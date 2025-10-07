<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user || !in_array($user->role, ['manager', 'staff'])) {
                abort(403, 'Accès non autorisé.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $user = Auth::user();
        $restaurant = $this->getStaffRestaurant($user);

        if (!$restaurant) {
            return redirect()->route('staff.setup')
                ->with('error', 'Aucun restaurant configuré pour votre compte.');
        }

        // Statistiques en temps réel
        $stats = [
            'pending_orders' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'pending')->count(),
            'preparing_orders' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'preparing')->count(),
            'ready_orders' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'ready')->count(),
            'today_orders' => Order::where('restaurant_id', $restaurant->id)
                ->whereDate('created_at', today())->count(),
        ];

        // Commandes récentes
        $recentOrders = Order::where('restaurant_id', $restaurant->id)
            ->with(['items'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('staff.dashboard', compact('restaurant', 'stats', 'recentOrders'));
    }

    public function orders(Request $request)
    {
        $user = Auth::user();
        $restaurant = $this->getStaffRestaurant($user);

        if (!$restaurant) {
            return redirect()->route('staff.setup');
        }

        $query = Order::where('restaurant_id', $restaurant->id)
            ->with(['items']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('staff.orders.index', compact('orders', 'restaurant'));
    }

    public function orderDetail(Order $order)
    {
        $user = Auth::user();
        $restaurant = $this->getStaffRestaurant($user);

        if (!$restaurant || $order->restaurant_id !== $restaurant->id) {
            abort(403, 'Accès non autorisé.');
        }

        $order->load(['items']);

        return view('staff.orders.show', compact('order', 'restaurant'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $user = Auth::user();
        $restaurant = $this->getStaffRestaurant($user);

        if (!$restaurant || $order->restaurant_id !== $restaurant->id) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Log de l'action
        \Log::info('Statut de commande mis à jour', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'updated_by' => $user->id,
            'user_role' => $user->role
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
            'order' => $order->fresh()
        ]);
    }

    public function setup()
    {
        $user = Auth::user();
        $restaurant = $this->getStaffRestaurant($user);

        if ($restaurant) {
            return redirect()->route('staff.dashboard');
        }

        return view('staff.setup');
    }

    protected function getStaffRestaurant($user)
    {
        if ($user->role === 'manager' || $user->role === 'staff') {
            return $user->tenant->restaurants->first();
        }

        return null;
    }
} 