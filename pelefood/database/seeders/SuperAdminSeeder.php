<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créer un super admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@pelefood.ci',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'phone' => '+2250700000000',
            'address' => 'Abidjan, Côte d\'Ivoire',
            'city' => 'Abidjan',
            'country' => 'Côte d\'Ivoire',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Créer un tenant de test
        $tenant = Tenant::create([
            'name' => 'Restaurant Test',
            'domain' => 'test.pelefood.ci',
            'subdomain' => 'test',
            'company_name' => 'Restaurant Test SARL',
            'email' => 'contact@restaurant-test.ci',
            'phone' => '+2250700000001',
            'address' => '123 Rue du Commerce, Plateau',
            'city' => 'Abidjan',
            'country' => 'Côte d\'Ivoire',
            'timezone' => 'Africa/Abidjan',
            'currency' => 'XOF',
            'language' => 'fr',
            'is_active' => true,
            'is_verified' => true,
            'trial_ends_at' => now()->addDays(30),
            'settings' => [
                'theme' => 'default',
                'notifications' => [
                    'email' => true,
                    'sms' => false,
                    'push' => true,
                ],
            ],
        ]);

        // Créer un admin restaurant
        $restaurantAdmin = User::create([
            'name' => 'Admin Restaurant',
            'email' => 'admin@restaurant-test.ci',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
            'role' => 'admin',
            'phone' => '+2250700000002',
            'address' => '123 Rue du Commerce, Plateau',
            'city' => 'Abidjan',
            'country' => 'Côte d\'Ivoire',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Créer un client de test
        $customer = User::create([
            'name' => 'Client Test',
            'email' => 'client@test.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
            'role' => 'customer',
            'phone' => '+2250700000003',
            'address' => '456 Avenue des Champs, Cocody',
            'city' => 'Abidjan',
            'country' => 'Côte d\'Ivoire',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Super Admin créé avec succès !');
        $this->command->info('Email: admin@pelefood.ci');
        $this->command->info('Mot de passe: password');
        $this->command->info('');
        $this->command->info('Tenant de test créé avec succès !');
        $this->command->info('Subdomain: test.pelefood.ci');
        $this->command->info('Admin restaurant: admin@restaurant-test.ci');
        $this->command->info('Client test: client@test.com');
    }
}
