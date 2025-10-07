<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
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
            'total_products' => Product::count(),
            'total_revenue' => Order::sum('total_amount'),
        ];

        // Commandes par mois (12 derniers mois)
        $ordersByMonth = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count, SUM(total_amount) as revenue')
            ->whereDate('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Top 10 des restaurants par commandes
        $topRestaurants = Restaurant::withCount('orders')
            ->withSum('orders', 'total_amount')
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();

        // Croissance des tenants (6 derniers mois)
        $tenantGrowth = Tenant::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', now()->subMonths(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Répartition des commandes par statut
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Répartition géographique des restaurants
        $restaurantsByCity = Restaurant::selectRaw('city, COUNT(*) as count')
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.analytics.index', compact(
            'stats',
            'ordersByMonth',
            'topRestaurants',
            'tenantGrowth',
            'ordersByStatus',
            'restaurantsByCity'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'orders');
        
        switch ($type) {
            case 'orders':
                return $this->exportOrders();
            case 'restaurants':
                return $this->exportRestaurants();
            case 'tenants':
                return $this->exportTenants();
            default:
                return back()->with('error', 'Type d\'export non reconnu');
        }
    }

    private function exportOrders()
    {
        $orders = Order::with(['user', 'restaurant'])
            ->latest()
            ->get();

        $filename = 'orders_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, ['ID', 'Restaurant', 'Client', 'Montant', 'Statut', 'Date']);
            
            // Data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->restaurant->name ?? 'N/A',
                    $order->user->name ?? 'N/A',
                    $order->total_amount,
                    $order->status,
                    $order->created_at->format('d/m/Y H:i'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportRestaurants()
    {
        $restaurants = Restaurant::with(['tenant', 'subscriptionPlan'])
            ->latest()
            ->get();

        $filename = 'restaurants_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($restaurants) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, ['ID', 'Nom', 'Tenant', 'Plan', 'Statut', 'Ville', 'Date création']);
            
            // Data
            foreach ($restaurants as $restaurant) {
                fputcsv($file, [
                    $restaurant->id,
                    $restaurant->name,
                    $restaurant->tenant->name ?? 'N/A',
                    $restaurant->subscriptionPlan->name ?? 'N/A',
                    $restaurant->status,
                    $restaurant->city ?? 'N/A',
                    $restaurant->created_at->format('d/m/Y H:i'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportTenants()
    {
        $tenants = Tenant::with(['owner', 'subscriptionPlan'])
            ->latest()
            ->get();

        $filename = 'tenants_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($tenants) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, ['ID', 'Nom', 'Propriétaire', 'Plan', 'Statut', 'Date création']);
            
            // Data
            foreach ($tenants as $tenant) {
                fputcsv($file, [
                    $tenant->id,
                    $tenant->name,
                    $tenant->owner->name ?? 'N/A',
                    $tenant->subscriptionPlan->name ?? 'N/A',
                    $tenant->status,
                    $tenant->created_at->format('d/m/Y H:i'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 