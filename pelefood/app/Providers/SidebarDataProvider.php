<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Video;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Models\User;

class SidebarDataProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.super-admin-new-design', function ($view) {
            try {
                $globalStats = [
                    'restaurants' => [
                        'total' => Restaurant::count(),
                        'active' => Restaurant::where('is_active', true)->count(),
                    ],
                    'orders' => [
                        'total' => Order::count(),
                        'pending' => Order::where('status', 'pending')->count(),
                        'completed' => Order::where('status', 'delivered')->count(),
                    ],
                    'products' => [
                        'total' => \App\Models\Product::count(),
                    ],
                    'categories' => [
                        'total' => \App\Models\Category::count(),
                    ],
                    'promotions' => [
                        'active' => \App\Models\Product::where('is_featured', true)->count(),
                    ],
                    'users' => [
                        'total' => User::count(),
                        'active' => User::where('is_active', true)->count(),
                    ],
                    'videos' => [
                        'total' => Video::count(),
                    ],
                    'transactions' => [
                        'total' => Payment::count(),
                    ],
                    'support' => [
                        'open' => 0, // À implémenter quand le modèle SupportTicket existera
                    ],
                ];
                
                $view->with('globalStats', $globalStats);
            } catch (\Exception $e) {
                // En cas d'erreur, utiliser des valeurs par défaut
                $view->with('globalStats', [
                    'restaurants' => ['total' => 0, 'active' => 0],
                    'orders' => ['total' => 0, 'pending' => 0, 'completed' => 0],
                    'products' => ['total' => 0],
                    'categories' => ['total' => 0],
                    'promotions' => ['active' => 0],
                    'users' => ['total' => 0, 'active' => 0],
                    'videos' => ['total' => 0],
                    'transactions' => ['total' => 0],
                    'support' => ['open' => 0],
                ]);
            }
        });
    }
}