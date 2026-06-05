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
    .pagination-info {
        margin-top: 20px;
        text-align: center;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    /* ===== MODAL PEMINJAMAN ===== */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        z-index: 2000;
        align-items: center;
        justify-content: center;
    }
    .modal-content {
        background: var(--card-bg);
        max-width: 550px;
        width: 90%;
        border-radius: 32px;
        box-shadow: 0 25px 45px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        animation: fadeInUp 0.3s ease;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .modal-header {
        padding: 24px 28px 16px 28px;
        background: white;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .modal-header h3 i {
        color: var(--primary-color);
        font-size: 1.6rem;
    }
    .close-modal {
        font-size: 1.8rem;
        cursor: pointer;
        color: #9aa6b5;
        transition: 0.2s;
        line-height: 1;
    }
    .close-modal:hover { color: var(--danger); }
    .modal-body { padding: 28px 28px 20px; }
    .form-group { margin-bottom: 24px; }
    .form-group label {
        display: block;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--text-dark);
        font-size: 0.9rem;
    }
    .form-group label i {
        color: var(--primary-color);
        margin-right: 8px;
        width: 20px;
    }
    .form-group select,
    .form-group input {
        width: 100%;
        padding: 14px 18px;
        border: 1.5px solid var(--border-color);
        border-radius: 16px;
        font-size: 0.95rem;
        outline: none;
        transition: 0.2s;
        background: white;
    }
    .form-group select:focus,
    .form-group input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(26, 107, 71, 0.1);
    }
    .info-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .info-hint i { color: var(--accent-green); }
    .modal-footer {
        padding: 16px 28px 28px;
        background: white;
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        border-top: 1px solid var(--border-color);
    }
    .btn-batal {
        background: #f1f3f5;
        color: #495057;
        border: none;
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-batal:hover { background: #e9ecef; }
    .btn-submit {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 40px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-submit:hover {
        background: var(--deep-green);
        transform: translateY(-2px);
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
                        <th>Aksi</th>
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
                            <td data-label="Aksi" class="loan-actions">
                                <a href="#">Detail</a>
                                @if($order->status === 'APPROVED')
                                    <a href="#">Perpanjang</a>
                                @endif
                            </td>
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
        @if($peminjaman->hasPages())
            <div class="pagination-info mt-4">
                {{ $peminjaman->links() }}
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

{{-- MODAL --}}
<div id="pinjamModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-feather-alt"></i> Form Peminjaman Buku</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-book"></i> Judul Buku / Kata Kunci</label>
                    <input type="text" name="collection_id" id="judulBukuInput" placeholder="Cari judul buku, pengarang, atau ISBN..." autocomplete="off" required>
                    <div class="info-hint" style="font-size:0.7rem; margin-top:6px;">
                        <i class="fas fa-lightbulb"></i> Contoh: Keperawatan Medikal Bedah, Farmakologi, dll.
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar-plus"></i> Tanggal Pinjam</label>
                    <input type="date" name="borrow_date" id="tglPinjam" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar-check"></i> Tanggal Kembali (maksimal 3 hari)</label>
                    <input type="date" name="return_date" id="tglKembali" readonly>
                    <div class="info-hint">
                        <i class="fas fa-clock"></i> Masa pinjam otomatis 3 hari (termasuk akhir pekan)
                    </div>
                </div>
                <div class="info-hint" style="color: var(--primary-color); background: #F2F7F4; padding: 12px 16px; border-radius: 20px; margin-top: 12px;">
                    <i class="fas fa-gem"></i> Peminjaman akan diproses oleh petugas perpustakaan dalam <strong>≤ 1x24 jam</strong>.
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-batal" id="closeModalBtn">Batal</button>
            <button type="submit" form="pinjamForm" class="btn-submit"><i class="fas fa-paper-plane"></i> Ajukan Peminjaman</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Filter chips
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

    // Modal logic
    const modal = document.getElementById('pinjamModal');
    const openBtn = document.getElementById('openPinjamModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const closeSpan = document.querySelector('.close-modal');
    const tglPinjam = document.getElementById('tglPinjam');
    const tglKembali = document.getElementById('tglKembali');

    function hitungTglKembali() {
        if (!tglPinjam.value) { tglKembali.value = ''; return; }
        let pinjamDate = new Date(tglPinjam.value);
        if (isNaN(pinjamDate)) return;
        let kembaliDate = new Date(pinjamDate);
        kembaliDate.setDate(pinjamDate.getDate() + 3);
        tglKembali.value = kembaliDate.toISOString().split('T')[0];
    }
    tglPinjam.addEventListener('change', hitungTglKembali);

    const today = new Date().toISOString().split('T')[0];
    tglPinjam.min = today;

    openBtn.onclick = () => {
        modal.style.display = 'flex';
        document.getElementById('pinjamForm').reset();
        tglKembali.value = '';
    };
    function closeModal() { modal.style.display = 'none'; }
    closeBtn.onclick = closeModal;
    closeSpan.onclick = closeModal;
    window.onclick = (e) => { if (e.target === modal) closeModal(); };
</script>
@endpush
