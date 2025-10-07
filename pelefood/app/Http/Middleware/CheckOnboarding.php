<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\SubscriptionPlan;

class CheckOnboarding
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if (!$user) {
            return $next($request);
        }

        // Les super_admin n'ont pas besoin d'onboarding
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // Vérifier si l'utilisateur a un restaurant
        $restaurant = $this->getCurrentRestaurant($user);
        
        // Si pas de restaurant, rediriger vers la création
        if (!$restaurant) {
            if ($request->routeIs('restaurant.restaurants.create') || 
                $request->routeIs('restaurant.restaurants.store') ||
                $request->routeIs('restaurant.subscription.*') ||
                $request->routeIs('onboarding.*')) {
                return $next($request);
            }
            
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        // Si pas d'abonnement actif, rediriger vers la sélection de plan
        if (!$restaurant->hasActiveSubscription()) {
            if ($request->routeIs('restaurant.subscription.*') || 
                $request->routeIs('restaurant.restaurants.*') ||
                $request->routeIs('onboarding.*')) {
                return $next($request);
            }
            
            // Rediriger vers la sélection des plans avec un message informatif
            return redirect()->route('restaurant.subscription.select')
                ->with('info', 'Bienvenue ! Pour commencer à utiliser PeleFood, veuillez choisir un plan d\'abonnement.');
        }

        return $next($request);
    }

    /**
     * Get the current restaurant for the user
     */
    private function getCurrentRestaurant($user)
    {
        if ($user->role === 'super_admin') {
            return Restaurant::first();
        } else {
            if ($user->tenant) {
                return $user->tenant->restaurants->first();
            }
            return Restaurant::first();
        }
    }
} 