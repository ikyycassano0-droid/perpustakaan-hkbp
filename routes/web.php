<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- AKSES PUBLIK ---
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// --- GUEST ONLY (Hanya bisa diakses jika belum login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// --- AUTHENTICATED (Wajib Login) ---
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- GRUP ADMIN (Role ID: 1) ---
    // Pastikan middleware 'role:admin' 
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Manajemen User (CRUD)
        Route::resource('users', UserController::class);
        
        // Cetak Kartu User
        Route::get('users/{id}/print', [UserController::class, 'printCard'])->name('users.print');
    });

    // --- GRUP MAHASISWA / USER UMUM (Role ID: 3) ---
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');
    });

    // --- GRUP DOSEN (Role ID: 2) - Opsional Tambahan ---
    Route::middleware('role:dosen')->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dosen.dashboard');
        })->name('dashboard');
    });

});