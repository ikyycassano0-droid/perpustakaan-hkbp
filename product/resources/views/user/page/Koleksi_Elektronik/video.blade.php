@extends('user.component.master')

@section('title', 'Video Tutorial & Simulasi Klinis - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS HALAMAN VIDEO (GAYA KLASIK HIJAU)
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
        width: 260px;
        flex-shrink: 0;
        background: var(--card-bg);
        padding: 25px 15px;
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
        margin-bottom: 20px;
        padding-left: 15px;
    }

    .side-menu {
        list-style: none;
    }

    .side-menu li a {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 18px;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-muted);
        border-radius: 10px;
        transition: 0.3s;
        margin-bottom: 5px;
        text-decoration: none;
    }

    .side-menu li a i {
        width: 20px;
        text-align: center;
    }

    .side-menu li a:hover {
        background-color: #f0f7f3;
        color: var(--primary-color);
    }

    .side-menu li a.active {
        background-color: #e0f0e8;
        color: var(--primary-color);
        border-left: 4px solid var(--primary-color);
        border-radius: 4px 12px 12px 4px;
    }

    .content-area {
        flex-grow: 1;
    }

    .portal-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .portal-title h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--text-dark);
    }

    .portal-title p {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .badge-akreditasi {
        background: #e0f0e8;
        color: var(--primary-color);
        padding: 6px 15px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 15px;
        margin-bottom: 30px;
    }

    .filter-input {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        padding: 0 15px;
        transition: 0.3s;
    }

    .filter-input:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(26, 107, 71, 0.1);
    }

    .filter-input i {
        color: var(--text-muted);
        margin-right: 10px;
    }

    .filter-input input,
    .filter-input select {
        border: none;
        padding: 12px 0;
        outline: none;
        width: 100%;
        font-size: 0.9rem;
        background: transparent;
        color: var(--text-dark);
    }

    /* Featured Video */
    .featured-video {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        background: #000;
        height: 400px;
        margin-bottom: 40px;
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
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
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
    }

    .btn-play-now {
        background: #2daa6e;
        color: white;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
        transition: 0.3s;
        text-decoration: none;
    }

    .btn-play-now:hover {
        background: var(--primary-color);
        transform: translateY(-2px);
    }

    /* Video Grid */
    .video-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .v-card {
        background: var(--card-bg);
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
        transition: 0.3s;
        display: flex;
        flex-direction: column;
    }

    .v-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(15, 74, 49, 0.12);
    }

    .v-thumb {
        height: 180px;
        position: relative;
        background: #f0f7f3;
        overflow: hidden;
    }

    .v-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .v-duration {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
    }

    .v-info {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .v-cat {
        font-size: 0.75rem;
        color: var(--primary-color);
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .v-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 12px;
        line-height: 1.4;
        height: 2.8rem;
        overflow: hidden;
    }

    .v-author {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 15px;
    }

    .v-footer {
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    /* Tombol seragam */
    .btn-read {
        background: var(--primary-color);
        color: white;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: 0.3s;
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
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: 0.3s;
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
    .pagination .page-item { list-style: none; }
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
        .sidebar,
        .featured-video {
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
            <li><a href="{{ route('final_project.koleksi', 'ebook') }}" class="active"><i class="fas fa-book"></i> E-book</a></li>
            <li><a href="{{ route('final_project.koleksi', 'e-article') }}"><i class="fas fa-file-alt"></i> E-Article</a></li>
            <li><a href="{{ route('final_project.koleksi', 'cd') }}"><i class="fas fa-compact-disc"></i> CD</a></li>
            <li><a href="{{ route('final_project.koleksi', 'video') }}"><i class="fas fa-video"></i> Video</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="content-area">
        <div class="portal-top">
            <div class="portal-title">
                <h2>Tutorial & Simulasi Klinis</h2>
                <p>Pusat pembelajaran visual untuk penguasaan prosedur keperawatan berstandar medis.</p>
            </div>
            <div class="badge-akreditasi"><i class="fas fa-check-circle"></i> AKREDITASI UNGGUL</div>
        </div>

        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('guest.koleksi_elektronik.video') }}" class="filter-row">
            <div class="filter-input">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari prosedur atau topik simulasi...">
            </div>
            <div class="filter-input">
                <select name="category">
                    <option value="">Semua Kategori</option>
                    {{-- Gunakan $filterCategories dari controller --}}
                    @foreach($filterCategories as $cat)
                        <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-input">
                <select name="sort">
                    <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Terbaru</option>
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                </select>
            </div>
        </form>

        <!-- Featured Video (item pertama) -->
        @if(isset($videos) && $videos->count() > 0)
            @php $featured = $videos->first(); @endphp
            <div class="featured-video">
                @if($featured->cover_image && file_exists(public_path('storage/' . $featured->cover_image)))
                    <img src="{{ asset('storage/' . $featured->cover_image) }}" alt="{{ $featured->title }}">
                @else
                    <img src="https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=1200&q=80" alt="Featured">
                @endif
                <div class="featured-video-info">
                    <span style="background: #f1c40f; color: var(--primary-color); padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:800;">VIDEO TERBARU</span>
                    <h3>{{ $featured->title }}</h3>
                    <p>{{ Str::limit($featured->abstract ?? 'Tidak ada deskripsi', 100) }}</p>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="{{ route('final_project.detail', $featured->id) }}" class="btn-play-now" style="margin-top:0;">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                        @if($featured->file_url)
                            @php
                                $featExt = strtolower(pathinfo($featured->file_url, PATHINFO_EXTENSION));
                                $videoExts = ['mp4', 'webm', 'ogg', 'mov'];
                            @endphp
                            @if(in_array($featExt, $videoExts))
                                <a href="{{ asset('storage/' . $featured->file_url) }}" target="_blank"
                                style="margin-top:0; background: var(--accent-yellow); color: var(--primary-color); padding: 12px 25px; border-radius: 50px; font-weight: 700; display: inline-flex; align-items: center; gap: 10px; text-decoration: none; transition: 0.3s;"
                                onmouseover="this.style.background='#fff'; this.style.transform='translateY(-2px)';"
                                onmouseout="this.style.background='var(--accent-yellow)'; this.style.transform='translateY(0)';">
                                    <i class="fas fa-play"></i> Putar
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Video Grid -->
        <div class="video-grid">
            @forelse($videos as $video)
                <div class="v-card">
                    <div class="v-thumb">
                        @if($video->cover_image && file_exists(public_path('storage/' . $video->cover_image)))
                            <img src="{{ asset('storage/' . $video->cover_image) }}" alt="{{ $video->title }}">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=Video+Thumb" alt="Thumb">
                        @endif
                        @if($video->file_url)
                            <span class="v-duration">
                                {{ strtoupper(pathinfo($video->file_url, PATHINFO_EXTENSION)) }}
                            </span>
                        @endif
                    </div>
                    <div class="v-info">
                        <span class="v-cat">{{ $video->category->name ?? 'Keperawatan' }}</span>
                        <h4 class="v-title">{{ Str::limit($video->title, 50) }}</h4>
                        <p class="v-author"><i class="far fa-user"></i> {{ $video->student_name ?? ($video->user->name ?? 'Administrator') }}</p>
                        <div class="v-footer">
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('final_project.detail', $video->id) }}" class="btn-outline-read">
                                    <i class="fas fa-info-circle"></i> Detail
                                </a>
                                {{-- Tombol Putar (jika file video) --}}
                                @if($video->file_url)
                                    @php
                                        $fileExt = strtolower(pathinfo($video->file_url, PATHINFO_EXTENSION));
                                        $videoExts = ['mp4', 'webm', 'ogg', 'mov'];
                                    @endphp
                                    @if(in_array($fileExt, $videoExts))
                                        <a href="{{ asset('storage/' . $video->file_url) }}" target="_blank" class="btn-outline-read">
                                            ▶ Putar
                                        </a>
                                    @endif
                                @endif
                                {{-- Tombol Download (harus login) --}}
                                @if($video->file_url)
                                    <a href="{{ asset('storage/' . $video->file_url) }}" download class="btn-outline-read">
                                        ⬇️ Download
                                    </a>
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
                        Tidak ada koleksi Video yang ditemukan
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($videos, 'links') && $videos->hasPages())
            <div class="pagination">
                {{ $videos->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.filter-input select').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endpush
