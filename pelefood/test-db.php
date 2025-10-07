<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $pdo = DB::connection()->getPdo();
    echo "✅ Connexion à la base de données réussie\n";
    
    // Test des rôles
    $roles = \Spatie\Permission\Models\Role::all();
    echo "✅ Rôles trouvés: " . $roles->count() . "\n";
    
    // Test des utilisateurs
    $users = \App\Models\User::all();
    echo "✅ Utilisateurs trouvés: " . $users->count() . "\n";
    
    if ($users->count() > 0) {
        $user = $users->first();
        echo "✅ Premier utilisateur: " . $user->email . " (rôle: " . $user->role . ")\n";
        
        if (method_exists($user, 'hasRole')) {
            echo "✅ Méthode hasRole disponible\n";
            foreach ($roles as $role) {
                echo "   - Rôle {$role->name}: " . ($user->hasRole($role->name) ? 'OUI' : 'NON') . "\n";
            }
        } else {
            echo "❌ Méthode hasRole non disponible\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
} 