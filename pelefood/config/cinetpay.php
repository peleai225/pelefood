<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CinetPay Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour l'intégration CinetPay
    | CinetPay est une solution de paiement pour l'Afrique de l'Ouest
    |
    */

    'api_key' => env('CINETPAY_API_KEY', '133206781683efbd05ee275.73048540'),
    'site_id' => env('CINETPAY_SITE_ID', '105897148'),
    'secret_key' => env('CINETPAY_SECRET_KEY', '1671717002683efc06e57276.37360777'),
    
    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | Détermine si CinetPay fonctionne en mode test ou production
    |
    */
    
    'environment' => env('CINETPAY_ENVIRONMENT', 'test'), // 'test' ou 'prod'
    
    /*
    |--------------------------------------------------------------------------
    | URLs CinetPay
    |--------------------------------------------------------------------------
    |
    | URLs des API CinetPay selon l'environnement
    |
    */
    
    'urls' => [
        'test' => [
            'base_url' => 'https://api-checkout.cinetpay.com/v2',
            'payment_url' => 'https://secure.cinetpay.com',
        ],
        'prod' => [
            'base_url' => 'https://api-checkout.cinetpay.com/v2',
            'payment_url' => 'https://secure.cinetpay.com',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuration des Paiements
    |--------------------------------------------------------------------------
    |
    | Configuration par défaut pour les paiements
    |
    */
    
    'currency' => 'XOF', // Franc CFA
    'lang' => 'fr', // Langue par défaut
    'notify_url' => env('APP_URL') . '/api/cinetpay/notify',
    'return_url' => env('APP_URL') . '/api/cinetpay/return',
    'cancel_url' => env('APP_URL') . '/api/cinetpay/cancel',
    
    /*
    |--------------------------------------------------------------------------
    | Méthodes de Paiement Supportées
    |--------------------------------------------------------------------------
    |
    | Liste des méthodes de paiement supportées par CinetPay
    |
    */
    
    'payment_methods' => [
        'MOBILE_MONEY' => [
            'ORANGE_MONEY' => 'orange_money',
            'MTN_MONEY' => 'mtn_money',
            'MOOV_MONEY' => 'moov_money',
        ],
        'CARD' => [
            'VISA' => 'visa',
            'MASTERCARD' => 'mastercard',
        ],
        'BANK_TRANSFER' => [
            'BANK_CARD' => 'bank_card',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuration des Timeouts
    |--------------------------------------------------------------------------
    |
    | Timeouts pour les requêtes vers l'API CinetPay
    |
    */
    
    'timeout' => 30, // secondes
    'connect_timeout' => 10, // secondes
    
    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Configuration du logging pour CinetPay
    |
    */
    
    'log_requests' => env('CINETPAY_LOG_REQUESTS', true),
    'log_responses' => env('CINETPAY_LOG_RESPONSES', true),
];
