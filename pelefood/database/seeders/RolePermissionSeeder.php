<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les permissions
        $permissions = [
            // Gestion des restaurants
            'view restaurants',
            'create restaurants',
            'edit restaurants',
            'delete restaurants',
            
            // Gestion des catégories
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            
            // Gestion des produits
            'view products',
            'create products',
            'edit products',
            'delete products',
            
            // Gestion des commandes
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',
            
            // Gestion des utilisateurs
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Gestion des abonnements
            'view subscriptions',
            'create subscriptions',
            'edit subscriptions',
            'delete subscriptions',
            
            // Gestion des paiements
            'view payments',
            'create payments',
            'edit payments',
            'delete payments',
            
            // Gestion des rapports
            'view reports',
            'create reports',
            'edit reports',
            'delete reports',
            
            // Administration
            'access admin',
            'manage system',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Créer les rôles
        $roles = [
            'super_admin' => [
                'access admin',
                'manage system',
                'view restaurants', 'create restaurants', 'edit restaurants', 'delete restaurants',
                'view categories', 'create categories', 'edit categories', 'delete categories',
                'view products', 'create products', 'edit products', 'delete products',
                'view orders', 'create orders', 'edit orders', 'delete orders',
                'view users', 'create users', 'edit users', 'delete users',
                'view subscriptions', 'create subscriptions', 'edit subscriptions', 'delete subscriptions',
                'view payments', 'create payments', 'edit payments', 'delete payments',
                'view reports', 'create reports', 'edit reports', 'delete reports',
            ],
            'admin' => [
                'access admin',
                'view restaurants', 'create restaurants', 'edit restaurants',
                'view categories', 'create categories', 'edit categories',
                'view products', 'create products', 'edit products',
                'view orders', 'create orders', 'edit orders',
                'view users', 'create users', 'edit users',
                'view subscriptions', 'create subscriptions', 'edit subscriptions',
                'view payments', 'create payments', 'edit payments',
                'view reports', 'create reports', 'edit reports',
            ],
            'restaurant' => [
                'view restaurants', 'edit restaurants',
                'view categories', 'create categories', 'edit categories', 'delete categories',
                'view products', 'create products', 'edit products', 'delete products',
                'view orders', 'edit orders',
                'view subscriptions', 'edit subscriptions',
                'view payments',
                'view reports',
            ],
            'manager' => [
                'view restaurants',
                'view categories', 'create categories', 'edit categories',
                'view products', 'create products', 'edit products',
                'view orders', 'edit orders',
                'view subscriptions',
                'view payments',
                'view reports',
            ],
            'staff' => [
                'view restaurants',
                'view categories',
                'view products',
                'view orders', 'edit orders',
                'view subscriptions',
                'view payments',
            ],
            'customer' => [
                'view restaurants',
                'view categories',
                'view products',
                'create orders',
                'view payments',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        $this->command->info('Rôles et permissions créés avec succès !');
    }
} 