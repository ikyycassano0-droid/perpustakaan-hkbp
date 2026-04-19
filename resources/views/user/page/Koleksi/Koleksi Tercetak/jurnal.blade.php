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
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📚 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Jurnal Ilmiah
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Kumpulan artikel ilmiah, penelitian keperawatan, dan publikasi akademik dari civitas academica AKPER HKBP Balige.
        </p>
    </section>

    <!-- SEARCH & FILTER SECTION -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                
                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari judul jurnal, penulis, atau kata kunci...">
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-3 mb-8">
                    <button class="filter-btn active" data-filter="all">Semua Jurnal</button>
                    <button class="filter-btn" data-filter="keperawatan">Keperawatan</button>
                    <button class="filter-btn" data-filter="kesehatan">Kesehatan Masyarakat</button>
                    <button class="filter-btn" data-filter="penelitian">Penelitian</button>
                    <button class="filter-btn" data-filter="2024">Tahun 2024</button>
                </div>

                <!-- Journal Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="journalGrid">
                    <!-- Journal cards will be inserted by JavaScript -->
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-8">
                    <div class="text-sm text-gray-400" id="paginationInfo">
                        Menampilkan 1 - 3 dari 6 jurnal
                    </div>
                    <div class="flex gap-2" id="paginationButtons">
                        <button class="pagination-btn" id="prevPage">◀ Sebelumnya</button>
                        <button class="pagination-btn" id="nextPage">Berikutnya ▶</button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SUBMIT JOURNAL CTA -->
    <section class="section max-w-6xl mx-auto px-5 mb-16">
        <div class="glass-card p-6 rounded-2xl fade-up text-center">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">✍️</span>
                    <div>
                        <h3 class="font-semibold text-indigo-200">Ingin Mempublikasikan Jurnal?</h3>
                        <p class="text-sm text-gray-400">Kirimkan artikel ilmiah Anda untuk direview dan dipublikasikan.</p>
                    </div>
                </div>
                <button id="submitJournalBtn" class="btn-primary px-6 py-2 text-sm">
                    Submit Jurnal →
                </button>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN JURNAL
// Hanya JS yang BELUM ADA di master blade
// ============================================

// DATA JURNAL
let journalData = [
    {
        id: 1,
        title: "Implementasi Perawatan Luka Diabetes Melitus Menggunakan Metode Modern Dressing di Wilayah Toba",
        authors: "Pardede, J. A., Simanjuntak, G. V., & Siahaan, Y.",
        journal: "Jurnal Keperawatan Indonesia",
        volume: "12(2)",
        year: 2024,
        category: "keperawatan",
        abstract: "Prevalensi diabetes melitus di wilayah Toba terus mengalami peningkatan signifikan dalam lima tahun terakhir. Salah satu komplikasi yang paling sering ditemui adalah ulkus diabetikum yang memerlukan penanganan intensif. Penelitian ini bertujuan untuk mengevaluasi efektivitas penggunaan modern dressing dibandingkan dengan teknik konvensional dalam mempercepat proses granulasi jaringan pada pasien luka diabetes. Metode penelitian menggunakan kuasi-eksperimen dengan kontrol group. Hasil menunjukkan bahwa rata-rata waktu penyembuhan luka dengan modern dressing adalah 14 hari, sementara metode konvensional mencapai 22 hari (p < 0.05).",
        keywords: ["Diabetes Melitus", "Modern Dressing", "Kesehatan Masyarakat", "Wilayah Toba"],
        references: 4,
        doi: "10.1234/jki.v12i2.001"
    },
    {
        id: 2,
        title: "Efektivitas Pendidikan Kesehatan tentang PHBS pada Remaja di Sekolah Menengah Atas",
        authors: "Hutabarat, R., & Silalahi, M.",
        journal: "Jurnal Promosi Kesehatan",
        volume: "9(1)",
        year: 2024,
        category: "kesehatan",
        abstract: "Perilaku Hidup Bersih dan Sehat (PHBS) merupakan faktor penting dalam mencegah berbagai penyakit. Penelitian ini bertujuan untuk mengetahui efektivitas pendidikan kesehatan terhadap peningkatan pengetahuan dan sikap remaja tentang PHBS. Desain penelitian menggunakan pre-experimental one group pre-test post-test. Sampel berjumlah 60 siswa SMA. Hasil menunjukkan peningkatan skor pengetahuan dari 55.6 menjadi 85.2 (p<0.001) dan skor sikap dari 62.3 menjadi 88.7 (p<0.001).",
        keywords: ["PHBS", "Remaja", "Pendidikan Kesehatan", "Promosi Kesehatan"],
        references: 2,
        doi: "10.5678/jpk.v9i1.002"
    },
    {
        id: 3,
        title: "Hubungan Tingkat Stres dengan Kualitas Tidur pada Mahasiswa Keperawatan",
        authors: "Nainggolan, E., & Manurung, D.",
        journal: "Jurnal Ilmu Keperawatan",
        volume: "15(3)",
        year: 2023,
        category: "keperawatan",
        abstract: "Mahasiswa keperawatan rentan mengalami stres akademik yang dapat berdampak pada kualitas tidur. Penelitian ini bertujuan menganalisis hubungan antara tingkat stres dengan kualitas tidur mahasiswa keperawatan. Metode cross-sectional dilakukan pada 120 mahasiswa. Hasil menunjukkan 65% mahasiswa mengalami stres sedang dan 55% memiliki kualitas tidur buruk. Terdapat hubungan signifikan antara tingkat stres dengan kualitas tidur (p<0.05, r=0.542).",
        keywords: ["Stres", "Kualitas Tidur", "Mahasiswa Keperawatan", "Kesehatan Mental"],
        references: 2,
        doi: "10.7890/jik.v15i3.003"
    },
    {
        id: 4,
        title: "Analisis Faktor Risiko Kejadian Hipertensi pada Lansia di Panti Sosial",
        authors: "Sitompul, T., & Lumbanraja, S.",
        journal: "Jurnal Gerontologi Keperawatan",
        volume: "7(2)",
        year: 2023,
        category: "penelitian",
        abstract: "Hipertensi merupakan masalah kesehatan utama pada lansia. Penelitian ini bertujuan menganalisis faktor risiko kejadian hipertensi pada lansia. Desain case-control dengan 100 responden. Hasil menunjukkan faktor riwayat keluarga (OR=3.2), obesitas (OR=2.8), dan konsumsi garam berlebih (OR=2.5) merupakan faktor risiko dominan.",
        keywords: ["Hipertensi", "Lansia", "Faktor Risiko", "Keperawatan Gerontik"],
        references: 2,
        doi: "10.9012/jgk.v7i2.004"
    },
    {
        id: 5,
        title: "Penerapan Evidence-Based Nursing dalam Penanganan Nyeri Post Operasi",
        authors: "Simamora, H., & Panjaitan, R.",
        journal: "Jurnal Praktik Keperawatan",
        volume: "11(4)",
        year: 2024,
        category: "keperawatan",
        abstract: "Penanganan nyeri post operasi yang efektif sangat penting untuk kesembuhan pasien. Penelitian ini menerapkan pendekatan evidence-based nursing dalam manajemen nyeri. Studi quasi-eksperimen pada 80 pasien post operasi. Kelompok intervensi mendapatkan terapi non-farmakologis (teknik relaksasi dan distraksi) ditambah analgesik.",
        keywords: ["Evidence-Based Nursing", "Nyeri Post Operasi", "Manajemen Nyeri", "Keperawatan Perioperatif"],
        references: 2,
        doi: "10.3456/jpk.v11i4.005"
    },
    {
        id: 6,
        title: "Determinan Kepuasan Pasien Terhadap Pelayanan Keperawatan di Rawat Inap",
        authors: "Marbun, W., Siregar, A., & Sinaga, L.",
        journal: "Jurnal Manajemen Keperawatan",
        volume: "10(1)",
        year: 2023,
        category: "penelitian",
        abstract: "Kepuasan pasien merupakan indikator mutu pelayanan kesehatan. Penelitian ini menganalisis determinan kepuasan pasien terhadap pelayanan keperawatan. Survey cross-sectional pada 150 pasien rawat inap. Hasil menunjukkan responsivitas perawat (β=0.342), komunikasi terapeutik (β=0.298), dan empati (β=0.256) merupakan determinan utama kepuasan pasien.",
        keywords: ["Kepuasan Pasien", "Pelayanan Keperawatan", "Mutu Pelayanan", "Rawat Inap"],
        references: 2,
        doi: "10.6789/jmk.v10i1.006"
    }
];

// Render journals
let currentPage = 1;
const itemsPerPage = 4;
let currentFilter = 'all';
let searchQuery = '';

function renderJournals() {
    let filteredData = [...journalData];
    
    // Filter by search
    if (searchQuery) {
        filteredData = filteredData.filter(item => 
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.authors.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.keywords.some(k => k.toLowerCase().includes(searchQuery.toLowerCase()))
        );
    }
    
    // Filter by category
    if (currentFilter !== 'all') {
        filteredData = filteredData.filter(item => 
            item.category === currentFilter || item.year.toString() === currentFilter
        );
    }
    
    // Pagination
    const totalItems = filteredData.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentData = filteredData.slice(startIndex, endIndex);
    
    // Update pagination info
    document.getElementById('paginationInfo').innerHTML = 
        `Menampilkan ${startIndex + 1} - ${Math.min(endIndex, totalItems)} dari ${totalItems} jurnal`;
    
    // Generate journal cards
    const grid = document.getElementById('journalGrid');
    grid.innerHTML = '';
    
    currentData.forEach(journal => {
        const card = document.createElement('div');
        card.className = 'journal-card fade-up';
        card.innerHTML = `
            <div class="journal-header">
                <div class="journal-title">${journal.title}</div>
                <div class="journal-meta">
                    <span>👨‍⚕️ ${journal.authors}</span>
                    <span>📄 ${journal.journal}</span>
                    <span>📅 ${journal.year}</span>
                    <span>🔢 Vol. ${journal.volume}</span>
                </div>
            </div>
            <div class="journal-body">
                <div class="journal-abstract">
                    <span class="text-indigo-300 font-semibold text-xs">📝 ABSTRAK:</span> ${journal.abstract.substring(0, 180)}...
                </div>
                <div class="journal-keywords">
                    ${journal.keywords.map(kw => `<span class="keyword-tag">#${kw}</span>`).join('')}
                </div>
                <div class="journal-ref">
                    <span class="text-indigo-300">📚 REFERENSI:</span> ${journal.references} sumber • DOI: ${journal.doi}
                </div>
                <div class="flex gap-3 mt-4">
                    <button class="btn-outline text-xs py-1 px-3" onclick="viewJournal(${journal.id})">
                        📖 Baca Selengkapnya
                    </button>
                    <button class="btn-outline text-xs py-1 px-3" onclick="downloadJournal(${journal.id})">
                        📥 Download PDF
                    </button>
                </div>
            </div>
        `;
        grid.appendChild(card);
    });
    
    // Add fade-up class after small delay
    setTimeout(() => {
        document.querySelectorAll('.journal-card').forEach(el => {
            el.classList.add('show');
        });
    }, 50);
    
    // Update pagination buttons
    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');
    if (prevBtn) prevBtn.disabled = currentPage === 1;
    if (nextBtn) nextBtn.disabled = currentPage === totalPages || totalPages === 0;
}

// View journal detail
function viewJournal(id) {
    const journal = journalData.find(j => j.id === id);
    if (journal) {
        showNotification(`📖 Membuka: ${journal.title.substring(0, 50)}...`, 'info');
    }
}

// Download journal
function downloadJournal(id) {
    const journal = journalData.find(j => j.id === id);
    if (journal) {
        showNotification(`📥 Mengunduh: ${journal.title.substring(0, 50)}...`, 'success');
    }
}

// Notification system
function showNotification(message, type = 'success') {
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

// Filter event listeners
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const filter = e.target.getAttribute('data-filter');
        currentFilter = filter;
        currentPage = 1;
        
        // Update button styles
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active');
        });
        e.target.classList.add('active');
        
        renderJournals();
    });
});

// Search event
document.getElementById('searchInput').addEventListener('input', (e) => {
    searchQuery = e.target.value;
    currentPage = 1;
    renderJournals();
});

// Pagination
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

// Submit journal button
document.getElementById('submitJournalBtn').addEventListener('click', () => {
    showNotification('✍️ Form submission jurnal akan segera terbuka. Silakan lengkapi data artikel Anda.', 'info');
});

// Initialize
renderJournals();

// Stagger animation for journal cards
const style = document.createElement('style');
style.textContent = `
    .journal-card {
        transition-delay: var(--delay, 0s);
    }
`;
document.head.appendChild(style);

document.querySelectorAll('.journal-card').forEach((card, idx) => {
    card.style.setProperty('--delay', `${idx * 0.05}s`);
});

console.log('Halaman Jurnal Ilmiah siap dengan 6 data jurnal dan fitur filter!');
</script>
@endpush