@extends(is_logged_in() ? 'user.component.master' : 'guest.component.master')

@section('title', 'Hasil Pencarian - AKPER HKBP Balige')

@push('styles')
    <style>
        /* ============================================================
               RESET & VARIABEL
            ============================================================ */
        :root {
            --primary-color: #1a6b47;
            --deep-green: #0f4a31;
            --accent-green: #2daa6e;
            --accent-yellow: #f1c40f;
            --text-dark: #0d2137;
            --text-muted: #5a7060;
            --light-bg: #f4f7f5;
            --card-bg: #ffffff;
            --border-color: #d4e5d9;
            --success: #2daa6e;
            --danger: #e74c3c;
        }

        * {
            box-sizing: border-box;
        }

        /* ============================================================
               HERO SECTION
            ============================================================ */
        .search-hero {
            background: linear-gradient(135deg, rgba(26, 107, 71, 0.05), rgba(45, 170, 110, 0.02));
            border-bottom: 1px solid rgba(26, 107, 71, 0.12);
            padding: 100px 5% 2rem;
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

        .search-hero .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            padding: 0.5rem 1.5rem;
            border-radius: 60px;
            border: 1px solid rgba(26, 107, 71, 0.25);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .search-hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-family: 'Playfair Display', serif;
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

        .result-stats strong {
            color: var(--primary-color);
        }

        .keyword-chip {
            background: rgba(26, 107, 71, 0.12);
            padding: 0.2rem 0.9rem;
            border-radius: 40px;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.2px;
        }

        /* ============================================================
               MAIN LAYOUT
            ============================================================ */
        .main-container {
            display: flex;
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
            gap: 30px;
            align-items: flex-start;
        }

        /* ============================================================
               SIDEBAR
            ============================================================ */
        .sidebar {
            width: 280px;
            flex-shrink: 0;
            background: var(--card-bg);
            padding: 1.5rem 1.2rem;
            border-radius: 24px;
            box-shadow: 0 12px 28px rgba(15, 74, 49, 0.06);
            border: 1px solid var(--border-color);
            border-top: 5px solid var(--accent-yellow);
            position: sticky;
            top: 110px;
            z-index: 10;
        }

        .sidebar-title {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 1.2rem;
            padding-left: 0.5rem;
            border-left: 3px solid var(--primary-color);
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
            color: var(--text-dark);
            margin-bottom: 12px;
            padding-left: 6px;
        }

        .filter-label i {
            color: var(--primary-color);
            width: 20px;
            font-size: 0.9rem;
        }

        .filter-select,
        .sort-select,
        .year-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            background: #fcfefd;
            font-size: 0.85rem;
            color: var(--text-dark);
            margin-bottom: 14px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .filter-select:focus,
        .sort-select:focus,
        .year-input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 4px rgba(26, 107, 71, 0.08);
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
            border-top: 1px solid var(--border-color);
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
            background: var(--primary-color);
            color: white;
            box-shadow: 0 2px 6px rgba(26, 107, 71, 0.2);
        }

        .btn-filter-apply:hover {
            background: var(--deep-green);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(15, 74, 49, 0.15);
            color: white;
        }

        .btn-filter-reset {
            background: #f4f8f6;
            color: #2c5a47;
            border: 1px solid var(--border-color);
        }

        .btn-filter-reset:hover {
            background: #eaf3ef;
            transform: translateY(-1px);
        }

        /* ============================================================
               RESULTS GRID - 3 KOLOM x 3 BARIS = 9 ITEMS
            ============================================================ */
        .content-section {
            flex-grow: 1;
            min-width: 0;
        }

        .search-results-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.8rem;
            margin-bottom: 2rem;
        }

        .search-card {
            background: var(--card-bg);
            border-radius: 1.5rem;
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--accent-yellow);
            transition: all 0.35s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 0 6px 14px rgba(15, 74, 49, 0.04);
        }

        .search-card:hover {
            transform: translateY(-6px);
            border-color: var(--accent-green);
            box-shadow: 0 20px 30px -12px rgba(26, 107, 71, 0.2);
        }

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
            color: var(--primary-color);
            padding: 0 2px;
            border-radius: 5px;
            font-weight: 700;
        }

        .card-content {
            padding: 1.2rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-title {
            font-weight: 800;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            color: var(--text-dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
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

        /* ============================================================
               BUTTONS
            ============================================================ */
        .btn-detail {
            background: var(--primary-color);
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
            background: var(--deep-green);
            transform: scale(1.02);
            box-shadow: 0 4px 10px rgba(26, 107, 71, 0.3);
            color: white;
        }

        .bg-accent {
            background-color: var(--accent-green);
        }

        .bg-accent:hover {
            background-color: #1f8b56;
        }

        /* ============================================================
               EMPTY STATE
            ============================================================ */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: var(--card-bg);
            border-radius: 2rem;
            border: 1px solid var(--border-color);
            border-top: 5px solid var(--accent-yellow);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02);
        }

        .empty-state .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.6;
        }

        .empty-state h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .empty-state p {
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        .empty-state .empty-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.8rem;
            flex-wrap: wrap;
        }

        /* ============================================================
               PAGINATION
            ============================================================ */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            display: inline-block;
            padding: 8px 14px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-dark);
            text-decoration: none;
            transition: 0.3s;
            font-weight: 600;
            font-size: 0.85rem;
            min-width: 38px;
            text-align: center;
        }

        .pagination .page-link:hover {
            background: #f0f7f3;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .pagination .active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(26, 107, 71, 0.2);
        }

        .pagination .disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* ============================================================
               ANIMATION
            ============================================================ */
        .fade-up {
            opacity: 0;
            transform: translateY(18px);
            transition: all 0.55s ease;
        }

        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* ============================================================
               LOADING SKELETON
            ============================================================ */
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
            border: 1px solid var(--border-color);
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

        /* ============================================================
               RESPONSIVE
            ============================================================ */
        @media (max-width: 1024px) {
            .sidebar {
                display: none;
            }

            .search-results-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .search-hero {
                padding: 90px 5% 1.5rem;
            }

            .search-hero h1 {
                font-size: 2rem;
            }

            .result-stats {
                font-size: 0.75rem;
                padding: 0.4rem 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        @media (max-width: 640px) {
            .search-results-grid {
                grid-template-columns: 1fr;
            }

            .search-hero h1 {
                font-size: 1.8rem;
            }

            .empty-state .empty-actions {
                flex-direction: column;
                align-items: center;
            }

            .card-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .card-footer .btn-detail {
                text-align: center;
            }

            .pagination .page-link {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <!-- ===== HERO SECTION ===== -->
        <section class="search-hero">
            <div class="hero-container">
                <div class="hero-badge">
                    <i class="fas fa-search"></i> PENCARIAN DIGITAL
                </div>
                <h1>Hasil Pencarian</h1>
                <div class="result-stats">
                    <i class="fas fa-search" style="color: var(--primary-color);"></i>
                    <span>Menampilkan <strong>
                        {{ method_exists($results, 'total') ? number_format($results->total()) : number_format($results->count()) }}
                    </strong> hasil untuk</span>
                    <span class="keyword-chip">“{{ $keyword }}”</span>
                </div>
            </div>
        </section>

        <!-- ===== KONTEN UTAMA ===== -->
        <div class="main-container">
            <!-- ===== SIDEBAR ===== -->
            <aside class="sidebar fade-up">
                <h3 class="sidebar-title">FILTER PENCARIAN</h3>

                <div class="filter-group-item">
                    <div class="filter-label"><i class="fas fa-tag"></i> Klasifikasi</div>
                    <select id="filterClassification" class="filter-select">
                        <option value="">🏷️ Semua Klasifikasi</option>
                        @foreach ($classifications ?? [] as $c)
                            <option value="{{ $c->name }}" {{ request('classification') == $c->name ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="filter-label"><i class="fas fa-folder"></i> Kategori</div>
                    <select id="filterCategory" class="filter-select">
                        <option value="">📁 Semua Kategori</option>
                        @foreach ($categories ?? [] as $cat)
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
                            <i class="fas fa-filter"></i> Terapkan
                        </button>
                        <button id="resetFilterBtn" class="btn-filter-reset">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>
            </aside>

            <!-- ===== HASIL PENCARIAN ===== -->
            <div class="content-section">
                @php
                    $perPage = 9;
                    $currentPage = request('page', 1);
                    $offset = ($currentPage - 1) * $perPage;
                    $paginatedItems = $results->slice($offset, $perPage);
                    $totalItems = $results->count();
                    $totalPages = ceil($totalItems / $perPage);
                @endphp

                <!-- Loading Skeleton -->
                <div id="loadingSkeleton" class="search-results-grid" style="display:none;">
                    @for ($i = 0; $i < 9; $i++)
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
                    @if ($totalItems == 0)
                        <div class="empty-state fade-up">
                            <div class="empty-icon">🔍</div>
                            <h3>Tidak ditemukan hasil</h3>
                            <p>Coba kata kunci lain atau gunakan filter yang berbeda.</p>
                            <div class="empty-actions">
                                <a href="{{ url('/') }}" class="btn-detail">
                                    <i class="fas fa-home"></i> Kembali ke Beranda
                                </a>
                                <button onclick="resetFilters()" style="background:#f1f5f2; color:var(--text-dark); border:1px solid var(--border-color); padding:0.5rem 1.5rem; border-radius:40px; cursor:pointer; font-weight:600;">
                                    <i class="fas fa-undo"></i> Reset Filter
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="search-results-grid" id="searchResultsGrid">
                            @foreach ($paginatedItems as $item)
                                @php
                                    $title = $item->title ?? '';
                                    $highlightedTitle = preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<span class="highlight">$1</span>', e($title));
                                    $description = $item->description ?? ($item->abstract ?? '');
                                    $descClean = strip_tags($description);
                                    $highlightedDesc = preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<span class="highlight">$1</span>', Str::limit($descClean, 120));
                                    $itemType = $item->type ?? 'collection';
                                    $year = $item->year ?? ($item->created_at ? date('Y', strtotime($item->created_at)) : null);
                                    $coverImage = $item->cover ?? $item->cover_image ?? $item->thumbnail ?? null;
                                    $coverUrl = $coverImage ? asset('storage/' . $coverImage) : 'https://via.placeholder.com/400x170/0f4a31/ffffff?text=No+Image';
                                @endphp
                                <div class="search-card fade-up" data-type="{{ $itemType }}">
                                    @if ($itemType == 'collection')
                                        <div class="card-thumb" style="background-image: url('{{ $coverUrl }}')">
                                            <span class="card-badge badge-collection">
                                                <i class="fas fa-book"></i> Koleksi
                                            </span>
                                            @if (!empty($item->is_restricted))
                                                <span class="restricted-badge">
                                                    <i class="fas fa-lock"></i> Terbatas
                                                </span>
                                            @endif
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">{!! $highlightedTitle !!}</h3>
                                            <div class="card-meta">
                                                @if ($year)
                                                    <span><i class="far fa-calendar-alt"></i> {{ $year }}</span>
                                                @endif
                                                <span><i class="fas fa-layer-group"></i> Koleksi</span>
                                            </div>
                                            <p class="card-desc">{!! $highlightedDesc !!}</p>
                                            <div class="card-footer">
                                                <span style="font-size:0.7rem; color:var(--text-muted);">
                                                    <i class="fas fa-library"></i> Perpustakaan
                                                </span>
                                                <a href="{{ url('/collections/' . $item->id) }}" class="btn-detail">
                                                    Lihat Detail <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card-thumb" style="background-image: url('{{ $coverUrl }}')">
                                            <span class="card-badge badge-final">
                                                <i class="fas fa-file-alt"></i> KTI
                                            </span>
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">{!! $highlightedTitle !!}</h3>
                                            <div class="card-meta">
                                                @if ($year)
                                                    <span><i class="far fa-calendar-alt"></i> {{ $year }}</span>
                                                @endif
                                                <span><i class="fas fa-graduation-cap"></i> Tugas Akhir</span>
                                            </div>
                                            <p class="card-desc">{!! $highlightedDesc !!}</p>
                                            <div style="display:flex; gap:0.6rem; margin-top:0.5rem; flex-wrap:wrap;">
                                                @if ($item->file_url)
                                                    <a href="{{ asset('storage/' . $item->file_url) }}" class="btn-detail" style="flex:1; text-align:center;" target="_blank">
                                                        <i class="fas fa-book-open"></i> Baca
                                                    </a>
                                                    <a href="{{ asset('storage/' . $item->file_url) }}" download class="btn-detail bg-accent" style="flex:1; text-align:center;">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                @else
                                                    <span style="color:var(--text-muted); font-size:0.75rem; width:100%; text-align:center;">
                                                        <i class="fas fa-file"></i> File tidak tersedia
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- ===== PAGINATION ===== -->
                        @if ($totalPages > 1)
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    {{-- Previous --}}
                                    <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $currentPage > 1 ? request()->fullUrlWithQuery(['page' => $currentPage - 1]) : '#' }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    {{-- Nomor Halaman --}}
                                    @for ($i = 1; $i <= $totalPages; $i++)
                                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endfor

                                    {{-- Next --}}
                                    <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $currentPage < $totalPages ? request()->fullUrlWithQuery(['page' => $currentPage + 1]) : '#' }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // ============================================================
        // DOM ELEMENTS
        // ============================================================
        var applyFilterBtn = document.getElementById('applyFilterBtn');
        var resetFilterBtn = document.getElementById('resetFilterBtn');
        var sortSelect = document.getElementById('sortBy');
        var loadingSkeleton = document.getElementById('loadingSkeleton');
        var resultsContainer = document.getElementById('resultsContainer');

        // ============================================================
        // APPLY FILTERS
        // ============================================================
        function applyFilters() {
            var params = new URLSearchParams(window.location.search);

            var classification = document.getElementById('filterClassification')?.value;
            if (classification) {
                params.set('classification', classification);
            } else {
                params.delete('classification');
            }

            var category = document.getElementById('filterCategory')?.value;
            if (category) {
                params.set('category', category);
            } else {
                params.delete('category');
            }

            var yearInput = document.getElementById('filterYear')?.value.trim();
            if (yearInput) {
                params.set('year', yearInput);
            } else {
                params.delete('year');
            }

            var sort = document.getElementById('sortBy')?.value;
            if (sort && sort !== 'relevance') {
                params.set('sort', sort);
            } else {
                params.delete('sort');
            }

            params.delete('page');
            window.location.search = params.toString();
        }

        // ============================================================
        // RESET FILTERS
        // ============================================================
        function resetFilters() {
            var params = new URLSearchParams(window.location.search);
            params.delete('classification');
            params.delete('category');
            params.delete('year');
            params.delete('sort');
            params.delete('page');
            window.location.search = params.toString();
        }

        // ============================================================
        // INIT FILTERS FROM URL
        // ============================================================
        function initFiltersFromURL() {
            var urlParams = new URLSearchParams(window.location.search);
            var sortParam = urlParams.get('sort');
            var yearParam = urlParams.get('year');
            var classificationParam = urlParams.get('classification');
            var categoryParam = urlParams.get('category');

            if (sortParam && sortSelect) {
                sortSelect.value = sortParam;
            }

            var yearInput = document.getElementById('filterYear');
            if (yearParam && yearInput) {
                yearInput.value = yearParam;
            }

            var classSelect = document.getElementById('filterClassification');
            if (classificationParam && classSelect) {
                classSelect.value = classificationParam;
            }

            var catSelect = document.getElementById('filterCategory');
            if (categoryParam && catSelect) {
                catSelect.value = categoryParam;
            }
        }

        // ============================================================
        // EVENT LISTENERS
        // ============================================================
        if (applyFilterBtn) {
            applyFilterBtn.addEventListener('click', applyFilters);
        }

        if (resetFilterBtn) {
            resetFilterBtn.addEventListener('click', resetFilters);
        }

        // ============================================================
        // HIDE LOADING AFTER PAGE LOAD
        // ============================================================
        window.addEventListener('load', function() {
            if (loadingSkeleton) {
                loadingSkeleton.style.display = 'none';
            }
            if (resultsContainer) {
                resultsContainer.style.display = 'block';
            }
        });

        // ============================================================
        // FADE-UP ANIMATION
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            var fadeElements = document.querySelectorAll('.fade-up');
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            fadeElements.forEach(function(el) {
                observer.observe(el);
            });
        });

        // ============================================================
        // INIT
        // ============================================================
        initFiltersFromURL();

        // Expose resetFilters globally
        window.resetFilters = resetFilters;
    </script>
@endpush
