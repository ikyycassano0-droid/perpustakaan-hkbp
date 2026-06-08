@extends('guest.component.master')

@section('title', 'Berita & Kegiatan - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
    <style>
        /* ============================================
           CSS KHUSUS HALAMAN BERITA (GAYA KLASIK HIJAU)
        ============================================ */

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(26, 107, 71, 0.85)),
                        url('https://images.unsplash.com/photo-1504270997636-07ddfbd48945?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            padding: 70px 5% 80px;
            color: white;
            text-align: center;
        }

        .hero-banner h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            margin-bottom: 10px;
            font-weight: 900;
        }

        .breadcrumb {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        /* Main container */
        .main-container {
            max-width: 1200px;
            margin: 40px auto 50px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            padding: 0 20px;
        }

        /* News Cards */
        .news-grid {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .news-card {
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            display: flex;
            transition: 0.3s;
            border: 1px solid var(--border-color);
            border-top: 4px solid #f1c40f;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 36px rgba(15, 74, 49, 0.12);
        }

        .news-img {
            width: 35%;
            background-size: cover;
            background-position: center;
            min-height: 220px;
            display: block;
        }

        .news-info {
            padding: 25px;
            width: 65%;
            display: flex;
            flex-direction: column;
        }

        .news-tag {
            background: #eef5f1;
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 10px;
            text-transform: uppercase;
            width: fit-content;
        }

        .news-info h3 {
            color: var(--text-dark);
            font-size: 1.25rem;
            margin-bottom: 12px;
            transition: 0.3s;
            font-weight: 700;
        }

        .news-info h3 a:hover {
            color: var(--primary-color);
        }

        .news-info p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .btn-readmore {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
            padding-bottom: 10px;
        }

        .btn-readmore:hover {
            color: var(--accent-green);
            gap: 12px;
        }

        .news-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            gap: 15px;
            border-top: 1px solid var(--border-color);
            padding-top: 12px;
            margin-top: 5px;
        }

        .news-meta i {
            color: #f1c40f;
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .sidebar-item {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            border: 1px solid var(--border-color);
        }

        .sidebar-title {
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1c40f;
            display: block;
            font-weight: bold;
        }

        .search-container {
            position: relative;
        }

        .search-container input {
            width: 100%;
            padding: 12px 15px;
            padding-right: 40px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            outline: none;
            transition: 0.3s;
            font-size: 0.9rem;
            background: white;
        }

        .search-container input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(26, 107, 71, 0.2);
        }

        .search-container i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .category-list {
            list-style: none;
        }

        .category-list li {
            padding: 10px 0;
            border-bottom: 1px solid #f0f5f2;
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: 0.2s;
        }

        .category-list li:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        .category-list li.active-cat {
            color: var(--primary-color);
            font-weight: 700;
        }

        .btn-help {
            color: #f1c40f;
            font-weight: bold;
            font-size: 0.9rem;
            display: inline-block;
            margin-top: 10px;
        }

        .widget-yudisium {
            background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(15, 74, 49, 0.9)),
                        url('https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&w=400&q=80');
            background-size: cover;
            border-radius: 16px;
            padding: 25px;
            color: white;
            min-height: 320px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .widget-yudisium .tag-white {
            background: var(--accent-green);
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            width: fit-content;
            margin-bottom: 10px;
        }

        .widget-yudisium h4 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            line-height: 1.2;
            font-family: 'Playfair Display', serif;
        }

        .widget-yudisium p {
            font-size: 0.85rem;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .widget-yudisium a {
            color: #f1c40f;
            font-weight: bold;
            font-size: 0.85rem;
            text-decoration: underline;
        }

        .widget-stats {
            background: var(--deep-green);
            border-radius: 16px;
            padding: 25px;
            color: white;
        }

        .widget-stats i.main-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
            color: #f1c40f;
        }

        .widget-stats h4 {
            font-size: 1.2rem;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .widget-stats p {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .bar-container {
            background: rgba(255, 255, 255, 0.2);
            height: 6px;
            border-radius: 10px;
            overflow: hidden;
        }

        .bar-fill {
            background: var(--accent-green);
            height: 100%;
            width: 80%;
        }

        /* ===== PAGINATION (SAMA SEPERTI PINBAL) ===== */
        .pagination-wrapper {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        .pagination-nav {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-link {
            display: inline-block;
            padding: 10px 18px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-dark);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            background: white;
        }

        .page-link:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .page-link.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .page-link.disabled {
            opacity: 0.4;
            pointer-events: none;
            background: #f7fafc;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .news-card {
                flex-direction: column;
            }

            .news-img,
            .news-info {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Banner -->
    <section class="hero-banner" data-aos="fade-up">
        <h2>Berita & Kegiatan</h2>
        <div class="breadcrumb">Home / Berita</div>
    </section>

    <div class="main-container">
        <main class="news-grid" id="newsGrid">
            @forelse($berita ?? [] as $item)
                <div class="news-card" data-category="{{ $item->category ?? 'berita' }}">
                    <a href="{{ route('user.berita.show', $item->slug ?? $item->id) }}"
                       class="news-img"
                       style="background-image: url('{{ asset('storage/' . $item->image) }}');"></a>
                    <div class="news-info">
                        <span class="news-tag">{{ ucfirst($item->category ?? 'Berita') }}</span>
                        <h3><a href="{{ route('user.berita.show', $item->slug ?? $item->id) }}">{{ $item->title }}</a></h3>
                        <p>{{ $item->excerpt }}</p>
                        <a href="{{ route('user.berita.show', $item->slug ?? $item->id) }}" class="btn-readmore">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                        <div class="news-meta">
                            <span><i class="far fa-calendar-alt"></i> {{ $item->created_at->format('d M Y') }}</span>
                            <span><i class="far fa-user"></i> {{ $item->author ?? 'Admin' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align:center; padding:40px; color:var(--text-muted);">
                    <i class="fas fa-newspaper" style="font-size:3rem; margin-bottom:10px; display:block;"></i>
                    Belum ada berita.
                </div>
            @endforelse
        </main>

        <aside class="sidebar">
            <!-- Widget Search -->
            <div class="sidebar-item">
                <b class="sidebar-title">Cari Berita</b>
                <div class="search-container">
                    <input type="text" id="newsSearch" placeholder="Ketik kata kunci...">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <!-- Widget Kategori -->
            <div class="sidebar-item">
                <b class="sidebar-title">Kategori Berita</b>
                <ul class="category-list" id="categoryList">
                    <li data-category="all" class="active-cat">Semua <span>({{ $berita->count() ?? 0 }})</span></li>
                    <li data-category="akademik">Akademik <span>({{ $berita->where('category', 'akademik')->count() ?? 0 }})</span></li>
                    <li data-category="pengumuman">Pengumuman <span>({{ $berita->where('category', 'pengumuman')->count() ?? 0 }})</span></li>
                    <li data-category="kegiatan">Kegiatan <span>({{ $berita->where('category', 'kegiatan')->count() ?? 0 }})</span></li>
                    <li data-category="riset">Riset <span>({{ $berita->where('category', 'riset')->count() ?? 0 }})</span></li>
                    <li data-category="fasilitas">Fasilitas <span>({{ $berita->where('category', 'fasilitas')->count() ?? 0 }})</span></li>
                    <li data-category="sosial">Sosial <span>({{ $berita->where('category', 'sosial')->count() ?? 0 }})</span></li>
                </ul>
            </div>

            <!-- Widget Bantuan -->
            <div class="sidebar-item">
                <b class="sidebar-title">Butuh Bantuan?</b>
                <p style="font-size: 0.85rem; margin-bottom: 15px; color: var(--text-muted);">Hubungi kami jika memiliki pertanyaan.</p>
                <a href="mailto:library@akperhkbp.ac.id" class="btn-help"><i class="fas fa-envelope"></i> library@akperhkbp.ac.id</a>
            </div>

            <!-- Widget Yudisium -->
            <div class="widget-yudisium">
                <div class="tag-white">PENGUMUMAN</div>
                <h4>Pendaftaran Yudisium Gelombang II Dibuka</h4>
                <p>Segera lengkapi berkas administrasi dan bebas pustaka sebelum 20 Oktober.</p>
                <a href="#">Lihat Persyaratan</a>
            </div>

            <!-- Widget Statistik -->
            <div class="widget-stats">
                <i class="fas fa-file-alt main-icon"></i>
                <h4>Statistik Peminjaman</h4>
                <p>Bulan ini, buku 'Fundamental Nursing' paling banyak dipinjam.</p>
                <div class="bar-container">
                    <div class="bar-fill"></div>
                </div>
            </div>
        </aside>
    </div>

    {{-- PAGINATION --}}
    @if(isset($berita) && method_exists($berita, 'hasPages') && $berita->hasPages())
        <div class="pagination-wrapper" style="margin-bottom: 80px;">
            <nav class="pagination-nav">
                {{-- Previous --}}
                @if($berita->onFirstPage())
                    <span class="page-link disabled">&laquo; Prev</span>
                @else
                    <a href="{{ $berita->previousPageUrl() }}" class="page-link">&laquo; Prev</a>
                @endif

                {{-- Page Numbers --}}
                @foreach(range(1, $berita->lastPage()) as $page)
                    @if($page == $berita->currentPage())
                        <span class="page-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $berita->url($page) }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($berita->hasMorePages())
                    <a href="{{ $berita->nextPageUrl() }}" class="page-link">Next &raquo;</a>
                @else
                    <span class="page-link disabled">Next &raquo;</span>
                @endif
            </nav>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        // Client-side search filter
        document.getElementById('newsSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let cards = document.querySelectorAll('.news-card');
            cards.forEach(card => {
                let title = card.querySelector('h3').innerText.toLowerCase();
                let text = card.querySelector('p').innerText.toLowerCase();
                if (title.includes(filter) || text.includes(filter)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        });

        // Kategori filter
        const categoryItems = document.querySelectorAll('#categoryList li');
        categoryItems.forEach(item => {
            item.addEventListener('click', function() {
                // Update active class
                categoryItems.forEach(i => i.classList.remove('active-cat'));
                this.classList.add('active-cat');

                const category = this.dataset.category;
                const cards = document.querySelectorAll('.news-card');
                cards.forEach(card => {
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
