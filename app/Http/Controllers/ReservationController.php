<?php

// App\Http\Controllers\ReservationController.php
namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Disponibilite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function index()
    {
        $reservations = Reservation::orderBy('date', 'desc')
                                  ->orderBy('heure', 'asc')
                                  ->get();
        return view('gerant.reservations', compact('reservations'));
    }

    // Créer une nouvelle réservation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after:today',
            'heure' => 'required',
            'nombre_personnes' => 'required|integer|min:1'
        ]);

        // Vérifier la disponibilité
        $disponibilite = Disponibilite::where('date', $validated['date'])
                                     ->where('heure', $validated['heure'])
                                     ->first();

        if (!$disponibilite || !$disponibilite->placesDisponibles() || $disponibilite->placesRestantes() < $validated['nombre_personnes']) {
            return back()->with('error', 'Pas de place disponible pour cette date et heure.');
        }

        // Créer la réservation
        $reservation = Reservation::create([
            'date' => $validated['date'],
            'heure' => $validated['heure'],
            'nombre_personnes' => $validated['nombre_personnes'],
            'status' => 'en attente',
            'client_id' => Auth::id()
        ]);

        // Mettre à jour la disponibilité
        $disponibilite->places_reservees += $validated['nombre_personnes'];
        $disponibilite->save();

        return redirect()->route('client.reservation.page')->with('success', 'Réservation créée avec succès!');
    }

    // Confirmer une réservation (pour gérant)
    public function confirm(Reservation $reservation)
    {
        $reservation->status = 'confirmée';
        $reservation->save();

        return back()->with('success', 'Réservation confirmée!');
    }

    // Mettre à jour une réservation
    public function update(Request $request, Reservation $reservation)
    {
        // Vérifier que l'utilisateur est le propriétaire de la réservation
        if (Auth::id() !== $reservation->client_id) {
            return back()->with('error', 'Non autorisé.');
        }

        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'heure' => 'required',
            'nombre_personnes' => 'required|integer|min:1'
        ]);

        // Mettre à jour la disponibilité
        $oldDisponibilite = Disponibilite::where('date', $reservation->date)
                                       ->where('heure', $reservation->heure)
                                       ->first();

        if ($oldDisponibilite) {
            $oldDisponibilite->places_reservees -= $reservation->nombre_personnes;
            $oldDisponibilite->save();
        }

        // Vérifier la nouvelle disponibilité
        $newDisponibilite = Disponibilite::where('date', $validated['date'])
                                       ->where('heure', $validated['heure'])
                                       ->first();

        if (!$newDisponibilite || !$newDisponibilite->placesDisponibles() || $newDisponibilite->placesRestantes() < $validated['nombre_personnes']) {
            // Restaurer l'ancienne disponibilité
            if ($oldDisponibilite) {
                $oldDisponibilite->places_reservees += $reservation->nombre_personnes;
                $oldDisponibilite->save();
            }
            return back()->with('error', 'Pas de place disponible pour cette date et heure.');
        }

        // Mettre à jour la réservation
        $reservation->update($validated);

        // Mettre à jour la nouvelle disponibilité
        $newDisponibilite->places_reservees += $validated['nombre_personnes'];
        $newDisponibilite->save();

        return redirect()->route('dashboard')->with('success', 'Réservation mise à jour avec succès!');
    }

    // Annuler une réservation
    public function destroy(Reservation $reservation)
    {
        // Vérifier que l'utilisateur est le propriétaire de la réservation
        if (Auth::id() !== $reservation->client_id) {
            return back()->with('error', 'Non autorisé.');
        }

        // Mettre à jour la disponibilité
        $disponibilite = Disponibilite::where('date', $reservation->date)
                                    ->where('heure', $reservation->heure)
                                    ->first();

        if ($disponibilite) {
            $disponibilite->places_reservees -= $reservation->nombre_personnes;
            $disponibilite->save();
        }

        $reservation->status = 'annulée';
        $reservation->save();

        return redirect()->route('dashboard')->with('success', 'Réservation annulée!');
    }

    // Afficher l'historique des réservations
    public function history()
    {
        $reservations = Reservation::where('client_id', Auth::id())
                                  ->orderBy('date', 'desc')
                                  ->orderBy('heure', 'asc')
                                  ->get();

        return view('reservations.history', compact('reservations'));
    }



    /**
     * Vérifie la disponibilité pour une date, une heure et un nombre de personnes donnés.
     * Cette méthode peut être utilisée pour des appels AJAX.
     */
    public function checkAvailability(Request $request)
    {
        $validated = $request->validate([
            'check_date'  => 'required|date|after_or_equal:today',
            'check_time'  => 'required',
            'check_guests'=> 'required|integer|min:1',
        ]);

        $date   = $validated['check_date'];
        $time   = $validated['check_time'];
        $guests = $validated['check_guests'];

        // Récupère la disponibilité (si elle existe) pour la date et l'heure indiquées
        $disponibilite = Disponibilite::where('date', $date)
                                      ->where('heure', $time)
                                      ->first();

        // Définition de la capacité totale (ou utilisation de la capacité définie dans disponibilite)
        $total_capacity = $disponibilite ? $disponibilite->capacite_totale : 50;
        $total_reserved = $disponibilite ? $disponibilite->places_reservees : 0;
        $available_seats = $total_capacity - $total_reserved;

        if ($available_seats >= $guests) {
            return response()->json([
                'status'  => 'success',
                'message' => "Disponible ! Il reste $available_seats places pour $guests personnes."
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => "Désolé, nous n'avons pas assez de places disponibles (seulement $available_seats disponibles)."
            ]);
        }
    }

    /**
     * Annule une réservation.
     */
    public function cancel(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id'
        ]);

        $reservation = Reservation::find($validated['reservation_id']);

        // Vérifie que l'utilisateur authentifié est bien le propriétaire de la réservation
        if ($reservation->client_id != Auth::id()) {
            return redirect()->back()->with('error', 'Non autorisé.');
        }

        // Vérifie que l'annulation est effectuée au moins 24h à l'avance
        $reservation_datetime = new \DateTime($reservation->date . ' ' . $reservation->heure);
        $now = new \DateTime();
        $diff = $now->diff($reservation_datetime);
        $hours = $diff->days * 24 + $diff->h;

        if ($reservation_datetime > $now && $hours >= 24) {
            $reservation->status = 'annulée';
            $reservation->save();

            // Optionnel : mettez à jour la disponibilité si besoin (décrémenter places_reservees)
            $disponibilite = Disponibilite::where('date', $reservation->date)
                                          ->where('heure', $reservation->heure)
                                          ->first();
            if ($disponibilite) {
                $disponibilite->places_reservees = max(0, $disponibilite->places_reservees - $reservation->nombre_personnes);
                $disponibilite->save();
            }

            return redirect()->back()->with('success', 'Réservation annulée avec succès.');
        } else {
            return redirect()->back()->with('error', 'Les réservations ne peuvent être annulées que 24 heures à l\'avance.');
        }
    }

}


