@extends('guest.component.master')

@section('title', 'Detail Berita - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN DETAIL BERITA
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

    .category-akademik { background: rgba(99, 102, 241, 0.2); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.4); }
    .category-pengumuman { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); }
    .category-kegiatan { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); }
    .category-riset { background: rgba(139, 92, 246, 0.2); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.4); }
    .category-fasilitas { background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.4); }
    .category-sosial { background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); }

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
        border-radius: 30px;
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

    /* Share Button */
    .share-btn {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 40px;
        padding: 8px 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.75rem;
        color: #c7d2fe;
    }

    .share-btn:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
    }

    /* Related News Card */
    .related-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
    }

    .related-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }

    .related-img {
        height: 140px;
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

    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Prose styling untuk artikel */
    .prose {
        max-width: 100%;
    }

    .prose h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #c7d2fe;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .prose p {
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .prose ul {
        color: #cbd5e1;
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }

    .prose li {
        margin-bottom: 0.25rem;
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
                📰 AKPER HKBP BALIGE
            </span>
        </div>

        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight title-main fade-up">
            {{ $news->title }}
        </h1>

        <div class="flex flex-wrap items-center justify-center gap-4 mt-4 fade-up">
            <span class="category-badge {{ 'category-'.$news->category }}">
                {{ strtoupper($news->category) }}
            </span>

            <span class="text-gray-400 text-sm">
                📅 {{ $news->created_at->format('d M Y') }}
            </span>

            <span class="text-gray-400 text-sm">
                👤 {{ $news->author ?? 'Admin' }}
            </span>

            <span class="text-gray-400 text-sm">
                👁️ {{ $news->views ?? 0 }} dibaca
            </span>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="section max-w-4xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <!-- IMAGE -->
                <div class="mb-8 rounded-2xl overflow-hidden">
                    <img src="{{ asset('storage/'.$news->image) }}"
                         alt="{{ $news->title }}"
                         class="w-full h-auto object-cover">
                </div>

                <!-- SHARE -->
                <div class="flex flex-wrap justify-between items-center mb-8 pb-4 border-b border-white/10">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-sm text-gray-400">Bagikan:</span>
                        <button onclick="shareArticle('facebook')" class="share-btn">Facebook</button>
                        <button onclick="shareArticle('twitter')" class="share-btn">Twitter</button>
                        <button onclick="shareArticle('whatsapp')" class="share-btn">WhatsApp</button>
                        <button onclick="copyLink()" class="share-btn">Copy Link</button>
                    </div>
                </div>

                <!-- ISI ARTIKEL -->
                <div class="prose max-w-none">
                    {!! $news->content !!}
                </div>

                <!-- TAGS -->
                @if($news->tags)
                <div class="mt-8 pt-4 border-t border-white/10">
                    <div class="flex flex-wrap gap-2">
                        <span class="text-sm text-gray-400">Tags:</span>

                        @foreach(explode(',', $news->tags) as $tag)
                            <span class="category-badge category-akademik">
                                #{{ trim($tag) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>

    <!-- RELATED -->
    <section class="section max-w-6xl mx-auto px-5 mb-16">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 glass-card px-4 py-2 rounded-full mb-3">
                <span class="text-indigo-400 text-sm">📰</span>
                <span class="text-indigo-300 text-sm font-medium">Berita Terkait</span>
            </div>

            <h2 class="text-2xl md:text-3xl font-bold text-white">
                Berita Lainnya
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related as $item)
            <div class="related-card">
                <img src="{{ asset('storage/'.$item->image) }}" class="related-img">

                <div class="p-4">
                    <span class="category-badge {{ 'category-'.$item->category }}">
                        {{ strtoupper($item->category) }}
                    </span>

                    <h3 class="font-semibold text-indigo-200 mt-2 text-sm line-clamp-2">
                        {{ $item->title }}
                    </h3>

                    <a href="{{ route('guest.berita.show', $item->id) }}"
                       class="btn-outline text-xs py-1 px-3 mt-3 inline-block">
                        Baca →
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- BACK -->
        <div class="text-center mt-10">
            <a href="{{ route('guest.berita.index') }}" class="btn-outline px-8 py-3">
                ← Kembali ke Daftar Berita
            </a>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
// ============================================
// JAVASCRIPT KHUSUS UNTUK HALAMAN DETAIL BERITA
// Hanya JS yang BELUM ADA di master blade
// ============================================

// DATA BERITA
const currentNews = {
    id: 1,
    title: "Implementasi Kurikulum Berbasis Simulasi Klinis Terpadu",
    category: "akademik",
    categoryName: "AKADEMIK",
    date: "12 Oktober 2024",
    image: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&h=450&fit=crop",
    author: "Tim Redaksi AKPER HKBP",
    views: 1245
};

const relatedNewsData = [
    {
        id: 2,
        title: "Prestasi Dosen: Publikasi Jurnal Internasional Terindeks Scopus",
        category: "riset",
        categoryName: "RISET",
        date: "01 Oktober 2024",
        image: "https://images.unsplash.com/photo-1532619187608-e5375cab36aa?w=400&h=200&fit=crop",
        excerpt: "Tim peneliti Akper HKBP Balige berhasil mempublikasikan temuan mengenai efektivitas perawatan luka diabetik modern..."
    },
    {
        id: 3,
        title: "Peresmian Laboratorium Keperawatan Medikal Bedah",
        category: "fasilitas",
        categoryName: "FASILITAS",
        date: "28 September 2024",
        image: "https://images.unsplash.com/photo-1516549655169-df83a0774514?w=400&h=200&fit=crop",
        excerpt: "Fasilitas penunjang praktik klinik dilengkapi dengan alat batu pernapasan terbaru dan sistem monitoring pasien digital..."
    },
    {
        id: 4,
        title: "Seminar Internasional Keperawatan Komunitas di Era Digital",
        category: "kegiatan",
        categoryName: "KEGIATAN",
        date: "05 Oktober 2024",
        image: "https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=400&h=200&fit=crop",
        excerpt: "Mengundang pakar dari mancanegara untuk membahas peran teknologi dalam meningkatkan efektivitas layanan kesehatan..."
    }
];

function getCategoryClass(category) {
    const classes = {
        'akademik': 'category-akademik',
        'pengumuman': 'category-pengumuman',
        'kegiatan': 'category-kegiatan',
        'riset': 'category-riset',
        'fasilitas': 'category-fasilitas',
        'sosial': 'category-sosial'
    };
    return classes[category] || 'category-akademik';
}

function renderNewsDetail() {
    // Set title
    document.getElementById('newsTitle').innerHTML = currentNews.title;

    // Set meta info
    const metaContainer = document.getElementById('newsMeta');
    metaContainer.innerHTML = `
        <span class="category-badge ${getCategoryClass(currentNews.category)}">${currentNews.categoryName}</span>
        <span class="text-gray-400 text-sm flex items-center gap-1">📅 ${currentNews.date}</span>
        <span class="text-gray-400 text-sm flex items-center gap-1">👤 ${currentNews.author}</span>
        <span class="text-gray-400 text-sm flex items-center gap-1">👁️ ${currentNews.views} dibaca</span>
    `;

    // Set featured image
    const imgContainer = document.getElementById('featuredImage');
    imgContainer.innerHTML = `
        <img src="${currentNews.image}" alt="${currentNews.title}" class="w-full h-auto object-cover transition-transform duration-500 hover:scale-105">
    `;
}

function renderRelatedNews() {
    const container = document.getElementById('relatedNews');
    container.innerHTML = '';

    relatedNewsData.forEach(news => {
        const card = document.createElement('div');
        card.className = 'related-card fade-up';
        card.innerHTML = `
            <img src="${news.image}" alt="${news.title}" class="related-img">
            <div class="p-4">
                <div class="flex items-center gap-2 mb-2 flex-wrap">
                    <span class="category-badge ${getCategoryClass(news.category)}">${news.categoryName}</span>
                    <span class="text-xs text-gray-500">📅 ${news.date}</span>
                </div>
                <h3 class="font-semibold text-indigo-200 mb-2 text-sm line-clamp-2">${news.title}</h3>
                <p class="text-gray-400 text-xs mb-3 line-clamp-2">${news.excerpt}</p>
                <button class="btn-outline text-xs py-1 px-3" onclick="readNews(${news.id})">
                    Baca Selengkapnya →
                </button>
            </div>
        `;
        container.appendChild(card);
    });

    // Add fade-up class
    setTimeout(() => {
        document.querySelectorAll('.related-card').forEach(el => {
            el.classList.add('show');
        });
    }, 50);
}

function readNews(id) {
    showNotification(`📖 Membuka berita dengan ID: ${id}`, 'info');
}

function shareArticle(platform) {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(currentNews.title);

    let shareUrl = '';
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?text=${title}&url=${url}`;
            break;
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${title}%20${url}`;
            break;
    }

    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
        showNotification(`📤 Membagikan artikel ke ${platform}`, 'success');
    }
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href);
    showNotification('🔗 Link berita telah disalin ke clipboard!', 'success');
}

function saveArticle() {
    showNotification('📌 Artikel telah disimpan ke bookmark Anda.', 'success');
}

function printArticle() {
    window.print();
    showNotification('🖨️ Halaman cetak sedang disiapkan...', 'info');
}

function goBack() {
    window.history.back();
}

// Custom notification (override jika perlu, tapi akan menggunakan showNotif dari master)
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

// Initialize
renderNewsDetail();
renderRelatedNews();

// Make functions global
window.readNews = readNews;
window.shareArticle = shareArticle;
window.copyLink = copyLink;
window.saveArticle = saveArticle;
window.printArticle = printArticle;
window.goBack = goBack;

console.log('Halaman Detail Berita siap!');
</script>
@endpush




