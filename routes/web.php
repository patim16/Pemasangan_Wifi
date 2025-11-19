<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;

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

//dashboard superadmin
route::get('/superadmin/dashboard', [UserController::class, 'superAdminController'])->name('superadmin.dashboard');
// route::get('/superadmin/dashboard', function(){
//     return view('superadmin.dashboard');
// })->name('superadmin.dashboard');

//dashboard admin
route::get('/admin/dashboard', function(){
    return view('admin.dashboard');
})->name('admin.dashboard');