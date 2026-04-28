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
    
    /* Metadata Box */
    .metadata-box {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        padding: 1.25rem;
    }
    
    .metadata-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .metadata-label {
        color: #94a3b8;
        font-size: 0.8rem;
    }
    
    .metadata-value {
        color: #c7d2fe;
        font-size: 0.8rem;
        font-weight: 500;
        text-align: right;
    }
    
    /* Reference Card */
    .reference-card {
        background: rgba(15, 23, 42, 0.4);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        border-left: 3px solid #6366f1;
        margin-bottom: 0.75rem;
    }
    
    .reference-text {
        font-size: 0.75rem;
        color: #cbd5e1;
        line-height: 1.4;
    }
    
    /* Prose styling */
    .prose {
        max-width: 100%;
    }
    
    .prose p {
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 1rem;
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
                📄 JURNAL ILMIAH
            </span>
        </div>

        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight title-main fade-up">
            {{ $collection->title }}
        </h1>

        <div class="flex items-center justify-center gap-3 mt-4 fade-up flex-wrap">
            <span class="category-badge category-riset">
                {{ $collection->category ?? 'Jurnal' }}
            </span>

            <span class="text-gray-400 text-sm">
                📅 {{ $collection->publication_year }}
            </span>

            @if($collection->isbn)
                <span class="text-gray-400 text-sm">
                    📍 ISBN: {{ $collection->isbn }}
                </span>
            @endif
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="section max-w-5xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <!-- Cover + Action -->
                <div class="flex flex-col md:flex-row gap-8 mb-8">

                    <!-- COVER -->
                    <div class="md:w-1/3">
                        <div class="rounded-2xl overflow-hidden glass-card">
                            <img src="{{ asset('storage/'.$collection->cover_image) }}"
                                 class="w-full h-auto">
                        </div>

                        <div class="flex gap-3 mt-4">
                            @if($collection->file_url)
                                <a href="{{ asset('storage/'.$collection->file_url) }}"
                                   target="_blank"
                                   class="btn-primary flex-1 text-center">
                                    📥 Download
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- METADATA -->
                    <div class="md:w-2/3">
                        <div class="metadata-box">

                            <div class="metadata-item">
                                <span class="metadata-label">📝 Judul</span>
                                <span class="metadata-value">
                                    {{ $collection->title }}
                                </span>
                            </div>

                            <div class="metadata-item">
                                <span class="metadata-label">✍️ Penulis</span>
                                <span class="metadata-value">
                                    {{ is_array($collection->author) ? implode(', ', $collection->author) : $collection->author }}
                                </span>
                            </div>

                            <div class="metadata-item">
                                <span class="metadata-label">📚 Penerbit</span>
                                <span class="metadata-value">
                                    {{ $collection->publisher }}
                                </span>
                            </div>

                            <div class="metadata-item">
                                <span class="metadata-label">📅 Tahun</span>
                                <span class="metadata-value">
                                    {{ $collection->publication_year }}
                                </span>
                            </div>

                            <div class="metadata-item">
                                <span class="metadata-label">🏷️ Bahasa</span>
                                <span class="metadata-value">
                                    {{ $collection->language }}
                                </span>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- DESKRIPSI / ABSTRAK -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-indigo-200 mb-4">
                        📋 Deskripsi
                    </h2>

                    <div class="glass-card p-5 rounded-xl">
                        <p class="text-gray-300 leading-relaxed">
                            {{ $collection->description ?? 'Tidak ada deskripsi.' }}
                        </p>
                    </div>
                </div>

                <!-- KEYWORDS -->
                @if($collection->keywords)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-indigo-200 mb-4">
                        🔑 Kata Kunci
                    </h2>

                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $collection->keywords) as $key)
                            <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-xs">
                                {{ trim($key) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- BACK BUTTON -->
                <div class="text-center mt-10">
                    <a href="{{ route('user.koleksi.jurnal') }}" class="btn-outline px-8 py-3">
                        ← Kembali
                    </a>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>

const journal = {
    title: @json($collection->title),
    authors: @json(is_array($collection->author) ? implode(', ', $collection->author) : $collection->author),
    publisher: @json($collection->publisher),
    year: @json($collection->publication_year),
    isbn: @json($collection->isbn),
    file: @json($collection->file_url ? asset('storage/'.$collection->file_url) : null)
};

// ==============================
// DOWNLOAD
// ==============================
function downloadJournal() {
    if (journal.file) {
        window.open(journal.file, '_blank');
        showNotification('📥 File berhasil dibuka!', 'success');
    } else {
        showNotification('⚠️ File tidak tersedia', 'error');
    }
}

// ==============================
// GENERATE SITASI OTOMATIS
// ==============================
function generateCitation() {
    return `${journal.authors} (${journal.year}). ${journal.title}. ${journal.publisher}.`;
}

// ==============================
// COPY SITASI
// ==============================
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

// ==============================
// BACK BUTTON
// ==============================
function goBack() {
    window.history.back();
}

// ==============================
// NOTIFICATION (fallback)
// ==============================
function showNotification(message, type = 'success') {
    if (typeof showNotif === 'function') {
        showNotif(message, type);
        return;
    }

    const n = document.createElement('div');
    n.className = 'notification show';
    n.innerHTML = message;
    document.body.appendChild(n);

    setTimeout(() => n.remove(), 2500);
}

// ==============================
// INIT
// ==============================
console.log('Detail Jurnal loaded:', journal);

// expose global
window.downloadJournal = downloadJournal;
window.copyCitation = copyCitation;
window.goBack = goBack;

</script>
@endpush