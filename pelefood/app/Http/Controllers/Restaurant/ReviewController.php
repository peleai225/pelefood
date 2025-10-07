<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.role:restaurant,admin,super_admin']);
    }

    protected function getCurrentRestaurant()
    {
        $user = auth()->user();
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

        // Récupérer les avis du restaurant
        $reviews = $restaurant->reviews()
            ->with(['customer', 'products'])
            ->latest()
            ->paginate(20);

        // Calculer les statistiques
        $totalReviews = $restaurant->reviews()->count();
        $averageRating = $restaurant->reviews()->avg('rating') ?? 0;
        $pendingReviews = $restaurant->reviews()->where('status', 'pending')->count();
        $approvedReviews = $restaurant->reviews()->where('status', 'approved')->count();

        // Calculer la répartition des notes
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $restaurant->reviews()->where('rating', $i)->count();
            $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
            
            $ratingDistribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        $stats = [
            'total_reviews' => $totalReviews,
            'average_rating' => round($averageRating, 1),
            'pending_reviews' => $pendingReviews,
            'approved_reviews' => $approvedReviews,
        ];

        return view('restaurant.reviews.index', compact('reviews', 'ratingDistribution', 'stats'));
    }

    public function approve(Review $review)
    {
        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant || $review->restaurant_id !== $restaurant->id) {
            return redirect()->back()->with('error', 'Avis non trouvé.');
        }

        $review->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Avis approuvé avec succès.');
    }

    public function reject(Review $review)
    {
        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant || $review->restaurant_id !== $restaurant->id) {
            return redirect()->back()->with('error', 'Avis non trouvé.');
        }

        $review->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Avis rejeté avec succès.');
    }

    public function reply(Request $request, Review $review)
    {
        $restaurant = $this->getCurrentRestaurant();
        
        if (!$restaurant || $review->restaurant_id !== $restaurant->id) {
            return redirect()->back()->with('error', 'Avis non trouvé.');
        }

        $request->validate([
            'restaurant_reply' => 'required|string|max:1000'
        ]);

        $review->update([
            'restaurant_reply' => $request->restaurant_reply,
            'reply_date' => now()
        ]);

        return redirect()->back()->with('success', 'Réponse ajoutée avec succès.');
    }
}
