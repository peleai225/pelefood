<?php

if (!function_exists('currency')) {
    /**
     * Format a number as currency
     *
     * @param float $amount
     * @param string $currency
     * @return string
     */
    function currency($amount, $currency = null)
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
}

if (!function_exists('currency_symbol')) {
    /**
     * Get currency symbol
     *
     * @param string $currency
     * @return string
     */
    function currency_symbol($currency = null)
    {
        return $currency ?: config('app.currency_symbol', 'FCFA');
    }
}
