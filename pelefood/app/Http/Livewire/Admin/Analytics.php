<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

class Analytics extends Component
{
    public $dateFrom;
    public $dateTo;
    public $selectedMetric = 'revenue';

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

    public function getAnalyticsData()
    {
        $query = Order::whereBetween('created_at', [$this->dateFrom, $this->dateTo]);

        return [
            'total_revenue' => $query->where('status', 'delivered')->sum('total_amount'),
            'total_orders' => $query->count(),
            'avg_order_value' => $query->avg('total_amount'),
            'conversion_rate' => 0, // À calculer selon vos besoins
            'top_restaurants' => Restaurant::withSum('orders', 'total_amount')
                ->whereHas('orders', function($q) {
                    $q->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
                })
                ->orderBy('orders_sum_total_amount', 'desc')
                ->take(5)
                ->get(),
            'monthly_data' => $this->getMonthlyData()
        ];
    }

    public function getMonthlyData()
    {
        $months = [];
        $revenue = [];
        $orders = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');
            
            $monthRevenue = Order::where('status', 'delivered')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_amount');
            $revenue[] = $monthRevenue;
            
            $monthOrders = Order::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $orders[] = $monthOrders;
        }
        
        return [
            'months' => $months,
            'revenue' => $revenue,
            'orders' => $orders
        ];
    }

    public function render()
    {
        $analytics = $this->getAnalyticsData();
        
        return view('livewire.admin.analytics', [
            'analytics' => $analytics
        ])->layout('layouts.super-admin-new-design');
    }
}