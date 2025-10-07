<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Récupérer le restaurant de l'utilisateur connecté
     */
    protected function getCurrentRestaurant()
    {
        $user = Auth::user();
        
        // Récupérer le restaurant selon le rôle de l'utilisateur
        if ($user->role === 'super_admin') {
            $restaurant = Restaurant::first();
        } else {
            $restaurant = $user->tenant?->restaurants->first();
        }
        
        if (!$restaurant) {
            return null;
        }
        
        return $restaurant;
    }

    public function index()
    {
        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        // Statistiques générales
        $stats = [
            'total_orders' => $restaurant->orders()->count(),
            'total_revenue' => $restaurant->orders()->where('status', 'delivered')->sum('total_amount'),
            'total_products' => $restaurant->products()->count(),
            'total_categories' => $restaurant->categories()->count(),
            'average_rating' => $restaurant->reviews()->avg('rating') ?? 0,
            'total_reviews' => $restaurant->reviews()->count(),
        ];

        // Statistiques récentes (ce mois)
        $startOfMonth = Carbon::now()->startOfMonth();
        $recentStats = [
            'new_orders' => $restaurant->orders()->where('created_at', '>=', $startOfMonth)->count(),
            'recent_revenue' => $restaurant->orders()->where('status', 'delivered')
                ->where('created_at', '>=', $startOfMonth)
                ->sum('total_amount'),
            'new_reviews' => $restaurant->reviews()->where('created_at', '>=', $startOfMonth)->count(),
        ];

        // Commandes des 7 derniers jours
        $ordersByDay = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = $restaurant->orders()
                ->whereDate('created_at', $date)
                ->count();
            
            $ordersByDay[] = [
                'date' => $date->format('d/m'),
                'count' => $count
            ];
        }

        // Commandes récentes
        $recentOrders = $restaurant->orders()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return (object) [
                    'order_number' => $order->order_number,
                    'customer_name' => $order->customer_name ?? 'Client anonyme',
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'created_at' => $order->created_at
                ];
            });

        // Commandes par statut
        $ordersByStatus = [
            'pending' => $restaurant->orders()->where('status', 'pending')->count(),
            'confirmed' => $restaurant->orders()->where('status', 'confirmed')->count(),
            'preparing' => $restaurant->orders()->where('status', 'preparing')->count(),
            'ready' => $restaurant->orders()->where('status', 'ready')->count(),
            'delivered' => $restaurant->orders()->where('status', 'delivered')->count(),
            'cancelled' => $restaurant->orders()->where('status', 'cancelled')->count(),
        ];

        // Produits populaires
        $popularProducts = $restaurant->products()
            ->withCount(['orderItems as order_items_count'])
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        // Avis récents
        $recentReviews = $restaurant->reviews()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($review) {
                return (object) [
                    'rating' => $review->rating,
                    'customer_name' => $review->customer_name ?? 'Client anonyme',
                    'comment' => $review->comment,
                    'created_at' => $review->created_at
                ];
            });

        // Produits en rupture de stock
        $outOfStockProducts = $restaurant->products()
            ->where('stock_quantity', '<=', 0)
            ->take(5)
            ->get();

        return view('restaurant.dashboard', compact(
            'restaurant',
            'stats',
            'recentStats',
            'ordersByDay',
            'recentOrders',
            'ordersByStatus',
            'popularProducts',
            'recentReviews',
            'outOfStockProducts'
        ));
    }
} 