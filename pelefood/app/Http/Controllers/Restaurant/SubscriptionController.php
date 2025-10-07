<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function manage()
    {
        $restaurant = auth()->user()->restaurant;
        return view('subscription.manage', compact('restaurant'));
    }

    public function select()
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }
        
        // Récupérer tous les plans actifs, triés par prix
        $plans = \App\Models\SubscriptionPlan::active()
            ->ordered()
            ->get();
            
        $isNewUser = true; // Toujours considérer comme nouvel utilisateur pour l'onboarding
        return view('subscription.select', compact('plans', 'isNewUser'));
    }

    public function show($plan)
    {
        $plan = \App\Models\SubscriptionPlan::findOrFail($plan);
        return view('subscription.show', compact('plan'));
    }

    public function subscribe(Request $request, $plan)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $plan = \App\Models\SubscriptionPlan::findOrFail($plan);
        $user = Auth::user();
        
        // Vérifier que l'utilisateur a un restaurant
        $restaurant = $user->tenant?->restaurants->first();
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('error', 'Vous devez d\'abord créer un restaurant.');
        }
        
        // Si c'est un essai gratuit, activer directement
        if ($plan->trial_days > 0) {
            $expiresAt = now()->addDays($plan->trial_days);
            
            $restaurant->update([
                'subscription_plan_id' => $plan->id,
                'subscription_status' => 'trial',
                'subscription_expires_at' => $expiresAt,
            ]);
            
            return redirect()->route('restaurant.dashboard')
                ->with('success', "Essai gratuit du plan '{$plan->name}' activé pour {$plan->trial_days} jours !");
        }
        
        // Pour les plans payants, rediriger vers la page de paiement
        return redirect()->route('payment.show', $plan->id);
    }

    public function renew()
    {
        // Logique de renouvellement
        return back()->with('success', 'Abonnement renouvelé');
    }

    public function cancel()
    {
        // Logique d'annulation
        return back()->with('success', 'Abonnement annulé');
    }
} 