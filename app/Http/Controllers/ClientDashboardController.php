<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ClientDashboardController extends Controller
{
    /**
     * Affiche le dashboard du client avec l'historique de ses réservations.
     */
    public function index()
    {
        // Récupère les réservations du client courant, triées par date et heure
        $reservations = Reservation::where('client_id', Auth::id())
                            ->orderBy('date', 'desc')
                            ->orderBy('heure', 'asc')
                            ->get();

        return view('clients.dashboard', compact('reservations'));
    }
}
