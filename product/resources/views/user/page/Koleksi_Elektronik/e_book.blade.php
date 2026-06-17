@extends('user.component.master')

@section('title', 'E-BOOK KOLEKSI - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
    <style>
        /* ============================================
           CSS KHUSUS HALAMAN E-BOOK (GAYA KLASIK HIJAU)
           Tidak mengganggu master layout
           + Perbaikan tampilan card agar lebih informatif
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

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 25px;
        }

        .book-card {
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

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(15, 74, 49, 0.12);
        }

        .book-thumb {
            height: 200px;
            position: relative;
            background: #f0f7f3;
            overflow: hidden;
        }

        .book-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-status {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--success);
            color: white;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 800;
        }

        .badge-available {
            background-color: #2daa6e;
            color: white;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .book-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        /* Metadata tambahan (tahun, jenis) */
        .book-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 8px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .book-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0f7f3;
            padding: 3px 10px;
            border-radius: 40px;
        }

        .book-meta i {
            font-size: 0.65rem;
            color: var(--primary-color);
        }

        .book-cat {
            font-size: 0.75rem;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .book-title {
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

        .book-author {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .book-author i {
            color: var(--primary-color);
            width: 16px;
        }

        .book-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
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

        /* === TOMBOL SERAGAM DENGAN E-ARTICLE === */
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
    </style>
@endpush

@section('content')
    <div class="main-container">

        <!-- Sidebar -->
        <aside class="sidebar">
            <h3 class="sidebar-title">Katalog Digital</h3>
            <ul class="side-menu">
                <li><a href="{{ route('final_project.koleksi', 'ebook') }}" {{ request()->route('category') == 'ebook' ? 'class=active' : '' }}><i class="fas fa-book"></i> E-book</a></li>
                <li><a href="{{ route('final_project.koleksi', 'e-article') }}" {{ request()->route('category') == 'e-article' ? 'class=active' : '' }}><i class="fas fa-file-alt"></i> E-Article</a></li>
                <li><a href="{{ route('final_project.koleksi', 'cd') }}" {{ request()->route('category') == 'cd' ? 'class=active' : '' }}><i class="fas fa-compact-disc"></i> CD</a></li>
                <li><a href="{{ route('final_project.koleksi', 'video') }}" {{ request()->route('category') == 'video' ? 'class=active' : '' }}><i class="fas fa-video"></i> Video</a></li>
                <li><a href="{{ route('final_project.kti') }}" {{ request()->route('category') == 'kti' ? 'class=active' : '' }}><i class="fas fa-chart-line"></i> KTI</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="content-section">
            <div class="page-header">
                <span>Koleksi Elektronik</span>
                <h2>Koleksi E-Book Keperawatan</h2>
                <p>Akses berbagai referensi medis dan keperawatan digital berkualitas tinggi.</p>
            </div>

            <!-- Form Search & Filter (server-side) -->
            <form method="GET" action="{{ route('final_project.koleksi', 'ebook') }}" class="filter-row">
                <div class="filter-item">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku...">
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

            <!-- Book Grid -->
            <div class="book-grid">
                @forelse($ebooks as $book)
                    @php
                        // Tentukan tahun terbit (prioritas year, fallback ke created_at)
                        $tahun = $book->year ?? (isset($book->created_at) ? date('Y', strtotime($book->created_at)) : null);
                        // Nama penulis yang lebih informatif
                        $penulis = $book->student_name ?? ($book->user->name ?? null);
                        // Jenis koleksi (selalu Ebook untuk halaman ini, namun bisa dinamis jika diperlukan)
                        $jenisKoleksi = 'Ebook';
                    @endphp
                    <div class="book-card">
                        <div class="book-thumb">
                            <span class="badge-status {{ $book->status == 'Approved' ? 'badge-available' : 'badge-pending' }}">
                                {{ $book->status == 'Approved' ? 'TERSEDIA' : strtoupper($book->status) }}
                            </span>
                            @if($book->cover_image && file_exists(public_path('storage/' . $book->cover_image)))
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                            @else
                                <img src="https://via.placeholder.com/300x400?text=No+Cover" alt="Cover">
                            @endif
                        </div>
                        <div class="book-info">
                            <!-- Metadata: Tahun & Jenis Koleksi (seperti contoh gambar) -->
                            <div class="book-meta">
                                @if($tahun)
                                    <span><i class="far fa-calendar-alt"></i> {{ $tahun }}</span>
                                @endif
                                <span><i class="fas fa-tag"></i> {{ $jenisKoleksi }}</span>
                            </div>

                            <h4 class="book-title">{{ $book->title }}</h4>

                            <!-- Penulis (jika ada) -->
                            @if($penulis)
                                <p class="book-author"><i class="far fa-user"></i> {{ $penulis }}</p>
                            @else
                                <p class="book-author"><i class="far fa-user"></i> Penulis tidak diketahui</p>
                            @endif

                            <!-- Tombol Aksi -->
                            <div class="book-footer">
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <!-- Detail (outline) -->
                                    <a href="{{ route('final_project.detail', $book->id) }}" class="btn-outline-read">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    <!-- Baca (solid) -->
                                    @if($book->file_url)
                                        @php
                                            $fileUrl  = asset('storage/' . $book->file_url);
                                            $ext      = strtolower(pathinfo($book->file_url, PATHINFO_EXTENSION));
                                            $isWord   = in_array($ext, ['doc', 'docx']);
                                            $bacaUrl  = $isWord
                                                ? 'https://docs.google.com/viewer?url=' . urlencode($fileUrl)
                                                : $fileUrl;
                                        @endphp
                                        <a href="{{ $bacaUrl }}" target="_blank" class="btn-read">
                                            <i class="fas fa-book"></i> Baca
                                        </a>
                                        <!-- Download (outline) -->
                                        <a href="{{ asset('storage/' . $book->file_url) }}" download class="btn-outline-read">
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
                            Tidak ada koleksi E‑Book yang ditemukan
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
