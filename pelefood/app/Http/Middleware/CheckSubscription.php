<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;

class CheckSubscription
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
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Les super_admin n'ont pas besoin d'abonnement
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // Si l'utilisateur est déjà sur une route de sélection d'abonnement, laisser passer
        if ($request->routeIs('restaurant.subscription.*')) {
            return $next($request);
        }

        // Vérifier si l'utilisateur a un restaurant
        $restaurant = $user->tenant?->restaurants->first();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        // Vérifier si le restaurant a un plan d'abonnement actif
        if (!$restaurant->subscription_plan_id) {
            return redirect()->route('restaurant.subscription.select')
                ->with('info', 'Pour accéder à toutes les fonctionnalités, veuillez choisir un plan d\'abonnement.');
        }

        // Vérifier si l'abonnement est actif (pas expiré)
        if ($restaurant->subscription_expires_at && $restaurant->subscription_expires_at->isPast()) {
            // Mettre à jour le statut de l'abonnement
            $restaurant->update(['subscription_status' => 'expired']);
            
            return redirect()->route('restaurant.subscription.select')
                ->with('warning', 'Votre abonnement a expiré. Veuillez le renouveler pour continuer à utiliser PeleFood.');
        }

        // Vérifier si l'abonnement est en essai et va bientôt expirer (7 jours avant)
        if ($restaurant->subscription_status === 'trial' && 
            $restaurant->subscription_expires_at && 
            $restaurant->subscription_expires_at->diffInDays(now()) <= 7) {
            
            $request->session()->flash('trial_warning', 
                "Votre essai gratuit se termine dans {$restaurant->subscription_expires_at->diffInDays(now())} jours. Pensez à choisir un plan d'abonnement !"
            );
        }

        return $next($request);
    }
} 