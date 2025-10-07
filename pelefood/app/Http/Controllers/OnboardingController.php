<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\SubscriptionPlan;

class OnboardingController extends Controller
{
    /**
     * Afficher la page d'accueil d'onboarding
     */
    public function welcome()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurantForUser($user);
        
        // Si l'utilisateur a déjà un restaurant et un abonnement, rediriger vers le dashboard
        if ($restaurant && $restaurant->hasActiveSubscription()) {
            return redirect()->route('restaurant.dashboard')
                ->with('info', 'Votre onboarding est déjà terminé !');
        }
        
        return view('onboarding.welcome');
    }

    /**
     * Afficher la page de sélection de plan avec onboarding
     */
    public function selectPlan()
    {
        $plans = SubscriptionPlan::active()->get();
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurantForUser($user);
        
        // Vérifier si c'est un nouvel utilisateur (pas encore de restaurant)
        $isNewUser = !$restaurant;
        
        return view('subscription.select', compact('plans', 'isNewUser'));
    }

    /**
     * Afficher la page de création de restaurant avec onboarding
     */
    public function createRestaurant()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurantForUser($user);
        
        if ($restaurant) {
            return redirect()->route('restaurant.restaurants.edit', $restaurant)
                ->with('info', 'Votre restaurant est déjà configuré.');
        }

        return view('restaurant.restaurants.create');
    }

    /**
     * Afficher la page de configuration finale
     */
    public function finalize()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurantForUser($user);
        
        if (!$restaurant) {
            return redirect()->route('onboarding.create-restaurant')
                ->with('error', 'Vous devez d\'abord créer votre restaurant.');
        }
        
        if (!$restaurant->hasActiveSubscription()) {
            return redirect()->route('onboarding.select-plan')
                ->with('error', 'Vous devez d\'abord choisir un plan d\'abonnement.');
        }
        
        return view('onboarding.finalize', compact('restaurant'));
    }

    /**
     * Marquer l'onboarding comme terminé
     */
    public function complete()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurantForUser($user);
        
        if (!$restaurant || !$restaurant->hasActiveSubscription()) {
            return redirect()->route('onboarding.welcome')
                ->with('error', 'Veuillez compléter toutes les étapes d\'onboarding.');
        }
        
        // Marquer l'onboarding comme terminé (vous pouvez ajouter un champ dans la base de données)
        // $user->update(['onboarding_completed' => true]);
        
        return redirect()->route('restaurant.dashboard')
            ->with('success', 'Félicitations ! Votre restaurant est maintenant opérationnel. 🎉');
    }

    /**
     * Get the current restaurant for the user
     */
    private function getCurrentRestaurantForUser($user)
    {
        if ($user->hasRole('super_admin')) {
            return Restaurant::first();
        } else {
            if ($user->tenant) {
                return $user->tenant->restaurants->first();
            }
            return Restaurant::first();
        }
    }
} 