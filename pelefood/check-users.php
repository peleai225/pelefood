<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== VÉRIFICATION DES UTILISATEURS ===\n\n";

// Vérifier tous les utilisateurs
$users = \App\Models\User::with('roles')->get();

if ($users->count() > 0) {
    echo "Utilisateurs existants :\n";
    foreach ($users as $user) {
        $roles = $user->roles->pluck('name')->join(', ');
        echo "- {$user->name} ({$user->email}) - Rôles: {$roles}\n";
    }
} else {
    echo "Aucun utilisateur trouvé.\n";
}

echo "\n=== VÉRIFICATION DES RÔLES ===\n";

// Vérifier les rôles existants
$roles = \Spatie\Permission\Models\Role::all();
if ($roles->count() > 0) {
    echo "Rôles disponibles :\n";
    foreach ($roles as $role) {
        echo "- {$role->name}\n";
    }
} else {
    echo "Aucun rôle trouvé.\n";
}

echo "\n=== VÉRIFICATION DES PERMISSIONS ===\n";

// Vérifier les permissions existantes
$permissions = \Spatie\Permission\Models\Permission::all();
if ($permissions->count() > 0) {
    echo "Permissions disponibles :\n";
    foreach ($permissions as $permission) {
        echo "- {$permission->name}\n";
    }
} else {
    echo "Aucune permission trouvée.\n";
}

echo "\n=== FIN DE LA VÉRIFICATION ===\n";
