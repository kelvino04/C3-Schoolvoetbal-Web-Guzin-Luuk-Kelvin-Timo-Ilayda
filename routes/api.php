<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\MatchApiController;

Route::post('/login', [ApiController::class, 'login']);
Route::get('/matches', [ApiController::class, 'matches']);
Route::get('/results', [MatchApiController::class, 'results']);