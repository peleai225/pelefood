<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Order;
use App\Models\SubscriptionPlan;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user || !in_array($user->role, ['admin', 'super_admin'])) {
                abort(403, 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        // Statistiques générales avec cache
        $stats = cache()->remember('admin_dashboard_stats', 300, function () {
            return [
                'total_restaurants' => Restaurant::count(),
                'active_restaurants' => Restaurant::where('is_active', true)->count(),
                'total_orders' => Order::count(),
                'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount') ?? 0,
                'total_users' => User::count(),
                'total_tenants' => Tenant::count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'completed_orders' => Order::where('status', 'completed')->count(),
            ];
        });

        // Restaurants récents avec eager loading
        $recent_restaurants = cache()->remember('admin_recent_restaurants', 300, function () {
            return Restaurant::with('tenant')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        });

        // Commandes récentes avec eager loading
        $recent_orders = cache()->remember('admin_recent_orders', 300, function () {
            return Order::with(['restaurant:id,name', 'items:id,order_id'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        });

        // Revenus par mois (6 derniers mois) avec cache
        $monthly_revenue = cache()->remember('admin_monthly_revenue', 600, function () {
            return Order::where('payment_status', 'paid')
                ->where('created_at', '>=', now()->subMonths(6))
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as revenue')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        });

        // Top restaurants par commandes avec cache
        $top_restaurants = cache()->remember('admin_top_restaurants', 600, function () {
            return Restaurant::withCount('orders')
                ->orderBy('orders_count', 'desc')
                ->limit(5)
                ->get();
        });

        return view('admin.dashboard', compact(
            'stats',
            'recent_restaurants',
            'recent_orders',
            'monthly_revenue',
            'top_restaurants'
        ));
    }

    public function restaurants(Request $request)
    {
        $query = Restaurant::with(['tenant:id,name,domain', 'subscriptionPlan:id,name,price']);

        // Filtres
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('plan')) {
            $query->whereHas('subscriptionPlan', function($q) use ($request) {
                $q->where('id', $request->plan);
            });
        }

        $restaurants = $query->orderBy('created_at', 'desc')->paginate(15);
        $plans = cache()->remember('subscription_plans_all', 300, function () {
            return SubscriptionPlan::all();
        });

        return view('admin.restaurants.index', compact('restaurants', 'plans'));
    }

    public function restaurantShow(Restaurant $restaurant)
    {
        $restaurant->load(['tenant:id,name,domain', 'subscriptionPlan:id,name,price', 'orders:id,restaurant_id,order_number,customer_name,customer_phone,total_amount,status,created_at', 'products:id,restaurant_id,name', 'categories:id,restaurant_id,name']);
        
        // Statistiques du restaurant avec cache
        $cacheKey = "restaurant_stats_{$restaurant->id}";
        $stats = cache()->remember($cacheKey, 300, function () use ($restaurant) {
            return [
                'total_orders' => $restaurant->orders()->count(),
                'total_revenue' => $restaurant->orders()->where('payment_status', 'paid')->sum('total_amount') ?? 0,
                'total_products' => $restaurant->products()->count(),
                'total_categories' => $restaurant->categories()->count(),
                'pending_orders' => $restaurant->orders()->where('status', 'pending')->count(),
                'completed_orders' => $restaurant->orders()->where('status', 'completed')->count(),
            ];
        });

        // Commandes récentes avec eager loading
        $recent_orders = $restaurant->orders()
            ->with('items:id,order_id,product_id,quantity,price')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Produits populaires avec cache
        $popular_products_cache_key = "restaurant_popular_products_{$restaurant->id}";
        $popular_products = cache()->remember($popular_products_cache_key, 600, function () use ($restaurant) {
            return $restaurant->products()
                ->withCount('orderItems')
                ->orderBy('order_items_count', 'desc')
                ->limit(5)
                ->get();
        });

        return view('admin.restaurants.show', compact('restaurant', 'stats', 'recent_orders', 'popular_products'));
    }

    public function restaurantEdit(Restaurant $restaurant)
    {
        $plans = SubscriptionPlan::all();
        $tenants = Tenant::all();
        
        return view('admin.restaurants.edit', compact('restaurant', 'plans', 'tenants'));
    }

    public function restaurantUpdate(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:restaurants,slug,' . $restaurant->id,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'subscription_plan_id' => 'nullable|exists:subscription_plans,id',
            'tenant_id' => 'nullable|exists:tenants,id',
        ]);

        $restaurant->update($request->all());

        return redirect()->route('admin.restaurants.show', $restaurant)
            ->with('success', 'Restaurant mis à jour avec succès');
    }

    public function restaurantToggleStatus(Restaurant $restaurant)
    {
        $restaurant->update(['is_active' => !$restaurant->is_active]);
        
        $status = $restaurant->is_active ? 'activé' : 'désactivé';
        return back()->with('success', "Restaurant {$status} avec succès");
    }

    public function tenants(Request $request)
    {
        $query = Tenant::with(['restaurants:id,tenant_id,name', 'users:id,tenant_id,name,email']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('domain', 'like', "%{$search}%");
            });
        }

        $tenants = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.tenants.index', compact('tenants'));
    }

    public function tenantShow(Tenant $tenant)
    {
        $tenant->load(['restaurants', 'users']);
        
        $stats = [
            'total_restaurants' => $tenant->restaurants()->count(),
            'active_restaurants' => $tenant->restaurants()->where('is_active', true)->count(),
            'total_users' => $tenant->users()->count(),
            'total_orders' => $tenant->restaurants()->withCount('orders')->get()->sum('orders_count'),
        ];

        return view('admin.tenants.show', compact('tenant', 'stats'));
    }

    public function subscriptionPlans()
    {
        $plans = SubscriptionPlan::withCount('restaurants')->get();
        
        return view('admin.subscription-plans.index', compact('plans'));
    }

    public function subscriptionPlanCreate()
    {
        return view('admin.subscription-plans.create');
    }

    public function subscriptionPlanStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        SubscriptionPlan::create($request->all());

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Plan d\'abonnement créé avec succès');
    }

    public function subscriptionPlanEdit(SubscriptionPlan $plan)
    {
        return view('admin.subscription-plans.edit', compact('plan'));
    }

    public function subscriptionPlanUpdate(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $plan->update($request->all());

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Plan d\'abonnement mis à jour avec succès');
    }

    public function orders(Request $request)
    {
        $query = Order::with(['restaurant:id,name,city', 'items:id,order_id,product_id,quantity,price']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('restaurant')) {
            $query->where('restaurant_id', $request->restaurant);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        $restaurants = cache()->remember('restaurants_for_orders', 300, function () {
            return Restaurant::select('id', 'name')->get();
        });

        return view('admin.orders.index', compact('orders', 'restaurants'));
    }

    public function orderShow(Order $order)
    {
        $order->load(['restaurant', 'items.product']);
        
        return view('admin.orders.show', compact('order'));
    }

    public function users(Request $request)
    {
        $query = User::with(['tenant:id,name,domain']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function userShow(User $user)
    {
        $user->load(['tenant', 'restaurants']);
        
        return view('admin.users.show', compact('user'));
    }

    public function reports()
    {
        // Statistiques pour les rapports avec cache
        $stats_cache_key = 'admin_reports_stats';
        $stats = cache()->remember($stats_cache_key, 600, function () {
            return [
                'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount') ?? 0,
                'total_orders' => Order::count(),
                'average_order_value' => Order::where('payment_status', 'paid')->avg('total_amount') ?? 0,
                'top_restaurant' => Restaurant::withCount('orders')->orderBy('orders_count', 'desc')->first(),
            ];
        });

        // Revenus par mois avec cache
        $monthly_revenue_cache_key = 'admin_monthly_revenue_reports';
        $monthly_revenue = cache()->remember($monthly_revenue_cache_key, 600, function () {
            return Order::where('payment_status', 'paid')
                ->where('created_at', '>=', now()->subYear())
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as revenue, COUNT(*) as orders')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        });

        // Top restaurants avec cache
        $top_restaurants_cache_key = 'admin_top_restaurants_reports';
        $top_restaurants = cache()->remember($top_restaurants_cache_key, 600, function () {
            return Restaurant::withCount('orders')
                ->withSum('orders', 'total_amount')
                ->orderBy('orders_sum_total_amount', 'desc')
                ->limit(10)
                ->get();
        });

        return view('admin.reports.index', compact('stats', 'monthly_revenue', 'top_restaurants'));
    }
} 