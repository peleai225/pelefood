<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Promotion;

class PromotionController extends Controller
{
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

        $promotions = $restaurant->promotions()->paginate(20);
        
        // Calculer les statistiques réelles
        $stats = [
            'active_promotions' => $restaurant->promotions()->where('is_active', true)
                ->where('starts_at', '<=', now())
                ->where('ends_at', '>=', now())
                ->count(),
            'total_promotions' => $restaurant->promotions()->count(),
            'expired_promotions' => $restaurant->promotions()->where('ends_at', '<', now())->count(),
            'scheduled_promotions' => $restaurant->promotions()->where('starts_at', '>', now())->count(),
        ];

        return view('restaurant.promotions.index', compact('promotions', 'stats'));
    }

    public function create()
    {
        $restaurant = $this->getCurrentRestaurant();
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        return view('restaurant.promotions.create');
    }

    public function store(Request $request)
    {
        $restaurant = $this->getCurrentRestaurant();
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount,free_delivery,buy_one_get_one',
            'discount_value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'code' => 'nullable|string|unique:promotions,code',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['restaurant_id'] = $restaurant->id;
        $promotion = $restaurant->promotions()->create($data);

        return redirect()->route('restaurant.promotions.index')
            ->with('success', 'Promotion créée avec succès !');
    }

    public function edit(Promotion $promotion)
    {
        $restaurant = $this->getCurrentRestaurant();
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        // Vérifier que la promotion appartient au restaurant
        if ($promotion->restaurant_id !== $restaurant->id) {
            abort(403, 'Accès refusé.');
        }

        return view('restaurant.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $restaurant = $this->getCurrentRestaurant();
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        // Vérifier que la promotion appartient au restaurant
        if ($promotion->restaurant_id !== $restaurant->id) {
            abort(403, 'Accès refusé.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount,free_delivery,buy_one_get_one',
            'discount_value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'code' => 'nullable|string|unique:promotions,code,' . $promotion->id,
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_active' => 'boolean',
        ]);

        $promotion->update($request->all());

        return redirect()->route('restaurant.promotions.index')
            ->with('success', 'Promotion mise à jour avec succès !');
    }

    public function destroy(Promotion $promotion)
    {
        $restaurant = $this->getCurrentRestaurant();
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }

        // Vérifier que la promotion appartient au restaurant
        if ($promotion->restaurant_id !== $restaurant->id) {
            abort(403, 'Accès refusé.');
        }

        $promotion->delete();

        return redirect()->route('restaurant.promotions.index')
            ->with('success', 'Promotion supprimée avec succès !');
    }
}
