<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\PaymentTransaction;

class AccountingController extends Controller
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

    public function index(Request $request)
    {
        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        // Période par défaut (aujourd'hui)
        $startDate = $request->get('start_date', today());
        $endDate = $request->get('end_date', today());

        // Récupérer les commandes de la période
        $orders = Order::where('restaurant_id', $restaurant->id)
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->with(['user', 'items'])
            ->get();

        // Récupérer les transactions de paiement
        $transactions = PaymentTransaction::where('restaurant_id', $restaurant->id)
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->with(['order'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistiques
        $stats = [
            'revenue' => $orders->where('status', 'delivered')->sum('total_amount'),
            'orders_count' => $orders->count(),
            'delivery_fees' => $orders->where('type', 'delivery')->sum('delivery_fee'),
            'net_profit' => $orders->where('status', 'delivered')->sum('total_amount') - $orders->where('type', 'delivery')->sum('delivery_fee'),
        ];

        // Données pour les graphiques
        $chartData = $this->getChartData($orders);

        return view('restaurant.accounting.index', compact('orders', 'transactions', 'stats', 'chartData', 'startDate', 'endDate'));
    }

    private function getChartData($orders)
    {
        // Graphique des ventes par heure
        $salesByHour = [];
        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $salesByHour[$hour] = $orders->where('status', 'delivered')
                ->filter(function ($order) use ($i) {
                    return $order->created_at->hour == $i;
                })
                ->sum('total_amount');
        }

        // Répartition des types de commande
        $orderTypes = [
            'delivery' => $orders->where('type', 'delivery')->count(),
            'pickup' => $orders->where('type', 'pickup')->count(),
            'dine_in' => $orders->where('type', 'dine_in')->count(),
        ];

        return [
            'sales_by_hour' => $salesByHour,
            'order_types' => $orderTypes,
        ];
    }
}