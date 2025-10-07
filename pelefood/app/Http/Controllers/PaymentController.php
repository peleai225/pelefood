<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\SubscriptionPlan;
use App\Models\PaymentTransaction;
use App\Services\PaymentService;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Afficher la page de paiement
     */
    public function show(Request $request, $planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        $user = Auth::user();
        $restaurant = $user->tenant?->restaurants->first();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('error', 'Vous devez d\'abord créer un restaurant.');
        }

        return view('payment.show', compact('plan', 'restaurant'));
    }

    /**
     * Traiter le paiement
     */
    public function process(Request $request, $planId)
    {
        $request->validate([
            'payment_method' => 'required|string|in:card,mobile_money,bank_transfer,cash',
            'terms_accepted' => 'required|accepted',
            'provider' => 'nullable|string|in:wave,orange,mtn,stripe,paypal',
        ]);

        $plan = SubscriptionPlan::findOrFail($planId);
        $user = Auth::user();
        $restaurant = $user->tenant?->restaurants->first();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('error', 'Vous devez d\'abord créer un restaurant.');
        }

        // Utiliser le service de paiement
        $paymentService = new PaymentService();
        $paymentData = [
            'method' => $request->payment_method,
            'provider' => $request->provider,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
        ];

        $paymentResult = $paymentService->initializeSubscriptionPayment($plan, $restaurant, $paymentData);
        
        if ($paymentResult['success']) {
            // Calculer la date d'expiration
            $expiresAt = now();
            if ($plan->trial_days > 0) {
                $expiresAt = $expiresAt->addDays($plan->trial_days);
            } else {
                if ($plan->billing_cycle === 'monthly') {
                    $expiresAt = $expiresAt->addMonth();
                } elseif ($plan->billing_cycle === 'yearly') {
                    $expiresAt = $expiresAt->addYear();
                } else {
                    $expiresAt = $expiresAt->addDays(30);
                }
            }
            
            // Mettre à jour le restaurant
            $restaurant->update([
                'subscription_plan_id' => $plan->id,
                'subscription_status' => $plan->trial_days > 0 ? 'trial' : 'active',
                'subscription_expires_at' => $expiresAt,
            ]);

            $message = $plan->trial_days > 0 
                ? "Essai gratuit du plan '{$plan->name}' activé pour {$plan->trial_days} jours !"
                : "Paiement réussi ! Votre abonnement au plan '{$plan->name}' est maintenant actif.";

            return redirect()->route('restaurant.dashboard')
                ->with('success', $message);
        } else {
            return back()->with('error', $paymentResult['message']);
        }
    }

    /**
     * Simuler le traitement du paiement
     */
    private function simulatePayment(SubscriptionPlan $plan, string $paymentMethod)
    {
        // Simuler un délai de traitement
        sleep(2);
        
        // Simuler différents scénarios de paiement
        $scenarios = [
            'success' => 0.9, // 90% de succès
            'insufficient_funds' => 0.05, // 5% de fonds insuffisants
            'card_declined' => 0.03, // 3% de carte refusée
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
                            'transaction_id' => 'TXN_' . strtoupper(uniqid()),
                            'message' => 'Paiement traité avec succès'
                        ];
                    case 'insufficient_funds':
                        return [
                            'success' => false,
                            'message' => 'Fonds insuffisants. Veuillez vérifier votre solde.'
                        ];
                    case 'card_declined':
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
            'transaction_id' => 'TXN_' . strtoupper(uniqid()),
            'message' => 'Paiement traité avec succès'
        ];
    }

    /**
     * Afficher l'historique des paiements
     */
    public function history()
    {
        $user = Auth::user();
        $restaurant = $user->tenant?->restaurants->first();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('error', 'Vous devez d\'abord créer un restaurant.');
        }

        $payments = PaymentTransaction::where('tenant_id', $restaurant->tenant_id)
            ->with(['user'])
            ->latest()
            ->paginate(20);

        $stats = (new PaymentService())->getPaymentStats($restaurant, '30d');

        return view('payment.history', compact('payments', 'restaurant', 'stats'));
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function verify(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string'
        ]);

        $paymentService = new PaymentService();
        $result = $paymentService->verifyPayment($request->transaction_id);

        return response()->json($result);
    }

    /**
     * Rembourser un paiement
     */
    public function refund(Request $request, PaymentTransaction $transaction)
    {
        $request->validate([
            'amount' => 'nullable|numeric|min:0.01',
            'reason' => 'nullable|string|max:255'
        ]);

        $paymentService = new PaymentService();
        $result = $paymentService->refundPayment(
            $transaction, 
            $request->amount, 
            $request->reason
        );

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Afficher les détails d'une transaction
     */
    public function showTransaction(PaymentTransaction $transaction)
    {
        $user = Auth::user();
        $restaurant = $user->tenant?->restaurants->first();
        
        if (!$restaurant || $transaction->tenant_id !== $restaurant->tenant_id) {
            abort(403, 'Accès non autorisé');
        }

        return view('payment.show-transaction', compact('transaction', 'restaurant'));
    }
}