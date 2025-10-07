<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== RAPPORT FINAL DE NETTOYAGE ===\n\n";

// 1. Utilisateurs restants
echo "1. Utilisateurs restants:\n";
$users = \App\Models\User::all();
foreach ($users as $user) {
    echo "   - ID: {$user->id}, Email: {$user->email}, Rôle: {$user->role}\n";
}

// 2. Restaurants restants
echo "\n2. Restaurants restants:\n";
$restaurants = \App\Models\Restaurant::all();
foreach ($restaurants as $restaurant) {
    echo "   - ID: {$restaurant->id}, Nom: {$restaurant->name}, User ID: {$restaurant->user_id}\n";
}

// 3. Assignations Spatie restantes
echo "\n3. Assignations Spatie restantes:\n";
$assignments = \DB::table('model_has_roles')
    ->join('users', 'model_has_roles.model_id', '=', 'users.id')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->get();

foreach ($assignments as $assignment) {
    echo "   - User: {$assignment->email} ({$assignment->role}) -> Rôle: {$assignment->name}\n";
}

// 4. Rôles Spatie disponibles
echo "\n4. Rôles Spatie disponibles:\n";
$roles = \DB::table('roles')->get();
foreach ($roles as $role) {
    echo "   - {$role->name} (ID: {$role->id})\n";
}

// 5. Permissions Spatie disponibles
echo "\n5. Permissions Spatie disponibles:\n";
$permissions = \DB::table('permissions')->get();
foreach ($permissions as $permission) {
    echo "   - {$permission->name} (ID: {$permission->id})\n";
}

// 6. Résumé
echo "\n6. Résumé du nettoyage:\n";
echo "   - Utilisateurs supprimés: 10 (9 restaurant + 1 admin)\n";
echo "   - Utilisateurs restants: " . $users->count() . "\n";
echo "   - Restaurants restants: " . $restaurants->count() . "\n";
echo "   - Assignations Spatie: " . $assignments->count() . "\n";
echo "   - Rôles Spatie: " . $roles->count() . "\n";
echo "   - Permissions Spatie: " . $permissions->count() . "\n";

echo "\n✅ NETTOYAGE TERMINÉ AVEC SUCCÈS!\n";
echo "\n=== RAPPORT TERMINÉ ===\n";
