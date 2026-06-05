{{-- resources/views/user/page/Layanan/pinbal.blade.php --}}
@extends('user.component.master')

@section('title', 'Pinbal - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    /* ===== HERO BANNER ===== */
    .hero-banner {
        background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(26, 107, 71, 0.85)),
                    url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80');
        background-size: cover;
        background-position: center;
        padding: 70px 5% 80px;
        color: white;
        text-align: center;
    }
    .hero-banner h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.4rem;
        margin-bottom: 10px;
        font-weight: 900;
    }
    .hero-banner p {
        font-size: 1.05rem;
        opacity: 0.92;
    }

    /* ===== CONTAINER UTAMA ===== */
    .container {
        max-width: 1200px;
        margin: -40px auto 50px;
        background: var(--card-bg);
        padding: 40px 40px;
        border-radius: 24px;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
        border-top: 4px solid var(--accent-yellow);
        border-left: 1px solid var(--border-color);
        border-right: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }

    /* ===== INFO CARD (PANDUAN) ===== */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 50px;
    }
    .info-card {
        background: #f8fbf9;
        padding: 20px;
        border-radius: 16px;
        border-left: 4px solid var(--accent-yellow);
        transition: 0.3s;
    }
    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(15, 74, 49, 0.1);
    }
    .num-circle {
        background: var(--primary-color);
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        font-weight: bold;
        margin-bottom: 12px;
    }
    .card-content h3 {
        color: var(--primary-color);
        margin-bottom: 8px;
        font-size: 1rem;
        font-weight: 800;
    }
    .card-content p {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.5;
    }
    .badge-fine {
        background: var(--danger);
        color: white;
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        display: inline-block;
        margin-top: 8px;
    }

    /* ===== TOMBOL AJUKAN ===== */
    .btn-pinjam {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 60px;
        font-weight: 800;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 4px 12px rgba(26, 107, 71, 0.3);
    }
    .btn-pinjam:hover {
        background: var(--deep-green);
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(15, 74, 49, 0.3);
    }

    /* ===== RIWAYAT PEMINJAMAN ===== */
    .loan-section {
        margin-top: 40px;
        border-top: 2px solid var(--border-color);
        padding-top: 30px;
    }
    .loan-section h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .loan-section h3 i {
        color: var(--accent-yellow);
    }
    .loan-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 25px;
    }
    .filter-chip {
        background: #f0f5f2;
        padding: 6px 16px;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        transition: 0.2s;
        border: 1px solid transparent;
    }
    .filter-chip:hover, .filter-chip.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    .loan-table-wrapper {
        overflow-x: auto;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        background: white;
    }
    .loan-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .loan-table thead tr {
        background: #f9fbfa;
    }
    .loan-table th {
        text-align: left;
        padding: 16px 16px;
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--primary-color);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--border-color);
    }
    .loan-table td {
        padding: 18px 16px;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        background-color: white;
    }
    .loan-table tbody tr:last-child td {
        border-bottom: none;
    }
    .loan-table tbody tr:hover {
        background-color: #fafdfb;
    }
    .loan-book-title {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }
    .loan-book-author {
        font-size: 0.7rem;
        color: var(--text-muted);
    }
    .loan-status {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 700;
    }
    .status-dipinjam {
        background: rgba(26, 107, 71, 0.12);
        color: var(--primary-color);
    }
    .status-dikembalikan {
        background: rgba(45, 170, 110, 0.12);
        color: var(--accent-green);
    }
    .status-menunggu {
        background: rgba(241, 196, 15, 0.2);
        color: #b8860b;
    }
    .status-ditolak {
        background: rgba(231, 76, 60, 0.15);
        color: var(--danger);
    }
    .loan-actions a {
        color: var(--primary-color);
        margin-right: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: 0.2s;
    }
    .loan-actions a:hover {
        color: var(--accent-green);
    }

    /* ===== PAGINATION ===== */
    .pagination-wrapper {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }
    .pagination-nav {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .page-link {
        display: inline-block;
        padding: 10px 18px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-dark);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        background: white;
    }
    .page-link:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    .page-link.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    .page-link.disabled {
        opacity: 0.4;
        pointer-events: none;
        background: #f7fafc;
    }

    /* ===== MODAL PEMINJAMAN (SAMA SEPERTI JURNAL) ===== */
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

    .autocomplete-wrapper {
        position: relative;
    }
    .autocomplete-items {
        position: absolute;
        z-index: 1000;
        width: 100%;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        max-height: 250px;
        overflow-y: auto;
        margin-top: 4px;
        box-shadow: 0 10px 25px rgba(15, 74, 49, 0.12);
    }
    .autocomplete-item {
        padding: 10px 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid var(--border-color);
    }
    .autocomplete-item:last-child {
        border-bottom: none;
    }
    .autocomplete-item-title {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-dark);
    }
    .autocomplete-item-author {
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    .autocomplete-item:hover {
        background: #f0f7f3;
    }

    .footer-note {
        margin-top: 20px;
        text-align: center;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    @media (max-width: 768px) {
        .container { padding: 25px 20px; margin: 20px 20px 50px; }
        .info-grid { grid-template-columns: 1fr; gap: 15px; }
        .modal-content { width: 95%; }
        .modal-body { padding: 20px; }
        .modal-header h3 { font-size: 1.3rem; }
        .loan-table thead { display: none; }
        .loan-table, .loan-table tbody, .loan-table tr, .loan-table td {
            display: block; width: 100%;
        }
        .loan-table tr {
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 12px;
            background: white;
        }
        .loan-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed var(--border-color);
            padding: 10px 0;
        }
        .loan-table td:last-child { border-bottom: none; }
        .loan-table td::before {
            content: attr(data-label);
            font-weight: 800;
            color: var(--primary-color);
            width: 40%;
        }
    }
</style>
@endpush

@section('content')
<section class="hero-banner">
    <h2>Peminjaman & Pengembalian</h2>
    <p>Pedoman Sirkulasi Koleksi Perpustakaan AKPER HKBP</p>
</section>

<div class="container">
    <div class="info-grid">
        <div class="info-card">
            <div class="num-circle">1</div>
            <div class="card-content">
                <h3>Prosedur Peminjaman</h3>
                <p>Mahasiswa wajib menunjukkan kartu anggota digital atau KTM yang masih aktif. Maksimal peminjaman 3 eksemplar buku, jangka waktu 3 hari kerja.</p>
            </div>
        </div>
        <div class="info-card">
            <div class="num-circle">2</div>
            <div class="card-content">
                <h3>Prosedur Pengembalian</h3>
                <p>Buku harus dikembalikan tepat waktu dan dalam kondisi baik. Keterlambatan dikenakan denda administratif.</p>
                <div class="badge-fine">Denda: Rp 1.000 / Hari / Buku</div>
            </div>
        </div>
        <div class="info-card">
            <div class="num-circle">3</div>
            <div class="card-content">
                <h3>Perpanjangan Masa Pinjam</h3>
                <p>Perpanjangan dapat dilakukan 1x untuk 3 hari, asalkan buku tidak sedang dipesan oleh anggota lain.</p>
            </div>
        </div>
    </div>

    <div class="loan-section">
        <h3><i class="fas fa-history"></i> Riwayat Peminjaman</h3>

        <div class="loan-filters">
            <span class="filter-chip active" data-filter="all">Semua</span>
            <span class="filter-chip" data-filter="PENDING">Menunggu</span>
            <span class="filter-chip" data-filter="APPROVED">Dipinjam</span>
            <span class="filter-chip" data-filter="RETURNED">Dikembalikan</span>
            <span class="filter-chip" data-filter="REJECTED">Ditolak</span>
        </div>

        <div class="loan-table-wrapper">
            <table class="loan-table" id="loanTable">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $order)
                        @php
                            $detail = $order->details->first();
                            $collection = $detail->collection ?? null;
                            $statusMap = [
                                'PENDING' => ['label' => 'Menunggu Persetujuan', 'class' => 'status-menunggu'],
                                'APPROVED' => ['label' => 'Dipinjam', 'class' => 'status-dipinjam'],
                                'RETURNED' => ['label' => 'Dikembalikan', 'class' => 'status-dikembalikan'],
                                'REJECTED' => ['label' => 'Ditolak', 'class' => 'status-ditolak'],
                            ];
                            $status = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => ''];
                        @endphp
                        <tr data-status="{{ $order->status }}">
                            <td data-label="Judul Buku">
                                <div class="loan-book-title">{{ $collection->title ?? 'Judul tidak tersedia' }}</div>
                                <div class="loan-book-author">
                                    @if($collection)
                                        @php
                                            $authors = is_array($collection->author) ? implode(', ', $collection->author) : $collection->author;
                                        @endphp
                                        {{ $authors }}
                                    @endif
                                </div>
                            </td>
                            <td data-label="Tanggal Pinjam">{{ \Carbon\Carbon::parse($order->borrow_date)->format('d M Y') }}</td>
                            <td data-label="Batas Kembali">{{ \Carbon\Carbon::parse($order->due_date)->format('d M Y') }}</td>
                            <td data-label="Status"><span class="loan-status {{ $status['class'] }}">{{ $status['label'] }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px; color:var(--text-muted);">
                                <i class="fas fa-book-open" style="font-size:2rem; margin-bottom:10px; display:block;"></i>
                                Belum ada riwayat peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($peminjaman->hasPages())
            <div class="pagination-wrapper">
                <nav class="pagination-nav">
                    @if($peminjaman->onFirstPage())
                        <span class="page-link disabled">&laquo; Prev</span>
                    @else
                        <a href="{{ $peminjaman->previousPageUrl() }}" class="page-link">&laquo; Prev</a>
                    @endif

                    @foreach(range(1, $peminjaman->lastPage()) as $page)
                        @if($page == $peminjaman->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $peminjaman->url($page) }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($peminjaman->hasMorePages())
                        <a href="{{ $peminjaman->nextPageUrl() }}" class="page-link">Next &raquo;</a>
                    @else
                        <span class="page-link disabled">Next &raquo;</span>
                    @endif
                </nav>
            </div>
        @endif
    </div>

    <div style="text-align: center; margin: 40px 0 10px;">
        <button id="openPinjamModalBtn" class="btn-pinjam"><i class="fas fa-calendar-check"></i> Ajukan Peminjaman</button>
    </div>
    <div class="footer-note">
        <i class="fas fa-info-circle"></i> Pastikan selalu cek status pinjaman di menu History.
    </div>
</div>

{{-- MODAL PEMINJAMAN (SAMA PERSIS SEPERTI JURNAL) --}}
<div id="pinjamModal" class="modal-overlay">
    <div class="modal-container">
        <h2><i class="fas fa-calendar-check" style="color:var(--primary-color);"></i> Form Peminjaman</h2>
        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="collection_id" id="collection_id">
            <div>
                <label>Judul Buku</label>
                <div class="autocomplete-wrapper">
                    <input type="text" id="book_title" placeholder="Ketik judul buku..." autocomplete="off" required>
                    <div id="autocompleteList" class="autocomplete-items" style="display: none;"></div>
                </div>
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
    // ================= FUNGSI UTILITY =================
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // ================= MODAL PEMINJAMAN (SEPERTI JURNAL) =================
    function openModal(id, title) {
        const modal = document.getElementById('pinjamModal');
        modal.classList.add('active');

        document.getElementById('collection_id').value = id;
        document.getElementById('book_title').value = title;
        // Sembunyikan autocomplete jika ada
        document.getElementById('autocompleteList').style.display = 'none';

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

    // ================= AUTOCOMPLETE =================
    var searchTimeout;
    var availableBooks = @json($availableBooks ?? []);

    document.getElementById('book_title').addEventListener('input', function() {
        var query = this.value.trim();
        var list = document.getElementById('autocompleteList');

        if (query.length < 2) {
            list.style.display = 'none';
            return;
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            var filtered = [];
            for (var i = 0; i < availableBooks.length; i++) {
                var title = availableBooks[i].title ? availableBooks[i].title.toLowerCase() : '';
                if (title.includes(query.toLowerCase())) {
                    filtered.push(availableBooks[i]);
                }
            }

            if (filtered.length > 0) {
                var html = '';
                for (var i = 0; i < filtered.length; i++) {
                    var b = filtered[i];
                    var title = b.title || 'Tanpa Judul';
                    var author = Array.isArray(b.author) ? b.author.join(', ') : (b.author || 'Penulis tidak diketahui');
                    html += '<div class="autocomplete-item" onclick="selectBook(' + b.id + ', \'' + title.replace(/'/g, "\\'") + '\')">' +
                        '<div class="autocomplete-item-title">📖 ' + title + '</div>' +
                        '<div class="autocomplete-item-author">✍️ ' + author + '</div>' +
                    '</div>';
                }
                list.innerHTML = html;
                list.style.display = 'block';
            } else {
                list.innerHTML = '<div class="autocomplete-item"><div class="autocomplete-item-title" style="color: var(--text-muted);">📭 Buku tidak ditemukan</div></div>';
                list.style.display = 'block';
            }
        }, 300);
    });

    function selectBook(id, title) {
        document.getElementById('book_title').value = title;
        document.getElementById('collection_id').value = id;
        document.getElementById('autocompleteList').style.display = 'none';
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#book_title') && !e.target.closest('#autocompleteList')) {
            document.getElementById('autocompleteList').style.display = 'none';
        }
    });

    // ================= TOMBOL AJUKAN (TANPA BUKU) =================
    document.getElementById('openPinjamModalBtn').addEventListener('click', function() {
        const modal = document.getElementById('pinjamModal');
        modal.classList.add('active');
        document.getElementById('pinjamForm').reset();
        document.getElementById('book_title').value = '';
        document.getElementById('collection_id').value = '';
        document.getElementById('autocompleteList').style.display = 'none';

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const borrowInput = document.getElementById('borrow_date');
        const returnInput = document.getElementById('return_date');
        borrowInput.min = formatDate(today);
        borrowInput.value = formatDate(today);

        const minReturn = new Date(today);
        minReturn.setDate(minReturn.getDate() + 1);
        const maxReturn = new Date(today);
        maxReturn.setDate(maxReturn.getDate() + 3);
        returnInput.min = formatDate(minReturn);
        returnInput.max = formatDate(maxReturn);
        returnInput.value = formatDate(minReturn);
    });

    // ================= VALIDASI SAAT SUBMIT =================
    document.addEventListener('submit', function(e) {
        if (e.target.id === 'pinjamForm') {
            e.preventDefault();
            const collectionId = document.getElementById('collection_id').value;
            if (!collectionId) {
                alert('Silakan pilih buku terlebih dahulu!');
                return;
            }
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

    // Update return date saat borrow berubah
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

    // Close modal on overlay click
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('pinjamModal');
        if (e.target === modal) closeModal();
    });

    // ================= FILTER CHIPS =================
    document.querySelectorAll('.filter-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('#loanTable tbody tr').forEach(row => {
                if (filter === 'all' || row.dataset.status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
