<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// AKSES PUBLIK
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// GUEST ONLY (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PROTEKSI ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// PROTEKSI USER
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});