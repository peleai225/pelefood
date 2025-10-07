<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            \Log::info('CheckUserRole: Utilisateur non connecté');
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = Auth::user();
        $allowedRoles = explode(',', $roles);
        
        // Nettoyer les espaces
        $allowedRoles = array_map('trim', $allowedRoles);

        \Log::info('CheckUserRole: Vérification des rôles', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'allowed_roles' => $allowedRoles,
            'route' => $request->route()->getName()
        ]);

        // Vérifier si l'utilisateur a un des rôles autorisés
        if (!in_array($user->role, $allowedRoles)) {
            \Log::warning('CheckUserRole: Rôle non autorisé', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'allowed_roles' => $allowedRoles
            ]);
            abort(403, 'Accès refusé. Vous n\'avez pas les permissions nécessaires.');
        }

        \Log::info('CheckUserRole: Accès autorisé');
        return $next($request);
    }
}