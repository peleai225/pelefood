<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RestaurantDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.role:restaurant,admin,super_admin']);
    }

    public function index()
    {
        $user = Auth::user();
        
        // Si c'est un super_admin, prendre le premier restaurant disponible
        if ($user->hasRole('super_admin')) {
            $restaurant = Restaurant::first();
            if (!$restaurant) {
                return redirect()->route('restaurant.restaurants.create')
                    ->with('error', 'Aucun restaurant trouvé. Veuillez d\'abord créer un restaurant.');
            }
        } else {
            // Pour les utilisateurs restaurant, utiliser leur tenant
            $restaurant = $user->tenant?->restaurants->first();
            if (!$restaurant) {
                return redirect()->route('restaurant.restaurants.create')
                    ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
            }
        }

        // Vérifier si l'utilisateur a un abonnement actif
        if (!$restaurant->hasActiveSubscription()) {
            return redirect()->route('restaurant.subscription.select')
                ->with('info', 'Bienvenue ! Pour accéder à votre tableau de bord, veuillez choisir un plan d\'abonnement.');
        }

        // Utiliser le cache pour les statistiques
        $cacheKey = "restaurant_stats_{$restaurant->id}";
        $stats = Cache::remember($cacheKey, 300, function () use ($restaurant) {
            return [
                'total_orders' => $restaurant->orders()->count(),
                'total_revenue' => $restaurant->orders()->sum('total_amount'),
                'total_products' => $restaurant->products()->count(),
                'total_categories' => $restaurant->categories()->count(),
                'monthly_orders' => $restaurant->orders()->whereMonth('created_at', now()->month)->count(),
                'monthly_revenue' => $restaurant->orders()->whereMonth('created_at', now()->month)->sum('total_amount'),
                'pending_orders' => $restaurant->orders()->where('status', 'pending')->count(),
                'average_rating' => $restaurant->reviews()->where('is_approved', true)->avg('rating') ?? 0,
            ];
        });

        // Statistiques récentes (pas de cache pour les données en temps réel)
        $recentStats = [
            'today_orders' => $restaurant->orders()->whereDate('created_at', today())->count(),
            'today_revenue' => $restaurant->orders()->whereDate('created_at', today())->sum('total_amount'),
            'week_orders' => $restaurant->orders()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'week_revenue' => $restaurant->orders()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount'),
        ];

        // Commandes par statut avec cache
        $ordersByStatusCacheKey = "orders_by_status_{$restaurant->id}";
        $ordersByStatus = Cache::remember($ordersByStatusCacheKey, 60, function () use ($restaurant) {
            return $restaurant->orders()
                ->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
        });

        // Commandes récentes (limitées et optimisées)
        $recentOrders = $restaurant->orders()
            ->with(['items'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Produits populaires avec cache
        $popularProductsCacheKey = "popular_products_{$restaurant->id}";
        $popularProducts = Cache::remember($popularProductsCacheKey, 600, function () use ($restaurant) {
            return $restaurant->products()
                ->with('category')
                ->where('is_popular', true)
                ->limit(6)
                ->get();
        });

        // Graphique des commandes par jour (7 derniers jours) avec cache
        $ordersByDayCacheKey = "orders_by_day_{$restaurant->id}";
        $ordersByDay = Cache::remember($ordersByDayCacheKey, 300, function () use ($restaurant) {
            $ordersByDay = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $ordersByDay[] = [
                    'date' => $date->format('d/m'),
                    'count' => $restaurant->orders()
                        ->whereDate('created_at', $date)
                        ->count(),
                    'revenue' => $restaurant->orders()
                        ->whereDate('created_at', $date)
                        ->sum('total_amount'),
                ];
            }
            return $ordersByDay;
        });

        // Avis récents avec cache
        $recentReviewsCacheKey = "recent_reviews_{$restaurant->id}";
        $recentReviews = Cache::remember($recentReviewsCacheKey, 300, function () use ($restaurant) {
            return $restaurant->reviews()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        });

        // Produits en rupture de stock avec cache
        $outOfStockProductsCacheKey = "out_of_stock_{$restaurant->id}";
        $outOfStockProducts = Cache::remember($outOfStockProductsCacheKey, 60, function () use ($restaurant) {
            return $restaurant->products()
                ->where('has_stock_management', true)
                ->where('stock_quantity', '<=', 0)
                ->limit(5)
                ->get();
        });

        return view('restaurant.dashboard', compact(
            'restaurant',
            'stats',
            'recentStats',
            'ordersByStatus',
            'recentOrders',
            'popularProducts',
            'ordersByDay',
            'recentReviews',
            'outOfStockProducts'
        ));
    }
}
