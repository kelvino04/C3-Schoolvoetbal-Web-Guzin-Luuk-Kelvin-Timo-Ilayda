<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index', ['greeting' => 'Welkom op de site!']);
});

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/login', function () {
    return view('auth.login');
});
