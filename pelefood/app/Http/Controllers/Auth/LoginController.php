<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        Log::info('🔍 LoginController: showLoginForm appelé');
        return view('auth.login');
    }

    public function handleLogin(Request $request)
    {
        Log::info('🚀 LoginController: handleLogin démarré', [
            'request_data' => $request->all(),
            'headers' => $request->headers->all(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        try {
            // Validation
            Log::info('✅ Validation des données...');
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
            Log::info('✅ Validation réussie');

            $credentials = $request->only('email', 'password');
            Log::info('🔑 Tentative de connexion avec', ['email' => $request->email]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                Log::info('✅ Connexion réussie');
                $request->session()->regenerate();
                
                $user = Auth::user();
                Log::info('👤 Utilisateur connecté', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role
                ]);
                
                // Redirection selon le rôle
                if ($user->isSuperAdmin()) {
                    Log::info('🏆 Redirection super_admin vers /admin/dashboard');
                    return redirect()->intended('/admin/dashboard');
                } elseif ($user->role === 'admin') {
                    // Les admins (gérants de restaurant) vont vers leur tableau de bord restaurant
                    Log::info('🍽️ Redirection admin restaurant vers /restaurant/dashboard');
                    return redirect()->intended('/restaurant/dashboard');
                } elseif ($user->role === 'restaurant') {
                    Log::info('🍽️ Redirection restaurant vers /restaurant/dashboard');
                    return redirect()->intended('/restaurant/dashboard');
                } elseif ($user->isCustomer()) {
                    Log::info('👤 Redirection client vers /');
                    return redirect()->intended('/');
                } else {
                    Log::info('❓ Rôle non reconnu, redirection vers /');
                    return redirect()->intended('/');
                }
            } else {
                Log::warning('❌ Échec de connexion', ['email' => $request->email]);
                return back()->withErrors([
                    'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
                ])->withInput($request->only('email'));
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('❌ Erreur de validation', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('💥 Erreur inattendue dans handleLogin', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return back()->withErrors([
                'general' => 'Une erreur est survenue lors de la connexion. Veuillez réessayer.'
            ])->withInput($request->only('email'));
        }
    }

    public function logout(Request $request)
    {
        Log::info('🚪 Logout demandé', ['user_id' => Auth::id()]);
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        Log::info('✅ Logout réussi');
        return redirect('/');
    }
}
