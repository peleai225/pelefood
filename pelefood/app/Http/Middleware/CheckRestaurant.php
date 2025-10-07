<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;

class CheckRestaurant
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
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = Auth::user();

        // Les super_admin n'ont pas besoin de restaurant
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Vérifier si l'utilisateur a un restaurant
        $restaurant = null;
        
        if ($user->role === 'super_admin') {
            $restaurant = Restaurant::first();
        } elseif ($user->tenant) {
            $restaurant = $user->tenant->restaurants()->first();
        } else {
            $restaurant = $user->restaurant;
        }
        
        if (!$restaurant) {
            // Si l'utilisateur n'a pas de restaurant, rediriger vers la création
            if ($request->routeIs('restaurant.restaurants.create') || 
                $request->routeIs('restaurant.restaurants.store') ||
                $request->routeIs('restaurant.subscription.*') ||
                $request->routeIs('onboarding.*') ||
                $request->routeIs('create.restaurant') ||
                $request->routeIs('select.subscription')) {
                return $next($request);
            }
            
            // Pour les utilisateurs restaurant sans restaurant, rediriger vers la création
            if ($user->role === 'restaurant') {
                return redirect()->route('restaurant.restaurants.create')
                    ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
            }
            
            // Pour les autres rôles, refuser l'accès
            abort(403, 'Vous devez avoir un restaurant pour accéder à cette page.');
        }

        return $next($request);
    }
}