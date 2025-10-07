<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Initialiser un paiement
     */
    public function initialize(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|in:XOF',
            'order_number' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'gateway' => 'required|string|exists:payment_gateways,code'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $gateway = PaymentGateway::where('code', $request->gateway)
                ->where('is_active', true)
                ->first();

            if (!$gateway) {
                return response()->json([
                    'success' => false,
                    'message' => 'Passerelle de paiement non disponible'
                ], 400);
            }

            // Calculer les frais
            $fees = $this->calculateFees($request->amount, $gateway);
            $totalAmount = $request->amount + $fees;

            // Créer la transaction
            $transaction = PaymentTransaction::create([
                'transaction_id' => $this->generateTransactionId(),
                'order_number' => $request->order_number,
                'gateway_code' => $gateway->code,
                'amount' => $request->amount,
                'fees' => $fees,
                'total_amount' => $totalAmount,
                'currency' => $request->currency,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'status' => 'pending',
                'gateway_response' => null,
                'callback_url' => $request->callback_url,
                'return_url' => $request->return_url
            ]);

            // Initialiser le paiement selon la passerelle
            $paymentData = $this->initializeGatewayPayment($transaction, $gateway);

            return response()->json([
                'success' => true,
                'message' => 'Paiement initialisé avec succès',
                'data' => [
                    'transaction_id' => $transaction->transaction_id,
                    'amount' => $totalAmount,
                    'currency' => $request->currency,
                    'gateway' => $gateway->code,
                    'gateway_name' => $gateway->name,
                    'payment_url' => $paymentData['payment_url'] ?? null,
                    'payment_data' => $paymentData['payment_data'] ?? null,
                    'expires_at' => now()->addMinutes(30)->toISOString()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'initialisation du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vérifier un paiement
     */
    public function verify(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|string',
            'gateway_reference' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $transaction = PaymentTransaction::where('transaction_id', $request->transaction_id)
                ->first();

            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction non trouvée'
                ], 404);
            }

            // Vérifier le paiement selon la passerelle
            $verificationResult = $this->verifyGatewayPayment($transaction, $request->gateway_reference);

            if ($verificationResult['success']) {
                $transaction->update([
                    'status' => 'completed',
                    'gateway_reference' => $request->gateway_reference,
                    'gateway_response' => json_encode($verificationResult['response']),
                    'completed_at' => now()
                ]);

                // Mettre à jour le statut de la commande
                $this->updateOrderStatus($transaction->order_number, 'confirmed');
            } else {
                $transaction->update([
                    'status' => 'failed',
                    'gateway_reference' => $request->gateway_reference,
                    'gateway_response' => json_encode($verificationResult['response']),
                    'failed_at' => now()
                ]);
            }

            return response()->json([
                'success' => $verificationResult['success'],
                'message' => $verificationResult['message'],
                'data' => [
                    'transaction_id' => $transaction->transaction_id,
                    'status' => $transaction->status,
                    'amount' => $transaction->total_amount,
                    'currency' => $transaction->currency,
                    'order_number' => $transaction->order_number
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la vérification du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les passerelles de paiement disponibles
     */
    public function gateways(): JsonResponse
    {
        $gateways = PaymentGateway::where('is_active', true)
            ->select(['code', 'name', 'description', 'fees_type', 'fees_value', 'supported_currencies', 'logo_url'])
            ->get()
            ->map(function($gateway) {
                return [
                    'code' => $gateway->code,
                    'name' => $gateway->name,
                    'description' => $gateway->description,
                    'fees_type' => $gateway->fees_type,
                    'fees_value' => $gateway->fees_value,
                    'supported_currencies' => json_decode($gateway->supported_currencies, true),
                    'logo_url' => $gateway->logo_url
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $gateways
        ]);
    }

    /**
     * Calculer les frais de paiement
     */
    private function calculateFees(float $amount, PaymentGateway $gateway): float
    {
        if ($gateway->fees_type === 'percentage') {
            return ($amount * $gateway->fees_value) / 100;
        } elseif ($gateway->fees_type === 'fixed') {
            return $gateway->fees_value;
        }

        return 0;
    }

    /**
     * Générer un ID de transaction unique
     */
    private function generateTransactionId(): string
    {
        do {
            $transactionId = 'TXN' . date('YmdHis') . rand(100, 999);
        } while (PaymentTransaction::where('transaction_id', $transactionId)->exists());

        return $transactionId;
    }

    /**
     * Initialiser le paiement selon la passerelle
     */
    private function initializeGatewayPayment(PaymentTransaction $transaction, PaymentGateway $gateway): array
    {
        switch ($gateway->code) {
            case 'wave':
                return $this->initializeWavePayment($transaction);
            case 'paystack':
                return $this->initializePaystackPayment($transaction);
            case 'flutterwave':
                return $this->initializeFlutterwavePayment($transaction);
            default:
                throw new \Exception('Passerelle de paiement non supportée');
        }
    }

    /**
     * Vérifier le paiement selon la passerelle
     */
    private function verifyGatewayPayment(PaymentTransaction $transaction, string $gatewayReference): array
    {
        switch ($transaction->gateway_code) {
            case 'wave':
                return $this->verifyWavePayment($transaction, $gatewayReference);
            case 'paystack':
                return $this->verifyPaystackPayment($transaction, $gatewayReference);
            case 'flutterwave':
                return $this->verifyFlutterwavePayment($transaction, $gatewayReference);
            default:
                return [
                    'success' => false,
                    'message' => 'Passerelle de paiement non supportée',
                    'response' => []
                ];
        }
    }

    /**
     * Initialiser un paiement Wave
     */
    private function initializeWavePayment(PaymentTransaction $transaction): array
    {
        // Implémentation Wave
        return [
            'payment_url' => 'https://wave.com/pay/' . $transaction->transaction_id,
            'payment_data' => [
                'transaction_id' => $transaction->transaction_id,
                'amount' => $transaction->total_amount,
                'currency' => $transaction->currency
            ]
        ];
    }

    /**
     * Initialiser un paiement Paystack
     */
    private function initializePaystackPayment(PaymentTransaction $transaction): array
    {
        // Implémentation Paystack
        return [
            'payment_url' => 'https://paystack.com/pay/' . $transaction->transaction_id,
            'payment_data' => [
                'transaction_id' => $transaction->transaction_id,
                'amount' => $transaction->total_amount,
                'currency' => $transaction->currency
            ]
        ];
    }

    /**
     * Initialiser un paiement Flutterwave
     */
    private function initializeFlutterwavePayment(PaymentTransaction $transaction): array
    {
        // Implémentation Flutterwave
        return [
            'payment_url' => 'https://flutterwave.com/pay/' . $transaction->transaction_id,
            'payment_data' => [
                'transaction_id' => $transaction->transaction_id,
                'amount' => $transaction->total_amount,
                'currency' => $transaction->currency
            ]
        ];
    }

    /**
     * Vérifier un paiement Wave
     */
    private function verifyWavePayment(PaymentTransaction $transaction, string $reference): array
    {
        // Simulation de vérification Wave
        return [
            'success' => true,
            'message' => 'Paiement confirmé',
            'response' => ['reference' => $reference, 'status' => 'success']
        ];
    }

    /**
     * Vérifier un paiement Paystack
     */
    private function verifyPaystackPayment(PaymentTransaction $transaction, string $reference): array
    {
        // Simulation de vérification Paystack
        return [
            'success' => true,
            'message' => 'Paiement confirmé',
            'response' => ['reference' => $reference, 'status' => 'success']
        ];
    }

    /**
     * Vérifier un paiement Flutterwave
     */
    private function verifyFlutterwavePayment(PaymentTransaction $transaction, string $reference): array
    {
        // Simulation de vérification Flutterwave
        return [
            'success' => true,
            'message' => 'Paiement confirmé',
            'response' => ['reference' => $reference, 'status' => 'success']
        ];
    }

    /**
     * Mettre à jour le statut de la commande
     */
    private function updateOrderStatus(string $orderNumber, string $status): void
    {
        \App\Models\Order::where('order_number', $orderNumber)
            ->update(['status' => $status]);
    }
}

