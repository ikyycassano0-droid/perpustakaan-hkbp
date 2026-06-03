{{-- resources/views/user/page/koleksi/video.blade.php --}}
@extends('user.component.master')

@section('title', 'Video Tutorial & Simulasi Klinis - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS HALAMAN VIDEO (GAYA KLASIK HIJAU)
       Tidak mengganggu master layout
    ============================================ */

    .main-container {
        display: flex;
        max-width: 1400px;
        margin: 40px auto;
        padding: 0 20px;
        gap: 30px;
        align-items: flex-start;
    }

    /* Sidebar */
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

    /* Content Area */
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

    /* Filter Row */
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

    /* Featured Grid */
    .featured-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
        margin-bottom: 40px;
    }

    .main-video {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        background: #000;
        height: 400px;
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
    }

    .main-video img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.6;
    }

    .main-video-info {
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

    .side-panels {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .panel-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 20px;
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
    }

    .panel-quiz a {
        background: var(--primary-color);
        color: white;
        padding: 10px;
        border-radius: 50px;
        display: block;
        text-align: center;
        font-weight: 700;
        transition: 0.3s;
        text-decoration: none;
    }

    .panel-quiz a:hover {
        background: var(--accent-green);
        transform: translateY(-2px);
    }

    .panel-live {
        background: var(--deep-green);
        color: white;
        position: relative;
        overflow: hidden;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: 20px;
        border-top: 4px solid #f1c40f;
    }

    .panel-live img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.3;
    }

    .panel-live div {
        z-index: 2;
    }

    /* Video Grid */
    .video-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 20px;
    }

    .v-card {
        background: var(--card-bg);
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
        transition: 0.3s;
    }

    .v-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(15, 74, 49, 0.12);
    }

    .v-thumb {
        height: 140px;
        position: relative;
        background: #f0f7f3;
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
    }

    .v-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
        height: 2.6rem;
        overflow: hidden;
    }

    .v-badge {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        display: inline-block;
    }

    .btn-load-more {
        display: block;
        margin: 40px auto;
        padding: 12px 40px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 50px;
        font-weight: 700;
        color: var(--primary-color);
        cursor: pointer;
        transition: 0.3s;
        text-align: center;
    }

    .btn-load-more:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Pagination */
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
        .sidebar,
        .featured-grid {
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
            <li><a href="{{ route('user.koleksi_elektronik.ebook') }}"><i class="fas fa-book"></i> E-book</a></li>
            <li><a href="{{ route('user.koleksi_elektronik.earticle') }}"><i class="fas fa-file-alt"></i> E-Article</a></li>
            <li><a href="{{ route('user.koleksi_elektronik.cd') }}"><i class="fas fa-compact-disc"></i> CD</a></li>
            <li><a href="{{ route('user.koleksi_elektronik.video') }}" class="active"><i class="fas fa-video"></i> Video</a></li>
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
        <form method="GET" action="{{ route('user.koleksi_elektronik.video') }}" class="filter-row">
            <div class="filter-input">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari prosedur atau topik simulasi...">
            </div>
            <div class="filter-input">
                <select name="category">
                    <option value="">Semua Kategori</option>
                    @php
                        $categories = collect($videos ?? [])->map(function($item) {
                            return $item->category->name ?? null;
                        })->unique()->filter();
                    @endphp
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
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

        <!-- Featured Section -->
        <div class="featured-grid">
            @php
                $featuredVideo = $videos && $videos->count() > 0 ? $videos->first() : null;
                $featuredTitle = $featuredVideo ? $featuredVideo->title : 'Teknik Pemasangan Infus pada Pasien Pediatrik';
                $featuredDesc = $featuredVideo ? ($featuredVideo->abstract ?? $featuredVideo->description) : 'Simulasi mendalam mengenai pendekatan klinis dan teknik akses vaskular pada anak.';
                $featuredCover = ($featuredVideo && $featuredVideo->cover_image) ? asset('storage/' . $featuredVideo->cover_image) : 'https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=1200&q=80';
                $featuredLink = $featuredVideo ? route('final_project.detail', $featuredVideo->id) : '#';
            @endphp
            <div class="main-video">
                <img src="{{ $featuredCover }}" alt="Featured Video">
                <div class="main-video-info">
                    <span style="background: #f1c40f; color: var(--primary-color); padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:800;">VIDEO UNGGULAN</span>
                    <h3>{{ $featuredTitle }}</h3>
                    <p>{{ $featuredDesc }}</p>
                    <a href="{{ $featuredLink }}" class="btn-play-now"><i class="fas fa-play"></i> Putar Sekarang</a>
                </div>
            </div>

            <div class="side-panels">
                <div class="panel-card panel-quiz">
                    <span style="color: var(--primary-color); font-weight:800; font-size:0.7rem;">KUIS KLINIS</span>
                    <h4>Uji Pemahaman Sterilisasi</h4>
                    <p>Selesaikan kuis interaktif setelah menonton modul simulasi.</p>
                    <a href="#">Mulai Kuis</a>
                </div>
                <div class="panel-live">
                    <img src="https://images.unsplash.com/photo-1579154235602-3c27f391d2f1?auto=format&fit=crop&w=500&q=80">
                    <div>
                        <h4>Siaran Langsung</h4>
                        <p style="font-size:0.75rem;">Akan datang: 24 Okt, 09:00 WIB</p>
                    </div>
                </div>
            </div>
        </div>

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
                        <span class="v-duration">
                            {{ $video->duration ?? '00:00' }}
                        </span>
                    </div>
                    <div class="v-info">
                        <h4 class="v-title">{{ Str::limit($video->title, 50) }}</h4>
                        <span class="v-badge" style="background:#e0f0e8; color:var(--primary-color);">
                            {{ $video->category->name ?? 'Keperawatan' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10 text-gray-500">Tidak ada video yang ditemukan</div>
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
    // Submit form saat select berubah (filter & sort)
    document.querySelectorAll('.filter-input select').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endpush
