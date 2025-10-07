<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CompleteRolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Désactiver les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Supprimer tous les rôles et permissions existants
        \Spatie\Permission\Models\Role::truncate();
        \Spatie\Permission\Models\Permission::truncate();
        
        // Réactiver les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Créer les rôles
        $superAdmin = Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $manager = Role::create(['name' => 'manager', 'guard_name' => 'web']);
        $staff = Role::create(['name' => 'staff', 'guard_name' => 'web']);
        $customer = Role::create(['name' => 'customer', 'guard_name' => 'web']);
        
        $this->command->info('✅ Rôles créés');
        
        // Créer les permissions
        $permissions = [
            'view_dashboard',
            'manage_restaurants',
            'manage_products',
            'manage_orders',
            'manage_categories',
            'manage_promotions',
            'manage_reviews',
            'manage_users',
            'manage_tenants',
            'view_reports',
            'export_data',
            'manage_settings',
            'manage_payments',
            'manage_subscriptions',
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
        
        $this->command->info('✅ Permissions créées');
        
        // Assigner toutes les permissions au super admin
        $superAdmin->givePermissionTo(Permission::all());
        
        // Assigner les permissions aux admins de restaurant
        $admin->givePermissionTo([
            'view_dashboard',
            'manage_restaurants',
            'manage_products',
            'manage_orders',
            'manage_categories',
            'manage_promotions',
            'manage_reviews',
            'export_data',
            'manage_settings',
            'manage_payments',
        ]);
        
        // Assigner les permissions aux managers
        $manager->givePermissionTo([
            'view_dashboard',
            'manage_products',
            'manage_orders',
            'manage_categories',
            'manage_promotions',
        ]);
        
        // Assigner les permissions au staff
        $staff->givePermissionTo([
            'view_dashboard',
            'manage_orders',
        ]);
        
        $this->command->info('✅ Permissions assignées aux rôles');
        
        // Corriger les utilisateurs existants
        $users = User::all();
        foreach ($users as $user) {
            if ($user->email === 'peleai.ci@gmail.com') {
                $user->syncRoles([$superAdmin]);
                $user->update(['role' => 'super_admin']);
                $this->command->info("✅ {$user->email} -> super_admin");
            } elseif ($user->email === 'admin@restaurant-test.ci') {
                $user->syncRoles([$admin]);
                $user->update(['role' => 'admin']);
                $this->command->info("✅ {$user->email} -> admin");
            } else {
                $user->syncRoles([$customer]);
                $user->update(['role' => 'customer']);
                $this->command->info("✅ {$user->email} -> customer");
            }
        }
        
        $this->command->info('🎯 Configuration des rôles et permissions terminée !');
    }
} 