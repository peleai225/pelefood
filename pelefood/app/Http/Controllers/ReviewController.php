<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Afficher le formulaire d'avis
     */
    public function showReviewForm($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        // Vérifier si l'avis existe déjà
        $existingReview = Review::where('order_id', $order->id)->first();
        
        return view('restaurant.public.review', compact('order', 'existingReview'));
    }
    
    /**
     * Soumettre un avis
     */
    public function store(Request $request, $orderNumber)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:500',
            'food_quality' => 'required|integer|min:1|max:5',
            'service_quality' => 'required|integer|min:1|max:5',
            'delivery_speed' => 'required|integer|min:1|max:5',
            'value_for_money' => 'required|integer|min:1|max:5'
        ]);
        
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        // Vérifier si l'avis existe déjà
        $existingReview = Review::where('order_id', $order->id)->first();
        
        if ($existingReview) {
            // Mettre à jour l'avis existant
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'food_quality' => $request->food_quality,
                'service_quality' => $request->service_quality,
                'delivery_speed' => $request->delivery_speed,
                'value_for_money' => $request->value_for_money,
                'updated_at' => now()
            ]);
            
            $review = $existingReview;
        } else {
            // Créer un nouvel avis
            $review = Review::create([
                'order_id' => $order->id,
                'restaurant_id' => $order->restaurant_id,
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'food_quality' => $request->food_quality,
                'service_quality' => $request->service_quality,
                'delivery_speed' => $request->delivery_speed,
                'value_for_money' => $request->value_for_money,
                'is_verified' => true
            ]);
        }
        
        // Mettre à jour la note moyenne du restaurant
        $this->updateRestaurantRating($order->restaurant_id);
        
        return redirect()->route('restaurant.tracking', $orderNumber)
            ->with('success', 'Votre avis a été enregistré avec succès !');
    }
    
    /**
     * Mettre à jour la note moyenne du restaurant
     */
    private function updateRestaurantRating($restaurantId)
    {
        $restaurant = Restaurant::find($restaurantId);
        $averageRating = Review::where('restaurant_id', $restaurantId)->avg('rating');
        
        $restaurant->update([
            'average_rating' => round($averageRating, 1),
            'reviews_count' => Review::where('restaurant_id', $restaurantId)->count()
        ]);
    }
    
    /**
     * Afficher tous les avis d'un restaurant
     */
    public function showRestaurantReviews($restaurantSlug)
    {
        $restaurant = Restaurant::where('slug', $restaurantSlug)->firstOrFail();
        $reviews = Review::where('restaurant_id', $restaurant->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('restaurant.public.reviews', compact('restaurant', 'reviews'));
    }
}
