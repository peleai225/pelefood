<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionPlan;
use App\Models\Restaurant;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher la page de sélection des plans
     */
    public function select()
    {
        $plans = SubscriptionPlan::active()->get();
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();
        
        // Vérifier si c'est un nouvel utilisateur (pas encore de restaurant)
        $isNewUser = !$restaurant;
        
        return view('subscription.select', compact('plans', 'isNewUser', 'restaurant'));
    }

    /**
     * Afficher les détails d'un plan
     */
    public function show(SubscriptionPlan $plan)
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();

        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create');
        }

        return view('subscription.show', compact('plan', 'restaurant'));
    }

    /**
     * Souscrire à un plan d'abonnement
     */
    public function subscribe(Request $request, SubscriptionPlan $plan)
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();

        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create');
        }

        // Vérifier si l'utilisateur a déjà un abonnement actif
        if ($restaurant->hasActiveSubscription()) {
            return redirect()->route('restaurant.dashboard')
                ->with('error', 'Vous avez déjà un abonnement actif.');
        }

        // Calculer les dates d'abonnement selon le cycle de facturation
        $startDate = now();
        $endDate = $startDate->copy();
        
        if ($plan->billing_cycle === 'yearly') {
            $endDate->addYear();
        } else {
            $endDate->addMonth();
        }

        // Si le plan a une période d'essai, l'appliquer
        if ($plan->trial_days > 0) {
            $endDate = $startDate->copy()->addDays($plan->trial_days);
        }

        // Mettre à jour le restaurant avec le plan sélectionné
        $restaurant->update([
            'subscription_plan_id' => $plan->id,
            'subscription_started_at' => $startDate,
            'subscription_expires_at' => $endDate,
            'subscription_status' => 'pending', // En attente de paiement
            'subscription_amount' => $plan->price,
            'subscription_currency' => $plan->currency,
            'payment_status' => 'pending',
        ]);

        // Si le plan est gratuit, activer directement
        if ($plan->price == 0) {
            $restaurant->update([
                'subscription_status' => 'active',
                'payment_status' => 'completed',
            ]);

            return redirect()->route('restaurant.dashboard')
                ->with('success', "Votre abonnement au plan {$plan->name} a été activé avec succès !");
        }

        // Rediriger vers le paiement Wave
        return redirect()->route('restaurant.subscription.payment', $plan)
            ->with('success', "Plan {$plan->name} sélectionné. Procédez au paiement pour activer votre abonnement.");
    }

    /**
     * Afficher la page de paiement Wave
     */
    public function payment(SubscriptionPlan $plan)
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();

        if (!$restaurant || $restaurant->subscription_plan_id !== $plan->id) {
            return redirect()->route('restaurant.subscription.select');
        }

        // Vérifier que le statut est bien "pending"
        if ($restaurant->subscription_status !== 'pending') {
            return redirect()->route('restaurant.subscription.select');
        }

        return view('subscription.payment', compact('plan', 'restaurant'));
    }

    /**
     * Traiter le paiement Wave (appelé après paiement réussi)
     */
    public function processPayment(Request $request, SubscriptionPlan $plan)
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();

        if (!$restaurant || $restaurant->subscription_plan_id !== $plan->id) {
            return redirect()->route('restaurant.subscription.select');
        }

        // Vérifier que le statut est bien "pending"
        if ($restaurant->subscription_status !== 'pending') {
            return redirect()->route('restaurant.subscription.select');
        }

        // Activer l'abonnement après paiement réussi
        $restaurant->update([
            'subscription_status' => 'active',
            'payment_status' => 'completed',
            'payment_method' => 'wave',
            'payment_date' => now(),
        ]);

        return redirect()->route('restaurant.dashboard')
            ->with('success', "Paiement traité avec succès ! Votre abonnement au plan {$plan->name} est maintenant actif.");
    }

    /**
     * Webhook pour recevoir les notifications de paiement Wave
     */
    public function webhook(Request $request)
    {
        // Log de la notification reçue
        \Log::info('Webhook Wave reçu', $request->all());

        // Ici, vous devriez vérifier la signature du webhook Wave
        // et traiter la notification selon le statut

        $paymentStatus = $request->input('status');
        $transactionId = $request->input('transaction_id');
        $amount = $request->input('amount');

        // Trouver le restaurant avec un paiement en attente
        $restaurant = Restaurant::where('payment_status', 'pending')
            ->where('subscription_status', 'pending')
            ->first();

        if ($restaurant && $paymentStatus === 'success') {
            // Activer l'abonnement
            $restaurant->update([
                'subscription_status' => 'active',
                'payment_status' => 'completed',
                'payment_method' => 'wave',
                'payment_date' => now(),
                'transaction_id' => $transactionId,
            ]);

            \Log::info('Abonnement activé via webhook Wave', [
                'restaurant_id' => $restaurant->id,
                'transaction_id' => $transactionId
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Afficher la page de gestion de l'abonnement
     */
    public function manage()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();

        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create');
        }

        return view('subscription.manage', compact('restaurant'));
    }

    /**
     * Annuler l'abonnement
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();

        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create');
        }

        $restaurant->update([
            'subscription_status' => 'cancelled',
        ]);

        return redirect()->route('restaurant.subscription.manage')
            ->with('success', 'Votre abonnement a été annulé. Il restera actif jusqu\'à la fin de la période payée.');
    }

    /**
     * Renouveler l'abonnement
     */
    public function renew()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();

        if (!$restaurant || !$restaurant->subscriptionPlan) {
            return redirect()->route('restaurant.subscription.select');
        }

        // Rediriger vers la sélection de plan pour le renouvellement
        return redirect()->route('restaurant.subscription.select')
            ->with('info', 'Veuillez sélectionner un plan pour renouveler votre abonnement.');
    }

    /**
     * Changer de plan
     */
    public function change(Request $request, SubscriptionPlan $newPlan)
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();

        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create');
        }

        // Mettre à jour le plan
        $restaurant->update([
            'subscription_plan_id' => $newPlan->id,
            'subscription_amount' => $newPlan->price,
            'subscription_currency' => $newPlan->currency,
        ]);

        return redirect()->route('restaurant.subscription.manage')
            ->with('success', "Votre plan a été changé vers {$newPlan->name} avec succès !");
    }

    /**
     * Obtenir le restaurant actuel de l'utilisateur
     */
    protected function getCurrentRestaurant()
    {
        $user = Auth::user();
        
        if ($user->hasRole('super_admin')) {
            $restaurant = Restaurant::first();
            if (!$restaurant) {
                return null;
            }
        } else {
            // Vérifier si l'utilisateur a un tenant avant d'accéder à ses restaurants
            if ($user->tenant) {
                $restaurant = $user->tenant->restaurants->first();
            } else {
                // Si pas de tenant, essayer de trouver un restaurant par défaut
                $restaurant = Restaurant::first();
            }
        }
        
        return $restaurant;
    }
} 