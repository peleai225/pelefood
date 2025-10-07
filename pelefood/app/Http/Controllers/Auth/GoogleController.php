<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class GoogleController extends Controller
{
    /**
     * Rediriger vers Google pour l'authentification
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->redirectUrl(config('services.google.redirect'))
            ->redirect();
    }

    /**
     * Gérer le callback de Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(config('services.google.redirect'))
                ->user();

            // Chercher l'utilisateur par email
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                // Créer un nouvel utilisateur
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(uniqid()), // Mot de passe aléatoire
                    'email_verified_at' => now(), // Email vérifié via Google
                ]);

                // Assigner le rôle super_admin pour PeleFood
                $superAdminRole = Role::where('name', 'super_admin')->first();
                if ($superAdminRole) {
                    $user->assignRole($superAdminRole);
                } else {
                    // Créer le rôle super_admin s'il n'existe pas
                    $superAdminRole = Role::create(['name' => 'super_admin']);
                    $user->assignRole($superAdminRole);
                }
            } else {
                // Si l'utilisateur existe déjà, s'assurer qu'il a le rôle super_admin
                if (!$user->hasRole('super_admin')) {
                    $superAdminRole = Role::where('name', 'super_admin')->first();
                    if ($superAdminRole) {
                        $user->assignRole($superAdminRole);
                    }
                }
            }

            // Connecter l'utilisateur
            Auth::login($user);

            // Rediriger selon le rôle
            if ($user->hasRole('super_admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('admin')) {
                return redirect()->route('restaurant.dashboard');
            } elseif ($user->hasRole('manager') || $user->hasRole('staff')) {
                return redirect()->route('staff.orders.index');
            } else {
                return redirect()->route('landing.home')->with('success', 'Connexion réussie avec Google !');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Erreur lors de la connexion avec Google. Veuillez réessayer.');
        }
    }
}
