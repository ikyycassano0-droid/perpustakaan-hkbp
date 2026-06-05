{{-- resources/views/guest/page/koleksi_elektronik/detail_video.blade.php --}}
@extends('guest.component.master')

@section('title', $item->title . ' - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    /* ============================================
       GAYA DETAIL VIDEO (KLASIK HIJAU)
    ============================================ */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: #f4f7f5;
        color: #0d2137;
        font-family: 'DM Sans', 'Poppins', sans-serif;
        overflow-x: hidden;
        cursor: auto;
    }

    .video-container {
        max-width: 1400px;
        margin: 15px auto 50px;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 30px;
    }

    /* Video Player */
    .video-player-wrapper {
        background: #000;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.12);
        aspect-ratio: 16 / 9;
        position: relative;
        border: 3px solid var(--card-bg);
    }
    .video-player-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    .video-header {
        margin-top: 25px;
        background: var(--card-bg);
        padding: 25px;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 4px solid var(--accent-yellow);
    }

    .video-tag {
        background: #e0f0e8;
        color: var(--primary-color);
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .video-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 15px 0;
        line-height: 1.4;
        font-family: 'Playfair Display', serif;
    }

    .video-meta-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
    }

    .stats-left {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .stats-right {
        display: flex;
        gap: 10px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: #fafdfb;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: 0.3s;
        color: var(--text-muted);
    }

    .action-btn:hover {
        background: #f0f7f3;
        transform: translateY(-2px);
        color: var(--primary-color);
        border-color: var(--accent-green);
    }

    .action-btn.active {
        color: var(--primary-color);
        border-color: var(--primary-color);
        background: #e0f0e8;
    }

    .description-card {
        background: var(--card-bg);
        padding: 30px;
        border-radius: 20px;
        margin-top: 20px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 4px solid var(--accent-yellow);
    }

    .desc-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .instructor-img {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        border: 3px solid var(--border-color);
    }

    .btn-follow {
        margin-left: auto;
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-follow:hover {
        background: var(--accent-green);
    }
    .btn-follow.following {
        background: #e2e8f0;
        color: var(--text-muted);
    }

    .points-list {
        list-style: none;
        margin-top: 15px;
    }
    .points-list li {
        position: relative;
        padding-left: 25px;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    .points-list li::before {
        content: "\f058";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        color: var(--accent-green);
    }

    /* Komentar */
    .comments-section {
        margin-top: 30px;
        background: var(--card-bg);
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 4px solid var(--accent-yellow);
    }

    .comments-count {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-dark);
    }

    .comment-input-area {
        display: flex;
        gap: 15px;
        margin-bottom: 40px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .input-wrapper {
        flex: 1;
    }
    .input-wrapper textarea {
        width: 100%;
        border: none;
        border-bottom: 2px solid var(--border-color);
        padding: 8px 0;
        font-family: inherit;
        font-size: 0.9rem;
        resize: none;
        outline: none;
        transition: 0.3s;
        background: transparent;
        color: var(--text-dark);
    }
    .input-wrapper textarea:focus {
        border-bottom-color: var(--primary-color);
    }

    .comment-btns {
        display: none;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 10px;
    }
    .btn-cancel {
        background: transparent;
        border: none;
        padding: 8px 15px;
        font-weight: 600;
        cursor: pointer;
        border-radius: 20px;
    }
    .btn-cancel:hover {
        background: var(--border-color);
    }
    .btn-post {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 8px 20px;
        font-weight: 600;
        cursor: pointer;
        border-radius: 20px;
        opacity: 0.6;
        pointer-events: none;
        transition: 0.3s;
    }
    .btn-post.active {
        opacity: 1;
        pointer-events: auto;
    }
    .btn-post:hover {
        background: var(--accent-green);
    }

    .comment-item {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        flex-direction: column;
    }
    .comment-main-content {
        display: flex;
        gap: 15px;
    }
    .comment-content h5 {
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 3px;
    }
    .comment-content h5 span {
        font-weight: 400;
        color: var(--text-muted);
        margin-left: 8px;
        font-size: 0.75rem;
    }
    .comment-text {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 10px;
    }
    .comment-actions-row {
        display: flex;
        align-items: center;
        gap: 15px;
        color: var(--text-muted);
        font-size: 0.8rem;
    }
    .comment-action-btn {
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        align-items: center;
        gap: 5px;
        user-select: none;
    }
    .comment-action-btn:hover {
        color: var(--primary-color);
    }
    .comment-action-btn.liked {
        color: #3b82f6;
    }
    .comment-action-btn.disliked {
        color: #ef4444;
    }

    .reply-box {
        margin-left: 55px;
        margin-top: 10px;
        display: none;
    }
    .reply-input {
        width: 100%;
        border: none;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.85rem;
        padding: 5px 0;
        outline: none;
        margin-bottom: 5px;
        background: transparent;
    }
    .reply-btns {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }
    .replies-container {
        margin-left: 55px;
        margin-top: 10px;
        border-left: 2px solid var(--border-color);
        padding-left: 15px;
    }

    /* Sidebar */
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .search-sidebar-container {
        position: relative;
        background: var(--card-bg);
        padding: 15px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
    }
    .search-sidebar-container input {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        background: #fafdfb;
        outline: none;
        font-size: 0.9rem;
        transition: 0.3s;
        color: var(--text-dark);
    }
    .search-sidebar-container input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(26, 107, 71, 0.1);
    }
    .search-sidebar-container i {
        position: absolute;
        left: 30px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .sidebar-title {
        font-size: 1.1rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
        color: var(--text-dark);
    }

    .related-card {
        display: grid;
        grid-template-columns: 140px 1fr;
        gap: 12px;
        background: var(--card-bg);
        padding: 10px;
        border-radius: 16px;
        transition: 0.3s;
        border: 1px solid transparent;
        margin-bottom: 5px;
        text-decoration: none;
        color: inherit;
    }
    .related-card:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border-color: var(--accent-green);
    }
    .related-thumb {
        width: 140px;
        height: 85px;
        border-radius: 12px;
        overflow: hidden;
    }
    .related-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .related-info h4 {
        font-size: 0.85rem;
        line-height: 1.3;
        color: var(--text-dark);
        margin-bottom: 4px;
        font-weight: 600;
    }
    .related-meta {
        font-size: 0.7rem;
        color: var(--text-muted);
    }

    .quiz-card {
        padding: 30px;
        background: var(--deep-green);
        border-radius: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .quiz-card::before {
        content: '\f0eb';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: -20px;
        top: -20px;
        font-size: 8rem;
        opacity: 0.1;
        transform: rotate(15deg);
    }
    .quiz-card h4 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .quiz-card p {
        font-size: 0.85rem;
        opacity: 0.9;
        margin-bottom: 25px;
        line-height: 1.5;
    }
    .btn-quiz {
        width: 100%;
        padding: 15px;
        background: var(--accent-yellow);
        color: var(--primary-color);
        border: none;
        border-radius: 14px;
        font-weight: 800;
        font-size: 0.95rem;
        cursor: pointer;
        transition: 0.4s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .btn-quiz:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(241, 196, 15, 0.3);
        background: #fff;
    }

    .toast {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: var(--deep-green);
        color: white;
        padding: 12px 25px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        z-index: 10000;
        opacity: 0;
        transition: 0.4s;
    }
    .toast.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }

    @media (max-width: 1100px) {
        .video-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="video-container">
    <!-- KOLOM KIRI: VIDEO & DETAIL -->
    <main class="main-content">
        <div class="video-player-wrapper" data-aos="fade-right">
            <iframe id="main-video-iframe"
                    src="{{ $item->video_url ?? 'https://www.youtube.com/embed/aqM6n0GvW-M?rel=0&modestbranding=1' }}"
                    title="{{ $item->title }}"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
            </iframe>
        </div>

        <div class="video-header" data-aos="fade-up">
            <span class="video-tag">{{ $item->category->name ?? 'Prosedur Keperawatan' }}</span>
            <h1 class="video-title">{{ $item->title }}</h1>

            <div class="video-meta-stats">
                <div class="stats-left">
                    <i class="far fa-eye"></i> {{ number_format($item->views ?? 1254) }} x ditonton
                    • <i class="far fa-calendar-alt"></i> {{ $item->created_at ? $item->created_at->format('d M Y') : '24 Okt 2024' }}
                </div>
                <div class="stats-right">
                    <button class="action-btn" id="btn-like" onclick="handleLike()">
                        <i class="far fa-thumbs-up"></i> <span id="like-count">{{ $item->likes ?? 120 }}</span>
                    </button>
                    <button class="action-btn" onclick="handleShare()"><i class="fas fa-share-alt"></i> Bagikan</button>
                    <button class="action-btn" id="btn-save" onclick="handleSave()"><i class="far fa-bookmark"></i> Simpan</button>
                </div>
            </div>
        </div>

        <div class="description-card" data-aos="fade-up">
            <div class="desc-header">
                <img src="https://ui-avatars.com/api/?name=Tim+Medis&background=1a6b47&color=fff" class="instructor-img">
                <div class="instructor-info">
                    <h4>Tim Multimedia AKPER HKBP <i class="fas fa-check-circle" style="color: #3b82f6; font-size: 0.8rem;"></i></h4>
                    <p>Spesialis Edukasi Keperawatan Dasar</p>
                </div>
                <button class="btn-follow" id="btn-follow" onclick="handleFollow()">Ikuti</button>
            </div>
            <div class="desc-text">
                <p>{{ $item->description ?? 'Video ini menjelaskan secara mendalam mengenai prosedur pemasangan infus pada pasien dewasa sesuai standar operasional yang berlaku di lingkungan rumah sakit.' }}</p>
                <ul class="points-list">
                    @if(is_array($item->highlights) && count($item->highlights))
                        @foreach($item->highlights as $point)
                            <li>{{ $point }}</li>
                        @endforeach
                    @else
                        <li>Identifikasi Pasien & Informed Consent yang benar.</li>
                        <li>Pemilihan lokasi anatomi vena yang optimal.</li>
                        <li>Teknik "Bevel Up" pada saat melakukan penusukan kateter.</li>
                        <li>Manajemen limbah medis tajam (Safety box).</li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- KOMENTAR -->
        <div class="comments-section" data-aos="fade-up">
            <div class="comments-count">
                <i class="fas fa-comment-dots"></i>
                <span id="total-comments-text">3 Komentar</span>
            </div>

            <div class="comment-input-area">
                <img src="https://ui-avatars.com/api/?name=User+Aktif&background=64748b&color=fff" class="user-avatar">
                <div class="input-wrapper">
                    <textarea id="comment-input" placeholder="Tambahkan komentar publik..." onfocus="showCommentBtns()"></textarea>
                    <div class="comment-btns" id="comment-btns">
                        <button class="btn-cancel" onclick="hideCommentBtns()">Batal</button>
                        <button class="btn-post" id="btn-post-comment" onclick="postComment()">Komentar</button>
                    </div>
                </div>
            </div>

            <div id="comment-list-container">
                <div class="comment-item">
                    <div class="comment-main-content">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" class="user-avatar">
                        <div class="comment-content">
                            <h5>Budi Santoso <span>2 hari yang lalu</span></h5>
                            <p class="comment-text">Sangat membantu untuk persiapan ujian praktik laboratorium minggu depan. Terima kasih Tim Akper HKBP!</p>
                            <div class="comment-actions-row">
                                <span class="comment-action-btn" onclick="toggleCommentLike(this)"><i class="far fa-thumbs-up"></i> <span class="l-count">12</span></span>
                                <span class="comment-action-btn" onclick="toggleCommentDislike(this)"><i class="far fa-thumbs-down"></i></span>
                                <span class="comment-action-btn" onclick="toggleReplyBox(this)">Balas</span>
                            </div>
                        </div>
                    </div>
                    <div class="reply-box">
                        <input type="text" class="reply-input" placeholder="Balas komentar...">
                        <div class="reply-btns">
                            <button class="btn-cancel" style="font-size: 0.7rem;" onclick="toggleReplyBox(this)">Batal</button>
                            <button class="btn-post active" style="font-size: 0.7rem; padding: 5px 12px;" onclick="postReply(this)">Balas</button>
                        </div>
                    </div>
                    <div class="replies-container"></div>
                </div>
                <div class="comment-item">
                    <div class="comment-main-content">
                        <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=random" class="user-avatar">
                        <div class="comment-content">
                            <h5>Siti Aminah <span>1 minggu yang lalu</span></h5>
                            <p class="comment-text">Penjelasannya sangat tenang dan mudah diikuti. Apakah ada video untuk teknik pengambilan darah vena juga?</p>
                            <div class="comment-actions-row">
                                <span class="comment-action-btn" onclick="toggleCommentLike(this)"><i class="far fa-thumbs-up"></i> <span class="l-count">5</span></span>
                                <span class="comment-action-btn" onclick="toggleCommentDislike(this)"><i class="far fa-thumbs-down"></i></span>
                                <span class="comment-action-btn" onclick="toggleReplyBox(this)">Balas</span>
                            </div>
                        </div>
                    </div>
                    <div class="reply-box">
                        <input type="text" class="reply-input" placeholder="Balas komentar...">
                        <div class="reply-btns">
                            <button class="btn-cancel" style="font-size: 0.7rem;" onclick="toggleReplyBox(this)">Batal</button>
                            <button class="btn-post active" style="font-size: 0.7rem; padding: 5px 12px;" onclick="postReply(this)">Balas</button>
                        </div>
                    </div>
                    <div class="replies-container"></div>
                </div>
            </div>
        </div>
    </main>

    <!-- SIDEBAR KANAN -->
    <aside class="sidebar" data-aos="fade-left">
        <div class="search-sidebar-container">
            <i class="fas fa-search"></i>
            <input type="text" id="search-related" placeholder="Cari video terkait..." onkeyup="filterRelatedVideos()">
        </div>

        <h3 class="sidebar-title">Video Terkait</h3>
        <div id="related-list">
            @forelse($relatedVideos ?? [] as $video)
                <a href="{{ route('guest.koleksi_elektronik.video_detail', $video->id) }}" class="related-card">
                    <div class="related-thumb">
                        <img src="{{ $video->cover_image ? asset('storage/'.$video->cover_image) : 'https://via.placeholder.com/140x85?text=Video' }}" alt="Thumb">
                    </div>
                    <div class="related-info">
                        <h4 class="related-title">{{ $video->title }}</h4>
                        <span class="related-meta">{{ $video->category->name ?? 'Klinis' }} • {{ number_format($video->views ?? 0) }} views</span>
                    </div>
                </a>
            @empty
                <div class="related-card">
                    <div class="related-thumb"><img src="https://via.placeholder.com/140x85?text=No+Image"></div>
                    <div class="related-info">
                        <h4>Teknik Pengambilan Darah Vena</h4>
                        <span class="related-meta">Klinis • 850 views</span>
                    </div>
                </div>
                <div class="related-card">
                    <div class="related-thumb"><img src="https://via.placeholder.com/140x85?text=No+Image"></div>
                    <div class="related-info">
                        <h4>Manajemen BHD Dasar</h4>
                        <span class="related-meta">Emergency • 2.1k views</span>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="quiz-card">
            <h4><i class="fas fa-graduation-cap"></i> Knowledge Check</h4>
            <p>Uji pemahaman Anda mengenai teknik ini untuk mendapatkan poin kompetensi.</p>
            <button class="btn-quiz" onclick="handleStartQuiz()">
                <span>MULAI KUIS SEKARANG</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </aside>
</div>

<div id="toast" class="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toast-message">Berhasil!</span>
</div>
@endsection

@push('scripts')
<script>
    // ==================== GLOBAL VARIABLES ====================
    let isLiked = false, isSaved = false, isFollowing = false, likes = {{ $item->likes ?? 120 }};

    // ==================== TOAST ====================
    function showToast(msg) {
        const toast = document.getElementById('toast');
        document.getElementById('toast-message').innerText = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // ==================== LIKE, SHARE, SAVE, FOLLOW ====================
    function handleLike() {
        isLiked = !isLiked;
        const btn = document.getElementById('btn-like');
        likes = isLiked ? likes + 1 : likes - 1;
        btn.classList.toggle('active', isLiked);
        btn.querySelector('i').className = isLiked ? 'fas fa-thumbs-up' : 'far fa-thumbs-up';
        document.getElementById('like-count').innerText = likes;
        if(isLiked) showToast("Anda menyukai video ini");
    }

    function handleShare() {
        navigator.clipboard.writeText(window.location.href).then(() => showToast("Link disalin ke clipboard!"));
    }

    function handleSave() {
        isSaved = !isSaved;
        const btn = document.getElementById('btn-save');
        btn.classList.toggle('active', isSaved);
        btn.querySelector('i').className = isSaved ? 'fas fa-bookmark' : 'far fa-bookmark';
        showToast(isSaved ? "Video disimpan" : "Dihapus dari simpanan");
    }

    function handleFollow() {
        isFollowing = !isFollowing;
        const btn = document.getElementById('btn-follow');
        btn.innerText = isFollowing ? "Mengikuti" : "Ikuti";
        btn.classList.toggle('following', isFollowing);
    }

    function handleStartQuiz() {
        if(confirm("Apakah Anda siap memulai kuis untuk video ini?")) {
            // window.location.href = "{{ route('quiz.start', $item->id) }}";
            alert("Fitur kuis akan segera hadir!");
        }
    }

    // ==================== SEARCH RELATED VIDEOS ====================
    function filterRelatedVideos() {
        let input = document.getElementById('search-related').value.toLowerCase();
        let cards = document.querySelectorAll('.related-card');
        cards.forEach(card => {
            let title = card.querySelector('.related-title').innerText.toLowerCase();
            card.style.display = title.includes(input) ? "grid" : "none";
        });
    }

    // ==================== KOMENTAR ====================
    const commentInput = document.getElementById('comment-input');
    const commentBtns = document.getElementById('comment-btns');
    const btnPost = document.getElementById('btn-post-comment');

    function showCommentBtns() {
        commentBtns.style.display = 'flex';
    }

    function hideCommentBtns() {
        commentInput.value = "";
        commentBtns.style.display = 'none';
        btnPost.classList.remove('active');
    }

    commentInput.addEventListener('input', function() {
        if(this.value.trim().length > 0) {
            btnPost.classList.add('active');
        } else {
            btnPost.classList.remove('active');
        }
    });

    function postComment() {
        const text = commentInput.value;
        if(!text) return;

        const container = document.getElementById('comment-list-container');
        const newComment = document.createElement('div');
        newComment.className = 'comment-item';
        newComment.innerHTML = `
            <div class="comment-main-content">
                <img src="https://ui-avatars.com/api/?name=User+Aktif&background=64748b&color=fff" class="user-avatar">
                <div class="comment-content">
                    <h5>User Aktif <span>Baru saja</span></h5>
                    <p class="comment-text">${text}</p>
                    <div class="comment-actions-row">
                        <span class="comment-action-btn" onclick="toggleCommentLike(this)"><i class="far fa-thumbs-up"></i> <span class="l-count">0</span></span>
                        <span class="comment-action-btn" onclick="toggleCommentDislike(this)"><i class="far fa-thumbs-down"></i></span>
                        <span class="comment-action-btn" onclick="toggleReplyBox(this)">Balas</span>
                    </div>
                </div>
            </div>
            <div class="reply-box">
                <input type="text" class="reply-input" placeholder="Balas komentar...">
                <div class="reply-btns">
                    <button class="btn-cancel" style="font-size: 0.7rem;" onclick="toggleReplyBox(this)">Batal</button>
                    <button class="btn-post active" style="font-size: 0.7rem; padding: 5px 12px;" onclick="postReply(this)">Balas</button>
                </div>
            </div>
            <div class="replies-container"></div>
        `;
        container.prepend(newComment);
        hideCommentBtns();
        showToast("Komentar berhasil diposting!");
        updateCommentCount();
    }

    function updateCommentCount() {
        const count = document.querySelectorAll('#comment-list-container > .comment-item').length;
        document.getElementById('total-comments-text').innerText = count + " Komentar";
    }

    function toggleCommentLike(el) {
        const icon = el.querySelector('i');
        const countSpan = el.querySelector('.l-count');
        let count = parseInt(countSpan.innerText);
        if (el.classList.contains('liked')) {
            el.classList.remove('liked');
            icon.className = 'far fa-thumbs-up';
            countSpan.innerText = count - 1;
        } else {
            el.classList.add('liked');
            icon.className = 'fas fa-thumbs-up';
            countSpan.innerText = count + 1;
            const dislikeBtn = el.nextElementSibling;
            if (dislikeBtn && dislikeBtn.classList.contains('disliked')) {
                toggleCommentDislike(dislikeBtn);
            }
        }
    }

    function toggleCommentDislike(el) {
        const icon = el.querySelector('i');
        if (el.classList.contains('disliked')) {
            el.classList.remove('disliked');
            icon.className = 'far fa-thumbs-down';
        } else {
            el.classList.add('disliked');
            icon.className = 'fas fa-thumbs-down';
            const likeBtn = el.previousElementSibling;
            if (likeBtn && likeBtn.classList.contains('liked')) {
                toggleCommentLike(likeBtn);
            }
        }
    }

    function toggleReplyBox(el) {
        const commentItem = el.closest('.comment-item');
        const box = commentItem.querySelector('.reply-box');
        box.style.display = (box.style.display === 'block') ? 'none' : 'block';
        if (box.style.display === 'block') box.querySelector('input').focus();
    }

    function postReply(btn) {
        const replyBox = btn.closest('.reply-box');
        const input = replyBox.querySelector('.reply-input');
        const container = replyBox.nextElementSibling;
        if (input.value.trim() === "") return;
        const replyHTML = `
            <div class="comment-item" style="margin-bottom: 10px; font-size: 0.85rem;">
                <div class="comment-main-content">
                    <img src="https://ui-avatars.com/api/?name=User+Aktif&background=64748b&color=fff" class="user-avatar" style="width: 30px; height: 30px;">
                    <div class="comment-content">
                        <h5>User Aktif <span>Baru saja</span></h5>
                        <p class="comment-text">${input.value}</p>
                        <div class="comment-actions-row">
                            <span class="comment-action-btn" onclick="toggleCommentLike(this)"><i class="far fa-thumbs-up"></i> <span class="l-count">0</span></span>
                            <span class="comment-action-btn" onclick="toggleCommentDislike(this)"><i class="far fa-thumbs-down"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', replyHTML);
        input.value = "";
        replyBox.style.display = 'none';
        showToast("Balasan terkirim!");
    }

    // Inisialisasi jumlah komentar
    updateCommentCount();
</script>
@endpush
