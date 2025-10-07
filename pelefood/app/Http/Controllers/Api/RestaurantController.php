<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RestaurantController extends Controller
{
    /**
     * Liste tous les restaurants actifs
     */
    public function index(Request $request): JsonResponse
    {
        $query = Restaurant::with(['user', 'subscriptionPlan'])
            ->where('is_active', true);

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->category}%");
            });
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', "%{$request->city}%");
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 12);
        $restaurants = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $restaurants->items(),
            'pagination' => [
                'current_page' => $restaurants->currentPage(),
                'last_page' => $restaurants->lastPage(),
                'per_page' => $restaurants->perPage(),
                'total' => $restaurants->total(),
                'from' => $restaurants->firstItem(),
                'to' => $restaurants->lastItem(),
            ],
            'filters' => $request->only(['search', 'category', 'city', 'sort_by', 'sort_order'])
        ]);
    }

    /**
     * Affiche un restaurant spécifique avec son menu
     */
    public function show(Request $request, $restaurant): JsonResponse
    {
        $restaurant = Restaurant::with([
            'user',
            'subscriptionPlan',
            'categories.products' => function($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            },
            'products' => function($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            },
            'reviews' => function($query) {
                $query->where('is_approved', true)->latest()->limit(10);
            }
        ])->where('slug', $restaurant)
          ->orWhere('id', $restaurant)
          ->first();

        if (!$restaurant || !$restaurant->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant non trouvé'
            ], 404);
        }

        // Calculer la note moyenne
        $averageRating = $restaurant->reviews()->avg('rating') ?? 0;
        $totalReviews = $restaurant->reviews()->count();

        // Formater les données du restaurant
        $restaurantData = [
            'id' => $restaurant->id,
            'name' => $restaurant->name,
            'slug' => $restaurant->slug,
            'description' => $restaurant->description,
            'address' => $restaurant->address,
            'city' => $restaurant->city,
            'phone' => $restaurant->phone,
            'email' => $restaurant->email,
            'logo_url' => $restaurant->logo_url,
            'cover_image_url' => $restaurant->cover_image_url,
            'gallery_images' => $restaurant->gallery_images,
            'opening_hours' => $restaurant->opening_hours,
            'delivery_fee' => $restaurant->delivery_fee,
            'minimum_order_amount' => $restaurant->minimum_order_amount,
            'average_rating' => round($averageRating, 1),
            'total_reviews' => $totalReviews,
            'is_open' => $this->isRestaurantOpen($restaurant),
            'theme_colors' => $restaurant->theme_colors,
            'categories' => $restaurant->categories->map(function($category) {
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
            'reviews' => $restaurant->reviews->map(function($review) {
                return [
                    'id' => $review->id,
                    'customer_name' => $review->customer_name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at->format('d/m/Y'),
                    'restaurant_reply' => $review->restaurant_reply
                ];
            })
        ];

        return response()->json([
            'success' => true,
            'data' => $restaurantData
        ]);
    }

    /**
     * Vérifie si le restaurant est ouvert
     */
    private function isRestaurantOpen(Restaurant $restaurant): bool
    {
        if (!$restaurant->opening_hours) {
            return true; // Si pas d'horaires définis, considérer comme ouvert
        }

        $openingHours = json_decode($restaurant->opening_hours, true);
        $currentDay = strtolower(now()->format('l')); // Monday, Tuesday, etc.
        $currentTime = now()->format('H:i');

        if (!isset($openingHours[$currentDay]) || !$openingHours[$currentDay]['is_open']) {
            return false;
        }

        $openTime = $openingHours[$currentDay]['open_time'];
        $closeTime = $openingHours[$currentDay]['close_time'];

        return $currentTime >= $openTime && $currentTime <= $closeTime;
    }

    /**
     * Formate les données d'un produit
     */
    private function formatProduct($product): array
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
            'ingredients' => $product->ingredients,
            'allergens' => $product->allergens,
            'nutritional_info' => $product->nutritional_info,
            'sort_order' => $product->sort_order
        ];
    }
}

