{{-- resources/views/guest/page/koleksi/e-article.blade.php --}}
@extends('guest.component.master')

@section('title', 'E-Article & Jurnal - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
    <style>
        /* ============================================
           CSS KHUSUS HALAMAN E-ARTICLE GUEST
           + Penambahan metadata & perapian card seperti versi lain
        ============================================ */

        .main-container {
            display: flex;
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
            gap: 30px;
            align-items: flex-start;
        }

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

        .filter-container {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            overflow-x: auto;
            padding-bottom: 5px;
        }

        .chip {
            padding: 8px 18px;
            background: var(--card-bg);
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: 0.3s;
            border: 1px solid var(--border-color);
            white-space: nowrap;
            text-decoration: none;
            display: inline-block;
        }

        .chip.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .chip:hover:not(.active) {
            background: #f0f7f3;
            border-color: var(--accent-green);
            color: var(--primary-color);
        }

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
            border-top: 4px solid #f1c40f;
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

        .badge-status {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #2daa6e;
            color: white;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            z-index: 2;
        }

        .article-info {
            padding: 18px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        /* Metadata tambahan (tahun, jenis) - SAMA DENGAN VERSI LAIN */
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
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .article-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
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
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .article-author i {
            color: var(--primary-color);
            width: 16px;
        }

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

        @media (max-width: 1024px) {
            .sidebar {
                display: none;
            }

            .filter-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-container">

        <!-- Sidebar -->
        <aside class="sidebar">
            <h3 class="sidebar-title">Katalog Digital</h3>
            <ul class="side-menu">
                <li><a href="{{ route('guest.koleksi_elektronik.ebook') }}"><i class="fas fa-book"></i> E-book</a></li>
                <li><a href="{{ route('guest.koleksi_elektronik.earticle') }}" class="active"><i class="fas fa-file-alt"></i> E-Article</a></li>
                <li><a href="{{ route('guest.koleksi_elektronik.cd') }}"><i class="fas fa-compact-disc"></i> CD</a></li>
                <li><a href="{{ route('guest.koleksi_elektronik.video') }}"><i class="fas fa-video"></i> Video</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="content-section">
            <div class="page-header">
                <span>Portal Jurnal & Riset</span>
                <h2>E-Article & Jurnal Riset</h2>
                <p>Akses koleksi artikel ilmiah, jurnal nasional, dan internasional untuk mendukung literasi klinis Anda.</p>
            </div>

            <!-- Form Search & Filter (server-side) -->
            <form method="GET" action="{{ route('guest.koleksi_elektronik.earticle') }}" class="filter-row">
                <div class="filter-item">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel, jurnal, atau kata kunci riset...">
                </div>
                <div class="filter-item">
                    <select name="category">
                        <option value="">Semua Kategori</option>
                        @foreach($filterCategories as $cat)
                            <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
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

            <!-- Article Grid -->
            <div class="article-grid">
                @forelse($ebooks as $article)
                    @php
                        // Tentukan tahun (prioritas year, fallback ke created_at)
                        $tahun = $article->year ?? (isset($article->created_at) ? date('Y', strtotime($article->created_at)) : null);
                        // Nama penulis
                        $penulis = $article->student_name ?? ($article->user->name ?? null);
                        // Jenis koleksi
                        $jenisKoleksi = 'E-Article';
                    @endphp
                    <div class="article-card">
                        <div class="article-thumb">
                            <span class="badge-status">TERSEDIA</span>
                            @if($article->cover_image && file_exists(public_path('storage/' . $article->cover_image)))
                                <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                            @else
                                <img src="https://via.placeholder.com/500x300?text=No+Cover" alt="Cover">
                            @endif
                        </div>
                        <div class="article-info">
                            <!-- Metadata: Tahun & Jenis -->
                            <div class="article-meta">
                                @if($tahun)
                                    <span><i class="far fa-calendar-alt"></i> {{ $tahun }}</span>
                                @endif
                                <span><i class="fas fa-tag"></i> {{ $jenisKoleksi }}</span>
                            </div>

                            <span class="article-cat">{{ $article->category->name ?? 'Jurnal Ilmiah' }}</span>
                            <h4 class="article-title">{{ $article->title }}</h4>

                            @if($penulis)
                                <p class="article-author"><i class="far fa-user"></i> {{ $penulis }}</p>
                            @else
                                <p class="article-author"><i class="far fa-user"></i> Penulis tidak diketahui</p>
                            @endif

                            <!-- Tombol Aksi (Detail + Baca + Download) -->
                            <div class="article-footer">
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('final_project.detail', $article->id) }}" class="btn-outline-read">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    {{-- Tombol Baca --}}
                                    @if($article->file_url)
                                        @php
                                            $fileUrl  = asset('storage/' . $article->file_url);
                                            $ext      = strtolower(pathinfo($article->file_url, PATHINFO_EXTENSION));
                                            $isWord   = in_array($ext, ['doc', 'docx']);
                                            $bacaUrl  = $isWord
                                                ? 'https://docs.google.com/viewer?url=' . urlencode($fileUrl)
                                                : $fileUrl;
                                        @endphp
                                        <a href="{{ $bacaUrl }}" target="_blank" class="btn-read">
                                            <i class="fas fa-book"></i> Baca
                                        </a>
                                        {{-- Tombol Download --}}
                                        <a href="{{ route('final_project.download', $article->id) }}" class="btn-outline-read">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @else
                                        <span class="btn-read" style="opacity:0.5;">Tidak tersedia</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-gray-500">
                        @if(isset($noCategoryMessage) && $noCategoryMessage)
                            {!! $noCategoryMessage !!}
                        @elseif(request('search'))
                            Tidak ada hasil untuk pencarian "{{ request('search') }}"
                        @else
                            Tidak ada koleksi E-Article yang ditemukan
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(method_exists($ebooks, 'links'))
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
        document.querySelectorAll('.filter-item select').forEach(select => {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    </script>
@endpush
