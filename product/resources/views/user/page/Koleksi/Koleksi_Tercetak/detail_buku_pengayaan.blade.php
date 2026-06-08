{{-- resources/views/user/page/Koleksi/Koleksi_Tercetak/detail_buku_pengayaan.blade.php --}}
@extends('user.component.master')

@section('title', $collection->title . ' - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    /* ========== UI 100% DARI DETAIL EBOOK ========== */
    .main-wrapper {
        max-width: 1300px;
        margin: 40px auto 40px 13%;
        padding: 0 30px;
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 50px;
        align-items: start;
    }

    /* 3D BOOK SECTION */
    .book-wrap {
        perspective: 1600px;
        position: sticky;
        top: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .real-book {
        width: 300px;
        height: 420px;
        position: relative;
        transform-style: preserve-3d;
        transform: rotateY(-12deg) rotateX(2deg);
        transition: transform 0.5s ease;
        cursor: pointer;
        margin-bottom: 30px;
        will-change: transform;
    }

    .real-book:hover {
        transform: rotateY(-5deg) rotateX(1deg) translateX(50px);
    }

    .book-back {
        position: absolute;
        width: 100%;
        height: 100%;
        background: linear-gradient(145deg, #e0d4bc, #cdc0a4);
        border-radius: 4px 12px 12px 4px;
        box-shadow: -5px 5px 15px rgba(0, 0, 0, 0.2);
        z-index: 1;
        backface-visibility: hidden;
    }

    .book-pages {
        position: absolute;
        width: 96%;
        height: 96%;
        top: 2%;
        left: 2%;
        background: #fffdfd;
        border-radius: 2px 8px 8px 2px;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05), 2px 3px 10px rgba(0, 0, 0, 0.1);
        z-index: 5;
        padding: 30px 16px;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        font-family: 'Playfair Display', serif;
    }

    .book-pages h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-color);
        border-left: 4px solid var(--accent-yellow);
        padding-left: 12px;
        margin-bottom: 12px;
        font-family: 'DM Sans', sans-serif;
    }

    .book-pages p {
        font-size: 0.72rem;
        line-height: 1.55;
        color: #2c3e2f;
        margin-bottom: 10px;
        text-align: justify;
    }

    .book-preview {
        background: #f9f5e8;
        padding: 8px 10px;
        border-radius: 8px;
        margin: 8px 0;
        font-style: italic;
        font-size: 0.7rem;
        border-left: 3px solid var(--accent-green);
    }

    .pages-meta {
        margin-top: auto;
        font-size: 0.62rem;
        color: #a0814b;
        display: flex;
        justify-content: space-between;
        border-top: 1px solid #ece3cf;
        padding-top: 10px;
        font-family: 'DM Sans', sans-serif;
    }

    .book-cover {
        position: absolute;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1a6b47, #0f4a31);
        border-radius: 4px 12px 12px 4px;
        transform-origin: left center;
        transition: transform 0.7s cubic-bezier(0.4, 0.2, 0.2, 1);
        z-index: 20;
        box-shadow: -8px 6px 20px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .real-book:hover .book-cover {
        transform: rotateY(-180deg);
    }

    .book-spine {
        position: absolute;
        width: 24px;
        height: 100%;
        background: linear-gradient(110deg, #0a3a25, #1b6845, #0f4a31);
        left: -8px;
        top: 0;
        transform: rotateY(-90deg);
        transform-origin: right center;
        border-radius: 3px 2px 2px 3px;
        box-shadow: -3px 0 10px rgba(0, 0, 0, 0.3);
        z-index: 25;
    }

    .book-edges {
        position: absolute;
        width: 97%;
        height: 95%;
        top: 2.5%;
        left: 1.5%;
        background: repeating-linear-gradient(180deg, #faf3e0 0px, #faf3e0 2px, #f2e8d0 2px, #f2e8d0 6px);
        z-index: 2;
        transform: translateZ(-5px);
        border-radius: 2px 5px 5px 2px;
        pointer-events: none;
    }

    .book-pages::-webkit-scrollbar {
        width: 3px;
    }

    .book-pages::-webkit-scrollbar-track {
        background: #ece3cf;
        border-radius: 10px;
    }

    .book-pages::-webkit-scrollbar-thumb {
        background: var(--accent-green);
        border-radius: 10px;
    }

    /* Action Buttons (untuk peminjaman) */
    .ebook-actions {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-ebook {
        width: 100%;
        padding: 12px 18px;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s ease;
        font-size: 0.85rem;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .btn-read {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(26, 107, 71, 0.25);
    }

    .btn-read:hover {
        background: var(--accent-green);
        transform: translateY(-3px);
    }

    .btn-read:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-download {
        background: #eef4f0;
        color: var(--primary-color);
        border: 1.8px solid var(--primary-color);
    }

    .btn-download:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    /* Detail Box (sama persis dengan ebook) */
    .detail-box {
        background: white;
        border-radius: 28px;
        padding: 32px 36px;
        box-shadow: 0 12px 28px rgba(15, 74, 49, 0.08);
        border: 1px solid var(--border-color);
        border-top: 5px solid var(--accent-yellow);
    }

    .title-area h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.9rem;
        color: var(--primary-color);
        margin-bottom: 8px;
    }

    .title-area span.top-tag {
        color: var(--accent-green);
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 8px;
        background: #e0f2e9;
        padding: 3px 12px;
        border-radius: 30px;
    }

    .author-text {
        color: var(--text-muted);
        margin-bottom: 26px;
        font-size: 0.95rem;
        border-bottom: 1px dashed var(--border-color);
        padding-bottom: 14px;
    }

    .section-header {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .availability-card {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 28px;
    }

    .avail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .avail-table th {
        background: #f0f7f3;
        color: var(--primary-color);
        text-align: left;
        padding: 12px 20px;
        font-size: 0.85rem;
    }

    .avail-table td {
        padding: 12px 20px;
        font-size: 0.85rem;
        border-bottom: 1px solid var(--border-color);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--accent-green);
        font-weight: 700;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        background: var(--accent-green);
        border-radius: 50%;
        position: relative;
    }

    .pulse-dot::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: var(--accent-green);
        border-radius: 50%;
        animation: pulse-ring 1.5s infinite;
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.33); opacity: 0.6; }
        80%, 100% { transform: scale(2.2); opacity: 0; }
    }

    .info-heading {
        font-size: 1.1rem;
        font-weight: 800;
        margin: 20px 0 16px;
        border-left: 5px solid var(--accent-yellow);
        padding-left: 14px;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 150px 1fr;
        padding: 8px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.85rem;
    }

    .label {
        color: var(--text-muted);
        font-weight: 600;
    }

    .value {
        color: var(--text-dark);
        font-weight: 500;
    }

    .category-badge {
        display: inline-block;
        background: var(--primary-color);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        margin: 2px;
    }

    .btn-back {
        display: block;
        width: 100%;
        margin-top: 15px;
        padding: 12px;
        text-align: center;
        background: white;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-back:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    /* Modal (sama persis dari detail asli) */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15,74,49,0.4);
        backdrop-filter: blur(8px);
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        visibility: hidden;
        opacity: 0;
        transition: all 0.3s;
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
        box-shadow: 0 25px 50px rgba(15,74,49,0.25);
        border: 1px solid var(--border-color);
        transform: scale(0.9);
        transition: transform 0.3s;
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
        .main-wrapper {
            grid-template-columns: 1fr;
            margin: 30px 20px;
            gap: 35px;
        }
        .book-wrap {
            position: relative;
            top: 0;
        }
    }
    @media (max-width: 640px) {
        .info-row {
            grid-template-columns: 1fr;
            gap: 6px;
        }
        .real-book {
            width: 250px;
            height: 370px;
        }
        .detail-box {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="main-wrapper">
    <!-- 3D BOOK SECTION (UI dari ebook) -->
    <div class="book-wrap" data-aos="zoom-in-right">
        <div class="real-book">
            <div class="book-spine"></div>
            <div class="book-edges"></div>
            <div class="book-back"></div>

            <div class="book-pages">
                <h3><i class="fas fa-feather-alt"></i> Sinopsis</h3>
                <p>{{ Str::limit($collection->description ?? 'Tidak ada sinopsis untuk buku ini.', 350) }}</p>

                @if($collection->publisher || $collection->publication_year)
                <div class="book-preview">
                    <i class="fas fa-info-circle"></i> <strong>Informasi Terbitan:</strong><br>
                    {{ $collection->publisher ?? 'AKPER HKBP Press' }}, {{ $collection->publication_year ?? '-' }}
                </div>
                @endif

                <div class="pages-meta">
                    <span><i class="fas fa-hashtag"></i> Koleksi Cetak</span>
                    <span><i class="fas fa-book"></i> Buku Pengayaan</span>
                </div>
            </div>

            <!-- Cover -->
            <div class="book-cover">
                @if($collection->cover_image && Storage::disk('public')->exists($collection->cover_image))
                    <img src="{{ Storage::url($collection->cover_image) }}" alt="{{ $collection->title }}">
                @else
                    <img src="https://via.placeholder.com/400x600?text=Buku+Cover" alt="Default Cover">
                @endif
            </div>
        </div>

        <!-- Tombol Pinjam & Kembali (menggantikan ebook-actions) -->
        <div class="ebook-actions">
            @if(session()->has('user'))
                @if($borrowStatus)
                    @if($borrowStatus['status'] == 'PENDING')
                        <button class="btn-ebook btn-read" disabled>⏳ Menunggu Konfirmasi</button>
                    @elseif($borrowStatus['status'] == 'APPROVED')
                        <button class="btn-ebook btn-read" disabled>📚 Sedang Dipinjam</button>
                    @elseif($borrowStatus['status'] == 'REJECTED')
                        <button class="btn-ebook btn-read" id="btnPinjamKiri"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
                    @endif
                @elseif($collection->available_stock > 0)
                    <button class="btn-ebook btn-read" id="btnPinjamKiri"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
                @else
                    <button class="btn-ebook btn-read" disabled>Stok Habis</button>
                @endif
            @else
                <button class="btn-ebook btn-read" id="btnPinjamKiri"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
            @endif

            <a href="{{ route('user.koleksi.buku_pengayaan') }}" class="btn-download btn-ebook" style="text-decoration:none;">
                <i class="fas fa-arrow-left"></i> Kembali ke Menu Buku Pengayaan
            </a>
        </div>
    </div>

    <!-- DETAIL BOX (UI dari ebook) -->
    <div class="detail-box" data-aos="fade-left">
        <div class="title-area">
            <span class="top-tag">
                <i class="fas fa-book-open"></i> KOLEKSI BUKU PENGAYAAN
            </span>
            <h1>{{ $collection->title }}</h1>
            <p class="author-text">
                @php
                    $authors = is_array($collection->author) ? $collection->author : json_decode($collection->author, true) ?? [];
                    $authorStr = !empty($authors) ? implode(', ', $authors) : 'Tim Penulis';
                @endphp
                <strong>{{ $authorStr }}</strong>
                @if($collection->edition)
                    — Edisi {{ $collection->edition }}
                @endif
                @if($collection->publication_year)
                    | {{ $collection->publication_year }}
                @endif
            </p>
        </div>

        <div class="section-header">
            <i class="fas fa-boxes" style="color: var(--accent-green);"></i>
            Status Ketersediaan Fisik
        </div>

        <div class="availability-card">
            <table class="avail-table">
                <thead>
                    <tr>
                        <th>Tipe Ketersediaan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Stok Tersedia</strong></td>
                        <td>
                            @if(($collection->available_stock ?? 0) > 0)
                                <div class="status-badge">
                                    <div class="pulse-dot"></div>
                                    Tersedia ({{ $collection->available_stok ?? $collection->available_stock }} eksemplar)
                                </div>
                            @else
                                <div class="status-badge" style="color: var(--danger);">Tidak Tersedia</div>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="info-heading">
            <i class="fas fa-info-circle"></i> Informasi Detail
        </div>

        <div class="info-list">
            <div class="info-row">
                <div class="label">ISBN/ISSN</div>
                <div class="value">{{ $collection->isbn ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Penerbit</div>
                <div class="value">{{ $collection->publisher ?? 'AKPER HKBP Press' }}</div>
            </div>
            @if($collection->publication_year)
            <div class="info-row">
                <div class="label">Tahun Terbit</div>
                <div class="value">{{ $collection->publication_year }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="label">Bahasa</div>
                <div class="value">{{ $collection->language ?? 'Indonesia' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Format</div>
                <div class="value">{{ $collection->format ?? 'Cetak' }}</div>
            </div>
            @if($collection->edition)
            <div class="info-row">
                <div class="label">Edisi</div>
                <div class="value">{{ $collection->edition }}</div>
            </div>
            @endif
            @if($collection->classifications && $collection->classifications->count())
            <div class="info-row">
                <div class="label">Klasifikasi</div>
                <div class="value">
                    @foreach($collection->classifications as $classification)
                        <span class="category-badge">{{ $classification->code ?? $classification->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif
            @if($collection->categories && $collection->categories->count())
            <div class="info-row">
                <div class="label">Kategori</div>
                <div class="value">
                    @foreach($collection->categories as $category)
                        <span class="category-badge">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif
            @if($collection->location)
            <div class="info-row">
                <div class="label">Lokasi Rak</div>
                <div class="value">{{ $collection->location->name }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="label">Jenis Koleksi</div>
                <div class="value">Buku Pengayaan (Dapat dipinjam)</div>
            </div>
        </div>

        @if($collection->description)
        <div class="info-heading" style="margin-top: 25px;">
            <i class="fas fa-align-left"></i> Sinopsis / Deskripsi
        </div>
        <div class="abstract-content" style="margin-top: 10px; line-height: 1.8; text-align: justify;">
            {{ $collection->description }}
        </div>
        @endif

        <!-- Tombol pinjam bawah (duplikasi untuk kenyamanan) -->
        <div style="margin-top: 30px;">
            @if(session()->has('user'))
                @if($borrowStatus)
                    @if($borrowStatus['status'] == 'PENDING')
                        <button class="btn-ebook btn-read" disabled>⏳ Menunggu Konfirmasi</button>
                    @elseif($borrowStatus['status'] == 'APPROVED')
                        <button class="btn-ebook btn-read" disabled>📚 Sedang Dipinjam</button>
                    @elseif($borrowStatus['status'] == 'REJECTED')
                        <button class="btn-ebook btn-read" id="btnPinjamBawah"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
                    @endif
                @elseif($collection->available_stock > 0)
                    <button class="btn-ebook btn-read" id="btnPinjamBawah"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
                @else
                    <button class="btn-ebook btn-read" disabled>Stok Habis</button>
                @endif
            @else
                <button class="btn-ebook btn-read" id="btnPinjamBawah"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
            @endif
            <a href="{{ route('user.koleksi.buku_pengayaan') }}" class="btn-back">Kembali ke Menu Buku Pengayaan</a>
        </div>
    </div>
</div>

{{-- MODAL PEMINJAMAN (logic asli) --}}
<div id="pinjamModal" class="modal-overlay">
    <div class="modal-container">
        <h2><i class="fas fa-calendar-check" style="color:var(--primary-color);"></i> Form Peminjaman Buku</h2>
        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="collection_id" value="{{ $collection->id }}">
            <div>
                <label>Judul Buku</label>
                <input type="text" value="{{ $collection->title }}" readonly>
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

{{-- MODAL LOGIN (logic asli) --}}
<div id="loginModal" class="modal-overlay">
    <div class="modal-container text-center">
        <div style="font-size:2rem; color:var(--accent-yellow); margin-bottom:15px;"><i class="fas fa-user-lock"></i></div>
        <h3 style="color:var(--primary-color);">Akses Terbatas</h3>
        <p style="color:#666; font-size:0.9rem; margin:10px 0 30px;">Silakan login terlebih dahulu untuk meminjam koleksi ini.</p>
        <div style="display:flex; gap:15px;">
            <button onclick="document.getElementById('loginModal').classList.remove('active')" class="btn-modal btn-batal">Kembali</button>
            <button onclick="window.location.href='{{ route('login') }}'" class="btn-modal btn-submit">Login</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    AOS.init({ duration: 700, once: true });

    // Logic peminjaman (sama persis dengan asli)
    const pinjamModal = document.getElementById('pinjamModal');
    const loginModal = document.getElementById('loginModal');

    function handlePinjam() {
        @if(session()->has('user'))
            pinjamModal.classList.add('active');
        @else
            loginModal.classList.add('active');
        @endif
    }

    document.getElementById('btnPinjamKiri')?.addEventListener('click', handlePinjam);
    document.getElementById('btnPinjamBawah')?.addEventListener('click', handlePinjam);

    window.closeModal = function() {
        pinjamModal.classList.remove('active');
        document.getElementById('pinjamForm').reset();
        const btn = document.getElementById('submitPinjamBtn');
        if(btn) { btn.disabled = false; btn.innerText = 'Pinjam'; }
    };

    document.getElementById('loginModal')?.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });

    const today = new Date();
    const borrowInput = document.getElementById('borrow_date');
    const returnInput = document.getElementById('return_date');
    if(borrowInput && returnInput) {
        borrowInput.min = formatDate(today);
        borrowInput.value = formatDate(today);
        const minReturn = new Date(today); minReturn.setDate(minReturn.getDate()+1);
        const maxReturn = new Date(today); maxReturn.setDate(maxReturn.getDate()+3);
        returnInput.min = formatDate(minReturn);
        returnInput.max = formatDate(maxReturn);
        returnInput.value = formatDate(minReturn);

        borrowInput.addEventListener('change', function() {
            const borrow = new Date(this.value);
            borrow.setHours(0,0,0,0);
            const minRet = new Date(borrow); minRet.setDate(minRet.getDate()+1);
            const maxRet = new Date(borrow); maxRet.setDate(maxRet.getDate()+3);
            returnInput.min = formatDate(minRet);
            returnInput.max = formatDate(maxRet);
            const cur = new Date(returnInput.value);
            if (cur < minRet || cur > maxRet) returnInput.value = formatDate(minRet);
        });
    }

    function formatDate(date) {
        const y = date.getFullYear();
        const m = String(date.getMonth()+1).padStart(2,'0');
        const d = String(date.getDate()).padStart(2,'0');
        return `${y}-${m}-${d}`;
    }

    document.getElementById('pinjamForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const borrow = new Date(borrowInput.value);
        const ret = new Date(returnInput.value);
        borrow.setHours(0,0,0,0); ret.setHours(0,0,0,0);
        const diff = (ret - borrow) / (1000*60*60*24);
        if (diff < 1) { alert('Minimal peminjaman 1 hari'); return; }
        if (diff > 3) { alert('Maksimal peminjaman hanya 3 hari'); return; }
        const btn = document.getElementById('submitPinjamBtn');
        btn.innerText = 'Memproses...'; btn.disabled = true;
        this.submit();
    });
</script>
@endpush
