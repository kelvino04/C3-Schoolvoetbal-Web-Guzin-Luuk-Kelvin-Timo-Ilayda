<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::get('/matches', [ApiController::class, 'matches']);
Route::get('/results', [ApiController::class, 'results']);