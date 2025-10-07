<?php

namespace App\Services;

use App\Models\PaymentTransaction;
use App\Models\PaymentGateway;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\SubscriptionPlan;
use App\Services\WalletService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentService
{
    protected $gateway;
    protected $restaurant;

    public function __construct(PaymentGateway $gateway = null, Restaurant $restaurant = null)
    {
        $this->gateway = $gateway;
        $this->restaurant = $restaurant;
    }

    /**
     * Initialiser un paiement pour une commande
     */
    public function initializeOrderPayment(Order $order, array $paymentData)
    {
        try {
            // Créer une transaction de paiement
            $transaction = PaymentTransaction::create([
                'user_id' => $order->user_id,
                'tenant_id' => $order->restaurant->tenant_id,
                'amount' => $order->total_amount,
                'currency' => $order->currency ?? 'XOF',
                'payment_method' => $paymentData['method'],
                'status' => 'pending',
                'transaction_id' => $this->generateTransactionId(),
                'description' => "Paiement commande #{$order->order_number}",
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'restaurant_id' => $order->restaurant_id,
                    'customer_name' => $order->customer_name,
                    'customer_phone' => $order->customer_phone,
                    'customer_email' => $order->customer_email,
                ],
            ]);

            // Traiter le paiement selon la méthode
            $result = $this->processPayment($transaction, $paymentData);

            if ($result['success']) {
                $transaction->markAsSuccessful();
                $transaction->update([
                    'gateway_transaction_id' => $result['gateway_transaction_id'] ?? null,
                    'commission' => $this->calculateCommission($transaction),
                    'commission_rate' => $this->getCommissionRate(),
                ]);

                // Mettre à jour le statut de la commande
                $order->update(['status' => 'confirmed']);

                // Créditer le portefeuille du restaurant
                $walletService = new WalletService();
                $walletResult = $walletService->processPayment($order, $transaction);

                return [
                    'success' => true,
                    'transaction' => $transaction,
                    'wallet_result' => $walletResult,
                    'message' => 'Paiement traité avec succès'
                ];
            } else {
                $transaction->markAsFailed();
                return [
                    'success' => false,
                    'transaction' => $transaction,
                    'message' => $result['message']
                ];
            }

        } catch (Exception $e) {
            Log::error('Erreur paiement commande', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors du traitement du paiement'
            ];
        }
    }

    /**
     * Initialiser un paiement pour un abonnement
     */
    public function initializeSubscriptionPayment(SubscriptionPlan $plan, Restaurant $restaurant, array $paymentData)
    {
        try {
            $amount = $plan->price;
            if ($plan->trial_days > 0) {
                $amount = 0; // Essai gratuit
            }

            $transaction = PaymentTransaction::create([
                'user_id' => $restaurant->user_id,
                'tenant_id' => $restaurant->tenant_id,
                'amount' => $amount,
                'currency' => 'XOF',
                'payment_method' => $paymentData['method'],
                'status' => 'pending',
                'transaction_id' => $this->generateTransactionId(),
                'description' => "Abonnement {$plan->name}",
                'metadata' => [
                    'subscription_plan_id' => $plan->id,
                    'restaurant_id' => $restaurant->id,
                    'billing_cycle' => $plan->billing_cycle,
                    'trial_days' => $plan->trial_days,
                ],
            ]);

            $result = $this->processPayment($transaction, $paymentData);

            if ($result['success']) {
                $transaction->markAsSuccessful();
                $transaction->update([
                    'gateway_transaction_id' => $result['gateway_transaction_id'] ?? null,
                    'commission' => $this->calculateCommission($transaction),
                    'commission_rate' => $this->getCommissionRate(),
                ]);

                return [
                    'success' => true,
                    'transaction' => $transaction,
                    'message' => 'Paiement d\'abonnement traité avec succès'
                ];
            } else {
                $transaction->markAsFailed();
                return [
                    'success' => false,
                    'transaction' => $transaction,
                    'message' => $result['message']
                ];
            }

        } catch (Exception $e) {
            Log::error('Erreur paiement abonnement', [
                'plan_id' => $plan->id,
                'restaurant_id' => $restaurant->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors du traitement du paiement d\'abonnement'
            ];
        }
    }

    /**
     * Traiter le paiement selon la méthode
     */
    protected function processPayment(PaymentTransaction $transaction, array $paymentData)
    {
        $method = $paymentData['method'];

        switch ($method) {
            case 'mobile_money':
                return $this->processMobileMoneyPayment($transaction, $paymentData);
            case 'card':
                return $this->processCardPayment($transaction, $paymentData);
            case 'bank_transfer':
                return $this->processBankTransferPayment($transaction, $paymentData);
            case 'cash':
                return $this->processCashPayment($transaction, $paymentData);
            default:
                return [
                    'success' => false,
                    'message' => 'Méthode de paiement non supportée'
                ];
        }
    }

    /**
     * Paiement Mobile Money (Wave, Orange Money, MTN Money)
     */
    protected function processMobileMoneyPayment(PaymentTransaction $transaction, array $paymentData)
    {
        // Simulation pour le développement
        if (app()->environment('local', 'testing')) {
            return $this->simulatePayment($transaction, 'mobile_money');
        }

        // Intégration réelle avec les APIs de paiement mobile
        try {
            $provider = $paymentData['provider'] ?? 'wave';
            
            switch ($provider) {
                case 'wave':
                    return $this->processWavePayment($transaction, $paymentData);
                case 'orange':
                    return $this->processOrangeMoneyPayment($transaction, $paymentData);
                case 'mtn':
                    return $this->processMTNMoneyPayment($transaction, $paymentData);
                default:
                    return $this->simulatePayment($transaction, 'mobile_money');
            }
        } catch (Exception $e) {
            Log::error('Erreur paiement mobile money', [
                'transaction_id' => $transaction->transaction_id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors du paiement mobile money'
            ];
        }
    }

    /**
     * Paiement par carte bancaire
     */
    protected function processCardPayment(PaymentTransaction $transaction, array $paymentData)
    {
        // Simulation pour le développement
        if (app()->environment('local', 'testing')) {
            return $this->simulatePayment($transaction, 'card');
        }

        // Intégration avec Stripe, PayPal, etc.
        try {
            // TODO: Implémenter l'intégration Stripe
            return $this->simulatePayment($transaction, 'card');
        } catch (Exception $e) {
            Log::error('Erreur paiement carte', [
                'transaction_id' => $transaction->transaction_id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors du paiement par carte'
            ];
        }
    }

    /**
     * Virement bancaire
     */
    protected function processBankTransferPayment(PaymentTransaction $transaction, array $paymentData)
    {
        // Pour les virements, on marque comme en attente
        return [
            'success' => true,
            'gateway_transaction_id' => 'BANK_' . $transaction->transaction_id,
            'message' => 'Virement en attente de confirmation'
        ];
    }

    /**
     * Paiement en espèces
     */
    protected function processCashPayment(PaymentTransaction $transaction, array $paymentData)
    {
        return [
            'success' => true,
            'gateway_transaction_id' => 'CASH_' . $transaction->transaction_id,
            'message' => 'Paiement en espèces confirmé'
        ];
    }

    /**
     * Simulation de paiement pour le développement
     */
    protected function simulatePayment(PaymentTransaction $transaction, string $method)
    {
        // Simuler un délai
        usleep(500000); // 0.5 seconde

        $scenarios = [
            'success' => 0.85, // 85% de succès
            'insufficient_funds' => 0.08, // 8% de fonds insuffisants
            'declined' => 0.05, // 5% de refus
            'network_error' => 0.02, // 2% d'erreur réseau
        ];

        $random = mt_rand() / mt_getrandmax();
        $cumulative = 0;

        foreach ($scenarios as $scenario => $probability) {
            $cumulative += $probability;
            if ($random <= $cumulative) {
                switch ($scenario) {
                    case 'success':
                        return [
                            'success' => true,
                            'gateway_transaction_id' => strtoupper($method) . '_' . $transaction->transaction_id,
                            'message' => 'Paiement traité avec succès'
                        ];
                    case 'insufficient_funds':
                        return [
                            'success' => false,
                            'message' => 'Fonds insuffisants. Veuillez vérifier votre solde.'
                        ];
                    case 'declined':
                        return [
                            'success' => false,
                            'message' => 'Paiement refusé. Veuillez contacter votre banque.'
                        ];
                    case 'network_error':
                        return [
                            'success' => false,
                            'message' => 'Erreur de connexion. Veuillez réessayer.'
                        ];
                }
            }
        }

        return [
            'success' => true,
            'gateway_transaction_id' => strtoupper($method) . '_' . $transaction->transaction_id,
            'message' => 'Paiement traité avec succès'
        ];
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function verifyPayment(string $transactionId)
    {
        $transaction = PaymentTransaction::where('transaction_id', $transactionId)->first();

        if (!$transaction) {
            return [
                'success' => false,
                'message' => 'Transaction non trouvée'
            ];
        }

        // TODO: Vérifier avec la passerelle de paiement réelle
        return [
            'success' => true,
            'transaction' => $transaction,
            'status' => $transaction->status
        ];
    }

    /**
     * Rembourser un paiement
     */
    public function refundPayment(PaymentTransaction $transaction, float $amount = null, string $reason = null)
    {
        if (!$transaction->is_refundable) {
            return [
                'success' => false,
                'message' => 'Cette transaction ne peut pas être remboursée'
            ];
        }

        try {
            $refundAmount = $amount ?? $transaction->amount;
            $transaction->refund($refundAmount, $reason);

            return [
                'success' => true,
                'message' => 'Remboursement effectué avec succès',
                'refund_amount' => $refundAmount
            ];
        } catch (Exception $e) {
            Log::error('Erreur remboursement', [
                'transaction_id' => $transaction->transaction_id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors du remboursement'
            ];
        }
    }

    /**
     * Générer un ID de transaction unique
     */
    protected function generateTransactionId(): string
    {
        return 'TXN_' . date('Ymd') . '_' . strtoupper(substr(md5(uniqid()), 0, 8));
    }

    /**
     * Calculer la commission
     */
    protected function calculateCommission(PaymentTransaction $transaction): float
    {
        $rate = $this->getCommissionRate();
        return $transaction->amount * $rate;
    }

    /**
     * Obtenir le taux de commission
     */
    protected function getCommissionRate(): float
    {
        // Commission de base de 3%
        return 0.03;
    }

    /**
     * Obtenir les statistiques de paiement
     */
    public function getPaymentStats(Restaurant $restaurant = null, $period = '30d')
    {
        $query = PaymentTransaction::query();

        if ($restaurant) {
            $query->where('tenant_id', $restaurant->tenant_id);
        }

        $startDate = now()->subDays(30);
        if ($period === '7d') {
            $startDate = now()->subDays(7);
        } elseif ($period === '90d') {
            $startDate = now()->subDays(90);
        }

        $query->where('created_at', '>=', $startDate);

        $stats = [
            'total_transactions' => $query->count(),
            'successful_transactions' => $query->clone()->successful()->count(),
            'failed_transactions' => $query->clone()->failed()->count(),
            'total_amount' => $query->clone()->successful()->sum('amount'),
            'total_commission' => $query->clone()->successful()->sum('commission'),
            'average_transaction' => $query->clone()->successful()->avg('amount'),
        ];

        return $stats;
    }
}