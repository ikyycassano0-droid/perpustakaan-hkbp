@extends('user.component.master')

@section('title', 'Detail Berita - Perpustakaan AKPER HKBP')

@section('hero')
    <!-- Banner Hero khusus halaman berita -->
    <div class="page-header">
        <div class="breadcrumb">
            <a href="{{ url('user.dashboard') }}">Home</a> /
            <a href="{{ route('user.berita') }}">Berita</a> /
            <span>Detail Artikel</span>
        </div>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; letter-spacing: 2px;">NEWS UPDATE</h1>
    </div>
@endsection

@section('content')
    <div class="main-container">
        <!-- ISI BERITA -->
        <main>
            <article class="news-detail">
                <span class="news-category">Workshop</span>
                <h2>Workshop Literasi Medis: Strategi Akses Jurnal Internasional Scopus</h2>

                <div class="news-meta-detail">
                    <span><i class="far fa-calendar-alt"></i> 15 Mei 2024</span>
                    <span><i class="far fa-user"></i> Admin Perpustakaan</span>
                    <span><i class="far fa-eye"></i> 1,240 Dilihat</span>
                </div>

                <div class="featured-image-container">
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1000&q=80" alt="News Image" class="featured-image">
                </div>

                <div class="news-content">
                    <p><strong>Balige, 15 Mei 2024</strong> – Perpustakaan AKPER HKBP kembali mengadakan kegiatan rutin tahunan untuk membekali mahasiswa tingkat akhir dalam penyusunan Karya Tulis Ilmiah (KTI).</p>
                    <p>Workshop kali ini berfokus pada strategi menembus dan mencari referensi di pangkalan data internasional seperti Scopus, ScienceDirect, dan ProQuest. Hal ini dirasa penting mengingat standar referensi karya ilmiah saat ini yang menuntut pembaruan data dan validitas sumber informasi.</p>
                    <blockquote>
                        "Literasi bukan hanya soal membaca buku, tapi bagaimana kita mampu memilah informasi yang valid dari ribuan jurnal yang tersedia di internet demi kredibilitas profesi keperawatan."
                    </blockquote>
                    <p>Kepala Perpustakaan menyampaikan bahwa kemampuan literasi digital bagi calon perawat sangatlah krusial. Seorang perawat masa depan harus berbasis bukti (Evidence Based Practice) yang bersumber dari riset-riset terkini.</p>
                </div>
            </article>
        </main>

        <!-- SIDEBAR (hanya kategori dan pencarian) -->
        <aside>

            <div class="sidebar-card">
                <h4>Kategori Berita</h4>
                <ul class="category-list">
                    <li><a href="{{ route('user.berita') }}">Semua</a></li>
                    <li><a href="{{ route('user.berita', ['kategori' => 'akademik']) }}">Akademik</a></li>
                    <li><a href="{{ route('user.berita', ['kategori' => 'pengumuman']) }}">Pengumuman</a></li>
                    <li><a href="{{ route('user.berita', ['kategori' => 'kegiatan']) }}">Kegiatan</a></li>
                    <li><a href="{{ route('user.berita', ['kategori' => 'riset']) }}">Riset</a></li>
                    <li><a href="{{ route('user.berita', ['kategori' => 'fasilitas']) }}">Fasilitas</a></li>
                    <li><a href="{{ route('user.berita', ['kategori' => 'sosial']) }}">Sosial</a></li>
                </ul>
            </div>
        </aside>
    </div>
@endsection

@push('styles')
    <style>
        /* CSS spesifik untuk halaman detail berita (tidak mengganggu master) */
        .page-header {
            background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(26, 107, 71, 0.85)),
                url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            padding: 60px 5%;
            color: white;
            text-align: center;
        }

        .breadcrumb {
            font-size: 0.9rem;
            margin-bottom: 10px;
            font-weight: 300;
            opacity: 0.85;
        }
        .breadcrumb a {
            color: rgba(255,255,255,0.8);
        }
        .breadcrumb a:hover {
            color: var(--accent-yellow);
        }

        .main-container {
            max-width: 1200px;
            margin: 40px auto 60px;
            display: grid;
            grid-template-columns: 2.2fr 1fr;
            gap: 30px;
            padding: 0 3%;
        }

        article.news-detail {
            background: var(--card-bg);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--accent-yellow);
        }

        .news-category {
            background: var(--accent-yellow);
            color: var(--primary-color);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 20px;
            display: inline-block;
        }

        .news-detail h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--primary-color);
            line-height: 1.3;
            margin-bottom: 25px;
            font-weight: 900;
        }

        .news-meta-detail {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 35px;
            padding: 15px 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .news-meta-detail span i {
            color: var(--accent-yellow);
            margin-right: 5px;
        }

        .featured-image-container {
            margin-bottom: 35px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .featured-image {
            width: 100%;
            height: auto;
            display: block;
        }

        .news-content {
            font-size: 1rem;
            color: var(--text-dark);
            text-align: justify;
        }

        .news-content p {
            margin-bottom: 20px;
        }

        blockquote {
            background: #f9fbf9;
            border-left: 5px solid var(--accent-yellow);
            margin: 30px 0;
            padding: 25px 30px;
            font-style: italic;
            color: var(--text-muted);
            border-radius: 0 12px 12px 0;
        }

        /* Sidebar baru */
        .sidebar-card {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid var(--border-color);
            margin-bottom: 30px;
        }

        .sidebar-card h4 {
            color: var(--primary-color);
            margin-bottom: 20px;
            border-left: 4px solid var(--accent-yellow);
            padding-left: 12px;
            font-weight: 700;
        }

        .search-container {
            position: relative;
            display: flex;
        }
        .search-container input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 12px 0 0 12px;
            outline: none;
            font-size: 0.9rem;
            background: white;
        }
        .search-container input:focus {
            border-color: var(--primary-color);
        }
        .search-container button {
            background: var(--primary-color);
            border: none;
            padding: 0 18px;
            border-radius: 0 12px 12px 0;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        .search-container button:hover {
            background: var(--accent-green);
        }

        .category-list {
            list-style: none;
            padding: 0;
        }
        .category-list li {
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }
        .category-list li a {
            display: block;
            color: var(--text-muted);
            transition: 0.2s;
        }
        .category-list li a:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        @media (max-width: 1024px) {
            .main-container {
                grid-template-columns: 1fr;
                margin-top: 20px;
            }
        }
        @media (max-width: 640px) {
            article.news-detail {
                padding: 25px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Fungsi logout (jika diperlukan)
        function logout() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                window.location.href = "{{ url('guest') }}";
            }
        }
    </script>
@endpush
