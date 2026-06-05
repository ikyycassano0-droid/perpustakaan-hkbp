{{-- resources/views/user/page/profile/kerjasama.blade.php --}}
@extends('user.component.master')

@section('title', 'Kerjasama - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
<style>
    /* ============================================
       STYLE KHUSUS HALAMAN KERJASAMA (TETAP SAMA)
    ============================================ */

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

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 10px 22px;
        background: #fff;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid var(--border-color);
        color: var(--text-dark);
    }

    .filter-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .filter-btn:hover:not(.active) {
        background: #eef3ef;
        border-color: var(--accent-green);
    }

    /* Card Mitra – border kuning, icon hijau */
    .partner-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .partner-card {
        background: var(--card-bg);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
        display: flex;
        flex-direction: column;
        padding: 25px;
        position: relative;
        border: 1px solid var(--border-color);
        border-top: 4px solid #f1c40f;   /* kuning */
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

    .partner-card .status-tag {
        position: absolute;
        top: 20px;
        right: 20px;
        background: var(--accent-green);
        color: white;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
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

    .card-footer {
        border-top: 1px solid var(--border-color);
        padding-top: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .card-footer i {
        color: #7c8b82;
    }

    /* Global Section (kerjasama internasional) */
    .global-section {
        background: var(--deep-green);
        border-radius: 20px;
        margin-top: 40px;
        padding: 40px;
        display: flex;
        color: white;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .global-info {
        flex: 1;
    }

    .global-info h4 {
        color: var(--accent-green);
        text-transform: uppercase;
        font-size: 0.8rem;
        margin-bottom: 15px;
        letter-spacing: 2px;
    }

    .global-info h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .global-info p {
        opacity: 0.85;
        font-size: 0.9rem;
        margin-bottom: 30px;
        max-width: 400px;
    }

    .btn-global {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--accent-green);
        color: white;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: bold;
        transition: 0.3s;
        text-decoration: none;
    }

    .btn-global:hover {
        background: var(--primary-color);
        transform: translateY(-2px);
        color: white;
    }

    .global-img {
        flex: 0 0 250px;
        text-align: center;
    }

    .global-img img {
        width: 100%;
        border-radius: 16px;
        border: 3px solid rgba(255,255,255,0.2);
    }

    /* Sidebar (kustomisasi agar konsisten dengan master) */
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
        }
        .sidebar {
            position: static;
            order: 2;
        }
        .content-area {
            order: 1;
        }
        .global-section {
            flex-direction: column;
            text-align: center;
        }
        .global-info p {
            margin-left: auto;
            margin-right: auto;
        }
        .btn-global {
            justify-content: center;
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
            <!-- Filter Tabs (dinamis dari kategori mitra) -->
            @php
                $categories = collect($mitra ?? [])->pluck('category')->unique()->filter();
            @endphp
            <div class="filter-tabs" id="filterTabs">
                <button class="filter-btn active" data-filter="all">Semua Mitra</button>
                @foreach($categories as $cat)
                    <button class="filter-btn" data-filter="{{ $cat }}">
                        {{ ucfirst(str_replace('-', ' ', $cat)) }}
                    </button>
                @endforeach
            </div>

            <!-- Grid Kartu Mitra (dinamis dari database) -->
            <div class="partner-grid" id="partnerGrid">
                @forelse($mitra ?? [] as $item)
                    <div class="partner-card" data-category="{{ $item->category ?? 'umum' }}">
                        @if($item->status_tag)
                            <span class="status-tag">{{ $item->status_tag }}</span>
                        @endif
                        <div class="card-icon">
                            {!! $item->icon ?? '<i class="fas fa-handshake"></i>' !!}
                        </div>
                        <h3>{{ $item->title ?? $item->name ?? 'Mitra' }}</h3>
                        <p>{{ $item->description ?? 'Deskripsi belum tersedia' }}</p>
                        <div class="card-footer">
                            <i class="fas {{ $item->footer_icon ?? 'fa-info-circle' }}"></i>
                            {{ $item->footer_text ?? 'Kerjasama aktif' }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full text-center py-10">Belum ada data mitra.</p>
                @endforelse
            </div>

            <!-- Banner Global Placement (bisa dinamis dari variabel $globalKerjasama) -->
            <section class="global-section" data-aos="fade-up" data-aos-delay="100">
                <div class="global-info">
                    <h4>{{ $globalKerjasama->subtitle ?? 'International Track' }}</h4>
                    <h2>{{ $globalKerjasama->title ?? 'Program Penempatan Kerja Global' }}</h2>
                    <p>{{ $globalKerjasama->description ?? 'Akper HKBP Balige kini bekerjasama dengan institusi kesehatan di Jepang dan Jerman untuk penyaluran lulusan profesional.' }}</p>
                    <a href="{{ $globalKerjasama->link ?? '#' }}" class="btn-global">
                        {{ $globalKerjasama->button_text ?? 'Pelajari Kerjasama Global' }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="global-img">
                    <img src="{{ $globalKerjasama->image ?? 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=500&q=80' }}" alt="Global Program">
                </div>
            </section>
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
                    <a href="{{ route('user.profile.kerjasama') }}" class="active">
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

@push('scripts')
<script>
    // Filter fungsionalitas untuk tab kerjasama (dinamis)
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const partnerCards = document.querySelectorAll('.partner-card');

        if (filterButtons.length && partnerCards.length) {
            filterButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    partnerCards.forEach(card => {
                        if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                            card.style.display = 'flex';
                            card.style.opacity = '0';
                            setTimeout(() => { card.style.opacity = '1'; }, 50);
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        }
    });
</script>
@endpush
