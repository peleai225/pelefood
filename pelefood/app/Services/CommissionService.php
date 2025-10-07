<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Models\Restaurant;
use App\Models\Tenant;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;

class CommissionService
{
    /**
     * Calculer la commission PeleFood sur une transaction
     */
    public function calculateCommission(Order $order, PaymentTransaction $transaction)
    {
        $restaurant = $order->restaurant;
        $tenant = $restaurant->tenant;
        $subscriptionPlan = $tenant->subscriptionPlan;

        // Commission de base selon le plan d'abonnement
        $baseCommission = $this->getBaseCommission($subscriptionPlan);
        
        // Commission variable selon le montant
        $variableCommission = $this->getVariableCommission($order->total_amount, $subscriptionPlan);
        
        // Commission fixe par transaction
        $fixedCommission = $this->getFixedCommission($subscriptionPlan);
        
        $totalCommission = $baseCommission + $variableCommission + $fixedCommission;
        
        return [
            'base_commission' => $baseCommission,
            'variable_commission' => $variableCommission,
            'fixed_commission' => $fixedCommission,
            'total_commission' => $totalCommission,
            'restaurant_amount' => $order->total_amount - $totalCommission,
            'commission_percentage' => ($totalCommission / $order->total_amount) * 100,
        ];
    }

    /**
     * Obtenir la commission de base selon le plan d'abonnement
     */
    private function getBaseCommission(SubscriptionPlan $subscriptionPlan)
    {
        $commissions = [
            'gratuit' => 0.05,      // 5% pour le plan gratuit
            'basique' => 0.03,      // 3% pour le plan basique
            'premium' => 0.02,      // 2% pour le plan premium
            'enterprise' => 0.01,   // 1% pour le plan enterprise
        ];

        $planSlug = $subscriptionPlan->slug ?? 'gratuit';
        return $commissions[$planSlug] ?? 0.05;
    }

    /**
     * Obtenir la commission variable selon le montant
     */
    private function getVariableCommission($amount, SubscriptionPlan $subscriptionPlan)
    {
        // Commission variable basée sur le montant de la commande
        if ($amount >= 10000) { // Commandes de 10 000+ XOF
            return $amount * 0.01; // +1% pour les grosses commandes
        }
        
        return 0;
    }

    /**
     * Obtenir la commission fixe par transaction
     */
    private function getFixedCommission(SubscriptionPlan $subscriptionPlan)
    {
        $fixedCommissions = [
            'gratuit' => 100,       // 100 XOF par transaction
            'basique' => 50,        // 50 XOF par transaction
            'premium' => 25,        // 25 XOF par transaction
            'enterprise' => 0,      // Pas de commission fixe
        ];

        $planSlug = $subscriptionPlan->slug ?? 'gratuit';
        return $fixedCommissions[$planSlug] ?? 100;
    }

    /**
     * Appliquer la commission à une transaction
     */
    public function applyCommission(PaymentTransaction $transaction)
    {
        $order = $transaction->order;
        $commission = $this->calculateCommission($order, $transaction);
        
        // Mettre à jour la transaction avec les détails de commission
        $transaction->update([
            'commission_amount' => $commission['total_commission'],
            'commission_details' => [
                'base_commission' => $commission['base_commission'],
                'variable_commission' => $commission['variable_commission'],
                'fixed_commission' => $commission['fixed_commission'],
                'commission_percentage' => $commission['commission_percentage'],
                'restaurant_amount' => $commission['restaurant_amount'],
            ],
        ]);

        return $commission;
    }

    /**
     * Obtenir les statistiques de commission pour un restaurant
     */
    public function getRestaurantCommissionStats($restaurantId, $period = 'month')
    {
        $query = PaymentTransaction::where('restaurant_id', $restaurantId)
            ->where('status', 'completed');

        // Filtrer par période
        switch ($period) {
            case 'week':
                $query->where('created_at', '>=', now()->subWeek());
                break;
            case 'month':
                $query->where('created_at', '>=', now()->subMonth());
                break;
            case 'year':
                $query->where('created_at', '>=', now()->subYear());
                break;
        }

        $transactions = $query->get();

        return [
            'total_transactions' => $transactions->count(),
            'total_amount' => $transactions->sum('amount'),
            'total_commission' => $transactions->sum('commission_amount'),
            'restaurant_revenue' => $transactions->sum('amount') - $transactions->sum('commission_amount'),
            'average_commission_rate' => $transactions->count() > 0 
                ? ($transactions->sum('commission_amount') / $transactions->sum('amount')) * 100 
                : 0,
        ];
    }

    /**
     * Obtenir les statistiques de commission pour PeleFood (tous restaurants)
     */
    public function getPlatformCommissionStats($period = 'month')
    {
        $query = PaymentTransaction::where('status', 'completed');

        // Filtrer par période
        switch ($period) {
            case 'week':
                $query->where('created_at', '>=', now()->subWeek());
                break;
            case 'month':
                $query->where('created_at', '>=', now()->subMonth());
                break;
            case 'year':
                $query->where('created_at', '>=', now()->subYear());
                break;
        }

        $transactions = $query->get();

        return [
            'total_transactions' => $transactions->count(),
            'total_amount' => $transactions->sum('amount'),
            'total_commission' => $transactions->sum('commission_amount'),
            'restaurants_revenue' => $transactions->sum('amount') - $transactions->sum('commission_amount'),
            'average_commission_rate' => $transactions->count() > 0 
                ? ($transactions->sum('commission_amount') / $transactions->sum('amount')) * 100 
                : 0,
        ];
    }

    /**
     * Générer un rapport de commission détaillé
     */
    public function generateCommissionReport($restaurantId = null, $startDate = null, $endDate = null)
    {
        $query = PaymentTransaction::with(['order.restaurant', 'paymentMethod'])
            ->where('status', 'completed');

        if ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        }

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $report = [
            'period' => [
                'start' => $startDate,
                'end' => $endDate,
            ],
            'summary' => [
                'total_transactions' => $transactions->count(),
                'total_amount' => $transactions->sum('amount'),
                'total_commission' => $transactions->sum('commission_amount'),
                'restaurants_revenue' => $transactions->sum('amount') - $transactions->sum('commission_amount'),
            ],
            'by_restaurant' => $transactions->groupBy('restaurant_id')->map(function ($restaurantTransactions) {
                return [
                    'restaurant_name' => $restaurantTransactions->first()->order->restaurant->name,
                    'transactions_count' => $restaurantTransactions->count(),
                    'total_amount' => $restaurantTransactions->sum('amount'),
                    'total_commission' => $restaurantTransactions->sum('commission_amount'),
                    'restaurant_revenue' => $restaurantTransactions->sum('amount') - $restaurantTransactions->sum('commission_amount'),
                ];
            }),
            'by_payment_method' => $transactions->groupBy('provider')->map(function ($methodTransactions) {
                return [
                    'provider' => $methodTransactions->first()->provider,
                    'transactions_count' => $methodTransactions->count(),
                    'total_amount' => $methodTransactions->sum('amount'),
                    'total_commission' => $methodTransactions->sum('commission_amount'),
                ];
            }),
            'transactions' => $transactions->map(function ($transaction) {
                return [
                    'transaction_id' => $transaction->transaction_id,
                    'restaurant_name' => $transaction->order->restaurant->name,
                    'order_number' => $transaction->order->order_number,
                    'amount' => $transaction->amount,
                    'commission_amount' => $transaction->commission_amount,
                    'restaurant_revenue' => $transaction->amount - $transaction->commission_amount,
                    'payment_method' => $transaction->provider,
                    'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
                ];
            }),
        ];

        return $report;
    }
} 