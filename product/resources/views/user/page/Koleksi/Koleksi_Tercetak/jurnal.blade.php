{{-- resources/views/user/page/koleksi_tercetak/jurnal.blade.php --}}
@extends('user.component.master')

@section('title', 'Koleksi Jurnal - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    /* ============================================
       GAYA KLASIK HIJAU (TANPA DEPENDENSI VAR)
    ============================================ */
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
        background: #ffffff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border: 1px solid #d4e5d9;
        position: sticky;
        top: 100px;
    }

    .sidebar h3 {
        font-size: 1.1rem;
        margin-bottom: 20px;
        color: #0d2137;
        border-bottom: 1px solid #d4e5d9;
        padding-bottom: 15px;
        font-weight: 800;
    }

    .filter-group {
        margin-bottom: 25px;
    }

    .filter-group h4 {
        font-size: 0.95rem;
        color: #5a7060;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .range-slider {
        width: 100%;
        cursor: pointer;
        accent-color: #1a6b47;
        margin-bottom: 10px;
    }

    .year-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #5a7060;
        font-weight: 600;
    }

    .filter-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        font-size: 0.9rem;
        color: #5a7060;
        cursor: pointer;
    }

    .filter-item input {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: #1a6b47;
    }

    .content-section {
        flex-grow: 1;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-header span {
        color: #1a6b47;
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
        color: #0d2137;
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
        background: #ffffff;
        border: 1px solid #d4e5d9;
        border-radius: 12px;
        display: flex;
        align-items: center;
        padding: 0 15px;
    }

    .search-item i {
        color: #5a7060;
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
        color: #0d2137;
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
        background: #ffffff;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #5a7060;
        cursor: pointer;
        transition: 0.3s;
        border: 1px solid #d4e5d9;
        white-space: nowrap;
    }

    .chip.active {
        background: #1a6b47;
        color: white;
        border-color: #1a6b47;
    }

    .chip:hover:not(.active) {
        background: #f0f7f3;
        border-color: #2daa6e;
        color: #1a6b47;
    }

    .book-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        gap: 25px;
        margin-bottom: 20px;
        transition: 0.3s;
        border: 1px solid #d4e5d9;
        border-top: 4px solid #f1c40f;
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
        background: #f1c40f;
        color: #1a6b47;
        padding: 4px 12px;
        border-radius: 50px;
        display: inline-block;
    }

    .book-info h2 {
        font-size: 1.25rem;
        color: #1a6b47;
        margin: 8px 0;
        cursor: pointer;
        line-height: 1.3;
        font-weight: 700;
    }

    .book-info p {
        font-size: 0.88rem;
        color: #5a7060;
        margin-bottom: 5px;
    }

    .book-info p strong {
        color: #1a6b47;
    }

    .tags {
        margin-top: 15px;
        display: flex;
        gap: 8px;
    }

    .tag {
        padding: 4px 12px;
        background: #f0f7f3;
        font-size: 0.75rem;
        border-radius: 50px;
        color: #1a6b47;
        font-weight: 600;
    }

    .book-status {
        width: 160px;
        text-align: center;
        display: flex;
        flex-direction: column;
        gap: 12px;
        border-left: 1px solid #d4e5d9;
        padding-left: 20px;
    }

    .stock-box {
        border: 1px solid #d4e5d9;
        padding: 12px;
        border-radius: 12px;
        background: #fafdfb;
    }

    .stock-box span {
        display: block;
        font-size: 0.7rem;
        color: #5a7060;
        text-transform: uppercase;
        font-weight: 700;
    }

    .stock-box strong {
        font-size: 1.5rem;
        color: #1a6b47;
    }

    .btn-action {
        padding: 10px;
        font-size: 0.8rem;
        background: white;
        border: 1px solid #d4e5d9;
        border-radius: 50px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: 600;
        color: #5a7060;
    }

    .btn-action:hover {
        background: #1a6b47;
        color: white;
        border-color: #1a6b47;
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

        .book-status {
            width: 100%;
            border-left: none;
            border-top: 1px solid #d4e5d9;
            padding: 20px 0 0;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <div class="main-container">

        <!-- Sidebar (statis, hanya UI) -->
        <aside class="sidebar">
            <h3>Ditapis dengan</h3>
            <div class="filter-group">
                <h4>Tahun Penerbitan</h4>
                <input type="range" min="2000" max="{{ date('Y') }}" value="{{ date('Y') }}" class="range-slider" id="yearSlider">
                <div class="year-label">
                    <span>2000</span>
                    <span id="currentYear" style="color:#1a6b47; font-weight:800;">{{ date('Y') }}</span>
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
                <h2>Koleksi Jurnal Keperawatan</h2>
            </div>

            <!-- Form Search & Filter (server-side) -->
            <form method="GET" action="{{ route('user.koleksi.jurnal') }}" class="filter-row">
                <div class="search-item">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul jurnal, penulis, atau ISSN...">
                </div>
                <div class="search-item">
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
                <a href="{{ route('user.koleksi.jurnal', array_merge(request()->except('category'), ['category' => ''])) }}"
                   class="chip {{ !request('category') ? 'active' : '' }}">Semua Kategori</a>
                @foreach($categories as $cat)
                    <a href="{{ route('user.koleksi.jurnal', array_merge(request()->except('category'), ['category' => $cat->id])) }}"
                       class="chip {{ request('category') == $cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>

            <!-- Daftar Jurnal -->
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
                        $categoryName = $item->categories->isNotEmpty() ? $item->categories->first()->name : 'JURNAL';
                        $keywords = $item->keywords;
                        if (is_array($keywords)) {
                            $keywords = implode(', ', $keywords);
                        }
                    @endphp
                    <div class="book-card">
                        <img src="{{ $item->cover_image ? asset('storage/'.$item->cover_image) : 'https://via.placeholder.com/140x190?text=Jurnal' }}" class="book-img" alt="Cover">
                        <div class="book-info">
                            <span class="category-label">{{ $categoryName }}</span>
                            <h2 onclick="location.href='{{ route('user.koleksi.detail', $item->id) }}'">{{ $item->title }}</h2>
                            <p><strong>Penulis:</strong> {{ $authorStr ?: 'Tim Penulis' }}</p>
                            <p><strong>Penerbit:</strong> {{ $item->publisher ?? 'AKPER HKBP Press' }} -- {{ $item->city ?? 'Tarutung' }} : {{ $item->publication_year ?? date('Y') }}</p>
                            <div class="tags">
                                @if($keywords)
                                    @foreach(explode(',', $keywords) as $tag)
                                        <span class="tag">{{ trim($tag) }}</span>
                                    @endforeach
                                @else
                                    <span class="tag">Nursing</span>
                                    <span class="tag">Clinical</span>
                                @endif
                            </div>
                        </div>
                        <div class="book-status">
                            <div class="stock-box">
                                <span>Ketersediaan</span>
                                <strong>{{ $item->available_stock ?? 0 }}</strong>
                            </div>
                            @if($item->marc_file)
                                <button class="btn-action" onclick="window.open('{{ asset('storage/'.$item->marc_file) }}', '_blank')">Unduh MARC</button>
                            @endif
                            <button class="btn-action" onclick="showCitation('{{ addslashes($item->title) }}', '{{ addslashes($authorStr) }}', '{{ addslashes($item->publisher) }}', '{{ $item->publication_year }}')">Sitasi Jurnal</button>

                            @if(session()->has('user'))
                                @if($borrowStatus && in_array($borrowStatus['status'], ['PENDING', 'APPROVED']))
                                    @if($borrowStatus['status'] == 'PENDING')
                                        <button class="btn-action" style="background:#fbbf24; color:#000;" disabled>⏳ Diproses</button>
                                    @else
                                        <button class="btn-action" style="background:#f87171;" disabled>📚 Dipinjam</button>
                                    @endif
                                @elseif(($item->available_stock ?? 0) > 0)
                                    <button class="btn-action" onclick="openModal({{ $item->id }}, '{{ addslashes($item->title) }}')">Pinjam</button>
                                @else
                                    <button class="btn-action" disabled>❌ Habis</button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-action">🔑 Login</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-500">Belum ada jurnal yang tersedia.</div>
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
</div>

<!-- Modal Peminjaman -->
<div id="pinjamModal" class="modal-overlay" style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(12px); z-index: 1000; display: flex; align-items: center; justify-content: center; visibility: hidden; opacity: 0; transition: all 0.3s ease;">
    <div class="modal-container" style="background: rgba(15,23,42,0.95); backdrop-filter: blur(16px); border: 1px solid rgba(99,102,241,0.5); border-radius: 1.5rem; width: 100%; max-width: 28rem; margin: 1rem; transform: scale(0.9); transition: transform 0.3s ease; padding: 1.5rem;">
        <h2 class="text-xl font-bold text-indigo-300 mb-4">Form Peminjaman Jurnal</h2>
        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="collection_id" id="collection_id">
            <div class="mb-3">
                <label class="text-xs text-gray-400">Judul Jurnal</label>
                <input type="text" id="book_title" class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700" readonly>
            </div>
            <div class="mb-3">
                <label class="text-xs text-gray-400">Tanggal Pinjam</label>
                <input type="date" name="borrow_date" id="borrow_date" class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700" required>
            </div>
            <div class="mb-3">
                <label class="text-xs text-gray-400">Tanggal Kembali</label>
                <input type="date" name="return_date" id="return_date" class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700" required>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="closeModal()" class="w-full py-2 rounded bg-gray-700 text-white">Batal</button>
                <button type="submit" id="submitPinjamBtn" class="w-full py-2 rounded bg-indigo-600 text-white font-semibold">Pinjam</button>
            </div>
        </form>
    </div>
</div>
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

    // Modal functions
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
</script>
@endpush
