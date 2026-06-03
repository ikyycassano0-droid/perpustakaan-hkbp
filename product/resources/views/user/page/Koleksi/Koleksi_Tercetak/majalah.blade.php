{{-- resources/views/user/page/koleksi_tercetak/majalah.blade.php --}}
@extends('user.component.master')

@section('title', 'Koleksi Majalah & Serial - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    /* ============================================
       GAYA MAJALAH & SERIAL (TEMA HIJAU KUNING)
       Sama seperti halaman koleksi lainnya
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
        font-size: 2.2rem;
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

    .search-box-item {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        padding: 0 15px;
    }

    .search-box-item i {
        color: var(--text-muted);
        margin-right: 10px;
    }

    .search-box-item input,
    .search-box-item select {
        border: none;
        outline: none;
        padding: 12px 0;
        width: 100%;
        font-size: 0.95rem;
        color: var(--text-dark);
        background: transparent;
    }

    .filter-container {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .chip {
        padding: 10px 20px;
        background: var(--card-bg);
        border-radius: 50px;
        font-size: 0.9rem;
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

    .mag-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 25px;
        display: flex;
        gap: 30px;
        margin-bottom: 25px;
        transition: 0.3s;
        border: 1px solid var(--border-color);
        border-top: 4px solid var(--accent-yellow);
        box-shadow: 0 4px 12px rgba(15, 74, 49, 0.05);
    }

    .mag-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(15, 74, 49, 0.12);
    }

    .mag-cover {
        width: 150px;
        height: 200px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .mag-info {
        flex-grow: 1;
    }

    .badge-serial {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        background: var(--accent-yellow);
        color: var(--primary-color);
        padding: 4px 12px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 12px;
    }

    .mag-title {
        font-size: 1.4rem;
        color: var(--primary-color);
        font-weight: 800;
        margin-bottom: 8px;
        display: block;
        text-decoration: none;
    }

    .mag-title:hover {
        text-decoration: underline;
    }

    .mag-edition {
        font-size: 1rem;
        color: var(--text-muted);
        margin-bottom: 20px;
    }

    .data-rows {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px 30px;
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    .row-item {
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    .row-item strong {
        color: var(--text-dark);
        font-weight: 700;
        margin-right: 5px;
    }

    .mag-action {
        width: 180px;
        border-left: 1px solid var(--border-color);
        padding-left: 30px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        justify-content: center;
    }

    .stock-box {
        border: 1px solid var(--border-color);
        padding: 15px;
        border-radius: 12px;
        text-align: center;
        background: #fafdfb;
    }

    .stock-box span {
        font-size: 0.75rem;
        color: var(--text-muted);
        display: block;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .stock-box strong {
        font-size: 2rem;
        color: var(--primary-color);
        display: block;
    }

    .btn-outline {
        padding: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        border-radius: 50px;
        border: 1px solid var(--border-color);
        background: white;
        cursor: pointer;
        transition: 0.3s;
        color: var(--text-muted);
        width: 100%;
    }

    .btn-outline:hover:not(:disabled) {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-outline:disabled {
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
        .mag-card {
            flex-direction: column;
        }
        .mag-action {
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
            <span>KOLEKSI TERCETAK</span>
            <h2>Koleksi Majalah & Serial</h2>
        </div>

        <!-- Form Search & Filter (server-side) -->
        <form method="GET" action="{{ route('user.koleksi.majalah') }}" class="filter-row">
            <div class="search-box-item">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama majalah atau ISSN...">
            </div>
            <div class="search-box-item">
                <select name="category">
                    <option value="">Semua Kategori</option>
                    @php
                        $categories = \App\Models\CategoryCollection::orderBy('name')->get();
                    @endphp
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="search-box-item">
                <select name="sort">
                    <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Terbaru</option>
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                </select>
            </div>
        </form>

        <!-- Category Chips -->
        <div class="filter-container">
            <a href="{{ route('user.koleksi.majalah', array_merge(request()->except('category'), ['category' => ''])) }}"
               class="chip {{ !request('category') ? 'active' : '' }}">Semua Majalah</a>
            @foreach($categories as $cat)
                <a href="{{ route('user.koleksi.majalah', array_merge(request()->except('category'), ['category' => $cat->id])) }}"
                   class="chip {{ request('category') == $cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
            @endforeach
        </div>

        <!-- Daftar Majalah -->
        <div class="mag-list">
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
                    $categoryName = $item->categories->isNotEmpty() ? $item->categories->first()->name : 'Serial Berkala';

                    // ========== LOGIKA PEMINJAMAN DENGAN BATAS 3 ITEM ==========
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
                                    $tooltipText = 'Anda sedang meminjam majalah ini';
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
                                $tooltipText = 'Stok majalah sedang kosong';
                            } elseif ($activeBorrowCount >= 3) {
                                $buttonText = '⚠️ Maksimal 3 Item';
                                $buttonDisabled = true;
                                $buttonOnclick = '';
                                $tooltipText = 'Anda sudah mencapai batas maksimal peminjaman (3 item)';
                            } else {
                                $buttonText = 'Pinjam';
                                $buttonDisabled = false;
                                $buttonOnclick = "openModal({$item->id}, '".addslashes($item->title)."')";
                                $tooltipText = 'Pinjam majalah ini';
                            }
                        }
                    } else {
                        // Guest
                        $buttonText = '🔑 Login';
                        $buttonDisabled = false;
                        $buttonOnclick = "window.location.href='{{ route('login') }}'";
                        $tooltipText = 'Silakan login untuk meminjam majalah';
                    }
                @endphp

                <div class="mag-card">
                    <img src="{{ $item->cover_image ? asset('storage/'.$item->cover_image) : 'https://via.placeholder.com/150x200?text=Majalah' }}" class="mag-cover" alt="Cover">
                    <div class="mag-info">
                        <span class="badge-serial">SERIAL BERKALA</span>
                        <a href="{{ route('user.koleksi.detail', $item->id) }}" class="mag-title">{{ $item->title }}</a>
                        <p class="mag-edition">Edisi: {{ $item->edition ?? ($item->volume ? 'Vol. ' . $item->volume : 'Vol. ' . rand(1,10) . ' No. ' . rand(1,4)) . ' - ' . ($item->publication_year ?? date('Y')) }}</p>

                        <div class="data-rows">
                            <div class="row-item"><strong>ISSN:</strong> {{ $item->issn ?? $item->isbn ?? '-' }}</div>
                            <div class="row-item"><strong>Penerbit:</strong> {{ $item->publisher ?? 'AKPER HKBP Press' }}</div>
                            <div class="row-item"><strong>Bahasa:</strong> {{ $item->language ?? 'Indonesia' }}</div>
                            <div class="row-item"><strong>Format:</strong> {{ $item->format ?? 'Cetak' }}</div>
                            <div class="row-item"><strong>Subjek:</strong> {{ $item->subject ?? ($item->keywords ? (is_array($item->keywords) ? implode(', ', $item->keywords) : $item->keywords) : 'Keperawatan') }}</div>
                            <div class="row-item"><strong>Lokasi:</strong> {{ $item->location ?? 'Rak Majalah' }}</div>
                        </div>
                    </div>
                    <div class="mag-action">
                        <div class="stock-box">
                            <span>STOK TERSEDIA</span>
                            <strong>{{ $item->available_stock ?? 0 }}</strong>
                        </div>
                        @if($item->marc_file)
                            <button class="btn-outline" onclick="window.open('{{ asset('storage/'.$item->marc_file) }}', '_blank')">Unduh MARC</button>
                        @endif
                        <button class="btn-outline" onclick="showCitation('{{ addslashes($item->title) }}', '{{ addslashes($authorStr) }}', '{{ addslashes($item->publisher) }}', '{{ $item->publication_year }}')">Sitasi Majalah</button>

                        <div class="btn-wrapper">
                            @if($buttonOnclick && !$buttonDisabled)
                                <button class="btn-outline" onclick="{{ $buttonOnclick }}" {{ $buttonDisabled ? 'disabled' : '' }}>
                                    {{ $buttonText }}
                                </button>
                            @else
                                <button class="btn-outline" disabled>{{ $buttonText }}</button>
                            @endif
                            @if($tooltipText)
                                <span class="tooltip-text">{{ $tooltipText }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-gray-500">Belum ada majalah atau serial yang tersedia.</div>
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

<!-- Modal Peminjaman -->
<div id="pinjamModal" class="modal-overlay" style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(12px); z-index: 1000; display: flex; align-items: center; justify-content: center; visibility: hidden; opacity: 0; transition: all 0.3s ease;">
    <div class="modal-container" style="background: rgba(15,23,42,0.95); backdrop-filter: blur(16px); border: 1px solid rgba(99,102,241,0.5); border-radius: 1.5rem; width: 100%; max-width: 28rem; margin: 1rem; transform: scale(0.9); transition: transform 0.3s ease; padding: 1.5rem;">
        <h2 class="text-xl font-bold text-indigo-300 mb-4">Form Peminjaman Majalah</h2>
        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="collection_id" id="collection_id">
            <div class="mb-3">
                <label class="text-xs text-gray-400">Judul Majalah</label>
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
        alert(`Sitasi Majalah (APA):\n${author}. (${year}). ${title}. ${publisher}.`);
    }

    // Format tanggal
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

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
        modal.style.visibility = 'hidden';
        modal.style.opacity = '0';
        document.getElementById('pinjamForm').reset();
        const btn = document.getElementById('submitPinjamBtn');
        if (btn) {
            btn.disabled = false;
            btn.innerText = 'Pinjam';
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
