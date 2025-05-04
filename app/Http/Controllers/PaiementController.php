<?php

// App\Http\Controllers\PaiementController.php
namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    // Afficher le formulaire de paiement
    public function create(Reservation $reservation)
    {
        // Vérifier que l'utilisateur est le propriétaire de la réservation
        if (Auth::id() !== $reservation->client_id) {
            return redirect()->route('dashboard')->with('error', 'Non autorisé.');
        }

        return view('paiements.create', compact('reservation'));
    }

    // Enregistrer un nouveau paiement
    public function store(Request $request, Reservation $reservation)
    {
        // Vérifier que l'utilisateur est le propriétaire de la réservation
        if (Auth::id() !== $reservation->client_id) {
            return redirect()->route('dashboard')->with('error', 'Non autorisé.');
        }

        $validated = $request->validate([
            'montant' => 'required|numeric|min:0',
            'methode' => 'required|string|in:carte,especes,electronique'
        ]);

        // Vérifier si un paiement existe déjà
        if ($reservation->paiement) {
            return redirect()->route('dashboard')->with('error', 'Cette réservation a déjà été payée.');
        }

        // Créer le paiement
        $paiement = new Paiement([
            'montant' => $validated['montant'],
            'date' => now(),
            'status' => 'complété',
            'methode' => $validated['methode'],
            'reservation_id' => $reservation->id
        ]);
        $paiement->save();

        // Mettre à jour le statut de la réservation si nécessaire
        if ($reservation->status === 'en attente') {
            $reservation->status = 'confirmée';
            $reservation->save();
        }

        return redirect()->route('dashboard')->with('success', 'Paiement effectué avec succès!');
    }

    // Rembourser un paiement
    public function refund(Paiement $paiement)
    {
        // Vérifier que l'utilisateur est un gérant ou administrateur
        if (!Auth::user()->isGerant() && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Non autorisé.');
        }

        $paiement->status = 'remboursé';
        $paiement->save();

        // Mettre à jour le statut de la réservation
        $reservation = $paiement->reservation;
        $reservation->status = 'annulée';
        $reservation->save();

        return redirect()->back()->with('success', 'Paiement remboursé avec succès!');
    }
}
