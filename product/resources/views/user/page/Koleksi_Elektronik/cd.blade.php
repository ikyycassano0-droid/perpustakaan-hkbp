{{-- resources/views/user/page/koleksi_elektronik/cd.blade.php --}}
@extends('user.component.master')

@section('title', 'CD & DVD Koleksi - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS HALAMAN CD (GAYA KLASIK HIJAU)
       Tidak mengganggu master layout
    ============================================ */

    /* Layout Utama */
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
    .content-section {
        flex-grow: 1;
    }

    .portal-header {
        margin-bottom: 25px;
    }

    .badge-top {
        display: inline-block;
        background: #e0f0e8;
        color: var(--primary-color);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .portal-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        color: var(--text-dark);
        font-weight: 800;
        margin-bottom: 10px;
    }

    /* Filter Row */
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

    /* Category Chips */
    .filter-container {
        display: flex;
        gap: 12px;
        margin-bottom: 35px;
        flex-wrap: wrap;
    }

    .chip {
        padding: 10px 22px;
        background: var(--card-bg);
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-muted);
        cursor: pointer;
        border: 1px solid var(--border-color);
        transition: 0.3s;
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

    /* Featured Section */
    .featured-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
        margin-bottom: 40px;
    }

    .featured-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 35px;
        display: flex;
        align-items: center;
        gap: 30px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
    }

    .featured-info h3 {
        font-size: 1.6rem;
        color: var(--primary-color);
        font-weight: 800;
        margin-bottom: 15px;
    }

    .featured-info p {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .meta-boxes {
        display: flex;
        gap: 15px;
    }

    .meta-item {
        background: #f8fbf9;
        padding: 12px 20px;
        border-radius: 15px;
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

    .featured-media {
        width: 260px;
        height: 160px;
        border-radius: 20px;
        background: #0f4a31;
        overflow: hidden;
        position: relative;
        flex-shrink: 0;
    }

    .featured-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.7;
    }

    .play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    /* Help Card */
    .help-card {
        background: var(--deep-green);
        border-radius: 24px;
        padding: 30px;
        color: white;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: 0.3s;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.15);
    }

    .help-card i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #f1c40f;
    }

    .help-card h3 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        font-weight: 700;
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
        margin-top: 15px;
        transition: 0.3s;
    }

    .btn-help:hover {
        background: #f1c40f;
        color: var(--primary-color);
        transform: translateY(-2px);
    }

    /* CD Grid */
    .cd-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .cd-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(15, 74, 49, 0.05);
        transition: 0.3s;
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;
    }

    .cd-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(15, 74, 49, 0.12);
    }

    .cd-thumb {
        width: 100%;
        height: 180px;
        border-radius: 18px;
        background: #0f4a31;
        position: relative;
        overflow: hidden;
    }

    .cd-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.8;
    }

    .badge-status {
        position: absolute;
        bottom: 12px;
        left: 12px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 800;
    }

    .badge-status.available {
        background: #2daa6e;
        color: white;
    }

    .badge-status.used {
        background: #fee2e2;
        color: #991b1b;
    }

    .cd-body {
        padding: 15px 5px;
    }

    .cd-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-color);
        height: 2.8rem;
        overflow: hidden;
        margin-top: 5px;
    }

    .cd-footer {
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-link {
        color: var(--primary-color);
        font-weight: 800;
        font-size: 0.8rem;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }

    .detail-link:hover {
        color: var(--accent-green);
        gap: 8px;
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

    /* Responsive */
    @media (max-width: 1024px) {
        .sidebar,
        .featured-row {
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
            <li><a href="{{ route('user.koleksi_elektronik.cd') }}" class="active"><i class="fas fa-compact-disc"></i> CD</a></li>
            <li><a href="{{ route('user.koleksi_elektronik.video') }}"><i class="fas fa-video"></i> Video</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="content-section">
        <div class="portal-header">
            <div class="badge-top">Media Pembelajaran Klinis</div>
            <h2>CD & DVD Koleksi Digital</h2>
        </div>

        <!-- Form Search & Filter (server-side) -->
        <form method="GET" action="{{ route('user.koleksi_elektronik.cd') }}" class="filter-row">
            <div class="filter-item">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari CD, topik, atau media pembelajaran...">
            </div>
            <div class="filter-item">
                <select name="category">
                    <option value="">Semua Kategori</option>
                    @php
                        // Ambil kategori unik dari data yang sudah ada (field 'category' dari FinalProject? Tidak ada di model, bisa pakai 'category_final_project_id'?)
                        // Untuk sementara, kita tidak punya kategori dinamis, bisa di-hardcode atau kosong.
                        // Jika ingin menggunakan kategori dari category_final_project, kita perlu eager load.
                    @endphp
                </select>
            </div>
            <div class="filter-item">
                <select name="sort">
                    <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Terbaru</option>
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Populer</option>
                </select>
            </div>
        </form>

        <!-- Category Chips (opsional, bisa dikosongkan) -->
        <div class="filter-container">
            <a href="{{ route('user.koleksi_elektronik.cd', array_merge(request()->except('category'), ['category' => ''])) }}"
               class="chip active">Semua Koleksi</a>
        </div>

        <!-- Featured & Help Cards (mengambil data pertama dari koleksi jika ada) -->
        <div class="featured-row">
            @php
                $firstItem = isset($data) && $data->count() > 0 ? $data->first() : null;
                $featuredTitle = $firstItem ? $firstItem->title : 'Ensiklopedia Video: Patofisiologi Penyakit Menular';
                $featuredDesc = $firstItem ? $firstItem->abstract : 'Seri DVD yang membahas mekanisme seluler penyakit menular tropis dengan animasi medis tingkat tinggi.';
                $featuredDuration = '12 Jam'; // Jika tidak ada field duration, bisa hardcode
                $featuredFormat = $firstItem ? (pathinfo($firstItem->file_url, PATHINFO_EXTENSION) ?? 'DVD-HD') : 'DVD-HD';
                $featuredCover = ($firstItem && $firstItem->cover_image) ? asset('storage/' . $firstItem->cover_image) : 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?auto=format&fit=crop&w=500&q=80';
            @endphp
            <div class="featured-card">
                <div class="featured-info">
                    <span style="background: #f1c40f; color: var(--primary-color); padding:4px 12px; border-radius:50px; font-size:0.6rem; font-weight:800; margin-bottom:15px; display:inline-block;">KOLEKSI TERBARU</span>
                    <h3>{{ $featuredTitle }}</h3>
                    <p>{{ $featuredDesc }}</p>
                    <div class="meta-boxes">
                        <div class="meta-item"><span>DURASI</span><strong>{{ $featuredDuration }}</strong></div>
                        <div class="meta-item"><span>FORMAT</span><strong>{{ $featuredFormat }}</strong></div>
                    </div>
                </div>
                <div class="featured-media">
                    <img src="{{ $featuredCover }}" alt="Featured">
                    <div class="play-btn"><i class="fas fa-play"></i></div>
                </div>
            </div>

            <div class="help-card">
                <i class="fas fa-headphones"></i>
                <h3>Butuh Bantuan Media?</h3>
                <p>Hubungi petugas multimedia kami untuk bantuan pemutaran CD.</p>
                <button class="btn-help" onclick="alert('Hubungi pustakawan di (0632) 12345')">Hubungi Pustakawan</button>
            </div>
        </div>

        <!-- CD Grid -->
        <div class="cd-grid">
            @forelse($data ?? [] as $cd)
                <div class="cd-card">
                    <div class="cd-thumb">
                        @if($cd->cover_image && file_exists(public_path('storage/' . $cd->cover_image)))
                            <img src="{{ asset('storage/' . $cd->cover_image) }}" alt="{{ $cd->title }}">
                        @else
                            <img src="https://via.placeholder.com/300x180?text=CD+Cover" alt="Cover">
                        @endif
                        <span class="badge-status available">
                            TERSEDIA
                        </span>
                    </div>
                    <div class="cd-body">
                        <span style="font-size:0.7rem; font-weight:800; color:var(--text-muted);">
                            {{ $cd->category->name ?? 'Koleksi CD' }} • {{ $cd->created_at->format('Y') }}
                        </span>
                        <h4 class="cd-title">{{ $cd->title }}</h4>
                        <div class="cd-footer">
                            <span style="font-size:0.7rem; color:var(--text-muted);">FORMAT: {{ pathinfo($cd->file_url, PATHINFO_EXTENSION) ?? 'ISO' }}</span>
                            <a href="{{ route('final_project.detail', $cd->id) }}" class="detail-link">Detail <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10 text-gray-500">Tidak ada koleksi CD/DVD yang ditemukan</div>
            @endforelse
        </div>

        <!-- Pagination (hanya tampil jika data ada) -->
        @if(isset($data) && $data->count() > 0)
            <div class="pagination">
                {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </main>
</div>
@endsection

@push('scripts')
<script>
    // Submit form otomatis saat select berubah (filter & sort)
    document.querySelectorAll('.filter-item select').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endpush
