<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        Log::info('🔍 RegisterController: showRegistrationForm appelé');
        return view('auth.register');
    }

    public function handleRegistration(Request $request)
    {
        Log::info('🚀 RegisterController: handleRegistration démarré', [
            'request_data' => $request->all(),
            'headers' => $request->headers->all(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        try {
            // Validation pour les restaurants uniquement
            Log::info('✅ Validation des données...');
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'required|string|max:20',
                'city' => 'required|string|max:100',
                'address' => 'required|string|max:500',
            ]);
            Log::info('✅ Validation réussie');

            // Création de l'utilisateur restaurant
            Log::info('👤 Création de l\'utilisateur restaurant...');
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'city' => $request->city,
                'address' => $request->address,
                'status' => 'active'
            ]);
            Log::info('✅ Utilisateur créé', ['user_id' => $user->id, 'email' => $user->email]);

            // Assigner le rôle restaurant et un tenant
            Log::info('🔑 Assignation du rôle restaurant...');
            
            // Trouver ou créer un tenant par défaut
            $tenant = \App\Models\Tenant::first();
            if (!$tenant) {
                // Créer un tenant par défaut si aucun n'existe
                $tenant = \App\Models\Tenant::create([
                    'name' => 'Restaurant par défaut',
                    'slug' => 'default-restaurant',
                    'is_active' => true
                ]);
                Log::info('✅ Tenant par défaut créé', ['tenant_id' => $tenant->id]);
            }
            
            // Mettre à jour le champ role et tenant_id
            $user->update([
                'role' => 'restaurant',
                'tenant_id' => $tenant->id
            ]);
            
            // Assigner aussi le rôle Spatie pour la compatibilité
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('restaurant');
                Log::info('✅ Rôle Spatie assigné', ['role' => 'restaurant']);
            }
            
            Log::info('✅ Rôle et tenant assignés', ['role' => 'restaurant', 'tenant_id' => $tenant->id]);

            // Connexion automatique
            Log::info('🔐 Tentative de connexion automatique...');
            Auth::login($user);
            $request->session()->regenerate();
            Log::info('✅ Connexion automatique réussie');

            // Vérifier que l'utilisateur est bien connecté
            $connectedUser = Auth::user();
            Log::info('🔍 Vérification connexion', [
                'user_id' => $connectedUser ? $connectedUser->id : 'null',
                'user_role' => $connectedUser ? $connectedUser->role : 'null'
            ]);

            // Redirection vers la création du restaurant
            Log::info('🎯 Redirection vers création restaurant...');
            return redirect()->route('restaurant.restaurants.create')->with('success', 'Compte restaurant créé avec succès ! Veuillez configurer votre restaurant.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('❌ Erreur de validation', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('💥 Erreur inattendue dans handleRegistration', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return back()->withErrors([
                'general' => 'Une erreur est survenue lors de la création du compte. Veuillez réessayer.'
            ])->withInput($request->only('name', 'email'));
        }
    }
}
