<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class FirebaseAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer le rôle super_admin s'il n'existe pas
        if (!Role::where('name', 'super_admin')->exists()) {
            Role::create(['name' => 'super_admin']);
        }

        // Créer l'utilisateur Firebase admin
        $firebaseAdmin = User::updateOrCreate(
            ['email' => 'peleai.ci@gmail.com'],
            [
                'name' => 'Admin PeleFood',
                'password' => bcrypt('firebase_admin_2024'),
                'email_verified_at' => now(),
            ]
        );

        // Assigner le rôle super_admin
        $firebaseAdmin->syncRoles(['super_admin']);

        $this->command->info('Utilisateur Firebase admin créé/mis à jour');
        $this->command->info('Email: peleai.ci@gmail.com');
        $this->command->info('Firebase UID: e0kNAAdZrgeYVTDD9437nKvakq32');
        $this->command->info('Rôle: super_admin');
    }
} 