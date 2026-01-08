<?php
use App\Http\Controllers\ApiController;

Route::post('/login', [ApiController::class, 'login']);
Route::get('/matches', [ApiController::class, 'matches']);
Route::get('/results', [ApiController::class, 'results']);
