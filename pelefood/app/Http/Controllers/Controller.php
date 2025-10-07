<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Get the current user's restaurant
     */
    protected function getCurrentRestaurant()
    {
        $user = Auth::user();
        
        // Utiliser hasRole() pour une vérification plus robuste
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
    
    /**
     * Get the current user's restaurant or redirect to create
     */
    protected function getCurrentRestaurantOrRedirect()
    {
        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant) {
            if (Auth::user()->hasRole('super_admin')) {
                return redirect()->route('restaurant.restaurants.create')
                    ->with('error', 'Aucun restaurant trouvé. Veuillez d\'abord créer un restaurant.');
            } else {
                return redirect()->route('restaurant.restaurants.create')
                    ->with('error', 'Vous devez d\'abord configurer votre restaurant.');
            }
        }
        
        return $restaurant;
    }
}
