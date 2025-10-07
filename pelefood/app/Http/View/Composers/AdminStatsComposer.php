<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Video;
use App\Models\SubscriptionPlan;

class AdminStatsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Statistiques globales pour la sidebar
        $globalStats = [
            'restaurants' => [
                'total' => Restaurant::count(),
                'active' => Restaurant::where('is_active', true)->count(),
                'pending' => Restaurant::where('is_verified', false)->count(), // Non vérifiés = en attente
            ],
            'users' => [
                'total' => User::count(),
                'active' => User::where('last_login_at', '>=', now()->subDays(30))->count(),
                'new_today' => User::whereDate('created_at', today())->count(),
            ],
            'orders' => [
                'total' => Order::count(),
                'pending' => Order::where('status', 'pending')->count(),
                'completed' => Order::where('status', 'delivered')->count(),
                'today' => Order::whereDate('created_at', today())->count(),
            ],
            'products' => [
                'total' => Product::count(),
                'active' => Product::where('is_available', true)->count(),
            ],
            'categories' => [
                'total' => Category::count(),
                'active' => Category::where('is_active', true)->count(),
            ],
            'subscriptions' => [
                'total' => SubscriptionPlan::count(),
                'active' => SubscriptionPlan::where('is_active', true)->count(),
            ],
            'reviews' => [
                'total' => Review::count(),
                'pending' => Review::where('is_approved', false)->count(), // Non approuvés = en attente
                'avg_rating' => Review::avg('rating') ?? 0,
            ],
            'videos' => [
                'total' => Video::count(),
                'active' => Video::where('is_active', true)->count(),
            ],
            'revenue' => [
                'total' => Order::where('status', 'delivered')->sum('total_amount') ?? 0,
                'today' => Order::where('status', 'delivered')
                    ->whereDate('created_at', today())
                    ->sum('total_amount') ?? 0,
            ]
        ];

        $view->with('globalStats', $globalStats);
    }
}
