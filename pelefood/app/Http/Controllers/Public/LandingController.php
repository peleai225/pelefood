<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;
use App\Models\Video;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Statistiques pour la landing page
        $stats = [
            'restaurants' => Restaurant::count(),
            'users' => User::count(),
            'orders' => Order::count(),
            'revenue' => Order::where('status', 'delivered')->sum('total_amount')
        ];

        // Vidéo mise en avant (correction du problème de vidéo)
        $featuredVideo = Video::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->first();

        // Plans de souscription - tous les plans actifs du backoffice
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('created_at', 'asc')   // Par ordre de création
            ->get();


        return view('landing.index', compact('stats', 'featuredVideo', 'plans'));
    }
}
