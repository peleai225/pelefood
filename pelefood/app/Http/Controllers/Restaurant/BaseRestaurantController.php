<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class BaseRestaurantController extends Controller
{
    /**
     * Le restaurant actuel
     */
    protected $restaurant;

    /**
     * Constructeur qui vérifie l'authentification et le restaurant
     */
    public function __construct()
    {
        $this->middleware('restaurant.owner');
    }

    /**
     * Récupérer le restaurant actuel depuis la requête
     */
    protected function getRestaurantFromRequest(Request $request)
    {
        return $request->get('current_restaurant');
    }

    /**
     * Vérifier que l'utilisateur est authentifié
     */
    protected function ensureAuthenticated()
    {
        if (!Auth::check()) {
            abort(401, 'Non authentifié');
        }
    }

    /**
     * Vérifier que l'utilisateur a un restaurant
     */
    protected function ensureRestaurant(Request $request)
    {
        $restaurant = $this->getRestaurantFromRequest($request);
        
        if (!$restaurant) {
            abort(403, 'Restaurant non trouvé');
        }
        
        return $restaurant;
    }
}
