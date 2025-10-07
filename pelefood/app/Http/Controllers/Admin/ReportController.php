<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Statistiques générales pour les rapports
        $stats = [
            'total_tenants' => Tenant::count(),
            'active_tenants' => Tenant::where('status', 'active')->count(),
            'total_restaurants' => Restaurant::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_revenue' => Order::sum('total_amount'),
        ];

        // Données pour les graphiques
        $reports = [
            'orders_by_month' => $this->getOrdersByMonth(),
            'top_restaurants' => $this->getTopRestaurants(),
            'tenant_growth' => $this->getTenantGrowth(),
            'revenue_trends' => $this->getRevenueTrends(),
            'orders_by_status' => $this->getOrdersByStatus(),
            'restaurants_by_city' => $this->getRestaurantsByCity(),
        ];

        return view('admin.reports.index', compact('stats', 'reports'));
    }

    /**
     * Rapport des commandes par mois
     */
    public function orders(Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'status', 'restaurant_id']);
        
        $query = Order::with(['restaurant', 'user']);
        
        if ($filters['date_from']) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        
        if ($filters['date_to']) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        
        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }
        
        if ($filters['restaurant_id']) {
            $query->where('restaurant_id', $filters['restaurant_id']);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(50);
        $restaurants = Restaurant::all();
        
        $stats = $this->getOrderStats($filters);
        
        return view('admin.reports.orders', compact('orders', 'restaurants', 'stats', 'filters'));
    }

    /**
     * Rapport des revenus
     */
    public function revenue(Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'restaurant_id', 'group_by']);
        $groupBy = $filters['group_by'] ?? 'month';
        
        $revenueData = $this->getRevenueData($filters, $groupBy);
        $restaurants = Restaurant::all();
        
        return view('admin.reports.revenue', compact('revenueData', 'restaurants', 'filters', 'groupBy'));
    }

    /**
     * Rapport des restaurants
     */
    public function restaurants(Request $request)
    {
        $filters = $request->only(['status', 'subscription_plan_id', 'date_from', 'date_to']);
        
        $query = Restaurant::with(['subscriptionPlan', 'tenant']);
        
        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }
        
        if ($filters['subscription_plan_id']) {
            $query->where('subscription_plan_id', $filters['subscription_plan_id']);
        }
        
        if ($filters['date_from']) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        
        if ($filters['date_to']) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        
        $restaurants = $query->orderBy('created_at', 'desc')->paginate(50);
        $stats = $this->getRestaurantStats($filters);
        
        return view('admin.reports.restaurants', compact('restaurants', 'stats', 'filters'));
    }

    /**
     * Export des données
     */
    public function export(Request $request, $type)
    {
        $filters = $request->all();
        $format = $request->get('format', 'csv');
        
        switch ($type) {
            case 'orders':
                $data = $this->getOrdersForExport($filters);
                break;
            case 'revenue':
                $data = $this->getRevenueForExport($filters);
                break;
            case 'restaurants':
                $data = $this->getRestaurantsForExport($filters);
                break;
            case 'tenants':
                $data = $this->getTenantsForExport($filters);
                break;
            default:
                return redirect()->back()->with('error', 'Type de rapport non reconnu.');
        }
        
        if ($format === 'pdf') {
            return $this->exportToPdf($type, $data);
        }
        
        return $this->exportToCsv($type, $data);
    }

    // Méthodes privées pour récupérer les données

    private function getOrdersByMonth()
    {
        return Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count, SUM(total_amount) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    }

    private function getTopRestaurants()
    {
        return Restaurant::withCount('orders')
            ->withSum('orders', 'total_amount')
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();
    }

    private function getTenantGrowth()
    {
        return Tenant::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', now()->subMonths(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    private function getRevenueTrends()
    {
        return Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->whereDate('created_at', '>=', now()->subMonths(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    private function getOrdersByStatus()
    {
        return Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
    }

    private function getRestaurantsByCity()
    {
        return Restaurant::selectRaw('city, COUNT(*) as count')
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
    }

    private function getOrderStats($filters = [])
    {
        $query = Order::query();
        
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        
        if (!empty($filters['restaurant_id'])) {
            $query->where('restaurant_id', $filters['restaurant_id']);
        }
        
        return [
            'total_orders' => $query->count(),
            'total_revenue' => $query->sum('total_amount'),
            'pending_orders' => (clone $query)->where('status', 'pending')->count(),
            'completed_orders' => (clone $query)->where('status', 'completed')->count(),
            'cancelled_orders' => (clone $query)->where('status', 'cancelled')->count(),
            'average_order_value' => $query->avg('total_amount'),
        ];
    }

    private function getRestaurantStats($filters = [])
    {
        $query = Restaurant::query();
        
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        
        return [
            'total_restaurants' => $query->count(),
            'active_restaurants' => (clone $query)->where('status', 'active')->count(),
            'pending_restaurants' => (clone $query)->where('status', 'pending')->count(),
        ];
    }

    private function getRevenueData($filters, $groupBy)
    {
        $query = Order::where('status', 'completed');
        
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        
        switch ($groupBy) {
            case 'day':
                $query->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders');
                $query->groupBy('date');
                break;
            case 'week':
                $query->selectRaw('YEARWEEK(created_at) as week, SUM(total_amount) as revenue, COUNT(*) as orders');
                $query->groupBy('week');
                break;
            case 'month':
            default:
                $query->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_amount) as revenue, COUNT(*) as orders');
                $query->groupBy('year', 'month');
                break;
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }

    // Méthodes d'export

    private function getOrdersForExport($filters) { /* Implementation */ }
    private function getRevenueForExport($filters) { /* Implementation */ }
    private function getRestaurantsForExport($filters) { /* Implementation */ }
    private function getTenantsForExport($filters) { /* Implementation */ }
    
    private function exportToCsv($type, $data) { /* Implementation */ }
    private function exportToPdf($type, $data) { /* Implementation */ }
} 