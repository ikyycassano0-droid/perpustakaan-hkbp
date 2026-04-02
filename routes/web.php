<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\CategoryCollectionController;
use App\Http\Controllers\LocationController;

// Login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard admin
Route::get('admin/dashboard', function(){
    return view('admin.page.home');
})->name('admin.home');
    
Route::prefix('admin')->name('admin.')->middleware(['auth','admin'])->group(function () {

    Route::prefix('members')->name('members.')->group(function () {

        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('/create', [MemberController::class, 'create'])->name('create');
        Route::post('/', [MemberController::class, 'store'])->name('store');

    });

    Route::prefix('profile')->name('profile.')->group(function () {

        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/create', [ProfileController::class, 'create'])->name('create');
        Route::post('/', [ProfileController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProfileController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('berita')->name('berita.')->group(function () {
        Route::get('/', [NewsController::class,'index_admin'])->name('index');
        Route::post('/', [NewsController::class,'store'])->name('store');
        Route::put('/{news}', [NewsController::class,'update'])->name('update');
        Route::delete('/{news}', [NewsController::class,'destroy'])->name('destroy');

    });

    // ================= COLLECTION =================
    Route::prefix('collections')->name('collections.')->group(function () {
        Route::get('/', [CollectionController::class, 'index_admin'])->name('index');
        Route::post('/', [CollectionController::class, 'store'])->name('store');
        Route::put('/{collection}', [CollectionController::class, 'update'])->name('update');
        Route::delete('/{collection}', [CollectionController::class, 'destroy'])->name('destroy');
    });

    // ================= CLASSIFICATION =================
    Route::prefix('classification')->name('classification.')->group(function () {
        Route::get('/', [ClassificationController::class, 'index'])->name('index');
        Route::post('/', [ClassificationController::class, 'store'])->name('store');
        Route::put('/{classification}', [ClassificationController::class, 'update'])->name('update');
        Route::delete('/{classification}', [ClassificationController::class, 'destroy'])->name('delete');

        // AJAX tambah
        Route::post('/ajax', [ClassificationController::class, 'storeAjax'])->name('storeAjax');

        // HAPUS TERAKHIR
        Route::delete('/delete-last', [ClassificationController::class, 'deleteLast'])->name('deleteLast');
    });

    // ================= CATEGORY =================
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryCollectionController::class, 'index'])->name('index');
        Route::post('/', [CategoryCollectionController::class, 'store'])->name('store');
        Route::put('/{category}', [CategoryCollectionController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryCollectionController::class, 'destroy'])->name('delete');

        // AJAX tambah
        Route::post('/ajax', [CategoryCollectionController::class, 'storeAjax'])->name('storeAjax');

        // HAPUS TERAKHIR
        Route::delete('/delete-last', [CategoryCollectionController::class, 'deleteLast'])->name('deleteLast');
    });

    // ================= LOCATION =================
    Route::prefix('location')->name('location.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::post('/', [LocationController::class, 'store'])->name('store');
        Route::put('/{location}', [LocationController::class, 'update'])->name('update');
        Route::delete('/{location}', [LocationController::class, 'destroy'])->name('delete');

        // AJAX tambah
        Route::post('/ajax', [LocationController::class, 'storeAjax'])->name('storeAjax');

        // HAPUS TERAKHIR
        Route::delete('/delete-last', [LocationController::class, 'deleteLast'])->name('deleteLast');
    });

});


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
    Route::get('/berita', [NewsController::class,'index'])
    ->name('guest.berita.index');
    Route::get('/berita/{id}', [NewsController::class, 'show'])
    ->name('guest.berita.show');
});