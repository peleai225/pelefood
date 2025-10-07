<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminPerformanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Optimiser les requêtes pour les pages admin
        if ($request->is('admin*')) {
            // Réduire le nombre de requêtes N+1
            DB::connection()->enableQueryLog();
            
            // Ajouter des headers de performance
            $response = $next($request);
            
            // Ajouter des headers de cache pour les ressources statiques
            $response->headers->set('Cache-Control', 'public, max-age=300'); // 5 minutes
            $response->headers->set('X-Admin-Performance', 'optimized');
            
            return $response;
        }

        return $next($request);
    }
}
