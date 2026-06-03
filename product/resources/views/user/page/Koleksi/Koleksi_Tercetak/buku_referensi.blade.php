{{-- resources/views/user/page/koleksi_tercetak/buku_referensi.blade.php --}}
@extends('user.component.master')

@section('title', 'Koleksi Buku Referensi - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    /* ============================================
       GAYA BUKU REFERENSI (TEMA HIJAU KUNING)
       Sama seperti halaman lain, konsisten dengan master
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
        --danger: #e74c3c;
    }

    .main-container {
        display: flex;
        max-width: 1400px;
        margin: 40px auto;
        padding: 0 20px;
        gap: 30px;
        align-items: flex-start;
    }

    .sidebar {
        width: 280px;
        flex-shrink: 0;
        background: var(--card-bg);
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        position: sticky;
        top: 100px;
    }

    .sidebar h3 {
        font-size: 1.1rem;
        margin-bottom: 20px;
        color: var(--text-dark);
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
        font-weight: 800;
    }

    .filter-group {
        margin-bottom: 25px;
    }

    .filter-group h4 {
        font-size: 0.95rem;
        color: var(--text-muted);
        margin-bottom: 15px;
        font-weight: 700;
    }

    .range-slider {
        width: 100%;
        cursor: pointer;
        accent-color: var(--primary-color);
        margin-bottom: 10px;
    }

    .year-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: var(--text-muted);
        font-weight: 600;
    }

    .filter-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        font-size: 0.9rem;
        color: var(--text-muted);
        cursor: pointer;
    }

    .filter-item input {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: var(--primary-color);
    }

    .content-section {
        flex-grow: 1;
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
        display: inline-block;
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
        margin-bottom: 20px;
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

    .filter-container {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .chip {
        padding: 8px 18px;
        background: var(--card-bg);
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        transition: 0.3s;
        border: 1px solid var(--border-color);
        white-space: nowrap;
    }

    .chip.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .chip:hover:not(.active) {
        background: #f0f7f3;
        border-color: var(--accent-green);
        color: var(--primary-color);
    }

    /* Book Card */
    .book-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 25px;
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

    .book-img-box {
        width: 140px;
        height: 200px;
        background: #f0f7f3;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .book-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .book-detail-info {
        flex-grow: 1;
    }

    .cat-tag {
        font-size: 0.7rem;
        font-weight: 800;
        background: var(--accent-yellow);
        color: var(--primary-color);
        padding: 4px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        display: inline-block;
    }

    .book-title-link {
        font-size: 1.3rem;
        color: var(--primary-color);
        margin: 10px 0 5px;
        cursor: pointer;
        display: block;
        font-weight: 700;
        text-decoration: none;
    }

    .book-title-link:hover {
        text-decoration: underline;
    }

    .book-author {
        font-size: 0.95rem;
        color: var(--text-muted);
        margin-bottom: 5px;
    }

    .data-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: 15px;
        border-top: 1px solid var(--border-color);
        padding-top: 15px;
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .data-grid strong {
        color: var(--primary-color);
    }

    .action-side {
        width: 170px;
        border-left: 1px solid var(--border-color);
        padding-left: 25px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    .stock-box {
        border: 1px solid var(--border-color);
        background: #fafdfb;
        padding: 12px;
        border-radius: 12px;
    }

    .stock-box small {
        font-size: 0.7rem;
        color: var(--text-muted);
        display: block;
        text-transform: uppercase;
        font-weight: 700;
    }

    .stock-box b {
        font-size: 1.6rem;
        color: var(--primary-color);
    }

    .btn-sm {
        padding: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 50px;
        border: 1px solid var(--border-color);
        background: white;
        cursor: pointer;
        transition: 0.2s;
        color: var(--text-muted);
        width: 100%;
    }

    .btn-sm:hover:not(:disabled) {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-sm:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Tooltip */
    .btn-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .btn-wrapper .tooltip-text {
        visibility: hidden;
        background-color: rgba(0,0,0,0.85);
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 6px 12px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        font-size: 0.7rem;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }

    .btn-wrapper:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* Notification */
    .notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 12px 24px;
        background: #0d2137;
        backdrop-filter: blur(12px);
        border: 1px solid var(--primary-color);
        border-radius: 12px;
        color: white;
        z-index: 1000;
        transform: translateX(120%);
        transition: transform 0.3s ease;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .notification.show {
        transform: translateX(0);
    }

    @media (max-width: 1024px) {
        .sidebar {
            display: none;
        }
        .filter-row {
            grid-template-columns: 1fr;
        }
        .book-card {
            flex-direction: column;
        }
        .action-side {
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

    <!-- Sidebar (statis, hanya UI) -->
    <aside class="sidebar">
        <h3>Ditapis dengan</h3>
        <div class="filter-group">
            <h4>Tahun Penerbitan</h4>
            <input type="range" min="2000" max="{{ date('Y') }}" value="{{ date('Y') }}" class="range-slider" id="yearSlider">
            <div class="year-label">
                <span>2000</span>
                <span id="currentYear" style="color:var(--primary-color); font-weight:800;">{{ date('Y') }}</span>
                <span>{{ date('Y') }}</span>
            </div>
        </div>
        <div class="filter-group">
            <h4>Lokasi Rak</h4>
            <label class="filter-item"><input type="checkbox"> Lantai 1 - Referensi (15)</label>
            <label class="filter-item"><input type="checkbox"> Ruang Baca Dosen (5)</label>
            <label class="filter-item"><input type="checkbox"> Lab Dasar (3)</label>
        </div>
        <div class="filter-group">
            <h4>Bahasa</h4>
            <label class="filter-item"><input type="checkbox"> Indonesia (15)</label>
            <label class="filter-item"><input type="checkbox"> Inggris (5)</label>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="content-section">
        <div class="page-header">
            <span>Koleksi Tercetak</span>
            <h2>Koleksi Buku Referensi Utama</h2>
        </div>

        <!-- Form Search & Filter (server-side) -->
        <form method="GET" action="{{ route('user.koleksi.buku_referensi') }}" class="filter-row">
            <div class="search-item">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul referensi, kamus, atau atlas...">
            </div>
            <div class="search-item">
                <select name="category">
                    <option value="">Semua Subjek</option>
                    @php
                        $categories = \App\Models\CategoryCollection::orderBy('name')->get();
                    @endphp
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="search-item">
                <select name="sort">
                    <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Terbaru</option>
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                </select>
            </div>
        </form>

        <!-- Category Chips -->
        <div class="filter-container">
            <a href="{{ route('user.koleksi.buku_referensi', array_merge(request()->except('category'), ['category' => ''])) }}"
               class="chip {{ !request('category') ? 'active' : '' }}">Semua Referensi</a>
            @foreach($categories as $cat)
                <a href="{{ route('user.koleksi.buku_referensi', array_merge(request()->except('category'), ['category' => $cat->id])) }}"
                   class="chip {{ request('category') == $cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
            @endforeach
        </div>

        <!-- Daftar Buku Referensi -->
        <div class="book-list">
            @forelse($collections as $item)
                @php
                    $borrowStatus = $userBorrowStatus[$item->id] ?? null;
                    $authorStr = '';
                    if (!empty($item->author)) {
                        if (is_array($item->author)) {
                            $authorStr = implode(', ', $item->author);
                        } else {
                            $authorStr = $item->author;
                        }
                    }
                    $categoryName = $item->categories->isNotEmpty() ? $item->categories->first()->name : 'Referensi Utama';
                    $keywords = $item->keywords;
                    if (is_array($keywords)) {
                        $keywords = implode(', ', $keywords);
                    }

                    // ========== LOGIKA PEMINJAMAN DENGAN BATAS 3 BUKU ==========
                    $buttonText = 'Pinjam';
                    $buttonDisabled = false;
                    $buttonOnclick = "openModal({$item->id}, '".addslashes($item->title)."')";
                    $tooltipText = '';

                    if (session()->has('user')) {
                        $activeBorrowCount = \App\Models\Order::where('user_id', auth()->id())
                            ->whereIn('status', ['PENDING', 'APPROVED'])
                            ->count();

                        if ($borrowStatus) {
                            switch ($borrowStatus['status']) {
                                case 'PENDING':
                                    $buttonText = '⏳ Menunggu Konfirmasi';
                                    $buttonDisabled = true;
                                    $buttonOnclick = '';
                                    $tooltipText = 'Pengajuan peminjaman sedang diproses admin';
                                    break;
                                case 'APPROVED':
                                    $buttonText = '📚 Sedang Dipinjam';
                                    $buttonDisabled = true;
                                    $buttonOnclick = '';
                                    $tooltipText = 'Anda sedang meminjam buku ini';
                                    break;
                                case 'REJECTED':
                                    $buttonText = '🔄 Pinjam Lagi';
                                    $buttonDisabled = false;
                                    $buttonOnclick = "openModal({$item->id}, '".addslashes($item->title)."')";
                                    $tooltipText = 'Pengajuan sebelumnya ditolak, Anda dapat meminjam ulang';
                                    break;
                            }
                        } else {
                            if ($item->available_stock < 1) {
                                $buttonText = '❌ Habis';
                                $buttonDisabled = true;
                                $buttonOnclick = '';
                                $tooltipText = 'Stok buku sedang kosong';
                            } elseif ($activeBorrowCount >= 3) {
                                $buttonText = '⚠️ Maksimal 3 Buku';
                                $buttonDisabled = true;
                                $buttonOnclick = '';
                                $tooltipText = 'Anda sudah mencapai batas maksimal peminjaman (3 buku)';
                            } else {
                                $buttonText = 'Pinjam';
                                $buttonDisabled = false;
                                $buttonOnclick = "openModal({$item->id}, '".addslashes($item->title)."')";
                                $tooltipText = 'Pinjam buku ini';
                            }
                        }
                    } else {
                        // Guest
                        $buttonText = '🔑 Login';
                        $buttonDisabled = false;
                        $buttonOnclick = "window.location.href='{{ route('login') }}'";
                        $tooltipText = 'Silakan login untuk meminjam buku';
                    }
                @endphp

                <div class="book-card">
                    <div class="book-img-box">
                        <img src="{{ $item->cover_image ? asset('storage/'.$item->cover_image) : 'https://via.placeholder.com/140x200?text=Referensi' }}" alt="Cover">
                    </div>
                    <div class="book-detail-info">
                        <span class="cat-tag">{{ $categoryName }}</span>
                        <a href="{{ route('user.koleksi.detail', $item->id) }}" class="book-title-link">{{ $item->title }}</a>
                        <p class="book-author">Oleh: <strong>{{ $authorStr ?: 'Tim Penyusun' }}</strong></p>

                        <div class="data-grid">
                            <span><strong>ISBN:</strong> {{ $item->isbn ?? '-' }}</span>
                            <span><strong>Penerbit:</strong> {{ $item->publisher ?? 'AKPER HKBP Press' }}, {{ $item->publication_year ?? date('Y') }}</span>
                            <span><strong>Subjek:</strong> {{ $item->subject ?? ($keywords ?? '-') }}</span>
                            <span><strong>Bahasa:</strong> {{ $item->language ?? 'Indonesia' }}</span>
                            <span><strong>Klasifikasi:</strong> {{ $item->classification ?? '-' }}</span>
                            <span><strong>Carrier Type:</strong> {{ $item->carrier_type ?? 'Volume' }}</span>
                        </div>
                    </div>
                    <div class="action-side">
                        <div class="stock-box">
                            <small>Ketersediaan</small>
                            <b>{{ $item->available_stock ?? 0 }}</b>
                        </div>
                        @if($item->marc_file)
                            <button class="btn-sm" onclick="window.open('{{ asset('storage/'.$item->marc_file) }}', '_blank')">Unduh MARC</button>
                        @endif
                        <button class="btn-sm" onclick="showCitation('{{ addslashes($item->title) }}', '{{ addslashes($authorStr) }}', '{{ addslashes($item->publisher) }}', '{{ $item->publication_year }}')">Sitasi</button>

                        <div class="btn-wrapper">
                            @if($buttonOnclick && !$buttonDisabled)
                                <button class="btn-sm" onclick="{{ $buttonOnclick }}" {{ $buttonDisabled ? 'disabled' : '' }}>
                                    {{ $buttonText }}
                                </button>
                            @else
                                <button class="btn-sm" disabled>{{ $buttonText }}</button>
                            @endif
                            @if($tooltipText)
                                <span class="tooltip-text">{{ $tooltipText }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-gray-500">Belum ada buku referensi yang tersedia.</div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($collections, 'links'))
            <div class="pagination" style="display: flex; justify-content: center; gap: 8px; margin-top: 30px;">
                {{ $collections->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </main>
</div>

<!-- Modal Peminjaman (dengan validasi 3 hari) -->
<div id="pinjamModal" class="modal-overlay" style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(12px); z-index: 1000; display: flex; align-items: center; justify-content: center; visibility: hidden; opacity: 0; transition: all 0.3s ease;">
    <div class="modal-container" style="background: rgba(15,23,42,0.95); backdrop-filter: blur(16px); border: 1px solid rgba(99,102,241,0.5); border-radius: 1.5rem; width: 100%; max-width: 28rem; margin: 1rem; transform: scale(0.9); transition: transform 0.3s ease; padding: 1.5rem;">
        <h2 class="text-xl font-bold text-indigo-300 mb-4">Form Peminjaman Buku Referensi</h2>
        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="collection_id" id="collection_id">
            <div class="mb-3">
                <label class="text-xs text-gray-400">Judul Buku</label>
                <input type="text" id="book_title" class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700" readonly>
            </div>
            <div class="mb-3">
                <label class="text-xs text-gray-400">Tanggal Pinjam</label>
                <input type="date" name="borrow_date" id="borrow_date" class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700" required>
            </div>
            <div class="mb-3">
                <label class="text-xs text-gray-400">Tanggal Kembali</label>
                <input type="date" name="return_date" id="return_date" class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700" required>
                <p class="text-xs text-gray-400 mt-1">* Maksimal peminjaman 3 hari</p>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="closeModal()" class="w-full py-2 rounded bg-gray-700 text-white">Batal</button>
                <button type="submit" id="submitPinjamBtn" class="w-full py-2 rounded bg-indigo-600 text-white font-semibold">Pinjam</button>
            </div>
        </form>
    </div>
</div>

<!-- Notifikasi -->
@if(session('success') || session('error'))
    <div id="notif" class="notification {{ session('success') ? 'bg-green-800 border-green-500' : 'bg-red-800 border-red-500' }}">
        {{ session('success') ?? session('error') }}
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Slider tahun UI
    const slider = document.getElementById('yearSlider');
    const output = document.getElementById('currentYear');
    if (slider && output) {
        slider.oninput = function() {
            output.innerHTML = this.value;
        };
    }

    function showCitation(title, author, publisher, year) {
        alert(`Sitasi APA:\n${author}. (${year}). ${title}. ${publisher}.`);
    }

    // Format tanggal (YYYY-MM-DD)
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Buka modal peminjaman
    function openModal(id, title) {
        const modal = document.getElementById('pinjamModal');
        modal.style.visibility = 'visible';
        modal.style.opacity = '1';
        document.getElementById('collection_id').value = id;
        document.getElementById('book_title').value = title;

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const borrowInput = document.getElementById('borrow_date');
        const returnInput = document.getElementById('return_date');

        // Reset value
        borrowInput.value = '';
        returnInput.value = '';

        // Set min & default borrow date = hari ini
        borrowInput.min = formatDate(today);
        borrowInput.value = formatDate(today);

        const minReturn = new Date(today);
        minReturn.setDate(minReturn.getDate() + 1);
        const maxReturn = new Date(today);
        maxReturn.setDate(maxReturn.getDate() + 3); // Maksimal 3 hari

        returnInput.min = formatDate(minReturn);
        returnInput.max = formatDate(maxReturn);
        returnInput.value = formatDate(minReturn);
    }

    // Tutup modal
    function closeModal() {
        const modal = document.getElementById('pinjamModal');
        modal.style.visibility = 'hidden';
        modal.style.opacity = '0';
        document.getElementById('pinjamForm').reset();
        const btn = document.getElementById('submitPinjamBtn');
        if (btn) {
            btn.disabled = false;
            btn.innerText = 'Pinjam';
        }
    }

    // Tutup modal jika klik di luar area modal
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('pinjamModal');
        if (e.target === modal) closeModal();
    });

    // Update batasan tanggal kembali ketika tanggal pinjam berubah
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

    // Validasi & submit form peminjaman
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

    // Auto-hide notification
    document.addEventListener('DOMContentLoaded', function() {
        const notif = document.getElementById('notif');
        if (notif) {
            setTimeout(() => {
                notif.classList.add('show');
                setTimeout(() => {
                    notif.classList.remove('show');
                    setTimeout(() => notif.remove(), 500);
                }, 3000);
            }, 100);
        }
    });
</script>
@endpush
