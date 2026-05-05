@extends('user.component.master')

@section('title', 'Layanan PINBAL')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN PINBAL
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */
    
    /* Glass card untuk pinbal */
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
    
    /* Stat Card */
    .stat-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        padding: 1.25rem;
        text-align: center;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.3);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }
    
    /* Search Input */
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
    
    /* Table Styles */
    .table-container {
        overflow-x: auto;
        border-radius: 1rem;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        text-align: left;
        padding: 1rem 1rem;
        background: rgba(99, 102, 241, 0.15);
        color: #c7d2fe;
        font-weight: 600;
        font-size: 0.85rem;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .data-table td {
        padding: 1rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
        font-size: 0.9rem;
        vertical-align: middle;
    }
    
    .data-table tr:hover {
        background: rgba(99, 102, 241, 0.08);
    }
    
    /* Book Image */
    .book-image {
        width: 50px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }
    
    .book-image:hover {
        transform: scale(1.1);
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .status-dipinjam {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.5);
    }
    
    .status-dikembalikan {
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.5);
    }
    
    .status-terlambat {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.5);
    }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.85rem;
    }
    
    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
    }
    
    .btn-outline {
        background: transparent;
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.85rem;
    }
    
    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
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
    
    /* Membership Badge */
    .membership-active {
        background: linear-gradient(135deg, #10b981, #059669);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
    }
    
    /* Notification custom */
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
    
    /* Delay utilities */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📚 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Sistem Pinbal Akademik
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Kelola riwayat peminjaman buku perpustakaan Anda dengan presisi. Pantau batas waktu pengembalian untuk menjaga kredibilitas akademik Anda.
        </p>
    </section>

    <!-- STATISTIK SECTION -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">📖</div>
                <div class="stat-number" id="aktifDipinjam">04</div>
                <div class="text-xs text-gray-400 mt-1">Aktif Dipinjam</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">⏰</div>
                <div class="stat-number" id="mendekatiDeadline">01</div>
                <div class="text-xs text-gray-400 mt-1">Mendekati Deadline</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">📚</div>
                <div class="stat-number" id="totalRiwayat">28</div>
                <div class="text-xs text-gray-400 mt-1">Total Riwayat</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-2xl mb-1">🎓</div>
                <div class="membership-active mx-auto" style="width: fit-content;">AKTIF</div>
                <div class="text-xs text-gray-400 mt-2">Status Keanggotaan</div>
            </div>
        </div>
    </section>

    <!-- SEARCH & TABLE SECTION -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                
                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari judul buku atau kode...">
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-3 mb-6">
                    <button class="btn-primary" data-filter="all">Semua Buku</button>
                    <button class="btn-outline" data-filter="dipinjam">Dipinjam</button>
                    <button class="btn-outline" data-filter="dikembalikan">Dikembalikan</button>
                    <button class="btn-outline" data-filter="terlambat">Terlambat</button>
                </div>

                <!-- Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>📖 BUKU & KATALOG</th>
                                <th>📅 TANGGAL PINJAM</th>
                                <th>⏰ BATAS KEMBALI</th>
                                <th>📌 STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info -->
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-400" id="paginationInfo">
                        Menampilkan 1 dari 3 entri
                    </div>
                    <div class="flex gap-2" id="paginationButtons">
                        <button class="pagination-btn" id="prevPage">◀ Sebelumnya</button>
                        <button class="pagination-btn" id="nextPage">Berikutnya ▶</button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ACTION BUTTONS -->
    <section class="section max-w-6xl mx-auto px-5 mb-16">
        <div class="flex flex-wrap justify-center gap-4">
            <button id="pinjamBtn" class="btn-primary px-8 py-3 fade-up">
                📖 Pinjam Buku
            </button>
            <button id="kembalikanBtn" class="btn-outline px-8 py-3 fade-up">
                ↺ Kembalikan Buku
            </button>
            <button id="perpanjangBtn" class="btn-outline px-8 py-3 fade-up">
                🔄 Perpanjang Pinjaman
            </button>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN PINBAL
// Hanya JS yang BELUM ADA di master blade
// ============================================

// DATA PEMINJAMAN DENGAN GAMBAR BUKU
let loanData = [
    {
        id: 1,
        judul: "Prinsip Dasar Keperawatan Klinis",
        kode: "KPR-2024-001",
        gambar: "https://images.unsplash.com/photo-1532012197267-da84d127e765?w=100&h=130&fit=crop",
        tanggalPinjam: "2024-04-12",
        batasKembali: "2024-04-26",
        status: "dipinjam",
        sisaHari: 4
    },
    {
        id: 2,
        judul: "Anatomi Manusia Edisi X",
        kode: "BKO-2023-089",
        gambar: "https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=100&h=130&fit=crop",
        tanggalPinjam: "2024-04-05",
        batasKembali: "2024-04-19",
        status: "dikembalikan",
        sisaHari: null
    },
    {
        id: 3,
        judul: "Farmakologi Dasar untuk Perawat",
        kode: "FRM-2024-012",
        gambar: "https://images.unsplash.com/photo-1585435557343-3b092031a7ec?w=100&h=130&fit=crop",
        tanggalPinjam: "2024-03-20",
        batasKembali: "2024-04-03",
        status: "terlambat",
        sisaHari: -13
    },
    {
        id: 4,
        judul: "Etika Keperawatan Profesional",
        kode: "ETK-2024-005",
        gambar: "https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=100&h=130&fit=crop",
        tanggalPinjam: "2024-04-10",
        batasKembali: "2024-04-24",
        status: "dipinjam",
        sisaHari: 2
    },
    {
        id: 5,
        judul: "Manajemen Asuhan Keperawatan",
        kode: "MAN-2024-008",
        gambar: "https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=100&h=130&fit=crop",
        tanggalPinjam: "2024-04-08",
        batasKembali: "2024-04-22",
        status: "dipinjam",
        sisaHari: 0
    },
    {
        id: 6,
        judul: "Keperawatan Anak",
        kode: "ANK-2024-003",
        gambar: "https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=100&h=130&fit=crop",
        tanggalPinjam: "2024-04-01",
        batasKembali: "2024-04-15",
        status: "dikembalikan",
        sisaHari: null
    },
    {
        id: 7,
        judul: "Keperawatan Maternitas",
        kode: "MAT-2024-007",
        gambar: "https://images.unsplash.com/photo-1518779578993-ec3579fee39f?w=100&h=130&fit=crop",
        tanggalPinjam: "2024-04-15",
        batasKembali: "2024-04-29",
        status: "dipinjam",
        sisaHari: 7
    }
];

// Hitung statistik
function updateStats() {
    const aktif = loanData.filter(item => item.status === 'dipinjam').length;
    const mendekati = loanData.filter(item => item.status === 'dipinjam' && item.sisaHari !== null && item.sisaHari <= 3 && item.sisaHari >= 0).length;
    const total = loanData.length;
    
    document.getElementById('aktifDipinjam').innerHTML = aktif.toString().padStart(2, '0');
    document.getElementById('mendekatiDeadline').innerHTML = mendekati.toString().padStart(2, '0');
    document.getElementById('totalRiwayat').innerHTML = total;
}

// Format tanggal
function formatTanggal(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
}

// Render tabel
let currentPage = 1;
const itemsPerPage = 5;
let currentFilter = 'all';
let searchQuery = '';

function renderTable() {
    let filteredData = [...loanData];
    
    // Filter berdasarkan pencarian
    if (searchQuery) {
        filteredData = filteredData.filter(item => 
            item.judul.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.kode.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }
    
    // Filter berdasarkan status (jika bukan 'all')
    if (currentFilter !== 'all') {
        filteredData = filteredData.filter(item => item.status === currentFilter);
    }
    
    // Pagination
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentData = filteredData.slice(startIndex, endIndex);
    
    // Update pagination info
    document.getElementById('paginationInfo').innerHTML = 
        `Menampilkan ${startIndex + 1} - ${Math.min(endIndex, totalItems)} dari ${totalItems} entri`;
    
    // Generate table rows
    const tbody = document.getElementById('tableBody');
    tbody.innerHTML = '';
    
    currentData.forEach(item => {
        const row = tbody.insertRow();
        
        // Kolom Buku & Katalog (dengan gambar)
        const cellBuku = row.insertCell(0);
        cellBuku.innerHTML = `
            <div class="flex items-center gap-3">
                <img src="${item.gambar}" alt="${item.judul}" class="book-image" 
                     onerror="this.src='https://placehold.co/100x130/1e293b/6366f1?text=📖'">
                <div>
                    <div class="font-semibold">${item.judul}</div>
                    <div class="text-xs text-gray-500">KODE: ${item.kode}</div>
                </div>
            </div>
        `;
        
        // Kolom Tanggal Pinjam
        const cellTglPinjam = row.insertCell(1);
        cellTglPinjam.innerHTML = formatTanggal(item.tanggalPinjam);
        
        // Kolom Batas Kembali
        const cellBatas = row.insertCell(2);
        if (item.status === 'dipinjam' && item.sisaHari !== null) {
            let deadlineText = '';
            let deadlineClass = '';
            if (item.sisaHari === 0) {
                deadlineText = 'Hari Terakhir!';
                deadlineClass = 'text-red-400';
            } else if (item.sisaHari < 0) {
                deadlineText = 'Terlambat';
                deadlineClass = 'text-red-400';
            } else if (item.sisaHari <= 3) {
                deadlineText = `⚠️ Tersisa ${item.sisaHari} Hari`;
                deadlineClass = 'text-yellow-400';
            } else {
                deadlineText = `Tersisa ${item.sisaHari} Hari`;
                deadlineClass = 'text-gray-400';
            }
            cellBatas.innerHTML = `${formatTanggal(item.batasKembali)}<br><span class="text-xs ${deadlineClass}">${deadlineText}</span>`;
        } else {
            cellBatas.innerHTML = formatTanggal(item.batasKembali);
        }
        
        // Kolom Status
        const cellStatus = row.insertCell(3);
        let statusClass = '';
        let statusText = '';
        let statusIcon = '';
        
        switch(item.status) {
            case 'dipinjam':
                statusClass = 'status-dipinjam';
                statusText = 'DIPINJAM';
                statusIcon = '📘';
                break;
            case 'dikembalikan':
                statusClass = 'status-dikembalikan';
                statusText = 'DIKEMBALIKAN';
                statusIcon = '✅';
                break;
            case 'terlambat':
                statusClass = 'status-terlambat';
                statusText = 'TERLAMBAT';
                statusIcon = '⚠️';
                break;
        }
        
        cellStatus.innerHTML = `<span class="status-badge ${statusClass}">${statusIcon} ${statusText}</span>`;
    });
    
    // Update pagination buttons state
    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');
    if (prevBtn) prevBtn.disabled = currentPage === 1;
    if (nextBtn) nextBtn.disabled = currentPage === totalPages || totalPages === 0;
    
    if (totalPages === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center py-8 text-gray-400">📚 Tidak ada data yang ditemukan</td></tr>';
    }
}

// Event listeners untuk filter
document.querySelectorAll('[data-filter]').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const filter = e.target.getAttribute('data-filter');
        currentFilter = filter;
        currentPage = 1;
        
        // Update button styles
        document.querySelectorAll('[data-filter]').forEach(b => {
            if (b.getAttribute('data-filter') === filter) {
                b.classList.remove('btn-outline');
                b.classList.add('btn-primary');
            } else {
                b.classList.remove('btn-primary');
                b.classList.add('btn-outline');
            }
        });
        
        renderTable();
    });
});

// Search event
document.getElementById('searchInput').addEventListener('input', (e) => {
    searchQuery = e.target.value;
    currentPage = 1;
    renderTable();
});

// Pagination
document.getElementById('prevPage').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
    }
});

document.getElementById('nextPage').addEventListener('click', () => {
    currentPage++;
    renderTable();
});

// Action buttons dengan notifikasi
function showCustomNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <span>${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}</span>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

document.getElementById('pinjamBtn').addEventListener('click', () => {
    showCustomNotification('📖 Form peminjaman buku akan segera terbuka. Silakan lengkapi data peminjaman.', 'info');
});

document.getElementById('kembalikanBtn').addEventListener('click', () => {
    showCustomNotification('↺ Silakan pilih buku yang akan dikembalikan.', 'info');
});

document.getElementById('perpanjangBtn').addEventListener('click', () => {
    showCustomNotification('🔄 Perpanjangan pinjaman dapat dilakukan H-3 sebelum batas waktu.', 'info');
});

// Inisialisasi
updateStats();
renderTable();

// Efek tambahan untuk stagger animation pada stat cards
const statCards = document.querySelectorAll('.stat-card');
statCards.forEach((card, idx) => {
    card.style.transitionDelay = `${idx * 0.1}s`;
});

console.log('Halaman Sistem Pinbal Akademik siap dengan data peminjaman lengkap!');
</script>
@endpush