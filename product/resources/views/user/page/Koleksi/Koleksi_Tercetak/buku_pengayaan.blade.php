@extends('user.component.master')

@section('title', 'Koleksi Buku Pengayaan - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN KOLEKSI BUKU PENGAYAAN
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */

    /* Glass card */
    .glass-card {
        background: rgba(30, 41, 59, 0.5);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(99, 102, 241, 0.25);
    }

    /* Glow text */
    .glow-text {
        text-shadow: 0 0 12px rgba(99, 102, 241, 0.7);
    }

    /* Tambahkan di style Visi Misi */
    .depth-2 { transform: translateZ(24px); }

    /* Title utama */
    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
    }

    /* Neon border */
    .neon-border {
        position: relative;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
        transition: all 0.3s ease;
    }

    .neon-border:hover {
        box-shadow: 0 0 30px rgba(99,102,241,0.3);
    }

    .neon-inner {
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 26px;
        padding: 2rem;
        border: 1px solid rgba(255,255,255,0.08);
    }

    /* Search input */
    .search-input {
        width: 100%;
        padding: 12px 20px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 40px;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
    }

    .search-input::placeholder {
        color: #64748b;
    }

    /* Filter button */
    .filter-btn {
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        color: #cbd5e1;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
    }

    .filter-btn:hover {
        border-color: #6366f1;
        color: white;
    }

    /* Book Card */
    .book-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .book-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }

    .book-cover {
        height: 180px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        background-color: #0f172a;
    }

    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        z-index: 2;
    }

    .status-tersedia {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }

    .status-dipinjam {
        background: rgba(245, 158, 11, 0.9);
        color: white;
    }

    /* Tooltip styling */
    .btn-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .btn-wrapper .tooltip-text {
        visibility: hidden;
        background-color: rgba(0,0,0,0.85);
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 6px 12px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        font-size: 0.7rem;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }

    .btn-wrapper:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* Sidebar Menu */
    .sidebar-menu {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        overflow: hidden;
    }

    .sidebar-item {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        cursor: pointer;
        color: #cbd5e1;
    }

    .sidebar-item:hover {
        background: rgba(99, 102, 241, 0.15);
        color: white;
        padding-left: 24px;
    }

    .sidebar-item.active {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        color: #a5b4fc;
        border-left: 3px solid #6366f1;
    }

    .sidebar-title {
        font-weight: 700;
        color: #c7d2fe;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 8px 16px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.75rem;
        width: 100%;
        text-align: center;
        display: inline-block;
    }

    .btn-primary:hover:not(:disabled) {
        transform: scale(1.02);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .btn-outline {
        background: transparent;
        padding: 8px 16px;
        border-radius: 40px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.75rem;
        width: 100%;
        text-align: center;
        display: inline-block;
    }

    .btn-outline:hover:not(:disabled) {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

    .btn-outline:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Pagination */
    .pagination-btn {
        padding: 8px 14px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 8px;
        color: #c7d2fe;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .pagination-btn:hover:not(:disabled) {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-btn.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
    }

    /* Notification */
    .notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 12px 24px;
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(99, 102, 241, 0.5);
        border-radius: 12px;
        color: white;
        z-index: 1000;
        transform: translateX(120%);
        transition: transform 0.3s ease;
    }

    .notification.show {
        transform: translateX(0);
    }

    /* Section spacing */
    .section {
        margin-top: 40px;
    }

    /* Delay utilities */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }

    /* Sidebar responsive */
    @media (max-width: 768px) {
        .sidebar-menu {
            margin-bottom: 20px;
        }
    }

    /* Custom line clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

     /* Glass card untuk halaman visi misi */
     .library-footer {
        position: relative;
        overflow: hidden;

        padding: 3.5rem 3rem 2rem;

        border-radius: 32px;

        background:
            linear-gradient(
                145deg,
                rgba(15, 23, 42, 0.92),
                rgba(17, 24, 39, 0.96)
            );

        border: 1px solid rgba(255, 255, 255, 0.06);

        backdrop-filter: blur(18px);

        box-shadow:
            0 10px 40px rgba(0, 0, 0, 0.35);
    }

    /* soft glow */
    .library-footer::before {
        content: "";

        position: absolute;

        width: 320px;
        height: 320px;

        top: -140px;
        right: -100px;

        border-radius: 999px;

        background: rgba(99, 102, 241, 0.08);

        filter: blur(80px);
    }

    /* grid */
    .footer-grid {
        position: relative;
        z-index: 2;

        display: grid;
        grid-template-columns: 1.6fr 1fr 1fr 1fr;
        gap: 3rem;
    }

    /* logo */
    .footer-logo {
        width: 58px;
        height: 58px;

        border-radius: 18px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 1.5rem;

        background:
            linear-gradient(
                135deg,
                rgba(99, 102, 241, 0.25),
                rgba(139, 92, 246, 0.15)
            );

        border: 1px solid rgba(99, 102, 241, 0.2);
    }

    /* description */
    .footer-desc {
        margin-top: 1rem;

        color: #94a3b8;

        line-height: 1.9;

        font-size: 0.95rem;

        max-width: 340px;
    }

    /* section title */
    .footer-title {
        color: white;

        font-size: 1rem;
        font-weight: 600;

        margin-bottom: 1.3rem;
    }

    /* links */
    .footer-links {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
    }

    .footer-links a {
        color: #94a3b8;

        font-size: 0.92rem;

        transition: all .25s ease;
    }

    .footer-links a:hover {
        color: #c7d2fe;

        transform: translateX(4px);
    }

    .footer-social {
        width: 44px;
        height: 44px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background: rgba(255, 255, 255, 0.04);

        border: 1px solid rgba(255, 255, 255, 0.06);

        color: #cbd5e1;

        backdrop-filter: blur(10px);

        transition: all .3s ease;
    }

    .footer-social:hover {
        transform: translateY(-4px);

        background:
            linear-gradient(
                135deg,
                rgba(99, 102, 241, 0.18),
                rgba(139, 92, 246, 0.12)
            );

        border-color: rgba(99, 102, 241, 0.28);

        color: white;

        box-shadow:
            0 10px 24px rgba(99, 102, 241, 0.18);
    }

    /* contact */
    .footer-contact {
        display: flex;
        gap: 12px;

        color: #94a3b8;

        line-height: 1.7;
    }

    /* divider */
    .footer-divider {
        height: 1px;

        margin: 2.5rem 0 1.5rem;

        background:
            linear-gradient(
                to right,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
    }

    /* bottom */
    .footer-bottom {
        position: relative;
        z-index: 2;

        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 1rem;

        color: #64748b;

        font-size: 0.85rem;
    }

    .footer-bottom-links {
        display: flex;
        gap: 1.5rem;
    }

    .footer-bottom-links a {
        transition: .25s ease;
    }

    .footer-bottom-links a:hover {
        color: #c7d2fe;
    }

    /* responsive */
    @media (max-width: 992px) {

        .footer-grid {
            grid-template-columns: 1fr 1fr;
        }

    }

    @media (max-width: 640px) {

        .library-footer {
            padding: 2rem;
            border-radius: 24px;
        }

        .footer-grid {
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }

        .footer-bottom {
            flex-direction: column;
            align-items: flex-start;
        }

        .footer-bottom-links {
            flex-wrap: wrap;
            gap: 1rem;
        }

    }
</style>
@endpush

@section('content')
{{-- DEBUG INFO --}}
@if($errors->any())
    <div class="fixed top-32 right-5 z-50 bg-red-600 text-white p-3 rounded-lg text-xs shadow-lg">
        @foreach($errors->all() as $error)
            <div>❌ {{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="main-content">
    {{-- 🔥 NOTIFICATION --}}
    @if(session('success'))
        <div id="notif" class="notification">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="notif" class="notification" style="border-color:red">
            {{ session('error') }}
        </div>
    @endif

    {{-- HERO --}}
    <section class="pt-28 pb-12 text-center px-5">
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
            Koleksi Buku <br>
            <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">Pengayaan</span>
        </h1>
        <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
            Eksplorasi wawasan literasi non-klinis, tingkatkan pengetahuan Anda
        </p>
    </section>

    {{-- GRID BUKU --}}
    <section class="max-w-7xl mx-auto px-5 pb-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($collections as $book)
                @php
                    // Ambil status peminjaman untuk buku ini (dari controller)
                    $borrowStatus = $userBorrowStatus[$book->id] ?? null;

                    // Inisialisasi variabel tombol
                    $buttonText = 'Pinjam';
                    $buttonClass = 'btn-primary';
                    $buttonDisabled = false;
                    $buttonOnclick = "openModal({$book->id}, '".addslashes($book->title)."')";
                    $tooltipText = '';

                    // Jika user sudah login, tentukan status tombol secara detail
                    if (auth()->check()) {
                        // Hitung jumlah peminjaman aktif (PENDING/APPROVED) untuk user ini
                        $activeBorrowCount = \App\Models\Order::where('user_id', auth()->id())
                            ->whereIn('status', ['PENDING', 'APPROVED'])
                            ->count();

                        if ($borrowStatus) {
                            switch ($borrowStatus['status']) {
                                case 'PENDING':
                                    $buttonText = '⏳ Menunggu Konfirmasi';
                                    $buttonClass = 'btn-outline';
                                    $buttonDisabled = true;
                                    $buttonOnclick = '';
                                    $tooltipText = 'Pengajuan peminjaman sedang diproses admin';
                                    break;
                                case 'APPROVED':
                                    $buttonText = '📚 Sedang Dipinjam';
                                    $buttonClass = 'btn-outline';
                                    $buttonDisabled = true;
                                    $buttonOnclick = '';
                                    $tooltipText = 'Anda sedang meminjam buku ini';
                                    break;
                                case 'REJECTED':
                                    $buttonText = '🔄 Pinjam Lagi';
                                    $buttonClass = 'btn-primary';
                                    $buttonDisabled = false;
                                    $buttonOnclick = "openModal({$book->id}, '".addslashes($book->title)."')";
                                    $tooltipText = 'Pengajuan sebelumnya ditolak, Anda dapat meminjam ulang';
                                    break;
                            }
                        } else {
                            // Belum pernah meminjam buku ini
                            if ($book->available_stock < 1) {
                                $buttonText = '❌ Habis';
                                $buttonClass = 'btn-outline';
                                $buttonDisabled = true;
                                $buttonOnclick = '';
                                $tooltipText = 'Stok buku sedang kosong';
                            } elseif ($activeBorrowCount >= 3) {
                                $buttonText = '⚠️ Maksimal 3 Buku';
                                $buttonClass = 'btn-outline';
                                $buttonDisabled = true;
                                $buttonOnclick = '';
                                $tooltipText = 'Anda sudah mencapai batas maksimal peminjaman (3 buku)';
                            } else {
                                $buttonText = 'Pinjam';
                                $buttonClass = 'btn-primary';
                                $buttonDisabled = false;
                                $buttonOnclick = "openModal({$book->id}, '".addslashes($book->title)."')";
                                $tooltipText = 'Pinjam buku ini';
                            }
                        }
                    } else {
                        // Guest
                        $buttonText = 'Login';
                        $buttonClass = 'btn-primary';
                        $buttonDisabled = false;
                        $buttonOnclick = "window.location.href='{{ route('login') }}'";
                        $tooltipText = 'Silakan login untuk meminjam buku';
                    }
                @endphp

                <div class="book-card">
                    <div class="book-cover" style="background-image: url('{{ $book->cover_url ?: asset('images/default-cover.jpg') }}');">
                        <span class="status-badge {{ $book->available_stock > 0 ? 'status-tersedia' : 'status-dipinjam' }}">
                            {{ $book->available_stock > 0 ? 'TERSEDIA' : 'DIPINJAM' }}
                        </span>
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-semibold text-indigo-200 line-clamp-2 min-h-[3rem]">
                            {{ $book->title }}
                        </h3>
                        <p class="text-xs text-gray-400 mt-1 mb-3">
                            {{ $book->author_string }}
                        </p>

                        <div class="flex gap-2 mt-auto">
                            <a href="{{ route('user.koleksi.detail', $book->id) }}"
                               class="btn-outline flex-1 text-center">
                                Detail
                            </a>

                            <div class="btn-wrapper flex-1">
                                @if($buttonOnclick && !$buttonDisabled)
                                    <button onclick="{{ $buttonOnclick }}"
                                            class="{{ $buttonClass }}"
                                            {{ $buttonDisabled ? 'disabled' : '' }}>
                                        {{ $buttonText }}
                                    </button>
                                @else
                                    <button class="{{ $buttonClass }}" disabled>
                                        {{ $buttonText }}
                                    </button>
                                @endif
                                @if($tooltipText)
                                    <span class="tooltip-text">{{ $tooltipText }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-16">
                    <div class="text-6xl mb-4">📭</div>
                    <p class="text-lg">Belum ada buku dalam koleksi ini</p>
                    <p class="text-sm mt-2">Silakan cek kembali nanti</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($collections->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $collections->links() }}
            </div>
        @endif
    </section>
</div>

{{-- ================= MODAL PINJAM ================= --}}
<div id="pinjamModal"
     class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-slate-900 w-full max-w-md rounded-2xl border border-indigo-500/30 shadow-2xl">
        <div class="p-6">
            <h2 class="text-xl font-bold text-indigo-300 mb-4">
                Form Peminjaman
            </h2>

            <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
                @csrf
                <input type="hidden" name="collection_id" id="collection_id">

                <div class="mb-4">
                    <label class="block text-xs text-gray-400 mb-1">Judul Buku</label>
                    <input type="text" id="book_title"
                           class="w-full p-2 rounded-lg bg-slate-800 text-white border border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition"
                           readonly>
                </div>

                <div class="mb-4">
                    <label class="block text-xs text-gray-400 mb-1">Tanggal Pinjam</label>
                    <input type="date" name="borrow_date" id="borrow_date"
                           class="w-full p-2 rounded-lg bg-slate-800 text-white border border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition"
                           required>
                </div>

                <div class="mb-6">
                    <label class="block text-xs text-gray-400 mb-1">Tanggal Kembali</label>
                    <input type="date" name="return_date" id="return_date"
                           class="w-full p-2 rounded-lg bg-slate-800 text-white border border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition"
                           required>
                    <p class="text-xs text-gray-500 mt-1">* Maksimal peminjaman 3 hari</p>
                </div>

                <div class="flex gap-3">
                    <button type="button"
                            onclick="closeModal()"
                            class="flex-1 py-2 rounded-lg bg-gray-700 text-white hover:bg-gray-600 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-500 transition">
                        Pinjam
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ================= FOOTER ================= -->
    <footer class="px-10 pb-12 pt-6">

        <div class="max-w-9xl mx-auto">

            <div class="library-footer fade-up">

                <div class="footer-grid">

                    <!-- BRAND -->
                    <div>

                        <div class="flex items-center gap-4">

                            <div class="footer-logo">
                                📚
                            </div>

                            <div>

                                <h3 class="text-white font-semibold text-lg">
                                    Perpustakaan Digital
                                </h3>

                                <p class="text-indigo-300 text-sm">
                                    AKPER HKBP Balige
                                </p>

                            </div>

                        </div>

                        <p class="footer-desc">
                            Menyediakan akses e-book, jurnal,
                            repository ilmiah, dan literatur digital
                            modern untuk mendukung pembelajaran mahasiswa.
                        </p>

                        <!-- SOCIAL MEDIA -->
                        <div class="flex items-center gap-3 mt-6">

                            <a
                                href="#"
                                class="footer-social"
                                aria-label="Website"
                            >
                                <i class="fas fa-globe"></i>
                            </a>

                            <a
                                href="#"
                                class="footer-social"
                                aria-label="Facebook"
                            >
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <a
                                href="#"
                                class="footer-social"
                                aria-label="YouTube"
                            >
                                <i class="fab fa-youtube"></i>
                            </a>

                            <a
                                href="#"
                                class="footer-social"
                                aria-label="Instagram"
                            >
                                <i class="fab fa-instagram"></i>
                            </a>

                        </div>

                    </div>

                    <!-- NAVIGATION -->
                    <div>

                        <h4 class="footer-title">
                            Navigasi
                        </h4>

                        <ul class="footer-links">

                            <li>
                                <a href="{{ route('home') }}">
                                    Beranda
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('guest.profile.tugas-fungsi') }}">
                                    E-Book
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    E-Journal
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Repository
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Katalog
                                </a>
                            </li>

                        </ul>

                    </div>

                    <!-- SERVICES -->
                    <div>

                        <h4 class="footer-title">
                            Layanan
                        </h4>

                        <ul class="footer-links">

                            <li>
                                <a href="{{ route('user.pinjam') }}">
                                    Peminjaman
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('final_project.upload.kti') }}">
                                    Upload KTI
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('panduan') }}">
                                    Literasi Digital
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('user.profile.struktur') }}">
                                    Keanggotaan
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Bantuan
                                </a>
                            </li>

                        </ul>

                    </div>

                    <!-- CONTACT -->
                    <div>

                        <h4 class="footer-title">
                            Kontak
                        </h4>

                        <div class="space-y-4 text-sm">

                            <div class="footer-contact">

                                <span>
                                    📍
                                </span>

                                <p>
                                    AKPER HKBP Balige,
                                    Sumatera Utara
                                </p>

                            </div>

                            <div class="footer-contact">

                                <span>
                                    📧
                                </span>

                                <p>
                                    library@akperhkbp.ac.id
                                </p>

                            </div>

                            <div class="footer-contact">

                                <span>
                                    📞
                                </span>

                                <p>
                                    +62 812 xxxx xxxx
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- divider -->
                <div class="footer-divider"></div>

                <!-- bottom -->
                <div class="footer-bottom">

                    <p>
                        © 2026 Perpustakaan Digital AKPER HKBP Balige.
                    </p>

                    <div class="footer-bottom-links">

                        <a href="#">
                            Privacy
                        </a>

                        <a href="#">
                            Terms
                        </a>

                        <a href="#">
                            Support
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </footer>
@endsection

@push('scripts')
<script>
    // ================= FORMAT DATE =================
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // ================= OPEN MODAL =================
    function openModal(id, title) {
        const modal = document.getElementById('pinjamModal');
        modal.classList.remove('hidden');

        document.getElementById('collection_id').value = id;
        document.getElementById('book_title').value = title;

        const today = new Date();
        today.setHours(0,0,0,0);

        const borrowInput = document.getElementById('borrow_date');
        const returnInput = document.getElementById('return_date');

        // Reset value
        borrowInput.value = '';
        returnInput.value = '';

        // Set batasan & default
        borrowInput.min = formatDate(today);
        borrowInput.value = formatDate(today);

        const minReturn = new Date(today);
        minReturn.setDate(minReturn.getDate() + 1);
        const maxReturn = new Date(today);
        maxReturn.setDate(maxReturn.getDate() + 3);

        returnInput.min = formatDate(minReturn);
        returnInput.max = formatDate(maxReturn);
        returnInput.value = formatDate(minReturn);
    }

    // ================= CLOSE MODAL =================
    function closeModal() {
        document.getElementById('pinjamModal').classList.add('hidden');
    }

    // ================= VALIDASI & SUBMIT =================
    document.addEventListener('submit', function(e) {
        if (e.target.id === 'pinjamForm') {
            e.preventDefault();

            const collectionId = document.getElementById('collection_id').value;
            const borrowDate = document.getElementById('borrow_date').value;
            const returnDate = document.getElementById('return_date').value;

            if (!collectionId) {
                alert('Terjadi kesalahan, silakan coba lagi.');
                return;
            }

            if (!borrowDate || !returnDate) {
                alert('Tanggal pinjam dan kembali harus diisi!');
                return;
            }

            const borrow = new Date(borrowDate);
            const ret = new Date(returnDate);
            borrow.setHours(0,0,0,0);
            ret.setHours(0,0,0,0);

            const diff = (ret - borrow) / (1000 * 60 * 60 * 24);

            if (diff < 1) {
                alert('Minimal peminjaman adalah 1 hari');
                return;
            }

            if (diff > 3) {
                alert('Maksimal peminjaman hanya 3 hari');
                return;
            }

            // Submit form
            const btn = e.target.querySelector('button[type="submit"]');
            const originalText = btn.innerText;
            btn.innerText = 'Memproses...';
            btn.disabled = true;

            e.target.submit();

            // Optional: restore jika terjadi error (tidak akan tercapai jika submit berhasil)
            setTimeout(() => {
                btn.innerText = originalText;
                btn.disabled = false;
            }, 5000);
        }
    });

    // ================= UPDATE RETURN DINAMIS =================
    document.addEventListener('change', function(e) {
        if (e.target.id === 'borrow_date') {
            const borrow = new Date(e.target.value);
            borrow.setHours(0,0,0,0);

            const returnInput = document.getElementById('return_date');

            const minReturn = new Date(borrow);
            minReturn.setDate(minReturn.getDate() + 1);
            const maxReturn = new Date(borrow);
            maxReturn.setDate(maxReturn.getDate() + 3);

            returnInput.min = formatDate(minReturn);
            returnInput.max = formatDate(maxReturn);

            const currentReturn = new Date(returnInput.value);
            if (isNaN(currentReturn) || currentReturn < minReturn || currentReturn > maxReturn) {
                returnInput.value = formatDate(minReturn);
            }
        }
    });

    // Auto close notification
    document.addEventListener('DOMContentLoaded', function() {
        const notif = document.getElementById('notif');
        if (notif) {
            setTimeout(() => {
                notif.classList.add('show');
                setTimeout(() => {
                    notif.classList.remove('show');
                }, 3000);
            }, 100);
        }
    });

    // Tutup modal jika klik di luar area modal
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('pinjamModal');
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
@endpush
