<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== NETTOYAGE DES UTILISATEURS RESTAURANT ===\n\n";

// 1. Lister tous les utilisateurs restaurant
echo "1. Utilisateurs restaurant à supprimer:\n";
$restaurantUsers = \App\Models\User::where('role', 'restaurant')->get();
foreach ($restaurantUsers as $user) {
    echo "   - ID: {$user->id}, Email: {$user->email}, Nom: {$user->name}\n";
}

// 2. Lister tous les utilisateurs admin (gérants de restaurant)
echo "\n2. Utilisateurs admin (gérants) à supprimer:\n";
$adminUsers = \App\Models\User::where('role', 'admin')->get();
foreach ($adminUsers as $user) {
    echo "   - ID: {$user->id}, Email: {$user->email}, Nom: {$user->name}\n";
}

// 3. Vérifier le super admin
echo "\n3. Super admin (à conserver):\n";
$superAdmin = \App\Models\User::where('role', 'super_admin')->first();
if ($superAdmin) {
    echo "   - ID: {$superAdmin->id}, Email: {$superAdmin->email}, Nom: {$superAdmin->name}\n";
} else {
    echo "   - Aucun super admin trouvé!\n";
}

// 4. Compter les utilisateurs à supprimer
$totalToDelete = $restaurantUsers->count() + $adminUsers->count();
echo "\n4. Résumé:\n";
echo "   - Utilisateurs restaurant: {$restaurantUsers->count()}\n";
echo "   - Utilisateurs admin: {$adminUsers->count()}\n";
echo "   - Total à supprimer: $totalToDelete\n";
echo "   - Super admin à conserver: " . ($superAdmin ? '1' : '0') . "\n";

// 5. Demander confirmation
echo "\n5. Confirmation de suppression:\n";
echo "   Voulez-vous supprimer ces utilisateurs? (y/N): ";

// 6. Supprimer les utilisateurs
if (true) { // Pour l'instant, on force la suppression
    echo "   Suppression en cours...\n\n";
    
    // Supprimer les assignations de rôles Spatie d'abord
    echo "   - Suppression des assignations Spatie...\n";
    $userIdsToDelete = $restaurantUsers->pluck('id')->merge($adminUsers->pluck('id'));
    \DB::table('model_has_roles')->whereIn('model_id', $userIdsToDelete)->delete();
    \DB::table('model_has_permissions')->whereIn('model_id', $userIdsToDelete)->delete();
    
    // Supprimer les utilisateurs restaurant
    echo "   - Suppression des utilisateurs restaurant...\n";
    $deletedRestaurant = \App\Models\User::where('role', 'restaurant')->delete();
    echo "     Supprimés: $deletedRestaurant utilisateurs\n";
    
    // Supprimer les utilisateurs admin
    echo "   - Suppression des utilisateurs admin...\n";
    $deletedAdmin = \App\Models\User::where('role', 'admin')->delete();
    echo "     Supprimés: $deletedAdmin utilisateurs\n";
    
    // Vérifier le résultat
    echo "\n6. Vérification après suppression:\n";
    $remainingUsers = \App\Models\User::all();
    foreach ($remainingUsers as $user) {
        echo "   - ID: {$user->id}, Email: {$user->email}, Rôle: {$user->role}\n";
    }
    
    echo "\n✅ Nettoyage terminé!\n";
} else {
    echo "   Suppression annulée.\n";
}

echo "\n=== NETTOYAGE TERMINÉ ===\n";
