@extends('user.component.master')

@section('title', 'CD & DVD Koleksi - Perpustakaan Sekolah Keperawatan HKBP')

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
               FEATURED ROW
            ============================================================ */
        .featured-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }

        .featured-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--accent-yellow);
        }

        .featured-info {
            flex: 1;
        }

        .featured-info .featured-tag {
            background: var(--accent-yellow);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.6rem;
            font-weight: 800;
            display: inline-block;
            margin-bottom: 15px;
        }

        .featured-info h3 {
            font-size: 1.4rem;
            color: var(--primary-color);
            font-weight: 800;
            margin-bottom: 10px;
        }

        .featured-info p {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .meta-boxes {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .meta-item {
            background: #f8fbf9;
            padding: 10px 18px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .meta-item span {
            display: block;
            font-size: 0.65rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
        }

        .meta-item strong {
            font-size: 0.9rem;
            color: var(--primary-color);
        }

        .featured-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .featured-media {
            width: 200px;
            height: 150px;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
            background: var(--deep-green);
        }

        .featured-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .featured-media .play-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.3);
        }

        .featured-media .play-overlay i {
            font-size: 2.5rem;
            color: white;
            opacity: 0.8;
        }

        .help-card {
            background: var(--deep-green);
            border-radius: 20px;
            padding: 30px;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.15);
            border-top: 4px solid var(--accent-yellow);
        }

        .help-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--accent-yellow);
        }

        .help-card h3 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .help-card p {
            font-size: 0.85rem;
            opacity: 0.85;
            margin-bottom: 15px;
        }

        .btn-help {
            background: white;
            color: var(--primary-color);
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 50px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-help:hover {
            background: var(--accent-yellow);
            transform: translateY(-2px);
        }

        /* ============================================================
               CD GRID
            ============================================================ */
        .cd-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .cd-card {
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

        .cd-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(15, 74, 49, 0.12);
        }

        .cd-thumb {
            height: 180px;
            position: relative;
            background: #f0f7f3;
            overflow: hidden;
        }

        .cd-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ============================================================
               BADGE STATUS
            ============================================================ */
        .badge-status {
            position: absolute;
            bottom: 12px;
            left: 12px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 800;
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
               CD INFO
            ============================================================ */
        .cd-body {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .cd-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 10px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .cd-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0f7f3;
            padding: 3px 10px;
            border-radius: 40px;
        }

        .cd-meta i {
            font-size: 0.65rem;
            color: var(--primary-color);
        }

        .cd-cat {
            font-size: 0.75rem;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cd-title {
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

        .cd-author {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .cd-author i {
            color: var(--primary-color);
            width: 16px;
        }

        /* ============================================================
               CD FOOTER & BUTTONS
            ============================================================ */
        .cd-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-start;
            gap: 8px;
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

            .featured-row {
                grid-template-columns: 1fr;
            }

            .featured-card {
                flex-direction: column;
                text-align: center;
            }

            .featured-media {
                width: 100%;
                height: 200px;
            }

            .meta-boxes {
                justify-content: center;
            }

            .featured-actions {
                justify-content: center;
            }
        }

        @media (max-width: 640px) {
            .cd-grid {
                grid-template-columns: 1fr;
            }

            .cd-thumb {
                height: 180px;
            }

            .page-header h2 {
                font-size: 1.5rem;
            }

            .cd-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .cd-footer .btn-read,
            .cd-footer .btn-outline-read {
                justify-content: center;
            }

            .btn-actions-group {
                justify-content: center;
            }

            .help-card {
                padding: 20px;
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
                <span>Media Pembelajaran Klinis</span>
                <h2>CD & DVD Koleksi Digital</h2>
                <p>Akses berbagai media pembelajaran interaktif untuk mendukung praktik klinis Anda.</p>
            </div>

            <!-- ===== FILTER ROW ===== -->
            <form method="GET" action="{{ route('final_project.koleksi', 'cd') }}" class="filter-row">
                <div class="filter-item">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari CD, topik, atau media pembelajaran...">
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

            <!-- ===== FEATURED & HELP ===== -->
            @if (isset($data) && $data->count() > 0)
                @php $featured = $data->first(); @endphp
                <div class="featured-row">
                    <div class="featured-card">
                        <div class="featured-info">
                            <span class="featured-tag">KOLEKSI TERBARU</span>
                            <h3>{{ $featured->title }}</h3>
                            <p>{{ Str::limit($featured->abstract ?? 'Deskripsi tidak tersedia.', 150) }}</p>
                            <div class="meta-boxes">
                                <div class="meta-item">
                                    <span>KATEGORI</span>
                                    <strong>{{ $featured->category->name ?? 'Umum' }}</strong>
                                </div>
                                @if ($featured->year)
                                    <div class="meta-item">
                                        <span>TAHUN</span>
                                        <strong>{{ $featured->year }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="featured-actions">
                                <a href="{{ route('final_project.detail', $featured->id) }}" class="btn-outline-read">
                                    <i class="fas fa-info-circle"></i> Detail
                                </a>
                                @if ($featured->file_url)
                                    <a href="{{ asset('storage/' . $featured->file_url) }}" target="_blank" class="btn-read">
                                        <i class="fas fa-play-circle"></i> Akses
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="featured-media">
                            @if ($featured->cover_image && file_exists(public_path('storage/' . $featured->cover_image)))
                                <img src="{{ asset('storage/' . $featured->cover_image) }}" alt="{{ $featured->title }}">
                            @else
                                <img src="https://via.placeholder.com/400x300/0f4a31/ffffff?text=CD+Cover" alt="Cover">
                            @endif
                            <div class="play-overlay">
                                <i class="fas fa-play-circle"></i>
                            </div>
                        </div>
                    </div>

                    <div class="help-card">
                        <i class="fas fa-headphones"></i>
                        <h3>Butuh Bantuan Media?</h3>
                        <p>Hubungi petugas multimedia kami untuk bantuan pemutaran CD.</p>
                        <button class="btn-help" onclick="alert('Hubungi pustakawan di (0632) 12345')">
                            Hubungi Pustakawan
                        </button>
                    </div>
                </div>
            @endif

            <!-- ===== CD GRID ===== -->
            <div class="cd-grid">
                @forelse ($data ?? [] as $item)
                    @php
                        $tahun = $item->year ?? (isset($item->created_at) ? date('Y', strtotime($item->created_at)) : null);
                        $penulis = $item->student_name ?? ($item->user->name ?? null);
                        $jenisKoleksi = 'CD';
                    @endphp

                    <div class="cd-card">
                        <div class="cd-thumb">
                            <span class="badge-status {{ $item->status == 'Approved' ? 'badge-available' : 'badge-pending' }}">
                                {{ $item->status == 'Approved' ? 'TERSEDIA' : strtoupper($item->status) }}
                            </span>
                            @if ($item->cover_image && file_exists(public_path('storage/' . $item->cover_image)))
                                <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}">
                            @else
                                <img src="https://via.placeholder.com/300x180?text=CD+Cover" alt="Cover">
                            @endif
                        </div>

                        <div class="cd-body">
                            <!-- Metadata -->
                            <div class="cd-meta">
                                @if ($tahun)
                                    <span><i class="far fa-calendar-alt"></i> {{ $tahun }}</span>
                                @endif
                                <span><i class="fas fa-tag"></i> {{ $jenisKoleksi }}</span>
                            </div>

                            <div class="cd-cat">{{ $item->category->name ?? 'Koleksi CD' }}</div>
                            <h4 class="cd-title">{{ $item->title }}</h4>

                            @if ($penulis)
                                <div class="cd-author"><i class="far fa-user"></i> {{ $penulis }}</div>
                            @else
                                <div class="cd-author"><i class="far fa-user"></i> Penulis tidak diketahui</div>
                            @endif

                            <!-- Tombol Aksi -->
                            <div class="cd-footer">
                                <div class="btn-actions-group">
                                    <a href="{{ route('final_project.detail', $item->id) }}" class="btn-outline-read">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    @if ($item->file_url)
                                        <a href="{{ asset('storage/' . $item->file_url) }}" target="_blank" class="btn-read">
                                            <i class="fas fa-play-circle"></i> Akses
                                        </a>
                                        <a href="{{ route('final_project.download', $item->id) }}" class="btn-outline-read">
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
                            Tidak ada koleksi CD/DVD yang ditemukan
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- ===== PAGINATION ===== -->
            @if (isset($data) && method_exists($data, 'links'))
                <div class="pagination">
                    {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
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
