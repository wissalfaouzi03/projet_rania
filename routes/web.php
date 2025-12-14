<?php

use App\Http\Controllers\LivreController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route d'accueil - redirige vers la liste des livres
Route::get('/', function () {
    return redirect()->route('livres.index');
});

// Routes d'authentification (gérées par Breeze via routes/auth.php)
require __DIR__.'/auth.php';

// Routes publiques pour les livres
Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');
Route::get('/livres/{livre}', [LivreController::class, 'show'])->name('livres.show');

// Routes authentifiées
Route::middleware('auth')->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Réservations (utilisateurs peuvent créer, voir et annuler leurs réservations)
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Actions admin sur les réservations
    Route::post('/reservations/{reservation}/valider', [ReservationController::class, 'valider'])
        ->name('reservations.valider');
    Route::post('/reservations/{reservation}/annuler', [ReservationController::class, 'annuler'])
        ->name('reservations.annuler');
});

// Routes admin (nécessitent authentification ET rôle admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion des livres (admin)
    Route::get('/livres/create', [LivreController::class, 'create'])->name('livres.create');
    Route::post('/livres', [LivreController::class, 'store'])->name('livres.store');
    Route::get('/livres/{livre}/edit', [LivreController::class, 'edit'])->name('livres.edit');
    Route::put('/livres/{livre}', [LivreController::class, 'update'])->name('livres.update');
    Route::delete('/livres/{livre}', [LivreController::class, 'destroy'])->name('livres.destroy');

    // Gestion des utilisateurs (admin)
    Route::resource('users', UserController::class);
});
