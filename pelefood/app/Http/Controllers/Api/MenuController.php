<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    /**
     * Afficher le menu d'un restaurant
     */
    public function show(Request $request, $restaurant): JsonResponse
    {
        $restaurant = Restaurant::where('slug', $restaurant)
            ->orWhere('id', $restaurant)
            ->first();

        if (!$restaurant || !$restaurant->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant non trouvé'
            ], 404);
        }

        $categories = Category::with(['products' => function($query) {
            $query->where('is_active', true)
                  ->orderBy('sort_order')
                  ->orderBy('name');
        }])
        ->where('restaurant_id', $restaurant->id)
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();

        $menuData = [
            'restaurant' => [
                'id' => $restaurant->id,
                'name' => $restaurant->name,
                'slug' => $restaurant->slug,
                'description' => $restaurant->description,
                'logo_url' => $restaurant->logo_url,
                'cover_image_url' => $restaurant->cover_image_url,
                'minimum_order_amount' => $restaurant->minimum_order_amount,
                'delivery_fee' => $restaurant->delivery_fee,
                'is_open' => $this->isRestaurantOpen($restaurant)
            ],
            'categories' => $categories->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'image_url' => $category->image_url,
                    'sort_order' => $category->sort_order,
                    'products_count' => $category->products->count(),
                    'products' => $category->products->map(function($product) {
                        return $this->formatProduct($product);
                    })
                ];
            }),
            'featured_products' => Product::where('restaurant_id', $restaurant->id)
                ->where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('sort_order')
                ->limit(6)
                ->get()
                ->map(function($product) {
                    return $this->formatProduct($product);
                }),
            'stats' => [
                'total_categories' => $categories->count(),
                'total_products' => $categories->sum('products_count'),
                'featured_products_count' => Product::where('restaurant_id', $restaurant->id)
                    ->where('is_active', true)
                    ->where('is_featured', true)
                    ->count()
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $menuData
        ]);
    }

    /**
     * Vérifier si le restaurant est ouvert
     */
    private function isRestaurantOpen(Restaurant $restaurant): bool
    {
        if (!$restaurant->opening_hours) {
            return true;
        }

        $openingHours = json_decode($restaurant->opening_hours, true);
        $currentDay = strtolower(now()->format('l'));
        $currentTime = now()->format('H:i');

        if (!isset($openingHours[$currentDay]) || !$openingHours[$currentDay]['is_open']) {
            return false;
        }

        $openTime = $openingHours[$currentDay]['open_time'];
        $closeTime = $openingHours[$currentDay]['close_time'];

        return $currentTime >= $openTime && $currentTime <= $closeTime;
    }

    /**
     * Formater les données d'un produit
     */
    private function formatProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'formatted_price' => number_format($product->price, 0, ',', ' ') . ' FCFA',
            'image_url' => $product->image_url,
            'is_available' => $product->is_available,
            'is_featured' => $product->is_featured,
            'preparation_time' => $product->preparation_time,
            'ingredients' => $product->ingredients ? json_decode($product->ingredients, true) : [],
            'allergens' => $product->allergens ? json_decode($product->allergens, true) : [],
            'nutritional_info' => $product->nutritional_info ? json_decode($product->nutritional_info, true) : [],
            'sort_order' => $product->sort_order,
            'category_id' => $product->category_id,
            'restaurant_id' => $product->restaurant_id,
            'created_at' => $product->created_at->format('d/m/Y'),
            'updated_at' => $product->updated_at->format('d/m/Y')
        ];
    }
}

