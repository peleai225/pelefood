<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Tenant;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin');
    }

    public function index(Request $request)
    {
        $query = Restaurant::with(['tenant', 'orders']);

        // Filtres
        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('plan')) {
            $query->where('subscription_plan_id', $request->plan);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $restaurants = $query->orderBy('created_at', 'desc')->paginate(15);
        $tenants = Tenant::all();
        $plans = \App\Models\SubscriptionPlan::all();

        return view('admin.restaurants.index', compact('restaurants', 'tenants', 'plans'));
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['tenant', 'orders', 'categories', 'products']);
        
        // Statistiques
        $stats = [
            'total_orders' => $restaurant->orders()->count(),
            'total_products' => $restaurant->products()->count(),
            'total_categories' => $restaurant->categories()->count(),
            'monthly_revenue' => $restaurant->orders()->whereMonth('created_at', now()->month)->sum('total_amount'),
        ];

        return view('admin.restaurants.show', compact('restaurant', 'stats'));
    }

    public function edit(Restaurant $restaurant)
    {
        $tenants = Tenant::all();
        $plans = \App\Models\SubscriptionPlan::all();
        $users = \App\Models\User::whereIn('role', ['restaurant', 'admin', 'super_admin'])->get();
        return view('admin.restaurants.edit', compact('restaurant', 'tenants', 'plans', 'users'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:restaurants,slug,' . $restaurant->id,
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url',
            'is_active' => 'boolean',
            'tenant_id' => 'nullable|exists:tenants,id',
            'user_id' => 'nullable|exists:users,id',
            'subscription_plan_id' => 'nullable|exists:subscription_plans,id',
            'delivery_fee' => 'nullable|numeric|min:0',
            'minimum_order' => 'nullable|numeric|min:0',
            'preparation_time' => 'nullable|integer|min:0',
            'delivery_time' => 'nullable|integer|min:0',
            'delivery_radius' => 'nullable|integer|min:0',
            'delivery_available' => 'boolean',
            'takeaway_available' => 'boolean',
            'delivery_zones' => 'nullable|array',
        ]);

        $data = $request->all();
        
        // Gérer les settings
        $settings = $restaurant->settings ?? [];
        $settings['delivery_enabled'] = $request->has('delivery_available');
        $settings['takeaway_enabled'] = $request->has('takeaway_available');
        $data['settings'] = $settings;
        
        // Supprimer les champs qui ne sont pas dans le modèle
        unset($data['delivery_available'], $data['takeaway_available']);

        $restaurant->update($data);

        return redirect()->route('admin.restaurants.show', $restaurant)
            ->with('success', 'Restaurant mis à jour avec succès.');
    }

    public function destroy(Restaurant $restaurant)
    {
        // Supprimer les images
        if ($restaurant->logo_url) {
            Storage::delete($restaurant->logo_url);
        }
        if ($restaurant->cover_image_url) {
            Storage::delete($restaurant->cover_image_url);
        }

        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant supprimé avec succès.');
    }

    public function orders(Restaurant $restaurant)
    {
        $orders = $restaurant->orders()
            ->with(['items'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.restaurants.orders', compact('restaurant', 'orders'));
    }

    public function reports(Restaurant $restaurant)
    {
        // Statistiques pour les rapports
        $stats = [
            'total_orders' => $restaurant->orders()->count(),
            'total_revenue' => $restaurant->orders()->sum('total_amount'),
            'avg_order_value' => $restaurant->orders()->avg('total_amount'),
            'monthly_orders' => $restaurant->orders()->whereMonth('created_at', now()->month)->count(),
            'monthly_revenue' => $restaurant->orders()->whereMonth('created_at', now()->month)->sum('total_amount'),
        ];

        // Commandes par statut
        $ordersByStatus = $restaurant->orders()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Commandes par mois (6 derniers mois)
        $monthlyOrders = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyOrders[$date->format('M Y')] = $restaurant->orders()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return view('admin.restaurants.reports', compact('restaurant', 'stats', 'ordersByStatus', 'monthlyOrders'));
    }

    public function toggleStatus(Restaurant $restaurant)
    {
        $restaurant->update([
            'is_active' => !$restaurant->is_active
        ]);

        $status = $restaurant->is_active ? 'activé' : 'désactivé';
        
        return redirect()->route('admin.restaurants.index')
            ->with('success', "Restaurant {$status} avec succès.");
    }
} 