@extends('user.component.master')

@section('title', 'Detail Buku Pengayaan - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN DETAIL BUKU PENGAYAAN
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */
    
    /* Glass card */
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
    
    /* Category Badge */
    .category-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .category-pengayaan { background: rgba(99, 102, 241, 0.2); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.4); }
    .category-referensi { background: rgba(139, 92, 246, 0.2); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.4); }
    .category-anatomi { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); }
    .category-keperawatan { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 12px 28px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.9rem;
    }
    
    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 25px rgba(99, 102, 241, 0.5);
    }
    
    .btn-outline {
        background: transparent;
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.5);
        cursor: pointer;
        color: #c7d2fe;
        font-size: 0.85rem;
    }
    
    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
        transform: translateY(-2px);
    }
    
    .btn-link {
        background: transparent;
        border: none;
        color: #a5b4fc;
        cursor: pointer;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .btn-link:hover {
        color: #818cf8;
    }
    
    /* Book Detail Styles */
    .book-cover-large {
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 25px 40px -15px rgba(0, 0, 0, 0.4);
    }
    
    .metadata-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .metadata-item {
        background: rgba(15, 23, 42, 0.6);
        border-radius: 1rem;
        padding: 1rem;
        border: 1px solid rgba(99, 102, 241, 0.2);
    }
    
    .metadata-label {
        font-size: 0.7rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .metadata-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #c7d2fe;
        margin-top: 0.25rem;
    }
    
    .chapter-list {
        list-style: none;
        padding: 0;
    }
    
    .chapter-list li {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .chapter-list li:hover {
        padding-left: 0.5rem;
        color: #a5b4fc;
    }
    
    .chapter-number {
        width: 28px;
        height: 28px;
        background: rgba(99, 102, 241, 0.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 600;
        color: #a5b4fc;
    }
    
    /* Recommendation Card */
    .recommend-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .recommend-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }
    
    .recommend-img {
        height: 160px;
        width: 100%;
        object-fit: cover;
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
    
    /* Rating bar */
    .rating-bar {
        height: 8px;
        background: #334155;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .rating-fill {
        height: 100%;
        border-radius: 4px;
    }
    
    /* Delay utilities */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                📚 {{ strtoupper($collection->menu_type ?? 'KOLEKSI') }}
            </span>
        </div>

        <h1 class="text-3xl md:text-5xl font-extrabold title-main fade-up">
            {{ $collection->title }}
        </h1>

        <div class="flex flex-wrap justify-center gap-3 mt-4 text-gray-400 text-sm fade-up">
            <span>✍️ 
                {{ is_array($collection->author) ? implode(', ', $collection->author) : $collection->author }}
            </span>

            <span>📅 {{ $collection->publication_year ?? '-' }}</span>

            <span>📄 {{ $collection->edition ?? '-' }}</span>
        </div>
    </section>

    <!-- MAIN -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- COVER -->
                    <div class="flex flex-col">

                    <!-- COVER -->
                        <div class="book-cover-large">
                            <img src="{{ $collection->cover_image ? asset('storage/'.$collection->cover_image) : 'https://via.placeholder.com/400x500' }}"
                                class="w-full">
                        </div>

                        <!-- BUTTON (FIX DI BAWAH COVER) -->
                        <div class="mt-4 flex flex-col gap-3">

                            <button onclick="borrowBook()" class="btn-primary w-full">
                                📖 Pinjam Buku
                            </button>

                            @if($collection->file_url)
                                <a href="{{ asset('storage/'.$collection->file_url) }}"
                                target="_blank"
                                class="btn-outline w-full text-center block">
                                    👁️ Lihat PDF
                                </a>
                            @endif

                        </div>

                            <!-- STATUS -->
                            <div class="glass-card p-4 mt-6 text-center">
                                <span class="text-green-400 font-semibold">
                                    {{ $collection->is_available ? 'Tersedia' : 'Tidak tersedia' }}
                                </span>

                                <p class="text-xs text-gray-400 mt-2">
                                    Stok: {{ $collection->available_stock }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    📍 {{ $collection->location->name ?? '-' }}
                                </p>
                            </div>

                    </div>

                    <!-- DETAIL -->
                    <div class="lg:col-span-2">

                        <!-- DESKRIPSI -->
                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-indigo-200 mb-3">
                                📖 Deskripsi
                            </h2>

                            <p class="text-gray-300">
                                {{ $collection->description ?? '-' }}
                            </p>
                        </div>

                        <!-- METADATA -->
                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-indigo-200 mb-3">
                                📋 Informasi
                            </h2>

                            <div class="metadata-grid">

                                <div class="metadata-item">
                                    <div class="metadata-label">Penulis</div>
                                    <div class="metadata-value">
                                        {{ is_array($collection->author) ? implode(', ', $collection->author) : $collection->author }}
                                    </div>
                                </div>

                                <div class="metadata-item">
                                    <div class="metadata-label">Penerbit</div>
                                    <div class="metadata-value">{{ $collection->publisher ?? '-' }}</div>
                                </div>

                                <div class="metadata-item">
                                    <div class="metadata-label">Tahun</div>
                                    <div class="metadata-value">{{ $collection->publication_year ?? '-' }}</div>
                                </div>

                                <div class="metadata-item">
                                    <div class="metadata-label">ISBN</div>
                                    <div class="metadata-value">{{ $collection->isbn ?? '-' }}</div>
                                </div>

                                <div class="metadata-item">
                                    <div class="metadata-label">Bahasa</div>
                                    <div class="metadata-value">{{ $collection->language ?? '-' }}</div>
                                </div>

                                <div class="metadata-item">
                                    <div class="metadata-label">Kategori</div>
                                    <div class="metadata-value">
                                        {{ $collection->categories->pluck('name')->implode(', ') }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- KEYWORDS -->
                        @if($collection->keywords)
                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-indigo-200 mb-3">
                                🏷️ Keywords
                            </h2>

                            <div class="flex flex-wrap gap-2">
                                @foreach($collection->keywords as $key)
                                    <span class="keyword-tag">{{ $key }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- BACK -->
    <div class="text-center mt-10 mb-20">
        <a href="{{ url()->previous() }}" class="btn-outline px-6 py-3">
            ← Kembali
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN DETAIL BUKU PENGAYAAN
// Hanya JS yang BELUM ADA di master blade
// ============================================

// Book data
const currentBook = {
    id: 1,
    title: "Fundamentals of Nursing: The Art and Science of Person-Centered Care",
    author: "Carol R. Taylor, Pamela Lynn",
    edition: "Edisi 9",
    year: 2023,
    isbn: "978-1-9751-6815-1",
    pages: 1856,
    category: "Nursing Fundamentals",
    location: "Rak A-12",
    status: "tersedia",
    stock: 3,
    rating: 4.8
};

function borrowBook() {
    showNotification('✅ Buku berhasil dipinjam! Silakan ambil di Rak A-12.', 'success');
}

function previewBook() {
    showNotification('👁️ Preview sampel buku akan segera terbuka...', 'info');
}

function addToWishlist() {
    showNotification('🤍 Buku ditambahkan ke wishlist Anda.', 'success');
}

function goToChapter(chapter) {
    showNotification(`📑 Membuka bab ${chapter}...`, 'info');
}

function viewAllChapters() {
    showNotification('📚 Menampilkan semua 54 bab buku ini.', 'info');
}

function viewBook(id) {
    showNotification(`📖 Membuka detail buku...`, 'info');
}

function goBack() {
    window.history.back();
}

// Custom notification (akan menggunakan showNotif dari master jika ada)
function showNotification(message, type = 'success') {
    if (typeof showNotif === 'function') {
        showNotif(message, type);
    } else {
        // Fallback notification
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
}

// Stagger animation untuk recommendation cards
const recCards = document.querySelectorAll('.recommend-card');
recCards.forEach((card, idx) => {
    card.style.transitionDelay = `${idx * 0.1}s`;
});

// Stagger animation untuk metadata items
const metadataItems = document.querySelectorAll('.metadata-item');
metadataItems.forEach((item, idx) => {
    item.style.transitionDelay = `${idx * 0.05}s`;
});

// Make functions global
window.borrowBook = borrowBook;
window.previewBook = previewBook;
window.addToWishlist = addToWishlist;
window.goToChapter = goToChapter;
window.viewAllChapters = viewAllChapters;
window.viewBook = viewBook;
window.goBack = goBack;

console.log('Halaman Detail Buku Pengayaan siap!');
</script>
@endpush