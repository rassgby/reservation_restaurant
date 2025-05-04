<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Récupère l'utilisateur authentifié
        $user = Auth::user();

        // Redirection en fonction du rôle de l'utilisateur
        if ($user->type === 'client') {
            return redirect()->route('client.reservation.page');
        } elseif ($user->type === 'gerant') {
            return redirect()->route('gerant.dashboard');
        } elseif ($user->type === 'administrateur') {
            return redirect()->route('admin.dashboard');
        }

        // Redirection par défaut en cas de rôle inconnu
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
