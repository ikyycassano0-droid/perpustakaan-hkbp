@extends(is_logged_in() ? 'user.component.master' : 'guest.component.master')

@section('title', 'Hasil Pencarian - AKPER HKBP Balige')

@push('styles')
    <style>
        /* ============================================
           LAYOUT KHUSUS HALAMAN PENCARIAN
           (CSS manual tanpa Tailwind) - VERSI DIPERINDAH
        ============================================ */

        /* Global reset tambahan untuk konsistensi */
        .main-content * {
            box-sizing: border-box;
        }

        /* ===== HERO SECTION ===== */
        .search-hero {
            background: linear-gradient(135deg, rgba(26, 107, 71, 0.05), rgba(45, 170, 110, 0.02));
            border-bottom: 1px solid rgba(26, 107, 71, 0.12);
            padding: 3rem 5% 2rem;
            position: relative;
            overflow: hidden;
        }

        .search-hero::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -10%;
            width: 80%;
            height: 150%;
            background: radial-gradient(circle, rgba(26, 107, 71, 0.05), transparent 70%);
            pointer-events: none;
            border-radius: 50%;
        }

        .result-stats {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            padding: 0.6rem 1.5rem;
            border-radius: 60px;
            border: 1px solid rgba(26, 107, 71, 0.25);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            font-size: 0.9rem;
        }

        .keyword-chip {
            background: rgba(26, 107, 71, 0.12);
            padding: 0.2rem 0.9rem;
            border-radius: 40px;
            font-weight: 700;
            color: #1a6b47;
            letter-spacing: -0.2px;
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

        /* ===== SIDEBAR (GAYA KATALOG DIGITAL) ===== */
        .sidebar {
            width: 280px;
            flex-shrink: 0;
            background: #ffffff;
            padding: 1.5rem 1.2rem;
            border-radius: 28px;
            box-shadow: 0 12px 30px rgba(15, 74, 49, 0.08);
            border: 1px solid #e2f0e8;
            position: sticky;
            top: 100px;
            z-index: 10;
            transition: all 0.2s;
        }

        .sidebar-title {
            font-size: 0.7rem;
            color: #5a7060;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 1.2rem;
            padding-left: 0.5rem;
            border-left: 3px solid #1a6b47;
        }

        .filter-group-item {
            margin-top: 0.5rem;
        }

        .filter-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #0d2137;
            margin-bottom: 12px;
            padding-left: 6px;
        }

        .filter-label i {
            color: #1a6b47;
            width: 20px;
            font-size: 0.9rem;
        }

        .filter-select,
        .sort-select,
        .year-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e0ece4;
            border-radius: 18px;
            background: #fcfefd;
            font-size: 0.85rem;
            color: #0d2137;
            margin-bottom: 14px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .filter-select:focus,
        .sort-select:focus,
        .year-input:focus {
            border-color: #1a6b47;
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 107, 71, 0.1);
            background: white;
        }

        .year-input::placeholder {
            color: #b0c4bb;
            font-weight: 400;
        }

        .sidebar-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 20px;
            padding-top: 12px;
            border-top: 1px solid #e0ece4;
        }

        .btn-filter-apply,
        .btn-filter-reset {
            padding: 10px 8px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.25s ease;
            text-align: center;
            border: none;
        }

        .btn-filter-apply {
            background: #1a6b47;
            color: white;
            box-shadow: 0 2px 6px rgba(26, 107, 71, 0.2);
        }

        .btn-filter-apply:hover {
            background: #0f4a31;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(15, 74, 49, 0.15);
        }

        .btn-filter-reset {
            background: #f4f8f6;
            color: #2c5a47;
            border: 1px solid #d4e5d9;
        }

        .btn-filter-reset:hover {
            background: #eaf3ef;
            transform: translateY(-1px);
        }

        /* ===== HASIL GRID (KARTU) ===== */
        .content-section {
            flex-grow: 1;
            min-width: 0;
        }

        .search-results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 1.8rem;
            margin-bottom: 2rem;
        }

        .search-card {
            background: #ffffff;
            border-radius: 1.5rem;
            border: 1px solid #e0ece4;
            transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 0 6px 14px rgba(15, 74, 49, 0.04);
        }

        .search-card:hover {
            transform: translateY(-6px);
            border-color: #2daa6e;
            box-shadow: 0 20px 30px -12px rgba(26, 107, 71, 0.2);
        }

        /* Thumbnail gambar */
        .card-thumb {
            height: 170px;
            background-size: cover;
            background-position: center;
            position: relative;
            background-color: #eef3f0;
            transition: all 0.3s;
        }

        .search-card:hover .card-thumb {
            filter: brightness(0.98);
        }

        .card-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 800;
            backdrop-filter: blur(6px);
            background: rgba(0, 0, 0, 0.65);
            color: white;
            letter-spacing: 0.3px;
        }

        .badge-collection {
            background: rgba(26, 107, 71, 0.9);
            backdrop-filter: blur(4px);
        }

        .badge-final {
            background: rgba(45, 170, 110, 0.9);
        }

        .restricted-badge {
            position: absolute;
            bottom: 12px;
            left: 12px;
            background: #e67e22;
            backdrop-filter: blur(4px);
            padding: 4px 10px;
            border-radius: 40px;
            font-size: 0.65rem;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .highlight {
            background: rgba(241, 196, 15, 0.25);
            color: #1a6b47;
            padding: 0 2px;
            border-radius: 5px;
            font-weight: 700;
        }

        /* Content card */
        .card-content {
            padding: 1.2rem 1.2rem 1.2rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-title {
            font-weight: 800;
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
            line-height: 1.45;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 0.9rem;
            font-size: 0.7rem;
            font-weight: 500;
            color: #6c8b7c;
        }

        .card-meta span {
            background: #f4f9f6;
            padding: 3px 8px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .card-meta i {
            font-size: 0.65rem;
        }

        .card-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.8rem;
        }

        /* Tombol seragam */
        .btn-detail {
            background: #1a6b47;
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
            transition: 0.25s;
            display: inline-block;
            text-align: center;
            border: none;
            cursor: pointer;
            text-decoration: none;
            letter-spacing: 0.3px;
        }

        .btn-detail:hover {
            background: #0f4a31;
            transform: scale(1.02);
            box-shadow: 0 4px 10px rgba(26, 107, 71, 0.3);
            color: white;
        }

        .bg-accent {
            background-color: #2daa6e;
        }

        .bg-accent:hover {
            background-color: #1f8b56;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: #ffffff;
            border-radius: 2rem;
            border: 1px solid #e0ece4;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02);
        }

        /* Pagination */
        .pagination-custom {
            display: flex;
            justify-content: center;
            gap: 0.6rem;
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
            width: 42px;
            height: 42px;
            background: white;
            border: 1px solid #deeae3;
            border-radius: 14px;
            color: #2c5a47;
            transition: 0.2s;
            font-weight: 600;
            text-decoration: none;
        }

        .pagination-custom .page-link:hover {
            background: #eef5f1;
            border-color: #1a6b47;
            transform: translateY(-2px);
        }

        .pagination-custom .active .page-link {
            background: #1a6b47;
            border-color: #1a6b47;
            color: white;
            box-shadow: 0 4px 10px rgba(26, 107, 71, 0.2);
        }

        /* Animasi fade-up */
        .fade-up {
            opacity: 0;
            transform: translateY(18px);
            transition: all 0.55s ease;
        }

        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Loading skeleton (diperhalus) */
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        .loading-skeleton-card {
            background: #fafefb;
            border-radius: 1.5rem;
            overflow: hidden;
            border: 1px solid #e2ece6;
        }

        .skeleton-thumb {
            height: 170px;
            background: linear-gradient(90deg, #e0ece4 25%, #f0f7f3 50%, #e0ece4 75%);
            background-size: 200% 100%;
            animation: shimmer 1.4s infinite;
        }

        .skeleton-line {
            height: 12px;
            background: linear-gradient(90deg, #e0ece4 25%, #f0f7f3 50%, #e0ece4 75%);
            background-size: 200% 100%;
            animation: shimmer 1.4s infinite;
            border-radius: 8px;
            margin: 1rem 1.2rem;
        }

        .skeleton-line-sm {
            width: 60%;
            height: 10px;
        }

        /* Responsif */
        @media (max-width: 1024px) {
            .sidebar {
                display: none;
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
                font-size: 0.75rem;
                padding: 0.4rem 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .search-hero h1 {
                font-size: 1.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-content">

        <!-- HERO SECTION PENCARIAN -->
        <section class="search-hero">
            <div class="max-w-7xl mx-auto" style="max-width:1200px; margin:0 auto; text-align:center;">
                <div class="inline-block bg-white/70 backdrop-blur-sm px-5 py-2 rounded-full mb-4 shadow-sm border border-[#d4e5d9]">
                    <span style="color:var(--primary-color, #1a6b47); font-size:0.85rem; font-weight:600;">🔍 PENCARIAN DIGITAL</span>
                </div>
                <h1 style="font-size:2.5rem; font-weight:700; color:#0d2137; margin-bottom:0.5rem;">
                    Hasil Pencarian
                </h1>
                <div class="result-stats">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" style="color:#1a6b47;"></path>
                    </svg>
                    <span>Menampilkan <strong style="color:#1a6b47;">
                        {{ method_exists($results, 'total') ? number_format($results->total()) : number_format($results->count()) }}
                    </strong> hasil untuk</span>
                    <span class="keyword-chip">“{{ $keyword }}”</span>
                </div>
            </div>
        </section>

        <!-- KONTEN UTAMA: FILTER + HASIL -->
        <div class="main-container">

            <!-- SIDEBAR (GAYA KATALOG DIGITAL + FILTER) -->
            <aside class="sidebar fade-up">
                <h3 class="sidebar-title">FILTER PENCARIAN</h3>

                <div class="filter-group-item">
                    <div class="filter-label"><i class="fas fa-tag"></i> Klasifikasi</div>
                    <select id="filterClassification" class="filter-select">
                        <option value="">🏷️ Semua Klasifikasi</option>
                        @foreach($classifications ?? [] as $c)
                            <option value="{{ $c->name }}" {{ request('classification') == $c->name ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="filter-label"><i class="fas fa-folder"></i> Kategori</div>
                    <select id="filterCategory" class="filter-select">
                        <option value="">📁 Semua Kategori</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="filter-label"><i class="fas fa-calendar-alt"></i> Tahun</div>
                    <input type="number" id="filterYear" class="year-input" placeholder="contoh: 2023" value="{{ request('year') }}">

                    <div class="filter-label"><i class="fas fa-sort-amount-down-alt"></i> Urutkan</div>
                    <select id="sortBy" class="sort-select">
                        <option value="relevance" {{ request('sort') == 'relevance' ? 'selected' : '' }}>🔄 Relevansi</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>📖 Judul (A-Z)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>📖 Judul (Z-A)</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>🆕 Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>🕰️ Terlama</option>
                    </select>

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
                            <div style="font-size:4rem; margin-bottom:1rem; opacity:0.6;">🔍</div>
                            <h3 style="font-size:1.3rem; font-weight:700; color:#0d2137;">Tidak ditemukan hasil</h3>
                            <p style="color:#5a7060; margin-top:0.5rem;">Coba kata kunci lain atau gunakan filter yang berbeda.</p>
                            <div style="display:flex; justify-content:center; gap:1rem; margin-top:1.8rem;">
                                <a href="{{ url('/') }}" class="btn-detail">Kembali ke Beranda</a>
                                <button onclick="resetFilters()" style="background:#f1f5f2; color:#0d2137; border:1px solid #d4e5d9; padding:0.5rem 1.5rem; border-radius:40px; cursor:pointer;">Reset Filter</button>
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
                                    $year = $item->year ?? ($item->created_at ? date('Y', strtotime($item->created_at)) : null);
                                @endphp
                                <div class="search-card fade-up" data-type="{{ $itemType }}">
                                    @if($itemType == 'collection')
                                        <div class="card-thumb" style="background-image: url('{{ ($item->cover ?? false) ? asset('storage/'.$item->cover) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=170&fit=crop' }}')">
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
                                            <div class="card-meta">
                                                @if($year)<span><i class="far fa-calendar-alt"></i> {{ $year }}</span>@endif
                                                <span><i class="fas fa-layer-group"></i> Koleksi</span>
                                            </div>
                                            <p class="card-desc">{!! $highlightedDesc !!}</p>
                                            <div class="card-footer">
                                                <span class="meta" style="font-size:0.7rem;">📚 Perpustakaan</span>
                                                <a href="{{ url('/collections/'.$item->id) }}" class="btn-detail">Lihat Detail →</a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card-thumb" style="background-image: url('{{ ($item->cover_image ?? $item->thumbnail ?? false) ? asset('storage/'.($item->cover_image ?? $item->thumbnail)) : 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=170&fit=crop' }}')">
                                            <span class="card-badge badge-final">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                KTI
                                            </span>
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">{!! $highlightedTitle !!}</h3>
                                            <div class="card-meta">
                                                @if($year)<span><i class="far fa-calendar-alt"></i> {{ $year }}</span>@endif
                                                <span><i class="fas fa-graduation-cap"></i> Tugas Akhir</span>
                                            </div>
                                            <p class="card-desc">{!! $highlightedDesc !!}</p>
                                            <div style="display:flex; gap:0.6rem; margin-top:0.5rem;">
                                                @if($item->file_url)
                                                    <a href="{{ asset('storage/'.$item->file_url) }}" class="btn-detail" style="flex:1; text-align:center;" target="_blank">
                                                        <i class="fas fa-book-open"></i> Baca
                                                    </a>
                                                    <a href="{{ asset('storage/'.$item->file_url) }}" download class="btn-detail bg-accent" style="flex:1; text-align:center;">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                @else
                                                    <span style="color:#6c8b7c; font-size:0.75rem; width:100%; text-align:center;">File tidak tersedia</span>
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
