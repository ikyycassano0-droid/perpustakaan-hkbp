@extends('user.component.master')

@section('title', 'Koleksi E-Book - AKPER HKBP Balige')

@push('styles')
<style>
    .glass-card {
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 2rem;
        transition: all 0.3s ease;
    }

    .title-main {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #a5b4fc, #6366f1);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
    }

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

    .stat-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.6);
        box-shadow: 0 10px 25px -10px rgba(99, 102, 241, 0.3);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 0.5rem;
    }

    .ebook-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
    }

    .ebook-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }

    .ebook-cover {
        height: 220px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .ebook-format {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.7);
        padding: 4px 8px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.75rem;
    }

    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
    }

    .btn-outline {
        background: transparent;
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.75rem;
    }

    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .pagination .page-item {
        list-style: none;
    }
    
    .pagination .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 14px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 8px;
        color: #c7d2fe;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.85rem;
    }
    
    .pagination .page-link:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }
    
    .pagination .active .page-link {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: white;
    }
    
    .pagination .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }

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

    .section {
        margin-top: 40px;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .stat-number {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">

    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">📱 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Koleksi E-Book
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Akses ribuan buku digital, jurnal elektronik, dan literatur keperawatan modern. Baca kapan saja, di mana saja.
        </p>
    </section>

    <section class="section max-w-6xl mx-auto px-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-card fade-up">
                <div class="text-3xl mb-2">📚</div>
                <div class="stat-number" id="totalEbook">{{ $ebooks->total() ?? 0 }}</div>
                <div class="stat-label">Total E-Book</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-3xl mb-2">📖</div>
                <div class="stat-number">856</div>
                <div class="stat-label">Akses Bulanan</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-3xl mb-2">⭐</div>
                <div class="stat-number">4.8</div>
                <div class="stat-label">Rating Rata-rata</div>
            </div>
            <div class="stat-card fade-up">
                <div class="text-3xl mb-2">🆓</div>
                <div class="stat-number">100%</div>
                <div class="stat-label">Gratis Akses</div>
            </div>
        </div>
    </section>

    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                
                <div class="mb-6">
                    <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari judul e-book, penulis, atau kata kunci...">
                </div>
                
                <h3 class="text-indigo-200 font-semibold mb-3">📚 Semua Koleksi E-Book</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="ebooksGrid">
                    <div class="col-span-3 text-center py-12">
                        <div class="text-5xl mb-3">⏳</div>
                        <p class="text-gray-400">Memuat data...</p>
                    </div>
                </div>
                
                <div class="mt-8" id="paginationContainer">
                    {{ $ebooks->links() }}
                </div>
                
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
// Data dari server
var ebooksData = @json($ebooks->items() ?? []);
var searchQuery = '';

// Escape HTML
function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Render E-Books Grid
function renderEbooks() {
    var filteredData = [];
    for (var i = 0; i < ebooksData.length; i++) {
        filteredData.push(ebooksData[i]);
    }
    
    // Filter by search
    if (searchQuery) {
        var temp = [];
        for (var i = 0; i < filteredData.length; i++) {
            var item = filteredData[i];
            var matchTitle = item.title && item.title.toLowerCase().includes(searchQuery.toLowerCase());
            var matchAuthor = item.author && item.author.toLowerCase().includes(searchQuery.toLowerCase());
            var matchDesc = item.description && item.description.toLowerCase().includes(searchQuery.toLowerCase());
            if (matchTitle || matchAuthor || matchDesc) {
                temp.push(item);
            }
        }
        filteredData = temp;
    }
    
    // Update total display
    var totalSpan = document.getElementById('totalEbook');
    if (totalSpan) totalSpan.innerHTML = filteredData.length;
    
    // Generate grid
    var grid = document.getElementById('ebooksGrid');
    if (!grid) return;
    grid.innerHTML = '';
    
    if (filteredData.length === 0) {
        grid.innerHTML = '<div class="col-span-3 text-center py-12"><div class="text-5xl mb-3">📭</div><p class="text-gray-400">Tidak ada e-book yang ditemukan</p></div>';
        return;
    }
    
    for (var i = 0; i < filteredData.length; i++) {
        var book = filteredData[i];
        var coverUrl = book.cover_image ? '/storage/' + book.cover_image : 'https://placehold.co/250x220/1e293b/6366f1?text=📖';
        var rating = book.rating || 4.5;
        var downloads = book.downloads || Math.floor(Math.random() * 1000) + 100;
        var year = book.publication_year || book.year || '2024';
        var pages = book.pages || Math.floor(Math.random() * 300) + 100;
        var format = book.format || 'PDF';
        var category = (book.category && book.category.name) ? book.category.name : (book.category_name || 'E-Book');
        var title = book.title || 'Judul tidak tersedia';
        var author = book.author || 'Penulis tidak diketahui';
        
        var card = document.createElement('div');
        card.className = 'ebook-card fade-up';
        card.innerHTML = '<div class="ebook-cover" style="background-image: url(\'' + coverUrl + '\'); background-size: cover; background-position: center;">' +
            '<span class="ebook-format">📕 ' + escapeHtml(format) + '</span>' +
            '</div>' +
            '<div class="p-4">' +
            '<div class="flex items-center justify-between mb-2 flex-wrap gap-1">' +
            '<span class="text-xs text-indigo-300">⭐ ' + rating + '</span>' +
            '<span class="text-xs text-gray-500">📥 ' + downloads + ' unduhan</span>' +
            '</div>' +
            '<div class="flex items-center justify-between mb-1">' +
            '<span class="text-xs text-indigo-300/70">' + escapeHtml(category) + '</span>' +
            '<span class="text-xs text-gray-500">📅 ' + year + '</span>' +
            '</div>' +
            '<h3 class="font-semibold text-indigo-200 mb-1 text-sm line-clamp-2">' + escapeHtml(title) + '</h3>' +
            '<p class="text-xs text-gray-400 mb-2">' + escapeHtml(author) + '</p>' +
            '<p class="text-xs text-gray-500 mb-3">📄 ' + pages + ' halaman</p>' +
            '<div class="flex items-center gap-2">' +
            '<button class="btn-primary flex-1 text-xs py-1" onclick="readEbook(' + book.id + ')">📖 Baca</button>' +
            '<button class="btn-outline text-xs py-1 px-2" onclick="downloadEbook(' + book.id + ')">⬇️</button>' +
            '</div>' +
            '</div>';
        grid.appendChild(card);
    }
    
    // Add fade-up class
    var cards = document.querySelectorAll('.ebook-card');
    for (var i = 0; i < cards.length; i++) {
        setTimeout(function(el) {
            return function() { el.classList.add('show'); };
        }(cards[i]), 50 * i);
    }
}

// Read Ebook
function readEbook(id) {
    var book = null;
    for (var i = 0; i < ebooksData.length; i++) {
        if (ebooksData[i].id === id) {
            book = ebooksData[i];
            break;
        }
    }
    if (book) {
        showNotification('📖 Membuka e-book: ' + escapeHtml(book.title), 'info');
    }
}

// Download Ebook
function downloadEbook(id) {
    var book = null;
    for (var i = 0; i < ebooksData.length; i++) {
        if (ebooksData[i].id === id) {
            book = ebooksData[i];
            break;
        }
    }
    if (book) {
        showNotification('⬇️ Mengunduh "' + escapeHtml(book.title) + '" dalam format ' + (book.format || 'PDF') + '...', 'success');
    }
}

// Notification
function showNotification(message, type) {
    if (typeof type === 'undefined') type = 'success';
    var notif = document.createElement('div');
    notif.className = 'notification';
    var icon = type === 'success' ? '✅' : (type === 'error' ? '❌' : 'ℹ️');
    notif.innerHTML = '<div class="flex items-center gap-2"><span>' + icon + '</span><span>' + message + '</span></div>';
    document.body.appendChild(notif);
    setTimeout(function() { notif.classList.add('show'); }, 10);
    setTimeout(function() {
        notif.classList.remove('show');
        setTimeout(function() { notif.remove(); }, 300);
    }, 3000);
}

// Search event
var searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', function(e) {
        searchQuery = e.target.value;
        renderEbooks();
    });
}

// Initialize - tambahkan fade-up untuk stat cards
var statCards = document.querySelectorAll('.stat-card');
for (var i = 0; i < statCards.length; i++) {
    setTimeout(function(el) {
        return function() { el.classList.add('show'); };
    }(statCards[i]), 100 * i);
}

// Render awal
renderEbooks();

// Make functions global
window.readEbook = readEbook;
window.downloadEbook = downloadEbook;

console.log('Halaman Koleksi E-Book siap dengan ' + ebooksData.length + ' data!');
</script>
@endpush