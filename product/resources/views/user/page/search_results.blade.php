@extends(is_logged_in() ? 'user.component.master' : 'guest.component.master')

@section('title', 'Hasil Pencarian - AKPER HKBP Balige')

@push('styles')
<style>
    /* ===== KHUSUS UNTUK HALAMAN PENCARIAN ===== */
    .search-hero {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05));
        border-bottom: 1px solid rgba(99, 102, 241, 0.2);
        position: relative;
        overflow: hidden;
    }

    .search-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 80%;
        height: 200%;
        background: radial-gradient(circle, rgba(99,102,241,0.08), transparent);
        border-radius: 50%;
        pointer-events: none;
    }

    .result-stats {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        padding: 0.5rem 1.25rem;
        border-radius: 40px;
        border: 1px solid rgba(99, 102, 241, 0.3);
    }

    .filter-sidebar {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        padding: 1.5rem;
        position: sticky;
        top: 100px;
        transition: all 0.3s ease;
    }

    .filter-sidebar:hover {
        border-color: rgba(99, 102, 241, 0.6);
        box-shadow: 0 0 25px rgba(99, 102, 241, 0.1);
    }

    .filter-title {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #a5b4fc;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }

    .filter-group {
        margin-bottom: 1.25rem;
    }

    .filter-label {
        font-size: 0.7rem;
        font-weight: 500;
        color: #94a3b8;
        margin-bottom: 0.5rem;
        display: block;
    }

    .filter-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #cbd5e1;
        font-size: 0.85rem;
    }

    .filter-option:hover {
        color: white;
        padding-left: 0.25rem;
    }

    .filter-option input {
        accent-color: #6366f1;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .sort-select {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 40px;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.85rem;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
    }

    .sort-select:hover, .sort-select:focus {
        border-color: #6366f1;
        outline: none;
    }

    .search-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .search-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.4);
    }

    .card-thumb {
        height: 160px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .card-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }

    .badge-collection {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.95), rgba(139, 92, 246, 0.95));
        color: white;
    }

    .badge-final {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.95), rgba(5, 150, 105, 0.95));
        color: white;
    }

    .restricted-badge {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(239, 68, 68, 0.9);
        backdrop-filter: blur(4px);
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 600;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .highlight {
        background: linear-gradient(120deg, rgba(99, 102, 241, 0.3), rgba(139, 92, 246, 0.1));
        color: #a5b4fc;
        padding: 0 2px;
        border-radius: 4px;
        font-weight: 500;
    }

    .btn-detail {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 0.5rem 1rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 500;
        color: white;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
    }

    .btn-detail:hover {
        transform: scale(1.03);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
    }

    /* Pagination Styling */
    .pagination-custom {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .pagination-custom .page-item {
        list-style: none;
    }

    .pagination-custom .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 10px;
        color: #c7d2fe;
        transition: all 0.3s ease;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .pagination-custom .page-link:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
        transform: translateY(-2px);
    }

    .pagination-custom .active .page-link {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }

    .pagination-custom .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Loading Skeleton */
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .loading-skeleton-card {
        background: rgba(15, 23, 42, 0.4);
        border-radius: 1.25rem;
        overflow: hidden;
    }

    .skeleton-thumb {
        height: 160px;
        background: linear-gradient(90deg, rgba(30, 41, 59, 0.6) 25%, rgba(51, 65, 85, 0.8) 50%, rgba(30, 41, 59, 0.6) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    .skeleton-line {
        height: 12px;
        background: linear-gradient(90deg, rgba(30, 41, 59, 0.6) 25%, rgba(51, 65, 85, 0.8) 50%, rgba(30, 41, 59, 0.6) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 6px;
        margin: 0.75rem 1rem;
    }

    .skeleton-line-sm {
        width: 60%;
        height: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .filter-sidebar {
            position: relative;
            top: 0;
            margin-bottom: 1.5rem;
        }
        .result-stats {
            font-size: 0.8rem;
            padding: 0.35rem 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO SECTION PENCARIAN -->
    <section class="search-hero py-12 px-5">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col items-center text-center">
                <div class="inline-block glass-card px-5 py-2 rounded-full mb-4 fade-up">
                    <span class="text-indigo-300 text-sm font-medium tracking-wide">🔍 PENCARIAN DIGITAL</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-bold title-main mb-3 fade-up">
                    Hasil Pencarian
                </h1>
                <div class="result-stats fade-up mt-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="text-gray-300">Menampilkan <span class="text-indigo-300 font-semibold" id="resultCount">
                        {{ method_exists($results, 'total') ? number_format($results->total()) : number_format($results->count()) }}
                    </span> hasil untuk</span>
                    <span class="text-indigo-300 font-semibold bg-indigo-500/20 px-2 py-0.5 rounded-full">"{{ $keyword }}"</span>
                </div>
            </div>
        </div>
    </section>

    <!-- KONTEN UTAMA: FILTER + HASIL -->
    <section class="py-10 px-5">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                <!-- SIDEBAR FILTER (Sticky) -->
                <div class="lg:col-span-1">
                    <div class="filter-sidebar fade-up">
                        <div class="filter-title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filter Pencarian
                        </div>

                        <div class="filter-group">
                            <span class="filter-label">📂 Tipe Konten</span>
                            <label class="filter-option">
                                <input type="checkbox" value="collection" class="type-filter" id="filterCollection">
                                <span>📚 Koleksi Buku</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="final" class="type-filter" id="filterFinal">
                                <span>📄 KTI / Tugas Akhir</span>
                            </label>
                        </div>

                        <div class="filter-group">
                            <span class="filter-label">🔄 Urutkan Berdasarkan</span>
                            <select id="sortBy" class="sort-select">
                                <option value="relevance">Relevansi (Default)</option>
                                <option value="title_asc">Judul (A-Z)</option>
                                <option value="title_desc">Judul (Z-A)</option>
                                <option value="newest">Terbaru</option>
                                <option value="oldest">Terlama</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mt-4">
                            <button id="applyFilterBtn" class="btn-primary text-sm py-2">
                                Terapkan
                            </button>
                            <button id="resetFilterBtn" class="btn-outline text-sm py-2">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- HASIL PENCARIAN -->
                <div class="lg:col-span-3">

                    <!-- Loading Skeleton -->
                    <div id="loadingSkeleton" class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: none;">
                        @for($i = 0; $i < 6; $i++)
                            <div class="loading-skeleton-card">
                                <div class="skeleton-thumb"></div>
                                <div class="skeleton-line"></div>
                                <div class="skeleton-line skeleton-line-sm"></div>
                                <div class="skeleton-line" style="width: 40%; margin-bottom: 1rem;"></div>
                            </div>
                        @endfor
                    </div>

                    <!-- Hasil konten -->
                    <div id="resultsContainer">
                        @if($results->count() == 0)
                            <div class="empty-state fade-up">
                                <div class="text-6xl mb-4 opacity-50">🔍</div>
                                <h3 class="text-xl font-semibold text-gray-300 mb-2">Tidak ditemukan hasil</h3>
                                <p class="text-gray-400">Coba kata kunci lain atau gunakan filter yang berbeda.</p>
                                <div class="flex justify-center gap-3 mt-6">
                                    <a href="{{ url('/') }}" class="btn-primary">Kembali ke Beranda</a>
                                    <button onclick="resetFilters()" class="btn-outline">Reset Filter</button>
                                </div>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="searchResultsGrid">
                                @foreach($results as $item)
                                    @php
                                        $highlightedTitle = preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<span class="highlight">$1</span>', e($item->title));
                                        $description = $item->description ?? ($item->abstract ?? '');
                                        $descClean = strip_tags($description);
                                        $highlightedDesc = preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<span class="highlight">$1</span>', Str::limit($descClean, 120));
                                    @endphp
                                    <div class="search-card fade-up" data-type="{{ $item->type }}">
                                        @if($item->type == 'collection')
                                            <div class="card-thumb" style="background-image: url('{{ $item->cover ? asset('storage/'.$item->cover) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=160&fit=crop' }}')">
                                                <span class="card-badge badge-collection">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                    Koleksi
                                                </span>
                                                @if(!empty($item->is_restricted))
                                                    <span class="restricted-badge">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                        Terbatas
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="p-4 flex flex-col flex-1">
                                                <h3 class="font-bold text-indigo-200 text-base mb-1 line-clamp-2">{!! $highlightedTitle !!}</h3>
                                                <p class="text-gray-400 text-sm mb-3 line-clamp-2">{!! $highlightedDesc !!}</p>
                                                <div class="flex items-center justify-between mt-auto">
                                                    <span class="text-xs text-gray-500">📚 Perpustakaan</span>
                                                    <a href="{{ url('/collections/'.$item->id) }}" class="btn-detail">Lihat Detail →</a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="card-thumb" style="background-image: url('{{ $item->thumbnail ?? 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=160&fit=crop' }}')">
                                                <span class="card-badge badge-final">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    KTI
                                                </span>
                                            </div>
                                            <div class="p-4 flex flex-col flex-1">
                                                <h3 class="font-bold text-indigo-200 text-base mb-1 line-clamp-2">{!! $highlightedTitle !!}</h3>
                                                <p class="text-gray-400 text-sm mb-3 line-clamp-2">{!! $highlightedDesc !!}</p>
                                                <div class="flex gap-2 mt-auto">
                                                    @if($item->file_url)
                                                        <a href="{{ asset('storage/'.$item->file_url) }}" class="btn-detail flex-1 text-center" target="_blank">
                                                            📖 Baca
                                                        </a>
                                                        <a href="{{ asset('storage/'.$item->file_url) }}" download class="btn-detail bg-indigo-700 hover:bg-indigo-600 flex-1 text-center">
                                                            ⬇️ Download
                                                        </a>
                                                    @else
                                                        <span class="text-gray-500 text-sm text-center w-full">File tidak tersedia</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination dengan pengecekan apakah $results adalah paginator -->
                            @if(method_exists($results, 'links') && $results->hasPages())
                                <div class="mt-10">
                                    {{ $results->appends(request()->except('page'))->links('pagination::tailwind') }}
                                </div>
                            @elseif(method_exists($results, 'links'))
                                <div class="mt-10">
                                    {{ $results->links('pagination::tailwind') }}
                                </div>
                            @endif
                        @endif
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
    // FITUR FILTER DAN SORTIR (CLIENT-SIDE/RELOAD)
    // ============================================

    // Elemen DOM
    const applyFilterBtn = document.getElementById('applyFilterBtn');
    const resetFilterBtn = document.getElementById('resetFilterBtn');
    const sortSelect = document.getElementById('sortBy');
    const filterCollection = document.getElementById('filterCollection');
    const filterFinal = document.getElementById('filterFinal');
    const loadingSkeleton = document.getElementById('loadingSkeleton');
    const resultsContainer = document.getElementById('resultsContainer');

    // Fungsi untuk menerapkan filter via URL parameter
    function applyFilters() {
        let params = new URLSearchParams(window.location.search);

        // Filter tipe
        let selectedTypes = [];
        if (filterCollection?.checked) selectedTypes.push('collection');
        if (filterFinal?.checked) selectedTypes.push('final');

        if (selectedTypes.length > 0) {
            params.set('type', selectedTypes.join(','));
        } else {
            params.delete('type');
        }

        // Sortir
        if (sortSelect && sortSelect.value !== 'relevance') {
            params.set('sort', sortSelect.value);
        } else {
            params.delete('sort');
        }

        // Reset ke halaman 1
        params.delete('page');

        // Tampilkan loading
        if (loadingSkeleton && resultsContainer) {
            resultsContainer.style.display = 'none';
            loadingSkeleton.style.display = 'grid';
        }

        window.location.search = params.toString();
    }

    // Reset filter
    function resetFilters() {
        let params = new URLSearchParams(window.location.search);
        params.delete('type');
        params.delete('sort');
        params.delete('page');
        window.location.search = params.toString();
    }

    // Inisialisasi nilai filter dari URL saat halaman dimuat
    function initFiltersFromURL() {
        let urlParams = new URLSearchParams(window.location.search);
        let typeParam = urlParams.get('type');
        let sortParam = urlParams.get('sort');

        if (typeParam) {
            let types = typeParam.split(',');
            if (filterCollection) filterCollection.checked = types.includes('collection');
            if (filterFinal) filterFinal.checked = types.includes('final');
        }

        if (sortParam && sortSelect) {
            sortSelect.value = sortParam;
        } else if (sortSelect) {
            sortSelect.value = 'relevance';
        }
    }

    // Event listeners
    if (applyFilterBtn) applyFilterBtn.addEventListener('click', applyFilters);
    if (resetFilterBtn) resetFilterBtn.addEventListener('click', resetFilters);

    // Sembunyikan loading setelah halaman selesai dimuat
    window.addEventListener('load', function() {
        if (loadingSkeleton) loadingSkeleton.style.display = 'none';
        if (resultsContainer) resultsContainer.style.display = 'block';
    });

    // Inisialisasi
    initFiltersFromURL();

    // ============================================
    // ANIMASI FADE-UP
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
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
    });

    // ============================================
    // NOTIFIKASI (jika diperlukan untuk restricted)
    // ============================================
    window.showNotif = window.showNotif || function(message, type) {
        const notif = document.createElement('div');
        notif.className = `notif ${type}`;
        notif.innerHTML = `<span>${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}</span>${message}`;
        document.body.appendChild(notif);
        setTimeout(() => notif.classList.add('show'), 50);
        setTimeout(() => {
            notif.classList.remove('show');
            setTimeout(() => notif.remove(), 400);
        }, 3000);
    };
</script>
@endpush
