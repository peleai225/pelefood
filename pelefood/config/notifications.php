<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration des notifications PeleFood
    |--------------------------------------------------------------------------
    */

    'channels' => [
        'database' => [
            'enabled' => env('NOTIFICATIONS_DATABASE', true),
        ],
        
        'broadcast' => [
            'enabled' => env('NOTIFICATIONS_BROADCAST', true),
            'driver' => env('BROADCAST_DRIVER', 'pusher'),
        ],
        
        'mail' => [
            'enabled' => env('NOTIFICATIONS_MAIL', true),
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'noreply@pelefood.com'),
                'name' => env('MAIL_FROM_NAME', 'PeleFood'),
            ],
        ],
        
        'sms' => [
            'enabled' => env('NOTIFICATIONS_SMS', false),
            'driver' => env('SMS_DRIVER', 'nexmo'),
            'nexmo' => [
                'api_key' => env('NEXMO_API_KEY'),
                'api_secret' => env('NEXMO_API_SECRET'),
                'from' => env('NEXMO_FROM', 'PeleFood'),
            ],
            'twilio' => [
                'sid' => env('TWILIO_SID'),
                'token' => env('TWILIO_TOKEN'),
                'from' => env('TWILIO_FROM'),
            ],
        ],
        
        'slack' => [
            'enabled' => env('NOTIFICATIONS_SLACK', false),
            'webhook_url' => env('SLACK_WEBHOOK_URL'),
            'channel' => env('SLACK_CHANNEL', '#notifications'),
            'username' => env('SLACK_USERNAME', 'PeleFood Bot'),
        ],
        
        'push' => [
            'enabled' => env('NOTIFICATIONS_PUSH', false),
            'driver' => env('PUSH_DRIVER', 'firebase'),
            'firebase' => [
                'server_key' => env('FIREBASE_SERVER_KEY'),
                'project_id' => env('FIREBASE_PROJECT_ID'),
            ],
        ],
    ],

    'types' => [
        'order' => [
            'new_order' => [
                'title' => 'Nouvelle commande reçue',
                'message' => 'Vous avez reçu une nouvelle commande #{order_number}',
                'channels' => ['database', 'broadcast'],
            ],
            'order_updated' => [
                'title' => 'Commande mise à jour',
                'message' => 'La commande #{order_number} a été mise à jour',
                'channels' => ['database', 'broadcast'],
            ],
            'order_cancelled' => [
                'title' => 'Commande annulée',
                'message' => 'La commande #{order_number} a été annulée',
                'channels' => ['database', 'broadcast', 'mail'],
            ],
        ],
        
        'payment' => [
            'payment_received' => [
                'title' => 'Paiement reçu',
                'message' => 'Paiement de {amount} reçu pour la commande #{order_number}',
                'channels' => ['database', 'broadcast', 'mail'],
            ],
            'payment_failed' => [
                'title' => 'Échec du paiement',
                'message' => 'Le paiement pour la commande #{order_number} a échoué',
                'channels' => ['database', 'broadcast', 'mail'],
            ],
        ],
        
        'subscription' => [
            'trial_expiring' => [
                'title' => 'Période d\'essai expire bientôt',
                'message' => 'Votre période d\'essai expire dans {days} jour(s)',
                'channels' => ['database', 'broadcast', 'mail'],
            ],
            'subscription_expired' => [
                'title' => 'Abonnement expiré',
                'message' => 'Votre abonnement a expiré. Renouvelez pour continuer à utiliser le service.',
                'channels' => ['database', 'broadcast', 'mail'],
            ],
        ],
        
        'system' => [
            'maintenance' => [
                'title' => 'Maintenance programmée',
                'message' => 'Une maintenance est programmée le {date} à {time}',
                'channels' => ['database', 'broadcast', 'mail'],
            ],
            'update' => [
                'title' => 'Mise à jour disponible',
                'message' => 'Une nouvelle version est disponible avec des améliorations',
                'channels' => ['database', 'broadcast'],
            ],
        ],
    ],

    'templates' => [
        'email' => [
            'order_receipt' => 'emails.order-receipt',
            'order_confirmation' => 'emails.order-confirmation',
            'subscription_reminder' => 'emails.subscription-reminder',
        ],
        
        'sms' => [
            'order_ready' => 'Votre commande #{order_number} est prête ! PeleFood',
            'order_delivered' => 'Votre commande #{order_number} a été livrée. Merci ! PeleFood',
        ],
        
        'push' => [
            'default_title' => 'PeleFood',
            'default_icon' => '/images/logo.png',
        ],
    ],

    'queue' => [
        'enabled' => env('NOTIFICATIONS_QUEUE', true),
        'connection' => env('QUEUE_CONNECTION', 'database'),
        'queue' => env('NOTIFICATIONS_QUEUE_NAME', 'notifications'),
    ],

    'rate_limiting' => [
        'enabled' => env('NOTIFICATIONS_RATE_LIMIT', true),
        'max_per_minute' => env('NOTIFICATIONS_MAX_PER_MINUTE', 60),
        'max_per_hour' => env('NOTIFICATIONS_MAX_PER_HOUR', 1000),
    ],
];
