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
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FinalProjectController;

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
        Route::get('/pengelolaan-buku', [CollectionController::class, 'pengelolaanBuku'])->name('pengelolaan_buku');
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

    Route::prefix('orders')->name('orders.')->group(function () {

        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::post('/{id}/approve', [OrderController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [OrderController::class, 'reject'])->name('reject');
        Route::post('/{id}/return', [OrderController::class, 'returnBook'])->name('return');
        Route::post('/{id}/extend', [OrderController::class, 'extend'])->name('extend');

    });

    // ================= KOLEKSI ELEKTRONIK (FINAL PROJECT) =================
    Route::prefix('koleksi-elektronik')->name('koleksi_elektronik.')->group(function () {
        Route::get('/', [FinalProjectController::class, 'index_admin'])->name('index');

        // STORE / UPDATE ADMIN
        Route::post('/', [FinalProjectController::class, 'store_admin'])->name('store');
        Route::put('/{id}', [FinalProjectController::class, 'update_admin'])->name('update');

        // DELETE tetap sama
        Route::delete('/{id}', [FinalProjectController::class, 'destroy'])->name('delete');
    });

});

// User
Route::middleware(['auth'])->prefix('user')->group(function () {

    // Dashboard
    Route::get('/dashboard', function() {
        return view('user.page.home');
    })->name('user.dashboard');

    // Halaman pinjam
    Route::get('/pinjam', [CollectionController::class, 'pinjam'])
        ->name('user.pinjam');

    // Orders
    Route::post('/orders', [OrderController::class, 'store'])
        ->name('orders.store');

    Route::get('/history', [OrderController::class, 'history'])
        ->name('user.history');

    // ================= KOLEKSI TERCETAK =================
    Route::prefix('koleksi')->group(function () {

        Route::get('/jurnal', [CollectionController::class, 'showUserMenu'])
            ->name('user.koleksi.jurnal')
            ->defaults('menu_type', 'jurnal');

        Route::get('/buku-pengayaan', [CollectionController::class, 'showUserMenu'])
            ->name('user.koleksi.buku_pengayaan')
            ->defaults('menu_type', 'buku_pengayaan');

        Route::get('/buku-referensi', [CollectionController::class, 'showUserMenu'])
            ->name('user.koleksi.buku_referensi')
            ->defaults('menu_type', 'buku_referensi');

        Route::get('/majalah', [CollectionController::class, 'showUserMenu'])
            ->name('user.koleksi.majalah')
            ->defaults('menu_type', 'majalah');
    });

    // ================= KOLEKSI ELEKTRONIK (FINAL PROJECT) =================
    Route::prefix('final-project')->name('final_project.')->group(function() {

        Route::get('/{category}', [FinalProjectController::class, 'index'])
            ->name('index');

        Route::post('/store', [FinalProjectController::class, 'store'])
            ->name('store');

        Route::post('/update/{id}', [FinalProjectController::class, 'update'])
            ->name('update');

        Route::delete('/delete/{id}', [FinalProjectController::class, 'destroy'])
            ->name('delete');

    });

});

//Guest
Route::get('/', fn() => view('guest.page.home'))->name('home');

// PROFILE
Route::get('/visi-misi', [ProfileController::class, 'showVisiMisi']);
Route::get('/tugas-fungsi', [ProfileController::class, 'showTugasFungsi']);
Route::get('/struktur', [ProfileController::class, 'showStruktur']);

// BERITA
Route::get('/berita', [NewsController::class,'index'])->name('guest.berita.index');
Route::get('/berita/{id}', [NewsController::class, 'show'])->name('guest.berita.show');

// FINAL PROJECT (PUBLIC VIEW)
Route::get('/koleksi/{category}', [FinalProjectController::class, 'index']);


// ================= 🔥 SEARCH SYSTEM =================
Route::prefix('user')->group(function () {

    // halaman hasil search
    Route::get('/search', [CollectionController::class, 'globalSearch'])
        ->name('user.global_search');

    // LIVE SEARCH AJAX
    Route::get('/live-search', [CollectionController::class, 'liveSearch'])
        ->name('user.live_search');
});


// ================= 🔥 DETAIL COLLECTION =================
Route::get('/collections/{id}', [CollectionController::class, 'show'])
    ->name('collections.show');


// ================= 🔥 FINAL PROJECT FILE VIEW =================
Route::get('/final-project/view/{id}', function($id){
    $item = \App\Models\FinalProject::findOrFail($id);
    return response()->file(storage_path('app/public/'.$item->file_url));
});


// ================= NOTIFICATION =================
Route::middleware(['auth'])->group(function () {
    Route::get('/inbox', [NotificationController::class, 'index'])
        ->name('user.inbox');
});