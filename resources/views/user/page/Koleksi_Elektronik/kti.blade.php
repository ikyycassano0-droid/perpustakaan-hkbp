@extends('user.component.master')

@section('title', 'Karya Tulis Ilmiah - AKPER HKBP Balige')

@push('styles')
<style>
    .glass-card {
        background: rgba(30, 41, 59, 0.5);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(99, 102, 241, 0.25);
    }

    /* Glow text */
    .glow-text {
        text-shadow: 0 0 12px rgba(99, 102, 241, 0.7);
    }

    /* Tambahkan di style Visi Misi */
    .depth-2 { transform: translateZ(24px); }

    .kti-card {
        background: rgba(15, 23, 42, 0.8);
        border-radius: 1rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .kti-card:hover {
        transform: translateY(-3px);
        border-color: #6366f1;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 500;
    }

    .status-approved {
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .sidebar-menu {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        overflow: hidden;
    }

    .sidebar-item {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        cursor: pointer;
        color: #cbd5e1;
        font-size: 0.85rem;
    }

    .sidebar-item:hover {
        background: rgba(99, 102, 241, 0.15);
        color: white;
        padding-left: 24px;
    }

    .sidebar-item.active {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        color: #a5b4fc;
        border-left: 3px solid #6366f1;
    }

    .sidebar-title {
        font-weight: 700;
        color: #c7d2fe;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }

    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 2rem;
    }

    .btn-upload {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 10px 20px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.85rem;
    }

    .btn-upload:hover {
        transform: scale(1.02);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }

    .search-input {
        width: 100%;
        padding: 10px 16px;
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

    .neon-border {
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
        padding: 2px;
    }

    .neon-inner {
        background: rgba(15, 23, 42, 0.7);
        border-radius: 26px;
        padding: 2rem;
        border: 1px solid rgba(255,255,255,0.08);
    }

    .fade-up {
        opacity: 0;
        transform: translateY(40px);
        transition: 0.9s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .fade-up.show {
        opacity: 1;
        transform: translateY(0);
    }

    .section {
        margin-top: 40px;
    }
</style>
@endpush

@section('content')
<div class="main-content">

    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📚 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight depth-2 fade-up">
    Karya Tulis Ilmiah <br>
    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-300 bg-clip-text text-transparent glow-text">Mahasiswa</span>
</h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Akses digital koleksi tugas akhir, skripsi, dan penelitian keperawatan.
        </p>
    </section>

    <section class="section max-w-7xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    <!-- SIDEBAR MENU -->
                    <div class="lg:col-span-1">
                        <div class="sidebar-menu">
                            <div class="sidebar-title">📂 Menu KTI</div>
                            <div class="sidebar-item active" data-menu="all">
                                🌐 Semua KTI (Disetujui)
                            </div>

                            <div class="sidebar-title mt-2">📁 KTI Saya</div>

                            <div class="sidebar-item" data-menu="my-approved">
                                ✅ Disetujui
                            </div>

                            <div class="sidebar-item" data-menu="my-pending">
                                ⏳ Menunggu Persetujuan
                            </div>

                            <div class="sidebar-item" data-menu="my-rejected">
                                ❌ Ditolak
                            </div>
                        </div>
                    </div>

                    <!-- MAIN CONTENT AREA -->
                    <div class="lg:col-span-3">

                        <!-- SEARCH -->
                        <div class="mb-6">
                            <input type="text" id="searchInput" class="search-input"
                                   placeholder="🔍 Cari judul KTI...">
                        </div>

                        <!-- KTI LIST -->
                        <div id="ktiList" class="min-h-[300px]">
                            <div class="text-center py-12">
                                <div class="text-5xl mb-3">⏳</div>
                                <p class="text-gray-400">Memuat data...</p>
                            </div>
                        </div>

                        <!-- PAGINATION -->
                        <div id="paginationButtons" class="flex justify-center gap-2 mt-6"></div>

                        <!-- TOMBOL UPLOAD -->
                        <div class="text-center mt-8">
                            <a href="{{ route('final_project.upload.kti') }}" class="btn-upload inline-flex items-center gap-2">
                                <span>📤</span> Upload KTI Baru
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Data dari server
    var allApprovedKtis = @json($allApprovedKtis ?? []);  // Semua KTI yang sudah approved dari semua user
    var myKtis = @json($myKtis ?? []);                    // KTI milik user yang login
    var currentUserId = {{ auth()->id() ?? 0 }};

    var currentMenu = 'all';     // Menu aktif: 'all', 'my-approved', 'my-pending', 'my-rejected'
    var currentPage = 1;
    var itemsPerPage = 5;
    var searchQuery = '';

    console.log('All Approved KTIs:', allApprovedKtis.length);
    console.log('My KTIs:', myKtis.length);

    function getStatusBadge(status) {
        if (status === 'Approved') {
            return '<span class="status-badge status-approved">✅ Disetujui</span>';
        } else if (status === 'Pending') {
            return '<span class="status-badge status-pending">⏳ Menunggu Persetujuan</span>';
        } else if (status === 'Rejected') {
            return '<span class="status-badge status-rejected">❌ Ditolak</span>';
        }
        return '';
    }

    function getFilteredData() {
        var filtered = [];

        if (currentMenu === 'all') {
            // Menampilkan SEMUA KTI yang sudah APPROVED dari semua user
            filtered = [...allApprovedKtis];
        } else if (currentMenu === 'my-approved') {
            // Menampilkan KTI user yang statusnya Approved
            filtered = myKtis.filter(function(item) {
                return item.status === 'Approved';
            });
        } else if (currentMenu === 'my-pending') {
            // Menampilkan KTI user yang statusnya Pending
            filtered = myKtis.filter(function(item) {
                return item.status === 'Pending';
            });
        } else if (currentMenu === 'my-rejected') {
            // Menampilkan KTI user yang statusnya Rejected
            filtered = myKtis.filter(function(item) {
                return item.status === 'Rejected';
            });
        }

        // Filter search
        if (searchQuery) {
            filtered = filtered.filter(function(item) {
                return (item.title && item.title.toLowerCase().includes(searchQuery.toLowerCase())) ||
                       (item.abstract && item.abstract.toLowerCase().includes(searchQuery.toLowerCase())) ||
                       (item.student_name && item.student_name.toLowerCase().includes(searchQuery.toLowerCase()));
            });
        }

        return filtered;
    }

    function renderKTI() {
        var container = document.getElementById('ktiList');
        if (!container) return;

        var filteredData = getFilteredData();
        var totalItems = filteredData.length;
        var totalPages = Math.ceil(totalItems / itemsPerPage);
        var startIndex = (currentPage - 1) * itemsPerPage;
        var currentData = filteredData.slice(startIndex, startIndex + itemsPerPage);

        container.innerHTML = '';

        if (currentData.length === 0) {
            var emptyMessage = '';
            if (currentMenu === 'all') emptyMessage = 'Belum ada KTI yang disetujui';
            else if (currentMenu === 'my-approved') emptyMessage = 'Belum ada KTI Anda yang disetujui';
            else if (currentMenu === 'my-pending') emptyMessage = 'Tidak ada KTI yang menunggu persetujuan';
            else if (currentMenu === 'my-rejected') emptyMessage = 'Tidak ada KTI yang ditolak';
            else emptyMessage = 'Tidak ada data';

            container.innerHTML = '<div class="text-center py-12"><div class="text-5xl mb-3">📭</div><p class="text-gray-400">' + emptyMessage + '</p></div>';
            return;
        }

        for (var i = 0; i < currentData.length; i++) {
            var kti = currentData[i];
            var card = document.createElement('div');
            card.className = 'kti-card p-5';

            var downloadUrl = "{{ url('storage') }}/" + (kti.file_url || '');
            var createdDate = kti.created_at ? new Date(kti.created_at).toLocaleDateString('id-ID') : '-';
            var abstractText = (kti.abstract && kti.abstract.length > 150) ? kti.abstract.substring(0, 150) + '...' : (kti.abstract || 'Tidak ada abstrak');

            // Tampilkan nama penulis untuk menu "Semua KTI"
            var authorInfo = '';
            if (currentMenu === 'all') {
                authorInfo = '<p class="text-xs text-indigo-300 mt-1">👤 Penulis: ' + escapeHtml(kti.student_name || '-') + ' | NPM: ' + escapeHtml(kti.npm || '-') + '</p>';
            }

            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs text-indigo-300">KTI #${kti.id}</span>
                        ${getStatusBadge(kti.status)}
                    </div>
                    <span class="text-xs text-gray-500">📅 ${createdDate}</span>
                </div>

                <h3 class="font-bold text-white text-lg mb-2">${escapeHtml(kti.title || 'Tanpa Judul')}</h3>

                <p class="text-gray-400 text-sm mb-3">${escapeHtml(abstractText)}</p>

                ${authorInfo}

                <div class="flex justify-between items-center mt-3 pt-3 border-t border-white/10">
                    <div>
                        <p class="text-sm text-gray-300">✍️ ${escapeHtml(kti.student_name || '-')}</p>
                        <p class="text-xs text-gray-500">NPM: ${escapeHtml(kti.npm || '-')} | ${escapeHtml(kti.study_program || '-')}</p>
                        <p class="text-xs text-gray-500">👨‍🏫 Pembimbing: ${escapeHtml(kti.first_supervisor ? kti.first_supervisor.name : '-')}${kti.second_supervisor ? ' & ' + escapeHtml(kti.second_supervisor.name) : ''}</p>
                    </div>
                    ${kti.file_url && kti.status === 'Approved' ? `<a href="${downloadUrl}" target="_blank" class="text-indigo-400 hover:text-indigo-300 text-sm">📥 Download</a>` : ''}
                </div>
            `;
            container.appendChild(card);
        }

        // Render pagination
        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        var paginationContainer = document.getElementById('paginationButtons');
        if (!paginationContainer) return;

        if (totalPages <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }

        var html = '<div class="flex gap-2">';
        html += '<button class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600 cursor-pointer" onclick="changePage(' + (currentPage - 1) + ')">◀</button>';

        for (var i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                html += '<button class="px-3 py-1 rounded bg-indigo-600">' + i + '</button>';
            } else {
                html += '<button class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600 cursor-pointer" onclick="changePage(' + i + ')">' + i + '</button>';
            }
        }

        html += '<button class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600 cursor-pointer" onclick="changePage(' + (currentPage + 1) + ')">▶</button>';
        html += '</div>';
        paginationContainer.innerHTML = html;
    }

    window.changePage = function(page) {
        var filtered = getFilteredData();
        var totalPages = Math.ceil(filtered.length / itemsPerPage);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            renderKTI();
            window.scrollTo({ top: 400, behavior: 'smooth' });
        }
    };

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // ================= MENU CLICK =================
    var menuItems = document.querySelectorAll('.sidebar-item');
    for (var i = 0; i < menuItems.length; i++) {
        menuItems[i].addEventListener('click', function() {
            var menu = this.dataset.menu;
            if (menu) {
                currentMenu = menu;
                currentPage = 1;

                var allItems = document.querySelectorAll('.sidebar-item');
                for (var j = 0; j < allItems.length; j++) {
                    allItems[j].classList.remove('active');
                }
                this.classList.add('active');

                renderKTI();
            }
        });
    }

    // ================= SEARCH =================
    var searchInputElem = document.getElementById('searchInput');
    if (searchInputElem) {
        searchInputElem.addEventListener('input', function(e) {
            searchQuery = e.target.value;
            currentPage = 1;
            renderKTI();
        });
    }

    // ================= INIT =================
    renderKTI();

    // Fade up animation
    var fadeElements = document.querySelectorAll('.fade-up');
    for (var i = 0; i < fadeElements.length; i++) {
        setTimeout(function(el) {
            return function() { el.classList.add('show'); };
        }(fadeElements[i]), 100);
    }
});
</script>
@endpush
