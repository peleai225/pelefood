<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PerformanceMiddleware
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
        $response = $next($request);

        // Ajouter des headers de performance
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Cache pour les pages publiques
        if ($request->is('/') || $request->is('about') || $request->is('contact')) {
            $response->headers->set('Cache-Control', 'public, max-age=300'); // 5 minutes
        }
        
        // Compression pour les réponses textuelles
        if (str_contains($response->headers->get('Content-Type'), 'text/html')) {
            $response->headers->set('Vary', 'Accept-Encoding');
        }

        return $response;
    }
}
