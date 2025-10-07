<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        
        // Rediriger selon le rôle de l'utilisateur
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'admin') {
            // Les admins (gérants de restaurant) vont vers leur tableau de bord restaurant
            return redirect()->route('restaurant.dashboard');
        } elseif ($user->role === 'restaurant') {
            return redirect()->route('restaurant.dashboard');
        } else {
            // Utilisateur client - afficher le dashboard client
            return view('dashboard.client');
        }
    }
} 