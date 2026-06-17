@extends('guest.component.master')

@section('title', 'Detail Berita - AKPER HKBP Balige')

@push('styles')
    <style>
        /* ============================================
           OVERRIDE TEMA MASTER → TEMA HIJAU + AKSEN KUNING
        ============================================ */
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

        body {
            background-color: var(--light-bg) !important;
            color: var(--text-dark);
            font-family: 'DM Sans', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.8;
        }

        .page-header {
            background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(26, 107, 71, 0.85)),
                        url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            padding: 60px 5%;
            color: white;
            text-align: center;
            margin-top: -30px;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            letter-spacing: 2px;
            font-weight: 900;
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

        .news-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 20px 0;
        }

        .news-content h1,
        .news-content h2,
        .news-content h3 {
            color: var(--primary-color);
            margin-top: 25px;
            margin-bottom: 15px;
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

        .share-section {
            margin-top: 40px;
            padding: 20px 0;
            border-top: 1px dashed var(--border-color);
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-share {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            transition: 0.3s;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }

        .btn-share:hover {
            transform: translateY(-3px);
        }

        .btn-share.fb {
            background: #3b5998;
        }
        .btn-share.wa {
            background: #25d366;
        }
        .btn-share.tw {
            background: #1da1f2;
        }
        .btn-share.copy {
            background: #6c757d;
        }

        .btn-back {
            display: inline-block;
            background: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn-back:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 107, 71, 0.2);
        }

        .btn-back i {
            margin-right: 6px;
        }

        /* Sidebar */
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

        .recent-post-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
            transition: 0.2s;
        }

        .recent-post-item:hover {
            transform: translateX(5px);
        }

        .recent-post-img {
            width: 70px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        .recent-post-info h5 {
            font-size: 0.85rem;
            margin-bottom: 5px;
            color: var(--text-dark);
            font-weight: 700;
        }

        .recent-post-info a {
            text-decoration: none;
            color: var(--text-dark);
        }

        .recent-post-info a:hover {
            color: var(--primary-color);
        }

        .recent-post-info span {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .sidebar-card ul {
            list-style: none;
            padding: 0;
        }

        .sidebar-card ul li {
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
        }

        .sidebar-card ul li a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .sidebar-card ul li a:hover {
            color: var(--primary-color);
        }

        .notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 12px 24px;
            background: var(--primary-color);
            color: white;
            border-radius: 12px;
            z-index: 1000;
            transform: translateX(120%);
            transition: transform 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .notification.show {
            transform: translateX(0);
        }

        @media (max-width: 1024px) {
            .main-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            article.news-detail {
                padding: 25px;
            }
        }
    </style>
@endpush

@section('content')
    <div>
        {{-- HERO HEADER --}}
        <div class="page-header">
            <h1>NEWS UPDATE</h1>
        </div>

        <div class="main-container">
            {{-- ARTIKEL UTAMA --}}
            <main>
                <article class="news-detail">
                    {{-- Kategori --}}
                    <span class="news-category">{{ strtoupper($news->category ?? 'UMUM') }}</span>

                    {{-- Judul --}}
                    <h2>{{ $news->title ?? 'Judul Berita' }}</h2>

                    {{-- Meta Informasi --}}
                    <div class="news-meta-detail">
                        <span><i class="far fa-calendar-alt"></i> {{ $news->created_at ? $news->created_at->format('d M Y') : date('d M Y') }}</span>
                        <span><i class="far fa-user"></i> {{ $news->createdBy->name ?? $news->author ?? 'Admin' }}</span>
                        @if (isset($news->is_featured) && $news->is_featured)
                            <span><i class="fas fa-star" style="color: #f1c40f;"></i> Berita Utama</span>
                        @endif
                    </div>

                    {{-- Gambar Utama --}}
                    @if (isset($news->image) && $news->image)
                        <div class="featured-image-container">
                            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title ?? 'Gambar Berita' }}" class="featured-image">
                        </div>
                    @endif

                    {{-- Konten Berita --}}
                    <div class="news-content">
                        @if (isset($news->excerpt) && $news->excerpt)
                            <p><strong>{{ $news->excerpt }}</strong></p>
                            <hr>
                        @endif
                        {!! $news->content ?? '<p>Konten berita tidak tersedia.</p>' !!}
                    </div>

                    {{-- Tombol Bagikan --}}
                    <div class="share-section">
                        <span style="font-weight: bold; color: var(--primary-color);">Bagikan:</span>
                        <button onclick="shareArticle('facebook')" class="btn-share fb"><i class="fab fa-facebook-f"></i></button>
                        <button onclick="shareArticle('whatsapp')" class="btn-share wa"><i class="fab fa-whatsapp"></i></button>
                        <button onclick="shareArticle('twitter')" class="btn-share tw"><i class="fab fa-twitter"></i></button>
                        <button onclick="copyLink()" class="btn-share copy"><i class="fas fa-link"></i></button>
                    </div>

                    {{-- Tombol Kembali --}}
                    <div style="text-align: center; margin-top: 30px;">
                        <a href="{{ route('guest.berita.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Berita
                        </a>
                    </div>
                </article>
            </main>

            {{-- SIDEBAR --}}
            <aside>
                {{-- Berita Terkait --}}
                <div class="sidebar-card">
                    <h4><i class="fas fa-newspaper"></i> Berita Terkait</h4>
                    @if (isset($related) && $related->count() > 0)
                        @foreach ($related as $item)
                            <div class="recent-post-item">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="recent-post-img">
                                @else
                                    <div style="width:70px; height:60px; background:#e0e8e3; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#999; font-size:1.5rem;">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                @endif
                                <div class="recent-post-info">
                                    <a href="{{ route('guest.berita.show', $item->id ?? $item->slug) }}">
                                        <h5>{{ $item->title }}</h5>
                                    </a>
                                    <span><i class="far fa-calendar-alt"></i> {{ $item->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p style="color: var(--text-muted); text-align: center; padding: 20px 0;">
                            <i class="fas fa-info-circle"></i> Tidak ada berita terkait.
                        </p>
                    @endif
                </div>

                {{-- Kategori dari Database --}}
                <div class="sidebar-card">
                    <h4><i class="fas fa-tags"></i> Kategori</h4>
                    @php
                        $categories = App\Models\News::select('category')
                            ->where('status', 'publish')
                            ->whereNotNull('category')
                            ->groupBy('category')
                            ->get();
                    @endphp
                    @if ($categories->count() > 0)
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($categories as $cat)
                                <li style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--border-color); transition: 0.2s;"
                                    onmouseover="this.style.transform='translateX(5px)'; this.style.color='var(--primary-color)';"
                                    onmouseout="this.style.transform='translateX(0)'; this.style.color='inherit';">
                                    <a href="{{ route('guest.berita.index', ['category' => $cat->category]) }}"
                                       style="color: var(--text-dark); text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-book" style="color: var(--accent-yellow); width: 20px; text-align: center;"></i>
                                        {{ ucfirst($cat->category) }}
                                    </a>
                                    <span class="badge" style="background: var(--accent-yellow); color: #0d2137; padding: 2px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 700;">
                                        {{ App\Models\News::where('category', $cat->category)->where('status', 'publish')->count() }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p style="color: var(--text-muted); text-align: center; padding: 20px 0;">
                            <i class="fas fa-info-circle"></i> Belum ada kategori.
                        </p>
                    @endif
                </div>
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Data berita saat ini
        const currentNews = {
            id: @json($news->id ?? 0),
            title: @json($news->title ?? 'Berita'),
            url: window.location.href
        };

        // Fungsi Share
        function shareArticle(platform) {
            const url = encodeURIComponent(currentNews.url);
            const title = encodeURIComponent(currentNews.title);
            let shareUrl = '';

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${title}%20${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?text=${title}&url=${url}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
                showNotification(`Membagikan artikel ke ${platform}`, 'success');
            }
        }

        // Fungsi Copy Link
        function copyLink() {
            navigator.clipboard.writeText(currentNews.url)
                .then(() => {
                    showNotification('Link berita telah disalin ke clipboard!', 'success');
                })
                .catch(() => {
                    const textarea = document.createElement('textarea');
                    textarea.value = currentNews.url;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    showNotification('Link berita telah disalin!', 'success');
                });
        }

        // Notifikasi
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.innerHTML = `
                <span>${type === 'success' ? '✅' : '❌'} ${message}</span>
            `;
            notification.style.background = type === 'success' ? '#1a6b47' : '#dc3545';
            document.body.appendChild(notification);

            setTimeout(() => notification.classList.add('show'), 10);
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        document.addEventListener('click', function(e) {
            if (e.target.closest('.notification')) {
                const notif = e.target.closest('.notification');
                notif.classList.remove('show');
                setTimeout(() => notif.remove(), 300);
            }
        });
    </script>
@endpush
