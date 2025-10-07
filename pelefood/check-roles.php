<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "🔍 Vérification des rôles et permissions...\n\n";
    
    // Vérifier les rôles
    $roles = \Spatie\Permission\Models\Role::all();
    echo "📋 Rôles trouvés (" . $roles->count() . "):\n";
    foreach ($roles as $role) {
        echo "   - {$role->name} (ID: {$role->id})\n";
    }
    
    echo "\n🔑 Permissions trouvées:\n";
    $permissions = \Spatie\Permission\Models\Permission::all();
    foreach ($permissions as $permission) {
        echo "   - {$permission->name}\n";
    }
    
    echo "\n👥 Utilisateurs et leurs rôles:\n";
    $users = \App\Models\User::all();
    foreach ($users as $user) {
        echo "   - {$user->email} (rôle DB: {$user->role})\n";
        if (method_exists($user, 'getRoleNames')) {
            $spatieRoles = $user->getRoleNames();
            echo "     Rôles Spatie: " . ($spatieRoles->count() > 0 ? implode(', ', $spatieRoles->toArray()) : 'Aucun') . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
} 