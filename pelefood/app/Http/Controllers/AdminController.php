<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\SubscriptionPlan;
use App\Models\Tenant;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Review;
use App\Models\Notification;
use App\Models\Promotion;
use App\Models\Invoice;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin.access']);
    }

    public function dashboard()
    {
        // Statistiques globales avancées
        $stats = [
            'total_tenants' => Tenant::count(),
            'total_restaurants' => Restaurant::count(),
            'active_restaurants' => Restaurant::where('is_active', true)->count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_reviews' => Review::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
        ];

        // Statistiques des 12 derniers mois avec plus de détails
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyStats[$month->format('M Y')] = [
                'restaurants' => Restaurant::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'orders' => Order::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'revenue' => Order::where('status', 'delivered')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('total_amount'),
                'users' => User::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
            ];
        }

        // Données pour les graphiques
        $ordersByMonth = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(total_amount) as revenue')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return [
                    'month' => $item->month,
                    'count' => $item->count,
                    'revenue' => $item->revenue ?? 0
                ];
            });

        // Restaurants récents avec plus d'informations
        $recentRestaurants = Restaurant::with(['user', 'subscriptionPlan'])
            ->withCount(['orders', 'products', 'categories'])
            ->withSum('orders', 'total_amount')
            ->latest()
            ->take(8)
            ->get();

        // Commandes récentes avec détails complets
        $recentOrders = Order::with(['restaurant', 'items', 'user'])
            ->withSum('items', 'total_price')
            ->latest()
            ->take(15)
            ->get();

        // Top restaurants par revenus et performance
        $topRestaurants = Restaurant::withCount(['orders as total_orders'])
            ->withSum('orders', 'total_amount')
            ->withCount('products')
            ->withCount('reviews')
            ->whereHas('orders', function($query) {
                $query->where('status', 'delivered');
            })
            ->orderBy('orders_sum_total_amount', 'desc')
            ->take(10)
            ->get();

        // Tenants récents
        $recentTenants = Tenant::withCount('restaurants')
            ->latest()
            ->take(6)
            ->get();

        // Plans d'abonnement avec statistiques
        $subscriptionPlans = SubscriptionPlan::withCount('restaurants')->get();

        // Statistiques des abonnements détaillées
        $subscriptionStats = [
            'trial' => Restaurant::where('subscription_status', 'trial')->count(),
            'active' => Restaurant::where('subscription_status', 'active')->count(),
            'expired' => Restaurant::where('subscription_status', 'expired')->count(),
            'cancelled' => Restaurant::where('subscription_status', 'cancelled')->count(),
            'premium' => Restaurant::whereHas('subscriptionPlan', function($q) {
                $q->where('name', 'like', '%premium%');
            })->count(),
        ];

        // Statistiques des paiements
        $paymentStats = [
            'total_payments' => Payment::count(),
            'completed_payments' => Payment::where('status', 'completed')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'total_amount' => Payment::where('status', 'completed')->sum('amount'),
        ];

        // Statistiques des produits et catégories
        $productStats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_available', true)->count(),
            'total_categories' => Category::count(),
            'products_with_images' => Product::whereNotNull('thumbnail')->count(),
        ];

        // Notifications récentes de l'utilisateur connecté (système Laravel)
        $recentNotifications = auth()->user()->notifications()
            ->latest()
            ->take(5)
            ->get();

        // Alertes système
        $systemAlerts = $this->getSystemAlerts();

        // Vérifier si c'est la route Shadcn
        if (request()->routeIs('admin.dashboard.shadcn')) {
            return view('admin.dashboard.index-shadcn', compact(
                'stats',
                'monthlyStats',
                'ordersByMonth',
                'recentRestaurants',
                'recentOrders',
                'topRestaurants',
                'recentTenants',
                'subscriptionPlans',
                'subscriptionStats',
                'paymentStats',
                'productStats',
                'recentNotifications',
                'systemAlerts'
            ));
        }

        // Vérifier si c'est la route moderne
        if (request()->routeIs('admin.dashboard.modern')) {
            return view('admin.dashboard.modern', compact(
                'stats',
                'topRestaurants',
                'recentOrders',
                'recentRestaurants'
            ));
        }

        return view('admin.dashboard.index', compact(
            'stats',
            'monthlyStats',
            'ordersByMonth',
            'recentRestaurants',
            'recentOrders',
            'topRestaurants',
            'recentTenants',
            'subscriptionPlans',
            'subscriptionStats',
            'paymentStats',
            'productStats',
            'recentNotifications',
            'systemAlerts'
        ));
    }

    private function getSystemAlerts()
    {
        $alerts = [];

        // Restaurants avec abonnement expiré
        $expiredRestaurants = Restaurant::where('subscription_status', 'expired')->count();
        if ($expiredRestaurants > 0) {
            $alerts[] = [
                'type' => 'warning',
                'message' => "{$expiredRestaurants} restaurant(s) avec abonnement expiré",
                'icon' => 'fas fa-exclamation-triangle',
                'action' => route('admin.restaurants.index')
            ];
        }

        // Commandes en attente depuis plus de 24h
        $oldPendingOrders = Order::where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subHours(24))
            ->count();
        if ($oldPendingOrders > 0) {
            $alerts[] = [
                'type' => 'danger',
                'message' => "{$oldPendingOrders} commande(s) en attente depuis plus de 24h",
                'icon' => 'fas fa-clock',
                'action' => route('admin.orders.index')
            ];
        }

        // Paiements échoués
        $failedPayments = Payment::where('status', 'failed')->count();
        if ($failedPayments > 0) {
            $alerts[] = [
                'type' => 'danger',
                'message' => "{$failedPayments} paiement(s) échoué(s)",
                'icon' => 'fas fa-credit-card',
                'action' => route('admin.payments.index')
            ];
        }

        // Restaurants sans produits
        $restaurantsWithoutProducts = Restaurant::whereDoesntHave('products')->count();
        if ($restaurantsWithoutProducts > 0) {
            $alerts[] = [
                'type' => 'info',
                'message' => "{$restaurantsWithoutProducts} restaurant(s) sans produits",
                'icon' => 'fas fa-info-circle',
                'action' => route('admin.restaurants.index')
            ];
        }

        return $alerts;
    }

    public function modernDashboard()
    {
        // Statistiques pour le dashboard moderne
        $stats = [
            'total_restaurants' => \App\Models\Restaurant::count(),
            'active_restaurants' => \App\Models\Restaurant::where('is_active', true)->count(),
            'total_users' => \App\Models\User::count(),
            'active_users' => \App\Models\User::where('is_active', true)->count(),
            'total_orders' => \App\Models\Order::count(),
            'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            'completed_orders' => \App\Models\Order::where('status', 'delivered')->count(),
            'total_revenue' => \App\Models\Order::where('status', 'delivered')->sum('total_amount'),
            'today_revenue' => \App\Models\Order::where('status', 'delivered')
                ->whereDate('created_at', today())
                ->sum('total_amount'),
            'total_products' => \App\Models\Product::count(),
            'active_products' => \App\Models\Product::where('is_available', true)->count(),
        ];

        // Top restaurants avec statistiques
        $topRestaurants = \App\Models\Restaurant::withSum('orders', 'total_amount')
            ->withCount('orders')
            ->whereHas('orders', function($query) {
                $query->where('status', 'delivered');
            })
            ->orderBy('orders_sum_total_amount', 'desc')
            ->take(5)
            ->get();

        // Commandes récentes
        $recentOrders = \App\Models\Order::with(['restaurant', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Restaurants récents
        $recentRestaurants = \App\Models\Restaurant::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.modern', compact(
            'stats',
            'topRestaurants',
            'recentOrders',
            'recentRestaurants'
        ));
    }

    public function restaurants()
    {
        $restaurants = Restaurant::with(['user', 'subscriptionPlan'])
            ->withCount(['orders', 'products', 'categories'])
            ->withSum('orders', 'total_amount')
            ->latest()
            ->paginate(20);

        // Vérifier si c'est la route new-design
        if (request()->routeIs('admin.restaurants.new-design')) {
            return view('admin.restaurants.index-new-design', compact('restaurants'));
        }

        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function users()
    {
        $users = User::with(['restaurant', 'tenant'])
            ->withCount(['orders'])
            ->latest()
            ->paginate(20);

        // Vérifier si c'est la route Shadcn
        if (request()->routeIs('admin.users.shadcn')) {
            return view('admin.users.index-shadcn', compact('users'));
        }

        // Vérifier si c'est la route new-design
        if (request()->routeIs('admin.users.new-design')) {
            return view('admin.users.index-new-design', compact('users'));
        }

        return view('admin.users.index', compact('users'));
    }

    public function subscriptionPlans()
    {
        $plans = SubscriptionPlan::withCount(['restaurants'])
            ->latest()
            ->get();

        return view('admin.subscription-plans.index', compact('plans'));
    }

    // CRUD Plans d'Abonnement
    public function createSubscriptionPlan()
    {
        return view('admin.subscription-plans.create');
    }

    public function storeSubscriptionPlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_restaurants' => 'nullable|integer|min:1',
            'max_products' => 'nullable|integer|min:1',
            'max_orders_per_month' => 'nullable|integer|min:1',
            'features' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        SubscriptionPlan::create($request->all());

        return redirect()->route('admin.subscription-plans')
            ->with('success', 'Plan d\'abonnement créé avec succès.');
    }

    public function editSubscriptionPlan(SubscriptionPlan $plan)
    {
        return view('admin.subscription-plans.edit', compact('plan'));
    }

    public function updateSubscriptionPlan(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_restaurants' => 'nullable|integer|min:1',
            'max_products' => 'nullable|integer|min:1',
            'max_orders_per_month' => 'nullable|integer|min:1',
            'features' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        $plan->update($request->all());

        return redirect()->route('admin.subscription-plans')
            ->with('success', 'Plan d\'abonnement mis à jour avec succès.');
    }

    public function destroySubscriptionPlan(SubscriptionPlan $plan)
    {
        if ($plan->restaurants()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce plan car des restaurants y sont abonnés.');
        }

        $plan->delete();

        return redirect()->route('admin.subscription-plans')
            ->with('success', 'Plan d\'abonnement supprimé avec succès.');
    }

    // CRUD Restaurants
    public function createRestaurant()
    {
        $users = User::whereDoesntHave('restaurant')->get();
        $subscriptionPlans = SubscriptionPlan::where('is_active', true)->get();
        
        return view('admin.restaurants.create', compact('users', 'subscriptionPlans'));
    }

    public function storeRestaurant(Request $request)
    {
        \Log::info('Tentative de création de restaurant', $request->all());
        
        try {
            // Validation de base
            $baseValidation = [
            'name' => 'required|string|max:255',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'address' => 'required|string',
            'city' => 'required|string',
                'country' => 'required|string|max:2',
            'phone' => 'required|string',
            'email' => 'required|email',
            'description' => 'nullable|string',
                'is_active' => 'boolean',
                'create_new_user' => 'boolean',
                'website' => 'nullable|url',
                'delivery_available' => 'boolean',
                'takeaway_available' => 'boolean',
                'delivery_fee' => 'nullable|numeric|min:0',
                'min_order_amount' => 'nullable|numeric|min:0',
                'opening_time' => 'nullable|date_format:H:i',
                'closing_time' => 'nullable|date_format:H:i',
                'working_days' => 'nullable|string'
            ];

            // Ajouter la validation conditionnelle
            if ($request->create_new_user == '1' || $request->create_new_user === true) {
                $baseValidation['user_name'] = 'required|string|max:255';
                $baseValidation['user_email'] = 'required|email|unique:users,email';
                $baseValidation['user_password'] = 'required|string|min:8';
                $baseValidation['user_phone'] = 'nullable|string';
            } else {
                $baseValidation['user_id'] = 'required|exists:users,id';
            }

            $request->validate($baseValidation);

        $user = null;

        // Créer un nouvel utilisateur si demandé
        if ($request->create_new_user == '1' || $request->create_new_user === true) {
            $user = User::create([
                'name' => $request->user_name,
                'email' => $request->user_email,
                'phone' => $request->user_phone,
                'password' => bcrypt($request->user_password),
                'email_verified_at' => now(),
            ]);

            // Assigner le rôle restaurant
            $user->update(['role' => 'restaurant']);
        } else {
            // Utiliser l'utilisateur existant
        $user = User::find($request->user_id);
        $user->update(['role' => 'restaurant']);
        }

        // Créer le restaurant
        $restaurantData = $request->only([
            'name', 'email', 'phone', 'address', 'city', 'country', 'description',
            'subscription_plan_id', 'is_active', 'website', 'delivery_available',
            'takeaway_available', 'delivery_fee', 'min_order_amount',
            'opening_time', 'closing_time', 'working_days'
        ]);
        
        $restaurantData['user_id'] = $user->id;
        $restaurant = Restaurant::create($restaurantData);

        // Envoyer un email avec les identifiants si nouvel utilisateur
        if ($request->create_new_user == '1' || $request->create_new_user === true) {
            try {
                \Mail::to($user->email)->send(new \App\Mail\RestaurantAccountCreated($user, $restaurant, $request->user_password));
            } catch (\Exception $e) {
                // Log l'erreur mais ne pas faire échouer la création
                \Log::error('Erreur envoi email restaurant: ' . $e->getMessage());
            }
        }

            return redirect()->route('admin.restaurants.index')
                ->with('success', 'Restaurant créé avec succès. ' . 
                    (($request->create_new_user == '1' || $request->create_new_user === true) ? 'Un compte utilisateur a été créé et les identifiants ont été envoyés par email.' : ''));
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du restaurant: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du restaurant: ' . $e->getMessage());
        }
    }

    public function showRestaurant(Restaurant $restaurant)
    {
        $restaurant->load(['user', 'subscriptionPlan', 'orders', 'products', 'categories']);
        
        return view('admin.restaurants.show', compact('restaurant'));
    }

    public function editRestaurant(Restaurant $restaurant)
    {
        $users = User::all();
        $plans = SubscriptionPlan::all();
        
        return view('admin.restaurants.edit', compact('restaurant', 'users', 'plans'));
    }

    public function updateRestaurant(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'address' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $restaurant->update($request->all());

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant mis à jour avec succès.');
    }

    public function destroyRestaurant(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant supprimé avec succès.');
    }

    // CRUD Utilisateurs
    public function createUser()
    {
        $roles = [
            'admin' => 'Administrateur',
            'super_admin' => 'Super Administrateur',
            'restaurant' => 'Restaurant',
            'customer' => 'Client',
            'driver' => 'Livreur'
        ];
        
        return view('admin.users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,super_admin,restaurant,customer,driver'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function showUser(User $user)
    {
        $user->load(['restaurant', 'tenant', 'orders']);
        
        return view('admin.users.show', compact('user'));
    }

    public function editUser(User $user)
    {
        $roles = [
            'admin' => 'Administrateur',
            'super_admin' => 'Super Administrateur',
            'restaurant' => 'Restaurant',
            'customer' => 'Client',
            'driver' => 'Livreur'
        ];
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,super_admin,restaurant,customer,driver'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    // ===== GESTION DES TENANTS =====
    
    public function tenants()
    {
        $tenants = \App\Models\Tenant::withCount('restaurants')
            ->latest()
            ->paginate(20);
            
        $totalTenants = \App\Models\Tenant::count();
        $activeTenants = \App\Models\Tenant::where('is_active', true)->count();
        $inactiveTenants = \App\Models\Tenant::where('is_active', false)->count();
        
        return view('admin.tenants.index', compact('tenants', 'totalTenants', 'activeTenants', 'inactiveTenants'));
    }
    
    public function createTenant()
    {
        return view('admin.tenants.create');
    }
    
    public function storeTenant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);
        
        \App\Models\Tenant::create($request->all());
        
        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant créé avec succès.');
    }
    
    public function editTenant(\App\Models\Tenant $tenant)
    {
        return view('admin.tenants.edit', compact('tenant'));
    }
    
    public function updateTenant(Request $request, \App\Models\Tenant $tenant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email,' . $tenant->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);
        
        $tenant->update($request->all());
        
        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant mis à jour avec succès.');
    }
    
    public function destroyTenant(\App\Models\Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant supprimé avec succès.');
    }

    // ===== PHASE 2: SYSTÈME DE PAIEMENTS =====
    
    // Gestion des Paiements
    public function payments()
    {
        $payments = \App\Models\Payment::with(['restaurant', 'user'])
            ->latest()
            ->paginate(20);

        $totalRevenue = \App\Models\Payment::where('status', 'completed')->sum('amount');
        $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
        $failedPayments = \App\Models\Payment::where('status', 'failed')->count();

        // Vérifier si c'est la route new-design
        if (request()->routeIs('admin.payments.new-design')) {
            return view('admin.payments.index-new-design', compact('payments', 'totalRevenue', 'pendingPayments', 'failedPayments'));
        }

        return view('admin.payments.index', compact('payments', 'totalRevenue', 'pendingPayments', 'failedPayments'));
    }

    public function createPayment()
    {
        $restaurants = \App\Models\Restaurant::where('is_active', true)->get();
        $users = \App\Models\User::all();
        
        return view('admin.payments.create', compact('restaurants', 'users'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed,failed,cancelled'
        ]);

        \App\Models\Payment::create($request->all());

        return redirect()->route('admin.payments.index')
            ->with('success', 'Paiement créé avec succès.');
    }

    public function editPayment(\App\Models\Payment $payment)
    {
        $restaurants = \App\Models\Restaurant::all();
        $users = \App\Models\User::all();
        
        return view('admin.payments.edit', compact('payment', 'restaurants', 'users'));
    }

    public function updatePayment(Request $request, \App\Models\Payment $payment)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed,failed,cancelled'
        ]);

        $payment->update($request->all());

        return redirect()->route('admin.payments.index')
            ->with('success', 'Paiement mis à jour avec succès.');
    }

    public function destroyPayment(\App\Models\Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Paiement supprimé avec succès.');
    }

    // ===== GESTION DES PASSERELLES DE PAIEMENT =====
    
    /**
     * Afficher la liste des passerelles de paiement
     */
    public function paymentGateways()
    {
        $gateways = \App\Models\PaymentGateway::orderBy('name')->paginate(15);
        
        return view('admin.payment-gateways.index', compact('gateways'));
    }

    /**
     * Afficher le formulaire de création d'une passerelle
     */
    public function createPaymentGateway()
    {
        $providers = [
            'wave' => 'Wave',
            'paystack' => 'Paystack',
            'flutterwave' => 'Flutterwave',
            'orange_money' => 'Orange Money',
            'mtn_momo' => 'MTN Mobile Money',
            'moov_money' => 'Moov Money',
            'cinetpay' => 'CinetPay',
            'cash' => 'Paiement en Espèces',
        ];

        return view('admin.payment-gateways.create', compact('providers'));
    }

    /**
     * Enregistrer une nouvelle passerelle
     */
    public function storePaymentGateway(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|string|max:50|unique:payment_gateways,provider',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'test_mode' => 'boolean',
            'fees_percentage' => 'required|numeric|min:0|max:100',
            'fees_fixed' => 'required|numeric|min:0',
            'api_key' => 'nullable|string',
            'secret_key' => 'nullable|string',
            'webhook_url' => 'nullable|url',
        ]);

        \App\Models\PaymentGateway::create([
            'name' => $request->name,
            'provider' => $request->provider,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'test_mode' => $request->has('test_mode'),
            'fees_percentage' => $request->fees_percentage,
            'fees_fixed' => $request->fees_fixed,
            'credentials' => [
                'api_key' => $request->api_key,
                'secret_key' => $request->secret_key,
            ],
            'webhook_url' => $request->webhook_url,
        ]);

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Passerelle de paiement créée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function editPaymentGateway(\App\Models\PaymentGateway $paymentGateway)
    {
        $providers = [
            'wave' => 'Wave',
            'paystack' => 'Paystack',
            'flutterwave' => 'Flutterwave',
            'orange_money' => 'Orange Money',
            'mtn_momo' => 'MTN Mobile Money',
            'moov_money' => 'Moov Money',
            'cinetpay' => 'CinetPay',
            'cash' => 'Paiement en Espèces',
        ];

        return view('admin.payment-gateways.edit', compact('paymentGateway', 'providers'));
    }

    /**
     * Mettre à jour une passerelle
     */
    public function updatePaymentGateway(Request $request, \App\Models\PaymentGateway $paymentGateway)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|string|max:50|unique:payment_gateways,provider,' . $paymentGateway->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'test_mode' => 'boolean',
            'fees_percentage' => 'required|numeric|min:0|max:100',
            'fees_fixed' => $request->fees_fixed,
            'api_key' => 'nullable|string',
            'secret_key' => 'nullable|string',
            'webhook_url' => 'nullable|url',
        ]);

        $paymentGateway->update([
            'name' => $request->name,
            'provider' => $request->provider,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'test_mode' => $request->has('test_mode'),
            'fees_percentage' => $request->fees_percentage,
            'fees_fixed' => $request->fees_fixed,
            'credentials' => [
                'api_key' => $request->api_key,
                'secret_key' => $request->secret_key,
            ],
            'webhook_url' => $request->webhook_url,
        ]);

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Passerelle de paiement mise à jour avec succès.');
    }

    /**
     * Supprimer une passerelle
     */
    public function destroyPaymentGateway(\App\Models\PaymentGateway $paymentGateway)
    {
        $paymentGateway->delete();

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Passerelle de paiement supprimée avec succès.');
    }


    // Gestion des Factures
    public function invoices()
    {
        $invoices = \App\Models\Invoice::with(['restaurant', 'user'])
            ->latest()
            ->paginate(20);

        $totalInvoiced = \App\Models\Invoice::sum('total_amount');
        $paidInvoices = \App\Models\Invoice::where('status', 'paid')->count();
        $pendingInvoices = \App\Models\Invoice::where('status', 'pending')->count();

        return view('admin.invoices.index', compact('invoices', 'totalInvoiced', 'paidInvoices', 'pendingInvoices'));
    }

    public function createInvoice()
    {
        $restaurants = \App\Models\Restaurant::where('is_active', true)->get();
        $users = \App\Models\User::all();
        $subscriptionPlans = \App\Models\SubscriptionPlan::all();
        
        return view('admin.invoices.create', compact('restaurants', 'users', 'subscriptionPlans'));
    }

    public function storeInvoice(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'user_id' => 'required|exists:users,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'total_amount' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:draft,pending,paid,overdue,cancelled'
        ]);

        \App\Models\Invoice::create($request->all());

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Facture créée avec succès.');
    }

    public function editInvoice(\App\Models\Invoice $invoice)
    {
        $restaurants = \App\Models\Restaurant::all();
        $users = \App\Models\User::all();
        $subscriptionPlans = \App\Models\SubscriptionPlan::all();
        
        return view('admin.invoices.edit', compact('invoice', 'restaurants', 'users', 'subscriptionPlans'));
    }

    public function updateInvoice(Request $request, \App\Models\Invoice $invoice)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'user_id' => 'required|exists:users,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'total_amount' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:draft,pending,paid,overdue,cancelled'
        ]);

        $invoice->update($request->all());

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Facture mise à jour avec succès.');
    }

    public function destroyInvoice(\App\Models\Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Facture supprimée avec succès.');
    }

    // Gestion des Catégories Globales
    public function categories()
    {
        $categories = \App\Models\Category::with(['restaurant'])
            ->withCount('products')
            ->latest()
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        $restaurants = \App\Models\Restaurant::where('is_active', true)->get();
        return view('admin.categories.create', compact('restaurants'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'restaurant_id' => 'required|exists:restaurants,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = new \App\Models\Category($request->only(['name', 'description', 'restaurant_id']));
        
        if ($request->hasFile('image')) {
            $category->image_url = $request->file('image')->store('categories', 'public');
        }
        
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function editCategory(\App\Models\Category $category)
    {
        $restaurants = \App\Models\Restaurant::where('is_active', true)->get();
        return view('admin.categories.edit', compact('category', 'restaurants'));
    }

    public function updateCategory(Request $request, \App\Models\Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'restaurant_id' => 'required|exists:restaurants,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category->fill($request->only(['name', 'description', 'restaurant_id']));
        
        if ($request->hasFile('image')) {
            if ($category->image_url) {
                \Storage::disk('public')->delete($category->image_url);
            }
            $category->image_url = $request->file('image')->store('categories', 'public');
        }
        
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroyCategory(\App\Models\Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Impossible de supprimer cette catégorie car elle contient des produits.');
        }

        if ($category->image_url) {
            \Storage::disk('public')->delete($category->image_url);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }

    // Gestion des Commandes Globales
    public function orders()
    {
        $orders = \App\Models\Order::with(['restaurant', 'user'])
            ->latest()
            ->paginate(20);

        $totalOrders = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
        $completedOrders = \App\Models\Order::where('status', 'delivered')->count();
        $totalRevenue = \App\Models\Order::where('status', 'delivered')->sum('total_amount');

        // Vérifier si c'est la route new-design
        if (request()->routeIs('admin.orders.new-design')) {
            return view('admin.orders.index-new-design', compact('orders', 'totalOrders', 'pendingOrders', 'completedOrders', 'totalRevenue'));
        }

        return view('admin.orders.index', compact('orders', 'totalOrders', 'pendingOrders', 'completedOrders', 'totalRevenue'));
    }

    public function showOrder(\App\Models\Order $order)
    {
        $order->load(['restaurant', 'user', 'orderItems.product']);
        
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Statut de la commande mis à jour.');
    }

    public function editOrder(Order $order)
    {
        $order->load(['restaurant', 'user', 'orderItems.product']);
        
        $statuses = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmée',
            'preparing' => 'En préparation',
            'ready' => 'Prête',
            'out_for_delivery' => 'En livraison',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée'
        ];

        $paymentStatuses = [
            'pending' => 'En attente',
            'paid' => 'Payée',
            'failed' => 'Échouée',
            'refunded' => 'Remboursée'
        ];

        return view('admin.orders.edit', compact('order', 'statuses', 'paymentStatuses'));
    }

    public function updateOrder(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,out_for_delivery,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'delivery_address' => 'required|array',
            'delivery_address.address' => 'required|string',
            'delivery_address.city' => 'required|string',
            'special_instructions' => 'nullable|string',
            'estimated_delivery_time' => 'nullable|date',
            'cancellation_reason' => 'nullable|string|required_if:status,cancelled'
        ]);

        $orderData = $request->only([
            'status', 'payment_status', 'customer_name', 'customer_phone', 
            'customer_email', 'delivery_address', 'special_instructions',
            'estimated_delivery_time', 'cancellation_reason'
        ]);

        // Si la commande est annulée, ajouter la date d'annulation
        if ($request->status === 'cancelled') {
            $orderData['cancelled_at'] = now();
        } else {
            $orderData['cancelled_at'] = null;
        }

        $order->update($orderData);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Commande mise à jour avec succès.');
    }

    public function destroyOrder(Order $order)
    {
        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Commande supprimée avec succès.');
    }

    // ===== GESTION GLOBALE DES PRODUITS =====
    
    public function products()
    {
        $products = Product::with(['restaurant', 'category', 'orderItems'])
            ->withCount('orderItems')
            ->withSum('orderItems', 'quantity')
            ->latest()
            ->paginate(20);

        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_available', true)->count(),
            'featured_products' => Product::where('is_featured', true)->count(),
            'total_restaurants' => Restaurant::count(),
            'total_categories' => Category::count(),
        ];

        return view('admin.products.index', compact('products', 'stats'));
    }

    public function showProduct(Product $product)
    {
        $product->load(['restaurant', 'category', 'orderItems.order']);
        
        $stats = [
            'total_orders' => $product->orderItems->count(),
            'total_quantity_sold' => $product->orderItems->sum('quantity'),
            'total_revenue' => $product->orderItems->sum(function($item) {
                return $item->quantity * $item->price;
            }),
            'average_rating' => $product->reviews()->avg('rating') ?? 0,
        ];

        return view('admin.products.show', compact('product', 'stats'));
    }

    public function updateProductStatus(Request $request, Product $product)
    {
        $request->validate([
            'is_available' => 'required|boolean'
        ]);

        $product->update(['is_available' => $request->is_available]);

        $status = $request->is_available ? 'activé' : 'désactivé';
        return response()->json([
            'success' => true,
            'message' => "Produit {$status} avec succès"
        ]);
    }

    public function toggleProductFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);
        
        $status = $product->is_featured ? 'mis en vedette' : 'retiré de la vedette';
        return response()->json([
            'success' => true,
            'message' => "Produit {$status} avec succès"
        ]);
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès');
    }

    public function exportProducts(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        $products = Product::with(['restaurant', 'category'])
            ->get()
            ->map(function($product) {
                return [
                    'ID' => $product->id,
                    'Nom' => $product->name,
                    'Restaurant' => $product->restaurant->name,
                    'Catégorie' => $product->category->name ?? 'Aucune',
                    'Prix' => $product->price,
                    'Statut' => $product->is_available ? 'Actif' : 'Inactif',
                    'Vedette' => $product->is_featured ? 'Oui' : 'Non',
                    'Créé le' => $product->created_at->format('d/m/Y H:i'),
                ];
            });

        if ($format === 'csv') {
            $filename = 'produits_' . now()->format('Y-m-d_H-i-s') . '.csv';
            
            $callback = function() use ($products) {
                $file = fopen('php://output', 'w');
                fputcsv($file, array_keys($products->first()));
                foreach ($products as $product) {
                    fputcsv($file, $product);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        return response()->json($products);
    }

    // ===== PHASE 3: ANALYTICS ET RAPPORTS =====
    

    // Rapports Exportables
    public function reports()
    {
        // Statistiques pour les rapports
        $stats = [
            'total_tenants' => \App\Models\Tenant::count(),
            'total_restaurants' => \App\Models\Restaurant::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_revenue' => \App\Models\Order::where('status', 'delivered')->sum('total_amount') ?? 0,
        ];
        
        // Données pour les graphiques
        $reports = [
            'orders_by_month' => \App\Models\Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->toArray(),
            'revenue_trends' => \App\Models\Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date, SUM(total_amount) as revenue')
                ->where('status', 'delivered')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->toArray(),
        ];
        
        // Vérifier si c'est la route new-design
        if (request()->routeIs('admin.reports.new-design')) {
            return view('admin.reports.index-new-design', compact('stats', 'reports'));
        }
        
        return view('admin.reports.index', compact('stats', 'reports'));
    }

    public function ordersReport()
    {
        // Statistiques des commandes
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
        ];

        // Commandes récentes
        $recentOrders = Order::with(['restaurant', 'user'])
            ->latest()
            ->paginate(20);

        // Commandes par statut
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Commandes par mois (12 derniers mois)
        $monthlyOrders = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyOrders[$date->format('M Y')] = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Revenus par mois
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyRevenue[$date->format('M Y')] = Order::where('status', 'delivered')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount');
        }

        // Top restaurants par commandes
        $topRestaurants = Restaurant::withCount('orders')
            ->withSum('orders', 'total_amount')
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.orders', compact(
            'stats',
            'recentOrders',
            'ordersByStatus',
            'monthlyOrders',
            'monthlyRevenue',
            'topRestaurants'
        ));
    }

    public function revenueReport()
    {
        // Statistiques des revenus
        $stats = [
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'monthly_revenue' => Order::where('status', 'delivered')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount'),
            'daily_revenue' => Order::where('status', 'delivered')
                ->whereDate('created_at', now())
                ->sum('total_amount'),
            'average_order_value' => Order::where('status', 'delivered')->avg('total_amount'),
            'total_orders' => Order::where('status', 'delivered')->count(),
        ];

        // Revenus par mois (12 derniers mois)
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyRevenue[$date->format('M Y')] = Order::where('status', 'delivered')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount');
        }

        // Revenus par jour (30 derniers jours)
        $dailyRevenue = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyRevenue[$date->format('d/m')] = Order::where('status', 'delivered')
                ->whereDate('created_at', $date)
                ->sum('total_amount');
        }

        // Revenus par restaurant
        $revenueByRestaurant = Restaurant::withCount('orders')
            ->withSum(['orders' => function($query) {
                $query->where('status', 'delivered');
            }], 'total_amount')
            ->whereHas('orders', function($query) {
                $query->where('status', 'delivered');
            })
            ->orderBy('orders_sum_total_amount', 'desc')
            ->limit(10)
            ->get();

        // Revenus par statut de commande
        $revenueByStatus = Order::selectRaw('status, SUM(total_amount) as revenue, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('revenue', 'status')
            ->toArray();

        // Tendances de revenus (comparaison avec mois précédent)
        $currentMonthRevenue = Order::where('status', 'delivered')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $previousMonthRevenue = Order::where('status', 'delivered')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');

        $revenueGrowth = $previousMonthRevenue > 0 
            ? (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100 
            : 0;

        return view('admin.reports.revenue', compact(
            'stats',
            'monthlyRevenue',
            'dailyRevenue',
            'revenueByRestaurant',
            'revenueByStatus',
            'revenueGrowth'
        ));
    }

    public function restaurantsReport()
    {
        // Statistiques des restaurants
        $stats = [
            'total_restaurants' => Restaurant::count(),
            'active_restaurants' => Restaurant::where('is_active', true)->count(),
            'verified_restaurants' => Restaurant::where('is_verified', true)->count(),
            'featured_restaurants' => Restaurant::where('is_featured', true)->count(),
            'restaurants_with_orders' => Restaurant::whereHas('orders')->count(),
        ];

        // Restaurants récents
        $recentRestaurants = Restaurant::with(['user', 'subscriptionPlan'])
            ->withCount(['orders', 'products', 'reviews'])
            ->withSum('orders', 'total_amount')
            ->latest()
            ->paginate(20);

        // Restaurants par statut d'abonnement
        $restaurantsBySubscription = Restaurant::selectRaw('subscription_status, COUNT(*) as count')
            ->groupBy('subscription_status')
            ->pluck('count', 'subscription_status')
            ->toArray();

        // Restaurants par ville
        $restaurantsByCity = Restaurant::selectRaw('city, COUNT(*) as count')
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->pluck('count', 'city')
            ->toArray();

        // Top restaurants par commandes
        $topRestaurantsByOrders = Restaurant::withCount('orders')
            ->withSum('orders', 'total_amount')
            ->whereHas('orders')
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();

        // Top restaurants par revenus
        $topRestaurantsByRevenue = Restaurant::withCount('orders')
            ->withSum(['orders' => function($query) {
                $query->where('status', 'delivered');
            }], 'total_amount')
            ->whereHas('orders', function($query) {
                $query->where('status', 'delivered');
            })
            ->orderBy('orders_sum_total_amount', 'desc')
            ->limit(10)
            ->get();

        // Restaurants sans commandes
        $restaurantsWithoutOrders = Restaurant::whereDoesntHave('orders')->count();

        // Restaurants sans produits
        $restaurantsWithoutProducts = Restaurant::whereDoesntHave('products')->count();

        return view('admin.reports.restaurants', compact(
            'stats',
            'recentRestaurants',
            'restaurantsBySubscription',
            'restaurantsByCity',
            'topRestaurantsByOrders',
            'topRestaurantsByRevenue',
            'restaurantsWithoutOrders',
            'restaurantsWithoutProducts'
        ));
    }

    public function exportReport(Request $request)
    {
        $type = $request->get('type', 'orders');
        $format = $request->get('format', 'csv');
        
        switch ($type) {
            case 'orders':
                return $this->exportOrdersReport();
            case 'revenue':
                return $this->exportRevenueReport();
            case 'restaurants':
                return $this->exportRestaurantsReport();
            case 'analytics':
                return $this->exportAnalyticsReport();
            default:
                return redirect()->route('admin.reports.index')
                    ->with('error', 'Type de rapport non valide.');
        }
    }

    public function exportRevenueReport()
    {
        // Revenus par mois (12 derniers mois)
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyRevenue[] = [
                'Mois' => $date->format('M Y'),
                'Revenus' => Order::where('status', 'delivered')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('total_amount'),
                'Commandes' => Order::where('status', 'delivered')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }

        $filename = 'revenus_rapport_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($monthlyRevenue) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, ['Mois', 'Revenus (FCFA)', 'Nombre de Commandes']);
            
            // Données
            foreach ($monthlyRevenue as $data) {
                fputcsv($file, [
                    $data['Mois'],
                    number_format($data['Revenus'], 0, ',', ' '),
                    $data['Commandes']
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportAnalyticsReport()
    {
        // Statistiques générales
        $stats = [
            'total_restaurants' => Restaurant::count(),
            'active_restaurants' => Restaurant::where('is_active', true)->count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'average_order_value' => Order::where('status', 'delivered')->avg('total_amount'),
        ];

        // Revenus mensuels (6 derniers mois)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyRevenue[] = [
                'Mois' => $date->format('M Y'),
                'Revenus' => Order::where('status', 'delivered')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('total_amount'),
                'Commandes' => Order::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'Restaurants' => Restaurant::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }

        $filename = 'analytics_rapport_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($stats, $monthlyRevenue) {
            $file = fopen('php://output', 'w');
            
            // Statistiques générales
            fputcsv($file, ['Métrique', 'Valeur']);
            fputcsv($file, ['Total Restaurants', $stats['total_restaurants']]);
            fputcsv($file, ['Restaurants Actifs', $stats['active_restaurants']]);
            fputcsv($file, ['Total Utilisateurs', $stats['total_users']]);
            fputcsv($file, ['Total Commandes', $stats['total_orders']]);
            fputcsv($file, ['Revenus Totaux (FCFA)', number_format($stats['total_revenue'], 0, ',', ' ')]);
            fputcsv($file, ['Panier Moyen (FCFA)', number_format($stats['average_order_value'], 0, ',', ' ')]);
            fputcsv($file, []);
            
            // Revenus mensuels
            fputcsv($file, ['Mois', 'Revenus (FCFA)', 'Commandes', 'Nouveaux Restaurants']);
            foreach ($monthlyRevenue as $data) {
                fputcsv($file, [
                    $data['Mois'],
                    number_format($data['Revenus'], 0, ',', ' '),
                    $data['Commandes'],
                    $data['Restaurants']
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportRestaurantsReport()
    {
        $restaurants = \App\Models\Restaurant::with(['user', 'subscriptionPlan'])
            ->get();
        
        $filename = 'restaurants_report_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($restaurants) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Nom', 'Email', 'Téléphone', 'Adresse', 'Ville',
                'Statut', 'Plan d\'Abonnement', 'Date de Création'
            ]);
            
            // Données
            foreach ($restaurants as $restaurant) {
                fputcsv($file, [
                    $restaurant->id,
                    $restaurant->name,
                    $restaurant->email,
                    $restaurant->phone,
                    $restaurant->address,
                    $restaurant->city,
                    $restaurant->is_active ? 'Actif' : 'Inactif',
                    $restaurant->subscriptionPlan ? $restaurant->subscriptionPlan->name : 'Aucun',
                    $restaurant->created_at->format('d/m/Y')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportOrdersReport()
    {
        $orders = \App\Models\Order::with(['restaurant', 'user'])
            ->latest()
            ->get();
        
        $filename = 'orders_report_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Restaurant', 'Client', 'Montant Total', 'Statut',
                'Méthode de Livraison', 'Date de Commande'
            ]);
            
            // Données
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->restaurant ? $order->restaurant->name : 'N/A',
                    $order->customer_name,
                    number_format($order->total_amount, 0, ',', ' ') . ' FCFA',
                    ucfirst($order->status),
                    $order->delivery_method,
                    $order->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    // Gestion des Promotions
    public function promotions()
    {
        $promotions = \App\Models\Promotion::with(['restaurant'])
            ->latest()
            ->paginate(20);
        
        $totalPromotions = \App\Models\Promotion::count();
        $activePromotions = \App\Models\Promotion::where('is_active', true)->count();
        $expiredPromotions = \App\Models\Promotion::where('expires_at', '<', now())->count();
        
        return view('admin.promotions.index', compact('promotions', 'totalPromotions', 'activePromotions', 'expiredPromotions'));
    }

    public function createPromotion()
    {
        $restaurants = \App\Models\Restaurant::where('is_active', true)->get();
        
        return view('admin.promotions.create', compact('restaurants'));
    }

    public function storePromotion(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'code' => 'required|string|unique:promotions,code',
            'description' => 'required|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'required|date|after:now',
            'is_active' => 'boolean'
        ]);

        \App\Models\Promotion::create($request->all());

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion créée avec succès.');
    }

    public function editPromotion(\App\Models\Promotion $promotion)
    {
        $restaurants = \App\Models\Restaurant::all();
        
        return view('admin.promotions.edit', compact('promotion', 'restaurants'));
    }

    public function updatePromotion(Request $request, \App\Models\Promotion $promotion)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'code' => 'required|string|unique:promotions,code,' . $promotion->id,
            'description' => 'required|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'required|date',
            'is_active' => 'boolean'
        ]);

        $promotion->update($request->all());

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion mise à jour avec succès.');
    }

    public function destroyPromotion(\App\Models\Promotion $promotion)
    {
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion supprimée avec succès.');
    }

    // Gestion des Avis et Reviews
    public function reviews()
    {
        $reviews = \App\Models\Review::with(['restaurant', 'order'])
            ->latest()
            ->paginate(20);
        
        $totalReviews = \App\Models\Review::count();
        $averageRating = \App\Models\Review::avg('rating');
        $positiveReviews = \App\Models\Review::where('rating', '>=', 4)->count();
        $negativeReviews = \App\Models\Review::where('rating', '<=', 2)->count();
        
        return view('admin.reviews.index', compact('reviews', 'totalReviews', 'averageRating', 'positiveReviews', 'negativeReviews'));
    }

    public function showReview(\App\Models\Review $review)
    {
        $review->load(['restaurant', 'order', 'order.orderItems.product']);
        
        return view('admin.reviews.show', compact('review'));
    }

    public function updateReviewStatus(Request $request, \App\Models\Review $review)
    {
        $request->validate([
            'status' => 'required|in:approved,pending,rejected'
        ]);

        $review->update(['status' => $request->status]);

        return redirect()->route('admin.reviews.show', $review)
            ->with('success', 'Statut de l\'avis mis à jour.');
    }

    // Gestion des Notifications
    public function notifications()
    {
        $notifications = \App\Models\Notification::with(['user'])
            ->latest()
            ->paginate(20);

        $totalNotifications = \App\Models\Notification::count();
        $unreadNotifications = \App\Models\Notification::where('is_read', false)->count();
        
        return view('admin.notifications.index', compact('notifications', 'totalNotifications', 'unreadNotifications'));
    }

    public function markNotificationAsRead(\App\Models\Notification $notification)
    {
        $notification->markAsRead();

        return back()->with('success', 'Notification marquée comme lue.');
    }

    public function markNotificationAsUnread(\App\Models\Notification $notification)
    {
        $notification->update(['read_at' => null]);

        return back()->with('success', 'Notification marquée comme non lue.');
    }

    public function markAllNotificationsAsRead()
    {
        \App\Models\Notification::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    public function createNotification()
    {
        $users = \App\Models\User::all();
        $restaurants = \App\Models\Restaurant::all();
        $tenants = \App\Models\Tenant::all();
        
        return view('admin.notifications.create', compact('users', 'restaurants', 'tenants'));
    }

    public function storeNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success,error',
            'notifiable_type' => 'required|in:App\Models\User,App\Models\Restaurant',
            'notifiable_id' => 'required|integer',
            'data' => 'nullable|array'
        ]);

        $notification = \App\Models\Notification::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'App\Notifications\AdminNotification',
            'notifiable_type' => $request->notifiable_type,
            'notifiable_id' => $request->notifiable_id,
            'data' => [
                'title' => $request->title,
                'message' => $request->message,
                'type' => $request->type,
                'data' => $request->data ?? []
            ]
        ]);

        return redirect()->route('admin.notifications')
            ->with('success', 'Notification créée avec succès.');
    }

    public function showNotification(\App\Models\Notification $notification)
    {
        $notification->load('notifiable');
        
        return view('admin.notifications.show', compact('notification'));
    }

    public function editNotification(\App\Models\Notification $notification)
    {
        $users = \App\Models\User::all();
        $restaurants = \App\Models\Restaurant::all();
        $tenants = \App\Models\Tenant::all();
        
        return view('admin.notifications.edit', compact('notification', 'users', 'restaurants', 'tenants'));
    }

    public function updateNotification(Request $request, \App\Models\Notification $notification)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success,error',
            'data' => 'nullable|array'
        ]);

        $notification->update([
            'data' => [
                'title' => $request->title,
                'message' => $request->message,
                'type' => $request->type,
                'data' => $request->data ?? []
            ]
        ]);

        return redirect()->route('admin.notifications.show', $notification)
            ->with('success', 'Notification mise à jour avec succès.');
    }

    public function destroyNotification(\App\Models\Notification $notification)
    {
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification supprimée avec succès.');
    }

    public function exportNotifications(Request $request)
    {
        $format = $request->get('format', 'csv');
        $notifications = \App\Models\Notification::with(['user'])
            ->latest()
            ->get();

        if ($format === 'csv') {
            $filename = 'notifications_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($notifications) {
                $file = fopen('php://output', 'w');
                
                // En-têtes CSV
                fputcsv($file, ['ID', 'Type', 'Destinataire', 'Titre', 'Message', 'Lu', 'Date de création']);
                
                foreach ($notifications as $notification) {
                    $data = $notification->data;
                    $title = $data['title'] ?? 'N/A';
                    $message = $data['message'] ?? 'N/A';
                    $notifiableName = $notification->notifiable ? $notification->notifiable->name : 'N/A';
                    $isRead = $notification->read_at ? 'Oui' : 'Non';
                    
                    fputcsv($file, [
                        $notification->id,
                        $notification->type,
                        $notifiableName,
                        $title,
                        $message,
                        $isRead,
                        $notification->created_at->format('Y-m-d H:i:s')
                    ]);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return back()->with('error', 'Format d\'export non supporté.');
    }

    public function sendNotificationToAll(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success,error',
            'target_type' => 'required|in:all,users,restaurants'
        ]);

        $users = [];
        $restaurants = [];

        if ($request->target_type === 'all' || $request->target_type === 'users') {
            $users = \App\Models\User::all();
        }

        if ($request->target_type === 'all' || $request->target_type === 'restaurants') {
            $restaurants = \App\Models\Restaurant::all();
        }

        $count = 0;

        // Envoyer aux utilisateurs
        foreach ($users as $user) {
            \App\Models\Notification::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\Notifications\AdminNotification',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $user->id,
                'data' => [
                    'title' => $request->title,
                    'message' => $request->message,
                    'type' => $request->type
                ]
            ]);
            $count++;
        }

        // Envoyer aux restaurants
        foreach ($restaurants as $restaurant) {
            \App\Models\Notification::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\Notifications\AdminNotification',
                'notifiable_type' => 'App\Models\Restaurant',
                'notifiable_id' => $restaurant->id,
                'data' => [
                    'title' => $request->title,
                    'message' => $request->message,
                    'type' => $request->type
                ]
            ]);
            $count++;
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', $count . ' notifications ont été envoyées avec succès.');
    }

    // Gestion des Messages
    public function messages()
    {
        $messages = \App\Models\Message::with(['user', 'restaurant'])
            ->latest()
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    public function createMessage()
    {
        $users = \App\Models\User::where('is_active', true)->get();
        $restaurants = \App\Models\Restaurant::where('is_active', true)->get();
        
        return view('admin.messages.create', compact('users', 'restaurants'));
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'restaurant_id' => 'nullable|exists:restaurants,id',
            'type' => 'required|in:info,warning,success,error',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $message = new \App\Models\Message($request->only([
            'subject', 'message', 'user_id', 'restaurant_id', 'type', 'priority'
        ]));
        
        $message->admin_id = auth()->id();
        $message->is_read = false;
        $message->save();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message créé avec succès.');
    }

    public function editMessage(\App\Models\Message $message)
    {
        $users = \App\Models\User::where('is_active', true)->get();
        $restaurants = \App\Models\Restaurant::where('is_active', true)->get();
        
        return view('admin.messages.edit', compact('message', 'users', 'restaurants'));
    }

    public function updateMessage(Request $request, \App\Models\Message $message)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'restaurant_id' => 'nullable|exists:restaurants,id',
            'type' => 'required|in:info,warning,success,error',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $message->update($request->only([
            'subject', 'message', 'user_id', 'restaurant_id', 'type', 'priority'
        ]));

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message mis à jour avec succès.');
    }

    public function destroyMessage(\App\Models\Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message supprimé avec succès.');
    }

    public function withdrawals()
    {
        $withdrawals = \App\Models\Withdrawal::with(['restaurant'])
            ->latest()
            ->paginate(20);

        $totalWithdrawals = \App\Models\Withdrawal::sum('amount');
        $pendingWithdrawals = \App\Models\Withdrawal::where('status', 'pending')->sum('amount');
        $approvedWithdrawals = \App\Models\Withdrawal::where('status', 'approved')->sum('amount');

        return view('admin.withdrawals.index', compact('withdrawals', 'totalWithdrawals', 'pendingWithdrawals', 'approvedWithdrawals'));
    }

    public function createWithdrawal()
    {
        $restaurants = \App\Models\Restaurant::where('is_active', true)->get();
        
        return view('admin.withdrawals.create', compact('restaurants'));
    }

    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'amount' => 'required|numeric|min:0.01',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $withdrawal = new \App\Models\Withdrawal($request->only([
            'restaurant_id', 'amount', 'bank_name', 'account_number', 'account_holder_name', 'notes'
        ]));
        
        $withdrawal->status = 'pending';
        $withdrawal->processed_by = auth()->id();
        $withdrawal->save();

        return redirect()->route('admin.withdrawals.index')
            ->with('success', 'Demande de retrait créée avec succès.');
    }

    public function showWithdrawal(\App\Models\Withdrawal $withdrawal)
    {
        $withdrawal->load(['restaurant', 'processedBy']);
        
        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    public function editWithdrawal(\App\Models\Withdrawal $withdrawal)
    {
        $restaurants = \App\Models\Restaurant::where('is_active', true)->get();
        
        return view('admin.withdrawals.edit', compact('withdrawal', 'restaurants'));
    }

    public function updateWithdrawal(Request $request, \App\Models\Withdrawal $withdrawal)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'amount' => 'required|numeric|min:0.01',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'status' => 'required|in:pending,approved,rejected,completed',
            'notes' => 'nullable|string',
        ]);

        $withdrawal->update($request->only([
            'restaurant_id', 'amount', 'bank_name', 'account_number', 'account_holder_name', 'status', 'notes'
        ]));

        return redirect()->route('admin.withdrawals.index')
            ->with('success', 'Demande de retrait mise à jour avec succès.');
    }

    public function destroyWithdrawal(\App\Models\Withdrawal $withdrawal)
    {
        $withdrawal->delete();

        return redirect()->route('admin.withdrawals.index')
            ->with('success', 'Demande de retrait supprimée avec succès.');
    }

    // Paramètres du Système
    public function settings()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        
        // Vérifier si c'est la route new-design
        if (request()->routeIs('admin.settings.new-design')) {
            return view('admin.settings.index-new-design', compact('settings'));
        }
        
        return view('admin.settings.index', compact('settings'));
    }

    // Gestion du Profil Admin
    public function showProfile()
    {
        $user = auth()->user();
        $user->load(['restaurant', 'tenant']);
        
        // Statistiques du profil
        $stats = [
            'total_restaurants_managed' => $user->role === 'super_admin' ? \App\Models\Restaurant::count() : ($user->restaurant ? 1 : 0),
            'total_orders_managed' => $user->role === 'super_admin' ? \App\Models\Order::count() : ($user->restaurant ? $user->restaurant->orders()->count() : 0),
            'last_login' => $user->last_login_at,
            'account_created' => $user->created_at,
            'role_permissions' => $user->role === 'super_admin' ? 'Toutes' : 'Limitées',
        ];
        
        return view('admin.profile.show', compact('user', 'stats'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        
        return view('admin.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'job_title' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|string|max:255',
        ]);

        $user->update($request->only([
            'name', 'email', 'phone', 'address', 'bio', 'job_title', 
            'department', 'website', 'linkedin', 'twitter', 'facebook', 'instagram'
        ]));

        return redirect()->route('admin.profile.show')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        
        // Supprimer l'ancienne photo si elle existe
        if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
            \Storage::disk('public')->delete($user->avatar);
        }
        
        // Stocker la nouvelle photo
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        
        $user->update(['avatar' => $avatarPath]);

        return response()->json([
            'success' => true,
            'message' => 'Photo de profil mise à jour avec succès.',
            'avatar_url' => asset('storage/' . $avatarPath)
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->update([
            'password' => \Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile.show')
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }

    // Gestion du Support
    public function support()
    {
        // Statistiques du support (modèle temporairement désactivé)
        $stats = [
            'total_tickets' => 0,
            'open_tickets' => 0,
            'resolved_tickets' => 0,
            'avg_response_time' => 0,
            'satisfaction_rate' => 0,
        ];

        // Tickets récents (modèle temporairement désactivé)
        $recentTickets = collect([]);

        // Tickets par priorité
        $ticketsByPriority = [
            'urgent' => 0,
            'high' => 0,
            'medium' => 0,
            'low' => 0,
        ];

        // Tickets par catégorie
        $ticketsByCategory = [];

        return view('admin.support.index', compact('stats', 'recentTickets', 'ticketsByPriority', 'ticketsByCategory'));
    }

    // Gestion des Analytics
    public function analytics()
    {
        // Métriques principales
        $metrics = [
            'total_revenue' => \App\Models\Order::where('status', 'completed')->sum('total_amount'),
            'total_orders' => \App\Models\Order::count(),
            'completed_orders' => \App\Models\Order::where('status', 'completed')->count(),
            'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            'cancelled_orders' => \App\Models\Order::where('status', 'cancelled')->count(),
            'avg_order_value' => \App\Models\Order::where('status', 'completed')->avg('total_amount') ?? 0,
            'total_restaurants' => \App\Models\Restaurant::count(),
            'active_restaurants' => \App\Models\Restaurant::where('is_active', true)->count(),
            'total_users' => \App\Models\User::count(),
            'active_users' => \App\Models\User::where('last_login_at', '>=', now()->subDays(30))->count(),
        ];

        // Revenus par mois (6 derniers mois)
        $monthlyRevenue = \App\Models\Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('revenue', 'month')
            ->toArray();

        // Commandes par jour (7 derniers jours)
        $dailyOrders = \App\Models\Order::where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Top restaurants par revenus
        $topRestaurants = \App\Models\Restaurant::withCount(['orders' => function($query) {
            $query->where('status', 'completed');
        }])
        ->withSum(['orders' => function($query) {
            $query->where('status', 'completed');
        }], 'total_amount')
        ->orderBy('orders_sum_total_amount', 'desc')
        ->limit(10)
        ->get();

        // Répartition des statuts de commandes
        $orderStatusDistribution = \App\Models\Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Métriques de performance
        $performanceMetrics = [
            'conversion_rate' => $metrics['total_orders'] > 0 ? 
                ($metrics['completed_orders'] / $metrics['total_orders']) * 100 : 0,
            'cancellation_rate' => $metrics['total_orders'] > 0 ? 
                ($metrics['cancelled_orders'] / $metrics['total_orders']) * 100 : 0,
            'avg_preparation_time' => \App\Models\Order::where('status', 'completed')
                ->whereNotNull('preparation_time')
                ->avg('preparation_time') ?? 0,
            'customer_satisfaction' => \App\Models\Review::avg('rating') ?? 0,
        ];

        return view('admin.analytics.index', compact(
            'metrics', 
            'monthlyRevenue', 
            'dailyOrders', 
            'topRestaurants', 
            'orderStatusDistribution', 
            'performanceMetrics'
        ));
    }

    // Gestion des Vidéos
    public function videos()
    {
        // Statistiques des vidéos
        $stats = [
            'total_videos' => \App\Models\Video::count(),
            'published_videos' => \App\Models\Video::where('is_active', true)->count(),
            'draft_videos' => \App\Models\Video::where('is_active', false)->count(),
            'total_views' => \App\Models\Video::get()->sum(function($video) {
                return $video->metadata['views'] ?? 0;
            }),
            'total_likes' => \App\Models\Video::get()->sum(function($video) {
                return $video->metadata['likes'] ?? 0;
            }),
            'avg_duration' => \App\Models\Video::avg('duration') ?? 0,
        ];

        // Vidéos récentes (toutes, pas seulement actives)
        $recentVideos = \App\Models\Video::latest()
            ->limit(10)
            ->get();

        // Vidéos populaires (triées par vues dans metadata)
        $popularVideos = \App\Models\Video::get()
            ->sortByDesc(function($video) {
                return $video->metadata['views'] ?? 0;
            })
            ->take(10);

        // Vidéos par qualité
        $videosByCategory = \App\Models\Video::selectRaw('quality, COUNT(*) as count')
            ->groupBy('quality')
            ->pluck('count', 'quality')
            ->toArray();

        // Statistiques de performance
        $performanceStats = [
            'avg_engagement_rate' => $stats['total_views'] > 0 ? 
                ($stats['total_likes'] / $stats['total_views']) * 100 : 0,
            'upload_rate' => \App\Models\Video::where('created_at', '>=', now()->subDays(30))->count(),
            'completion_rate' => \App\Models\Video::where('is_active', true)->count() / max($stats['total_videos'], 1) * 100,
        ];

        return view('admin.videos.index', compact(
            'stats', 
            'recentVideos', 
            'popularVideos', 
            'videosByCategory', 
            'performanceStats'
        ));
    }

    // Export des vidéos
    public function exportVideos()
    {
        // Logique d'export des vidéos (à implémenter)
        return response()->json(['message' => 'Export des vidéos en cours de développement']);
    }

    // Afficher le formulaire de création de vidéo
    public function createVideo()
    {
        return view('admin.videos.create');
    }

    // Stocker une nouvelle vidéo
    public function storeVideo(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB
            'duration' => 'nullable|integer|min:1',
            'quality' => 'required|string|in:SD,HD,Full HD,4K',
            'language' => 'required|string|max:10',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        try {
            // Vérifier qu'au moins une source vidéo est fournie
            if (!$request->video_url && !$request->hasFile('video_file')) {
                return back()->withErrors(['video_url' => 'Vous devez fournir soit une URL vidéo, soit un fichier vidéo.']);
            }

            $videoData = [
                'title' => $request->title,
                'description' => $request->description,
                'video_url' => $request->video_url,
                'duration' => $request->duration,
                'quality' => $request->quality,
                'language' => $request->language,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->boolean('is_active'),
                'is_featured' => $request->boolean('is_featured'),
                'views_count' => 0,
                'likes_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Gérer l'upload du fichier vidéo
            if ($request->hasFile('video_file')) {
                $videoFile = $request->file('video_file');
                $videoFileName = time() . '_' . $videoFile->getClientOriginalName();
                $videoPath = $videoFile->storeAs('public/videos', $videoFileName);
                $videoData['video_file'] = $videoFileName;
            }

            // Gérer l'upload de la miniature
            if ($request->hasFile('thumbnail')) {
                $thumbnailFile = $request->file('thumbnail');
                $thumbnailFileName = time() . '_' . $thumbnailFile->getClientOriginalName();
                $thumbnailPath = $thumbnailFile->storeAs('public/thumbnails', $thumbnailFileName);
                $videoData['thumbnail'] = $thumbnailFileName;
            }

            // Insérer dans la base de données
            \App\Models\Video::create($videoData);

            return redirect()->route('admin.videos.index')
                           ->with('success', 'Vidéo créée avec succès !');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la création de la vidéo: ' . $e->getMessage()]);
        }
    }

    // Gestion des Transactions de Paiement
    public function paymentTransactions()
    {
        // Statistiques des transactions (modèle temporairement désactivé)
        $stats = [
            'total_transactions' => 0,
            'successful_transactions' => 0,
            'pending_transactions' => 0,
            'failed_transactions' => 0,
            'total_amount' => 0,
            'avg_transaction_amount' => 0,
        ];

        // Transactions récentes (modèle temporairement désactivé)
        $recentTransactions = collect([]);

        // Transactions par statut
        $transactionsByStatus = [
            'completed' => 0,
            'pending' => 0,
            'failed' => 0,
            'cancelled' => 0,
        ];

        // Transactions par méthode de paiement
        $transactionsByMethod = [];

        // Métriques de performance
        $performanceMetrics = [
            'success_rate' => 0,
            'avg_processing_time' => 0,
            'daily_transactions' => 0,
        ];

        return view('admin.payment-transactions.index', compact(
            'stats', 
            'recentTransactions', 
            'transactionsByStatus', 
            'transactionsByMethod', 
            'performanceMetrics'
        ));
    }

    // Méthode pour récupérer les statistiques globales (utilisée dans la sidebar)
    public function getGlobalStats()
    {
        return [
            'total_restaurants' => \App\Models\Restaurant::count(),
            'active_restaurants' => \App\Models\Restaurant::where('is_active', true)->count(),
            'total_users' => \App\Models\User::count(),
            'active_users' => \App\Models\User::where('last_login_at', '>=', now()->subDays(30))->count(),
            'total_orders' => \App\Models\Order::count(),
            'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            'completed_orders' => \App\Models\Order::where('status', 'completed')->count(),
            'total_revenue' => \App\Models\Order::where('status', 'completed')->sum('total_amount'),
            'total_products' => \App\Models\Product::count(),
            'active_products' => \App\Models\Product::where('is_available', true)->count(),
            'total_categories' => \App\Models\Category::count(),
            'total_promotions' => 0, // \App\Models\Promotion::where('is_active', true)->count(),
            'total_reviews' => \App\Models\Review::count(),
            'avg_rating' => \App\Models\Review::avg('rating') ?? 0,
            'total_videos' => \App\Models\Video::count(),
            'published_videos' => \App\Models\Video::where('is_active', true)->count(),
            'total_transactions' => 0, // \App\Models\PaymentTransaction::count(),
            'successful_transactions' => 0, // \App\Models\PaymentTransaction::where('status', 'completed')->count(),
            'total_support_tickets' => 0, // \App\Models\SupportTicket::count(),
            'open_support_tickets' => 0, // \App\Models\SupportTicket::where('status', 'open')->count(),
        ];
    }

    public function updateSettings(Request $request)
    {
        // Validation flexible pour tous les paramètres
        $request->validate([
            'platform_name' => 'nullable|string|max:255',
            'platform_url' => 'nullable|url',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'currency' => 'nullable|string|max:10',
            'timezone' => 'nullable|string',
            'default_language' => 'nullable|string',
            'number_format' => 'nullable|string',
            'platform_description' => 'nullable|string',
            'delivery_time' => 'nullable|integer|min:5|max:1440',
        ]);

        // Sauvegarder tous les paramètres reçus
        foreach ($request->except('_token', '_method') as $key => $value) {
            if (!empty($value)) {
                \App\Models\Setting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => $value,
                        'type' => 'string',
                        'description' => ucfirst(str_replace('_', ' ', $key))
                    ]
                );
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres mis à jour avec succès.');
    }

    // Export des Reviews
    public function exportReviews(Request $request)
    {
        $format = $request->get('format', 'csv');
        $reviews = \App\Models\Review::with(['user', 'restaurant', 'order'])
            ->latest()
            ->get();

        if ($format === 'csv') {
            $filename = 'reviews_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($reviews) {
                $file = fopen('php://output', 'w');
                
                // En-têtes CSV
                fputcsv($file, ['ID', 'Utilisateur', 'Restaurant', 'Note', 'Commentaire', 'Statut', 'Date de création']);
                
                foreach ($reviews as $review) {
                    fputcsv($file, [
                        $review->id,
                        $review->user ? $review->user->name : 'N/A',
                        $review->restaurant ? $review->restaurant->name : 'N/A',
                        $review->rating,
                        $review->comment,
                        $review->status,
                        $review->created_at->format('Y-m-d H:i:s')
                    ]);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return back()->with('error', 'Format d\'export non supporté.');
    }

    // Export des Promotions
    public function exportPromotions(Request $request)
    {
        $format = $request->get('format', 'csv');
        $promotions = \App\Models\Promotion::with(['restaurant'])
            ->latest()
            ->get();

        if ($format === 'csv') {
            $filename = 'promotions_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($promotions) {
                $file = fopen('php://output', 'w');
                
                // En-têtes CSV
                fputcsv($file, ['ID', 'Restaurant', 'Titre', 'Description', 'Réduction', 'Type', 'Statut', 'Date d\'expiration', 'Date de création']);
                
                foreach ($promotions as $promotion) {
                    fputcsv($file, [
                        $promotion->id,
                        $promotion->restaurant ? $promotion->restaurant->name : 'N/A',
                        $promotion->title,
                        $promotion->description,
                        $promotion->discount_value . ($promotion->discount_type === 'percentage' ? '%' : ' FCFA'),
                        $promotion->discount_type,
                        $promotion->is_active ? 'Active' : 'Inactive',
                        $promotion->expires_at ? $promotion->expires_at->format('Y-m-d H:i:s') : 'N/A',
                        $promotion->created_at->format('Y-m-d H:i:s')
                    ]);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return back()->with('error', 'Format d\'export non supporté.');
    }
}
