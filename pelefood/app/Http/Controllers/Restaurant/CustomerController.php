<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Récupérer le restaurant de l'utilisateur connecté
     */
    protected function getCurrentRestaurant()
    {
        $user = Auth::user();
        
        if ($user->role === 'super_admin') {
            $restaurant = \App\Models\Restaurant::first();
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

        // Récupérer les clients à partir des commandes
        $customers = Order::where('restaurant_id', $restaurant->id)
            ->whereNotNull('user_id')
            ->with(['user'])
            ->get()
            ->groupBy('user_id')
            ->map(function ($orders) {
                $user = $orders->first()->user;
                // Vérifier que l'utilisateur existe
                if (!$user) {
                    return null;
                }
                return [
                    'user' => $user,
                    'orders_count' => $orders->count(),
                    'total_spent' => $orders->sum('total_amount'),
                    'last_order' => $orders->max('created_at'),
                    'satisfaction_rate' => 85 + rand(0, 15), // Simulation
                ];
            })
            ->filter(); // Supprimer les entrées null

        // Statistiques
        $stats = [
            'total_customers' => $customers->count(),
            'active_customers' => $customers->where('orders_count', '>', 1)->count(),
            'new_customers' => $customers->where('last_order', '>=', now()->subDays(30))->count(),
            'average_value' => $customers->avg('total_spent') ?? 0,
        ];

        return view('restaurant.customers.index', compact('customers', 'stats'));
    }

    public function show($id)
    {
        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        $user = User::findOrFail($id);
        $orders = Order::where('restaurant_id', $restaurant->id)
            ->where('user_id', $id)
            ->with(['items'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('restaurant.customers.show', compact('user', 'orders'));
    }
}