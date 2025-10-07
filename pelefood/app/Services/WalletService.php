<?php

namespace App\Services;

use App\Models\RestaurantWallet;
use App\Models\WithdrawalRequest;
use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class WalletService
{
    const COMMISSION_RATE = 0.02; // 2%
    const WITHDRAWAL_FEE = 500; // 500 FCFA
    const MIN_WITHDRAWAL = 1000; // 1000 FCFA minimum

    /**
     * Traiter un paiement et créditer le portefeuille
     */
    public function processPayment(Order $order, PaymentTransaction $transaction): array
    {
        try {
            DB::beginTransaction();

            // Récupérer ou créer le portefeuille du restaurant
            $wallet = RestaurantWallet::getOrCreate($order->restaurant_id);

            // Calculer la commission PeleFood (2%)
            $commission = $order->total_amount * self::COMMISSION_RATE;
            $restaurantAmount = $order->total_amount - $commission;

            // Créditer le portefeuille du restaurant
            $wallet->credit($restaurantAmount, "Paiement commande #{$order->order_number}");

            // Ajouter la commission au portefeuille
            $wallet->addCommission($commission);

            // Mettre à jour la transaction avec les détails de commission
            $transaction->update([
                'commission' => $commission,
                'commission_rate' => self::COMMISSION_RATE,
            ]);

            DB::commit();

            return [
                'success' => true,
                'restaurant_amount' => $restaurantAmount,
                'commission' => $commission,
                'wallet_balance' => $wallet->balance,
                'message' => 'Paiement traité et portefeuille crédité'
            ];

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erreur traitement paiement portefeuille', [
                'order_id' => $order->id,
                'restaurant_id' => $order->restaurant_id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors du traitement du paiement'
            ];
        }
    }

    /**
     * Créer une demande de retrait
     */
    public function createWithdrawalRequest(int $restaurantId, float $amount, array $bankDetails = []): array
    {
        try {
            $wallet = RestaurantWallet::where('restaurant_id', $restaurantId)->first();

            if (!$wallet) {
                return [
                    'success' => false,
                    'message' => 'Portefeuille non trouvé'
                ];
            }

            // Vérifier le montant minimum
            if ($amount < self::MIN_WITHDRAWAL) {
                return [
                    'success' => false,
                    'message' => "Le montant minimum de retrait est de " . number_format(self::MIN_WITHDRAWAL, 0, ',', ' ') . " FCFA"
                ];
            }

            // Vérifier le solde disponible
            if (!$wallet->canWithdraw($amount)) {
                return [
                    'success' => false,
                    'message' => 'Solde insuffisant pour ce retrait'
                ];
            }

            // Créer la demande de retrait
            $withdrawalRequest = WithdrawalRequest::createRequest($restaurantId, $amount, $bankDetails);

            // Bloquer le montant dans le portefeuille
            $wallet->addPending($amount);

            return [
                'success' => true,
                'withdrawal_request' => $withdrawalRequest,
                'message' => 'Demande de retrait créée avec succès'
            ];

        } catch (Exception $e) {
            Log::error('Erreur création demande retrait', [
                'restaurant_id' => $restaurantId,
                'amount' => $amount,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors de la création de la demande de retrait'
            ];
        }
    }

    /**
     * Approuver une demande de retrait
     */
    public function approveWithdrawal(WithdrawalRequest $withdrawalRequest, int $adminId, string $notes = null): array
    {
        try {
            if (!$withdrawalRequest->can_be_approved) {
                return [
                    'success' => false,
                    'message' => 'Cette demande ne peut pas être approuvée'
                ];
            }

            $withdrawalRequest->approve(User::find($adminId), $notes);

            return [
                'success' => true,
                'message' => 'Demande de retrait approuvée'
            ];

        } catch (Exception $e) {
            Log::error('Erreur approbation retrait', [
                'withdrawal_request_id' => $withdrawalRequest->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors de l\'approbation'
            ];
        }
    }

    /**
     * Rejeter une demande de retrait
     */
    public function rejectWithdrawal(WithdrawalRequest $withdrawalRequest, int $adminId, string $reason, string $notes = null): array
    {
        try {
            if (!$withdrawalRequest->can_be_rejected) {
                return [
                    'success' => false,
                    'message' => 'Cette demande ne peut pas être rejetée'
                ];
            }

            $withdrawalRequest->reject(User::find($adminId), $reason, $notes);

            // Libérer le montant bloqué
            $wallet = RestaurantWallet::where('restaurant_id', $withdrawalRequest->restaurant_id)->first();
            if ($wallet) {
                $wallet->removePending($withdrawalRequest->amount);
            }

            return [
                'success' => true,
                'message' => 'Demande de retrait rejetée'
            ];

        } catch (Exception $e) {
            Log::error('Erreur rejet retrait', [
                'withdrawal_request_id' => $withdrawalRequest->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors du rejet'
            ];
        }
    }

    /**
     * Traiter un retrait (après transfert effectif)
     */
    public function processWithdrawal(WithdrawalRequest $withdrawalRequest, int $adminId, string $notes = null): array
    {
        try {
            if (!$withdrawalRequest->can_be_processed) {
                return [
                    'success' => false,
                    'message' => 'Cette demande ne peut pas être traitée'
                ];
            }

            DB::beginTransaction();

            // Marquer comme traité
            $withdrawalRequest->process(User::find($adminId), $notes);

            // Débiter le portefeuille
            $wallet = RestaurantWallet::where('restaurant_id', $withdrawalRequest->restaurant_id)->first();
            if ($wallet) {
                $wallet->debit($withdrawalRequest->amount, "Retrait #{$withdrawalRequest->request_number}");
                $wallet->increment('total_withdrawals', $withdrawalRequest->amount);
                $wallet->removePending($withdrawalRequest->amount);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Retrait traité avec succès'
            ];

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erreur traitement retrait', [
                'withdrawal_request_id' => $withdrawalRequest->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors du traitement du retrait'
            ];
        }
    }

    /**
     * Obtenir les statistiques d'un portefeuille
     */
    public function getWalletStats(int $restaurantId): array
    {
        $wallet = RestaurantWallet::where('restaurant_id', $restaurantId)->first();

        if (!$wallet) {
            return [
                'balance' => 0,
                'total_earnings' => 0,
                'total_withdrawals' => 0,
                'total_commission' => 0,
                'pending_withdrawals' => 0,
            ];
        }

        $pendingWithdrawals = WithdrawalRequest::where('restaurant_id', $restaurantId)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('amount');

        return [
            'balance' => $wallet->balance,
            'available_balance' => $wallet->available_balance,
            'total_earnings' => $wallet->total_earnings,
            'total_withdrawals' => $wallet->total_withdrawals,
            'total_commission' => $wallet->total_commission,
            'pending_withdrawals' => $pendingWithdrawals,
            'formatted_balance' => $wallet->formatted_balance,
            'formatted_available_balance' => $wallet->formatted_available_balance,
        ];
    }

    /**
     * Obtenir les statistiques globales (Super Admin)
     */
    public function getGlobalStats(): array
    {
        $totalWallets = RestaurantWallet::active()->count();
        $totalBalance = RestaurantWallet::active()->sum('balance');
        $totalEarnings = RestaurantWallet::active()->sum('total_earnings');
        $totalWithdrawals = RestaurantWallet::active()->sum('total_withdrawals');
        $totalCommission = RestaurantWallet::active()->sum('total_commission');

        $pendingRequests = WithdrawalRequest::pending()->count();
        $pendingAmount = WithdrawalRequest::pending()->sum('amount');

        return [
            'total_wallets' => $totalWallets,
            'total_balance' => $totalBalance,
            'total_earnings' => $totalEarnings,
            'total_withdrawals' => $totalWithdrawals,
            'total_commission' => $totalCommission,
            'pending_requests' => $pendingRequests,
            'pending_amount' => $pendingAmount,
            'formatted_total_balance' => number_format($totalBalance, 0, ',', ' ') . ' FCFA',
            'formatted_total_commission' => number_format($totalCommission, 0, ',', ' ') . ' FCFA',
        ];
    }

    /**
     * Calculer la commission pour un montant
     */
    public function calculateCommission(float $amount): array
    {
        $commission = $amount * self::COMMISSION_RATE;
        $restaurantAmount = $amount - $commission;

        return [
            'original_amount' => $amount,
            'commission_rate' => self::COMMISSION_RATE,
            'commission' => $commission,
            'restaurant_amount' => $restaurantAmount,
            'formatted_original_amount' => number_format($amount, 0, ',', ' ') . ' FCFA',
            'formatted_commission' => number_format($commission, 0, ',', ' ') . ' FCFA',
            'formatted_restaurant_amount' => number_format($restaurantAmount, 0, ',', ' ') . ' FCFA',
        ];
    }
}
