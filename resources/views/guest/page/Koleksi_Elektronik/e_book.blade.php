@extends('guest.component.master')

@section('title', 'Koleksi E-Book - AKPER HKBP Balige')

@push('styles')
<style>

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
        padding: 1.5rem;
        text-align: center;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.6);
        box-shadow: 0 10px 25px -10px rgba(99, 102, 241, 0.3);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 0.5rem;
    }

    /* E-Book Card */
    .ebook-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
    }

    .ebook-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }

    .ebook-cover {
        height: 220px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .ebook-format {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.7);
        padding: 4px 8px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.75rem;
    }

    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }

    .btn-outline {
        background: transparent;
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.75rem;
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
    }

    .btn-link:hover {
        color: #818cf8;
    }

    /* Pagination */
    .pagination-btn {
        padding: 8px 14px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 8px;
        color: #c7d2fe;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .pagination-btn:hover:not(:disabled) {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-btn.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
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
        .stat-number {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                🎥 AKPER HKBP BALIGE
            </span>
        </div>

        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
    Koleksi
    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">E-Book</span>
</h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
    Akses koleksi buku digital pilihan untuk mendukung pembelajaran dan riset keperawatan.
</p>
    </section>

    <!-- VIDEO LIST -->
    <section class="section max-w-7xl mx-auto px-5">

        <h3 class="text-indigo-200 font-semibold mb-4">
            📋 Semua Video
        </h3>

        <div class="space-y-4">

            @forelse($videos as $index => $item)

                {{-- ===================== --}}
                {{-- CARD PERTAMA (SPECIAL) --}}
                {{-- ===================== --}}
                @if($index == 0)
                <div class="video-card-special fade-up">
                    <div class="grid md:grid-cols-3 gap-0">

                        <div class="thumbnail-special"
                             style="background:#1e293b;">

                            <div class="play-button-small"
                                 onclick="playVideo('{{ Storage::url($item->file_url) }}', '{{ addslashes($item->title) }}')">
                                ▶
                            </div>

                            <div class="duration-badge">VIDEO</div>
                        </div>

                        <div class="md:col-span-2 p-5">
                            <span class="cat-badge cat-dasar">
                                {{ $item->category->name ?? 'Video' }}
                            </span>

                            <h3 class="font-bold text-indigo-200 text-lg mb-2">
                                {{ $item->title }}
                            </h3>

                            <p class="text-gray-400 text-sm mb-3">
                                {{ Str::limit($item->abstract, 150) }}
                            </p>

                            <div class="flex gap-3">
                                <button class="btn-primary"
                                    onclick="playVideo('{{ Storage::url($item->file_url) }}', '{{ addslashes($item->title) }}')">
                                    ▶ Putar
                                </button>

                                <a href="{{ route('admin.kti.download', ['id' => $item->id]) }}"
                                   class="btn-outline">
                                    ⬇ Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== --}}
                {{-- CARD BIASA --}}
                {{-- ===================== --}}
                @else
                <div class="video-card fade-up">
                    <div class="flex flex-col md:flex-row">

                        <div class="thumbnail-small md:w-64"
                             style="background:#1e293b;">

                            <div class="play-button-small"
                                 onclick="playVideo('{{ Storage::url($item->file_url) }}', '{{ addslashes($item->title) }}')">
                                ▶
                            </div>

                            <div class="duration-badge">VIDEO</div>
                        </div>

                        <div class="flex-1 p-4">

                            <div class="flex items-center gap-2 mb-2">
                                <span class="cat-badge cat-dasar">
                                    {{ $item->category->name ?? 'Video' }}
                                </span>

                                <span class="text-xs text-gray-500">
                                    📅 {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <h3 class="font-semibold text-indigo-200 mb-1">
                                {{ $item->title }}
                            </h3>

                            <p class="text-gray-400 text-sm mb-3">
                                {{ Str::limit($item->abstract, 100) }}
                            </p>

                            <div class="flex gap-2">
                                <button class="btn-link"
                                    onclick="playVideo('{{ Storage::url($item->file_url) }}', '{{ addslashes($item->title) }}')">
                                    ▶ Putar →
                                </button>

                                <a href="{{ route('final_project.download', $item->id) }}"
                                   class="btn-link">
                                    ⬇ Download
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                @endif

            @empty
                <div class="text-center py-12">
                    <div class="text-5xl mb-3">🎬</div>
                    <p class="text-gray-400">
                        Tidak ada video tersedia
                    </p>
                </div>
            @endforelse

        </div>

        <!-- PAGINATION -->
        <div class="mt-8">
            {{ $videos->links() }}
        </div>

    </section>

</div>
@endsection

@push('scripts')
<script>
let currentCategory = 'all';
let searchQuery = '';

const videos = document.querySelectorAll('#videoList > div');

// ================= FILTER CATEGORY =================
document.querySelectorAll('.sidebar-item[data-category]').forEach(item => {
    item.addEventListener('click', (e) => {
        currentCategory = e.target.getAttribute('data-category');

        document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
        e.target.classList.add('active');

        filterVideos();
    });
});

// ================= SEARCH =================
document.getElementById('searchInput').addEventListener('input', (e) => {
    searchQuery = e.target.value.toLowerCase();
    filterVideos();
});

// ================= FILTER FUNCTION =================
function filterVideos() {
    videos.forEach(video => {
        const title = video.getAttribute('data-title') || '';
        const desc = video.getAttribute('data-description') || '';
        const category = video.getAttribute('data-category');

        let matchSearch =
            title.includes(searchQuery) ||
            desc.includes(searchQuery);

        let matchCategory =
            currentCategory === 'all' || category === currentCategory;

        if (matchSearch && matchCategory) {
            video.style.display = 'block';
        } else {
            video.style.display = 'none';
        }
    });
}

// ================= PLAY VIDEO =================
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

// ================= NOTIFICATION =================
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification show';
    notification.innerText = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function saveVideo(id) {
    showNotification('💾 Video disimpan');
}

function setReminder() {
    showNotification('🔔 Pengingat disetel');
}

// ================= EXPORT =================
window.playVideo = playVideo;
window.saveVideo = saveVideo;
window.setReminder = setReminder;
</script>
@endpush
