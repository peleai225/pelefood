<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Tenant;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantsController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with(['tenant', 'subscriptionPlan', 'user'])
            ->latest()
            ->paginate(15);
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        $plans = SubscriptionPlan::all();
        return view('admin.restaurants.create', compact('tenants', 'plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tenant_id' => 'required|exists:tenants,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('restaurants/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('restaurants/covers', 'public');
        }

        Restaurant::create($validated);

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant créé avec succès');
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['tenant', 'subscriptionPlan', 'user', 'categories', 'products']);
        return view('admin.restaurants.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant)
    {
        $tenants = Tenant::all();
        $plans = SubscriptionPlan::all();
        return view('admin.restaurants.edit', compact('restaurant', 'tenants', 'plans'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tenant_id' => 'required|exists:tenants,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'status' => 'required|in:active,inactive,suspended',
            'delivery_fee' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'delivery_zones' => 'nullable|array',
            'delivery_zones.*.name' => 'required_with:delivery_zones|string|max:255',
            'delivery_zones.*.fee' => 'required_with:delivery_zones|numeric|min:0',
            'delivery_zones.*.delivery_time' => 'required_with:delivery_zones|integer|min:1',
        ]);

        if ($request->hasFile('logo')) {
            if ($restaurant->logo) {
                Storage::disk('public')->delete($restaurant->logo);
            }
            $validated['logo'] = $request->file('logo')->store('restaurants/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($restaurant->cover_image) {
                Storage::disk('public')->delete($restaurant->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('restaurants/covers', 'public');
        }

        // Traitement des zones de livraison
        if ($request->has('delivery_zones')) {
            $deliveryZones = [];
            foreach ($request->delivery_zones as $zone) {
                if (!empty($zone['name'])) {
                    $deliveryZones[] = [
                        'name' => $zone['name'],
                        'fee' => (float) $zone['fee'],
                        'delivery_time' => (int) $zone['delivery_time']
                    ];
                }
            }
            $validated['delivery_zones'] = $deliveryZones;
        }

        // Mapper min_order_amount vers minimum_order
        if (isset($validated['min_order_amount'])) {
            $validated['minimum_order'] = $validated['min_order_amount'];
            unset($validated['min_order_amount']);
        }

        $restaurant->update($validated);

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant mis à jour avec succès');
    }

    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->orders()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce restaurant car il a des commandes associées');
        }

        // Supprimer les images
        if ($restaurant->logo) {
            Storage::disk('public')->delete($restaurant->logo);
        }
        if ($restaurant->cover_image) {
            Storage::disk('public')->delete($restaurant->cover_image);
        }

        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant supprimé avec succès');
    }
} 