<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRestaurantOwner
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
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour accéder à cette section.');
        }
        
        $user = Auth::user();
        
        // Vérifier si l'utilisateur a un tenant
        if (!$user || !$user->tenant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('error', 'Vous devez d\'abord créer un restaurant pour accéder à cette section.');
        }
        
        // Vérifier si le tenant a au moins un restaurant
        if (!$user->tenant->restaurants()->exists()) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('error', 'Vous devez d\'abord créer un restaurant pour accéder à cette section.');
        }
        
        // Ajouter le restaurant à la requête pour éviter de le récupérer dans chaque contrôleur
        $restaurant = $user->tenant->restaurants->first();
        $request->merge(['current_restaurant' => $restaurant]);
        
        return $next($request);
    }
}
