{{-- resources/views/user/page/profile/struktur.blade.php --}}
@extends('user.component.master')

@section('title', 'Struktur Pengurus - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
<style>
    /* ============================================
       THEME HIJAU DENGAN AKSEN KUNING
    ============================================ */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: #f4f7f5;
        color: #0d2137;
        line-height: 1.6;
    }

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
    }

    /* Banner Halaman */
    .page-banner {
        background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(26, 107, 71, 0.85)),
                    url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1500&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 70px 5% 80px;
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

    /* Layout Utama */
    .main-layout {
        display: flex;
        max-width: 1300px;
        margin: 40px auto 80px;
        padding: 0 20px;
        gap: 30px;
        position: relative;
        z-index: 10;
    }

    .content-area {
        flex: 1;
        background: var(--card-bg);
        padding: 50px 30px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        text-align: center;
        border-top: 4px solid var(--accent-yellow);
    }

    .org-header {
        color: var(--primary-color);
        font-weight: 800;
        margin-bottom: 50px;
        font-size: 1.8rem;
        letter-spacing: 1px;
        font-family: 'Playfair Display', serif;
    }

    .org-section {
        margin-bottom: 60px;
        position: relative;
    }

    .category-label {
        background-color: var(--primary-color);
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 25px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 35px;
        box-shadow: 0 4px 10px rgba(15, 74, 49, 0.2);
    }

    .category-label i {
        color: var(--accent-yellow);
    }

    .cards-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    /* Kartu Anggota Struktur */
    .member-item {
        width: 160px;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: transform 0.3s;
    }

    .member-item:hover {
        transform: translateY(-5px);
    }

    .image-box {
        position: relative;
        margin-bottom: 15px;
        line-height: 0;
        border: 3px solid #000000;
        padding: 3px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .member-item img {
        width: 140px;
        height: 180px;
        object-fit: cover;
        border-radius: 4px;
    }

    .image-box::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 3px;
        background: var(--accent-yellow);
        border-radius: 2px;
    }

    .member-item .m-name {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1.3;
        margin-top: 10px;
        min-height: 40px;
    }

    .member-item .m-role {
        font-size: 0.7rem;
        color: var(--text-muted);
        line-height: 1.2;
        font-weight: 500;
    }

    /* Ukuran khusus untuk Direktur (sub_type 'direktur') */
    .section-director .member-item {
        width: 260px;
    }

    .section-director .image-box {
        border-width: 4px;
    }

    .section-director .member-item img {
        width: 240px;
        height: 300px;
    }

    .section-director .member-item .m-name {
        font-size: 1.2rem;
    }

    /* Ukuran khusus untuk Kepala (sub_type 'kepala') */
    .section-head .member-item {
        width: 220px;
    }

    .section-head .image-box {
        border-width: 4px;
    }

    .section-head .member-item img {
        width: 200px;
        height: 260px;
    }

    .section-head .member-item .m-name {
        font-size: 1rem;
    }

    /* Empty State */
    .empty-state {
        padding: 50px 20px;
        text-align: center;
    }

    .empty-state i {
        font-size: 3.5rem;
        color: var(--primary-color);
        opacity: 0.25;
        margin-bottom: 15px;
        display: block;
    }

    .empty-state h4 {
        font-size: 1.2rem;
        color: var(--text-dark);
        margin-bottom: 5px;
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    /* Sidebar */
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

    @media (max-width: 1100px) {
        .main-layout {
            flex-direction: column;
        }
        .sidebar {
            position: static;
            width: 100%;
            order: 2;
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
        <h1>Struktur Organisasi</h1>
        <p>Arah dan Kepemimpinan Perpustakaan AKPER HKBP</p>
    </div>

    <div class="main-layout">
        <!-- Konten Utama -->
        <main class="content-area" data-aos="fade-up" data-aos-delay="100">
            <h2 class="org-header">Organisasi Perpustakaan</h2>

            @php
                // Ambil data struktur dari database (fallback jika controller tidak mengirim)
                if (!isset($struktur) || $struktur->isEmpty()) {
                    $struktur = \App\Models\Profile::where('type', 'struktur')
                                ->where('active', true)
                                ->orderBy('order')
                                ->get();
                }

                // Kelompokkan berdasarkan sub_type (pilihan di CRUD: direktur, kepala, anggota)
                $grouped = $struktur->groupBy('sub_type');
                
                // Urutan prioritas tampilan: direktur -> kepala -> anggota
                $prioritas = ['direktur', 'kepala', 'anggota'];
            @endphp

            @if($struktur->isNotEmpty())
                @foreach($prioritas as $sub_type)
                    @php
                        $anggota = $grouped->get($sub_type);
                        if (empty($anggota)) continue;
                        
                        // Tentukan label dan ikon berdasarkan sub_type
                        $label = 'Anggota';
                        $icon = 'users';
                        $isTop = false;
                        $isHead = false;

                        if ($sub_type === 'direktur') {
                            $label = 'Direktur';
                            $icon = 'crown';
                            $isTop = true;
                        } elseif ($sub_type === 'kepala') {
                            $label = 'Kepala Pengurus Perpustakaan';
                            $icon = 'user-shield';
                            $isHead = true;
                        } elseif ($sub_type === 'anggota') {
                            $label = 'Anggota';
                            $icon = 'users';
                        }
                    @endphp

                    <div class="org-section {{ $isTop ? 'section-director' : ($isHead ? 'section-head' : '') }}">
                        <div class="category-label">
                            <i class="fas fa-{{ $icon }}"></i> {{ $label }}
                        </div>
                        <div class="cards-container">
                            @foreach($anggota as $member)
                                <div class="member-item">
                                    <div class="image-box">
                                        @if($member->image)
                                            <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->title }}">
                                        @else
                                            <div style="width:{{ $isTop ? '240px' : ($isHead ? '200px' : '140px') }}; height:{{ $isTop ? '300px' : ($isHead ? '260px' : '180px') }}; background:#f0f0f0; display:flex; align-items:center; justify-content:center; color:#999;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="m-name">{{ $member->title ?? 'Nama belum diisi' }}</div>
                                    <div class="m-role">{{ $member->jabatan ?? 'Jabatan belum diisi' }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                {{-- TAMPILAN SAAT DATA KOSONG --}}
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h4>Belum Ada Data Struktur</h4>
                    <p>Data struktur pengurus belum tersedia. Silakan hubungi administrator perpustakaan.</p>
                </div>
            @endif
        </main>

        <!-- Sidebar -->
        <aside class="sidebar" data-aos="fade-left" data-aos-delay="200">
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
                    <a href="{{ route('user.profile.struktur') }}" class="active">
                        <i class="fas fa-users"></i> Struktur Pengurus
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile.tugas_fungsi') }}">
                        <i class="fas fa-tasks"></i> Tugas, Fungsi, Tujuan
                    </a>
                </li>
            </ul>
        </aside>
    </div>
@endsection