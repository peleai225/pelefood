<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Format a number as currency
     *
     * @param float $amount
     * @param string $currency
     * @return string
     */
    public static function format($amount, $currency = null)
    {
        $currency = $currency ?: config('app.currency', 'FCFA');
        $currencyCode = config('app.currency_code', 'XOF');
        
        // Format for FCFA (West African CFA franc)
        if ($currencyCode === 'XOF' || $currency === 'FCFA') {
            return number_format($amount, 0, ',', ' ') . ' FCFA';
        }
        
        // Format for other currencies
        return $currency . ' ' . number_format($amount, 2, '.', ',');
    }

    /**
     * Get currency symbol
     *
     * @param string $currency
     * @return string
     */
    public static function symbol($currency = null)
    {
        return $currency ?: config('app.currency_symbol', 'FCFA');
    }

    /**
     * Get currency code
     *
     * @return string
     */
    public static function code()
    {
        return config('app.currency_code', 'XOF');
    }

    /**
     * Convert amount to cents (for payment processing)
     *
     * @param float $amount
     * @return int
     */
    public static function toCents($amount)
    {
        return (int) round($amount * 100);
    }

    /**
     * Convert cents to amount
     *
     * @param int $cents
     * @return float
     */
    public static function fromCents($cents)
    {
        return $cents / 100;
    }

    /**
     * Get available currencies
     *
     * @return array
     */
    public static function available()
    {
        return [
            'FCFA' => [
                'code' => 'XOF',
                'symbol' => 'FCFA',
                'name' => 'Franc CFA (Afrique de l\'Ouest)',
                'country' => 'Côte d\'Ivoire'
            ],
            'EUR' => [
                'code' => 'EUR',
                'symbol' => '€',
                'name' => 'Euro',
                'country' => 'Europe'
            ],
            'USD' => [
                'code' => 'USD',
                'symbol' => '$',
                'name' => 'Dollar américain',
                'country' => 'États-Unis'
            ]
        ];
    }
}