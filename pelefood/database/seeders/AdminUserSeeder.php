<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer le rôle admin s'il n'existe pas
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Créer l'utilisateur admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@pelefood.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@pelefood.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assigner le rôle admin
        $adminUser->assignRole($adminRole);

        $this->command->info('Utilisateur admin créé avec succès !');
        $this->command->info('Email: admin@pelefood.com');
        $this->command->info('Mot de passe: password');
    }
} 