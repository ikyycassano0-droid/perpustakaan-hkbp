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
    }

    .video-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }

    .thumbnail-small {
        position: relative;
        height: 140px;
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
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.85rem;
    }

    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
    }

    .btn-outline {
        background: transparent;
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.8rem;
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
        font-size: 0.8rem;
        transition: all 0.3s ease;
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
    }

    /* ============================================
       CSS KHUSUS UNTUK HALAMAN TUTORIAL & SIMULASI KLINIS
    ============================================ */

    /* Style untuk special card (video pertama di list) */
    .video-card-special {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.05));
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
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

    /* Style untuk card biasa (tidak berubah) */
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
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }

    .thumbnail-small {
        position: relative;
        height: 140px;
        background-size: cover;
        background-position: center;
        cursor: pointer;
    }

    /* (kode lainnya tetap sama seperti yang sudah Anda punya) */
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- HERO SECTION (tidak berubah) -->
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

    <!-- STATISTICS SECTION (tidak berubah) -->
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

                    <!-- SIDEBAR (tidak berubah) -->
                    <div class="lg:col-span-1">
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Kategori Video</div>
                            <div class="sidebar-item active" data-category="all">🎬 Semua Video</div>
                            @foreach($categories as $cat)
                                <div class="sidebar-item" data-category="{{ $cat->id }}">{{ $cat->name }}</div>
                            @endforeach
                        </div>
                        <div class="sidebar-menu mt-6">
                            <div class="sidebar-title">📅 Tahun Rilis</div>
                            <div class="sidebar-item" data-year="2024">2024</div>
                            <div class="sidebar-item" data-year="2023">2023</div>
                            <div class="sidebar-item" data-year="2022">2022</div>
                        </div>
                    </div>

                    <!-- MAIN CONTENT AREA -->
                    <div class="lg:col-span-3">

                        <!-- Search Bar -->
                        <div class="mb-6">
                            <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari prosedur atau topik simulasi...">
                        </div>

                        <!-- FEATURED VIDEO (tidak berubah) -->
                        @php $featured = $videos->where('is_featured', true)->first(); @endphp
                        @if($featured)
                        <div class="mb-8">
                            <div class="featured-video">
                                <div class="grid md:grid-cols-2 gap-0">
                                    <div class="video-thumbnail relative">
                                        <img src="{{ $featured->thumbnail ? Storage::url($featured->thumbnail) : '/images/default.jpg' }}">
                                        <div class="play-button" onclick="playVideo('{{ $featured->video_url }}', '{{ addslashes($featured->title) }}')">▶</div>
                                        <div class="duration-badge">{{ $featured->duration ?? '00:00' }}</div>
                                    </div>
                                    <div class="p-6 flex flex-col justify-center">
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="cat-badge cat-dasar">{{ $featured->category->name ?? 'Prosedur Dasar' }}</span>
                                            <span class="text-xs text-gray-500">👁️ {{ number_format($featured->views ?? 0) }} tontonan</span>
                                            <span class="text-xs text-gray-500">📅 {{ $featured->created_at->diffForHumans() }}</span>
                                        </div>
                                        <h2 class="text-xl font-bold text-indigo-200 mb-2">{{ $featured->title }}</h2>
                                        <p class="text-gray-400 text-sm mb-3">{{ Str::limit($featured->description, 120) }}</p>
                                        <p class="text-xs text-indigo-300 mb-4">👨‍⚕️ Narasumber: {{ $featured->expert ?? 'Tim AKPER HKBP' }}</p>
                                        <div class="flex gap-3">
                                            <button class="btn-primary"onclick="playVideo('{{ Storage::url($featured->file_url) }}', '{{ addslashes($featured->title) }}')">▶ Putar Sekarang</button>
                                            <button class="btn-outline" onclick="saveVideo({{ $featured->id }})">💾 Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- VIDEO LIST -->
                        <h3 class="text-indigo-200 font-semibold mb-3">📋 Semua Video Tutorial</h3>
                        <div class="space-y-4" id="videoList">
                            @php
                                $regularVideos = $videos->where('is_featured', false)->values();
                                $firstSpecial = $regularVideos->isNotEmpty() ? $regularVideos->shift() : null;
                            @endphp

                            <!-- CARD PERTAMA (SPECIAL) -->
                            @if($firstSpecial)
                            <div class="video-card-special fade-up"
                                 data-category="{{ $firstSpecial->category_id }}"
                                 data-year="{{ $firstSpecial->created_at->format('Y') }}"
                                 data-title="{{ strtolower($firstSpecial->title) }}"
                                 data-description="{{ strtolower($firstSpecial->description) }}">
                                <div class="grid md:grid-cols-3 gap-0">
                                    <div class="thumbnail-special md:col-span-1" style="background-image: url('{{ asset('storage/'.$firstSpecial->thumbnail) }}');">
                                        <div class="play-button-small" style="position: absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:50px; height:50px; background:rgba(99,102,241,0.8); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer;" onclick="playVideo('{{ $firstSpecial->video_url }}', '{{ addslashes($firstSpecial->title) }}')">▶</div>
                                        <div class="duration-badge">{{ $firstSpecial->duration ?? '00:00' }}</div>
                                    </div>
                                    <div class="md:col-span-2 p-5">
                                        <div class="flex items-center gap-2 flex-wrap mb-2">
                                            <span class="cat-badge cat-dasar">{{ $firstSpecial->category->name ?? 'Prosedur Dasar' }}</span>
                                            <span class="text-xs text-gray-500">👁️ {{ number_format($firstSpecial->views ?? 0) }} tontonan</span>
                                            <span class="text-xs text-gray-500">📅 {{ $firstSpecial->created_at->diffForHumans() }}</span>
                                            @if($firstSpecial->has_quiz)<span class="text-xs text-green-400">📝 Ada Kuis</span>@endif
                                        </div>
                                        <h3 class="font-bold text-indigo-200 text-lg mb-2">{{ $firstSpecial->title }}</h3>
                                        <p class="text-gray-400 text-sm mb-3">{{ Str::limit($firstSpecial->description, 150) }}</p>
                                        <div class="flex gap-3">
                                            <button class="btn-primary text-sm py-1.5 px-4" onclick="playVideo('{{ $firstSpecial->video_url }}', '{{ addslashes($firstSpecial->title) }}')">▶ Putar Sekarang</button>
                                            <button class="btn-outline text-sm py-1.5 px-4" onclick="saveVideo({{ $firstSpecial->id }})">💾 Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- CARD BIASA (SISA VIDEO) -->
                            @forelse($regularVideos as $item)
                            <div class="video-card fade-up"
                                 data-category="{{ $item->category_id }}"
                                 data-year="{{ $item->created_at->format('Y') }}"
                                 data-title="{{ strtolower($item->title) }}"
                                 data-description="{{ strtolower($item->description) }}">
                                <div class="flex flex-col md:flex-row">
                                    <div class="thumbnail-small md:w-64" style="background-image: url('{{ asset('storage/'.$item->thumbnail) }}');">
                                        <div class="play-button-small" onclick="playVideo('{{ $item->video_url }}', '{{ addslashes($item->title) }}')">▶</div>
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
                                        <p class="text-gray-400 text-sm mb-3">{{ Str::limit($item->description, 100) }}</p>
                                        <div class="flex gap-2">
                                            <button class="btn-link text-sm" onclick="playVideo('{{ $item->video_url }}', '{{ addslashes($item->title) }}')">▶ Putar →</button>
                                            <button class="btn-link text-sm" onclick="saveVideo({{ $item->id }})">💾 Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                                @if(!$firstSpecial)
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
    // Render functions
    let currentLimit = 5;
    let currentCategory = 'all';
    let searchQuery = '';

    function getCategoryClass(category) {
        const classes = {
            'dasar': 'cat-dasar',
            'gawat': 'cat-gawat',
            'bedah': 'cat-bedah',
            'etika': 'cat-etika',
            'simulasi': 'cat-dasar'
        };
        return classes[category] || 'cat-dasar';
    }

    function renderFeaturedVideo() {
        const featured = videosData.find(v => v.isFeatured === true);
        const container = document.getElementById('featuredVideo');
        if (featured) {
            container.innerHTML = `
                <div class="featured-video">
                    <div class="grid md:grid-cols-2 gap-0">
                        <div class="video-thumbnail">
                            <img src="${featured.thumbnail}" alt="${featured.title}" class="w-full h-full object-cover" style="min-height: 280px;">
                            <div class="play-button" onclick="playVideo(${featured.id})">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                            <div class="duration-badge">${featured.duration}</div>
                        </div>
                        <div class="p-6 flex flex-col justify-center">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="cat-badge ${getCategoryClass(featured.category)}">${featured.categoryName}</span>
                                <span class="text-xs text-gray-500">👁️ ${featured.views.toLocaleString()} tontonan</span>
                                <span class="text-xs text-gray-500">📅 ${featured.date}</span>
                            </div>
                            <h2 class="text-xl font-bold text-indigo-200 mb-2">${featured.title}</h2>
                            <p class="text-gray-400 text-sm mb-3">${featured.description}</p>
                            <p class="text-xs text-indigo-300 mb-4">👨‍⚕️ Narasumber: ${featured.expert}</p>
                            <div class="flex gap-3">
                                <button class="btn-primary" onclick="playVideo(${featured.id})">
                                    ▶ Putar Sekarang
                                </button>
                                <button class="btn-outline" onclick="saveVideo(${featured.id})">
                                    💾 Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    function renderVideoList() {
        let filteredData = [...videosData];

        // Filter by search
        if (searchQuery) {
            filteredData = filteredData.filter(item =>
                item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
                item.description.toLowerCase().includes(searchQuery.toLowerCase())
            );
        }

        // Filter by category
        if (currentCategory !== 'all') {
            filteredData = filteredData.filter(item => item.category === currentCategory);
        }

        // Exclude featured video from list
        filteredData = filteredData.filter(v => v.isFeatured !== true);

        // Limit items
        const limitedData = filteredData.slice(0, currentLimit);

        // Generate video list
        const container = document.getElementById('videoList');
        container.innerHTML = '';

        if (limitedData.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <div class="text-5xl mb-3">🎬</div>
                    <p class="text-gray-400">Tidak ada video yang ditemukan</p>
                </div>
            `;
        } else {
            limitedData.forEach(video => {
                const card = document.createElement('div');
                card.className = 'video-card fade-up';
                card.innerHTML = `
                    <div class="flex flex-col md:flex-row">
                        <div class="thumbnail-small md:w-64" style="background-image: url('${video.thumbnail}');">
                            <div class="play-button-small" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 40px; height: 40px; background: rgba(99,102,241,0.8); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="playVideo(${video.id})">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                            <div class="duration-badge">${video.duration}</div>
                        </div>
                        <div class="flex-1 p-4">
                            <div class="flex items-center gap-2 flex-wrap mb-2">
                                <span class="cat-badge ${getCategoryClass(video.category)}">${video.categoryName}</span>
                                <span class="text-xs text-gray-500">👁️ ${video.views.toLocaleString()} tontonan</span>
                                <span class="text-xs text-gray-500">📅 ${video.date}</span>
                                ${video.isNew ? '<span class="text-xs text-yellow-400">🆕 Baru</span>' : ''}
                                ${video.isPopular ? '<span class="text-xs text-orange-400">⭐ Populer</span>' : ''}
                                ${video.hasQuiz ? '<span class="text-xs text-green-400">📝 Ada Kuis</span>' : ''}
                            </div>
                            <h3 class="font-semibold text-indigo-200 mb-1">${video.title}</h3>
                            <p class="text-gray-400 text-sm mb-3">${video.description.substring(0, 100)}...</p>
                            <div class="flex gap-2">
                                <button class="btn-link text-sm" onclick="playVideo(${video.id})">▶ Putar →</button>
                                <button class="btn-link text-sm" onclick="saveVideo(${video.id})">💾 Simpan</button>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        // Hide load more button if no more items
        const loadMoreContainer = document.getElementById('loadMoreContainer');
        if (filteredData.length <= currentLimit) {
            loadMoreContainer.style.display = 'none';
        } else {
            loadMoreContainer.style.display = 'flex';
        }

        // Add fade-up observer
        document.querySelectorAll('.video-card').forEach(el => {
            if (!el.classList.contains('show')) {
                setTimeout(() => el.classList.add('show'), 50);
            }
        });
    }

    function loadMore() {
        currentLimit += 3;
        renderVideoList();
    }

    function playVideo(url, title) {
    if (url.includes('youtube.com/watch')) {
        const videoId = url.split('v=')[1];
        url = `https://www.youtube.com/embed/${videoId}`;
    }

    let modal = document.createElement('div');
    modal.innerHTML = `
        <div style="
            position:fixed;
            top:0; left:0;
            width:100%; height:100%;
            background:rgba(0,0,0,0.8);
            display:flex;
            align-items:center;
            justify-content:center;
            z-index:9999;
        " onclick="this.remove()">
            <div style="width:80%; max-width:800px;" onclick="event.stopPropagation()">
                <iframe width="100%" height="450"
                    src="${url}"
                    frameborder="0"
                    allow="autoplay; encrypted-media"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

    function saveVideo(id) {
        const video = videosData.find(v => v.id === id);
        if (video) {
            showNotification(`💾 "${video.title}" telah disimpan ke playlist Anda.`, 'success');
        }
    }

    function setReminder() {
        showNotification(`🔔 Pengingat untuk siaran langsung Bedah Klinis telah disetel.`, 'success');
    }

    // Filter event listeners
    document.querySelectorAll('.sidebar-item[data-category]').forEach(item => {
        item.addEventListener('click', (e) => {
            const category = e.target.getAttribute('data-category');
            currentCategory = category;
            currentLimit = 5;

            document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
            e.target.classList.add('active');

            renderVideoList();
        });
    });

    // Search event
    document.getElementById('searchInput').addEventListener('input', (e) => {
        searchQuery = e.target.value;
        currentLimit = 5;
        renderVideoList();
    });

    // Notification system
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <span>${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}</span>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(notification);
        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // ==========================
    // PARTICLE ENGINE
    // ==========================
    const canvas = document.getElementById('particleCanvas');
    let ctx = canvas.getContext('2d');
    let particles = [];
    let animationId = null;

    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    function initParticles() {
        const particleCount = 80;
        particles = [];
        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                dx: (Math.random() - 0.5) * 0.6,
                dy: (Math.random() - 0.5) * 0.6,
                r: Math.random() * 2.5 + 1,
                opacity: Math.random() * 0.5 + 0.2
            });
        }
    }

    function drawParticles() {
        if (!ctx) return;
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        particles.forEach(p => {
            p.x += p.dx;
            p.y += p.dy;

            if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
            if (p.y < 0 || p.y > canvas.height) p.dy *= -1;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(99, 102, 241, ${p.opacity})`;
            ctx.fill();
        });

        animationId = requestAnimationFrame(drawParticles);
    }

    function startParticles() {
        if (animationId) cancelAnimationFrame(animationId);
        resizeCanvas();
        initParticles();
        drawParticles();
    }

    window.addEventListener('resize', () => {
        resizeCanvas();
        initParticles();
    });

    startParticles();

    // ==========================
    // CURSOR GLOW
    // ==========================
    const cursorGlow = document.getElementById('cursorGlow');
    if (cursorGlow) {
        document.addEventListener('mousemove', (e) => {
            cursorGlow.style.left = e.clientX + 'px';
            cursorGlow.style.top = e.clientY + 'px';
        });
        document.addEventListener('mouseleave', () => {
            cursorGlow.style.opacity = '0';
        });
        document.addEventListener('mouseenter', () => {
            cursorGlow.style.opacity = '1';
        });
    }

    // ==========================
    // FADE-UP INTERSECTION OBSERVER
    // ==========================
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

    // ==========================
    // 3D TILT EFFECT
    // ==========================
    const tiltCards = document.querySelectorAll('.tilt-card');
    tiltCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (x - centerX) / 20;
            card.style.transform = `perspective(1200px) rotateX(${-rotateX}deg) rotateY(${rotateY}deg) scale(1.01)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = `perspective(1200px) rotateX(0deg) rotateY(0deg) scale(1)`;
        });
    });

    // ==========================
    // PARALLAX EFFECT
    // ==========================
    window.addEventListener('scroll', () => {
        const heroTitle = document.querySelector('.title-main');
        if (heroTitle) {
            const scrollY = window.scrollY;
            heroTitle.style.transform = `translateY(${scrollY * 0.03}px)`;
        }
    });

    // Make functions global
    window.playVideo = playVideo;
    window.saveVideo = saveVideo;
    window.setReminder = setReminder;
    window.loadMore = loadMore;

</script>
@endpush
