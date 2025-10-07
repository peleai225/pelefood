<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;

class RestaurantAdminSeeder extends Seeder
{
    public function run()
    {
        // Récupérer le premier tenant
        $tenant = Tenant::first();
        
        if (!$tenant) {
            $this->command->error('Aucun tenant trouvé. Veuillez d\'abord exécuter SuperAdminSeeder.');
            return;
        }

        // Créer un utilisateur admin pour le restaurant
        $user = User::create([
            'name' => 'Admin Restaurant',
            'email' => 'admin@restaurant.ci',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
            'role' => 'admin',
            'phone' => '+225 27 22 49 50 00',
            'address' => '123 Boulevard de la Corniche',
            'city' => 'Abidjan',
            'country' => 'Côte d\'Ivoire',
            'is_active' => true,
        ]);

        $this->command->info('Utilisateur admin restaurant créé avec succès !');
        $this->command->info('Email: admin@restaurant.ci');
        $this->command->info('Mot de passe: password');
    }
} 