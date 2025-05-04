<?php

// app/Http/Middleware/CheckRole.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        foreach ($roles as $role) {
            // Vérifier si l'utilisateur a l'un des rôles spécifiés
            if ($request->user()->type === $role) {
                return $next($request);
            }
        }

        return redirect('/dashboard')->with('error', 'Vous n\'avez pas les permissions nécessaires.');
    }
}
