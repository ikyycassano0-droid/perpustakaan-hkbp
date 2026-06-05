@extends(is_logged_in() ? 'user.component.master' : 'guest.component.master')

@section('title', 'Hasil Pencarian - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       LAYOUT KHUSUS HALAMAN PENCARIAN
       (CSS manual tanpa Tailwind)
    ============================================ */

    .search-hero {
        background: linear-gradient(135deg, rgba(26, 107, 71, 0.08), rgba(45, 170, 110, 0.04));
        border-bottom: 1px solid rgba(26, 107, 71, 0.15);
        padding: 3rem 5% 2rem;
        position: relative;
        overflow: hidden;
    }

    .search-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 80%;
        height: 200%;
        background: radial-gradient(circle, rgba(26, 107, 71, 0.08), transparent);
        border-radius: 50%;
        pointer-events: none;
    }

    .result-stats {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        padding: 0.5rem 1.25rem;
        border-radius: 40px;
        border: 1px solid rgba(26, 107, 71, 0.2);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    /* ===== LAYOUT UTAMA GRID ===== */
    .main-container {
        display: flex;
        max-width: 1400px;
        margin: 40px auto;
        padding: 0 20px;
        gap: 30px;
        align-items: flex-start;
    }

    /* ============================================
       SIDEBAR (GAYA SEPERTI KATALOG DIGITAL)
    ============================================ */
    .sidebar {
        width: 260px;
        flex-shrink: 0;
        background: var(--card-bg);
        padding: 20px 15px;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        position: sticky;
        top: 100px;
        z-index: 10;
    }

    .sidebar-title {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
        padding-left: 10px;
    }

    /* Menu item seperti pada gambar (E-book, E-Article, dll) */
    .side-menu {
        list-style: none;
    }

    .side-menu li {
        margin-bottom: 5px;
    }

    .side-menu li a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 15px;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-muted);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .side-menu li a i {
        width: 20px;
        text-align: center;
        color: var(--primary-color);
    }

    .side-menu li a:hover {
        background-color: #f0f7f3;
        color: var(--primary-color);
        transform: translateX(4px);
    }

    /* Pemisah antar grup filter (agar terlihat rapi seperti menu) */
    .filter-group-item {
        margin-top: 20px;
        border-top: 1px solid var(--border-color);
        padding-top: 15px;
    }

    .filter-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
        padding-left: 5px;
    }

    .filter-label i {
        color: var(--primary-color);
        width: 20px;
    }

    .filter-options {
        padding-left: 30px;
        margin-bottom: 12px;
    }

    .filter-option {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 0;
        font-size: 0.85rem;
        color: var(--text-muted);
        cursor: pointer;
        transition: 0.2s;
    }

    .filter-option:hover {
        color: var(--primary-color);
        padding-left: 4px;
    }

    .filter-option input {
        accent-color: var(--primary-color);
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .sort-select, .filter-select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background: #fcfdfc;
        font-size: 0.85rem;
        color: var(--text-dark);
        margin-bottom: 10px;
        transition: 0.3s;
    }

    .sort-select:focus, .filter-select:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 2px rgba(26, 107, 71, 0.1);
    }

    .year-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.85rem;
    }

    .sidebar-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 15px;
        padding-top: 10px;
        border-top: 1px solid var(--border-color);
    }

    .btn-filter-apply {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-filter-apply:hover {
        background: var(--deep-green);
        transform: translateY(-2px);
    }

    .btn-filter-reset {
        background: #f1f5f2;
        color: #0d2137;
        border: 1px solid var(--border-color);
        padding: 8px 12px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-filter-reset:hover {
        background: #e2e8e6;
    }

    /* ===== HASIL GRID (KARTU) ===== */
    .content-section {
        flex-grow: 1;
        min-width: 300px;
    }

    .search-results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .search-card {
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid #d4e5d9;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 12px rgba(15, 74, 49, 0.04);
    }

    .search-card:hover {
        transform: translateY(-5px);
        border-color: var(--accent-green, #2daa6e);
        box-shadow: 0 16px 28px -8px rgba(15, 74, 49, 0.15);
    }

    /* ===== GAMBAR THUMBNAIL ===== */
    .card-thumb {
        height: 160px;
        background-size: cover;
        background-position: center;
        position: relative;
        background-color: #e2e8f0;
        transition: all 0.3s ease;
    }

    .card-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 700;
        backdrop-filter: blur(4px);
    }

    .badge-collection {
        background: var(--primary-color, #1a6b47);
        color: white;
    }

    .badge-final {
        background: var(--accent-green, #2daa6e);
        color: white;
    }

    .restricted-badge {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: #e74c3c;
        backdrop-filter: blur(4px);
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .highlight {
        background: rgba(241, 196, 15, 0.25);
        color: var(--primary-color, #1a6b47);
        padding: 0 2px;
        border-radius: 4px;
        font-weight: 600;
    }

    /* ===== TOMBOL DETAIL ===== */
    .btn-detail {
        background: var(--primary-color, #1a6b47);
        padding: 0.5rem 1rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-detail:hover {
        background: var(--deep-green, #0f4a31);
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(26, 107, 71, 0.3);
        color: white;
    }

    .bg-accent {
        background-color: var(--accent-green, #2daa6e);
    }
    .bg-accent:hover {
        background-color: var(--primary-color, #1a6b47);
    }

    /* ===== CONTENT CARD ===== */
    .card-content {
        padding: 1rem 1.25rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        color: #0d2137;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-desc {
        font-size: 0.85rem;
        color: #5a7060;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-footer {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-footer .meta {
        font-size: 0.75rem;
        color: #5a7060;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: #ffffff;
        border-radius: 1.5rem;
        border: 1px solid #d4e5d9;
        box-shadow: 0 4px 12px rgba(15, 74, 49, 0.04);
    }

    /* ===== PAGINATION ===== */
    .pagination-custom {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .pagination-custom .page-item {
        list-style: none;
    }

    .pagination-custom .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #ffffff;
        border: 1px solid #d4e5d9;
        border-radius: 10px;
        color: #0d2137;
        transition: all 0.3s ease;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .pagination-custom .page-link:hover {
        background: rgba(26, 107, 71, 0.08);
        border-color: var(--primary-color, #1a6b47);
        transform: translateY(-2px);
    }

    .pagination-custom .active .page-link {
        background: var(--primary-color, #1a6b47);
        border-color: var(--primary-color, #1a6b47);
        color: white;
        box-shadow: 0 4px 12px rgba(26, 107, 71, 0.3);
    }

    .pagination-custom .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .sidebar {
            display: none; /* Sidebar hilang di tablet/mobile, filter bisa diakses via tombol atau di atas */
        }
        .search-results-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    @media (max-width: 640px) {
        .search-results-grid {
            grid-template-columns: 1fr;
        }
        .result-stats {
            font-size: 0.8rem;
            padding: 0.35rem 1rem;
        }
    }

    /* ===== ANIMASI FADE-UP ===== */
    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease;
    }
    .fade-up.show {
        opacity: 1;
        transform: translateY(0);
    }

    /* ===== LOADING SKELETON ===== */
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .loading-skeleton-card {
        background: #f8fbf9;
        border-radius: 1.25rem;
        overflow: hidden;
        border: 1px solid #e2e8e6;
    }

    .skeleton-thumb {
        height: 160px;
        background: linear-gradient(90deg, #e2e8e6 25%, #f0f5f2 50%, #e2e8e6 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    .skeleton-line {
        height: 12px;
        background: linear-gradient(90deg, #e2e8e6 25%, #f0f5f2 50%, #e2e8e6 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 6px;
        margin: 0.75rem 1rem;
    }

    .skeleton-line-sm {
        width: 60%;
        height: 10px;
    }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO SECTION PENCARIAN -->
    <section class="search-hero">
        <div class="max-w-7xl mx-auto" style="max-width:1200px; margin:0 auto; text-align:center;">
            <div class="inline-block bg-white/80 backdrop-blur-sm px-5 py-2 rounded-full mb-4 shadow-sm border border-[#d4e5d9]">
                <span style="color:var(--primary-color); font-size:0.85rem; font-weight:600;">🔍 PENCARIAN DIGITAL</span>
            </div>
            <h1 style="font-size:2.5rem; font-weight:700; color:#0d2137; margin-bottom:0.5rem;">
                Hasil Pencarian
            </h1>
            <div class="result-stats" style="display:inline-flex; align-items:center; gap:0.75rem; background:rgba(255,255,255,0.9); backdrop-filter:blur(12px); padding:0.5rem 1.25rem; border-radius:40px; border:1px solid rgba(26,107,71,0.2); box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" style="color:var(--primary-color);"></path>
                </svg>
                <span style="color:#5a7060;">Menampilkan <span style="color:var(--primary-color); font-weight:600;">
                    {{ method_exists($results, 'total') ? number_format($results->total()) : number_format($results->count()) }}
                </span> hasil untuk</span>
                <span style="color:var(--primary-color); font-weight:600; background:rgba(26,107,71,0.1); padding:0.1rem 0.75rem; border-radius:40px;">"{{ $keyword }}"</span>
            </div>
        </div>
    </section>

    <!-- KONTEN UTAMA: FILTER + HASIL (Menggunakan struktur main-container seperti E-Book) -->
    <div class="main-container">

        <!-- SIDEBAR (GAYA KATALOG DIGITAL + FILTER) -->
        <aside class="sidebar fade-up">
            <h3 class="sidebar-title">HASIL PENCARIAN</h3>

            <!-- FILTER PENCARIAN (TETAP DIPERTAHANKAN) -->
            <div class="filter-group-item">
                <div class="filter-label"><i class="fas fa-sliders-h"></i> Filter Pencarian</div>

                <!-- Tipe Konten -->

                <!-- Klasifikasi -->
                <select id="filterClassification" class="filter-select">
                    <option value="">🏷️ Semua Klasifikasi</option>
                    @foreach($classifications ?? [] as $c)
                        <option value="{{ $c->name }}" {{ request('classification') == $c->name ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Kategori -->
                <select id="filterCategory" class="filter-select">
                    <option value="">📁 Semua Kategori</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Tahun -->
                <input type="number" id="filterYear" class="year-input" placeholder="📅 Tahun (contoh: 2023)" value="{{ request('year') }}">

                <!-- Urutkan -->
                <select id="sortBy" class="sort-select">
                    <option value="relevance" {{ request('sort') == 'relevance' ? 'selected' : '' }}>🔄 Relevansi</option>
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>📖 Judul (A-Z)</option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>📖 Judul (Z-A)</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>🆕 Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>🕰️ Terlama</option>
                </select>

                <!-- Tombol -->
                <div class="sidebar-actions">
                    <button id="applyFilterBtn" class="btn-filter-apply">
                        🔍 Terapkan
                    </button>
                    <button id="resetFilterBtn" class="btn-filter-reset">
                        🔄 Reset
                    </button>
                </div>
            </div>
        </aside>

        <!-- HASIL PENCARIAN -->
        <div class="content-section">
            <!-- Loading Skeleton -->
            <div id="loadingSkeleton" class="search-results-grid" style="display:none;">
                @for($i = 0; $i < 6; $i++)
                    <div class="loading-skeleton-card">
                        <div class="skeleton-thumb"></div>
                        <div class="skeleton-line"></div>
                        <div class="skeleton-line skeleton-line-sm"></div>
                        <div class="skeleton-line" style="width:40%; margin-bottom:1rem;"></div>
                    </div>
                @endfor
            </div>

            <!-- Hasil konten -->
            <div id="resultsContainer">
                @if($results->count() == 0)
                    <div class="empty-state fade-up">
                        <div style="font-size:4rem; margin-bottom:1rem; opacity:0.5;">🔍</div>
                        <h3 style="font-size:1.25rem; font-weight:600; color:#0d2137; margin-bottom:0.5rem;">Tidak ditemukan hasil</h3>
                        <p style="color:#5a7060;">Coba kata kunci lain atau gunakan filter yang berbeda.</p>
                        <div style="display:flex; justify-content:center; gap:1rem; margin-top:1.5rem;">
                            <a href="{{ url('/') }}" class="btn-detail">Kembali ke Beranda</a>
                            <button onclick="resetFilters()" style="background:#f1f5f2; color:#0d2137; border:1px solid #d4e5d9; padding:0.5rem 1.5rem; border-radius:40px; cursor:pointer; transition:0.3s;">Reset Filter</button>
                        </div>
                    </div>
                @else
                    <div class="search-results-grid" id="searchResultsGrid">
                        @foreach($results as $item)
                            @php
                                $title = $item->title ?? '';
                                $highlightedTitle = preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<span class="highlight">$1</span>', e($title));
                                $description = $item->description ?? ($item->abstract ?? '');
                                $descClean = strip_tags($description);
                                $highlightedDesc = preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<span class="highlight">$1</span>', Str::limit($descClean, 120));
                                $itemType = $item->type ?? 'collection';
                            @endphp
                            <div class="search-card fade-up" data-type="{{ $itemType }}">
                                @if($itemType == 'collection')
                                    <div class="card-thumb" style="background-image: url('{{ ($item->cover ?? false) ? asset('storage/'.$item->cover) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=160&fit=crop' }}')">
                                        <span class="card-badge badge-collection">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            Koleksi
                                        </span>
                                        @if(!empty($item->is_restricted))
                                            <span class="restricted-badge">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                Terbatas
                                            </span>
                                        @endif
                                    </div>
                                    <div class="card-content">
                                        <h3 class="card-title">{!! $highlightedTitle !!}</h3>
                                        <p class="card-desc">{!! $highlightedDesc !!}</p>
                                        <div class="card-footer">
                                            <span class="meta">📚 Perpustakaan</span>
                                            <a href="{{ url('/collections/'.$item->id) }}" class="btn-detail">Lihat Detail →</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="card-thumb" style="background-image: url('{{ ($item->cover_image ?? $item->thumbnail ?? false) ? asset('storage/'.($item->cover_image ?? $item->thumbnail)) : 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=160&fit=crop' }}')">
                                        <span class="card-badge badge-final">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            KTI
                                        </span>
                                    </div>
                                    <div class="card-content">
                                        <h3 class="card-title">{!! $highlightedTitle !!}</h3>
                                        <p class="card-desc">{!! $highlightedDesc !!}</p>
                                        <div style="display:flex; gap:0.5rem; margin-top:0.5rem;">
                                            @if($item->file_url)
                                                <a href="{{ asset('storage/'.$item->file_url) }}" class="btn-detail" style="flex:1; text-align:center;" target="_blank">
                                                    📖 Baca
                                                </a>
                                                <a href="{{ asset('storage/'.$item->file_url) }}" download class="btn-detail bg-accent" style="flex:1; text-align:center;">
                                                    ⬇️ Download
                                                </a>
                                            @else
                                                <span style="color:#5a7060; font-size:0.85rem; text-align:center; width:100%;">File tidak tersedia</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if(method_exists($results, 'links') && $results->hasPages())
                        <div class="pagination-custom">
                            {{ $results->appends(request()->except('page'))->links('pagination::tailwind') }}
                        </div>
                    @elseif(method_exists($results, 'links'))
                        <div class="pagination-custom">
                            {{ $results->links('pagination::tailwind') }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Elemen DOM
    const applyFilterBtn = document.getElementById('applyFilterBtn');
    const resetFilterBtn = document.getElementById('resetFilterBtn');
    const sortSelect = document.getElementById('sortBy');
    const filterCollection = document.getElementById('filterCollection');
    const filterFinal = document.getElementById('filterFinal');
    const loadingSkeleton = document.getElementById('loadingSkeleton');
    const resultsContainer = document.getElementById('resultsContainer');

    // Fungsi untuk menerapkan filter via URL parameter
    function applyFilters() {
        let params = new URLSearchParams(window.location.search);

        // Tipe konten
        let selectedTypes = [];
        if (document.getElementById('filterCollection')?.checked) selectedTypes.push('collection');
        if (document.getElementById('filterFinal')?.checked) selectedTypes.push('final');
        if (selectedTypes.length > 0) params.set('type', selectedTypes.join(','));
        else params.delete('type');

        // Classification
        let classification = document.getElementById('filterClassification')?.value;
        if (classification) params.set('classification', classification);
        else params.delete('classification');

        // Category
        let category = document.getElementById('filterCategory')?.value;
        if (category) params.set('category', category);
        else params.delete('category');

        // Tahun (Input Manual)
        let yearInput = document.getElementById('filterYear')?.value.trim();
        if (yearInput) {
            params.set('year', yearInput);
        } else {
            params.delete('year');
        }

        // Sort
        let sort = document.getElementById('sortBy')?.value;
        if (sort && sort !== 'relevance') params.set('sort', sort);
        else params.delete('sort');

        params.delete('page');
        window.location.search = params.toString();
    }

    // Reset filter
    function resetFilters() {
        let params = new URLSearchParams(window.location.search);
        params.delete('type');
        params.delete('sort');
        params.delete('page');
        window.location.search = params.toString();
    }

    // Inisialisasi nilai filter dari URL saat halaman dimuat
    function initFiltersFromURL() {
        let urlParams = new URLSearchParams(window.location.search);
        let typeParam = urlParams.get('type');
        let sortParam = urlParams.get('sort');
        let yearParam = urlParams.get('year');

        if (typeParam) {
            let types = typeParam.split(',');
            if (filterCollection) filterCollection.checked = types.includes('collection');
            if (filterFinal) filterFinal.checked = types.includes('final');
        }

        if (sortParam && sortSelect) {
            sortSelect.value = sortParam;
        } else if (sortSelect) {
            sortSelect.value = 'relevance';
        }

        let yearInput = document.getElementById('filterYear');
        if (yearParam && yearInput) {
            yearInput.value = yearParam;
        }
    }

    // Event listeners
    if (applyFilterBtn) applyFilterBtn.addEventListener('click', applyFilters);
    if (resetFilterBtn) resetFilterBtn.addEventListener('click', resetFilters);

    // Sembunyikan loading setelah halaman selesai dimuat
    window.addEventListener('load', function() {
        if (loadingSkeleton) loadingSkeleton.style.display = 'none';
        if (resultsContainer) resultsContainer.style.display = 'block';
    });

    // Inisialisasi
    initFiltersFromURL();

    // ============================================
    // ANIMASI FADE-UP
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const fadeElements = document.querySelectorAll('.fade-up');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        fadeElements.forEach(el => observer.observe(el));
    });
</script>
@endpush
