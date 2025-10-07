<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class FixAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer le rôle super_admin s'il n'existe pas
        if (!Role::where('name', 'super_admin')->exists()) {
            Role::create(['name' => 'super_admin']);
            $this->command->info('Rôle super_admin créé');
        }

        // Trouver l'utilisateur admin
        $adminUser = User::where('email', 'admin@pelefood.com')->first();
        
        if ($adminUser) {
            // Supprimer tous les rôles existants
            $adminUser->syncRoles([]);
            
            // Assigner le rôle super_admin
            $adminUser->assignRole('super_admin');
            
            $this->command->info('Utilisateur admin mis à jour avec le rôle super_admin');
            $this->command->info('Email: admin@pelefood.com');
            $this->command->info('Mot de passe: password123');
        } else {
            $this->command->error('Utilisateur admin@pelefood.com non trouvé');
        }
    }
} 