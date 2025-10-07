<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class FixUserRolesSeeder extends Seeder
{
    public function run()
    {
        // Récupérer les rôles existants
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $customerRole = Role::where('name', 'customer')->first();
        
        if (!$superAdminRole || !$adminRole || !$customerRole) {
            $this->command->error('Rôles manquants. Vérifiez la base de données.');
            return;
        }
        
        // Corriger l'utilisateur super admin
        $superAdminUser = User::where('email', 'peleai.ci@gmail.com')->first();
        if ($superAdminUser) {
            // Supprimer tous les rôles existants
            $superAdminUser->syncRoles([]);
            // Assigner le rôle super_admin
            $superAdminUser->assignRole($superAdminRole);
            // Mettre à jour le champ role dans la table users
            $superAdminUser->update(['role' => 'super_admin']);
            $this->command->info("✅ Utilisateur {$superAdminUser->email} assigné au rôle super_admin");
        }
        
        // Corriger les autres utilisateurs
        $otherUsers = User::where('email', '!=', 'peleai.ci@gmail.com')->get();
        foreach ($otherUsers as $user) {
            if ($user->role === 'admin') {
                $user->syncRoles([$adminRole]);
            } else {
                $user->syncRoles([$customerRole]);
                $user->update(['role' => 'customer']);
            }
            $this->command->info("✅ Utilisateur {$user->email} corrigé");
        }
        
        $this->command->info('🎯 Correction des rôles terminée !');
    }
} 