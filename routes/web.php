<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\DashoardController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('checkrole')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/membre', [RegisteredUserController::class, 'store_membre'])->name('new_membre');
    Route::get('/list_user', [RegisteredUserController::class, 'listeUser'])->name('list_user');
    Route::put('/utilisateur/{id}', [RegisteredUserController::class, 'update'])->name('utilisateur.update');
    Route::delete('/utilisateur/{id}', [RegisteredUserController::class, 'destroy'])->name('utilisateur.destroy');
    Route::get('/listes-candidats', [CandidatController::class, 'liste_candidats'])->name('listes-candidats');
    Route::get('/candidats/{id}', [CandidatController::class, 'show'])->name('candidats.show');
    Route::put('/candidats/{id}', [CandidatController::class, 'update'])->name('candidats.update');
    Route::delete('/candidats/{id}', [CandidatController::class, 'destroy'])->name('candidats.destroy');
    Route::post('/enregistrement-candidat', [CandidatController::class, 'creation_candidat'])->name('candidat_create');

    Route::get('/vote', [VoteController::class, 'showVotePage'])->name('vote.index');

    Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');
    Route::get('/dashboard', [DashoardController ::class, 'showDashboard'])->name('dashboard');
    Route::get('/dashboard', [DashoardController::class, 'dashboard'])->name('dashboard');

});



require __DIR__ . '/auth.php';
