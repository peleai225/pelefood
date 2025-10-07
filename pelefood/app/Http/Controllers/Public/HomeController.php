<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil avec des données réelles
     */
    public function index()
    {
        // Récupérer les données réelles depuis la base de données
        $featuredRestaurants = Restaurant::with(['user', 'reviews'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get()
            ->map(function($restaurant) {
                $averageRating = $restaurant->reviews()->avg('rating') ?? 0;
                $totalReviews = $restaurant->reviews()->count();
                
                return [
                    'id' => $restaurant->id,
                    'name' => $restaurant->name,
                    'slug' => $restaurant->slug,
                    'description' => $restaurant->description,
                    'address' => $restaurant->address,
                    'city' => $restaurant->city,
                    'logo_url' => $restaurant->logo_url,
                    'cover_image_url' => $restaurant->cover_image_url,
                    'average_rating' => round($averageRating, 1),
                    'total_reviews' => $totalReviews,
                    'is_open' => $this->isRestaurantOpen($restaurant),
                    'delivery_fee' => $restaurant->delivery_fee,
                    'minimum_order_amount' => $restaurant->minimum_order_amount
                ];
            });

        $popularProducts = Product::with(['restaurant', 'category'])
            ->where('is_available', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'formatted_price' => number_format($product->price, 0, ',', ' ') . ' FCFA',
                    'image_url' => $product->image_url,
                    'restaurant' => [
                        'name' => $product->restaurant->name,
                        'slug' => $product->restaurant->slug
                    ],
                    'category' => $product->category ? $product->category->name : null
                ];
            });

        $categories = Category::withCount('products')
            ->where('is_active', true)
            ->orderBy('products_count', 'desc')
            ->limit(8)
            ->get()
            ->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'image_url' => $category->image_url,
                    'products_count' => $category->products_count
                ];
            });

        $recentReviews = Review::with(['restaurant'])
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get()
            ->map(function($review) {
                return [
                    'id' => $review->id,
                    'customer_name' => $review->customer_name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at->format('d/m/Y'),
                    'restaurant' => [
                        'name' => $review->restaurant->name,
                        'slug' => $review->restaurant->slug
                    ]
                ];
            });

        // Statistiques globales
        $stats = [
            'total_restaurants' => Restaurant::where('is_active', true)->count(),
            'total_products' => Product::where('is_available', true)->count(),
            'total_orders' => \App\Models\Order::count(),
            'average_rating' => round(Review::where('is_approved', true)->avg('rating') ?? 0, 1)
        ];

        return view('landing.home', compact(
            'featuredRestaurants',
            'popularProducts', 
            'categories',
            'recentReviews',
            'stats'
        ));
    }

    /**
     * Vérifier si un restaurant est ouvert
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
}

