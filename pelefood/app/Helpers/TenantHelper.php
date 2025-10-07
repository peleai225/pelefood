<?php

namespace App\Helpers;

use App\Models\Tenant;

class TenantHelper
{
    /**
     * Obtenir le tenant actuel
     */
    public static function current()
    {
        return session('current_tenant');
    }
    
    /**
     * Obtenir l'ID du tenant actuel
     */
    public static function currentId()
    {
        $tenant = self::current();
        return $tenant ? $tenant->id : null;
    }
    
    /**
     * Vérifier si un tenant est actuellement actif
     */
    public static function hasCurrent()
    {
        return session()->has('current_tenant');
    }
    
    /**
     * Définir le tenant actuel
     */
    public static function setCurrent(Tenant $tenant)
    {
        session(['current_tenant' => $tenant]);
    }
    
    /**
     * Effacer le tenant actuel
     */
    public static function clearCurrent()
    {
        session()->forget('current_tenant');
    }
    
    /**
     * Obtenir la configuration du tenant actuel
     */
    public static function config($key = null, $default = null)
    {
        $tenant = self::current();
        
        if (!$tenant) {
            return $default;
        }
        
        if ($key === null) {
            return $tenant->settings;
        }
        
        return data_get($tenant->settings, $key, $default);
    }
    
    /**
     * Obtenir l'URL du tenant actuel
     */
    public static function url($path = '')
    {
        $tenant = self::current();
        
        if (!$tenant) {
            return url($path);
        }
        
        return 'https://' . $tenant->subdomain . '.pelefood.ci' . ($path ? '/' . ltrim($path, '/') : '');
    }
} 