<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

// Login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard admin
Route::get('admin/dashboard', function(){
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('auth');

// Dashboard user biasa
Route::get('user/dashboard', function(){
    return view('user.dashboard');
})->name('user.dashboard')->middleware('auth');

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('guest.page.home'); // path Blade tetap: guest.page.home
    })->name('home');

    Route::get('/visi-misi', [ProfileController::class, 'showVisiMisi'])
        ->name('guest.page.profile.visi-misi'); // path tetap

    Route::get('/tugas-fungsi', [ProfileController::class, 'showTugasFungsi'])
        ->name('guest.page.profile.tugas-fungsi'); // path tetap

    Route::get('/struktur', [ProfileController::class, 'showStruktur'])
        ->name('guest.page.profile.struktur pengurus'); // path tetap
});