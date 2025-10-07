<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Créer les rôles principaux
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $restaurant = Role::firstOrCreate(['name' => 'restaurant']); // Rôle pour les restaurants
        $customer = Role::firstOrCreate(['name' => 'customer']); // Rôle pour les clients
        $admin = Role::firstOrCreate(['name' => 'admin']); // Rôle admin général
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $staff = Role::firstOrCreate(['name' => 'staff']);

        // Créer les permissions (éviter les doublons)
        $permissions = [
            // Permissions générales
            'view_dashboard',
            'manage_profile',
            
            // Permissions restaurant
            'manage_restaurant',
            'manage_menu',
            'manage_orders',
            'manage_categories',
            'manage_promotions',
            'manage_reviews',
            'manage_deliveries',
            'view_analytics',
            'manage_subscription',
            'export_data',
            
            // Permissions client
            'place_orders',
            'view_menu',
            'write_reviews',
            
            // Permissions admin
            'manage_users',
            'manage_tenants',
            'manage_platform',
            'view_reports',
            'manage_billing',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assigner toutes les permissions au super admin
        $superAdmin->givePermissionTo(Permission::all());

        // Permissions pour les restaurants
        $restaurant->givePermissionTo([
            'view_dashboard',
            'manage_profile',
            'manage_restaurant',
            'manage_menu',
            'manage_orders',
            'manage_categories',
            'manage_promotions',
            'manage_reviews',
            'manage_deliveries',
            'view_analytics',
            'manage_subscription',
            'export_data',
        ]);

        // Permissions pour les clients
        $customer->givePermissionTo([
            'view_dashboard',
            'manage_profile',
            'place_orders',
            'view_menu',
            'write_reviews',
        ]);

        // Permissions pour les admins
        $admin->givePermissionTo([
            'view_dashboard',
            'manage_profile',
            'manage_users',
            'manage_tenants',
            'view_reports',
            'manage_billing',
        ]);

        // Permissions pour les managers
        $manager->givePermissionTo([
            'view_dashboard',
            'manage_profile',
            'manage_menu',
            'manage_orders',
            'manage_categories',
            'manage_promotions',
        ]);

        // Permissions pour le staff
        $staff->givePermissionTo([
            'view_dashboard',
            'manage_profile',
            'manage_orders',
        ]);

        // Assigner le rôle restaurant à l'utilisateur existant
        $user = User::where('email', 'pelefood1@gmail.com')->first();
        if ($user) {
            $user->assignRole('restaurant');
        }

        // Assigner le rôle customer aux autres utilisateurs
        $otherUsers = User::where('email', '!=', 'pelefood1@gmail.com')->get();
        foreach ($otherUsers as $user) {
            if (!$user->hasRole('restaurant') && !$user->hasRole('admin')) {
                $user->assignRole('customer');
            }
        }
    }
}
