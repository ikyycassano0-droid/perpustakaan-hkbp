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
use App\Http\Controllers\ArchiveController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request, $id) {

    $user = User::findOrFail($id);

    
    if ($user->hasVerifiedEmail()) {
        return redirect('/login')->with('info', 'Email sudah diverifikasi sebelumnya');
    }

    
    $request->fulfill();

    return redirect('/login')->with('success', 'Email berhasil diverifikasi!');

})->middleware(['signed'])->name('verification.verify');

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
        Route::get('/{id}/edit', [MemberController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MemberController::class, 'update'])->name('update');
        Route::post('/{id}/delete', [MemberController::class, 'destroy'])->name('destroy.post');
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

    // ================= KTI ADMIN =================
    Route::prefix('kti')->name('kti.')->middleware(['auth','admin'])->group(function () {

        // List semua KTI
        Route::get('/', [FinalProjectController::class, 'index_kti_admin'])->name('index');

        // Menampilkan KTI yang pending approval
        Route::get('/pending', [FinalProjectController::class, 'pending_admin'])->name('pending');

        // Approve / Reject
        Route::post('/{id}/approve', [FinalProjectController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [FinalProjectController::class, 'reject'])->name('reject');

        // Delete KTI
        Route::delete('/{id}', [FinalProjectController::class, 'destroy'])->name('delete');
    });

    // ================= LAYANAN (ARCHIVE) =================
    Route::prefix('layanan')->name('layanan.')->group(function () {

        Route::get('/', [ArchiveController::class, 'index'])->name('index');

        Route::get('/{category}', [ArchiveController::class, 'byCategory'])->name('category');

        Route::post('/', [ArchiveController::class, 'store'])->name('store');
        Route::put('/{id}', [ArchiveController::class, 'update'])->name('update');
        Route::delete('/{id}', [ArchiveController::class, 'destroy'])->name('delete');
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

    // ================= PROFILE =================
    Route::prefix('profile')->name('user.profile.')->group(function () {

        // Mahasiswa
        Route::get('/visi-misi', [ProfileController::class, 'showVisiMisiMahasiswa'])
            ->name('visi_misi');

        Route::get('/tugas-fungsi', [ProfileController::class, 'showTugasFungsiMahasiswa'])
            ->name('tugas_fungsi');

        Route::get('/struktur', [ProfileController::class, 'showStrukturMahasiswa'])
            ->name('struktur');

    });

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

    Route::prefix('final-project')->name('final_project.')->group(function() {

        // ✅ KTI → user upload
        Route::get('/kti', [FinalProjectController::class,'index'])       ->name('kti')->defaults('category','kti');
        Route::post('/kti/store', [FinalProjectController::class,'store'])->name('kti.store');
        Route::post('/kti/update/{id}', [FinalProjectController::class,'update'])->name('kti.update');
        Route::delete('/kti/delete/{id}', [FinalProjectController::class,'destroy'])->name('kti.delete');

        
        Route::get('/{category}', [FinalProjectController::class,'index'])
            ->name('index')
            ->where('category','ebook|e-article|cd|video');
    });

});

//Guest

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
    Route::get('/koleksi/{category}', [FinalProjectController::class, 'index']);

    Route::get('/layanan/{category}', [ArchiveController::class, 'indexLayananGuest'])
        ->name('guest.layanan.show');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/inbox', [NotificationController::class, 'index'])
        ->name('user.inbox');

});

// routes/web.php
Route::prefix('user')->group(function () {
    Route::get('/search', [CollectionController::class, 'globalSearch'])
        ->name('user.global_search');
});
