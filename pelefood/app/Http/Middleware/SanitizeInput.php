<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitizeInput
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
        // Sanitiser les données de la requête
        $this->sanitizeRequest($request);
        
        return $next($request);
    }
    
    /**
     * Sanitiser les données de la requête
     */
    private function sanitizeRequest(Request $request): void
    {
        $input = $request->all();
        $sanitized = $this->sanitizeArray($input);
        
        // Remplacer les données de la requête
        $request->replace($sanitized);
    }
    
    /**
     * Sanitiser un tableau de données
     */
    private function sanitizeArray(array $data): array
    {
        $sanitized = [];
        
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = $this->sanitizeArray($value);
            } else {
                $sanitized[$key] = $this->sanitizeValue($value);
            }
        }
        
        return $sanitized;
    }
    
    /**
     * Sanitiser une valeur
     */
    private function sanitizeValue($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        
        // Supprimer les caractères dangereux
        $value = strip_tags($value);
        
        // Échapper les caractères spéciaux
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        
        // Supprimer les scripts potentiels
        $value = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $value);
        
        // Supprimer les expressions JavaScript
        $value = preg_replace('/javascript:/i', '', $value);
        $value = preg_replace('/on\w+\s*=/i', '', $value);
        
        // Limiter la longueur
        if (strlen($value) > 10000) {
            $value = substr($value, 0, 10000);
        }
        
        return trim($value);
    }
} 