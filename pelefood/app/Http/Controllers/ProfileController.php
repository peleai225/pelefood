<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher la page de profil
     */
    public function show()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();
        
        // Rediriger vers la vue appropriée selon le rôle
        if ($user->hasRole('super_admin')) {
            return view('admin.profile.show', compact('user'));
        } elseif ($user->hasRole('restaurant')) {
            return view('restaurant.profile.show', compact('user', 'restaurant'));
        } elseif ($user->hasRole(['staff', 'manager'])) {
            return view('staff.profile.show', compact('user', 'restaurant'));
        } else {
            return view('profile.show', compact('user', 'restaurant'));
        }
    }

    /**
     * Afficher le formulaire de modification du profil
     */
    public function edit()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();
        
        // Rediriger vers la vue appropriée selon le rôle
        if ($user->hasRole('super_admin')) {
            return view('admin.profile.edit', compact('user'));
        } elseif ($user->hasRole('restaurant')) {
            return view('restaurant.profile.edit', compact('user', 'restaurant'));
        } elseif ($user->hasRole(['staff', 'manager'])) {
            return view('staff.profile.edit', compact('user', 'restaurant'));
        } else {
            return view('profile.edit', compact('user', 'restaurant'));
        }
    }

    /**
     * Mettre à jour les informations du profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
        ]);

        $user->update($request->only([
            'name',
            'email',
            'phone',
            'address',
            'city',
            'postal_code',
            'country',
        ]));

        return redirect()->route('profile.show')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Afficher le formulaire de changement de mot de passe
     */
    public function changePassword()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();
        
        return view('profile.change-password', compact('user', 'restaurant'));
    }

    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Vérifier le mot de passe actuel
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }

    /**
     * Afficher les paramètres de sécurité
     */
    public function security()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();
        
        return view('profile.security', compact('user', 'restaurant'));
    }

    /**
     * Afficher l'historique des connexions
     */
    public function activity()
    {
        $user = Auth::user();
        $restaurant = $this->getCurrentRestaurant();
        
        // Ici vous pourriez récupérer l'historique des connexions
        // Pour l'instant, on retourne une vue vide
        $activities = collect(); // À remplacer par votre logique d'activité
        
        return view('profile.activity', compact('user', 'restaurant', 'activities'));
    }

    /**
     * Supprimer le compte
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        // Vérifier le mot de passe
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Le mot de passe est incorrect.']);
        }

        // Supprimer le compte
        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Votre compte a été supprimé avec succès.');
    }
} 