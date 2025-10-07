<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Récupérer le restaurant de l'utilisateur connecté
     */
    protected function getCurrentRestaurant()
    {
        $user = auth()->user();
        
        // Récupérer le restaurant selon le rôle de l'utilisateur
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
        
        $products = $restaurant->products()->with('category')->paginate(20);
        return view('restaurant.products.index', compact('products'));
    }

    public function create()
    {
        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }
        
        $categories = $restaurant->categories()->where('is_active', true)->get();
        return view('restaurant.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }
        
        $product = new Product();
        $product->restaurant_id = $restaurant->id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->is_active = $request->has('is_active') || $request->is_active === '1' || $request->is_active === 'on';
        $product->slug = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('restaurant.products.index')
            ->with('success', 'Produit créé avec succès !');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('restaurant.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant) {
            return redirect()->route('restaurant.restaurants.create')
                ->with('info', 'Bienvenue ! Commençons par créer votre restaurant.');
        }
        
        $categories = $restaurant->categories()->where('is_active', true)->get();
        return view('restaurant.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->is_active = $request->has('is_active') || $request->is_active === '1' || $request->is_active === 'on';
        $product->slug = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('restaurant.products.index')
            ->with('success', 'Produit mis à jour avec succès !');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('restaurant.products.index')
            ->with('success', 'Produit supprimé avec succès !');
    }

    public function toggleStatus(Request $request, Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Statut du produit mis à jour');
    }
}
