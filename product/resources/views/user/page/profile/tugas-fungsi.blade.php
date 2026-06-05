{{-- resources/views/user/page/profile/tugas-fungsi.blade.php --}}
@extends('user.component.master')

@section('title', 'Tugas, Fungsi & Tujuan - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
<style>
    /* ============================================
       STYLE KHUSUS HALAMAN TUGAS, FUNGSI, TUJUAN
       (mempertahankan desain asli: border kuning, card putih)
    ============================================ */

    /* Banner Halaman */
    .page-banner {
        background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(26, 107, 71, 0.85)),
                    url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1470&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 80px 5% 80px;
        text-align: center;
    }

    .page-banner h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.4rem;
        margin-bottom: 10px;
        font-weight: 900;
    }

    .page-banner p {
        font-size: 1.05rem;
        opacity: 0.92;
    }

    /* Layout Utama (Content + Sidebar) */
    .main-layout {
        display: flex;
        max-width: 1200px;
        margin: 40px auto 50px;
        padding: 0 20px;
        gap: 30px;
        position: relative;
        z-index: 10;
    }

    .content-area {
        flex: 1;
    }

    /* SECTION BOX (CARD) DENGAN BORDER TOP KUNING */
    .section-box {
        background: var(--card-bg);
        padding: 35px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f; /* kuning */
        transition: 0.3s;
    }

    .section-box:hover {
        box-shadow: 0 16px 36px rgba(15, 74, 49, 0.12);
    }

    .section-box h2 {
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 3px solid #f1c40f;
        padding-bottom: 12px;
        margin-bottom: 25px;
        font-size: 1.4rem;
        font-family: 'Playfair Display', serif;
    }

    .item {
        display: flex;
        gap: 15px;
        margin-bottom: 18px;
        align-items: flex-start;
    }

    .item i {
        color: #f1c40f;
        font-size: 1.1rem;
        margin-top: 4px;
    }

    .item p {
        font-size: 1rem;
        color: var(--text-dark);
        line-height: 1.7;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: bold;
        color: var(--primary-color);
        margin-top: 10px;
        transition: 0.3s;
        text-decoration: none;
    }

    .btn-back:hover {
        color: var(--accent-green);
        gap: 14px;
    }

    /* Sidebar (konsisten dengan halaman lain) */
    .sidebar {
        flex: 0 0 320px;
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        padding: 25px;
        height: fit-content;
        position: sticky;
        top: 100px;
        border: 1px solid var(--border-color);
        transition: 0.3s;
    }

    .sidebar:hover {
        box-shadow: 0 16px 36px rgba(15, 74, 49, 0.12);
        border-color: var(--accent-green);
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .sidebar-brand .logo-img-small {
        width: 45px;
        height: 45px;
        background-color: var(--primary-color);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .sidebar-brand h3 {
        font-size: 0.9rem;
        color: var(--text-dark);
        line-height: 1.3;
        font-weight: 700;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
    }

    .sidebar-menu li {
        margin-bottom: 10px;
    }

    .sidebar-menu li a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        border-radius: 10px;
        color: var(--text-muted);
        font-weight: 600;
        transition: 0.3s;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .sidebar-menu li a i {
        font-size: 1.1rem;
        color: #9cb5a8;
        width: 20px;
        text-align: center;
    }

    .sidebar-menu li a.active {
        background-color: #e0f0e8;
        color: var(--primary-color);
    }

    .sidebar-menu li a.active i {
        color: var(--primary-color);
    }

    .sidebar-menu li a:hover:not(.active) {
        background-color: #f0f7f3;
        color: var(--primary-color);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .main-layout {
            flex-direction: column;
            margin-top: 20px;
        }
        .sidebar {
            position: static;
            order: 2;
            flex: 1;
        }
        .content-area {
            order: 1;
        }
    }
</style>
@endpush

@section('content')
    <!-- Banner Halaman -->
    <div class="page-banner" data-aos="fade-up">
        <h1>Tugas, Fungsi & Tujuan</h1>
        <p>Peran Strategis Perpustakaan dalam Pendidikan Keperawatan HKBP</p>
    </div>

    <div class="main-layout">
        <!-- Konten Utama -->
        <main class="content-area">
            <!-- Tugas Pokok -->
            <div class="section-box" data-aos="fade-up" data-aos-delay="100">
                <h2><i class="fas fa-tasks"></i> Tugas Pokok</h2>
                @forelse($tugas ?? [] as $item)
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p>{{ $item->deskripsi ?? $item->description ?? '' }}</p>
                    </div>
                @empty
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p>Mengumpulkan, mengolah, dan menyajikan informasi medis keperawatan secara sistematis untuk mendukung kurikulum pendidikan.</p>
                    </div>
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p>Merawat dan melestarikan koleksi pustaka baik cetak maupun digital guna menjamin ketersediaan referensi jangka panjang.</p>
                    </div>
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p>Memberikan layanan prima kepada sivitas akademika dalam pencarian sumber informasi ilmiah.</p>
                    </div>
                @endforelse
            </div>

            <!-- Fungsi -->
            <div class="section-box" data-aos="fade-up" data-aos-delay="200">
                <h2><i class="fas fa-cogs"></i> Fungsi</h2>
                @forelse($fungsi ?? [] as $item)
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p><b>{{ $item->nama ?? $item->judul ?? '' }}:</b> {{ $item->deskripsi ?? $item->description ?? '' }}</p>
                    </div>
                @empty
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p><b>Fungsi Edukasi:</b> Menjadi laboratorium intelektual mahasiswa untuk memperdalam ilmu keperawatan di luar kelas.</p>
                    </div>
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p><b>Fungsi Informasi:</b> Menyediakan referensi data yang akurat, mutakhir, dan valid untuk penelitian kesehatan.</p>
                    </div>
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p><b>Fungsi Riset:</b> Memfasilitasi dosen dan mahasiswa dalam menemukan jurnal-jurnal terakreditasi nasional maupun internasional.</p>
                    </div>
                @endforelse
            </div>

            <!-- Tujuan -->
            <div class="section-box" data-aos="fade-up" data-aos-delay="300">
                <h2><i class="fas fa-bullseye"></i> Tujuan</h2>
                @forelse($tujuan ?? [] as $index => $item)
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p>{{ $item->deskripsi ?? $item->description ?? '' }}</p>
                    </div>
                @empty
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p>Mendukung tercapainya Tri Dharma Perguruan Tinggi (Pendidikan, Penelitian, dan Pengabdian Masyarakat) di lingkungan AKPER HKBP.</p>
                    </div>
                    <div class="item">
                        <i class="fas fa-check-circle"></i>
                        <p>Melahirkan lulusan perawat yang literat, kritis, dan berwawasan luas berdasarkan bukti ilmiah (Evidence-Based Nursing).</p>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('home') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar" data-aos="fade-left" data-aos-delay="100">
            <div class="sidebar-brand">
                <div class="logo-img-small"><i class="fas fa-plus-square"></i></div>
                <h3>Perpustakaan<br>AKPER HKBP</h3>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('user.profile.visi_misi') }}">
                        <i class="fas fa-lightbulb"></i> Visi, Misi, & Sasaran
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile.kerjasama') }}">
                        <i class="fas fa-handshake"></i> Kerjasama
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile.struktur') }}">
                        <i class="fas fa-users"></i> Struktur Pengurus
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile.tugas_fungsi') }}" class="active">
                        <i class="fas fa-tasks"></i> Tugas, Fungsi, Tujuan
                    </a>
                </li>
            </ul>
        </aside>
    </div>
@endsection
