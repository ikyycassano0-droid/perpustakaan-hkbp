@extends('guest.component.master')

@section('title', 'Panduan & Informasi - AKPER HKBP Balige')

@push('styles')
<style>
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
    
    /* Filter button */
    .filter-btn {
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 0.85rem;
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
    
    /* Guide Card */
    .guide-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .guide-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.3);
    }
    
    .guide-icon {
        width: 50px;
        height: 50px;
        background: rgba(99, 102, 241, 0.15);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .guide-title {
        font-weight: 700;
        font-size: 1rem;
        color: #c7d2fe;
        margin-bottom: 0.25rem;
    }
    
    .guide-meta {
        font-size: 0.7rem;
        color: #94a3b8;
    }
    
    .btn-download {
        background: transparent;
        border: 1px solid rgba(99, 102, 241, 0.5);
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 500;
        color: #a5b4fc;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    
    .btn-download:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
        color: white;
    }
    
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
    
    /* Line clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
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
            Panduan & Informasi Akademik
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Akses berbagai dokumen panduan resmi, tata tertib, dan prosedur operasional standar Akademi Keperawatan HKBP Balige untuk mendukung kelancaran studi Anda.
        </p>
    </section>

    <!-- SEARCH & FILTER SECTION -->
    <section class="section max-w-5xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">
                
                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari panduan...">
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-3 mb-8">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    @php
                        $uniqueCategories = $data->pluck('category')->unique();
                    @endphp
                    @foreach($uniqueCategories as $category)
                    <button class="filter-btn" data-filter="{{ strtolower($category) }}">
                        @if($category == 'Petunjuk Penggunaan') 📖 
                        @elseif($category == 'Kebijakan') ⚖️ 
                        @elseif($category == 'Syarat & Ketentuan') 📜 
                        @elseif($category == 'FAQ') ❓ 
                        @else 📌 
                        @endif
                        {{ $category }}
                    </button>
                    @endforeach
                </div>

                <!-- Guides Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="guidesGrid">
                    <!-- Guide cards will be inserted by JavaScript -->
                </div>

            </div>
        </div>
    </section>

    <!-- HELP SECTION -->
    <section class="section max-w-5xl mx-auto px-5 mb-16">
        <div class="glass-card p-6 rounded-2xl fade-up">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">💬</span>
                    <div>
                        <h3 class="font-semibold text-indigo-200">Butuh Bantuan Lainnya?</h3>
                        <p class="text-sm text-gray-400">Jika Anda tidak menemukan panduan yang dicari, silakan hubungi pusat informasi akademik kami di Balige.</p>
                    </div>
                </div>
                <button id="helpBtn" class="btn-primary px-6 py-2 text-sm">
                    Hubungi Kami →
                </button>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="section max-w-5xl mx-auto px-5 pb-16">
        <div class="glass-card p-6 rounded-2xl fade-up text-center">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="font-bold text-indigo-200">Akper HKBP Balige</h3>
                    <p class="text-xs text-gray-500 mt-1">© 2024 Akademi Keperawatan HKBP Balige. Seluruh Hak Cipta Dilindungi.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-indigo-300">📞 Kontak Layanan Akademik</p>
                    <p class="text-xs text-gray-400">(0632) 12345 | info@akperhkbp.ac.id</p>
                </div>
            </div>
        </div>
    </footer>

</div>
@endsection

@push('scripts')
<script>
// ============================================
// DATA DARI BACKEND (Laravel) - LANGSUNG DARI CONTROLLER
// ============================================

@php
    $guides = $data->map(function($item){
        // Map kategori ke filter yang sesuai
        $categoryFilter = strtolower($item->category);
        
        // Mapping filter untuk konsistensi
        if (strpos($categoryFilter, 'petunjuk') !== false) {
            $categoryFilter = 'perpustakaan';
        } elseif (strpos($categoryFilter, 'kebijakan') !== false) {
            $categoryFilter = 'administrasi';
        } elseif (strpos($categoryFilter, 'syarat') !== false) {
            $categoryFilter = 'administrasi';
        } elseif (strpos($categoryFilter, 'faq') !== false) {
            $categoryFilter = 'perpustakaan';
        } else {
            $categoryFilter = 'laboratorium';
        }
        
        return [
            'id' => $item->id,
            'title' => $item->title,
            'category' => $item->category,
            'category_filter' => $categoryFilter,
            'icon' => $item->icon ?? 'fas fa-file-alt',
            'date' => $item->updated_at ? $item->updated_at->format('d M Y') : date('d M Y'),
            'description' => $item->description ?? '',
            'files' => $item->activeFiles->map(function($file){
                return [
                    'url' => asset('storage/' . $file->file_url),
                    'name' => $file->file_name ?? 'File',
                    'size' => $file->file_size ?? 0
                ];
            })->values()
        ];
    })->values();
@endphp

let guidesData = {!! json_encode($guides) !!};

// ============================================
// FILTER & SEARCH
// ============================================

let currentFilter = 'all';
let searchQuery = '';

function renderGuides() {
    let filteredData = [...guidesData];
    
    // SEARCH
    if (searchQuery) {
        filteredData = filteredData.filter(item => 
            item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
            item.description.toLowerCase().includes(searchQuery.toLowerCase())
        );
    }
    
    // FILTER
    if (currentFilter !== 'all') {
        filteredData = filteredData.filter(item => 
            item.category_filter === currentFilter
        );
    }
    
    const grid = document.getElementById('guidesGrid');
    if (!grid) return;
    
    grid.innerHTML = '';
    
    if (filteredData.length === 0) {
        grid.innerHTML = `
            <div class="col-span-2 text-center py-12">
                <div class="text-5xl mb-3">📭</div>
                <p class="text-gray-400">Tidak ada panduan yang ditemukan</p>
                <p class="text-sm text-gray-500 mt-1">Coba kata kunci lain atau pilih kategori berbeda</p>
            </div>
        `;
        return;
    }
    
    filteredData.forEach(guide => {
        let fileButton = '';
        if (guide.files.length > 0) {
            fileButton = `
                <a href="${guide.files[0].url}" target="_blank" class="btn-download" download>
                    📥 Unduh
                </a>
            `;
        } else {
            fileButton = `
                <span class="btn-download" style="opacity:0.5; cursor:not-allowed;">
                    📄 Tidak ada file
                </span>
            `;
        }

        // Tentukan icon berdasarkan kategori
        let iconHtml = '';
        if (guide.icon && guide.icon.includes('fa-')) {
            iconHtml = `<i class="${guide.icon}"></i>`;
        } else {
            // Default icons based on category
            if (guide.category.toLowerCase().includes('petunjuk')) {
                iconHtml = '📖';
            } else if (guide.category.toLowerCase().includes('kebijakan')) {
                iconHtml = '⚖️';
            } else if (guide.category.toLowerCase().includes('syarat')) {
                iconHtml = '📜';
            } else if (guide.category.toLowerCase().includes('faq')) {
                iconHtml = '❓';
            } else {
                iconHtml = '📄';
            }
        }

        const card = document.createElement('div');
        card.className = 'guide-card fade-up';
        card.setAttribute('data-id', guide.id);
        card.innerHTML = `
            <div class="p-5 flex items-start justify-between gap-4">
                <div class="flex items-start gap-4 flex-1">
                    <div class="guide-icon">${iconHtml}</div>
                    <div class="flex-1">
                        <h3 class="guide-title">${escapeHtml(guide.title)}</h3>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                            ${guide.description ? escapeHtml(guide.description.substring(0, 100)) + (guide.description.length > 100 ? '...' : '') : '-'}
                        </p>
                        <div class="guide-meta mt-3">
                            <span>🕒 Update: ${guide.date}</span>
                            ${guide.files.length > 0 ? `
                                <span class="mx-2">•</span>
                                <span>📄 ${guide.files.length} file</span>
                            ` : ''}
                        </div>
                    </div>
                </div>
                ${fileButton}
            </div>
        `;
        grid.appendChild(card);
    });
}

// Helper function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ============================================
// EVENT HANDLERS
// ============================================

// FILTER BUTTON
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const filter = e.currentTarget.getAttribute('data-filter');
        currentFilter = filter;
        
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active');
        });
        e.currentTarget.classList.add('active');
        
        renderGuides();
    });
});

// SEARCH INPUT
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value;
        renderGuides();
    });
}

// HELP BUTTON
const helpBtn = document.getElementById('helpBtn');
if (helpBtn) {
    helpBtn.addEventListener('click', () => {
        showNotification('💬 Menghubungkan ke layanan bantuan akademik...', 'info');
    });
}

// NOTIFICATION FUNCTION
function showNotification(message, type = 'info') {
    // Remove existing notification
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" style="background:none; border:none; color:#94a3b8; cursor:pointer;">✕</button>
        </div>
    `;
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Auto hide after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// ============================================
// ANIMATION ON SCROLL (Fade Up)
// ============================================
const fadeElements = document.querySelectorAll('.fade-up');

function checkFade() {
    fadeElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        
        if (rect.top < windowHeight - 100) {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }
    });
}

// Set initial styles
fadeElements.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
});

window.addEventListener('load', () => {
    checkFade();
    renderGuides();
});

window.addEventListener('scroll', checkFade);

// ============================================
// INITIAL RENDER
// ============================================
console.log('✅ Panduan dinamis dari database aktif!');
console.log(`📊 Total panduan: ${guidesData.length}`);
</script>
@endpush