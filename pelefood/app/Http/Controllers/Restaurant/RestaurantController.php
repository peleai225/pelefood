<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Events\NewRestaurantRegistered;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user || !in_array($user->role, ['restaurant', 'admin', 'super_admin'])) {
                abort(403, 'User does not have the right roles.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'super_admin') {
            $restaurant = Restaurant::first();
        } else {
            $restaurant = $user->tenant->restaurants->first();
        }
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('error', 'Vous devez d\'abord configurer votre restaurant.');
        }

        return redirect()->route('restaurant.restaurants.edit', $restaurant);
    }

    public function create()
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }
        
        $user = Auth::user();
        
        // Vérifier si cet utilisateur a déjà un restaurant
        if ($user->role === 'super_admin') {
            $restaurant = Restaurant::first();
        } else {
            // Vérifier si l'utilisateur a un tenant
            if (!$user->tenant) {
                return redirect()->route('login')
                    ->with('error', 'Votre compte n\'est pas associé à un tenant. Veuillez contacter l\'administrateur.');
            }
            
            // Chercher un restaurant appartenant à cet utilisateur spécifique
            $restaurant = Restaurant::where('user_id', $user->id)->first();
            
            // Si pas de restaurant avec user_id, chercher dans le tenant (pour compatibilité)
            if (!$restaurant) {
                $restaurant = $user->tenant->restaurants()->where('user_id', $user->id)->first();
            }
        }
        
        if ($restaurant) {
            return redirect()->route('restaurant.restaurants.edit', $restaurant)
                ->with('info', 'Votre restaurant est déjà configuré.');
        }

        return view('restaurant.restaurants.create');
    }

    public function store(Request $request)
    {
        \Log::info('RestaurantController@store: Début de la création de restaurant', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role ?? 'non connecté',
            'request_data' => $request->except(['_token'])
        ]);
        
        $user = Auth::user();
        
        if ($user->role === 'super_admin') {
            if (Restaurant::exists()) {
                return redirect()->route('restaurant.dashboard')
                    ->with('error', 'Un restaurant existe déjà.');
            }
        } else {
            // Vérifier si l'utilisateur a un tenant
            if (!$user->tenant) {
                return redirect()->route('restaurant.restaurants.create')
                    ->with('error', 'Votre compte n\'est pas associé à un tenant. Veuillez contacter l\'administrateur.');
            }
            
            // Vérifier si cet utilisateur a déjà un restaurant
            $existingRestaurant = Restaurant::where('user_id', $user->id)->first();
            if ($existingRestaurant) {
                return redirect()->route('restaurant.restaurants.edit', $existingRestaurant)
                    ->with('info', 'Vous avez déjà un restaurant configuré. Vous pouvez le modifier ici.');
            }
        }

        \Log::info('RestaurantController@store: Validation des données');
        
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'city' => 'required|string|max:100',
                'postal_code' => 'nullable|string|max:20',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'is_active' => 'nullable|in:0,1,on,off',
            ]);
            \Log::info('RestaurantController@store: Validation réussie');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('RestaurantController@store: Erreur de validation', [
                'errors' => $e->errors()
            ]);
            throw $e;
        }

        // Créer le restaurant avec les données de base
        $restaurant = new Restaurant();
        $restaurant->user_id = $user->id; // Assigner l'utilisateur au restaurant
        
        if ($user->role === 'super_admin') {
            $restaurant->tenant_id = null; // super_admin n'a pas de tenant
        } else {
            // Vérifier à nouveau que l'utilisateur a un tenant
            if (!$user->tenant) {
                return redirect()->route('restaurant.restaurants.create')
                    ->with('error', 'Votre compte n\'est pas associé à un tenant. Veuillez contacter l\'administrateur.');
            }
            $restaurant->tenant_id = $user->tenant->id;
        }
        $restaurant->name = $request->name;
        $restaurant->description = $request->description;
        $restaurant->phone = $request->phone;
        $restaurant->email = $user->email; // Utiliser l'email de l'utilisateur connecté
        $restaurant->address = $request->address;
        $restaurant->city = $request->city;
        $restaurant->postal_code = $request->postal_code;
        $restaurant->country = 'Côte d\'Ivoire'; // Valeur par défaut pour la Côte d'Ivoire
        $restaurant->is_active = $request->has('is_active') || $request->is_active === '1' || $request->is_active === 'on';
        $restaurant->slug = Str::slug($request->name);

        // Gestion des images
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('restaurants/logos', 'public');
            $restaurant->logo = $logoPath;
        }

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('restaurants/covers', 'public');
            $restaurant->cover_image = $coverPath;
        }

        \Log::info('RestaurantController@store: Sauvegarde du restaurant');
        $restaurant->save();

        // Debug: Vérifier que le restaurant a été créé
        \Log::info('RestaurantController@store: Restaurant créé avec succès', [
            'id' => $restaurant->id,
            'name' => $restaurant->name,
            'tenant_id' => $restaurant->tenant_id
        ]);

        // Déclencher l'événement de nouveau restaurant
        event(new NewRestaurantRegistered($restaurant, $user));

        return redirect()->route('restaurant.subscription.select')
            ->with('success', 'Restaurant créé avec succès ! Choisissez maintenant votre plan d\'abonnement.');
    }

    public function show(Restaurant $restaurant)
    {
        $user = Auth::user();
        
        // Vérifier que le restaurant appartient au tenant (sauf pour super_admin)
        if ($user->role !== 'super_admin' && $restaurant->tenant_id !== $user->tenant->id) {
            abort(403);
        }

        return view('restaurant.restaurants.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant)
    {
        $user = Auth::user();
        
        // Vérifier que le restaurant appartient au tenant (sauf pour super_admin)
        if ($user->role !== 'super_admin' && $restaurant->tenant_id !== $user->tenant->id) {
            abort(403);
        }

        return view('restaurant.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $user = Auth::user();
        
        // Vérifier que le restaurant appartient au tenant (sauf pour super_admin)
        if ($user->role !== 'super_admin' && $restaurant->tenant_id !== $user->tenant->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'opening_hours' => 'nullable|array',
            'delivery_type' => 'required|in:delivery,pickup,both',
            'delivery_fee' => 'nullable|numeric|min:0',
            'delivery_time' => 'nullable|integer|min:0',
            'minimum_order' => 'nullable|numeric|min:0',
            'payment_methods' => 'nullable|array',
            'theme_colors' => 'nullable|array',
            'is_open' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $restaurant->fill($request->except(['logo', 'banner', 'cover_image']));
        $restaurant->slug = Str::slug($request->name);
        $restaurant->is_open = $request->has('is_open');
        $restaurant->is_active = $request->has('is_active');

        // Gestion des images
        if ($request->hasFile('logo')) {
            if ($restaurant->logo) {
                Storage::disk('public')->delete($restaurant->logo);
            }
            $logoPath = $request->file('logo')->store('restaurants/logos', 'public');
            $restaurant->logo = $logoPath;
        }

        if ($request->hasFile('banner')) {
            if ($restaurant->banner) {
                Storage::disk('public')->delete($restaurant->banner);
            }
            $bannerPath = $request->file('banner')->store('restaurants/banners', 'public');
            $restaurant->banner = $bannerPath;
        }

        if ($request->hasFile('cover_image')) {
            if ($restaurant->cover_image) {
                Storage::disk('public')->delete($restaurant->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('restaurants/covers', 'public');
            $restaurant->cover_image = $coverPath;
        }

        $restaurant->save();

        return redirect()->route('restaurant.restaurants.edit', $restaurant)
            ->with('success', 'Restaurant mis à jour avec succès.');
    }

    public function destroy(Restaurant $restaurant)
    {
        $user = Auth::user();
        
        // Vérifier que le restaurant appartient au tenant (sauf pour super_admin)
        if ($user->role !== 'super_admin' && $restaurant->tenant_id !== $user->tenant->id) {
            abort(403);
        }

        // Supprimer les images
        if ($restaurant->logo) {
            Storage::disk('public')->delete($restaurant->logo);
        }
        if ($restaurant->banner) {
            Storage::disk('public')->delete($restaurant->banner);
        }
        if ($restaurant->cover_image) {
            Storage::disk('public')->delete($restaurant->cover_image);
        }

        $restaurant->delete();

        return redirect()->route('restaurant.restaurants.create')
            ->with('success', 'Restaurant supprimé avec succès.');
    }
}
