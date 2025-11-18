<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/contoh', function () {
    return view('contoh');
});
// Form Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Proses Login
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Register Pelanggan
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
