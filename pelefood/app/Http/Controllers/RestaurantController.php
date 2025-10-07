<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    /**
     * Afficher la page d'accueil du restaurant
     */
    public function show($slug)
    {
        // Récupérer le restaurant par son slug
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        
        // Récupérer les catégories et produits du restaurant
        $categories = $restaurant->categories;
        $products = $restaurant->products;
        
        return view('restaurant.public.home', compact('restaurant', 'categories', 'products'));
    }
    
    /**
     * Afficher la page de commande
     */
    public function checkout($slug)
    {
        // Récupérer le restaurant par son slug
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        
        return view('restaurant.public.checkout', compact('restaurant'));
    }
}
