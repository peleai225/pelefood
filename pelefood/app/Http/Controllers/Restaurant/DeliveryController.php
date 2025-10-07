<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class DeliveryController extends Controller
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

        // Récupérer les commandes de livraison
        $deliveries = Order::where('restaurant_id', $restaurant->id)
            ->where('type', 'delivery')
            ->with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistiques
        $todayDeliveries = Order::where('restaurant_id', $restaurant->id)
            ->where('type', 'delivery')
            ->whereDate('created_at', today())
            ->get();

        $stats = [
            'today_deliveries' => $todayDeliveries->count(),
            'delivered_today' => $todayDeliveries->where('status', 'delivered')->count(),
            'in_progress' => $todayDeliveries->whereIn('status', ['preparing', 'ready', 'delivering'])->count(),
            'delivery_revenue' => $todayDeliveries->where('status', 'delivered')->sum('delivery_fee') ?? 0,
        ];

        return view('restaurant.deliveries.index', compact('deliveries', 'stats', 'restaurant'));
    }

    public function show($id)
    {
        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        $order = Order::where('restaurant_id', $restaurant->id)
            ->where('type', 'delivery')
            ->where('id', $id)
            ->with(['user', 'items'])
            ->firstOrFail();

        return view('restaurant.deliveries.show', compact('order'));
    }
}