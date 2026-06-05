@extends('guest.component.master')

@section('title', 'Detail Berita - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       OVERRIDE TEMA MASTER → TEMA HIJAU + AKSEN KUNING
       (Tidak mengubah route / nama variabel)
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

    /* --- BREADCRUMB & PAGE HEADER --- */
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

    .breadcrumb {
        font-size: 0.9rem;
        margin-bottom: 10px;
        font-weight: 300;
        opacity: 0.85;
    }
    .breadcrumb a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
    }
    .breadcrumb a:hover {
        color: var(--accent-yellow);
    }
    .page-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        letter-spacing: 2px;
        font-weight: 900;
    }

    /* --- LAYOUT UTAMA --- */
    .main-container {
        max-width: 1200px;
        margin: 40px auto 60px;
        display: grid;
        grid-template-columns: 2.2fr 1fr;
        gap: 30px;
        padding: 0 3%;
    }

    /* --- ARTIKEL DETAIL --- */
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

    /* --- BAGIKAN --- */
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
    .btn-share.fb { background: #3b5998; }
    .btn-share.wa { background: #25d366; }
    .btn-share.tw { background: #1da1f2; }
    .btn-share.copy { background: #6c757d; }

    /* --- TOMBOL BACK (KHUSUS) --- */
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

    /* --- KOMENTAR --- */
    .comments-section {
        margin-top: 50px;
        border-top: 2px solid var(--border-color);
        padding-top: 40px;
    }
    .comments-section h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        color: var(--primary-color);
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .comment-item {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        background: #fafdfb;
        padding: 15px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    .comment-avatar {
        width: 50px;
        height: 50px;
        background: #e0e8e3;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-weight: bold;
        flex-shrink: 0;
    }
    .comment-content {
        flex-grow: 1;
    }
    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    .comment-name {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 0.95rem;
    }
    .comment-date {
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    .comment-text {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
    }
    .comment-form-container {
        margin-top: 40px;
        background: #fafdfb;
        padding: 25px;
        border-radius: 16px;
        border: 1px solid var(--border-color);
    }
    .comment-form-container h4 {
        margin-bottom: 20px;
        color: var(--primary-color);
        font-weight: 700;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-label {
        display: block;
        margin-bottom: 5px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
    }
    .form-input {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        outline: none;
        font-size: 0.9rem;
        transition: 0.3s;
        background: white;
    }
    .form-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(26, 107, 71, 0.1);
    }
    textarea.form-input {
        height: 120px;
        resize: none;
    }
    .btn-submit {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-submit:hover {
        background: var(--accent-green);
        transform: translateY(-2px);
    }

    /* --- SIDEBAR --- */
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
    .sidebar-card ul li a:hover {
        color: var(--primary-color);
    }

    /* --- NOTIFICATION --- */
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
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .notification.show {
        transform: translateX(0);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .main-container {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        article.news-detail {
            padding: 25px;
        }
    }
</style>
@endpush

@section('content')
<div>
    {{-- HERO BREADCRUMB --}}
    <div class="page-header">
        <div class="breadcrumb">
            <a href="#">Home</a> /
            <a href="{{ route('guest.berita.index') }}">Berita</a> /
            <span>{{ $news->title }}</span>
        </div>
        <h1>NEWS UPDATE</h1>
    </div>

    <div class="main-container">
        {{-- ARTIKEL UTAMA --}}
        <main>
            <article class="news-detail">
                {{-- Kategori badge --}}
                <span class="news-category">{{ strtoupper($news->category) }}</span>

                <h2>{{ $news->title }}</h2>

                {{-- Meta informasi --}}
                <div class="news-meta-detail">
                    <span><i class="far fa-calendar-alt"></i> {{ $news->created_at->format('d M Y') }}</span>
                    <span><i class="far fa-user"></i> {{ $news->author ?? 'Admin' }}</span>
                    <span><i class="far fa-eye"></i> {{ $news->views ?? 0 }} Dilihat</span>
                    <span><i class="far fa-comment"></i> 2 Komentar</span>
                </div>

                {{-- Gambar Utama --}}
                <div class="featured-image-container">
                    <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}" class="featured-image">
                </div>

                {{-- Isi Berita --}}
                <div class="news-content">
                    {!! $news->content !!}
                </div>

                {{-- Tombol Bagikan --}}
                <div class="share-section">
                    <span style="font-weight: bold; color: var(--primary-color);">Bagikan:</span>
                    <button onclick="shareArticle('facebook')" class="btn-share fb"><i class="fab fa-facebook-f"></i></button>
                    <button onclick="shareArticle('whatsapp')" class="btn-share wa"><i class="fab fa-whatsapp"></i></button>
                    <button onclick="shareArticle('twitter')" class="btn-share tw"><i class="fab fa-twitter"></i></button>
                    <button onclick="copyLink()" class="btn-share copy"><i class="fas fa-link"></i></button>
                </div>

                {{-- TOMBOL BACK KE DAFTAR BERITA --}}
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ route('guest.berita.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Berita
                    </a>
                </div>

                {{-- Komentar --}}
                <section class="comments-section">
                    <h3><i class="fas fa-comments"></i> Komentar (2)</h3>

                    <div class="comment-list">
                        <div class="comment-item">
                            <div class="comment-avatar">JS</div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-name">Junita Simanjuntak</span>
                                    <span class="comment-date">16 Mei 2024</span>
                                </div>
                                <p class="comment-text">Terima kasih atas informasinya! Sangat membantu kami yang sedang menyusun tugas akhir.</p>
                            </div>
                        </div>
                        <div class="comment-item">
                            <div class="comment-avatar">RP</div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-name">Rudi Pasaribu</span>
                                    <span class="comment-date">17 Mei 2024</span>
                                </div>
                                <p class="comment-text">Materi workshopnya sangat jelas. Sukses selalu untuk AKPER HKBP!</p>
                            </div>
                        </div>
                    </div>

                    {{-- Form Komentar --}}
                    <div class="comment-form-container">
                        <h4>Tulis Komentar Anda</h4>
                        <form id="commentForm" onsubmit="submitComment(event)">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-input" placeholder="Masukkan nama Anda..." required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-input" placeholder="Masukkan email Anda..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Isi Komentar</label>
                                <textarea class="form-input" placeholder="Tuliskan pendapat Anda di sini..." required></textarea>
                            </div>
                            <button type="submit" class="btn-submit">Kirim Komentar</button>
                        </form>
                    </div>
                </section>
            </article>
        </main>

        {{-- SIDEBAR --}}
        <aside>
            {{-- Berita Terkait --}}
            <div class="sidebar-card">
                <h4>Berita Terkait</h4>
                @foreach($related as $item)
                <div class="recent-post-item">
                    <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="recent-post-img">
                    <div class="recent-post-info">
                        <a href="{{ route('guest.berita.show', $item->id) }}">
                            <h5>{{ $item->title }}</h5>
                        </a>
                        <span>{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Kategori (statis, bisa dikembangkan) --}}
            <div class="sidebar-card">
                <h4>Kategori</h4>
                <ul>
                    <li><a href="#">Workshop</a> <span>(7)</span></li>
                    <li><a href="#">Pengumuman</a> <span>(5)</span></li>
                    <li><a href="#">Kegiatan</a> <span>(12)</span></li>
                </ul>
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Data berita saat ini untuk share
    const currentNews = {
        title: @json($news->title),
        url: window.location.href
    };

    function shareArticle(platform) {
        const url = encodeURIComponent(currentNews.url);
        const title = encodeURIComponent(currentNews.title);
        let shareUrl = '';

        switch(platform) {
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

    function copyLink() {
        navigator.clipboard.writeText(currentNews.url).then(() => {
            showNotification('Link berita telah disalin ke clipboard!', 'success');
        });
    }

    // Komentar (simulasi)
    function submitComment(event) {
        event.preventDefault();
        const form = document.getElementById('commentForm');
        const name = form.querySelector('input[type="text"]').value;
        const email = form.querySelector('input[type="email"]').value;
        const message = form.querySelector('textarea').value;

        if (name && email && message) {
            showNotification('Komentar Anda telah dikirim (simulasi). Terima kasih!', 'success');
            form.reset();
        } else {
            showNotification('Mohon isi semua field.', 'error');
        }
    }

    // Notifikasi custom (fallback)
    function showNotification(message, type = 'success') {
        if (typeof showNotif === 'function') {
            showNotif(message, type);
        } else {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.innerHTML = `<span>${type === 'success' ? '✅' : '❌'} ${message}</span>`;
            document.body.appendChild(notification);
            setTimeout(() => notification.classList.add('show'), 10);
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    }
</script>
@endpush
