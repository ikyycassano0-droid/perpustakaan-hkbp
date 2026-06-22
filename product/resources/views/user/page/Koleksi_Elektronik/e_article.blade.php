@extends('user.component.master')

@section('title', 'E-Article & Jurnal - Perpustakaan Sekolah Keperawatan HKBP')

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
            width: 250px;
            flex-shrink: 0;
            background: var(--card-bg);
            padding: 20px;
            border-radius: 16px;
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
            margin-bottom: 15px;
        }

        .side-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .side-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
            border-radius: 10px;
            transition: 0.3s;
            margin-bottom: 5px;
            text-decoration: none;
        }

        .side-menu li a:hover,
        .side-menu li a.active {
            background-color: #f0f7f3;
            color: var(--primary-color);
        }

        .side-menu li a.active {
            background-color: #e0f0e8;
            border-left: 4px solid var(--primary-color);
        }

        /* ============================================================
               CONTENT SECTION
            ============================================================ */
        .content-section {
            flex-grow: 1;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header span {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            background: #e0f0e8;
            padding: 4px 12px;
            border-radius: 50px;
        }

        .page-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--text-dark);
            margin-top: 10px;
            font-weight: 800;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* ============================================================
               FILTER ROW
            ============================================================ */
        .filter-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .filter-item {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            padding: 0 15px;
            transition: 0.3s;
        }

        .filter-item:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(26, 107, 71, 0.1);
        }

        .filter-item i {
            color: var(--text-muted);
            margin-right: 10px;
            font-size: 0.9rem;
        }

        .filter-item input,
        .filter-item select {
            border: none;
            outline: none;
            padding: 12px 0;
            width: 100%;
            font-size: 0.9rem;
            color: var(--text-dark);
            background: transparent;
        }

        /* ============================================================
               ARTICLE GRID
            ============================================================ */
        .article-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 25px;
        }

        .article-card {
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(15, 74, 49, 0.05);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--accent-yellow);
        }

        .article-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(15, 74, 49, 0.12);
        }

        .article-thumb {
            height: 200px;
            position: relative;
            background: #f0f7f3;
            overflow: hidden;
        }

        .article-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .article-card:hover .article-thumb img {
            transform: scale(1.05);
        }

        /* ============================================================
               BADGE STATUS
            ============================================================ */
        .badge-status {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            z-index: 2;
        }

        .badge-available {
            background-color: var(--success);
            color: white;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        /* ============================================================
               ARTICLE INFO
            ============================================================ */
        .article-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 10px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .article-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0f7f3;
            padding: 3px 10px;
            border-radius: 40px;
        }

        .article-meta i {
            font-size: 0.65rem;
            color: var(--primary-color);
        }

        .article-cat {
            font-size: 0.75rem;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .article-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            line-height: 1.4;
            height: 2.8rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .article-author {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .article-author i {
            color: var(--primary-color);
            width: 16px;
        }

        /* ============================================================
               ARTICLE FOOTER & BUTTONS
            ============================================================ */
        .article-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-read {
            background: var(--primary-color);
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            transition: 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-read:hover {
            background: var(--accent-green);
            transform: translateY(-2px);
            color: white;
        }

        .btn-outline-read {
            background: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-outline-read:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-actions-group {
            display: flex;
            gap: 8px;
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
        }

        .pagination .page-link:hover {
            background: #f0f7f3;
            border-color: var(--primary-color);
        }

        .pagination .active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* ============================================================
               RESPONSIVE
            ============================================================ */
        @media (max-width: 1024px) {
            .sidebar {
                display: none;
            }

            .filter-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .article-grid {
                grid-template-columns: 1fr;
            }

            .article-thumb {
                height: 180px;
            }

            .page-header h2 {
                font-size: 1.5rem;
            }

            .article-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .article-footer .btn-read,
            .article-footer .btn-outline-read {
                justify-content: center;
            }

            .btn-actions-group {
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-container">
        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar">
            <h3 class="sidebar-title">Katalog Digital</h3>
            <ul class="side-menu">
                <li>
                    <a href="{{ route('final_project.koleksi', 'ebook') }}" {{ request()->route('category') == 'ebook' ? 'class=active' : '' }}>
                        <i class="fas fa-book"></i> E-book
                    </a>
                </li>
                <li>
                    <a href="{{ route('final_project.koleksi', 'e-article') }}" {{ request()->route('category') == 'e-article' ? 'class=active' : '' }}>
                        <i class="fas fa-file-alt"></i> E-Article
                    </a>
                </li>
                <li>
                    <a href="{{ route('final_project.koleksi', 'cd') }}" {{ request()->route('category') == 'cd' ? 'class=active' : '' }}>
                        <i class="fas fa-compact-disc"></i> CD
                    </a>
                </li>
                <li>
                    <a href="{{ route('final_project.koleksi', 'video') }}" {{ request()->route('category') == 'video' ? 'class=active' : '' }}>
                        <i class="fas fa-video"></i> Video
                    </a>
                </li>
                <li>
                    <a href="{{ route('final_project.kti') }}" {{ request()->route('category') == 'kti' ? 'class=active' : '' }}>
                        <i class="fas fa-chart-line"></i> KTI
                    </a>
                </li>
            </ul>
        </aside>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="content-section">
            <div class="page-header">
                <span>Portal Jurnal & Riset</span>
                <h2>E-Article & Jurnal Riset</h2>
                <p>Akses koleksi artikel ilmiah, jurnal nasional, dan internasional untuk mendukung literasi klinis Anda.</p>
            </div>

            <!-- ===== FILTER ROW ===== -->
            <form method="GET" action="{{ route('final_project.koleksi', 'e-article') }}" class="filter-row">
                <div class="filter-item">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel atau kata kunci riset...">
                </div>
                <div class="filter-item">
                    <select name="category">
                        <option value="">Semua Kategori</option>
                        @foreach ($filterCategories as $cat)
                            <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <select name="sort">
                        <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Terbaru</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                    </select>
                </div>
            </form>

            <!-- ===== ARTICLE GRID ===== -->
            <div class="article-grid">
                @forelse ($ebooks as $article)
                    @php
                        $tahun = $article->year ?? (isset($article->created_at) ? date('Y', strtotime($article->created_at)) : null);
                        $penulis = $article->student_name ?? ($article->user->name ?? null);
                        $jenisKoleksi = 'E-Article';
                    @endphp

                    <div class="article-card">
                        <div class="article-thumb">
                            <span class="badge-status {{ $article->status == 'Approved' ? 'badge-available' : 'badge-pending' }}">
                                {{ $article->status == 'Approved' ? 'TERSEDIA' : strtoupper($article->status) }}
                            </span>
                            @if ($article->cover_image && file_exists(public_path('storage/' . $article->cover_image)))
                                <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                            @else
                                <img src="https://via.placeholder.com/500x300?text=E-Article" alt="Cover">
                            @endif
                        </div>

                        <div class="article-info">
                            <!-- Metadata -->
                            <div class="article-meta">
                                @if ($tahun)
                                    <span><i class="far fa-calendar-alt"></i> {{ $tahun }}</span>
                                @endif
                                <span><i class="fas fa-tag"></i> {{ $jenisKoleksi }}</span>
                            </div>

                            <div class="article-cat">{{ $article->category->name ?? 'Jurnal Ilmiah' }}</div>
                            <h4 class="article-title">{{ $article->title }}</h4>

                            @if ($penulis)
                                <p class="article-author"><i class="far fa-user"></i> {{ $penulis }}</p>
                            @else
                                <p class="article-author"><i class="far fa-user"></i> Penulis tidak diketahui</p>
                            @endif

                            <!-- Tombol Aksi -->
                            <div class="article-footer">
                                <div class="btn-actions-group">
                                    <a href="{{ route('final_project.detail', $article->id) }}" class="btn-outline-read">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    @if ($article->file_url)
                                        @php
                                            $fileUrl = asset('storage/' . $article->file_url);
                                            $ext = strtolower(pathinfo($article->file_url, PATHINFO_EXTENSION));
                                            $isWord = in_array($ext, ['doc', 'docx']);
                                            $bacaUrl = $isWord
                                                ? 'https://docs.google.com/viewer?url=' . urlencode($fileUrl)
                                                : $fileUrl;
                                        @endphp
                                        <a href="{{ $bacaUrl }}" target="_blank" class="btn-read">
                                            <i class="fas fa-book"></i> Baca
                                        </a>
                                        <a href="{{ asset('storage/' . $article->file_url) }}" download class="btn-outline-read">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @else
                                        <span class="btn-read" style="opacity: 0.5; cursor: not-allowed;">
                                            Tidak tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px 20px; color: var(--text-muted);">
                        @if (isset($noCategoryMessage) && $noCategoryMessage)
                            {!! $noCategoryMessage !!}
                        @elseif (request('search'))
                            Tidak ada hasil untuk pencarian "{{ request('search') }}"
                        @else
                            Tidak ada koleksi E-Article yang ditemukan
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- ===== PAGINATION ===== -->
            @if (method_exists($ebooks, 'links'))
                <div class="pagination">
                    {{ $ebooks->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </main>
    </div>
@endsection

@push('scripts')
    <script>
        // Submit form otomatis saat select berubah (untuk filter & sort)
        document.querySelectorAll('.filter-item select').forEach(function(select) {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    </script>
@endpush
