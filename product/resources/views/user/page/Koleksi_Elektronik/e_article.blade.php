@extends('user.component.master')

@section('title', 'Koleksi E-Article - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN KOLEKSI E-ARTICLE
       (Melengkapi style dari master)
    ============================================ */

    /* Glass & efek dasar */
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

    /* Neon border wrapper */
    .neon-border {
        position: relative;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(99,102,241,0.28), rgba(139,92,246,0.15));
        transition: all .35s ease;
    }

    .neon-border:hover {
        box-shadow: 0 0 35px rgba(99,102,241,0.18);
    }

    .neon-inner {
        background: rgba(15, 23, 42, 0.78);
        backdrop-filter: blur(18px);
        border-radius: 26px;
        padding: 2rem;
        border: 1px solid rgba(255,255,255,0.06);
    }

    /* Search input */
    .search-input {
        width: 100%;
        padding: 14px 20px;
        background: rgba(15, 23, 42, 0.65);
        border: 1px solid rgba(99, 102, 241, 0.28);
        border-radius: 999px;
        color: white;
        font-size: .9rem;
        transition: .3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 20px rgba(99,102,241,.25);
    }

    .search-input::placeholder {
        color: #64748b;
    }

    /* Sidebar Menu */
    .sidebar-menu {
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(99,102,241,.25);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .sidebar-title {
        padding: 14px 18px;
        color: #c7d2fe;
        font-weight: 700;
        border-bottom: 1px solid rgba(99,102,241,.25);
    }

    .sidebar-item {
        padding: 13px 18px;
        color: #cbd5e1;
        border-bottom: 1px solid rgba(255,255,255,.04);
        transition: .3s ease;
        cursor: pointer;
        font-size: .85rem;
    }

    .sidebar-item:last-child {
        border-bottom: none;
    }

    .sidebar-item:hover {
        background: rgba(99,102,241,.14);
        color: white;
        padding-left: 24px;
    }

    .sidebar-item.active {
        background: linear-gradient(135deg, rgba(99,102,241,.18), rgba(139,92,246,.08));
        border-left: 3px solid #6366f1;
        color: #c7d2fe;
    }

    /* Kartu E-Article */
    .ebook-card {
        background: rgba(15, 23, 42, 0.68);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all .4s cubic-bezier(.2,.9,.4,1.1);
        border: 1px solid rgba(99,102,241,.24);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .ebook-card:hover {
        transform: translateY(-7px);
        border-color: rgba(99,102,241,.6);
        box-shadow: 0 18px 35px rgba(99,102,241,.18);
    }

    .ebook-cover {
        height: 230px;
        position: relative;
        overflow: hidden;
        background: #1e293b;
    }

    .ebook-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: .5s ease;
    }

    .ebook-card:hover .ebook-cover img {
        transform: scale(1.05);
    }

    .ebook-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(2,6,23,.82), transparent 55%);
    }

    .ebook-format {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: rgba(0,0,0,.72);
        backdrop-filter: blur(4px);
        padding: 5px 10px;
        border-radius: 20px;
        font-size: .68rem;
        font-weight: 700;
        color: white;
        z-index: 5;
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

    /* Mini stat */
    .mini-stat {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .72rem;
        color: #94a3b8;
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 8px 14px;
        border-radius: 999px;
        font-weight: 600;
        transition: .3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: .74rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .3rem;
    }

    .btn-primary:hover {
        transform: scale(1.02);
        box-shadow: 0 0 18px rgba(99,102,241,.35);
        color: white;
    }

    .btn-outline {
        background: transparent;
        padding: 8px 12px;
        border-radius: 999px;
        border: 1px solid rgba(99,102,241,.45);
        color: #c7d2fe;
        font-size: .74rem;
        transition: .3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .3rem;
    }

    .btn-outline:hover {
        background: rgba(99,102,241,.15);
        border-color: #6366f1;
        color: white;
    }

    /* Tooltip wrapper */
    .tooltip-wrapper {
        position: relative;
        display: inline-flex;
    }

    .tooltip-wrapper .tooltip-text {
        visibility: hidden;
        background-color: rgba(0,0,0,0.85);
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 4px 8px;
        position: absolute;
        z-index: 20;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        font-size: 0.7rem;
        opacity: 0;
        transition: opacity 0.2s;
        pointer-events: none;
    }

    .tooltip-wrapper:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* Pagination (laravel built-in) */
    .pagination {
        display: flex;
        justify-content: center;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        background: rgba(15,23,42,.7);
        border: 1px solid rgba(99,102,241,.25);
        color: #c7d2fe;
        border-radius: .8rem;
        padding: .55rem .9rem;
        transition: .3s ease;
        text-decoration: none;
    }

    .pagination .page-link:hover {
        background: rgba(99,102,241,.15);
        border-color: #6366f1;
    }

    .pagination .active .page-link {
        background: linear-gradient(135deg,#6366f1,#8b5cf6);
        color: white;
        border-color: transparent;
    }

    /* Notification */
    .notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 12px 22px;
        background: rgba(15,23,42,.95);
        border: 1px solid rgba(99,102,241,.4);
        border-radius: 14px;
        color: white;
        z-index: 9999;
        transform: translateX(120%);
        transition: .3s ease;
        backdrop-filter: blur(12px);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .notification.show {
        transform: translateX(0);
    }

    /* Filter badge */
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(99, 102, 241, 0.2);
        border-radius: 30px;
        padding: 4px 12px;
        font-size: 0.7rem;
        color: #a5b4fc;
        border: 1px solid rgba(99,102,241,0.3);
    }

    .reset-filter {
        cursor: pointer;
        transition: all 0.2s;
    }

    .reset-filter:hover {
        color: white;
        background: rgba(99,102,241,0.4);
        border-radius: 30px;
        padding: 0 2px;
    }

    /* Utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .section {
        margin-top: 40px;
    }

    .fade-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .fade-up.show {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .ebook-cover {
            height: 200px;
        }
    }

    @media (max-width: 768px) {
        .neon-inner {
            padding: 1.2rem;
        }
        .ebook-cover {
            height: 180px;
        }
        .sidebar-menu {
            margin-bottom: 1rem;
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

    {{-- HERO SECTION --}}
    <section class="pt-28 pb-10 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                📱 AKPER HKBP BALIGE
            </span>
        </div>

        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
            Koleksi
            <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">
                E-Article
            </span>
        </h1>

        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Akses artikel ilmiah, jurnal elektronik, dan literatur keperawatan modern kapan saja dan di mana saja.
        </p>
    </section>

    {{-- MAIN CONTENT --}}
    <section class="section max-w-7xl mx-auto px-5 pb-16">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    {{-- SIDEBAR FILTER --}}
                    <div class="lg:col-span-1">
                        {{-- Kategori --}}
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Kategori E-Article</div>
                            <div class="sidebar-item active" data-filter="category" data-value="all">📚 Semua E-Article</div>
                            @php
                                // Kumpulkan kategori unik dari koleksi yang ada (dari hasil paginator)
                                $categories = $ebooks->getCollection()->pluck('category')->filter()->unique('id');
                            @endphp
                            @forelse($categories as $cat)
                                <div class="sidebar-item" data-filter="category" data-value="{{ strtolower(str_replace(' ', '-', $cat->name ?? $cat)) }}">
                                    📁 {{ $cat->name ?? $cat }}
                                </div>
                            @empty
                                <div class="sidebar-item" data-filter="category" data-value="jurnal-keperawatan">📄 Jurnal Keperawatan</div>
                                <div class="sidebar-item" data-filter="category" data-value="medikal-bedah">🏥 Medikal Bedah</div>
                                <div class="sidebar-item" data-filter="category" data-value="keperawatan-anak">👶 Keperawatan Anak</div>
                                <div class="sidebar-item" data-filter="category" data-value="farmakologi">💊 Farmakologi</div>
                            @endforelse
                        </div>

                        {{-- Format File --}}
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📄 Format File</div>
                            <div class="sidebar-item active" data-filter="format" data-value="all">📄 Semua Format</div>
                            <div class="sidebar-item" data-filter="format" data-value="pdf">📕 PDF</div>
                            <div class="sidebar-item" data-filter="format" data-value="doc">📘 DOC</div>
                            <div class="sidebar-item" data-filter="format" data-value="ppt">📙 PPT</div>
                        </div>

                        {{-- Info filter aktif --}}
                        <div class="mt-4 hidden" id="activeFiltersContainer">
                            <div class="text-xs text-gray-400 mb-2">Filter aktif:</div>
                            <div id="activeFiltersList" class="flex flex-wrap gap-2"></div>
                            <button id="resetAllFilters" class="text-xs text-indigo-300 mt-2 hover:text-white transition">✖ Reset semua filter</button>
                        </div>
                    </div>

                    {{-- CONTENT AREA --}}
                    <div class="lg:col-span-3">
                        {{-- Search Form (server-side, dengan debounce) --}}
                        <div class="mb-7">
                            <form method="GET" action="{{ url()->current() }}" id="searchForm">
                                <div class="relative">
                                    <input type="text"
                                           name="search"
                                           value="{{ request('search') }}"
                                           class="search-input"
                                           placeholder="🔍 Cari judul e-article, penulis, atau kata kunci..."
                                           id="searchInput">
                                    @if(request('search'))
                                        <a href="{{ url()->current() }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white text-xs">✖</a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        {{-- E-Article Populer (2 item pertama) --}}
                        @if($ebooks->count() > 0)
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-indigo-200 font-semibold">✨ E-Article Populer</h3>
                                <span class="text-xs text-gray-500">Paling banyak diakses</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                @foreach($ebooks->take(2) as $featured)
                                <div class="ebook-card"
                                     data-category="{{ strtolower(str_replace(' ', '-', $featured->category->name ?? '')) }}"
                                     data-format="{{ strtolower($featured->format ?? 'pdf') }}">
                                    <div class="ebook-cover">
                                        @if(!empty($featured->cover_image) && file_exists(public_path('storage/' . $featured->cover_image)))
                                            <img src="{{ asset('storage/' . $featured->cover_image) }}" alt="{{ $featured->title }}" loading="lazy">
                                            <div class="cover-fallback" style="display:none;">📖</div>
                                        @else
                                            <div class="cover-fallback">📖</div>
                                        @endif
                                        <div class="ebook-overlay"></div>
                                        <span class="ebook-format">📕 {{ strtoupper($featured->format ?? 'PDF') }}</span>
                                    </div>
                                    <div class="p-4 flex flex-col flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs text-indigo-300">⭐ 4.8</span>
                                            <span class="text-xs text-gray-500">📥 {{ $featured->views ?? 0 }} views</span>
                                        </div>
                                        <h3 class="font-semibold text-indigo-200 mb-1 text-sm line-clamp-2">{{ Str::limit($featured->title, 55) }}</h3>
                                        <p class="text-xs text-gray-400 mb-4">✍️ {{ $featured->author ?? 'Administrator' }}</p>
                                        <div class="flex items-center gap-2 mt-auto">
                                            @if(!empty($featured->file_url))
                                                <a href="{{ asset('storage/' . $featured->file_url) }}" target="_blank" class="btn-primary flex-1 tooltip-wrapper">
                                                    📖 Baca
                                                    <span class="tooltip-text">Baca online</span>
                                                </a>
                                                <a href="{{ route('final_project.detail', $featured->id) }}" class="btn-outline tooltip-wrapper">
                                                    👁️
                                                    <span class="tooltip-text">Detail</span>
                                                </a>
                                                <a href="{{ asset('storage/' . $featured->file_url) }}" download class="btn-outline tooltip-wrapper">
                                                    ⬇️
                                                    <span class="tooltip-text">Download</span>
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-500">File tidak tersedia</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Semua Koleksi --}}
                        <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                            <h3 class="text-indigo-200 font-semibold text-lg">📚 Semua Koleksi E-Article</h3>
                            <span class="text-sm text-gray-400" id="totalCountDisplay">{{ $ebooks->total() }} artikel tersedia</span>
                        </div>

                        {{-- Grid dengan data attribute untuk filter --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5" id="ebooksGrid">
                            @forelse($ebooks as $item)
                            <div class="ebook-card"
                                 data-category="{{ strtolower(str_replace(' ', '-', $item->category->name ?? $item->category_name ?? 'keperawatan')) }}"
                                 data-format="{{ strtolower($item->format ?? 'pdf') }}">
                                <div class="ebook-cover">
                                    @if(!empty($item->cover_image) && file_exists(public_path('storage/' . $item->cover_image)))
                                        <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}" loading="lazy">
                                        <div class="cover-fallback" style="display:none;">📖</div>
                                    @else
                                        <div class="cover-fallback">📖</div>
                                    @endif
                                    <div class="ebook-overlay"></div>
                                    <span class="ebook-format">📕 {{ strtoupper($item->format ?? 'PDF') }}</span>
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs text-indigo-300">{{ $item->category->name ?? $item->category_name ?? 'Keperawatan' }}</span>
                                        <span class="text-xs text-gray-500">📅 {{ $item->year ?? $item->publication_year ?? date('Y') }}</span>
                                    </div>
                                    <h3 class="font-semibold text-indigo-100 mb-2 text-sm line-clamp-2">{{ Str::limit($item->title, 55) }}</h3>
                                    <p class="text-xs text-gray-400 mb-3">✍️ {{ $item->author ?? 'Administrator' }}</p>
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="mini-stat">👁️ {{ $item->views ?? 0 }} views</div>
                                        <div class="mini-stat">⭐ 4.8</div>
                                    </div>
                                    @if(!empty($item->file_url))
                                    <div class="flex items-center gap-2 mt-auto">
                                        <a href="{{ asset('storage/' . $item->file_url) }}" target="_blank" class="btn-primary flex-1 tooltip-wrapper">
                                            📖 Baca
                                            <span class="tooltip-text">Baca online</span>
                                        </a>
                                        <a href="{{ route('final_project.detail', $item->id) }}" class="btn-outline tooltip-wrapper">
                                            👁️
                                            <span class="tooltip-text">Detail</span>
                                        </a>
                                        <a href="{{ asset('storage/' . $item->file_url) }}" download class="btn-outline tooltip-wrapper">
                                            ⬇️
                                            <span class="tooltip-text">Download</span>
                                        </a>
                                    </div>
                                    @else
                                    <span class="text-xs text-gray-500">File tidak tersedia</span>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="col-span-full text-center py-14">
                                <div class="text-6xl mb-4">📭</div>
                                <p class="text-gray-300 text-lg">Tidak ada e-article yang ditemukan</p>
                                <p class="text-sm text-gray-500 mt-2">Silakan coba kata kunci lain</p>
                            </div>
                            @endforelse
                        </div>

                        {{-- Pagination --}}
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
// 1. FADE-UP ANIMATION
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
// 2. FALLBACK IMAGES
// ==============================
function fixImageFallbacks() {
    document.querySelectorAll('.ebook-cover img').forEach(img => {
        const fallback = img.parentElement.querySelector('.cover-fallback');
        img.addEventListener('error', () => {
            img.style.display = 'none';
            if (fallback) fallback.style.display = 'flex';
        });
        if (img.complete && img.naturalWidth === 0) {
            img.style.display = 'none';
            if (fallback) fallback.style.display = 'flex';
        }
    });
}

// ==============================
// 3. CLIENT-SIDE FILTER (KATEGORI & FORMAT)
// ==============================
let activeCategory = 'all';
let activeFormat = 'all';

function updateFilters() {
    const cards = document.querySelectorAll('#ebooksGrid .ebook-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const cardCategory = card.getAttribute('data-category') || '';
        const cardFormat = card.getAttribute('data-format') || '';

        const categoryMatch = (activeCategory === 'all') || (cardCategory === activeCategory);
        const formatMatch = (activeFormat === 'all') || (cardFormat === activeFormat);

        if (categoryMatch && formatMatch) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Update tampilan jumlah
    const totalSpan = document.getElementById('totalCountDisplay');
    if (totalSpan) {
        totalSpan.innerText = `${visibleCount} artikel ditampilkan`;
    }

    // Tampilkan container filter aktif jika ada filter yang tidak 'all'
    const filterContainer = document.getElementById('activeFiltersContainer');
    const filterList = document.getElementById('activeFiltersList');
    if (filterContainer && filterList) {
        const hasActive = (activeCategory !== 'all') || (activeFormat !== 'all');
        filterContainer.classList.toggle('hidden', !hasActive);
        if (hasActive) {
            let html = '';
            if (activeCategory !== 'all') {
                const categoryName = document.querySelector(`.sidebar-item[data-filter="category"][data-value="${activeCategory}"]`)?.innerText?.replace(/[📁📚]/g,'').trim() || activeCategory;
                html += `<span class="filter-badge">📂 ${categoryName} <span class="reset-filter" data-filter-type="category" style="cursor:pointer;">✖</span></span>`;
            }
            if (activeFormat !== 'all') {
                const formatName = document.querySelector(`.sidebar-item[data-filter="format"][data-value="${activeFormat}"]`)?.innerText?.replace(/[📄📕📘📙]/g,'').trim() || activeFormat;
                html += `<span class="filter-badge">📄 ${formatName.toUpperCase()} <span class="reset-filter" data-filter-type="format" style="cursor:pointer;">✖</span></span>`;
            }
            filterList.innerHTML = html;
            // Event listener untuk reset individual
            document.querySelectorAll('.reset-filter').forEach(el => {
                el.addEventListener('click', (e) => {
                    const type = el.getAttribute('data-filter-type');
                    if (type === 'category') setActiveCategory('all');
                    if (type === 'format') setActiveFormat('all');
                });
            });
        }
    }
}

function setActiveCategory(value) {
    activeCategory = value;
    document.querySelectorAll('.sidebar-item[data-filter="category"]').forEach(el => {
        if (el.getAttribute('data-value') === value) {
            el.classList.add('active');
        } else {
            el.classList.remove('active');
        }
    });
    updateFilters();
}

function setActiveFormat(value) {
    activeFormat = value;
    document.querySelectorAll('.sidebar-item[data-filter="format"]').forEach(el => {
        if (el.getAttribute('data-value') === value) {
            el.classList.add('active');
        } else {
            el.classList.remove('active');
        }
    });
    updateFilters();
}

function initFilters() {
    // Kategori
    document.querySelectorAll('.sidebar-item[data-filter="category"]').forEach(el => {
        el.addEventListener('click', () => {
            setActiveCategory(el.getAttribute('data-value'));
        });
    });
    // Format
    document.querySelectorAll('.sidebar-item[data-filter="format"]').forEach(el => {
        el.addEventListener('click', () => {
            setActiveFormat(el.getAttribute('data-value'));
        });
    });
    // Reset all
    const resetAllBtn = document.getElementById('resetAllFilters');
    if (resetAllBtn) {
        resetAllBtn.addEventListener('click', () => {
            setActiveCategory('all');
            setActiveFormat('all');
        });
    }
    // Inisialisasi default
    setActiveCategory('all');
    setActiveFormat('all');
}

// ==============================
// 4. NOTIFICATION SYSTEM
// ==============================
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = 'notification';
    const icon = type === 'success' ? '✅' : (type === 'error' ? '❌' : 'ℹ️');
    notification.innerHTML = `<span>${icon}</span><span>${message}</span>`;
    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ==============================
// 5. NOTIFIKASI SAAT BACA/DOWNLOAD
// ==============================
function attachActionNotifications() {
    document.querySelectorAll('.btn-primary, .btn-outline').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const href = btn.getAttribute('href');
            if (href && (href.includes('/storage/') || href.includes('/download'))) {
                e.preventDefault(); // biar notif dulu
                showNotification('Membuka file...', 'info');
                setTimeout(() => {
                    window.open(href, '_blank');
                }, 100);
            }
        });
    });
}

// ==============================
// 6. SEARCH DEBOUNCE
// ==============================
function initSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                document.getElementById('searchForm').submit();
            }, 500);
        });
    }
}

// ==============================
// INIT ALL
// ==============================
document.addEventListener('DOMContentLoaded', function() {
    initAnimation();
    fixImageFallbacks();
    initFilters();
    attachActionNotifications();
    initSearch();
});
</script>
@endpush




