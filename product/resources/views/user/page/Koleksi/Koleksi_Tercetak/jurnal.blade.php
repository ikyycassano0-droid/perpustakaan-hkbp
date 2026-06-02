@extends('user.component.master')


@section('title', 'Jurnal Ilmiah - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN JURNAL
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */

    /* Glass card untuk jurnal */
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

    /* Journal Card */
    .journal-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
        height: 100%;
    }

    .journal-card:hover {
        transform: translateY(-8px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.3);
    }

    .journal-header {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }

    .journal-title {
        font-weight: 700;
        font-size: 1.1rem;
        line-height: 1.4;
        color: #c7d2fe;
        margin-bottom: 0.5rem;
    }

    .journal-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.7rem;
        color: #94a3b8;
    }

    .journal-body {
        padding: 1.25rem;
    }

    .journal-abstract {
        font-size: 0.85rem;
        color: #cbd5e1;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .journal-keywords {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .keyword-tag {
        background: rgba(99, 102, 241, 0.15);
        border: 1px solid rgba(99, 102, 241, 0.3);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.65rem;
        color: #a5b4fc;
    }

    .journal-ref {
        font-size: 0.7rem;
        color: #64748b;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 0.75rem;
        margin-top: 0.5rem;
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
        display: inline-block;
        text-decoration: none;
        text-align: center;
    }

    .btn-primary:hover:not(:disabled) {
        transform: scale(1.05);
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
        display: inline-block;
        text-decoration: none;
        text-align: center;
    }

    .btn-outline:hover:not(:disabled) {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

    .btn-outline:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Status Badge */
    .status-tersedia {
        display: inline-block;
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.5);
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
    }

    .status-diproses {
        display: inline-block;
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.5);
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
    }

    .status-habis {
        display: inline-block;
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.5);
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
    }

    /* Action Buttons Row */
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    /* Filter button */
    .filter-btn {
        padding: 6px 16px;
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

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(12px);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        visibility: hidden;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        visibility: visible;
        opacity: 1;
    }

    .modal-container {
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(99, 102, 241, 0.5);
        border-radius: 1.5rem;
        width: 100%;
        max-width: 28rem;
        margin: 1rem;
        transform: scale(0.9);
        transition: transform 0.3s ease;
    }

    .modal-overlay.active .modal-container {
        transform: scale(1);
    }

    /* Section spacing */
    .section {
        margin-top: 40px;
    }

    /* Line clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Delay utilities */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }

    /* Responsive */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        .btn-primary, .btn-outline {
            width: 100%;
            text-align: center;
        }
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

<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                📚 AKPER HKBP BALIGE
            </span>
        </div>

        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
    Jurnal
    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">Ilmiah</span>
</h1>

        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Kumpulan artikel ilmiah, penelitian keperawatan, dan publikasi akademik.
        </p>
    </section>

    <!-- CONTENT SECTION -->
    <section class="section max-w-6xl mx-auto px-5">

        <div class="neon-border fade-up">
            <div class="neon-inner">

                <!-- SEARCH -->
                <form method="GET" class="mb-6">
                    <input type="text" name="search"
                           value="{{ request('search') }}"
                           class="search-input"
                           placeholder="🔍 Cari jurnal...">
                </form>

                <!-- GRID DATA -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    @forelse ($collections as $item)
                        @php
                            $borrowStatus = $userBorrowStatus[$item->id] ?? null;
                        @endphp

                        <div class="journal-card">

                            <!-- HEADER -->
                            <div class="journal-header">
                                <div class="journal-title">
                                    {{ $item->title }}
                                </div>

                                <div class="journal-meta">
                                    <span>👨‍⚕️ {{ $item->author_string }}</span>
                                    <span>📅 {{ $item->publication_year ?? '-' }}</span>
                                    <span>📄 {{ $item->edition ?? '-' }}</span>
                                </div>
                            </div>

                            <!-- BODY -->
                            <div class="journal-body">

                                <div class="journal-abstract">
                                    {{ Str::limit($item->description ?? 'Tidak ada deskripsi', 150) }}
                                </div>

                                <!-- Status Stok -->
                                <div class="mb-3">
                                    @if($item->available_stock > 0)
                                        <span class="status-tersedia">✓ Tersedia (Stok: {{ $item->available_stock }})</span>
                                    @else
                                        <span class="status-habis">✗ Stok Habis</span>
                                    @endif
                                </div>

                                <!-- ACTION BUTTONS -->
                                <div class="action-buttons">

                                    <a href="{{ route('user.koleksi.detail', $item->id) }}"
                                       class="btn-outline flex-1 text-center">
                                        📖 Detail
                                    </a>

                                    @if($item->file_url)
                                        <a href="{{ asset('storage/'.$item->file_url) }}"
                                           target="_blank"
                                           class="btn-outline flex-1 text-center">
                                            📥 PDF
                                        </a>
                                    @endif

                                    @if(session()->has('user'))
                                        @if($borrowStatus && in_array($borrowStatus['status'], ['PENDING', 'APPROVED']))
                                            @if($borrowStatus['status'] == 'PENDING')
                                                <button class="btn-outline flex-1 text-center" disabled>
                                                    ⏳ Diproses
                                                </button>
                                            @else
                                                <button class="btn-outline flex-1 text-center" disabled>
                                                    📚 Dipinjam
                                                </button>
                                            @endif
                                        @elseif($item->available_stock > 0)
                                            <button onclick="openModal({{ $item->id }}, '{{ addslashes($item->title) }}')"
                                                    class="btn-primary flex-1 text-center">
                                                📖 Pinjam
                                            </button>
                                        @else
                                            <button class="btn-outline flex-1 text-center" disabled>
                                                ❌ Habis
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn-primary flex-1 text-center">
                                            🔑 Login
                                        </a>
                                    @endif

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-span-2 text-center py-10 text-gray-400">
                            📭 Jurnal belum tersedia
                        </div>

                    @endforelse

                </div>

                <!-- PAGINATION -->
                <div class="mt-8">
                    {{ $collections->withQueryString()->links() }}
                </div>

            </div>
        </div>

    </section>

</div>

{{-- ================= MODAL PINJAM ================= --}}
<div id="pinjamModal" class="modal-overlay">
    <div class="modal-container p-6">

        <h2 class="text-xl font-bold text-indigo-300 mb-4">
            Form Peminjaman Jurnal
        </h2>

        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf

            <input type="hidden" name="collection_id" id="collection_id">

            <div class="mb-3">
                <label class="text-xs text-gray-400">Judul Jurnal</label>
                <input type="text" id="book_title"
                       class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700"
                       readonly>
            </div>

            <div class="mb-3">
                <label class="text-xs text-gray-400">Tanggal Pinjam</label>
                <input type="date" name="borrow_date" id="borrow_date"
                       class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700"
                       required>
            </div>

            <div class="mb-3">
                <label class="text-xs text-gray-400">Tanggal Kembali</label>
                <input type="date" name="return_date" id="return_date"
                       class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700"
                       required>
            </div>

            <div class="flex gap-2">
                <button type="button"
                        onclick="closeModal()"
                        class="w-full py-2 rounded bg-gray-700 text-white">
                    Batal
                </button>

                <button type="submit"
                        id="submitPinjamBtn"
                        class="w-full py-2 rounded bg-indigo-600 text-white font-semibold">
                    Pinjam
                </button>
            </div>

        </form>

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
    modal.classList.add('active');

    document.getElementById('collection_id').value = id;
    document.getElementById('book_title').value = title;

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const borrowInput = document.getElementById('borrow_date');
    const returnInput = document.getElementById('return_date');

    // Reset value
    borrowInput.value = '';
    returnInput.value = '';

    // Set borrow date = hari ini
    borrowInput.min = formatDate(today);
    borrowInput.value = formatDate(today);

    const minReturn = new Date(today);
    minReturn.setDate(minReturn.getDate() + 1);

    // ✅ MAKSIMAL 3 HARI
    const maxReturn = new Date(today);
    maxReturn.setDate(maxReturn.getDate() + 3);

    returnInput.min = formatDate(minReturn);
    returnInput.max = formatDate(maxReturn);
    returnInput.value = formatDate(minReturn);
}

// ================= CLOSE MODAL =================
function closeModal() {
    const modal = document.getElementById('pinjamModal');
    modal.classList.remove('active');

    // Reset form
    document.getElementById('pinjamForm').reset();

    // Enable submit button
    const submitBtn = document.getElementById('submitPinjamBtn');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Pinjam';
    }
}

// Klik luar modal untuk menutup
document.addEventListener('click', function(e) {
    const modal = document.getElementById('pinjamModal');
    if (e.target === modal) {
        closeModal();
    }
});

// ================= UPDATE RETURN DINAMIS =================
document.addEventListener('change', function(e) {
    if (e.target.id === 'borrow_date') {
        const borrow = new Date(e.target.value);
        borrow.setHours(0, 0, 0, 0);

        const returnInput = document.getElementById('return_date');
        const minReturn = new Date(borrow);
        minReturn.setDate(minReturn.getDate() + 1);

        // ✅ MAKSIMAL 3 HARI
        const maxReturn = new Date(borrow);
        maxReturn.setDate(maxReturn.getDate() + 3);

        returnInput.min = formatDate(minReturn);
        returnInput.max = formatDate(maxReturn);

        const currentReturn = new Date(returnInput.value);
        if (currentReturn < minReturn || currentReturn > maxReturn) {
            returnInput.value = formatDate(minReturn);
        }
    }
});

// ================= VALIDASI SUBMIT =================
document.addEventListener('submit', function(e) {
    if (e.target.id === 'pinjamForm') {
        e.preventDefault();

        const borrow = new Date(document.getElementById('borrow_date').value);
        const ret = new Date(document.getElementById('return_date').value);

        borrow.setHours(0, 0, 0, 0);
        ret.setHours(0, 0, 0, 0);

        const diff = (ret - borrow) / (1000 * 60 * 60 * 24);

        if (diff < 1) {
            alert('Minimal peminjaman 1 hari');
            return;
        }

        // ✅ CEK MAKSIMAL 3 HARI
        if (diff > 3) {
            alert('Maksimal peminjaman hanya 3 hari');
            return;
        }

        const btn = document.getElementById('submitPinjamBtn');
        if (btn) {
            btn.innerText = 'Memproses...';
            btn.disabled = true;
        }

        e.target.submit();
    }
});

// ============================================
// NOTIFICATION AUTO CLOSE
// ============================================
setTimeout(function() {
    const notif = document.getElementById('notif');
    if (notif) {
        notif.classList.add('show');
        setTimeout(function() {
            notif.style.transform = 'translateX(120%)';
        }, 4000);
    }
}, 100);

console.log('📚 Jurnal page loaded (Maksimal pinjam 3 hari)');

</script>
@endpush




