<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.role:restaurant,admin,super_admin']);
    }

    public function index()
    {
        $user = auth()->user();
        $restaurant = $user->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('login')->with('error', 'Aucun restaurant associé à votre compte.');
        }

        // Récupérer les catégories avec leurs produits
        $categories = $restaurant->categories()->withCount(['products', 'products as active_products_count' => function($query) {
            $query->where('is_active', true);
        }])->paginate(20);

        // Calculer les statistiques
        $totalCategories = $restaurant->categories()->count();
        $totalProducts = $restaurant->products()->count();
        $activeCategories = $restaurant->categories()->where('is_active', true)->count();
        $averagePrice = $restaurant->products()->avg('price') ?? 0;

        $stats = [
            'total_categories' => $totalCategories,
            'total_products' => $totalProducts,
            'active_categories' => $activeCategories,
            'average_price' => $averagePrice,
        ];

        return view('restaurant.categories.index', compact('categories', 'stats', 'restaurant'));
    }

    public function create()
    {
        $user = auth()->user();
        $restaurant = $user->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('login')->with('error', 'Aucun restaurant associé à votre compte.');
        }

        return view('restaurant.categories.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $restaurant = $user->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('login')->with('error', 'Aucun restaurant associé à votre compte.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean'
        ]);

        $categoryData = [
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'restaurant_id' => $restaurant->id
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $categoryData['image'] = $imagePath;
        }

        Category::create($categoryData);

        return redirect()->route('restaurant.categories.index')
            ->with('success', 'Catégorie créée avec succès !');
    }

    public function show(Category $category)
    {
        $user = auth()->user();
        $restaurant = $user->restaurant;
        
        if (!$restaurant || $category->restaurant_id !== $restaurant->id) {
            abort(403, 'Accès refusé.');
        }

        return view('restaurant.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $user = auth()->user();
        $restaurant = $user->restaurant;
        
        if (!$restaurant || $category->restaurant_id !== $restaurant->id) {
            abort(403, 'Accès refusé.');
        }

        return view('restaurant.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $user = auth()->user();
        $restaurant = $user->restaurant;
        
        if (!$restaurant || $category->restaurant_id !== $restaurant->id) {
            abort(403, 'Accès refusé.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean'
        ]);

        $categoryData = [
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ];

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($category->image) {
                \Storage::disk('public')->delete($category->image);
            }
            
            $imagePath = $request->file('image')->store('categories', 'public');
            $categoryData['image'] = $imagePath;
        }

        $category->update($categoryData);

        return redirect()->route('restaurant.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès !');
    }

    public function destroy(Category $category)
    {
        $user = auth()->user();
        $restaurant = $user->restaurant;
        
        if (!$restaurant || $category->restaurant_id !== $restaurant->id) {
            abort(403, 'Accès refusé.');
        }

        // Supprimer l'image si elle existe
        if ($category->image) {
            \Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('restaurant.categories.index')
            ->with('success', 'Catégorie supprimée avec succès !');
    }
}
