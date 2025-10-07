<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 TEST DES RÔLES ET AUTHENTIFICATION\n";
echo "=====================================\n\n";

try {
    // Vérifier les rôles
    echo "1️⃣ Vérification des rôles...\n";
    $roles = \Spatie\Permission\Models\Role::all();
    echo "   Nombre de rôles trouvés: " . $roles->count() . "\n";
    
    if ($roles->count() > 0) {
        foreach ($roles as $role) {
            echo "   - " . $role->name . "\n";
        }
    } else {
        echo "   ❌ Aucun rôle trouvé\n";
    }
    
    // Vérifier les utilisateurs
    echo "\n2️⃣ Vérification des utilisateurs...\n";
    $users = \App\Models\User::all();
    echo "   Nombre d'utilisateurs: " . $users->count() . "\n";
    
    if ($users->count() > 0) {
        foreach ($users as $user) {
            echo "   - " . $user->email . " (rôle: " . $user->role . ")\n";
        }
    }
    
    // Vérifier la configuration de la base de données
    echo "\n3️⃣ Test de connexion à la base de données...\n";
    try {
        \DB::connection()->getPdo();
        echo "   ✅ Connexion à la base de données réussie\n";
        echo "   Base de données: " . \DB::connection()->getDatabaseName() . "\n";
    } catch (Exception $e) {
        echo "   ❌ Erreur de connexion à la base de données: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
}

echo "\n🎯 TEST TERMINÉ\n";
?> 