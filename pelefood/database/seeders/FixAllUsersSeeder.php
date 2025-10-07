<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class FixAllUsersSeeder extends Seeder
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

        // Trouver tous les utilisateurs
        $users = User::all();
        
        foreach ($users as $user) {
            $this->command->info("Traitement de l'utilisateur: {$user->email}");
            
            // Supprimer tous les rôles existants
            $user->syncRoles([]);
            
            // Assigner le rôle super_admin à tous les utilisateurs
            $user->assignRole('super_admin');
            
            $this->command->info("  - Rôle super_admin assigné");
        }

        $this->command->info('Tous les utilisateurs ont maintenant le rôle super_admin');
        
        // Afficher les utilisateurs
        $users = User::with('roles')->get();
        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->join(', ');
            $this->command->info("  - {$user->email}: {$roles}");
        }
    }
} 