<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\MatchesController;

Route::get('/', function () {
    return view('index');
});

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])
    ->name('admin.index');

Route::put('/admin/{user}/role', [App\Http\Controllers\AdminController::class, 'updateRole'])
    ->name('admin.updateRole');

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    $topTeams = \App\Models\Team::orderByDesc('points')->take(5)->get();
    return view('dashboard', compact('topTeams'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('teams', [TeamsController::class, 'index'])->name('teams.index');


        Route::get('teams/create', [TeamsController::class, 'create'])->name('teams.create');
        Route::post('teams', [TeamsController::class, 'store'])->name('teams.store');
        Route::get('teams/{team}/edit', [TeamsController::class, 'edit'])->name('teams.edit');
        Route::put('teams/{team}', [TeamsController::class, 'update'])->name('teams.update');
        Route::delete('teams/{team}', [TeamsController::class, 'destroy'])->name('teams.destroy');
    

    Route::resource('matches', MatchesController::class);
});

