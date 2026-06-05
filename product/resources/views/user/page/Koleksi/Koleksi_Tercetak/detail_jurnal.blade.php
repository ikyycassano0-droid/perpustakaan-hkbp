{{-- resources/views/user/page/Koleksi/Koleksi_Tercetak/detail_jurnal.blade.php --}}
@extends('user.component.master')

@section('title', $collection->title . ' - Perpustakaan AKPER HKBP')

@push('styles')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { background-color: #f4f7f5; color: #0d2137; line-height: 1.6; font-family: 'DM Sans', sans-serif; overflow-x: hidden; }
    a { text-decoration: none; color: inherit; }
    :root {
        --primary-color: #1a6b47; --deep-green: #0f4a31; --accent-green: #2daa6e;
        --accent-yellow: #f1c40f; --text-dark: #0d2137; --text-muted: #5a7060;
        --light-bg: #f4f7f5; --card-bg: #ffffff; --border-color: #d4e5d9; --danger: #e74c3c; --paper: #fffcf0;
    }

    .main-wrapper { max-width: 1400px; margin: 50px auto; padding: 0 20px; display: grid; grid-template-columns: 380px 1fr; gap: 60px; }
    .book-wrap { perspective: 1500px; position: sticky; top: 120px; }
    .book { width: 320px; height: 480px; position: relative; transform-style: preserve-3d; transform: rotateY(-25deg); transition: transform 0.8s; }
    .book:hover { transform: rotateY(-5deg) translateX(50px); }
    .cover { position: absolute; width: 100%; height: 100%; background: var(--primary-color); border-radius: 3px 12px 12px 3px; z-index: 10; transform-origin: left; transition: transform 0.8s; box-shadow: 10px 10px 25px rgba(0,0,0,0.3); overflow: hidden; }
    .cover img { width: 100%; height: 100%; object-fit: cover; }
    .page { position: absolute; width: 98%; height: 96%; top: 2%; left: 1%; background: var(--paper); padding: 40px 30px; box-shadow: inset 0 0 10px rgba(0,0,0,0.1); z-index: 5; transform: translateZ(-1px); display: flex; flex-direction: column; gap: 15px; }
    .page h2 { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--primary-color); border-bottom: 2px solid var(--accent-yellow); display: inline-block; padding-bottom: 5px; }
    .page p { font-family: 'Playfair Display', serif; font-style: italic; font-size: 0.95rem; line-height: 1.7; color: #444; }
    .spine { position: absolute; width: 45px; height: 100%; background: var(--deep-green); left: 0; transform: rotateY(-90deg); transform-origin: left; z-index: 8; }
    .book:hover .cover { transform: rotateY(-155deg); }

    .detail-box { background: white; border-radius: 25px; padding: 45px; box-shadow: 0 8px 24px rgba(15,74,49,0.08); border: 1px solid var(--border-color); border-top: 4px solid var(--accent-yellow); }
    .title-area h1 { font-family: 'Playfair Display', serif; font-size: 2.4rem; color: var(--primary-color); margin-bottom: 10px; line-height: 1.2; }
    .author-edition { color: var(--text-muted); margin-bottom: 35px; font-size: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; }
    .availability-card { background: #fff; border: 1px solid var(--border-color); border-radius: 16px; overflow: hidden; margin-bottom: 40px; }
    .avail-table { width: 100%; border-collapse: collapse; }
    .avail-table th { background: #f0f7f3; color: var(--primary-color); font-weight: 700; text-align: left; padding: 16px 24px; font-size: 0.9rem; border-bottom: 2px solid var(--border-color); }
    .avail-table td { padding: 20px 24px; color: var(--text-dark); font-size: 0.95rem; border-bottom: 1px solid var(--border-color); }
    .status-badge { display: inline-flex; align-items: center; gap: 8px; color: var(--accent-green); font-weight: 700; font-size: 0.9rem; }
    .pulse-dot { width: 8px; height: 8px; background: var(--accent-green); border-radius: 50%; position: relative; }
    .pulse-dot::after { content: ''; position: absolute; width: 100%; height: 100%; background: var(--accent-green); border-radius: 50%; animation: pulse-ring 1.5s infinite; }
    @keyframes pulse-ring { 0% { transform: scale(0.33); opacity: 0.8; } 80%,100% { transform: scale(2.5); opacity: 0; } }

    .cards-row { display: flex; gap: 20px; margin-bottom: 40px; flex-wrap: wrap; }
    .info-card { flex: 1; min-width: 320px; background: #ffffff; border-radius: 16px; padding: 25px 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); border: 1px solid var(--border-color); transition: 0.3s; }
    .info-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(15,74,49,0.08); border-color: var(--accent-green); }
    .info-card h3 { font-size: 1.1rem; font-weight: 700; color: var(--primary-color); margin-bottom: 20px; border-left: 4px solid var(--accent-yellow); padding-left: 12px; }
    .info-item { display: grid; grid-template-columns: 120px 1fr; margin-bottom: 18px; align-items: baseline; }
    .info-label { font-weight: 600; color: var(--text-muted); font-size: 0.85rem; }
    .info-value { color: var(--text-dark); font-size: 0.9rem; line-height: 1.5; }

    .sinopsis-card { background: #fff; border-radius: 20px; padding: 30px; margin-bottom: 40px; border: 1px solid var(--border-color); }
    .sinopsis-card h3 { font-size: 1.3rem; font-weight: 700; color: var(--primary-color); margin-bottom: 20px; border-left: 4px solid var(--accent-yellow); padding-left: 15px; }
    .sinopsis-card p { line-height: 1.8; color: var(--text-dark); text-align: justify; }

    .btn-reserve { width: 100%; padding: 20px; background: var(--primary-color); color: white; border: none; border-radius: 15px; font-weight: 700; cursor: pointer; margin-top: 40px; transition: 0.4s; font-size: 1rem; }
    .btn-reserve:hover { background: var(--accent-green); transform: translateY(-3px); }
    .btn-reserve:disabled { opacity: 0.6; cursor: not-allowed; }
    .btn-back { display: block; width: 100%; padding: 15px; background: white; color: var(--primary-color); border: 2px solid var(--primary-color); border-radius: 15px; font-weight: 700; cursor: pointer; margin-top: 15px; transition: 0.4s; font-size: 1rem; text-align: center; text-decoration: none; }
    .btn-back:hover { background: var(--primary-color); color: white; transform: translateY(-3px); }

    /* Modal */
    .modal-overlay { position: fixed; inset: 0; background: rgba(15,74,49,0.4); backdrop-filter: blur(8px); z-index: 2000; display: flex; align-items: center; justify-content: center; visibility: hidden; opacity: 0; transition: all 0.3s; }
    .modal-overlay.active { visibility: visible; opacity: 1; }
    .modal-container { background: white; border-radius: 24px; width: 100%; max-width: 480px; margin: 1rem; box-shadow: 0 25px 50px rgba(15,74,49,0.25); border: 1px solid var(--border-color); transform: scale(0.9); transition: transform 0.3s; padding: 2rem; }
    .modal-overlay.active .modal-container { transform: scale(1); }
    .modal-container h2 { font-size: 1.4rem; font-weight: 700; color: var(--primary-color); margin-bottom: 1.5rem; }
    .modal-container label { font-size: 0.85rem; font-weight: 600; color: var(--text-dark); display: block; margin-bottom: 0.4rem; }
    .modal-container input { width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 12px; font-size: 0.9rem; margin-bottom: 1rem; background: #f9fbf9; }
    .modal-actions { display: flex; gap: 12px; margin-top: 1rem; }
    .btn-modal { flex: 1; padding: 12px; border-radius: 40px; font-weight: 600; font-size: 0.9rem; cursor: pointer; border: none; }
    .btn-batal { background: #f1f5f9; color: #475569; }
    .btn-submit { background: var(--primary-color); color: white; }
    .btn-submit:hover { background: var(--deep-green); }
    .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }

    @media (max-width: 1024px) { .main-wrapper { grid-template-columns: 1fr; } .book-wrap { position: relative; top: 0; margin: 0 auto 50px; width: 320px; } }
    @media (max-width: 640px) { .cards-row { flex-direction: column; } .info-item { grid-template-columns: 1fr; gap: 4px; } }
</style>
@endpush

@section('content')
<div class="main-wrapper">
    <div class="book-wrap" data-aos="zoom-in-right">
        <div class="book">
            <div class="spine"></div>
            <div class="cover">
                <img src="{{ $collection->cover_image ? asset('storage/'.$collection->cover_image) : 'https://via.placeholder.com/400x600?text=Jurnal+Cover' }}" alt="Cover">
            </div>
            <div class="page">
                <h2>Abstrak</h2>
                <p>{{ Str::limit($collection->description ?? 'Tidak ada abstrak.', 200) }}</p>
                <div style="font-size: 0.75rem; color: #888; margin-top: auto;">
                    <i class="fas fa-calendar-alt"></i> Terbit: {{ $collection->publication_year ?? '-' }}<br>
                    <i class="fas fa-building"></i> {{ $collection->publisher ?? 'AKPER HKBP Press' }}
                </div>
            </div>
        </div>

        {{-- Tombol Pinjam / Status --}}
        @if(session()->has('user'))
            @if($borrowStatus)
                @if($borrowStatus['status'] == 'PENDING')
                    <button class="btn-reserve" disabled>⏳ Menunggu Konfirmasi</button>
                @elseif($borrowStatus['status'] == 'APPROVED')
                    <button class="btn-reserve" disabled>📚 Sedang Dipinjam</button>
                @elseif($borrowStatus['status'] == 'REJECTED')
                    <button class="btn-reserve" id="btnPinjamKiri"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
                @endif
            @elseif($collection->available_stock > 0)
                <button class="btn-reserve" id="btnPinjamKiri"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
            @else
                <button class="btn-reserve" disabled>Stok Habis</button>
            @endif
        @else
            <button class="btn-reserve" id="btnPinjamKiri"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
        @endif

        <a href="{{ route('user.koleksi.jurnal') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Menu Jurnal
        </a>
    </div>

    <div class="detail-box" data-aos="fade-left">
        <div class="title-area">
            <span style="color: var(--accent-green); font-weight: 800; font-size: 0.75rem; text-transform: uppercase;">Koleksi Jurnal Tercetak</span>
            <h1>{{ $collection->title }}</h1>
            <div class="author-edition">
                @php
                    $authors = is_array($collection->author) ? $collection->author : json_decode($collection->author, true) ?? [];
                    $authorStr = !empty($authors) ? implode(', ', $authors) : 'Tim Penulis';
                @endphp
                <strong>{{ $authorStr }}</strong> —
                @if($collection->edition) Vol. {{ $collection->edition }}, @endif
                {{ $collection->publication_year ?? '-' }}
            </div>
        </div>

        <div class="cards-row">
            <div class="info-card">
                <h3>Informasi Publikasi</h3>
                <div class="info-item"><div class="info-label">ISSN/ISBN</div><div class="info-value">{{ $collection->isbn ?? '-' }}</div></div>
                <div class="info-item"><div class="info-label">Penerbit</div><div class="info-value">{{ $collection->publisher ?? 'AKPER HKBP Press' }}</div></div>
                <div class="info-item"><div class="info-label">Bahasa</div><div class="info-value">{{ $collection->language ?? 'Indonesia' }}</div></div>
                <div class="info-item"><div class="info-label">Format</div><div class="info-value">{{ $collection->format ?? 'Cetak' }}</div></div>
                @if($collection->location)
                <div class="info-item"><div class="info-label">Lokasi</div><div class="info-value">{{ $collection->location->name }}</div></div>
                @endif
            </div>
            <div class="info-card">
                <h3>Kategorisasi</h3>
                <div class="info-item">
                    <div class="info-label">Kategori</div>
                    <div class="info-value">{{ $collection->categories->isNotEmpty() ? $collection->categories->pluck('name')->join(', ') : 'Umum' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Klasifikasi</div>
                    <div class="info-value">{{ $collection->classifications->isNotEmpty() ? $collection->classifications->pluck('name')->join(', ') : '-' }}</div>
                </div>
                <div class="info-item"><div class="info-label">Edisi</div><div class="info-value">{{ $collection->edition ?? '-' }}</div></div>
                <div class="info-item"><div class="info-label">Tahun Terbit</div><div class="info-value">{{ $collection->publication_year ?? '-' }}</div></div>
            </div>
        </div>

        <div class="sinopsis-card">
            <h3>Abstrak / Deskripsi</h3>
            <p>{{ $collection->description ?? 'Tidak ada deskripsi tersedia.' }}</p>
        </div>

        <div class="availability-card">
            <table class="avail-table">
                <thead><tr><th>Tipe Ketersediaan</th><th>Status</th></tr></thead>
                <tbody>
                    <tr>
                        <td>Stok Tersedia</td>
                        <td>
                            @if(($collection->available_stock ?? 0) > 0)
                                <div class="status-badge"><div class="pulse-dot"></div> Tersedia ({{ $collection->available_stock }} eksemplar)</div>
                            @else
                                <div class="status-badge" style="color: var(--danger);">Tidak Tersedia</div>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Tombol Pinjam Bawah --}}
        @if(session()->has('user'))
            @if($borrowStatus)
                @if($borrowStatus['status'] == 'PENDING')
                    <button class="btn-reserve" disabled>⏳ Menunggu Konfirmasi</button>
                @elseif($borrowStatus['status'] == 'APPROVED')
                    <button class="btn-reserve" disabled>📚 Sedang Dipinjam</button>
                @elseif($borrowStatus['status'] == 'REJECTED')
                    <button class="btn-reserve" id="btnPinjamBawah"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
                @endif
            @elseif($collection->available_stock > 0)
                <button class="btn-reserve" id="btnPinjamBawah"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
            @else
                <button class="btn-reserve" disabled>Stok Habis</button>
            @endif
        @else
            <button class="btn-reserve" id="btnPinjamBawah"><i class="fas fa-book-reader"></i> PINJAM SEKARANG</button>
        @endif

        <a href="{{ route('user.koleksi.jurnal') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Menu Jurnal
        </a>
    </div>
</div>

{{-- MODAL PEMINJAMAN --}}
<div id="pinjamModal" class="modal-overlay">
    <div class="modal-container">
        <h2><i class="fas fa-calendar-check" style="color:var(--primary-color);"></i> Form Peminjaman Jurnal</h2>
        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="collection_id" value="{{ $collection->id }}">
            <div>
                <label>Judul Jurnal</label>
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

{{-- MODAL LOGIN --}}
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
    AOS.init({ duration: 1000, once: true });

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

    // Tutup modal pinjam
    window.closeModal = function() {
        pinjamModal.classList.remove('active');
        document.getElementById('pinjamForm').reset();
        const btn = document.getElementById('submitPinjamBtn');
        if(btn) { btn.disabled = false; btn.innerText = 'Pinjam'; }
    };

    // Tutup modal login
    document.getElementById('loginModal')?.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });

    // Tanggal otomatis
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

    // Submit form
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
