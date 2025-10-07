<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Config;

class TenantMiddleware
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
        // Récupérer le sous-domaine depuis l'URL
        $subdomain = $this->getSubdomain($request);
        
        if ($subdomain) {
            // Chercher le tenant par sous-domaine
            $tenant = Tenant::where('subdomain', $subdomain)
                           ->where('is_active', true)
                           ->first();
            
            if (!$tenant) {
                abort(404, 'Restaurant non trouvé ou désactivé');
            }
            
            // Stocker le tenant dans la session
            session(['current_tenant' => $tenant]);
            
            // Configurer la base de données pour ce tenant si nécessaire
            $this->configureTenant($tenant);
        }
        
        return $next($request);
    }
    
    /**
     * Extraire le sous-domaine de la requête
     */
    private function getSubdomain(Request $request)
    {
        $host = $request->getHost();
        $parts = explode('.', $host);
        
        // Si nous avons plus de 2 parties, le premier est le sous-domaine
        if (count($parts) > 2) {
            return $parts[0];
        }
        
        return null;
    }
    
    /**
     * Configurer l'environnement pour le tenant
     */
    private function configureTenant(Tenant $tenant)
    {
        // Configurer la timezone
        Config::set('app.timezone', $tenant->timezone);
        
        // Configurer la locale
        Config::set('app.locale', $tenant->language);
        
        // Configurer la devise
        Config::set('app.currency', $tenant->currency);
        
        // Autres configurations spécifiques au tenant
        Config::set('tenant', [
            'id' => $tenant->id,
            'name' => $tenant->name,
            'subdomain' => $tenant->subdomain,
            'settings' => $tenant->settings,
        ]);
    }
}
