{{-- resources/views/user/page/profile/visi-misi.blade.php --}}
@extends('user.component.master')

@section('title', 'Visi & Misi - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
    <style>
        /* ============================================
           STYLE KHUSUS HALAMAN VISI & MISI (USER)
           - Primary   : hijau teal  #1a6b47
           - Deep green: #0f4a31
           - Accent    : hijau muda  #2daa6e
           - Accent yellow: #f1c40f (border card)
        ============================================ */

        /* Banner Halaman */
        .page-banner {
            background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(26, 107, 71, 0.85)),
                        url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1350&q=80');
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

        /* Layout Utama (Content + Sidebar) */
        .main-layout {
            display: flex;
            max-width: 1200px;
            margin: 40px auto 80px;
            padding: 0 20px;
            gap: 30px;
            position: relative;
            z-index: 10;
        }

        .content-area {
            flex: 1;
        }

        /* Card dengan border-top KUNING (seperti desain asli) */
        .card {
            background: var(--card-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            margin-bottom: 30px;
            border-top: 4px solid #f1c40f;   /* kuning */
            transition: 0.3s;
        }

        .card:hover {
            box-shadow: 0 16px 36px rgba(15, 74, 49, 0.12);
        }

        h2 {
            color: var(--primary-color);
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 25px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
        }

        .misi-list {
            list-style: none;
            padding: 0;
        }

        .misi-list li {
            padding: 18px;
            border-left: 5px solid #f1c40f;
            background: #f8fbf9;
            margin-bottom: 12px;
            font-weight: 500;
            border-radius: 0 12px 12px 0;
            transition: 0.3s;
            color: var(--text-dark);
        }

        .misi-list li:hover {
            background: #eef5f1;
            transform: translateX(5px);
            border-left-color: var(--accent-green);
        }

        .misi-list li i {
            color: var(--accent-green);
            margin-right: 10px;
        }

        /* Sidebar (Styling ulang agar konsisten dengan master) */
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
            }

            .sidebar {
                position: static;
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
        <h1>Visi & Misi</h1>
        <p>Arah dan tujuan Perpustakaan Sekolah Keperawatan HKBP</p>
    </div>

    <div class="main-layout">
        <!-- Konten Utama -->
        <main class="content-area">
            {{-- CARD VISI (dinamis) --}}
            <div class="card" data-aos="fade-right">
                <h2>Visi</h2>
                <p style="font-size: 1.15rem; font-style: italic; line-height: 1.8; color: var(--text-dark); border-left: 4px solid #f1c40f; padding-left: 20px;">
                    "{{ isset($visi) && $visi ? $visi->description : 'Visi belum tersedia' }}"
                </p>
            </div>

            {{-- CARD MISI (dinamis dengan list) --}}
            <div class="card" data-aos="fade-right" data-aos-delay="200">
                <h2>Misi</h2>
                <ul class="misi-list">
                    @forelse($misi ?? [] as $item)
                        <li><i class="fas fa-check-circle"></i> {{ $item->description ?? $item->title ?? $item }}</li>
                    @empty
                        <li><i class="fas fa-check-circle"></i> Data misi belum tersedia</li>
                    @endforelse
                </ul>
            </div>
        </main>

        <!-- Sidebar (menggunakan route user yang benar) -->
        <aside class="sidebar" data-aos="fade-left" data-aos-delay="100">
            <div class="sidebar-brand">
                <div class="logo-img-small"><i class="fas fa-plus-square"></i></div>
                <h3>Perpustakaan<br>AKPER HKBP</h3>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('user.profile.visi_misi') }}" class="active">
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
                    <a href="{{ route('user.profile.tugas_fungsi') }}">
                        <i class="fas fa-tasks"></i> Tugas, Fungsi, Tujuan
                    </a>
                </li>
            </ul>
        </aside>
    </div>
@endsection
