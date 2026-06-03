{{-- resources/views/user/page/Koleksi_Elektronik/kti.blade.php --}}
@extends('user.component.master')

@section('title', 'KTI Digital - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS HALAMAN KTI (GAYA KLASIK HIJAU)
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

    /* Content Section */
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
        display: inline-block;
    }

    .page-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        color: var(--text-dark);
        margin-top: 10px;
        font-weight: 800;
    }

    .page-header p {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    /* Filter Row */
    .filter-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
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

    /* KTI Grid Container */
    .kti-grid-container {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }

    .featured-kti {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 25px;
        display: flex;
        gap: 25px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 4px solid var(--accent-yellow);
    }

    .featured-kti img {
        width: 160px;
        height: 220px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .featured-info {
        flex: 1;
    }

    .badge-prodi {
        background: #e0f0e8;
        color: var(--primary-color);
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .featured-info h3 {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 12px 0 8px;
        line-height: 1.4;
    }

    .featured-info p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .author-box {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-top: 10px;
        border-top: 1px solid var(--border-color);
    }

    .author-text {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .author-text span {
        font-weight: 400;
        color: var(--text-muted);
        display: block;
    }

    .featured-info a {
        color: var(--primary-color);
        font-weight: 800;
        font-size: 0.8rem;
        transition: 0.3s;
        text-decoration: none;
    }

    .featured-info a:hover {
        color: var(--accent-green);
    }

    /* Small KTI Card */
    .small-kti-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        display: flex;
        flex-direction: column;
        border: 1px solid var(--border-color);
        border-top: 4px solid var(--accent-yellow);
        transition: 0.3s;
    }

    .small-kti-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(15, 74, 49, 0.12);
    }

    .small-kti-card h4 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 10px 0;
        line-height: 1.5;
    }

    .small-kti-card .author {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 15px;
    }

    .card-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.7rem;
        font-weight: 800;
        color: var(--text-muted);
    }

    /* Stats Banner */
    .stats-banner {
        background: #e0f0e8;
        border-radius: 20px;
        padding: 30px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin: 30px 0;
        border: 1px solid var(--border-color);
        flex-wrap: wrap;
        gap: 20px;
    }

    .stat-item {
        text-align: center;
        flex: 1;
        border-right: 1px solid var(--border-color);
    }

    .stat-item:last-child {
        border-right: none;
    }

    .stat-item h2 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary-color);
    }

    .stat-item p {
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--primary-color);
        text-transform: uppercase;
    }

    .btn-unggah {
        background: var(--primary-color);
        color: white;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-unggah:hover {
        background: var(--accent-green);
        transform: translateY(-2px);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 30px;
    }

    .page-box {
        width: 35px;
        height: 35px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .page-box.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .page-box:hover:not(.active) {
        background: #f0f7f3;
        border-color: var(--accent-green);
        color: var(--primary-color);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .sidebar,
        .kti-grid-container {
            display: none;
        }
        .filter-row {
            grid-template-columns: 1fr;
        }
        .stats-banner {
            flex-direction: column;
            text-align: center;
        }
        .stat-item {
            border-right: none;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }
        .stat-item:last-child {
            border-bottom: none;
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
            <li><a href="{{ route('user.koleksi_elektronik.video') }}"><i class="fas fa-video"></i> Video</a></li>
            <li><a href="{{ route('final_project.kti') }}" class="active"><i class="fas fa-graduation-cap"></i> Karya Tulis Ilmiah</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="content-section">
        <div class="page-header">
            <span>Repositori Digital</span>
            <h2>Karya Tulis Ilmiah (KTI)</h2>
            <p>Akses koleksi hasil penelitian mahasiswa keperawatan sebagai referensi tugas akhir Anda.</p>
        </div>

        <!-- Form Search & Filter -->
        <form method="GET" action="{{ route('final_project.kti') }}" class="filter-row">
            <div class="filter-item">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul KTI, penulis, atau kata kunci riset...">
            </div>
            <div class="filter-item">
                <select name="program_studi">
                    <option value="">Semua Program Studi</option>
                    <option value="D3 Keperawatan" {{ request('program_studi') == 'D3 Keperawatan' ? 'selected' : '' }}>D3 Keperawatan</option>
                    <option value="Profesi Ners" {{ request('program_studi') == 'Profesi Ners' ? 'selected' : '' }}>Profesi Ners</option>
                </select>
            </div>
            <div class="filter-item">
                <select name="tahun">
                    <option value="">Tahun Terbaru</option>
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </form>

        @if(isset($allApprovedKtis) && $allApprovedKtis->count())
            @php
                $featured = $allApprovedKtis->first();
                $others = $allApprovedKtis->slice(1);
            @endphp

            <!-- Featured & Side KTI Grid -->
            <div class="kti-grid-container">
                <div class="featured-kti">
                    @if($featured->cover_image)
                        <img src="{{ asset('storage/' . $featured->cover_image) }}" alt="Cover KTI">
                    @else
                        <img src="https://via.placeholder.com/160x220?text=KTI+Cover" alt="Cover">
                    @endif
                    <div class="featured-info">
                        <span class="badge-prodi">KTI - {{ $featured->study_program ?? 'D3 Keperawatan' }}</span>
                        <span style="font-size: 0.7rem; color: var(--text-muted); margin-left: 10px;">Lulus: {{ $featured->publication_year ?? $featured->created_at->format('Y') }}</span>
                        <h3>{{ $featured->title }}</h3>
                        <p>{{ Str::limit($featured->abstract ?? $featured->description ?? '', 120) }}</p>
                        <div class="author-box">
                            <div class="author-text">
                                {{ $featured->student_name ?? ($featured->user->name ?? 'Penulis') }}
                                <span>Pembimbing: {{ $featured->firstSupervisor->name ?? '-' }}, {{ $featured->secondSupervisor->name ?? '' }}</span>
                            </div>
                            <a href="{{ route('final_project.detail', $featured->id) }}" style="margin-left: auto;">Baca Fulltext <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="small-kti-card">
                    <span style="font-size: 0.65rem; color: var(--text-muted); margin-left: auto;">#KTI-{{ $featured->id }}</span>
                    <i class="far fa-file-alt" style="color: var(--text-muted); font-size: 1.5rem;"></i>
                    <h4>{{ Str::limit($featured->title, 60) }}</h4>
                    <p class="author">{{ $featured->student_name ?? ($featured->user->name ?? 'Penulis') }}</p>
                    <div class="card-footer">
                        <span>{{ $featured->pages ?? '-' }} HALAMAN</span>
                        <i class="fas fa-download" onclick="window.open('{{ asset('storage/' . $featured->file_url) }}', '_blank')"></i>
                    </div>
                </div>
            </div>

            <!-- Other KTI cards (2 col) -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 25px;">
                @foreach($others->take(4) as $kti)
                <div class="small-kti-card">
                    <i class="far fa-file-alt" style="color: var(--text-muted); font-size: 1.5rem;"></i>
                    <h4>{{ Str::limit($kti->title, 60) }}</h4>
                    <p class="author">{{ $kti->student_name ?? ($kti->user->name ?? 'Penulis') }}</p>
                    <div class="card-footer">
                        <span>{{ $kti->pages ?? '-' }} HALAMAN</span>
                        <i class="fas fa-download" onclick="window.open('{{ asset('storage/' . $kti->file_url) }}', '_blank')"></i>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 text-gray-500">Belum ada KTI yang disetujui.</div>
        @endif

        <!-- Stats Banner -->
        <div class="stats-banner">
            <div class="stat-item"><h2>{{ number_format($allApprovedKtis->count() ?? 0) }}+</h2><p>KTI Digital</p></div>
            <div class="stat-item"><h2>{{ ($allApprovedKtis->pluck('first_supervisor_id')->unique()->count() ?? 0) }}</h2><p>Dosen Pembimbing</p></div>
            <div class="stat-item"><h2>100%</h2><p>Akses Terbuka</p></div>
            <button class="btn-unggah" onclick="window.location.href='{{ route('final_project.upload.kti') }}'">Unggah Karya Mandiri</button>
        </div>

        <!-- Pagination (jika menggunakan paginator) -->
        @if(isset($allApprovedKtis) && method_exists($allApprovedKtis, 'links'))
            <div class="pagination">
                {{ $allApprovedKtis->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </main>
</div>
@endsection

@push('scripts')
<script>
    // Auto submit form saat select berubah
    document.querySelectorAll('.filter-item select').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endpush
