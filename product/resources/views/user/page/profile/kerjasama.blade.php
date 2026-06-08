{{-- resources/views/user/page/profile/kerjasama.blade.php --}}
@extends('user.component.master')

@section('title', 'Kerjasama - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
    <style>
        /* Banner Halaman */
        .page-banner {
            background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(26, 107, 71, 0.85)),
                        url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1350&q=80');
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

        /* Card Mitra */
        .partner-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .partner-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            padding: 25px;
            border: 1px solid var(--border-color);
            border-top: 4px solid #f1c40f;
        }

        .partner-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.08);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            background: #f0f4f2;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .partner-card h3 {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .partner-card p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 25px;
            flex-grow: 1;
            line-height: 1.5;
        }

        .partner-card .order-badge {
            font-size: 0.75rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            padding-top: 15px;
            margin-top: auto;
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 50px 20px;
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

        .sidebar-menu li a.active {
            background-color: #e0f0e8;
            color: var(--primary-color);
        }

        .sidebar-menu li a:hover:not(.active) {
            background-color: #f0f7f3;
            color: var(--primary-color);
        }

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
        <h1>Jaringan Kerjasama</h1>
        <p>Membangun sinergi lintas institusi untuk mencetak tenaga kesehatan profesional.</p>
    </div>

    <div class="main-layout">
        <!-- Konten Utama -->
        <main class="content-area">
            <!-- Grid Kartu Mitra -->
            <div class="partner-grid" id="partnerGrid">
                @php
                    // Jika $mitra tidak dikirim atau kosong, ambil langsung dari database (fallback)
                    if (!isset($mitra) || $mitra->isEmpty()) {
                        $mitra = \App\Models\Profile::where('type', 'kerjasama')
                                    ->where('active', true)
                                    ->orderBy('order')
                                    ->get();
                    }
                @endphp

                @forelse($mitra as $item)
                    <div class="partner-card">
                        <div class="card-icon">
                            {!! $item->icon ?? '<i class="fas fa-handshake"></i>' !!}
                        </div>
                        <h3>{{ $item->title ?? 'Mitra' }}</h3>
                        <p>{{ $item->description ?? 'Deskripsi belum tersedia' }}</p>
                        <div class="order-badge">
                            <i class="fas fa-hashtag"></i> Urutan: {{ $item->order ?? 1 }}
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-handshake"></i>
                        <h4>Belum Ada Data Mitra</h4>
                        <p>Data kerjasama belum tersedia. Silakan hubungi administrator perpustakaan.</p>
                    </div>
                @endforelse
            </div>
        </main>

        <!-- Sidebar (sama seperti sebelumnya) -->
        <aside class="sidebar" data-aos="fade-left" data-aos-delay="100">
            <div class="sidebar-brand">
                <div class="logo-img-small"><i class="fas fa-plus-square"></i></div>
                <h3>Perpustakaan<br>AKPER HKBP</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('user.profile.visi_misi') }}"><i class="fas fa-lightbulb"></i> Visi, Misi</a></li>
                <li><a href="{{ route('user.profile.kerjasama') }}" class="active"><i class="fas fa-handshake"></i> Kerjasama</a></li>
                <li><a href="{{ route('user.profile.struktur') }}"><i class="fas fa-users"></i> Struktur Pengurus</a></li>
                <li><a href="{{ route('user.profile.tugas_fungsi') }}"><i class="fas fa-tasks"></i> Tugas & Fungsi</a></li>
            </ul>
        </aside>
    </div>
@endsection
