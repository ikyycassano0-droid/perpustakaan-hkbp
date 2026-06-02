{{-- resources/views/user/page/Layanan/pinbal.blade.php --}}
@extends('user.component.master')

@section('title', 'Sistem Pinbal Akademik - AKPER HKBP Balige')

@push('styles')
<style>
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

    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
    }

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

    .stat-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        padding: 1.25rem;
        text-align: center;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.3);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

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

    .table-container {
        overflow-x: auto;
        border-radius: 1rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        text-align: left;
        padding: 1rem 1rem;
        background: rgba(99, 102, 241, 0.15);
        color: #c7d2fe;
        font-weight: 600;
        font-size: 0.85rem;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }

    .data-table td {
        padding: 1rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .data-table tr:hover {
        background: rgba(99, 102, 241, 0.08);
    }

    .book-image {
        width: 50px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }

    .book-image:hover {
        transform: scale(1.1);
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.5);
    }

    .status-approved {
        background: rgba(99, 102, 241, 0.2);
        color: #a5b4fc;
        border: 1px solid rgba(99, 102, 241, 0.5);
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.5);
    }

    .status-returned {
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.5);
    }

    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.85rem;
    }

    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
    }

    .btn-outline {
        background: transparent;
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.85rem;
    }

    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

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

    .membership-active {
        background: linear-gradient(135deg, #10b981, #059669);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
    }

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

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        z-index: 9998;
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal-overlay.show {
        display: flex;
        opacity: 1;
    }

    .modal-container {
        width: 90%;
        max-width: 500px;
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 1.5rem;
        padding: 1.5rem;
        transform: scale(0.9);
        transition: transform 0.3s ease;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .modal-overlay.show .modal-container {
        transform: scale(1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        background: linear-gradient(135deg, #ffffff, #c7d2fe);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    .modal-close {
        background: rgba(99, 102, 241, 0.2);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #c7d2fe;
    }

    .modal-close:hover {
        background: rgba(99, 102, 241, 0.4);
        transform: scale(1.1);
    }

    .form-group {
        margin-bottom: 1.25rem;
        position: relative;
    }

    .form-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #a5b4fc;
        margin-bottom: 0.5rem;
    }

    .form-input-modal {
        width: 100%;
        padding: 10px 14px;
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 12px;
        color: white;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .form-input-modal:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
    }

    .form-input-modal::placeholder {
        color: #64748b;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .autocomplete-items {
        position: absolute;
        z-index: 1000;
        width: 100%;
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 12px;
        max-height: 250px;
        overflow-y: auto;
        margin-top: 4px;
    }

    .autocomplete-item {
        padding: 10px 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid rgba(99, 102, 241, 0.2);
    }

    .autocomplete-item-title {
        font-size: 0.85rem;
        font-weight: 500;
        color: #c7d2fe;
    }

    .autocomplete-item-author {
        font-size: 0.7rem;
        color: #94a3b8;
        margin-top: 2px;
    }

    .btn-modal {
        width: 100%;
        padding: 12px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        margin-top: 0.5rem;
    }

    .btn-modal-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
    }

    .btn-modal-primary:hover {
        transform: scale(1.02);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
    }

    .btn-modal-secondary {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.5);
        color: #c7d2fe;
        margin-top: 0.75rem;
    }

    .btn-modal-secondary:hover {
        background: rgba(99, 102, 241, 0.2);
    }

    .section {
        margin-top: 40px;
    }

    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(99, 102, 241, 0.3);
        border-radius: 50%;
        border-top-color: #6366f1;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
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

    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📚 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
    Sistem Pinbal <br>
    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">Akademik</span>
</h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Kelola riwayat peminjaman buku perpustakaan Anda. Pantau batas waktu pengembalian.
        </p>
    </section>

    <section class="section max-w-6xl mx-auto px-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">📖</div>
                <div class="stat-number" id="aktifDipinjam">0</div>
                <div class="text-xs text-gray-400 mt-1">Aktif Dipinjam</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">⏰</div>
                <div class="stat-number" id="mendekatiDeadline">0</div>
                <div class="text-xs text-gray-400 mt-1">Mendekati Deadline</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">📚</div>
                <div class="stat-number" id="totalRiwayat">0</div>
                <div class="text-xs text-gray-400 mt-1">Total Riwayat</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">🎓</div>
                <div class="membership-active mx-auto" style="width: fit-content;">
                    {{ is_logged_in() ? 'AKTIF' : 'GUEST' }}
                </div>
                <div class="text-xs text-gray-400 mt-2">Status Keanggotaan</div>
            </div>
        </div>
    </section>

    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="mb-6">
                    <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari judul buku...">
                </div>

                <div class="flex flex-wrap gap-3 mb-6">
                    <button class="btn-primary" data-filter="all">Semua</button>
                    <button class="btn-outline" data-filter="PENDING">Menunggu</button>
                    <button class="btn-outline" data-filter="APPROVED">Dipinjam</button>
                    <button class="btn-outline" data-filter="RETURNED">Dikembalikan</button>
                    <button class="btn-outline" data-filter="REJECTED">Ditolak</button>
                </div>

                <!-- MODAL FORM PEMINJAMAN -->
                <div id="pinjamModal" class="modal-overlay">
                    <div class="modal-container">
                        <div class="modal-header">
                            <h2 class="modal-title">📖 Form Peminjaman Buku</h2>
                            <button class="modal-close" onclick="closePinjamModal()">✕</button>
                        </div>

                        <form id="pinjamForm" action="{{ route('user.pinbal.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">📚 Pilih Judul Buku</label>
                                <input type="text" id="judulBukuInput" class="form-input-modal"
                                       placeholder="Ketik judul buku..." autocomplete="off" required>
                                <input type="hidden" id="collection_id" name="collection_id" required>
                                <div id="autocompleteList" class="autocomplete-items" style="display: none;"></div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">📅 Tanggal Pinjam</label>
                                    <input type="date" id="tglPinjam" name="borrow_date" class="form-input-modal" required min="" onfocus="this.min=new Date().toISOString().split('T')[0]">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">📅 Tanggal Kembali</label>
                                   <input type="date" id="tglKembali" name="return_date" class="form-input-modal" required min="" max="">
                                </div>
                            </div>

                            <div class="form-group">
                                <p class="text-xs text-gray-400">
                                    ⚠️ *Peminjaman akan diproses oleh petugas perpustakaan.
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    📌 *Masa pinjam maksimal 3 hari.
                                </p>
                            </div>

                            <button type="submit" class="btn-modal btn-modal-primary">
                                ✅ Ajukan Peminjaman
                            </button>
                            <button type="button" class="btn-modal btn-modal-secondary" onclick="closePinjamModal()">
                                Batal
                            </button>
                        </form>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>📖 BUKU & KATALOG</th>
                                <th>📅 TANGGAL PINJAM</th>
                                <th>⏰ BATAS KEMBALI</th>
                                <th>📌 STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-400">
                                    <div class="loading-spinner mx-auto mb-2"></div>
                                    Memuat data...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-400" id="paginationInfo">
                        Menampilkan 0 dari 0 entri
                    </div>
                    <div class="flex gap-2" id="paginationButtons">
                        <button class="pagination-btn" id="prevPage">◀ Sebelumnya</button>
                        <button class="pagination-btn" id="nextPage">Berikutnya ▶</button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="section max-w-6xl mx-auto px-5 mb-16">
        <div class="flex flex-wrap justify-center gap-4">
            <button id="pinjamBtn" class="btn-primary px-8 py-3 fade-up">
                📖 Pinjam Buku
            </button>
        </div>
    </section>

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
</div>
@endsection

@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN PINBAL
// ============================================

// Data dari server
let loanData = @json($peminjaman->items() ?? []);
let currentPage = 1;
let currentFilter = 'all';
let searchQuery = '';

console.log('Loan Data:', loanData);

// Fungsi aman untuk mengambil string
function safeString(str) {
    if (str === null || str === undefined) return '';
    if (typeof str === 'string') return str;
    if (typeof str === 'number') return str.toString();
    if (Array.isArray(str)) return str.join(', ');
    return String(str);
}

// Escape HTML
function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Fungsi untuk mengambil data buku dari order
function getBookFromOrder(order) {
    if (!order) return null;
    if (order.details && order.details.length > 0 && order.details[0].collection) {
        return order.details[0].collection;
    }
    if (order.collection) {
        return order.collection;
    }
    return null;
}

// Status badge
function getStatusBadge(status) {
    var map = {
        'PENDING': { class: 'status-pending', icon: '⏳', text: 'MENUNGGU KONFIRMASI' },
        'APPROVED': { class: 'status-approved', icon: '📘', text: 'DIPINJAM' },
        'REJECTED': { class: 'status-rejected', icon: '❌', text: 'DITOLAK' },
        'RETURNED': { class: 'status-returned', icon: '✅', text: 'DIKEMBALIKAN' }
    };
    return map[status] || { class: 'status-pending', icon: '⏳', text: 'MENUNGGU' };
}

// Format tanggal
function formatDate(dateStr) {
    if (!dateStr) return '-';
    try {
        var date = new Date(dateStr);
        if (isNaN(date.getTime())) return '-';
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    } catch(e) {
        return '-';
    }
}

// Hitung sisa hari
function getRemainingDays(returnDate) {
    if (!returnDate) return null;
    try {
        var today = new Date();
        today.setHours(0, 0, 0, 0);
        var end = new Date(returnDate);
        if (isNaN(end.getTime())) return null;
        end.setHours(0, 0, 0, 0);
        var diff = Math.ceil((end - today) / (1000 * 60 * 60 * 24));
        return diff;
    } catch(e) {
        return null;
    }
}

// Update statistik
function updateStats(data) {
    var aktif = 0;
    var mendekati = 0;
    var total = data.length;

    for (var i = 0; i < data.length; i++) {
        if (data[i].status === 'APPROVED') {
            aktif++;
            var dueDate = data[i].due_date || data[i].tanggal_kembali;
            var days = getRemainingDays(dueDate);
            if (days !== null && days <= 3 && days >= 0) {
                mendekati++;
            }
        }
    }

    document.getElementById('aktifDipinjam').innerHTML = aktif.toString().padStart(2, '0');
    document.getElementById('mendekatiDeadline').innerHTML = mendekati.toString().padStart(2, '0');
    document.getElementById('totalRiwayat').innerHTML = total;
}

// Render tabel
function renderTable() {
    var filtered = [];
    for (var i = 0; i < loanData.length; i++) {
        filtered.push(loanData[i]);
    }

    // Search filter
    if (searchQuery) {
        var temp = [];
        for (var i = 0; i < filtered.length; i++) {
            var book = getBookFromOrder(filtered[i]);
            var title = book ? safeString(book.title).toLowerCase() : '';
            if (title.includes(searchQuery.toLowerCase())) {
                temp.push(filtered[i]);
            }
        }
        filtered = temp;
    }

    // Status filter
    if (currentFilter !== 'all') {
        var temp = [];
        for (var i = 0; i < filtered.length; i++) {
            if (filtered[i].status === currentFilter) {
                temp.push(filtered[i]);
            }
        }
        filtered = temp;
    }

    // Update stats
    updateStats(filtered);

    // Pagination
    var perPage = 5;
    var totalPages = Math.ceil(filtered.length / perPage);
    var start = (currentPage - 1) * perPage;
    var end = start + perPage;
    var currentData = [];
    for (var i = start; i < end && i < filtered.length; i++) {
        currentData.push(filtered[i]);
    }

    // Update info
    var paginationInfo = document.getElementById('paginationInfo');
    if (paginationInfo) {
        paginationInfo.innerHTML = filtered.length > 0 ?
            'Menampilkan ' + (start + 1) + ' - ' + Math.min(end, filtered.length) + ' dari ' + filtered.length + ' entri' :
            'Tidak ada data';
    }

    // Render table
    var tbody = document.getElementById('tableBody');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (currentData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center py-8 text-gray-400">📚 Belum ada riwayat peminjaman</td></tr>';
        return;
    }

    for (var i = 0; i < currentData.length; i++) {
        var item = currentData[i];
        var book = getBookFromOrder(item);
        var status = getStatusBadge(item.status);

        var borrowDate = item.borrow_date || item.tanggal_pinjam || item.created_at;
        var dueDate = item.due_date || item.tanggal_kembali;

        var remaining = null;
        if (dueDate && item.status === 'APPROVED') {
            remaining = getRemainingDays(dueDate);
        }

        var bookTitle = 'Judul tidak tersedia';
        var bookAuthor = 'Penulis tidak diketahui';
        var coverImage = null;

        if (book) {
            bookTitle = safeString(book.title) || 'Judul tidak tersedia';
            var authorData = book.author;
            if (authorData) {
                if (typeof authorData === 'string') {
                    bookAuthor = authorData;
                } else if (Array.isArray(authorData)) {
                    bookAuthor = authorData.join(', ');
                }
            }
            coverImage = book.cover_image ? '/storage/' + safeString(book.cover_image) : null;
        }

        var row = tbody.insertRow();

        // Kolom Buku
        row.insertCell(0).innerHTML = '<div class="flex items-center gap-3">' +
            '<img src="' + (coverImage || 'https://placehold.co/100x130/1e293b/6366f1?text=📖') + '" class="book-image" onerror="this.src=\'https://placehold.co/100x130/1e293b/6366f1?text=📖\'">' +
            '<div>' +
                '<div class="font-semibold">' + escapeHtml(bookTitle) + '</div>' +
                '<div class="text-xs text-gray-500 mt-1">✍️ ' + escapeHtml(bookAuthor) + '</div>' +
            '</div>' +
        '</div>';

        // Kolom Tanggal Pinjam
        row.insertCell(1).innerHTML = formatDate(borrowDate);

        // Kolom Batas Kembali
        if (item.status === 'APPROVED' && dueDate) {
            var text = '', cls = '';
            if (remaining === 0) { text = '⚠️ Hari Terakhir!'; cls = 'text-red-400'; }
            else if (remaining < 0) { text = '❌ Terlambat ' + Math.abs(remaining) + ' hari'; cls = 'text-red-400'; }
            else if (remaining <= 3) { text = '⚠️ Tersisa ' + remaining + ' Hari'; cls = 'text-yellow-400'; }
            else { text = '📚 Tersisa ' + remaining + ' Hari'; cls = 'text-green-400'; }
            row.insertCell(2).innerHTML = formatDate(dueDate) + '<br><span class="text-xs ' + cls + '">' + text + '</span>';
        } else if (item.status === 'APPROVED' && !dueDate) {
            row.insertCell(2).innerHTML = '<span class="text-xs text-gray-400">Tanggal belum ditentukan</span>';
        } else {
            row.insertCell(2).innerHTML = formatDate(dueDate) || '<span class="text-xs text-gray-400">Menunggu konfirmasi</span>';
        }

        // Kolom Status
        row.insertCell(3).innerHTML = '<span class="status-badge ' + status.class + '">' + status.icon + ' ' + status.text + '</span>';
    }

    // Update pagination buttons
    var prevBtn = document.getElementById('prevPage');
    var nextBtn = document.getElementById('nextPage');
    if (prevBtn) prevBtn.disabled = currentPage === 1;
    if (nextBtn) nextBtn.disabled = currentPage === totalPages || totalPages === 0;
}

// Event listeners
var filterBtns = document.querySelectorAll('[data-filter]');
for (var i = 0; i < filterBtns.length; i++) {
    filterBtns[i].addEventListener('click', function(e) {
        var filter = e.target.getAttribute('data-filter');
        currentFilter = filter;
        currentPage = 1;

        var allBtns = document.querySelectorAll('[data-filter]');
        for (var j = 0; j < allBtns.length; j++) {
            if (allBtns[j].getAttribute('data-filter') === filter) {
                allBtns[j].classList.remove('btn-outline');
                allBtns[j].classList.add('btn-primary');
            } else {
                allBtns[j].classList.remove('btn-primary');
                allBtns[j].classList.add('btn-outline');
            }
        }
        renderTable();
    });
}

document.getElementById('searchInput').addEventListener('input', function(e) {
    searchQuery = e.target.value;
    currentPage = 1;
    renderTable();
});

document.getElementById('prevPage').addEventListener('click', function() {
    if (currentPage > 1) { currentPage--; renderTable(); }
});

document.getElementById('nextPage').addEventListener('click', function() {
    currentPage++; renderTable();
});

// AUTOCOMPLETE
var searchTimeout;
var availableBooks = @json($availableBooks ?? []);

document.getElementById('judulBukuInput').addEventListener('input', function() {
    var query = this.value.trim();
    var list = document.getElementById('autocompleteList');

    if (query.length < 2) {
        list.style.display = 'none';
        return;
    }

    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        var filtered = [];
        for (var i = 0; i < availableBooks.length; i++) {
            var title = availableBooks[i].title ? safeString(availableBooks[i].title).toLowerCase() : '';
            if (title.includes(query.toLowerCase())) {
                filtered.push(availableBooks[i]);
            }
        }

        if (filtered.length > 0) {
            var html = '';
            for (var i = 0; i < filtered.length; i++) {
                var b = filtered[i];
                var title = safeString(b.title);
                var author = safeString(b.author || 'Penulis tidak diketahui');
                html += '<div class="autocomplete-item" onclick="selectBook(' + b.id + ', \'' + title.replace(/'/g, "\\'") + '\')">' +
                    '<div class="autocomplete-item-title">📖 ' + escapeHtml(title) + '</div>' +
                    '<div class="autocomplete-item-author">✍️ ' + escapeHtml(author) + '</div>' +
                '</div>';
            }
            list.innerHTML = html;
            list.style.display = 'block';
        } else {
            list.innerHTML = '<div class="autocomplete-item"><div class="autocomplete-item-title text-gray-400">📭 Buku tidak ditemukan</div></div>';
            list.style.display = 'block';
        }
    }, 300);
});

function selectBook(id, title) {
    document.getElementById('judulBukuInput').value = title;
    document.getElementById('collection_id').value = id;
    document.getElementById('autocompleteList').style.display = 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#judulBukuInput') && !e.target.closest('#autocompleteList')) {
        document.getElementById('autocompleteList').style.display = 'none';
    }
});

// Form validation
document.getElementById('pinjamForm').addEventListener('submit', function(e) {
    var collectionId = document.getElementById('collection_id').value;
    if (!collectionId) {
        e.preventDefault();
        alert('❌ Silakan pilih buku!');
        return;
    }

    var pinjam = new Date(document.getElementById('tglPinjam').value);
    var kembali = new Date(document.getElementById('tglKembali').value);
    var today = new Date(); today.setHours(0,0,0,0);
    pinjam.setHours(0,0,0,0);
    kembali.setHours(0,0,0,0);

    if (pinjam < today) {
        e.preventDefault();
        alert('❌ Tanggal pinjam tidak boleh kurang dari hari ini!');
        return;
    }

    if (kembali <= pinjam) {
        e.preventDefault();
        alert('❌ Tanggal kembali harus setelah tanggal pinjam!');
        return;
    }

    var diff = (kembali - pinjam) / (1000 * 60 * 60 * 24);
    if (diff > 3) {
        e.preventDefault();
        alert('❌ Maksimal peminjaman 3 hari!');
        return;
    }
});

// Modal functions
function openPinjamModal() {
    var modal = document.getElementById('pinjamModal');
    modal.classList.add('show');

    var today = new Date();
    var todayStr = today.toISOString().split('T')[0];
    
    var tglPinjam = document.getElementById('tglPinjam');
    tglPinjam.value = todayStr;
    tglPinjam.min = todayStr;
    
    var tglKembali = document.getElementById('tglKembali');
    
    // Set max return = 3 hari dari sekarang
    var maxReturn = new Date(today);
    maxReturn.setDate(maxReturn.getDate() + 3);
    var maxStr = maxReturn.toISOString().split('T')[0];
    
    tglKembali.value = maxStr;
    tglKembali.min = todayStr;
    tglKembali.max = maxStr;

    document.getElementById('judulBukuInput').value = '';
    document.getElementById('collection_id').value = '';
}

function closePinjamModal() {
    var modal = document.getElementById('pinjamModal');
    modal.classList.remove('show');
    document.getElementById('pinjamForm').reset();
    document.getElementById('autocompleteList').style.display = 'none';
}

function showNotification(message, type) {
    if (typeof type === 'undefined') type = 'success';
    var notif = document.createElement('div');
    notif.className = 'notification';
    var icon = type === 'success' ? '✅' : (type === 'error' ? '❌' : 'ℹ️');
    notif.innerHTML = '<div class="flex items-center gap-2"><span>' + icon + '</span><span>' + message + '</span></div>';
    document.body.appendChild(notif);
    setTimeout(function() { notif.classList.add('show'); }, 10);
    setTimeout(function() {
        notif.classList.remove('show');
        setTimeout(function() { notif.remove(); }, 300);
    }, 3000);
}

document.getElementById('pinjamBtn').addEventListener('click', openPinjamModal);

// Initialize
if (loanData.length > 0) {
    console.log('Total orders:', loanData.length);
    for (var i = 0; i < loanData.length; i++) {
        console.log('Order ' + (i+1) + ':', {
            id: loanData[i].id,
            status: loanData[i].status,
            borrow_date: loanData[i].borrow_date,
            due_date: loanData[i].due_date,
            tanggal_pinjam: loanData[i].tanggal_pinjam,
            tanggal_kembali: loanData[i].tanggal_kembali,
        });
    }
    renderTable();
} else {
    document.getElementById('tableBody').innerHTML = '<tr><td colspan="4" class="text-center py-8 text-gray-400">📚 Belum ada riwayat peminjaman</td><\/tr>';
}

console.log('Halaman Pinbal siap!');
</script>
@endpush

@push('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush




