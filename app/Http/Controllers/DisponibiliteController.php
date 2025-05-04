<?php

// App\Http\Controllers\DisponibiliteController.php
namespace App\Http\Controllers;

use App\Models\Disponibilite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisponibiliteController extends Controller
{
    // Afficher toutes les disponibilités
    public function index()
    {
        $disponibilites = Disponibilite::orderBy('date')
                                     ->orderBy('heure')
                                     ->get();
        return view('gerant.disponibilites.index', compact('disponibilites'));
    }

    // Afficher le formulaire pour créer une nouvelle disponibilité
    public function create()
    {
        return view('gerant.disponibilites.create');
    }

    // Enregistrer une nouvelle disponibilité
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'heure' => 'required',
            'capacite_totale' => 'required|integer|min:1',
            'disponible' => 'boolean'
        ]);

        // Vérifier si une disponibilité existe déjà pour cette date et heure
        $existingDisponibilite = Disponibilite::where('date', $validated['date'])
                                           ->where('heure', $validated['heure'])
                                           ->first();

        if ($existingDisponibilite) {
            return redirect()->route('gerant.disponibilites.index')
                          ->with('error', 'Une disponibilité existe déjà pour cette date et heure.');
        }

        Disponibilite::create([
            'date' => $validated['date'],
            'heure' => $validated['heure'],
            'capacite_totale' => $validated['capacite_totale'],
            'places_reservees' => 0,
            'disponible' => $validated['disponible'] ?? true
        ]);

        return redirect()->route('gerant.disponibilites.index')
                      ->with('success', 'Disponibilité ajoutée avec succès!');
    }

    // Afficher le formulaire pour modifier une disponibilité
    public function edit(Disponibilite $disponibilite)
    {
        return view('gerant.disponibilites.edit', compact('disponibilite'));
    }

    // Mettre à jour une disponibilité
    public function update(Request $request, Disponibilite $disponibilite)
    {
        $validated = $request->validate([
            'capacite_totale' => 'required|integer|min:' . $disponibilite->places_reservees,
            'disponible' => 'boolean'
        ]);

        $disponibilite->update([
            'capacite_totale' => $validated['capacite_totale'],
            'disponible' => $validated['disponible'] ?? $disponibilite->disponible
        ]);

        return redirect()->route('gerant.disponibilites.index')
                      ->with('success', 'Disponibilité mise à jour avec succès!');
    }

    // Supprimer une disponibilité
    public function destroy(Disponibilite $disponibilite)
    {
        // Vérifier s'il y a des réservations pour cette disponibilité
        if ($disponibilite->places_reservees > 0) {
            return redirect()->route('gerant.disponibilites.index')
                          ->with('error', 'Impossible de supprimer une disponibilité avec des réservations.');
        }

        $disponibilite->delete();
        return redirect()->route('gerant.disponibilites.index')
                      ->with('success', 'Disponibilité supprimée avec succès!');
    }
}
