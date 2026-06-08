{{-- resources/views/user/page/Koleksi/Koleksi_Tercetak/jurnal.blade.php --}}
@extends('user.component.master')

@section('title', 'Koleksi Jurnal - AKPER HKBP')

@push('styles')
<style>
    /* === GAYA ASLI JURNAL (PUTIH HIJAU) === */
    .main-container {
        display: flex;
        max-width: 1300px;
        margin: 40px auto;
        padding: 0 20px;
        gap: 30px;
        align-items: flex-start;
    }

    .sidebar {
        width: 260px;
        flex-shrink: 0;
        background: var(--card-bg);
        padding: 16px;
        border-radius: 14px;
        box-shadow: 0 4px 16px rgba(15, 74, 49, 0.06);
        border: 1px solid var(--border-color);
        position: sticky;
        top: 100px;
    }

    .sidebar h3 {
        font-size: 0.85rem;
        margin-bottom: 14px;
        color: var(--text-dark);
        padding-bottom: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        border-bottom: 1.5px solid #e2e8f0;
    }

    .filter-group {
        margin-bottom: 20px;
    }

    .filter-group h4 {
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-bottom: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    /* === GAYA MINIMALIS RENTANG TAHUN === */
    .range-wrapper {
        background: #fafcfb;
        border-radius: 10px;
        padding: 12px 10px;
        border: 1px solid #eef2f0;
    }

    .range-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .range-header-item {
        text-align: center;
        flex: 1;
    }

    .range-header-label {
        font-size: 0.6rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }

    .range-header-value {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--primary-color);
        font-family: monospace;
        background: #eef3f0;
        display: inline-block;
        padding: 2px 8px;
        border-radius: 16px;
    }

    .double-range-container {
        position: relative;
        height: 32px;
        margin: 4px 0 8px;
    }

    .range-track {
        position: absolute;
        top: 14px;
        left: 0;
        right: 0;
        height: 3px;
        background: #e2e8f0;
        border-radius: 3px;
    }

    .range-fill {
        position: absolute;
        top: 14px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 3px;
        pointer-events: none;
    }

    .range-input {
        position: absolute;
        top: 6px;
        left: 0;
        width: 100%;
        height: 20px;
        background: transparent;
        pointer-events: none;
    }

    .range-input input {
        position: absolute;
        width: 100%;
        height: 20px;
        background: transparent;
        -webkit-appearance: none;
        pointer-events: auto;
    }

    .range-input input:focus {
        outline: none;
    }

    .range-input input::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 12px;
        height: 12px;
        background: white;
        border: 2px solid var(--primary-color);
        border-radius: 50%;
        cursor: pointer;
        pointer-events: auto;
        transition: all 0.15s ease;
    }

    .range-input input::-webkit-slider-thumb:hover {
        transform: scale(1.2);
        background: var(--primary-color);
    }

    .range-input input::-moz-range-thumb {
        width: 12px;
        height: 12px;
        background: white;
        border: 2px solid var(--primary-color);
        border-radius: 50%;
        cursor: pointer;
        pointer-events: auto;
    }

    .range-values {
        display: flex;
        gap: 8px;
        margin: 12px 0 10px;
    }

    .range-value-box {
        flex: 1;
        text-align: center;
        background: #ffffff;
        border-radius: 8px;
        padding: 6px 4px;
        border: 1px solid #edf2f0;
    }

    .range-value-box label {
        font-size: 0.6rem;
        color: #94a3b8;
        display: block;
        margin-bottom: 3px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .range-value-box span {
        display: inline-block;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--primary-color);
        font-family: monospace;
    }

    .btn-reset-tahun {
        margin-top: 10px;
        padding: 6px 10px;
        background: transparent;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        font-size: 0.65rem;
        cursor: pointer;
        width: 100%;
        transition: 0.2s;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .btn-reset-tahun:hover {
        background: #f1f5f9;
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .filter-active-indicator {
        margin-top: 10px;
        padding-top: 8px;
        border-top: 1px solid #eef2f0;
        font-size: 0.6rem;
        color: var(--primary-color);
        text-align: center;
        font-weight: 500;
    }

    /* ================= SISANYA SAMA ================= */
    .content-section {
        flex-grow: 1;
        min-width: 0;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-header span {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        background: #e0f0e8;
        padding: 4px 12px;
        border-radius: 50px;
    }

    .page-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--text-dark);
        margin-top: 10px;
        font-weight: 800;
    }

    .filter-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }

    .search-item {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        padding: 0 15px;
    }

    .search-item i {
        color: var(--text-muted);
        margin-right: 10px;
    }

    .search-item input,
    .search-item select {
        border: none;
        outline: none;
        padding: 12px 0;
        width: 100%;
        font-size: 0.9rem;
        background: transparent;
        color: var(--text-dark);
    }

    .book-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        gap: 25px;
        margin-bottom: 20px;
        transition: 0.3s;
        border: 1px solid var(--border-color);
        border-top: 4px solid var(--accent-yellow);
        box-shadow: 0 4px 12px rgba(15, 74, 49, 0.05);
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(15, 74, 49, 0.12);
    }

    .book-img {
        width: 140px;
        height: 190px;
        background: #eee;
        border-radius: 8px;
        object-fit: cover;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .book-info {
        flex-grow: 1;
    }

    .book-info .category-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: var(--accent-yellow);
        color: var(--primary-color);
        padding: 4px 12px;
        border-radius: 50px;
        display: inline-block;
    }

    .book-info h2 {
        font-size: 1.25rem;
        color: var(--primary-color);
        margin: 8px 0;
        cursor: pointer;
        line-height: 1.3;
        font-weight: 700;
    }

    .book-info p {
        font-size: 0.88rem;
        color: var(--text-muted);
        margin-bottom: 5px;
    }

    .book-info p strong {
        color: var(--primary-color);
    }

    .tags {
        margin-top: 15px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .tag {
        padding: 4px 12px;
        background: #f0f7f3;
        font-size: 0.75rem;
        border-radius: 50px;
        color: var(--primary-color);
        font-weight: 600;
    }

    .book-status {
        width: 160px;
        text-align: center;
        display: flex;
        flex-direction: column;
        gap: 12px;
        border-left: 1px solid var(--border-color);
        padding-left: 20px;
    }

    .stock-box {
        border: 1px solid var(--border-color);
        padding: 12px;
        border-radius: 12px;
        background: #fafdfb;
    }

    .stock-box span {
        display: block;
        font-size: 0.7rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 700;
    }

    .stock-box strong {
        font-size: 1.5rem;
        color: var(--primary-color);
    }

    .btn-action {
        padding: 10px;
        font-size: 0.8rem;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 50px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: 600;
        color: var(--text-muted);
        text-align: center;
        text-decoration: none;
        display: block;
    }

    .btn-action:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-action.borrow-btn {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-action.borrow-btn:hover {
        background: var(--deep-green);
        border-color: var(--deep-green);
    }

    .btn-action:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .status-badge {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 50px;
        display: inline-block;
        margin-top: 5px;
    }

    .status-badge.pending { background: #fff3cd; color: #856404; }
    .status-badge.approved { background: #d4edda; color: #155724; }
    .status-badge.rejected { background: #f8d7da; color: #721c24; }

    .pagination {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        display: block;
    }

    .empty-state h3 {
        margin-bottom: 10px;
        font-size: 1.2rem;
    }

    .empty-state p {
        font-size: 0.9rem;
    }

    /* === MODAL PEMINJAMAN === */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 74, 49, 0.4);
        backdrop-filter: blur(8px);
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        visibility: hidden;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        visibility: visible;
        opacity: 1;
    }

    .modal-container {
        background: white;
        border-radius: 24px;
        width: 100%;
        max-width: 480px;
        margin: 1rem;
        box-shadow: 0 25px 50px rgba(15, 74, 49, 0.25);
        border: 1px solid var(--border-color);
        transform: scale(0.9);
        transition: transform 0.3s ease;
        padding: 2rem;
    }

    .modal-overlay.active .modal-container {
        transform: scale(1);
    }

    .modal-container h2 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modal-container label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark);
        display: block;
        margin-bottom: 0.4rem;
    }

    .modal-container input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        background: #f9fbf9;
    }

    .modal-container input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(26, 107, 71, 0.1);
    }

    .modal-actions {
        display: flex;
        gap: 12px;
        margin-top: 1rem;
    }

    .btn-modal {
        flex: 1;
        padding: 12px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: 0.3s;
        border: none;
    }

    .btn-batal {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-submit {
        background: var(--primary-color);
        color: white;
    }

    .btn-submit:hover {
        background: var(--deep-green);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    @media (max-width: 1024px) {
        .sidebar { display: none; }
        .filter-row { grid-template-columns: 1fr; }
        .book-card { flex-direction: column; }
        .book-status {
            width: 100%;
            border-left: none;
            border-top: 1px solid var(--border-color);
            padding: 20px 0 0;
        }
    }
</style>
@endpush

@section('content')
<div class="main-container">
    {{-- SIDEBAR MINIMALIS --}}
    <aside class="sidebar">
        <h3>Ditapis dengan</h3>
        <div class="filter-group">
            <h4>Tahun Penerbitan</h4>

            <div class="range-wrapper">
                <div class="range-header">
                    <div class="range-header-item">
                        <div class="range-header-label">Dari</div>
                        <div class="range-header-value" id="rangeMinLabel">{{ $currentMinYear ?? ($minYear ?? 2000) }}</div>
                    </div>
                    <div class="range-header-item">
                        <div class="range-header-label">Sampai</div>
                        <div class="range-header-value" id="rangeMaxLabel">{{ $currentMaxYear ?? ($maxYear ?? date('Y')) }}</div>
                    </div>
                </div>

                <div class="double-range-container">
                    <div class="range-track"></div>
                    <div class="range-fill" id="rangeFill"></div>
                    <div class="range-input">
                        <input type="range" id="minYearSlider" min="{{ $minYear ?? 2000 }}" max="{{ $maxYear ?? date('Y') }}" value="{{ $currentMinYear ?? ($minYear ?? 2000) }}" step="1">
                        <input type="range" id="maxYearSlider" min="{{ $minYear ?? 2000 }}" max="{{ $maxYear ?? date('Y') }}" value="{{ $currentMaxYear ?? ($maxYear ?? date('Y')) }}" step="1">
                    </div>
                </div>

                <div class="range-values">
                    <div class="range-value-box">
                        <label>Min</label>
                        <span id="minYearValue">{{ $currentMinYear ?? ($minYear ?? 2000) }}</span>
                    </div>
                    <div class="range-value-box">
                        <label>Max</label>
                        <span id="maxYearValue">{{ $currentMaxYear ?? ($maxYear ?? date('Y')) }}</span>
                    </div>
                </div>

                <button class="btn-reset-tahun" id="resetYearBtn">
                    <i class="fas fa-undo-alt"></i> Reset
                </button>

                @if(request('year_min') || request('year_max'))
                <div class="filter-active-indicator">
                    <i class="fas fa-filter"></i>
                    {{ request('year_min', $minYear ?? 2000) }} — {{ request('year_max', $maxYear ?? date('Y')) }}
                </div>
                @endif
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="content-section">
        <div class="page-header">
            <span>Koleksi Tercetak</span>
            <h2>Koleksi Jurnal Keperawatan</h2>
        </div>

        <div class="filter-row">
            <div class="search-item">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari judul jurnal, penulis, atau ISSN..."
                       id="searchInput" value="{{ request('search') }}">
            </div>
            <div class="search-item">
                <select id="categoryFilter">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="search-item">
                <select id="sortOrder">
                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="popular">Terpopuler</option>
                    <option value="az">A - Z</option>
                </select>
            </div>
        </div>

        {{-- Daftar Koleksi --}}
        <div class="book-list">
            @forelse($collections as $collection)
                @php
                    $authors = is_array($collection->author)
                                ? $collection->author
                                : json_decode($collection->author, true) ?? [];
                    $authorNames = implode(', ', $authors);

                    $coverUrl = $collection->cover_image
                                ? asset('storage/' . $collection->cover_image)
                                : 'https://images.unsplash.com/photo-1589998059171-988d887df646?auto=format&fit=crop&w=400&q=80';

                    $tagNames = $collection->categories->pluck('name')->toArray();

                    $borrowStatus = $userBorrowStatus[$collection->id] ?? null;
                    $isBorrowed = $borrowStatus && in_array($borrowStatus['status'], ['PENDING', 'APPROVED']);
                    $statusText = $borrowStatus['status_text'] ?? null;
                @endphp

                <div class="book-card">
                    <img src="{{ $coverUrl }}" class="book-img" alt="Cover {{ $collection->title }}">
                    <div class="book-info">
                        <span class="category-label">JURNAL</span>
                        <h2 onclick="location.href='{{ route('user.koleksi.detail', $collection->id) }}'">
                            {{ $collection->title }}
                        </h2>
                        @if(!empty($authors))
                            <p><strong>Penulis:</strong> {{ $authorNames }}</p>
                        @endif
                        <p><strong>Penerbit:</strong> {{ $collection->publisher }}
                           @if($collection->publication_year)
                               -- {{ $collection->publication_year }}
                           @endif
                        </p>
                        @if(!empty($tagNames))
                        <div class="tags">
                            @foreach($tagNames as $tag)
                                <span class="tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="book-status">
                        <div class="stock-box">
                            <span>Ketersediaan</span>
                            <strong>{{ $collection->available_stock }}</strong>
                        </div>

                        @if(session()->has('user'))
                            @if($isBorrowed)
                                <span class="status-badge {{ strtolower($borrowStatus['status']) }}">
                                    {{ $statusText }}
                                </span>
                            @elseif($collection->available_stock > 0)
                                <button onclick="openModal({{ $collection->id }}, '{{ addslashes($collection->title) }}')"
                                        class="btn-action borrow-btn">
                                    <i class="fas fa-book"></i> Pinjam
                                </button>
                            @else
                                <button class="btn-action" disabled>Stok Habis</button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-action">Login untuk Pinjam</a>
                        @endif

                        {{-- TOMBOL LIHAT DETAIL --}}
                        <a href="{{ route('user.koleksi.detail', $collection->id) }}" class="btn-action">
                            <i class="fas fa-info-circle"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h3>Tidak ada jurnal ditemukan</h3>
                    <p>
                        @if(request('year_min') || request('year_max') || request('category') || request('search'))
                            Maaf, tidak ada jurnal yang sesuai dengan filter yang dipilih.
                            <br>Coba ubah atau <a href="{{ route('user.koleksi.jurnal') }}" style="color: var(--primary-color); text-decoration: underline;">reset filter</a>.
                        @else
                            Belum ada jurnal yang tersedia saat ini.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        @if($collections->hasPages())
            <div class="pagination">
                {{ $collections->appends(request()->query())->links() }}
            </div>
        @endif
    </main>
</div>

{{-- MODAL PEMINJAMAN --}}
<div id="pinjamModal" class="modal-overlay">
    <div class="modal-container">
        <h2><i class="fas fa-calendar-check" style="color:var(--primary-color);"></i> Form Peminjaman Jurnal</h2>
        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="collection_id" id="collection_id">
            <div>
                <label>Judul Jurnal</label>
                <input type="text" id="book_title" readonly>
            </div>
            <div>
                <label>Tanggal Pinjam</label>
                <input type="date" name="borrow_date" id="borrow_date" required>
            </div>
            <div>
                <label>Tanggal Kembali (maks. 3 hari)</label>
                <input type="date" name="return_date" id="return_date" required>
            </div>
            <div class="modal-actions">
                <button type="button" onclick="closeModal()" class="btn-modal btn-batal">Batal</button>
                <button type="submit" id="submitPinjamBtn" class="btn-modal btn-submit">Pinjam</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ================= FILTER RENTANG TAHUN =================
    const minSlider = document.getElementById('minYearSlider');
    const maxSlider = document.getElementById('maxYearSlider');
    const minValueSpan = document.getElementById('minYearValue');
    const maxValueSpan = document.getElementById('maxYearValue');
    const rangeFill = document.getElementById('rangeFill');
    const minLabel = document.getElementById('rangeMinLabel');
    const maxLabel = document.getElementById('rangeMaxLabel');

    const globalMin = parseInt(minSlider.min);
    const globalMax = parseInt(maxSlider.max);

    function updateRangeFill() {
        const minVal = parseInt(minSlider.value);
        const maxVal = parseInt(maxSlider.value);
        const percentMin = ((minVal - globalMin) / (globalMax - globalMin)) * 100;
        const percentMax = ((maxVal - globalMin) / (globalMax - globalMin)) * 100;
        rangeFill.style.left = percentMin + '%';
        rangeFill.style.width = (percentMax - percentMin) + '%';

        minValueSpan.innerText = minVal;
        maxValueSpan.innerText = maxVal;
        minLabel.innerText = minVal;
        maxLabel.innerText = maxVal;
    }

    function applyYearFilter() {
        const minYear = parseInt(minSlider.value);
        const maxYear = parseInt(maxSlider.value);

        const url = new URL(window.location.href);
        if (minYear > globalMin) {
            url.searchParams.set('year_min', minYear);
        } else {
            url.searchParams.delete('year_min');
        }

        if (maxYear < globalMax) {
            url.searchParams.set('year_max', maxYear);
        } else {
            url.searchParams.delete('year_max');
        }

        window.location.href = url.toString();
    }

    if (minSlider && maxSlider) {
        minSlider.addEventListener('input', function() {
            let minVal = parseInt(minSlider.value);
            let maxVal = parseInt(maxSlider.value);
            if (minVal > maxVal) {
                minSlider.value = maxVal;
                minVal = maxVal;
            }
            updateRangeFill();
        });

        maxSlider.addEventListener('input', function() {
            let minVal = parseInt(minSlider.value);
            let maxVal = parseInt(maxSlider.value);
            if (maxVal < minVal) {
                maxSlider.value = minVal;
                maxVal = minVal;
            }
            updateRangeFill();
        });

        minSlider.addEventListener('change', applyYearFilter);
        maxSlider.addEventListener('change', applyYearFilter);

        updateRangeFill();
    }

    document.getElementById('resetYearBtn')?.addEventListener('click', function() {
        const url = new URL(window.location.href);
        url.searchParams.delete('year_min');
        url.searchParams.delete('year_max');
        window.location.href = url.toString();
    });

    // ================= FUNGSI FILTER LAINNYA =================
    function updateFilter(param, value) {
        const url = new URL(window.location.href);
        if (value) {
            url.searchParams.set(param, value);
        } else {
            url.searchParams.delete(param);
        }
        window.location.href = url.toString();
    }

    document.getElementById('categoryFilter')?.addEventListener('change', function() {
        updateFilter('category', this.value);
    });

    document.getElementById('sortOrder')?.addEventListener('change', function() {
        updateFilter('sort', this.value);
    });

    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    searchInput?.addEventListener('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            updateFilter('search', this.value);
        }, 500);
    });

    // ================= MODAL PEMINJAMAN =================
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function openModal(id, title) {
        const modal = document.getElementById('pinjamModal');
        modal.classList.add('active');

        document.getElementById('collection_id').value = id;
        document.getElementById('book_title').value = title;

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const borrowInput = document.getElementById('borrow_date');
        const returnInput = document.getElementById('return_date');

        borrowInput.value = '';
        returnInput.value = '';

        borrowInput.min = formatDate(today);
        borrowInput.value = formatDate(today);

        const minReturn = new Date(today);
        minReturn.setDate(minReturn.getDate() + 1);
        const maxReturn = new Date(today);
        maxReturn.setDate(maxReturn.getDate() + 3);

        returnInput.min = formatDate(minReturn);
        returnInput.max = formatDate(maxReturn);
        returnInput.value = formatDate(minReturn);
    }

    function closeModal() {
        const modal = document.getElementById('pinjamModal');
        modal.classList.remove('active');
        document.getElementById('pinjamForm').reset();
        const submitBtn = document.getElementById('submitPinjamBtn');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Pinjam';
        }
    }

    document.addEventListener('click', function(e) {
        const modal = document.getElementById('pinjamModal');
        if (e.target === modal) closeModal();
    });

    document.addEventListener('change', function(e) {
        if (e.target.id === 'borrow_date') {
            const borrow = new Date(e.target.value);
            borrow.setHours(0, 0, 0, 0);
            const returnInput = document.getElementById('return_date');
            const minReturn = new Date(borrow);
            minReturn.setDate(minReturn.getDate() + 1);
            const maxReturn = new Date(borrow);
            maxReturn.setDate(maxReturn.getDate() + 3);
            returnInput.min = formatDate(minReturn);
            returnInput.max = formatDate(maxReturn);
            const curReturn = new Date(returnInput.value);
            if (curReturn < minReturn || curReturn > maxReturn) {
                returnInput.value = formatDate(minReturn);
            }
        }
    });

    document.addEventListener('submit', function(e) {
        if (e.target.id === 'pinjamForm') {
            e.preventDefault();
            const borrow = new Date(document.getElementById('borrow_date').value);
            const ret = new Date(document.getElementById('return_date').value);
            borrow.setHours(0, 0, 0, 0);
            ret.setHours(0, 0, 0, 0);
            const diff = (ret - borrow) / (1000 * 60 * 60 * 24);
            if (diff < 1) {
                alert('Minimal peminjaman 1 hari');
                return;
            }
            if (diff > 3) {
                alert('Maksimal peminjaman hanya 3 hari');
                return;
            }
            const btn = document.getElementById('submitPinjamBtn');
            if (btn) {
                btn.innerText = 'Memproses...';
                btn.disabled = true;
            }
            e.target.submit();
        }
    });
</script>
@endpush
