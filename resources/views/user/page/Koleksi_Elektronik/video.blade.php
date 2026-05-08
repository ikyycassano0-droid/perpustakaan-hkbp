@extends('user.component.master')

@section('title', 'Tutorial & Simulasi Klinis - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN TUTORIAL & SIMULASI KLINIS
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */

    /* Glass card */
    .glass-card {
        background: rgba(30, 41, 59, 0.5);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(99, 102, 241, 0.25);
    }

    /* Glow text */
    .glow-text {
        text-shadow: 0 0 12px rgba(99, 102, 241, 0.7);
    }

    /* Tambahkan di style Visi Misi */
    .depth-2 { transform: translateZ(24px); }

    /* Title utama */
    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
    }

    /* Neon border */
    .neon-border {
        position: relative;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
        transition: all 0.3s ease;
    }

    .neon-border:hover {
        box-shadow: 0 0 30px rgba(99,102,241,0.3);
    }

    .neon-inner {
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 26px;
        padding: 2rem;
        border: 1px solid rgba(255,255,255,0.08);
    }

    /* Search input */
    .search-input {
        width: 100%;
        padding: 12px 20px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 40px;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
    }

    .search-input::placeholder {
        color: #64748b;
    }

    /* Sidebar Menu */
    .sidebar-menu {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        overflow: hidden;
    }

    .sidebar-item {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        cursor: pointer;
        color: #cbd5e1;
        font-size: 0.85rem;
    }

    .sidebar-item:hover {
        background: rgba(99, 102, 241, 0.15);
        color: white;
        padding-left: 24px;
    }

    .sidebar-item.active {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        color: #a5b4fc;
        border-left: 3px solid #6366f1;
    }

    .sidebar-title {
        font-weight: 700;
        color: #c7d2fe;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }

    /* Stat Card */
    .stat-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        padding: 1.25rem;
        text-align: center;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.6);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    /* Featured Video */
    .featured-video {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.05));
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .featured-video:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.3);
    }

    .video-thumbnail {
        position: relative;
        cursor: pointer;
        min-height: 280px;
        background-size: cover;
        background-position: center;
    }

    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background: rgba(99, 102, 241, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .play-button:hover {
        transform: translate(-50%, -50%) scale(1.1);
        background: #6366f1;
    }

    .duration-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.7);
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.7rem;
    }

    /* Video Card */
    .video-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
        margin-bottom: 1rem;
    }

    .video-card:hover {
        transform: translateY(-3px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }

    .thumbnail-small {
        position: relative;
        height: 160px;
        background-size: cover;
        background-position: center;
        cursor: pointer;
    }

    .play-button-small {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 45px;
        height: 45px;
        background: rgba(99, 102, 241, 0.85);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .play-button-small:hover {
        transform: translate(-50%, -50%) scale(1.1);
        background: #6366f1;
    }

    /* Video Card Special */
    .video-card-special {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.05));
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .video-card-special:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.3);
    }

    .thumbnail-special {
        position: relative;
        height: 200px;
        background-size: cover;
        background-position: center;
        cursor: pointer;
    }

    /* Live Badge */
    .live-badge {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    /* Category Badge */
    .cat-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }

    .cat-dasar { background: rgba(99, 102, 241, 0.2); color: #a5b4fc; }
    .cat-gawat { background: rgba(239, 68, 68, 0.2); color: #f87171; }
    .cat-bedah { background: rgba(16, 185, 129, 0.2); color: #34d399; }
    .cat-etika { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
    .cat-simulasi { background: rgba(139, 92, 246, 0.2); color: #a78bfa; }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 8px 18px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-primary:hover {
        transform: scale(1.02);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }

    .btn-outline {
        background: transparent;
        padding: 7px 16px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

    .btn-link {
        background: transparent;
        border: none;
        color: #a5b4fc;
        cursor: pointer;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-link:hover {
        color: #818cf8;
    }

    /* Notification */
    .notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 12px 24px;
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(99, 102, 241, 0.5);
        border-radius: 12px;
        color: white;
        z-index: 1000;
        transform: translateX(120%);
        transition: transform 0.3s ease;
    }

    .notification.show {
        transform: translateX(0);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .pagination a, .pagination span {
        padding: 8px 14px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 8px;
        color: #c7d2fe;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

    .pagination .active span {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
    }

    /* Section spacing */
    .section {
        margin-top: 40px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar-menu {
            margin-bottom: 20px;
        }
        .thumbnail-small {
            height: 180px;
        }
        .btn-primary, .btn-outline {
            padding: 5px 12px;
            font-size: 0.7rem;
        }
    }

    /* Fade Up Animation */
    .fade-up {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .fade-up.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">🎥 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
            Tutorial & <br>
            <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">Simulasi Klinis</span>
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Pusat pembelajaran visual untuk penggunaan prosedur keperawatan berstandar medis tinggi. Pelajari teknik terbaik dari praktisi ahli.
        </p>
    </section>

    <!-- STATISTICS SECTION -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 fade-up">
            <div class="stat-card">
                <div class="text-2xl mb-1">🎬</div>
                <div class="stat-number">{{ $videos->count() }}</div>
                <div class="text-xs text-gray-400 mt-1">Video Tutorial</div>
            </div>
            <div class="stat-card">
                <div class="text-2xl mb-1">👨‍⚕️</div>
                <div class="stat-number">45+</div>
                <div class="text-xs text-gray-400 mt-1">Praktisi Ahli</div>
            </div>
            <div class="stat-card">
                <div class="text-2xl mb-1">📊</div>
                <div class="stat-number">{{ $categories->count() }}</div>
                <div class="text-xs text-gray-400 mt-1">Kategori Spesialis</div>
            </div>
            <div class="stat-card">
                <div class="text-2xl mb-1">👥</div>
                <div class="stat-number">{{ number_format($videos->sum('views')) }}+</div>
                <div class="text-xs text-gray-400 mt-1">Total Tontonan</div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="section max-w-7xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    <!-- SIDEBAR -->
                    <div class="lg:col-span-1">
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Kategori Video</div>
                            <div class="sidebar-item active" data-category="all">🎬 Semua Video</div>
                            @foreach($categories as $cat)
                                <div class="sidebar-item" data-category="{{ $cat->id }}">{{ $cat->name }}</div>
                            @endforeach
                        </div>
                    </div>

                    <!-- MAIN CONTENT AREA -->
                    <div class="lg:col-span-3">

                        <!-- Search Bar -->
                        <div class="mb-6">
                            <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari prosedur atau topik simulasi...">
                        </div>

                        <!-- FEATURED VIDEO -->
                        @php $featured = $videos->where('is_featured', true)->first(); @endphp
                        @if($featured)
                        <div class="mb-8">
                            <div class="featured-video">
                                <div class="grid md:grid-cols-2 gap-0">
                                    <div class="video-thumbnail" style="background-image: url('{{ $featured->thumbnail ? asset('storage/'.$featured->thumbnail) : '/images/default-video.jpg' }}'); min-height: 280px;">
                                        <div class="play-button" onclick="playVideo('{{ $featured->video_url }}', '{{ addslashes($featured->title) }}')">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                        <div class="duration-badge">{{ $featured->duration ?? '00:00' }}</div>
                                    </div>
                                    <div class="p-6 flex flex-col justify-center">
                                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                                            <span class="cat-badge cat-dasar">{{ $featured->category->name ?? 'Prosedur Dasar' }}</span>
                                            <span class="text-xs text-gray-500">👁️ {{ number_format($featured->views ?? 0) }} tontonan</span>
                                            <span class="text-xs text-gray-500">📅 {{ $featured->created_at->diffForHumans() }}</span>
                                        </div>
                                        <h2 class="text-xl font-bold text-indigo-200 mb-2">{{ $featured->title }}</h2>
                                        <p class="text-gray-400 text-sm mb-3">{{ Str::limit($featured->description, 120) }}</p>
                                        <p class="text-xs text-indigo-300 mb-4">👨‍⚕️ Narasumber: {{ $featured->expert ?? 'Tim AKPER HKBP' }}</p>
                                        <div class="flex gap-3 flex-wrap">
                                            <button class="btn-primary" onclick="playVideo('{{ $featured->video_url }}', '{{ addslashes($featured->title) }}')">
                                                ▶ Putar Sekarang
                                            </button>
                                            <a href="{{ route('final_project.detail', $item->id) }}" class="btn-outline">
                                                📄 Lihat Detail
                                            </a>
                                            <button class="btn-outline" onclick="saveVideo({{ $featured->id }}, '{{ addslashes($featured->title) }}')">
                                                💾 Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- VIDEO LIST -->
                        <h3 class="text-indigo-200 font-semibold mb-3">📋 Semua Video Tutorial</h3>
                        <div id="videoList">
                            @php
                                $regularVideos = $videos->where('is_featured', false);
                            @endphp

                            @forelse($regularVideos as $item)
                            <div class="video-card fade-up"
                                 data-category="{{ $item->category_id }}"
                                 data-title="{{ strtolower($item->title) }}"
                                 data-description="{{ strtolower($item->description) }}">
                                <div class="flex flex-col md:flex-row">
                                    <div class="thumbnail-small md:w-64" style="background-image: url('{{ $item->thumbnail ? asset('storage/'.$item->thumbnail) : '/images/default-video.jpg' }}');">
                                        <div class="play-button-small" onclick="playVideo('{{ $item->video_url }}', '{{ addslashes($item->title) }}')">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                        <div class="duration-badge">{{ $item->duration ?? '00:00' }}</div>
                                    </div>
                                    <div class="flex-1 p-4">
                                        <div class="flex items-center gap-2 flex-wrap mb-2">
                                            <span class="cat-badge cat-dasar">{{ $item->category->name ?? 'Prosedur Dasar' }}</span>
                                            <span class="text-xs text-gray-500">👁️ {{ number_format($item->views ?? 0) }} tontonan</span>
                                            <span class="text-xs text-gray-500">📅 {{ $item->created_at->diffForHumans() }}</span>
                                            @if($item->has_quiz)<span class="text-xs text-green-400">📝 Ada Kuis</span>@endif
                                        </div>
                                        <h3 class="font-semibold text-indigo-200 mb-1">{{ $item->title }}</h3>
                                        <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ Str::limit($item->description ?? '', 100) }}</p>
                                        <div class="flex gap-3 flex-wrap">
                                            <a href="{{ route('final_project.detail', $item->id) }}" class="btn-link">
                                                📄 Lihat Detail →
                                            </a>
                                            <button class="btn-link" onclick="playVideo('{{ $item->video_url }}', '{{ addslashes($item->title) }}')">
                                                ▶ Putar
                                            </button>
                                            <button class="btn-link" onclick="saveVideo({{ $item->id }}, '{{ addslashes($item->title) }}')">
                                                💾 Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                                @if(!$featured)
                                <div class="text-center py-12">
                                    <div class="text-5xl mb-3">🎬</div>
                                    <p class="text-gray-400">Tidak ada video yang ditemukan</p>
                                </div>
                                @endif
                            @endforelse
                        </div>

                        <!-- PAGINATION -->
                        <div class="mt-8">
                            {{ $videos->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- UPCOMING LIVE STREAM -->
    <section class="section max-w-7xl mx-auto px-5 mb-16">
        <div class="glass-card p-5 rounded-xl fade-up">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    <div class="live-badge">🔴 LIVE</div>
                    <div>
                        <h3 class="font-semibold text-indigo-200">Siaran Langsung Bedah Klinis</h3>
                        <p class="text-sm text-gray-400">Akan datang 24 Oktober 2025, 08:00 WIB</p>
                    </div>
                </div>
                <button onclick="setReminder()" class="btn-primary px-6 py-2 text-sm">🔔 Ingatkan Saya</button>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
// ================= PLAY VIDEO =================
function playVideo(url, title) {
    let videoUrl = url;
    
    // Handle YouTube URL
    if (url && url.includes('youtube.com/watch')) {
        const videoId = url.split('v=')[1];
        videoUrl = `https://www.youtube.com/embed/${videoId}`;
    }
    
    // Create modal
    let modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    `;
    modal.onclick = function(e) {
        if (e.target === modal) modal.remove();
    };
    
    modal.innerHTML = `
        <div style="width: 90%; max-width: 1000px; position: relative;">
            <button onclick="this.closest('div').parentElement.remove()" style="
                position: absolute;
                top: -40px;
                right: 0;
                background: none;
                border: none;
                color: white;
                font-size: 28px;
                cursor: pointer;
            ">✕</button>
            <video width="100%" controls autoplay style="border-radius: 16px;">
                <source src="${videoUrl}" type="video/mp4">
                Browser Anda tidak mendukung video.
            </video>
            <div style="margin-top: 16px; color: white; text-align: center;">
                <h3>${title}</h3>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
}

// ================= SAVE VIDEO =================
function saveVideo(id, title) {
    let savedVideos = JSON.parse(localStorage.getItem('savedVideos') || '[]');
    
    if (!savedVideos.includes(id)) {
        savedVideos.push(id);
        localStorage.setItem('savedVideos', JSON.stringify(savedVideos));
        showNotification(`✅ "${title}" telah disimpan ke playlist Anda.`, 'success');
    } else {
        showNotification(`ℹ️ "${title}" sudah ada di playlist Anda.`, 'info');
    }
}

// ================= SET REMINDER =================
function setReminder() {
    showNotification(`🔔 Pengingat untuk siaran langsung Bedah Klinis telah disetel.`, 'success');
}

// ================= FILTER & SEARCH =================
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const sidebarItems = document.querySelectorAll('.sidebar-item[data-category]');
    const videoCards = document.querySelectorAll('.video-card');
    
    function filterVideos() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const activeCategory = document.querySelector('.sidebar-item.active[data-category]');
        const categoryId = activeCategory ? activeCategory.getAttribute('data-category') : 'all';
        
        videoCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            const cardTitle = card.getAttribute('data-title') || '';
            const cardDesc = card.getAttribute('data-description') || '';
            
            const matchCategory = categoryId === 'all' || cardCategory === categoryId;
            const matchSearch = searchTerm === '' || cardTitle.includes(searchTerm) || cardDesc.includes(searchTerm);
            
            if (matchCategory && matchSearch) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    // Search event
    if (searchInput) {
        searchInput.addEventListener('input', filterVideos);
    }
    
    // Category filter
    sidebarItems.forEach(item => {
        item.addEventListener('click', function() {
            sidebarItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            filterVideos();
        });
    });
});

// ================= NOTIFICATION =================
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = 'notification';
    const icon = type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️';
    notification.innerHTML = `${icon} ${message}`;
    
    if (type === 'error') {
        notification.style.borderColor = '#ef4444';
    }
    
    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ================= FADE UP ANIMATION =================
const fadeElements = document.querySelectorAll('.fade-up');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });

fadeElements.forEach(el => observer.observe(el));

// ================= GLOBAL FUNCTIONS =================
window.playVideo = playVideo;
window.saveVideo = saveVideo;
window.setReminder = setReminder;
window.showNotification = showNotification;
</script>
@endpush