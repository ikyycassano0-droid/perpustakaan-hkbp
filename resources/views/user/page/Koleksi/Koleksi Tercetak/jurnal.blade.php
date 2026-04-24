@extends('user.component.master')

@section('title', 'Jurnal Ilmiah - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN JURNAL
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */
    
    /* Glass card untuk jurnal */
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
    
    /* Search input */
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
    
    /* Journal Card */
    .journal-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
        height: 100%;
    }
    
    .journal-card:hover {
        transform: translateY(-8px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.3);
    }
    
    .journal-header {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .journal-title {
        font-weight: 700;
        font-size: 1.1rem;
        line-height: 1.4;
        color: #c7d2fe;
        margin-bottom: 0.5rem;
    }
    
    .journal-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.7rem;
        color: #94a3b8;
    }
    
    .journal-body {
        padding: 1.25rem;
    }
    
    .journal-abstract {
        font-size: 0.85rem;
        color: #cbd5e1;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    
    .journal-keywords {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .keyword-tag {
        background: rgba(99, 102, 241, 0.15);
        border: 1px solid rgba(99, 102, 241, 0.3);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.65rem;
        color: #a5b4fc;
    }
    
    .journal-ref {
        font-size: 0.7rem;
        color: #64748b;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 0.75rem;
        margin-top: 0.5rem;
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
        padding: 8px 20px;
        border-radius: 40px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.8rem;
    }
    
    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }
    
    /* Filter button */
    .filter-btn {
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        color: #cbd5e1;
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
    }
    
    .filter-btn:hover {
        border-color: #6366f1;
        color: white;
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
    
    /* Notification */
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
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                📚 AKPER HKBP BALIGE
            </span>
        </div>

        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Jurnal Ilmiah
        </h1>

        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Kumpulan artikel ilmiah, penelitian keperawatan, dan publikasi akademik dari civitas academica AKPER HKBP Balige.
        </p>
    </section>

    <!-- CONTENT SECTION -->
    <section class="section max-w-6xl mx-auto px-5">

        <div class="neon-border fade-up">
            <div class="neon-inner">

                <!-- SEARCH -->
                <div class="mb-6">
                    <input type="text" id="searchInput" class="search-input"
                        placeholder="🔍 Cari jurnal, penulis, atau kata kunci...">
                </div>

                <!-- FILTER -->
                <div class="flex flex-wrap gap-3 mb-8">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <button class="filter-btn" data-filter="keperawatan">Keperawatan</button>
                    <button class="filter-btn" data-filter="kesehatan">Kesehatan</button>
                    <button class="filter-btn" data-filter="penelitian">Penelitian</button>
                    <button class="filter-btn" data-filter="2024">2024</button>
                </div>

                <!-- GRID -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="journalGrid"></div>

                <!-- PAGINATION -->
                <div class="flex justify-between items-center mt-8">

                    <div class="text-sm text-gray-400" id="paginationInfo">
                        Menampilkan data...
                    </div>

                    <div class="flex gap-2">
                        <button class="pagination-btn" id="prevPage">◀</button>
                        <button class="pagination-btn" id="nextPage">▶</button>
                    </div>

                </div>

            </div>
        </div>

    </section>

    <!-- CTA SECTION -->
    <section class="section max-w-6xl mx-auto px-5 mb-16">

        <div class="glass-card p-6 rounded-2xl text-center fade-up">

            <h3 class="font-semibold text-indigo-200 mb-2">
                Ingin Mempublikasikan Jurnal?
            </h3>

            <p class="text-sm text-gray-400 mb-4">
                Kirimkan artikel ilmiah Anda untuk direview dan dipublikasikan.
            </p>

            <button id="submitJournalBtn" class="btn-primary">
                Submit Jurnal →
            </button>

        </div>

    </section>

</div>
@endsection

@push('scripts')
<script>
// ============================================
// FIX & LANJUTAN SCRIPT JURNAL
// ============================================

// STATE
let currentPage = 1;
const itemsPerPage = 4;
let currentFilter = 'all';
let searchQuery = '';

// VIEW DETAIL (opsional jika nanti mau modal)
function viewJournal(id) {
    const journal = journalData.find(j => j.id === id);
    if (journal) {
        showNotification(`📖 ${journal.title}`, 'info');
    }
}

// DOWNLOAD
function downloadJournal(id) {
    const journal = journalData.find(j => j.id === id);
    if (journal) {
        showNotification(`📥 Download: ${journal.title}`, 'success');
    }
}

// NOTIFICATION
function showNotification(message, type = 'success') {
    const notif = document.createElement('div');
    notif.className = 'notification';
    notif.innerHTML = `
        <div class="flex items-center gap-2">
            <span>
                ${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}
            </span>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(notif);

    setTimeout(() => notif.classList.add('show'), 50);

    setTimeout(() => {
        notif.classList.remove('show');
        setTimeout(() => notif.remove(), 300);
    }, 3000);
}

// RENDER FUNCTION (FIXED)
function renderJournals() {
    let filtered = [...journalData];

    // search
    if (searchQuery) {
        filtered = filtered.filter(item =>
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.authors.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.keywords.some(k => k.toLowerCase().includes(searchQuery.toLowerCase()))
        );
    }

    // filter
    if (currentFilter !== 'all') {
        filtered = filtered.filter(item =>
            item.category === currentFilter ||
            item.year.toString() === currentFilter
        );
    }

    const totalItems = filtered.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);

    if (currentPage > totalPages) currentPage = 1;

    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const data = filtered.slice(start, end);

    // GRID
    const grid = document.getElementById('journalGrid');
    grid.innerHTML = '';

    if (data.length === 0) {
        grid.innerHTML = `
            <div class="col-span-2 text-center py-10 text-gray-400">
                📭 Jurnal tidak ditemukan
            </div>
        `;
        return;
    }

    data.forEach(j => {
        const el = document.createElement('div');
        el.className = 'journal-card fade-up';

        el.innerHTML = `
            <div class="journal-header">
                <div class="journal-title">${j.title}</div>
                <div class="journal-meta">
                    <span>👨‍⚕️ ${j.authors}</span>
                    <span>📅 ${j.year}</span>
                    <span>📄 ${j.volume}</span>
                </div>
            </div>

            <div class="journal-body">
                <div class="journal-abstract">
                    ${j.abstract.substring(0, 160)}...
                </div>

                <div class="journal-keywords">
                    ${j.keywords.map(k => `<span class="keyword-tag">#${k}</span>`).join('')}
                </div>

                <div class="flex gap-2 mt-3">
                    <button class="btn-outline" onclick="viewJournal(${j.id})">
                        📖 Detail
                    </button>
                    <button class="btn-primary" onclick="downloadJournal(${j.id})">
                        📥 PDF
                    </button>
                </div>
            </div>
        `;

        grid.appendChild(el);
    });

    // pagination info
    document.getElementById('paginationInfo').innerText =
        `Menampilkan ${start + 1} - ${Math.min(end, totalItems)} dari ${totalItems}`;

    // update button pagination
    document.getElementById('prevPage').disabled = currentPage === 1;
    document.getElementById('nextPage').disabled = currentPage === totalPages || totalPages === 0;

    // animate
    setTimeout(() => {
        document.querySelectorAll('.journal-card').forEach((el, i) => {
            el.style.setProperty('--delay', `${i * 0.05}s`);
            el.classList.add('show');
        });
    }, 50);
}

// FILTER CLICK
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        currentFilter = e.target.dataset.filter;
        currentPage = 1;

        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        e.target.classList.add('active');

        renderJournals();
    });
});

// SEARCH
document.getElementById('searchInput').addEventListener('input', (e) => {
    searchQuery = e.target.value;
    currentPage = 1;
    renderJournals();
});

// PAGINATION
document.getElementById('prevPage').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        renderJournals();
    }
});

document.getElementById('nextPage').addEventListener('click', () => {
    currentPage++;
    renderJournals();
});

// INIT
document.addEventListener('DOMContentLoaded', () => {
    renderJournals();
});

console.log('Jurnal page loaded successfully 🚀');
</script>
@endpush