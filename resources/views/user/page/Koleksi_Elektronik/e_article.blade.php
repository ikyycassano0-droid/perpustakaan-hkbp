@extends('user.component.master')

@section('title', 'Koleksi E-Book - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN KOLEKSI E-BOOK
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

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📱 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
    Koleksi
    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">E-Artikel</span>
</h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Akses ribuan buku digital, jurnal elektronik, dan literatur keperawatan modern. Baca kapan saja, di mana saja.
        </p>
    </section>

    <!-- STATISTICS SECTION -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-card fade-up">
                <div class="text-3xl mb-2">📚</div>
                <div class="stat-number">{{ $ebooks->count() }}</div>
                <div class="stat-label">Total E-Book</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-3xl mb-2">📖</div>
                <div class="stat-number">{{ $ebooks->sum('views') ?? 0 }}</div>
                <div class="stat-label">Total Unduhan</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-3xl mb-2">⭐</div>
                <div class="stat-number">4.8</div>
                <div class="stat-label">Rating</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-3xl mb-2">🆓</div>
                <div class="stat-number">100%</div>
                <div class="stat-label">Gratis Akses</div>
            </div>
        </div>
    </section>

    <!-- SEARCH BAR -->
    <section class="max-w-7xl mx-auto px-5 mt-8">
        <form method="GET" action="{{ url()->current() }}" class="max-w-2xl mx-auto">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="search-input"
                   placeholder="🔍 Cari judul e-book, penulis, atau kata kunci...">
        </form>
    </section>

    <!-- MAIN CONTENT - E-BOOKS GRID (TANPA SIDEBAR) -->
    <section class="section max-w-7xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <!-- GRID EBOOK - FULL WIDTH -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5" id="ebooksGrid">

                    @forelse($ebooks as $item)
                        <div class="ebook-card">
                            <!-- COVER -->
                            <div class="ebook-cover">
                                @if($item->cover && file_exists(public_path('storage/'.$item->cover)))
                                    <img src="{{ asset('storage/'.$item->cover) }}"
                                         alt="{{ $item->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="ebook-cover" style="background-image: url('https://images.unsplash.com/photo-1512820790803-83ca734da794?w=250');">
                                </div>
                                @endif
                                <span class="ebook-format">📕 {{ strtoupper($item->format ?? 'PDF') }}</span>
                            </div>

                            <!-- CONTENT -->
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-indigo-300">
                                        {{ $item->category->name ?? 'Keperawatan' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        📅 {{ $item->year ?? date('Y') }}
                                    </span>
                                </div>

                                <h3 class="font-semibold text-indigo-200 mb-1 text-sm line-clamp-2">
                                    {{ Str::limit($item->title, 50) }}
                                </h3>

                                <p class="text-xs text-gray-400 mb-2 flex items-center gap-1">
                                <span class="text-indigo-400/70">✍️</span> {{ $item->author ?? 'Administrator' }}
                            </p>

                                <div class="flex items-center gap-2">
                                    <!-- READ BUTTON -->
                                    @if($item->file_url)
                                        <a href="{{ asset('storage/'.$item->file_url) }}"
                                           target="_blank"
                                           class="btn-primary flex-1 text-xs py-1 text-center">
                                            📖 Baca
                                        </a>

                                        <a href="{{ route('final_project.detail', $item->id) }}"
                                        class="btn-outline flex-2 text-xs py-1 text-center">
                                            👁️Lihat Detail
                                        </a>

                                        <!-- DOWNLOAD BUTTON -->
                                        <a href="{{ asset('storage/'.$item->file_url) }}"
                                           download
                                           class="btn-outline text-xs py-1 px-2 text-center">
                                            ⬇️
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-500">File tidak tersedia</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="text-5xl mb-3">📭</div>
                            <p class="text-gray-400">Tidak ada e-book yang ditemukan</p>
                            <p class="text-sm text-gray-500 mt-1">Silakan coba kata kunci lain</p>
                        </div>
                    @endforelse

                </div>

                <!-- PAGINATION -->
                <div class="mt-8">
                    {{ $ebooks->links() }}
                </div>

            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
// ==============================
// ANIMASI FADE-UP
// ==============================
function initAnimation() {
    const elements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    elements.forEach(el => observer.observe(el));
}

// ==============================
// NOTIFICATION SYSTEM
// ==============================
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

// ==============================
// CEK GAMBAR COVER
// ==============================
function checkImages() {
    document.querySelectorAll('.ebook-cover img').forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const parent = this.parentElement;
            if (parent) {
                const fallback = document.createElement('div');
                fallback.className = 'w-full h-full bg-gradient-to-br from-indigo-900 to-slate-900 flex items-center justify-center';
                fallback.innerHTML = '<span class="text-5xl">📖</span>';
                parent.appendChild(fallback);
            }
        });
    });
}

// ==============================
// INITIALIZE
// ==============================
document.addEventListener('DOMContentLoaded', function() {
    initAnimation();
    checkImages();
});

// Global functions
window.showNotification = showNotification;
</script>
@endpush
