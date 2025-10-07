<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DIAGNOSTIC NAVBAR ===\n\n";

// Vérifier l'utilisateur connecté
$user = auth()->user();

if ($user) {
    echo "✅ Utilisateur connecté :\n";
    echo "- Nom : {$user->name}\n";
    echo "- Email : {$user->email}\n";
    echo "- Rôle : {$user->role}\n";
    echo "- ID : {$user->id}\n";
    
    // Vérifier les méthodes disponibles
    echo "\n🔍 Méthodes disponibles :\n";
    echo "- hasRole('super_admin') : " . ($user->hasRole('super_admin') ? 'OUI' : 'NON') . "\n";
    echo "- hasRole('admin') : " . ($user->hasRole('admin') ? 'OUI' : 'NON') . "\n";
    echo "- hasRole('restaurant') : " . ($user->hasRole('restaurant') ? 'OUI' : 'NON') . "\n";
    
    // Vérifier isSuperAdmin
    if (method_exists($user, 'isSuperAdmin')) {
        echo "- isSuperAdmin() : " . ($user->isSuperAdmin() ? 'OUI' : 'NON') . "\n";
    } else {
        echo "- isSuperAdmin() : MÉTHODE N'EXISTE PAS\n";
    }
    
    echo "\n🎯 Conditions navbar :\n";
    echo "- isSuperAdmin() : " . (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin() ? 'OUI' : 'NON') . "\n";
    echo "- role === 'admin' : " . ($user->role === 'admin' ? 'OUI' : 'NON') . "\n";
    echo "- role === 'restaurant' : " . ($user->role === 'restaurant' ? 'OUI' : 'NON') . "\n";
    
} else {
    echo "❌ Aucun utilisateur connecté\n";
}

echo "\n=== FIN DU DIAGNOSTIC ===\n";
