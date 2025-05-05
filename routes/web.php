<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DisponibiliteController;
use App\Http\Controllers\GerantDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil publique
Route::get('/', fn() => view('welcome'));
Route::get('/test', fn() => view('test'));

// Routes générales nécessitant l'authentification
Route::middleware('auth')->group(function () {
    // Dashboard général
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Profil
    Route::get('/profile',   [ProfileController::class, 'edit']   )->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'] )->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -----------------------------
// Module CLIENT1
// -----------------------------
// Route::middleware('auth')
//      ->prefix('client')
//      ->name('client.')
//      ->group(function(){
//     // Page réservation
//     Route::view('/reservation', 'clients.reservation')
//          ->name('reservation.page');

//     // Créer une réservation
//     Route::post('/reservation', [ReservationController::class, 'store'])
//          ->name('reservation.store');

//     // Vérifier disponibilités
//     Route::view('/availability', 'clients.availability')
//          ->name('availability.page');
//     Route::post('/availability/check', [ReservationController::class, 'checkAvailability'])
//          ->name('availability.check');

//     // Historique
//     Route::get('/history', [ReservationController::class, 'history'])
//          ->name('history.page');

//     // Annulation
//     Route::post('/reservation/cancel', [ReservationController::class, 'cancel'])
//          ->name('reservation.cancel');
// });


// -----------------------------
// Module CLIENT2
// -----------------------------

Route::middleware(['auth'])->prefix('client')->name('client.')->group(function(){
    // Page Réserver
    Route::get('/reservation', function(){
        return view('clients.reservation');
    })->name('reservation.page');

    // Traitement de la réservation
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');


    // Page Vérifier Disponibilités
    Route::get('/availability', function(){
        return view('clients.availability');
    })->name('availability.page');

    // Vérification des disponibilités (retour JSON, utilisé par AJAX)
    Route::post('/availability/check', [ReservationController::class, 'checkAvailability'])->name('availability.check');

    // Page Historique
    Route::get('/history', function(){
        $reservations = \App\Models\Reservation::where('user_id', auth()->id())
                            ->orderBy('date', 'desc')
                            ->orderBy('heure', 'asc')
                            ->get();
        return view('clients.history', compact('reservations'));
    })->name('history.page');

    // Annulation d'une réservation
    Route::post('/reservation/cancel', [ReservationController::class, 'cancel'])->name('reservation.cancel');
});



// -----------------------------
// Module GÉRANT
// -----------------------------
Route::middleware('auth')
     ->prefix('gerant')
     ->name('gerant.')
     ->group(function(){
    // Dashboard gérant
    Route::get('/dashboard', [GerantDashboardController::class, 'index'])
         ->name('dashboard');

    // Gestion des réservations
    Route::get('/reservations', [ReservationController::class, 'index'])
         ->name('reservations.index');
    Route::post('/reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])
         ->name('reservations.confirm');

    // Gestion des disponibilités
    Route::resource('disponibilites', DisponibiliteController::class)
         ->only(['index','create','store','edit','update','destroy']);

    // Gestion des menus
    Route::resource('menus', MenuController::class);

});


// -----------------------------
// Module ADMINISTRATEUR
// -----------------------------
Route::middleware('auth')
     ->prefix('admin')
     ->name('admin.')
     ->group(function() {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Gestion des utilisateurs
    Route::resource('users', AdminController::class)
         ->except(['show']);
      // Index des disponibilités
      Route::get('/disponibilites', [AdminController::class, 'disponibilites'])
      ->name('disponibilites.index');

 // Index des réservations
 Route::get('/reservations', [AdminController::class, 'reservations'])
      ->name('reservations.index');
    // Basculer l'état actif/inactif d'un utilisateur
Route::post('/users/{user}/toggle', [\App\Http\Controllers\AdminController::class, 'toggle'])
         ->name('users.toggle');

});

require __DIR__.'/auth.php';
