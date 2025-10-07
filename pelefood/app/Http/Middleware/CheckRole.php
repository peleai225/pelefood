<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Vérifier si l'utilisateur a un des rôles requis
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Si aucun rôle ne correspond, rediriger vers le dashboard
        return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
    }
} 