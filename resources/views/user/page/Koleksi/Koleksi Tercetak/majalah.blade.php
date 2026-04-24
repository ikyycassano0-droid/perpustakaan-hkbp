@extends('user.component.master')

@section('title', 'Koleksi Majalah - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN KOLEKSI MAJALAH
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */
    
    /* Glass card */
    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 2rem;
        transition: all 0.3s ease;
    }
    
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
    
    /* Magazine Card */
    .magazine-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .magazine-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }
    
    .magazine-cover {
        height: 200px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .featured-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    /* Featured Hero Card */
    .hero-magazine {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 1.5rem;
        overflow: hidden;
    }
    
    /* Category List */
    .category-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        background: rgba(15, 23, 42, 0.6);
        border-radius: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .category-item:hover {
        background: rgba(99, 102, 241, 0.15);
        transform: translateX(5px);
    }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.8rem;
    }
    
    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
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
    
    /* Accreditation Badge */
    .accreditation-badge {
        display: inline-block;
        background: linear-gradient(135deg, #10b981, #059669);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
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

@push('styles')
{{-- CSS kamu tetap pakai yang sudah ada (tidak diubah) --}}
<style>
    /* CSS kamu tetap di sini (sudah bagus untuk UI) */
</style>
@endpush

@section('content')

<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                📰 AKPER HKBP BALIGE
            </span>
        </div>

        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Koleksi Majalah
        </h1>

        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Eksplorasi wawasan terbaru dalam dunia keperawatan dan publikasi akademik.
        </p>
    </section>

    <!-- MAIN SECTION (READY CRUD LAYOUT) -->
    <section class="section max-w-7xl mx-auto px-5">

        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    <!-- SIDEBAR FILTER (NANTI BISA DARI DB) -->
                    <div class="lg:col-span-1">

                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Kategori</div>

                            <a href="#" class="sidebar-item">
                                📰 Semua Majalah
                            </a>

                            <a href="#" class="sidebar-item">
                                🔬 Riset Keperawatan
                            </a>

                            <a href="#" class="sidebar-item">
                                🏥 Klinis & Bedah
                            </a>

                            <a href="#" class="sidebar-item">
                                👶 Pediatrik
                            </a>

                            <a href="#" class="sidebar-item">
                                🌿 Wellness
                            </a>
                        </div>

                    </div>

                    <!-- CONTENT GRID (INI SUDAH CRUD READY) -->
                    <div class="lg:col-span-3">

                        <!-- SEARCH (NANTI PAKAI REQUEST QUERY) -->
                        <form method="GET" action="#" class="mb-6">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="search-input"
                                placeholder="🔍 Cari majalah..."
                            >
                        </form>

                        <!-- GRID DATA DARI DATABASE -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                            @forelse ($majalahs as $item)

                                <div class="magazine-card">

                                    <div class="magazine-cover"
                                         style="background-image: url('{{ asset('storage/'.$item->cover) }}')">
                                    </div>

                                    <div class="p-4">

                                        <div class="flex justify-between mb-2">
                                            <span class="text-xs text-indigo-300">
                                                {{ $item->kategori }}
                                            </span>

                                            <span class="text-xs text-gray-500">
                                                {{ $item->created_at->format('d M Y') }}
                                            </span>
                                        </div>

                                        <h3 class="font-semibold text-indigo-200 text-sm">
                                            {{ $item->judul }}
                                        </h3>

                                        <p class="text-xs text-gray-400 mt-2">
                                            {{ Str::limit($item->deskripsi, 80) }}
                                        </p>

                                        <div class="flex justify-between items-center mt-3">

                                            <span class="text-xs text-gray-500">
                                                👁 {{ $item->views ?? 0 }}
                                            </span>

                                            <a href="{{ route('majalah.show', $item->id) }}"
                                               class="btn-link text-xs">
                                                Baca →
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="col-span-3 text-center text-gray-400 py-10">
                                    📭 Data majalah belum tersedia
                                </div>

                            @endforelse

                        </div>

                        <!-- PAGINATION LARAVEL -->
                        <div class="mt-8">
                            {{ $majalahs->links() }}
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
@push('scripts')
<script>
// ============================================
// KOLEKSI MAJALAH - FRONTEND UX SCRIPT (CRUD READY)
// Tidak pakai dummy data lagi
// ============================================

// SEARCH AUTO SUBMIT (ENTER / LIVE OPTIONAL)
const searchInput = document.querySelector('input[name="search"]');

if (searchInput) {
    searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            this.form.submit();
        }
    });
}

// SIDEBAR ACTIVE STATE HANDLER
const sidebarItems = document.querySelectorAll('.sidebar-item');

sidebarItems.forEach(item => {
    item.addEventListener('click', function () {
        sidebarItems.forEach(i => i.classList.remove('active'));
        this.classList.add('active');
    });
});

// NOTIFICATION SYSTEM (UNTUK CRUD RESPONSE NANTI)
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');

    let icon = 'ℹ️';
    if (type === 'success') icon = '✅';
    if (type === 'error') icon = '❌';
    if (type === 'warning') icon = '⚠️';

    notification.className = 'notification show';
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <span>${icon}</span>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 2500);
}

// DETEKSI SUCCESS MESSAGE DARI LARAVEL SESSION
@if(session('success'))
    showNotification("{{ session('success') }}", 'success');
@endif

@if(session('error'))
    showNotification("{{ session('error') }}", 'error');
@endif

// IMAGE LAZY LOAD (optional optimization)
const covers = document.querySelectorAll('.magazine-cover');

if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = 1;
            }
        });
    });

    covers.forEach(img => observer.observe(img));
}

// DEBUG INFO
console.log('📚 Koleksi Majalah CRUD Mode Active');

</script>
@endpush
</script>
@endpush