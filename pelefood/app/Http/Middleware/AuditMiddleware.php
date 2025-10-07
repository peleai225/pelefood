<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuditMiddleware
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
        
        // Auditer les actions sensibles
        if ($this->isSensitiveAction($request)) {
            $this->logAudit($request, $response);
        }
        
        return $response;
    }
    
    /**
     * Déterminer si l'action est sensible
     */
    private function isSensitiveAction(Request $request): bool
    {
        $sensitiveMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];
        $sensitiveRoutes = [
            'admin/users/*',
            'admin/restaurants/*',
            'admin/tenants/*',
            'restaurant/products/*',
            'restaurant/orders/*',
            'restaurant/settings/*',
            'auth/*',
            'webhook/*',
        ];
        
        if (!in_array($request->method(), $sensitiveMethods)) {
            return false;
        }
        
        foreach ($sensitiveRoutes as $route) {
            if ($request->is($route)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Logger l'audit
     */
    private function logAudit(Request $request, $response): void
    {
        $user = Auth::user();
        
        Log::channel('audit')->info('Audit Action', [
            'user_id' => $user ? $user->id : null,
            'user_email' => $user ? $user->email : null,
            'user_role' => $user ? $user->role : null,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_data' => $this->sanitizeData($request->all()),
            'response_status' => $response->getStatusCode(),
            'timestamp' => now()->toISOString(),
        ]);
    }
    
    /**
     * Sanitiser les données sensibles
     */
    private function sanitizeData(array $data): array
    {
        $sensitiveFields = ['password', 'password_confirmation', 'token', 'api_key', 'secret'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '***HIDDEN***';
            }
        }
        
        return $data;
    }
} 