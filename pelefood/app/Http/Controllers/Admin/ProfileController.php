<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Afficher le profil de l'administrateur
     */
    public function show()
    {
        $user = Auth::user();
        return view('admin.profile.show', compact('user'));
    }

    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Mettre à jour le profil de l'administrateur
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        $user->update($validated);

        return redirect()->route('admin.profile.show')
            ->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Afficher la page de sécurité du profil
     */
    public function security()
    {
        $user = Auth::user();
        return view('admin.profile.security', compact('user'));
    }

    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.profile.security')
            ->with('success', 'Mot de passe mis à jour avec succès');
    }

    /**
     * Afficher l'activité de l'administrateur
     */
    public function activity()
    {
        $user = Auth::user();
        
        // Ici vous pouvez ajouter la logique pour récupérer l'activité de l'utilisateur
        // Par exemple : connexions, actions effectuées, etc.
        
        return view('admin.profile.activity', compact('user'));
    }

    /**
     * Mettre à jour les préférences de notification
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
        ]);

        $user->update([
            'notification_preferences' => $validated
        ]);

        return redirect()->route('admin.profile.show')
            ->with('success', 'Préférences de notification mises à jour');
    }

    /**
     * Supprimer le compte (avec confirmation)
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = Auth::user();
        
        // Vérifier que l'utilisateur n'est pas le seul super admin
        if ($user->hasRole('super_admin')) {
            $superAdminCount = \App\Models\User::role('super_admin')->count();
            if ($superAdminCount <= 1) {
                return back()->with('error', 'Impossible de supprimer le dernier super administrateur');
            }
        }

        Auth::logout();
        $user->delete();

        return redirect()->route('login')
            ->with('success', 'Votre compte a été supprimé avec succès');
    }
} 