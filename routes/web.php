<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\MatchesController;

// Public homepage
Route::get('/', function () {
    return view('index');
});

Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');

// Auth routes
require __DIR__.'/auth.php';

// Dashboard: Top 5 teams
Route::get('/dashboard', function () {
    $topTeams = \App\Models\Team::orderByDesc('points')->take(5)->get();
    return view('dashboard', compact('topTeams'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Teams CRUD
    Route::resource('teams', TeamsController::class);

    // Matches CRUD
    Route::resource('matches', MatchesController::class);


});
