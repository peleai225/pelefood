<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    /**
     * Obtenir la devise principale
     */
    public static function getCurrency()
    {
        return Setting::getValue('currency', 'XOF');
    }

    /**
     * Obtenir le symbole de la devise
     */
    public static function getCurrencySymbol()
    {
        $currency = self::getCurrency();
        $symbols = [
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
            'JPY' => '¥',
            'XOF' => 'FCFA',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'CHF' => 'CHF',
            'CNY' => '¥',
            'INR' => '₹',
            'BRL' => 'R$',
            'MXN' => '$',
            'RUB' => '₽',
            'ZAR' => 'R',
            'NGN' => '₦',
            'EGP' => 'E£',
            'MAD' => 'MAD',
            'TND' => 'DT',
            'DZD' => 'DA',
        ];
        
        return $symbols[$currency] ?? $currency;
    }

    /**
     * Formater un montant avec la devise
     */
    public static function formatAmount($amount, $decimals = 2)
    {
        $currency = self::getCurrency();
        $symbol = self::getCurrencySymbol();
        
        // Format selon la devise
        switch ($currency) {
            case 'XOF':
            case 'JPY':
                return number_format($amount, 0) . ' ' . $symbol;
            default:
                return number_format($amount, $decimals) . ' ' . $symbol;
        }
    }

    /**
     * Obtenir le nom de la plateforme
     */
    public static function getPlatformName()
    {
        return Setting::getValue('platform_name', 'PeleFood');
    }

    /**
     * Obtenir l'URL de la plateforme
     */
    public static function getPlatformUrl()
    {
        return Setting::getValue('platform_url', 'https://pelefood.com');
    }

    /**
     * Obtenir l'email de contact
     */
    public static function getContactEmail()
    {
        return Setting::getValue('contact_email', 'contact@pelefood.com');
    }

    /**
     * Obtenir le téléphone de contact
     */
    public static function getContactPhone()
    {
        return Setting::getValue('contact_phone', '+33 1 23 45 67 89');
    }

    /**
     * Obtenir la description de la plateforme
     */
    public static function getPlatformDescription()
    {
        return Setting::getValue('platform_description', 'Plateforme de gestion de restaurants et de commandes en ligne');
    }

    /**
     * Obtenir le fuseau horaire
     */
    public static function getTimezone()
    {
        return Setting::getValue('timezone', 'Europe/Paris');
    }

    /**
     * Obtenir la langue par défaut
     */
    public static function getDefaultLanguage()
    {
        return Setting::getValue('default_language', 'fr');
    }

    /**
     * Obtenir le format des nombres
     */
    public static function getNumberFormat()
    {
        return Setting::getValue('number_format', 'fr');
    }
}
