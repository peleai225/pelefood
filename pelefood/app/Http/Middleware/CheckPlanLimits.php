<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;

class CheckPlanLimits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $feature = null)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Les super_admin n'ont pas de limites
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // Récupérer le restaurant de l'utilisateur
        $restaurant = $user->tenant?->restaurants->first();
        
        if (!$restaurant || !$restaurant->subscriptionPlan) {
            return redirect()->route('restaurant.subscription.select')
                ->with('error', 'Vous devez avoir un plan d\'abonnement actif.');
        }

        $plan = $restaurant->subscriptionPlan;

        // Vérifier les limites selon le plan
        switch ($feature) {
            case 'products':
                if ($plan->max_products && $restaurant->products()->count() >= $plan->max_products) {
                    return redirect()->back()
                        ->with('error', "Limite atteinte : {$plan->max_products} produits maximum pour le plan {$plan->name}.");
                }
                break;

            case 'categories':
                if ($plan->max_categories && $restaurant->categories()->count() >= $plan->max_categories) {
                    return redirect()->back()
                        ->with('error', "Limite atteinte : {$plan->max_categories} catégories maximum pour le plan {$plan->name}.");
                }
                break;

            case 'restaurants':
                if ($plan->max_restaurants && $user->tenant->restaurants()->count() >= $plan->max_restaurants) {
                    return redirect()->back()
                        ->with('error', "Limite atteinte : {$plan->max_restaurants} restaurants maximum pour le plan {$plan->name}.");
                }
                break;

            case 'customization':
                if (!$plan->allows_customization) {
                    return redirect()->back()
                        ->with('error', "La personnalisation n'est pas disponible avec le plan {$plan->name}.");
                }
                break;

            case 'analytics':
                if (!$plan->allows_analytics) {
                    return redirect()->back()
                        ->with('error', "Les analytics ne sont pas disponibles avec le plan {$plan->name}.");
                }
                break;

            case 'api':
                if (!$plan->allows_api) {
                    return redirect()->back()
                        ->with('error', "L'accès API n'est pas disponible avec le plan {$plan->name}.");
                }
                break;
        }

        return $next($request);
    }
} 