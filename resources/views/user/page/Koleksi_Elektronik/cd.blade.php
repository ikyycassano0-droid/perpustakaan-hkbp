@extends('user.component.master')

@section('title', 'Koleksi CD & DVD - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN KOLEKSI CD & DVD
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

    /* CD Card */
    .cd-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
        height: 100%;
    }

    .cd-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }

    .cd-icon {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        border-radius: 1rem;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .format-badge {
        display: inline-block;
        background: rgba(99, 102, 241, 0.2);
        border: 1px solid rgba(99, 102, 241, 0.4);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        color: #a5b4fc;
    }

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
    }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">💿 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
    Multimedia
    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">Lab</span>
</h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Akses literatur multimedia untuk mendukung visualisasi prosedur keperawatan, simulasi anatomik, dan tutorial laboratorium klinis tercanggih.
        </p>
        <div class="flex justify-center gap-4 mt-6 fade-up">
            <button class="btn-primary">🎬 Pinjam Sekarang</button>
            <button class="btn-outline">📖 Panduan Akses</button>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="section max-w-7xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    <!-- SIDEBAR (TIDAK DIUBAH) -->
                    <div class="lg:col-span-1">
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Kategori Media</div>
                            <div class="sidebar-item active">💿 Semua Koleksi</div>
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="lg:col-span-3">

                        <!-- Search -->
                        <div class="mb-6">
                            <form method="GET">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="search-input"
                                    placeholder="🔍 Cari judul CD/DVD...">
                            </form>
                        </div>

                        <!-- Info -->
                        <div class="text-sm text-gray-400 mb-4">
                            Menampilkan {{ $data->count() }} data
                        </div>

                        <!-- GRID -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @forelse($data as $item)
                                <div class="cd-card fade-up">
                                    <div class="p-5">
                                        <div class="flex items-start gap-4">

                                            <div class="cd-icon">💿</div>

                                            <div class="flex-1">
                                                <div class="flex items-center justify-between flex-wrap gap-2 mb-2">
                                                    <span class="format-badge">
                                                        {{ strtoupper($item->category->name ?? 'CD') }}
                                                    </span>
                                                    <span class="text-xs text-gray-500">
                                                        📅 {{ $item->created_at->format('Y') }}
                                                    </span>
                                                </div>

                                                <h3 class="font-semibold text-indigo-200 mb-1">
                                                    {{ \Illuminate\Support\Str::limit($item->title, 60) }}
                                                </h3>

                                                <p class="text-gray-400 text-sm mb-3">
                                                    {{ \Illuminate\Support\Str::limit($item->abstract, 100) }}
                                                </p>

                                                <div class="flex items-center justify-between">
                                                    <div class="text-xs text-gray-500">
                                                        📂 {{ $item->category->name ?? '-' }}
                                                    </div>

                                                    <div class="flex gap-2">
                                                        <a href="{{ route('final_project.detail', $item->id) }}"
                                                           class="btn-link text-sm">
                                                            Lihat Detail →
                                                        </a>

                                                        @if($item->file_url)
                                                            <a href="{{ asset('storage/'.$item->file_url) }}"
                                                               target="_blank"
                                                               class="btn-primary text-xs py-1 px-3">
                                                                Dengar
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-12">
                                    <div class="text-5xl mb-3">💿</div>
                                    <p class="text-gray-400">Tidak ada koleksi ditemukan</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- PAGINATION -->
                        <div class="flex justify-center mt-8">
                            {{ $data->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
// ============================================
// SCRIPT UNTUK KOLEKSI CD/DVD (VERSI BLADE)
// ============================================

// 🔍 SEARCH AUTO SUBMIT (optional lebih smooth)
const searchInput = document.querySelector('input[name="search"]');

if (searchInput) {
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.closest('form').submit();
        }
    });
}

// ✨ ANIMASI FADE-UP
function initAnimation() {
    const elements = document.querySelectorAll('.fade-up');

    elements.forEach((el, i) => {
        setTimeout(() => {
            el.classList.add('show');
        }, i * 100);
    });
}

document.addEventListener('DOMContentLoaded', initAnimation);

// 🔔 NOTIFICATION SYSTEM (fallback kalau tidak ada di master)
function showNotification(message, type = 'success') {
    if (typeof showNotif === 'function') {
        showNotif(message, type);
        return;
    }

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

// 📄 DETAIL (sementara dummy → nanti bisa ke halaman detail)
function viewDetail(title) {
    showNotification(`📄 Detail untuk: ${title}`, 'info');
}

// 🎬 AKSI BUTTON
function borrowNow() {
    showNotification('🎬 Silakan datang ke Multimedia Lab untuk peminjaman.', 'info');
}

function accessGuide() {
    showNotification('📖 Panduan akses akan segera tersedia.', 'info');
}

// 🌐 GLOBAL (biar bisa dipanggil di onclick)
window.viewDetail = viewDetail;
window.borrowNow = borrowNow;
window.accessGuide = accessGuide;

console.log('Halaman Koleksi CD/DVD (Blade Version) siap 🚀');
</script>
@endpush
