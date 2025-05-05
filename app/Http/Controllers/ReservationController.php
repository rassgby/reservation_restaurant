<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Affiche le formulaire de réservation
     */
    public function create()
    {
        return view('client.reservations.create');
    }

    /**
     * Enregistre une nouvelle réservation
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'heure' => 'required|string',
            'nombre_personnes' => 'required|string',
            'special_requests' => 'nullable|string|max:500',
            'email' => 'nullable|email',  // Si vous collectez l'email
            'phone' => 'nullable|string', // Si vous collectez le téléphone
            'name' => 'nullable|string',  // Si vous collectez le nom
        ]);

        try {
            // Vérifier la disponibilité (nombre de tables à cette heure et date)
            if (!$this->checkAvailability($validated['date'], $validated['heure'], $validated['nombre_personnes'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Désolé, nous n\'avons plus de tables disponibles à cette date et heure. Veuillez choisir un autre créneau.');
            }

            // Créer la réservation
            $reservation = new Reservation($validated);
            
            // Associer l'utilisateur connecté si disponible
            if (Auth::check()) {
                $reservation->user_id = Auth::id();
                // Si l'utilisateur est connecté, on peut récupérer ses données
                $user = Auth::user();
                $reservation->email = $user->email;
                $reservation->name = $user->name;
            }

            $reservation->save();

            return redirect()->route('client.reservation.success')
                ->with('success', 'Votre réservation a été confirmée !');

        } catch (\Exception $e) {
            // Log l'erreur
            \Log::error('Erreur lors de la réservation: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de votre réservation. Veuillez réessayer ou nous contacter par téléphone.');
        }
    }

    /**
     * Affiche la page de confirmation après une réservation réussie
     */
    public function success()
    {
        return view('client.reservations.success');
    }

    /**
     * Vérifie la disponibilité d'une table à une date/heure spécifique
     */
    private function checkAvailability($date, $heure, $nombre_personnes)
    {
        // Implémentation simplifiée - à adapter selon vos besoins
        // Exemple: Maximum 10 réservations par créneau horaire
        $reservationsCount = Reservation::where('date', $date)
            ->where('heure', $heure)
            ->where('status', 'confirmed')
            ->count();

        // Logique à adapter selon votre capacité d'accueil
        $maxReservationsPerSlot = 10;
        
        // Pour les grands groupes (plus de 10 personnes), vérifier différemment
        if ($nombre_personnes === 'plus_de_10') {
            $maxReservationsPerSlot = 5; // Moins de réservations possibles pour les grands groupes
        }

        return $reservationsCount < $maxReservationsPerSlot;
    }

    /**
     * Envoie un email de confirmation de réservation
     */
    // private function sendConfirmationEmail(Reservation $reservation)
    // {
    //     // Si vous avez une classe mail pour les confirmations
    //     if ($reservation->email) {
    //         Mail::to($reservation->email)
    //             ->send(new ReservationConfirmation($reservation));
    //     }
    // }

    /**
     * Permet à l'utilisateur d'annuler sa réservation
     */
    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Vérifier que l'utilisateur est autorisé à annuler cette réservation
        if (Auth::check() && Auth::id() === $reservation->user_id) {
            $reservation->status = 'cancelled';
            $reservation->save();
            
            return redirect()->route('client.reservations.list')
                ->with('success', 'Votre réservation a été annulée avec succès.');
        }
        
        return redirect()->back()
            ->with('error', 'Vous n\'êtes pas autorisé à annuler cette réservation.');
    }

    /**
     * Liste les réservations de l'utilisateur connecté
     */
    public function index()
    {
        if (Auth::check()) {
            $reservations = Reservation::where('user_id', Auth::id())
                ->orderBy('date', 'desc')
                ->paginate(10);
                
            return view('client.reservations.index', compact('reservations'));
        }
        
        return redirect()->route('login')
            ->with('error', 'Vous devez être connecté pour voir vos réservations.');
    }
}