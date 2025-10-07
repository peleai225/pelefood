<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignSuperAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@pelefood.com')->first();
        $role = Role::where('name', 'super_admin')->first();
        
        if ($user && $role) {
            $user->assignRole($role);
            $this->command->info('Rôle super_admin assigné à ' . $user->email);
        } else {
            $this->command->error('Utilisateur ou rôle non trouvé');
        }
    }
} 