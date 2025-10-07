<?php

require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Configuration de base
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Tenant;
use App\Models\Restaurant;

echo "🔧 Création d'un utilisateur de test avec rôles corrects...\n\n";

try {
    // Créer les rôles s'ils n'existent pas
    $roles = ['super_admin', 'admin', 'restaurant', 'customer'];
    foreach ($roles as $roleName) {
        if (!Role::where('name', $roleName)->exists()) {
            Role::create(['name' => $roleName]);
            echo "✅ Rôle '$roleName' créé\n";
        } else {
            echo "ℹ️  Rôle '$roleName' existe déjà\n";
        }
    }

    // Créer ou récupérer un tenant de test
    $tenant = Tenant::first();
    if (!$tenant) {
        $tenant = Tenant::create([
            'name' => 'Test Restaurant',
            'domain' => 'test.pelefood.com',
            'subdomain' => 'test',
            'company_name' => 'Test Restaurant Company',
            'email' => 'test@pelefood.com',
            'phone' => '+225 07 12 34 56 78',
            'address' => '123 Avenue de la République, Cocody, Abidjan',
            'city' => 'Abidjan',
            'country' => 'Côte d\'Ivoire',
            'timezone' => 'Africa/Abidjan',
            'currency' => 'XOF',
            'language' => 'fr'
        ]);
        echo "✅ Tenant créé: {$tenant->name}\n";
    } else {
        echo "ℹ️  Tenant existant utilisé: {$tenant->name}\n";
    }

    // Créer un restaurant de test
    $restaurant = Restaurant::firstOrCreate([
        'name' => 'Test Restaurant',
        'phone' => '+225 07 12 34 56 78',
        'address' => '123 Avenue de la République, Cocody, Abidjan',
        'city' => 'Abidjan',
        'country' => 'Côte d\'Ivoire',
        'tenant_id' => $tenant->id,
        'is_active' => true,
    ]);
    echo "✅ Restaurant créé: {$restaurant->name}\n";

    // Créer ou mettre à jour l'utilisateur de test
    $user = User::updateOrCreate(
        ['email' => 'test@pelefood.com'],
        [
            'name' => 'Test User',
            'password' => Hash::make('password123'),
            'tenant_id' => $tenant->id,
        ]
    );

    // Assigner le rôle restaurant
    $restaurantRole = Role::where('name', 'restaurant')->first();
    if ($restaurantRole && !$user->hasRole('restaurant')) {
        $user->assignRole($restaurantRole);
        echo "✅ Rôle 'restaurant' assigné à l'utilisateur\n";
    } else {
        echo "ℹ️  Rôle 'restaurant' déjà assigné\n";
    }

    echo "\n🎉 Utilisateur de test créé avec succès !\n";
    echo "📧 Email: test@pelefood.com\n";
    echo "🔑 Mot de passe: password123\n";
    echo "🏢 Restaurant: {$restaurant->name}\n";
    echo "🏢 Tenant: {$tenant->name}\n";
    echo "👤 Rôles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n\n";

    echo "🔗 URLs de test:\n";
    echo "- Connexion simple: http://localhost:8000/login-simple\n";
    echo "- Inscription simple: http://localhost:8000/register-simple\n";
    echo "- Connexion moderne: http://localhost:8000/login\n";
    echo "- Inscription moderne: http://localhost:8000/register\n";

} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "📍 Fichier: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
