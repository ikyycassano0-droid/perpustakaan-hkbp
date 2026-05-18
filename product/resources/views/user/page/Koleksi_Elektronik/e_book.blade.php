@extends('user.component.master')

@section('title', 'Koleksi E-Book - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS HALAMAN E-BOOK (RAPI)
    ============================================ */

    /* Base & Container */
    .main-content {
        min-height: 100vh;
    }

    /* Glass & efek */
    .glass-card {
        background: rgba(30, 41, 59, 0.5);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(99, 102, 241, 0.25);
    }

    .glow-text {
        text-shadow: 0 0 12px rgba(99, 102, 241, 0.7);
    }

    .depth-2 {
        transform: translateZ(24px);
    }

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

    /* ======================
       SEARCH BAR
    ====================== */
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

    /* ======================
       SIDEBAR - RAPIH
    ====================== */
    .sidebar-menu {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        overflow: hidden;
    }

    .sidebar-item {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        transition: all 0.3s ease;
        cursor: pointer;
        color: #cbd5e1;
        font-size: 0.85rem;
        user-select: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sidebar-item:last-child {
        border-bottom: none;
    }

    .sidebar-item:hover {
        background: rgba(99, 102, 241, 0.15);
        color: white;
        transform: translateX(4px);
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
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    /* ======================
       CARD E-BOOK - RAPIH
    ====================== */
    .ebook-card {
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

    .ebook-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }

    .ebook-cover {
        height: 200px;
        position: relative;
        background: #1e293b;
        overflow: hidden;
    }

    .ebook-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .ebook-card:hover .ebook-cover img {
        transform: scale(1.05);
    }

    .ebook-format {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(4px);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        color: white;
        z-index: 10;
        letter-spacing: 0.5px;
    }

    .cover-fallback {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1e293b 0%, #312e81 50%, #1e1b4b 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
    }

    /* ======================
       BUTTON - KONSISTEN
    ====================== */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 8px 12px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        gap: 4px;
    }

    .btn-primary:hover {
        transform: scale(1.02);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-outline {
        background: transparent;
        padding: 8px 12px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        gap: 4px;
    }

    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
        color: #c7d2fe;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* ======================
       PAGINATION - RAPI
    ====================== */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        padding: 8px 12px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 10px;
        color: #c7d2fe;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .pagination .page-link:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
        transform: translateY(-2px);
    }

    .pagination .active .page-link {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
    }

    .pagination .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* ======================
       NOTIFICATION
    ====================== */
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
        z-index: 9999;
        transform: translateX(120%);
        transition: transform 0.3s ease;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    }

    .notification.show {
        transform: translateX(0);
    }

    /* ======================
       ANIMASI
    ====================== */
    .fade-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.7s ease;
    }

    .fade-up.show {
        opacity: 1;
        transform: translateY(0);
    }

    .section {
        margin-top: 40px;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ======================
       RESPONSIVE FIX
    ====================== */
    @media (max-width: 768px) {
        .sidebar-menu {
            margin-bottom: 20px;
        }

        .ebook-cover {
            height: 180px;
        }

        .notification {
            right: 15px;
            left: 15px;
            bottom: 20px;
        }

        .neon-inner {
            padding: 1.25rem;
        }

        .btn-primary, .btn-outline {
            padding: 6px 10px;
            font-size: 0.7rem;
        }

        .hero-title {
            font-size: 2.5rem !important;
        }
    }

    /* Additional improvements */
    .badge-category {
        background: rgba(99, 102, 241, 0.2);
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.7rem;
    }

    .card-footer-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: auto;
    }

    .text-truncate-custom {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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

    {{-- HERO SECTION --}}
    <section class="pt-28 pb-8 text-center px-5">

        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                📚 AKPER HKBP BALIGE
            </span>
        </div>

        <h1 class="hero-title text-4xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
            Koleksi
            <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">
                E-Book
            </span>
        </h1>

        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up px-3">
            Akses ribuan buku digital, jurnal elektronik, dan literatur keperawatan modern.
        </p>

    </section>

    {{-- MAIN CONTENT --}}
    <section class="section max-w-7xl mx-auto px-5 pb-16">

        <div class="neon-border fade-up">

            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    {{-- SIDEBAR KIRI --}}
                    <div class="lg:col-span-1">

                        {{-- KATEGORI --}}
                        <div class="sidebar-menu">

                            <div class="sidebar-title">
                                📂 Kategori E-Book
                            </div>

                            <div class="sidebar-item active" data-category="all">
                                📚 Semua E-Book
                            </div>

                            @php
                                $categories = $ebooks->getCollection()
                                    ->pluck('category')
                                    ->filter()
                                    ->unique('id');
                            @endphp

                            @forelse($categories as $cat)

                                <div class="sidebar-item" data-category="{{ strtolower(str_replace(' ', '-', $cat->name)) }}">
                                    📁 {{ $cat->name }}
                                </div>

                            @empty

                                <div class="sidebar-item">👩‍⚕️ Keperawatan Dasar</div>
                                <div class="sidebar-item">🏥 Medikal Bedah</div>
                                <div class="sidebar-item">👶 Keperawatan Anak</div>

                            @endforelse

                        </div>

                        {{-- FORMAT FILE --}}
                        <div class="sidebar-menu mt-6">

                            <div class="sidebar-title">
                                📄 Format File
                            </div>

                            <div class="sidebar-item" data-format="pdf">📕 PDF</div>
                            <div class="sidebar-item" data-format="epub">📗 EPUB</div>
                            <div class="sidebar-item" data-format="doc">📘 DOC</div>

                        </div>

                    </div>

                    {{-- KONTEN UTAMA --}}
                    <div class="lg:col-span-3">

                        {{-- SEARCH --}}
                        <div class="mb-8">

                            <form method="GET" action="{{ url()->current() }}">

                                <input type="text"
                                       name="search"
                                       value="{{ request('search') }}"
                                       class="search-input"
                                       placeholder="🔍 Cari judul e-book, penulis, atau kata kunci...">

                            </form>

                        </div>

                        {{-- FEATURED (POPULER) --}}
                        @if($ebooks->count() > 0)
                        <div class="mb-10">

                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-indigo-200 font-semibold text-lg">✨ E-Book Populer</h3>
                                <span class="text-xs text-gray-400 bg-gray-800/30 px-2 py-1 rounded-full">⭐ Pilihan</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                @foreach($ebooks->take(2) as $featured)

                                    <div class="ebook-card fade-up">

                                        <div class="ebook-cover">

                                            @if($featured->cover_image && file_exists(public_path('storage/' . $featured->cover_image)))

                                                <img src="{{ asset('storage/' . $featured->cover_image) }}"
                                                     alt="{{ $featured->title }}"
                                                     loading="lazy">

                                            @else

                                                <div class="cover-fallback">📖</div>

                                            @endif

                                            <span class="ebook-format">📕 {{ strtoupper($featured->format ?? 'PDF') }}</span>

                                        </div>

                                        <div class="p-4 flex flex-col flex-1">

                                            <div class="flex items-center justify-between mb-2">

                                                <span class="text-xs text-indigo-300 bg-indigo-500/20 px-2 py-0.5 rounded-full">
                                                    ⭐ 4.8
                                                </span>

                                                <span class="text-xs text-gray-500">
                                                    📥 {{ $featured->views ?? 0 }} views
                                                </span>

                                            </div>

                                            <h3 class="font-semibold text-indigo-200 mb-1 text-base line-clamp-2">
                                                {{ Str::limit($featured->title, 55) }}
                                            </h3>

                                            <p class="text-xs text-gray-400 mb-4">
                                                ✍️ {{ $featured->author ?? 'Administrator' }}
                                            </p>

                                            <div class="card-footer-buttons">

                                                <a href="{{ asset('storage/' . $featured->file_url) }}"
                                                   target="_blank"
                                                   class="btn-primary flex-1">📖 Baca</a>

                                                <a href="{{ route('final_project.detail', $featured->id) }}"
                                                   class="btn-outline">👁️</a>

                                                <a href="{{ asset('storage/' . $featured->file_url) }}"
                                                   download
                                                   class="btn-outline">⬇️</a>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>
                        @endif

                        {{-- SEMUA KOLEKSI --}}
                        <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                            <h3 class="text-indigo-200 font-semibold text-lg">📚 Semua Koleksi E-Book</h3>
                            <span class="text-sm text-gray-400 bg-gray-800/30 px-3 py-1 rounded-full">
                                {{ $ebooks->total() }} e-book tersedia
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                            @forelse($ebooks as $item)

                                <div class="ebook-card fade-up">

                                    <div class="ebook-cover">

                                        @if($item->cover_image && file_exists(public_path('storage/' . $item->cover_image)))

                                            <img src="{{ asset('storage/' . $item->cover_image) }}"
                                                 alt="{{ $item->title }}"
                                                 loading="lazy"
                                                 onerror="this.style.display='none'; this.parentElement.querySelector('.cover-fallback').style.display='flex';">

                                            <div class="cover-fallback" style="display:none;">📖</div>

                                        @else

                                            <div class="cover-fallback">📖</div>

                                        @endif

                                        <span class="ebook-format">📕 {{ strtoupper($item->format ?? 'PDF') }}</span>

                                    </div>

                                    <div class="p-4 flex flex-col flex-1">

                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs text-indigo-300/80 badge-category">
                                                {{ $item->category->name ?? 'E-Book' }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                📅 {{ $item->publication_year ?? $item->year ?? date('Y') }}
                                            </span>
                                        </div>

                                        <h3 class="font-semibold text-indigo-200 mb-1 text-sm line-clamp-2">
                                            {{ Str::limit($item->title, 55) }}
                                        </h3>

                                        <p class="text-xs text-gray-400 mb-2">
                                            ✍️ {{ $item->author ?? 'Administrator' }}
                                        </p>

                                        <p class="text-xs text-gray-500 mb-4">
                                            📄 {{ $item->pages ?? '-' }} halaman
                                        </p>

                                        <div class="card-footer-buttons">

                                            @if($item->file_url)

                                                <a href="{{ asset('storage/' . $item->file_url) }}"
                                                   target="_blank"
                                                   class="btn-primary flex-1">📖 Baca</a>

                                                <a href="{{ route('final_project.detail', $item->id) }}"
                                                   class="btn-outline flex-1">👁️ Detail</a>

                                                <a href="{{ asset('storage/' . $item->file_url) }}"
                                                   download
                                                   class="btn-outline">⬇️</a>

                                            @else

                                                <span class="text-xs text-gray-500 w-full text-center py-1">
                                                    File tidak tersedia
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="col-span-full text-center py-12">

                                    <div class="text-6xl mb-4">📭</div>

                                    <p class="text-gray-400 text-lg">Tidak ada e-book ditemukan</p>

                                    <p class="text-sm text-gray-500 mt-2">
                                        Silakan coba kata kunci lain atau reset filter
                                    </p>

                                </div>

                            @endforelse

                        </div>

                        {{-- PAGINATION --}}
                        <div class="mt-10">
                            {{ $ebooks->links() }}
                        </div>

                    </div>

                </div>

            </div>

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
// ==============================
// FADE-UP ANIMATION
// ==============================
function initAnimation() {
    const elements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    elements.forEach(el => observer.observe(el));
}

// ==============================
// IMAGE FALLBACK
// ==============================
function checkImages() {
    document.querySelectorAll('.ebook-cover img').forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const fallback = this.parentElement.querySelector('.cover-fallback');
            if (fallback) fallback.style.display = 'flex';
        });
    });
}

// ==============================
// FILTER CATEGORY (UI only)
// ==============================
function initCategoryFilter() {
    const categoryItems = document.querySelectorAll('[data-category]');
    categoryItems.forEach(item => {
        item.addEventListener('click', function() {
            categoryItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

// ==============================
// FILTER FORMAT (UI only)
// ==============================
function initFormatFilter() {
    const formatItems = document.querySelectorAll('[data-format]');
    formatItems.forEach(item => {
        item.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });
}

// ==============================
// NOTIFICATION
// ==============================
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <span>${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}</span>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ==============================
// INIT
// ==============================
document.addEventListener('DOMContentLoaded', function() {
    initAnimation();
    checkImages();
    initCategoryFilter();
    initFormatFilter();
});

window.showNotification = showNotification;
</script>
@endpush
