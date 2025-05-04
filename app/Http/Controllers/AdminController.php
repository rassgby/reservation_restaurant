<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use App\Models\Disponibilite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Dashboard: statistiques globales
     */
    public function dashboard()
    {
        $totalUsers          = User::count();
        $activeUsers         = User::where('is_active', true)->count();
        $totalReservations   = Reservation::count();
        $pendingReservations = Reservation::where('status', 'en attente')->count();
        // Pour le dashboard, on peut conserver un simple get()
        $disponibilites      = Disponibilite::orderBy('date')->orderBy('heure')->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'totalReservations',
            'pendingReservations',
            'disponibilites'
        ));
    }

    /**
     * Liste paginée des utilisateurs
     */
    public function index(Request $request)
    {
        // 15 utilisateurs par page
        $users = User::orderBy('type')
                     ->orderBy('nom')
                     ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom'                  => 'required|string|max:255',
            'nom'                     => 'required|string|max:255',
            'email'                   => 'required|email|unique:users,email',
            'password'                => 'required|string|min:8|confirmed',
            'type'                    => 'required|in:client,agent,administrateur',
        ]);

        User::create([
            'prenom'    => $validated['prenom'],
            'nom'       => $validated['nom'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'type'      => $validated['type'],
            'is_active' => true,
        ]);

        return redirect()
               ->route('admin.users.index')
               ->with('success', 'Utilisateur créé avec succès !');
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'prenom'    => 'required|string|max:255',
            'nom'       => 'required|string|max:255',
            'email'     => "required|email|unique:users,email,{$user->id}",
            'type'      => 'required|in:client,agent,administrateur',
            'is_active' => 'required|boolean',
        ]);

        $user->update($validated);

        return redirect()
               ->route('admin.users.index')
               ->with('success', 'Utilisateur mis à jour !');
    }

    /**
     * Supprime un utilisateur (sauf vous-même)
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()
               ->route('admin.users.index')
               ->with('success', 'Utilisateur supprimé !');
    }

    /**
     * Bascule le champ is_active pour un utilisateur.
     */
    public function toggle(User $user)
    {
        $user->is_active = ! $user->is_active;
        $user->save();

        return redirect()
               ->route('admin.users.index')
               ->with('success', 'Le statut de l’utilisateur a été mis à jour.');
    }

    public function reservations(Request $request)
{
    $query = Reservation::orderBy('date','desc')->orderBy('heure');
    if ($date = $request->query('date')) {
        $query->where('date', $date);
    }
    $reservations = $query->paginate(15)->appends($request->only('date'));
    return view('admin.reservations.index', compact('reservations'));
}

public function disponibilites(Request $request)
{
    $query = Disponibilite::orderBy('date')->orderBy('heure');
    if ($date = $request->query('date')) {
        $query->where('date', $date);
    }
    $disponibilites = $query->paginate(15)->appends($request->only('date'));
    return view('admin.disponibilites.index', compact('disponibilites'));
}

}
