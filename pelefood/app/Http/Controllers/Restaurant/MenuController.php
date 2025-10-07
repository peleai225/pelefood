<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;

class MenuController extends Controller
{
    /**
     * Récupérer le restaurant de l'utilisateur connecté
     */
    protected function getCurrentRestaurant()
    {
        $user = Auth::user();
        
        \Log::info('MenuController@getCurrentRestaurant: Vérification du restaurant', [
            'user_id' => $user->id,
            'role' => $user->role,
            'tenant_id' => $user->tenant_id,
            'has_tenant' => $user->tenant ? 'yes' : 'no'
        ]);
        
        // Récupérer le restaurant selon le rôle de l'utilisateur
        if ($user->role === 'super_admin') {
            $restaurant = \App\Models\Restaurant::first();
            \Log::info('MenuController@getCurrentRestaurant: Super admin, restaurant trouvé', [
                'restaurant_id' => $restaurant ? $restaurant->id : 'null'
            ]);
        } else {
            if ($user->tenant) {
                $restaurant = $user->tenant->restaurants->first();
                \Log::info('MenuController@getCurrentRestaurant: Utilisateur normal, restaurant trouvé', [
                    'restaurant_id' => $restaurant ? $restaurant->id : 'null',
                    'tenant_restaurants_count' => $user->tenant->restaurants->count()
                ]);
            } else {
                \Log::info('MenuController@getCurrentRestaurant: Utilisateur sans tenant');
                $restaurant = null;
            }
        }
        
        if (!$restaurant) {
            \Log::info('MenuController@getCurrentRestaurant: Aucun restaurant trouvé');
            return null;
        }
        
        return $restaurant;
    }

    public function index()
    {
        $user = Auth::user();
        \Log::info('MenuController@index: Utilisateur connecté', [
            'user_id' => $user->id,
            'role' => $user->role,
            'tenant_id' => $user->tenant_id
        ]);

        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant) {
            \Log::info('MenuController@index: Aucun restaurant trouvé, redirection vers création');
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        \Log::info('MenuController@index: Restaurant trouvé', [
            'restaurant_id' => $restaurant->id,
            'restaurant_name' => $restaurant->name
        ]);

        // Récupérer les catégories et produits du restaurant
        $categories = $restaurant->categories()->with('products')->get();
        $products = $restaurant->products()->with('category')->get();

        \Log::info('MenuController@index: Données récupérées', [
            'categories_count' => $categories->count(),
            'products_count' => $products->count()
        ]);

        // Calculer les statistiques
        $stats = [
            'total_categories' => $categories->count(),
            'total_products' => $products->count(),
            'active_products' => $products->where('is_active', true)->count(),
            'featured_products' => $products->where('is_featured', true)->count(),
        ];

        return view('restaurant.menu.index', compact('categories', 'products', 'restaurant', 'stats'));
    }
}
