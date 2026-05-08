@extends('user.component.master')

@section('title', 'Detail Jurnal - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN DETAIL JURNAL
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
    
    .category-riset { background: rgba(139, 92, 246, 0.2); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.4); }
    .category-keperawatan { background: rgba(99, 102, 241, 0.2); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.4); }
    
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
    
    .btn-outline:disabled {
        opacity: 0.5;
        cursor: not-allowed;
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
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .metadata-item {
        background: rgba(15, 23, 42, 0.6);
        border-radius: 1rem;
        padding: 1rem;
        border: 1px solid rgba(99, 102, 241, 0.2);
        transition: all 0.3s ease;
    }
    
    .metadata-item:hover {
        border-color: rgba(99, 102, 241, 0.5);
        background: rgba(15, 23, 42, 0.8);
        transform: translateY(-2px);
    }
    
    .metadata-label {
        font-size: 0.7rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    
    .metadata-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #e2e8f0;
        word-wrap: break-word;
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
    
    /* Section Title */
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #a5b4fc;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(99, 102, 241, 0.3);
        display: inline-block;
    }
    
    /* Badge Container */
    .badge-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    /* Stats Card */
    .stats-card {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05));
        border: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    /* Copyright */
    .copyright-text {
        font-family: monospace;
        font-size: 0.7rem;
        color: #64748b;
        background: rgba(0,0,0,0.3);
        padding: 0.5rem;
        border-radius: 0.5rem;
    }
    
    /* Delay utilities */
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
    
    /* Responsive */
    @media (max-width: 768px) {
        .neon-inner {
            padding: 1rem;
        }
        .metadata-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">

    {{-- 🔥 NOTIFICATION --}}
    @if(session('success'))
        <div id="notif" class="notification">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="notif" class="notification" style="border-color: #ef4444;">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                📄 {{ strtoupper(str_replace('_', ' ', $collection->menu_type ?? 'JURNAL')) }}
            </span>
        </div>

        <h1 class="text-3xl md:text-5xl font-extrabold title-main fade-up">
            {{ $collection->title }}
        </h1>

        <div class="flex flex-wrap justify-center gap-3 mt-4 text-gray-400 text-sm fade-up">
            <span><i class="fas fa-user-edit mr-1"></i> {{ is_array($collection->author) ? implode(', ', $collection->author) : ($collection->author ?? '-') }}</span>

            @if($collection->publisher)
            <span><i class="fas fa-building mr-1"></i> {{ $collection->publisher }}</span>
            @endif

            @if($collection->publication_year)
            <span><i class="far fa-calendar-alt mr-1"></i> {{ $collection->publication_year }}</span>
            @endif

            @if($collection->edition)
            <span><i class="fas fa-tag mr-1"></i> Edisi {{ $collection->edition }}</span>
            @endif
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- LEFT COLUMN - COVER & ACTION -->
                    <div class="flex flex-col">

                        <!-- COVER IMAGE -->
                        <div class="book-cover-large">
                            <img src="{{ $collection->cover_image ? asset('storage/'.$collection->cover_image) : 'https://via.placeholder.com/400x500?text=No+Cover' }}"
                                class="w-full" alt="Cover {{ $collection->title }}">
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="mt-4 flex flex-col gap-3">
                            @if($collection->file_url)
                                <a href="{{ asset('storage/'.$collection->file_url) }}"
                                   target="_blank"
                                   class="btn-primary w-full text-center">
                                    <i class="fas fa-download mr-2"></i> Download Jurnal
                                </a>
                            @endif

                            <button onclick="copyCitation()"
                                    class="btn-outline w-full">
                                <i class="fas fa-quote-right mr-2"></i> Salin Sitasi
                            </button>
                        </div>

                        <!-- STATUS CARD -->
                        <div class="glass-card p-4 mt-6 stats-card">
                            <div class="text-center">
                                <div class="text-indigo-300 font-semibold text-sm">
                                    <i class="fas fa-info-circle mr-1"></i> INFORMASI
                                </div>
                                <div class="mt-2 text-xs text-gray-400">
                                    <i class="fas fa-file-alt mr-1"></i> Jurnal Ilmiah
                                </div>
                                @if($collection->format)
                                <div class="mt-1 text-xs text-gray-500">
                                    Format: {{ $collection->format }}
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN - DETAIL INFORMASI -->
                    <div class="lg:col-span-2">

                        <!-- DESKRIPSI / ABSTRAK -->
                        @if($collection->description)
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-align-left mr-2"></i> Abstrak / Deskripsi
                            </h2>
                            <div class="mt-3 text-gray-300 leading-relaxed">
                                {{ $collection->description }}
                            </div>
                        </div>
                        @endif

                        <!-- INFORMASI LENGKAP JURNAL -->
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-info-circle mr-2"></i> Informasi Jurnal
                            </h2>
                            
                            <div class="metadata-grid mt-4">
                                <!-- Penulis -->
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-user-edit mr-1"></i> Penulis
                                    </div>
                                    <div class="metadata-value">
                                        {{ is_array($collection->author) ? implode(', ', $collection->author) : ($collection->author ?? '-') }}
                                    </div>
                                </div>

                                <!-- Penerbit -->
                                @if($collection->publisher)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-building mr-1"></i> Penerbit
                                    </div>
                                    <div class="metadata-value">{{ $collection->publisher }}</div>
                                </div>
                                @endif

                                <!-- ISSN/ISBN -->
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-barcode mr-1"></i> ISSN/ISBN
                                    </div>
                                    <div class="metadata-value">
                                        {{ $collection->isbn ?? '-' }}
                                        @if(!$collection->isbn)
                                            <span class="text-gray-500 text-xs">(Tidak tersedia)</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Volume/Nomor -->
                                @if($collection->series_title)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-layer-group mr-1"></i> Volume / Nomor
                                    </div>
                                    <div class="metadata-value">{{ $collection->series_title }}</div>
                                </div>
                                @endif

                                <!-- Tahun Terbit -->
                                @if($collection->publication_year)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="far fa-calendar-alt mr-1"></i> Tahun Terbit
                                    </div>
                                    <div class="metadata-value">{{ $collection->publication_year }}</div>
                                </div>
                                @endif

                                <!-- Edisi -->
                                @if($collection->edition)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-tag mr-1"></i> Edisi
                                    </div>
                                    <div class="metadata-value">{{ $collection->edition }}</div>
                                </div>
                                @endif

                                <!-- Bahasa -->
                                @if($collection->language)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-language mr-1"></i> Bahasa
                                    </div>
                                    <div class="metadata-value">{{ $collection->language }}</div>
                                </div>
                                @endif

                                <!-- Subject -->
                                @if($collection->subject)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-graduation-cap mr-1"></i> Subject
                                    </div>
                                    <div class="metadata-value">{{ $collection->subject }}</div>
                                </div>
                                @endif

                                <!-- Carrier Type -->
                                @if($collection->carrier_type)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-database mr-1"></i> Carrier Type
                                    </div>
                                    <div class="metadata-value">{{ $collection->carrier_type }}</div>
                                </div>
                                @endif

                                <!-- Format -->
                                @if($collection->format)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-file mr-1"></i> Format
                                    </div>
                                    <div class="metadata-value">{{ $collection->format }}</div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- CLASSIFICATION -->
                        @if($collection->classifications && $collection->classifications->count() > 0)
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-tags mr-2"></i> Klasifikasi
                            </h2>
                            <div class="badge-container mt-3">
                                @foreach($collection->classifications as $classification)
                                    <span class="category-badge" style="background: rgba(99, 102, 241, 0.2); color: #a5b4fc; border-color: rgba(99, 102, 241, 0.4);">
                                        <i class="fas fa-hashtag mr-1"></i> {{ $classification->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- CATEGORIES -->
                        @if($collection->categories && $collection->categories->count() > 0)
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-folder-open mr-2"></i> Kategori
                            </h2>
                            <div class="badge-container mt-3">
                                @foreach($collection->categories as $category)
                                    <span class="category-badge category-riset">
                                        <i class="fas fa-folder mr-1"></i> {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- KEYWORDS -->
                        @if($collection->keywords && count($collection->keywords) > 0)
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-key mr-2"></i> Kata Kunci
                            </h2>
                            <div class="badge-container mt-3">
                                @foreach($collection->keywords as $keyword)
                                    <span class="category-badge" style="background: rgba(139, 92, 246, 0.2); color: #a78bfa; border-color: rgba(139, 92, 246, 0.4);">
                                        <i class="fas fa-hashtag mr-1"></i> {{ $keyword }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- SITASI / REFERENSI -->
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-quote-left mr-2"></i> Cara Sitasi
                            </h2>
                            <div class="glass-card p-4 mt-3">
                                <div class="reference-text mb-2">
                                    <strong class="text-indigo-300">Format Sitasi:</strong>
                                </div>
                                <div class="copyright-text mb-3" id="citationText">
                                    {{ is_array($collection->author) ? implode(', ', $collection->author) : ($collection->author ?? 'Penulis') }} 
                                    ({{ $collection->publication_year ?? 't.th' }}). 
                                    {{ $collection->title }}. 
                                    {{ $collection->publisher ?? '' }}.
                                </div>
                                <button onclick="copyCitation()" class="btn-link text-sm">
                                    <i class="fas fa-copy mr-1"></i> Salin Sitasi
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- BACK BUTTON -->
    <div class="text-center mt-10 mb-20">
        <a href="{{ route('user.koleksi.jurnal') }}" class="btn-outline px-6 py-3 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Jurnal
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>

// ================= AUTO CLOSE NOTIFICATION =================
document.addEventListener('DOMContentLoaded', function() {
    const notif = document.getElementById('notif');
    if (notif) {
        setTimeout(() => notif.classList.add('show'), 100);
        setTimeout(() => {
            notif.classList.remove('show');
            setTimeout(() => notif.remove(), 300);
        }, 4000);
    }
});

// ================= GENERATE SITASI OTOMATIS =================
function generateCitation() {
    const author = @json(is_array($collection->author) ? implode(', ', $collection->author) : ($collection->author ?? 'Penulis'));
    const year = @json($collection->publication_year ?? 't.th');
    const title = @json($collection->title);
    const publisher = @json($collection->publisher ?? '');
    
    return `${author} (${year}). ${title}. ${publisher}.`.trim();
}

// ================= COPY SITASI =================
function copyCitation() {
    const text = generateCitation();
    
    navigator.clipboard.writeText(text)
        .then(() => {
            showNotification('📋 Sitasi berhasil disalin!', 'success');
        })
        .catch(() => {
            showNotification('❌ Gagal menyalin sitasi', 'error');
        });
}

// ================= SHOW NOTIFICATION =================
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.style.transform = 'translateX(120%)';
    
    const icon = type === 'success' ? '✅' : '⚠️';
    notification.innerHTML = `${icon} ${message}`;
    
    if (type === 'error') {
        notification.style.borderColor = '#ef4444';
    }
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Expose global functions
window.copyCitation = copyCitation;
window.generateCitation = generateCitation;

</script>
@endpush