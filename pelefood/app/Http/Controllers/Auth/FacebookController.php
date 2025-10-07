<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class FacebookController extends Controller
{
    /**
     * Rediriger vers Facebook pour l'authentification
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Gérer le callback de Facebook
     */
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Chercher l'utilisateur par email
            $user = User::where('email', $facebookUser->email)->first();

            if (!$user) {
                // Créer un nouvel utilisateur
                $user = User::create([
                    'name' => $facebookUser->name,
                    'email' => $facebookUser->email,
                    'password' => Hash::make(uniqid()), // Mot de passe aléatoire
                    'email_verified_at' => now(), // Email vérifié via Facebook
                ]);

                // Assigner le rôle par défaut
                $customerRole = Role::where('name', 'customer')->first();
                if ($customerRole) {
                    $user->assignRole($customerRole);
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
                return redirect()->route('landing.home')->with('success', 'Connexion réussie avec Facebook !');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Erreur lors de la connexion avec Facebook. Veuillez réessayer.');
        }
    }
}
