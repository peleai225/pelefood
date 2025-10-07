<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Video;
use App\Models\Payment;
use Carbon\Carbon;

class Dashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $filterPeriod = '30'; // 7, 30, 90, 365
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    
    // Statistiques en temps réel
    public $stats = [
        'total_tenants' => 0,
        'total_restaurants' => 0,
        'active_restaurants' => 0,
        'total_users' => 0,
        'total_orders' => 0,
        'total_revenue' => 0,
        'orders_today' => 0,
        'total_products' => 0,
        'total_categories' => 0,
        'total_reviews' => 0,
        'pending_orders' => 0,
        'completed_orders' => 0,
        'cancelled_orders' => 0,
        'total_videos' => 0,
        'total_payments' => 0,
    ];
    
    // Données pour les graphiques
    public $monthlyData = [
        'months' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
        'revenue' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'orders' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    ];
    public $topRestaurants = [];
    public $recentOrders = [];
    public $recentUsers = [];

    protected $listeners = ['refreshDashboard' => 'loadData'];

    public function mount()
    {
        // Charger toutes les données
        $this->loadStats();
        $this->loadMonthlyData();
        $this->loadTopRestaurants();
        $this->loadRecentOrders();
        $this->loadRecentUsers();
    }

    public function loadData()
    {
        $this->loadStats();
        $this->loadMonthlyData();
        $this->loadTopRestaurants();
        $this->loadRecentOrders();
        $this->loadRecentUsers();
    }

    public function loadStats()
    {
        try {
            $this->stats = [
                'total_tenants' => Restaurant::count(),
                'total_restaurants' => Restaurant::count(),
                'active_restaurants' => Restaurant::where('is_active', true)->count(),
                'total_users' => User::count(),
                'total_orders' => Order::count(),
                'total_revenue' => Order::where('status', 'delivered')->sum('total_amount') ?? 0,
                'orders_today' => Order::whereDate('created_at', today())->count(),
                'total_products' => Product::count(),
                'total_categories' => Category::count(),
                'total_reviews' => 0, // Temporairement désactivé
                'pending_orders' => Order::where('status', 'pending')->count(),
                'completed_orders' => Order::where('status', 'delivered')->count(),
                'cancelled_orders' => Order::where('status', 'cancelled')->count(),
                'total_videos' => 0, // Temporairement désactivé
                'total_payments' => 0, // Temporairement désactivé
            ];
        } catch (\Exception $e) {
            // En cas d'erreur, utiliser des valeurs par défaut
            $this->stats = [
                'total_tenants' => 0,
                'total_restaurants' => 0,
                'active_restaurants' => 0,
                'total_users' => 0,
                'total_orders' => 0,
                'total_revenue' => 0,
                'orders_today' => 0,
                'total_products' => 0,
                'total_categories' => 0,
                'total_reviews' => 0,
                'pending_orders' => 0,
                'completed_orders' => 0,
                'cancelled_orders' => 0,
                'total_videos' => 0,
                'total_payments' => 0,
            ];
        }
    }

    public function loadMonthlyData()
    {
        try {
            $months = [];
            $revenue = [];
            $orders = [];
            
            for ($i = 11; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $months[] = $month->format('M Y');
                
                $monthRevenue = Order::where('status', 'delivered')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('total_amount') ?? 0;
                $revenue[] = $monthRevenue;
                
                $monthOrders = Order::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count();
                $orders[] = $monthOrders;
            }
            
            $this->monthlyData = [
                'months' => $months,
                'revenue' => $revenue,
                'orders' => $orders
            ];
        } catch (\Exception $e) {
            $this->monthlyData = [
                'months' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                'revenue' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                'orders' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            ];
        }
    }

    public function loadTopRestaurants()
    {
        try {
            $this->topRestaurants = Restaurant::withSum('orders', 'total_amount')
                ->withCount('orders')
                ->whereHas('orders', function($query) {
                    $query->where('status', 'delivered');
                })
                ->orderBy('orders_sum_total_amount', 'desc')
                ->take(5)
                ->get()
                ->map(function($restaurant) {
                    return [
                        'id' => $restaurant->id,
                        'name' => $restaurant->name,
                        'revenue' => $restaurant->orders_sum_total_amount ?? 0,
                        'orders_count' => $restaurant->orders_count ?? 0,
                        'city' => $restaurant->city ?? 'N/A'
                    ];
                });
        } catch (\Exception $e) {
            $this->topRestaurants = collect([]);
        }
    }

    public function loadRecentOrders()
    {
        try {
            $this->recentOrders = Order::with(['restaurant', 'user'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function($order) {
                    return [
                        'id' => $order->id,
                        'order_number' => $order->order_number ?? '#'.$order->id,
                        'restaurant_name' => $order->restaurant->name ?? 'Restaurant supprimé',
                        'customer_name' => $order->user->name ?? 'Client supprimé',
                        'total_amount' => $order->total_amount ?? 0,
                        'status' => $order->status ?? 'pending',
                        'created_at' => $order->created_at ? $order->created_at->diffForHumans() : 'N/A'
                    ];
                });
        } catch (\Exception $e) {
            $this->recentOrders = collect([]);
        }
    }

    public function loadRecentUsers()
    {
        try {
            $this->recentUsers = User::with('restaurant')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'restaurant_name' => $user->restaurant->name ?? 'Aucun restaurant',
                        'created_at' => $user->created_at ? $user->created_at->diffForHumans() : 'N/A'
                    ];
                });
        } catch (\Exception $e) {
            $this->recentUsers = collect([]);
        }
    }

    public function updateFilterPeriod($period)
    {
        $this->filterPeriod = $period;
        $this->loadData();
    }

    public function refreshStats()
    {
        $this->loadData();
        $this->emit('showNotification', 'Statistiques mises à jour', 'success');
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'stats' => $this->stats,
            'monthlyData' => $this->monthlyData,
            'topRestaurants' => $this->topRestaurants,
            'recentOrders' => $this->recentOrders,
            'recentUsers' => $this->recentUsers,
        ])->layout('layouts.super-admin-new-design');
    }
}