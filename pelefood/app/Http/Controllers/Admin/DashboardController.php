<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_tenants' => Tenant::count(),
            'active_tenants' => Tenant::where('status', 'active')->count(),
            'total_restaurants' => Restaurant::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_revenue' => Order::sum('total_amount') ?? 0,
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
        ];

        // Commandes par mois (12 derniers mois)
        $ordersByMonth = $this->getOrdersByMonth();
        
        // Commandes par statut
        $ordersByStatus = $this->getOrdersByStatus();
        
        // Restaurants par ville
        $restaurantsByCity = $this->getRestaurantsByCity();
        
        // Commandes récentes
        $recentOrders = Order::with(['restaurant', 'user'])
            ->latest()
            ->limit(10)
            ->get();
            
        // Tenants récents
        $recentTenants = Tenant::with('subscriptionPlan')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats', 
            'ordersByMonth', 
            'ordersByStatus', 
            'restaurantsByCity', 
            'recentOrders', 
            'recentTenants'
        ));
    }

    /**
     * Obtenir les commandes par mois
     */
    private function getOrdersByMonth()
    {
        $orders = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(total_amount) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Remplir les mois manquants avec 0
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $orders->where('month', $i)->first();
            $monthlyData[] = [
                'month' => $i,
                'count' => $monthData ? $monthData->count : 0,
                'revenue' => $monthData ? ($monthData->revenue ?? 0) : 0
            ];
        }

        return $monthlyData;
    }

    /**
     * Obtenir les commandes par statut
     */
    private function getOrdersByStatus()
    {
        return DB::table('orders')
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
    }

    /**
     * Obtenir les restaurants par ville
     */
    private function getRestaurantsByCity()
    {
        return DB::table('restaurants')
            ->selectRaw('city, COUNT(*) as count')
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(10)
            ->get();
    }
}
