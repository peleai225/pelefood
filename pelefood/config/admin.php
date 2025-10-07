<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration du Backoffice Administrateur
    |--------------------------------------------------------------------------
    |
    | Ce fichier contient la configuration pour optimiser les performances
    | du backoffice administrateur de PeleFood.
    |
    */

    'performance' => [
        // Durée de cache en secondes pour les données fréquemment utilisées
        'cache_duration' => [
            'dashboard_stats' => 300, // 5 minutes
            'recent_data' => 300, // 5 minutes
            'lists' => 600, // 10 minutes
            'reports' => 1800, // 30 minutes
        ],

        // Nombre d'éléments à afficher par page
        'pagination' => [
            'restaurants' => 15,
            'orders' => 20,
            'users' => 20,
            'tenants' => 15,
        ],

        // Optimisations de requêtes
        'query_optimization' => [
            'eager_loading' => true,
            'select_specific_columns' => true,
            'use_cache' => true,
        ],
    ],

    'features' => [
        // Fonctionnalités activées dans le backoffice
        'dashboard' => true,
        'restaurant_management' => true,
        'tenant_management' => true,
        'subscription_management' => true,
        'order_management' => true,
        'user_management' => true,
        'reports' => true,
    ],

    'security' => [
        // Configuration de sécurité
        'session_timeout' => 3600, // 1 heure
        'max_login_attempts' => 5,
        'lockout_duration' => 900, // 15 minutes
    ],
]; 