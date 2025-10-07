<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequests
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
        $startTime = microtime(true);
        
        $response = $next($request);
        
        $duration = microtime(true) - $startTime;
        
        // Logger les requêtes importantes
        if ($this->shouldLog($request)) {
            Log::channel('requests')->info('HTTP Request', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => auth()->id(),
                'status_code' => $response->getStatusCode(),
                'duration' => round($duration * 1000, 2) . 'ms',
                'timestamp' => now()->toISOString(),
            ]);
        }
        
        return $response;
    }
    
    /**
     * Déterminer si la requête doit être loggée
     */
    private function shouldLog(Request $request): bool
    {
        // Ignorer les requêtes statiques
        if ($request->is('*.css') || $request->is('*.js') || $request->is('*.png') || $request->is('*.jpg')) {
            return false;
        }
        
        // Logger les actions sensibles
        $sensitiveRoutes = [
            'admin/*',
            'restaurant/*',
            'auth/*',
            'webhook/*',
            'payment/*',
        ];
        
        foreach ($sensitiveRoutes as $route) {
            if ($request->is($route)) {
                return true;
            }
        }
        
        return false;
    }
} 