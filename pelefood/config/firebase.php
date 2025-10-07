<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour l'intégration Firebase avec PeleFood
    |
    */

    'project_id' => env('FIREBASE_PROJECT_ID', 'pelefood-saas'),
    'api_key' => env('FIREBASE_API_KEY'),
    'auth_domain' => env('FIREBASE_AUTH_DOMAIN'),
    'database_url' => env('FIREBASE_DATABASE_URL'),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET'),
    'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID'),
    'app_id' => env('FIREBASE_APP_ID'),

    /*
    |--------------------------------------------------------------------------
    | Firebase Services Configuration
    |--------------------------------------------------------------------------
    */

    'services' => [
        'auth' => [
            'enabled' => env('FIREBASE_AUTH_ENABLED', true),
            'providers' => [
                'email' => true,
                'google' => true,
                'phone' => false,
            ],
        ],
        
        'firestore' => [
            'enabled' => env('FIREBASE_FIRESTORE_ENABLED', true),
            'collections' => [
                'orders' => 'orders',
                'restaurants' => 'restaurants',
                'users' => 'users',
                'notifications' => 'notifications',
                'analytics' => 'analytics',
            ],
        ],
        
        'realtime_database' => [
            'enabled' => env('FIREBASE_RTDB_ENABLED', true),
            'rules' => [
                'orders' => [
                    'read' => 'auth != null',
                    'write' => 'auth != null && (auth.token.role == "admin" || auth.token.role == "restaurant")',
                ],
                'notifications' => [
                    'read' => 'auth != null',
                    'write' => 'auth != null && auth.token.role == "admin"',
                ],
            ],
        ],
        
        'messaging' => [
            'enabled' => env('FIREBASE_MESSAGING_ENABLED', true),
            'topics' => [
                'new_orders' => 'new_orders',
                'payment_updates' => 'payment_updates',
                'system_alerts' => 'system_alerts',
            ],
        ],
        
        'analytics' => [
            'enabled' => env('FIREBASE_ANALYTICS_ENABLED', true),
            'events' => [
                'order_created' => 'order_created',
                'payment_completed' => 'payment_completed',
                'restaurant_registered' => 'restaurant_registered',
                'user_login' => 'user_login',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Security Rules
    |--------------------------------------------------------------------------
    */

    'security_rules' => [
        'firestore' => [
            'rules' => [
                'orders' => [
                    'read' => 'request.auth != null && (request.auth.token.role == "admin" || request.auth.token.role == "restaurant")',
                    'write' => 'request.auth != null && request.auth.token.role == "admin"',
                ],
                'restaurants' => [
                    'read' => 'request.auth != null',
                    'write' => 'request.auth != null && request.auth.token.role == "admin"',
                ],
                'users' => [
                    'read' => 'request.auth != null && request.auth.token.role == "admin"',
                    'write' => 'request.auth != null && request.auth.token.role == "admin"',
                ],
            ],
        ],
        
        'realtime_database' => [
            'rules' => [
                '.read' => 'auth != null',
                '.write' => 'auth != null && auth.token.role == "admin"',
                'orders' => [
                    '.read' => 'auth != null && (auth.token.role == "admin" || auth.token.role == "restaurant")',
                    '.write' => 'auth != null && auth.token.role == "admin"',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Webhooks
    |--------------------------------------------------------------------------
    */

    'webhooks' => [
        'enabled' => env('FIREBASE_WEBHOOKS_ENABLED', true),
        'endpoints' => [
            'order_created' => '/api/firebase/webhooks/order-created',
            'payment_completed' => '/api/firebase/webhooks/payment-completed',
            'user_registered' => '/api/firebase/webhooks/user-registered',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Admin SDK
    |--------------------------------------------------------------------------
    */

    'admin' => [
        'service_account' => [
            'type' => 'service_account',
            'project_id' => env('FIREBASE_PROJECT_ID'),
            'private_key_id' => env('FIREBASE_PRIVATE_KEY_ID'),
            'private_key' => env('FIREBASE_PRIVATE_KEY'),
            'client_email' => env('FIREBASE_CLIENT_EMAIL'),
            'client_id' => env('FIREBASE_CLIENT_ID'),
            'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'token_uri' => 'https://oauth2.googleapis.com/token',
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => env('FIREBASE_CLIENT_CERT_URL'),
        ],
    ],
]; 