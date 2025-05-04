<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Disponibilite;

class GerantDashboardController extends Controller
{
    public function index()
    {
        // Exemple : Récupérer le nombre de réservations en attente et confirmées,
        // ainsi qu'un résumé des disponibilités.
        $totalReservations = Reservation::count();
        $pendingReservations = Reservation::where('status', 'en attente')->count();
        $confirmedReservations = Reservation::where('status', 'confirmée')->count();
        $disponibilites = Disponibilite::orderBy('date')->orderBy('heure')->get();

        return view('gerant.dashboard', compact(
            'totalReservations',
            'pendingReservations',
            'confirmedReservations',
            'disponibilites'
        ));
    }
}
