<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class Reports extends Component
{
    public $dateFrom;
    public $dateTo;
    public $selectedRestaurant = 'all';

    protected $listeners = ['dateRangeUpdated' => 'loadData'];

    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->endOfMonth()->format('Y-m-d');
        $this->loadData();
    }

    public function loadData()
    {
        // Les données sont chargées dans render()
    }

    public function updateDateRange()
    {
        $this->emit('dateRangeUpdated');
    }

    public function render()
    {
        $query = Order::with(['restaurant', 'user'])
            ->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);

        if ($this->selectedRestaurant !== 'all') {
            $query->where('restaurant_id', $this->selectedRestaurant);
        }

        $orders = $query->get();

        $stats = [
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->where('status', 'delivered')->sum('total_amount'),
            'avg_order_value' => $orders->avg('total_amount'),
            'restaurants_count' => Restaurant::count(),
            'products_count' => Product::count(),
            'categories_count' => Category::count(),
        ];

        // Générer les données d'analytics pour les graphiques
        $analytics = $this->generateAnalyticsData();

        return view('livewire.admin.reports', [
            'orders' => $orders,
            'stats' => $stats,
            'restaurants' => Restaurant::all(),
            'analytics' => $analytics
        ])->layout('layouts.super-admin-new-design');
    }

    private function generateAnalyticsData()
    {
        // Données mensuelles pour les 12 derniers mois
        $months = [];
        $revenue = [];
        $orders = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            
            $monthOrders = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'delivered');
                
            if ($this->selectedRestaurant !== 'all') {
                $monthOrders->where('restaurant_id', $this->selectedRestaurant);
            }
            
            $monthOrdersData = $monthOrders->get();
            
            $revenue[] = $monthOrdersData->sum('total_amount');
            $orders[] = $monthOrdersData->count();
        }

        // Top restaurants
        $topRestaurants = Restaurant::withCount(['orders' => function($query) {
            $query->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
        }])
        ->withSum(['orders' => function($query) {
            $query->whereBetween('created_at', [$this->dateFrom, $this->dateTo])
                  ->where('status', 'delivered');
        }], 'total_amount')
        ->orderBy('orders_sum_total_amount', 'desc')
        ->take(5)
        ->get();

        return [
            'monthly_data' => [
                'months' => $months,
                'revenue' => $revenue,
                'orders' => $orders
            ],
            'top_restaurants' => $topRestaurants,
            'status_distribution' => [
                'pending' => Order::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->where('status', 'pending')->count(),
                'confirmed' => Order::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->where('status', 'confirmed')->count(),
                'preparing' => Order::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->where('status', 'preparing')->count(),
                'ready' => Order::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->where('status', 'ready')->count(),
                'delivered' => Order::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->where('status', 'delivered')->count(),
                'cancelled' => Order::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->where('status', 'cancelled')->count(),
            ]
        ];
    }
}