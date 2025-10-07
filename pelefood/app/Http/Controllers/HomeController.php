<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil optimisée
     */
    public function index()
    {
        // Cache les statistiques pour améliorer les performances
        $stats = Cache::remember('home_stats', 300, function () {
            return [
                'total_restaurants' => Restaurant::where('is_active', true)->count(),
                'total_orders' => Order::where('status', 'completed')->count(),
                'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount') ?? 0,
            ];
        });

        // Cache les restaurants populaires
        $popular_restaurants = Cache::remember('popular_restaurants', 600, function () {
            return Restaurant::where('is_active', true)
                ->withCount('orders')
                ->orderBy('orders_count', 'desc')
                ->limit(6)
                ->get(['id', 'name', 'slug', 'city', 'description']);
        });

        return view('landing.home', compact('stats', 'popular_restaurants'));
    }
}
