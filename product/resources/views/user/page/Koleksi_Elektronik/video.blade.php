@extends('user.component.master')

@section('title', 'Video Tutorial & Simulasi Klinis - Perpustakaan Sekolah Keperawatan HKBP')

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
               FEATURED VIDEO
            ============================================================ */
        .featured-video {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: #000;
            height: 380px;
            margin-bottom: 40px;
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--accent-yellow);
        }

        .featured-video img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.6;
        }

        .featured-video-info {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 35px;
            color: white;
            width: 100%;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.85));
        }

        .featured-video-info .featured-tag {
            background: var(--accent-yellow);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 800;
            display: inline-block;
            margin-bottom: 10px;
        }

        .featured-video-info h3 {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .featured-video-info p {
            font-size: 0.9rem;
            opacity: 0.85;
            margin-bottom: 15px;
            max-width: 600px;
        }

        .featured-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ============================================================
               VIDEO GRID
            ============================================================ */
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .video-card {
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

        .video-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(15, 74, 49, 0.12);
        }

        .video-thumb {
            height: 180px;
            position: relative;
            background: #f0f7f3;
            overflow: hidden;
        }

        .video-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-duration {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 2px 10px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
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
               VIDEO INFO
            ============================================================ */
        .video-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .video-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 10px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .video-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0f7f3;
            padding: 3px 10px;
            border-radius: 40px;
        }

        .video-meta i {
            font-size: 0.65rem;
            color: var(--primary-color);
        }

        .video-cat {
            font-size: 0.75rem;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .video-title {
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

        .video-author {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .video-author i {
            color: var(--primary-color);
            width: 16px;
        }

        /* ============================================================
               VIDEO FOOTER & BUTTONS
            ============================================================ */
        .video-footer {
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

        .btn-play-now {
            background: var(--accent-yellow);
            color: var(--primary-color);
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-play-now:hover {
            background: #ffffff;
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

            .featured-video {
                height: 280px;
            }

            .featured-video-info h3 {
                font-size: 1.2rem;
            }

            .featured-video-info p {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 640px) {
            .video-grid {
                grid-template-columns: 1fr;
            }

            .video-thumb {
                height: 180px;
            }

            .page-header h2 {
                font-size: 1.5rem;
            }

            .featured-video {
                height: 220px;
            }

            .featured-video-info {
                padding: 20px;
            }

            .featured-video-info h3 {
                font-size: 1rem;
            }

            .video-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .video-footer .btn-read,
            .video-footer .btn-outline-read {
                justify-content: center;
            }

            .btn-actions-group {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .featured-video {
                height: 180px;
            }

            .featured-video-info {
                padding: 15px;
            }

            .featured-video-info h3 {
                font-size: 0.9rem;
            }

            .featured-video-info p {
                display: none;
            }

            .featured-actions .btn-play-now {
                padding: 8px 16px;
                font-size: 0.8rem;
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
                <span>Tutorial & Simulasi Klinis</span>
                <h2>Tutorial & Simulasi Klinis</h2>
                <p>Pusat pembelajaran visual untuk penguasaan prosedur keperawatan berstandar medis.</p>
            </div>

            <!-- ===== FILTER ROW ===== -->
            <form method="GET" action="{{ route('final_project.koleksi', 'video') }}" class="filter-row">
                <div class="filter-item">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari prosedur atau topik simulasi...">
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

            <!-- ===== FEATURED VIDEO ===== -->
            @if (isset($videos) && $videos->count() > 0)
                @php $featured = $videos->first(); @endphp
                <div class="featured-video">
                    @if ($featured->cover_image && file_exists(public_path('storage/' . $featured->cover_image)))
                        <img src="{{ asset('storage/' . $featured->cover_image) }}" alt="{{ $featured->title }}">
                    @else
                        <img src="https://via.placeholder.com/1200x400/1a6b47/ffffff?text=Video+Featured" alt="Featured">
                    @endif
                    <div class="featured-video-info">
                        <span class="featured-tag">VIDEO TERBARU</span>
                        <h3>{{ $featured->title }}</h3>
                        <p>{{ Str::limit($featured->abstract ?? 'Deskripsi tidak tersedia.', 120) }}</p>
                        <div class="featured-actions">
                            <a href="{{ route('final_project.detail', $featured->id) }}" class="btn-outline-read" style="background: rgba(255,255,255,0.15); color: white; border-color: rgba(255,255,255,0.3);">
                                <i class="fas fa-info-circle"></i> Detail
                            </a>
                            @if ($featured->file_url)
                                @php
                                    $featExt = strtolower(pathinfo($featured->file_url, PATHINFO_EXTENSION));
                                    $videoExts = ['mp4', 'webm', 'ogg', 'mov', 'mkv'];
                                    $featuredFileUrl = asset('storage/' . $featured->file_url);
                                @endphp
                                @if (in_array($featExt, $videoExts))
                                    <a href="{{ $featuredFileUrl }}" target="_blank" class="btn-play-now">
                                        <i class="fas fa-play"></i> Putar
                                    </a>
                                @endif
                                <a href="{{ $featuredFileUrl }}" download class="btn-read" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4);">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- ===== VIDEO GRID ===== -->
            <div class="video-grid">
                @forelse ($videos as $video)
                    @php
                        $tahun = $video->year ?? (isset($video->created_at) ? date('Y', strtotime($video->created_at)) : null);
                        $penulis = $video->student_name ?? ($video->user->name ?? null);
                        $jenisKoleksi = 'Video';
                        $videoFileUrl = $video->file_url ? asset('storage/' . $video->file_url) : null;
                        $fileExt = $video->file_url ? strtolower(pathinfo($video->file_url, PATHINFO_EXTENSION)) : null;
                        $videoExts = ['mp4', 'webm', 'ogg', 'mov', 'mkv'];
                        $isVideoFile = $fileExt && in_array($fileExt, $videoExts);
                    @endphp

                    <div class="video-card">
                        <div class="video-thumb">
                            <span class="badge-status {{ $video->status == 'Approved' ? 'badge-available' : 'badge-pending' }}">
                                {{ $video->status == 'Approved' ? 'TERSEDIA' : strtoupper($video->status) }}
                            </span>
                            @if ($video->cover_image && file_exists(public_path('storage/' . $video->cover_image)))
                                <img src="{{ asset('storage/' . $video->cover_image) }}" alt="{{ $video->title }}">
                            @else
                                <img src="https://via.placeholder.com/300x180/0f4a31/ffffff?text=Video" alt="Thumb">
                            @endif
                            @if ($video->file_url)
                                <span class="video-duration">{{ strtoupper($fileExt) }}</span>
                            @endif
                        </div>

                        <div class="video-info">
                            <!-- Metadata -->
                            <div class="video-meta">
                                @if ($tahun)
                                    <span><i class="far fa-calendar-alt"></i> {{ $tahun }}</span>
                                @endif
                                <span><i class="fas fa-tag"></i> {{ $jenisKoleksi }}</span>
                            </div>

                            <div class="video-cat">{{ $video->category->name ?? 'Keperawatan' }}</div>
                            <h4 class="video-title">{{ $video->title }}</h4>

                            @if ($penulis)
                                <div class="video-author"><i class="far fa-user"></i> {{ $penulis }}</div>
                            @else
                                <div class="video-author"><i class="far fa-user"></i> Penulis tidak diketahui</div>
                            @endif

                            <!-- Tombol Aksi -->
                            <div class="video-footer">
                                <div class="btn-actions-group">
                                    <a href="{{ route('final_project.detail', $video->id) }}" class="btn-outline-read">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    @if ($isVideoFile)
                                        <a href="{{ $videoFileUrl }}" target="_blank" class="btn-read">
                                            <i class="fas fa-play"></i> Putar
                                        </a>
                                    @endif
                                    @if ($videoFileUrl)
                                        <a href="{{ $videoFileUrl }}" download class="btn-outline-read">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @else
                                        <span class="btn-outline-read" style="opacity: 0.5; cursor: not-allowed;">
                                            <i class="fas fa-download"></i> Tidak Tersedia
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
                            Tidak ada koleksi Video yang ditemukan
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- ===== PAGINATION ===== -->
            @if (method_exists($videos, 'links') && $videos->hasPages())
                <div class="pagination">
                    {{ $videos->appends(request()->query())->links('pagination::bootstrap-4') }}
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
