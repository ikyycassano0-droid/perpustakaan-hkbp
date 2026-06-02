@extends('user.component.master')

@section('title', 'Detail Koleksi Elektronik - AKPER HKBP Balige')

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
    
    /* Category Badge */
    .category-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .badge-ebook { background: rgba(99, 102, 241, 0.2); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.4); }
    .badge-earticle { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); }
    .badge-cd { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); }
    .badge-video { background: rgba(139, 92, 246, 0.2); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.4); }
    
    /* Metadata Grid */
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
    
    /* Cover Image */
    .cover-large {
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 25px 40px -15px rgba(0, 0, 0, 0.4);
        background: linear-gradient(135deg, #1e293b, #0f172a);
    }
    
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
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .btn-primary:hover {
        transform: scale(1.02);
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
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .btn-outline:hover {
        background: rgba(99, 102, 241, 0.2);
        border-color: #6366f1;
        transform: translateY(-2px);
    }
    
    /* File Preview */
    .file-preview {
        background: rgba(15, 23, 42, 0.4);
        border-radius: 1rem;
        padding: 1rem;
        text-align: center;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .neon-inner {
            padding: 1rem;
        }
        .metadata-grid {
            grid-template-columns: 1fr;
        }
        .btn-primary, .btn-outline {
            padding: 8px 16px;
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">

    {{-- HERO SECTION --}}
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">
                💿 {{ strtoupper($item->category->name ?? 'KOLEKSI ELEKTRONIK') }}
            </span>
        </div>

        <h1 class="text-3xl md:text-5xl font-extrabold title-main fade-up">
            {{ $item->title }}
        </h1>

        <div class="flex flex-wrap justify-center gap-3 mt-4 text-gray-400 text-sm fade-up">
            @if($item->isbn)
            <span><i class="fas fa-barcode mr-1"></i> ISBN: {{ $item->isbn }}</span>
            @endif

            @if($item->year)
            <span><i class="far fa-calendar-alt mr-1"></i> {{ $item->year }}</span>
            @endif

            <span><i class="fas fa-calendar-plus mr-1"></i> Diupload: {{ $item->created_at->format('d M Y') }}</span>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <section class="section max-w-6xl mx-auto px-5">
        <div class="neon-border fade-up">
            <div class="neon-inner">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- LEFT COLUMN - COVER --}}
                    <div class="flex flex-col">
                        <div class="cover-large">
                            @if($item->cover_image)
                                <img src="{{ asset('storage/'.$item->cover_image) }}"
                                     class="w-full" alt="Cover {{ $item->title }}">
                            @else
                                <div class="aspect-[3/4] flex items-center justify-center text-8xl bg-gradient-to-br from-slate-800 to-slate-900">
                                    @php
                                        $slug = $item->category->slug ?? '';
                                        $icon = match($slug) {
                                            'ebook' => '📖',
                                            'e-article' => '📄',
                                            'cd' => '💿',
                                            'video' => '🎬',
                                            default => '📁'
                                        };
                                    @endphp
                                    {{ $icon }}
                                </div>
                            @endif
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="mt-6 flex flex-col gap-3">
                            @if($item->file_url)
                                @php
                                    $fileExt = pathinfo($item->file_url, PATHINFO_EXTENSION);
                                    $fileUrl = asset('storage/'.$item->file_url);
                                @endphp

                                @if(in_array($fileExt, ['mp4', 'webm', 'ogg']))
                                    <button onclick="openVideoModal('{{ $fileUrl }}', '{{ addslashes($item->title) }}')"
                                            class="btn-primary w-full justify-center">
                                        <i class="fas fa-play"></i> Putar Video
                                    </button>
                                @elseif(in_array($fileExt, ['mp3', 'wav', 'ogg']))
                                    <button onclick="openAudioModal('{{ $fileUrl }}', '{{ addslashes($item->title) }}')"
                                            class="btn-primary w-full justify-center">
                                        <i class="fas fa-headphones"></i> Dengarkan Audio
                                    </button>
                                @elseif($fileExt === 'pdf')
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn-primary w-full justify-center">
                                        <i class="fas fa-file-pdf"></i> Baca PDF
                                    </a>
                                @else
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn-primary w-full justify-center">
                                        <i class="fas fa-download"></i> Download File
                                    </a>
                                @endif
                            @endif

                            <a href="{{ url()->previous() }}" class="btn-outline w-full justify-center">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN - DETAIL INFORMASI --}}
                    <div class="lg:col-span-2">

                        {{-- DESKRIPSI / ABSTRACT --}}
                        @if($item->abstract)
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-align-left mr-2"></i> Abstract / Ringkasan
                            </h2>
                            <div class="mt-3 text-gray-300 leading-relaxed">
                                {{ $item->abstract }}
                            </div>
                        </div>
                        @endif

                        {{-- INFORMASI LENGKAP --}}
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-info-circle mr-2"></i> Informasi Lengkap
                            </h2>
                            
                            <div class="metadata-grid mt-4">
                                {{-- Jenis Koleksi --}}
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-tag mr-1"></i> Jenis Koleksi
                                    </div>
                                    <div class="metadata-value">
                                        @php
                                            $slug = $item->category->slug ?? '';
                                            $badgeClass = match($slug) {
                                                'ebook' => 'badge-ebook',
                                                'e-article' => 'badge-earticle',
                                                'cd' => 'badge-cd',
                                                'video' => 'badge-video',
                                                default => 'badge-ebook'
                                            };
                                        @endphp
                                        <span class="category-badge {{ $badgeClass }}">
                                            {{ $item->category->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- ISBN --}}
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-barcode mr-1"></i> ISBN
                                    </div>
                                    <div class="metadata-value">
                                        {{ $item->isbn ?? '-' }}
                                        @if(!$item->isbn)
                                            <span class="text-gray-500 text-xs">(Tidak tersedia)</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Tahun --}}
                                @if($item->year)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="far fa-calendar-alt mr-1"></i> Tahun
                                    </div>
                                    <div class="metadata-value">{{ $item->year }}</div>
                                </div>
                                @endif

                                {{-- Tanggal Upload --}}
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-upload mr-1"></i> Tanggal Upload
                                    </div>
                                    <div class="metadata-value">{{ $item->created_at->format('d F Y') }}</div>
                                </div>

                                {{-- Format File --}}
                                @if($item->file_url)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-file mr-1"></i> Format File
                                    </div>
                                    <div class="metadata-value">
                                        {{ strtoupper(pathinfo($item->file_url, PATHINFO_EXTENSION)) }}
                                    </div>
                                </div>
                                @endif

                                {{-- Ukuran File (opsional jika ada kolom size) --}}
                                @if(isset($item->file_size) && $item->file_size)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-weight-hanging mr-1"></i> Ukuran File
                                    </div>
                                    <div class="metadata-value">{{ number_format($item->file_size / 1024, 2) }} KB</div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- CLASSIFICATION --}}
                        @if($item->classifications && $item->classifications->count() > 0)
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-tags mr-2"></i> Klasifikasi
                            </h2>
                            <div class="badge-container mt-3">
                                @foreach($item->classifications as $classification)
                                    <span class="category-badge" style="background: rgba(99, 102, 241, 0.2); color: #a5b4fc; border-color: rgba(99, 102, 241, 0.4);">
                                        <i class="fas fa-hashtag mr-1"></i> {{ $classification->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- CATEGORIES --}}
                        @if($item->categoriesMany && $item->categoriesMany->count() > 0)
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-folder-open mr-2"></i> Kategori
                            </h2>
                            <div class="badge-container mt-3">
                                @foreach($item->categoriesMany as $category)
                                    <span class="category-badge badge-ebook">
                                        <i class="fas fa-folder mr-1"></i> {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- KEYWORDS --}}
                        @if($item->keywords && count($item->keywords) > 0)
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-key mr-2"></i> Kata Kunci
                            </h2>
                            <div class="badge-container mt-3">
                                @foreach($item->keywords as $keyword)
                                    <span class="category-badge" style="background: rgba(139, 92, 246, 0.2); color: #a78bfa; border-color: rgba(139, 92, 246, 0.4);">
                                        <i class="fas fa-hashtag mr-1"></i> {{ $keyword }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- PREVIEW FILE (Untuk PDF) --}}
                        @if($item->file_url && pathinfo($item->file_url, PATHINFO_EXTENSION) === 'pdf')
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-file-pdf mr-2"></i> Preview File
                            </h2>
                            <div class="file-preview mt-3">
                                <iframe src="{{ asset('storage/'.$item->file_url) }}" 
                                        width="100%" 
                                        height="400" 
                                        class="rounded-xl"
                                        frameborder="0">
                                </iframe>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

{{-- MODAL VIDEO --}}
<div id="videoModal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="relative w-full max-w-4xl mx-4">
        <button onclick="closeVideoModal()" 
                class="absolute -top-12 right-0 text-white text-2xl hover:text-gray-300 transition">
            <i class="fas fa-times"></i>
        </button>
        <video id="videoPlayer" class="w-full rounded-xl" controls>
            <source id="videoSource" src="">
            Browser Anda tidak mendukung video.
        </video>
        <h3 id="videoTitle" class="text-white text-center mt-4"></h3>
    </div>
</div>

{{-- MODAL AUDIO --}}
<div id="audioModal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="relative w-full max-w-2xl mx-4 bg-slate-900 rounded-2xl p-6 border border-indigo-500/30">
        <button onclick="closeAudioModal()" 
                class="absolute -top-10 right-0 text-white text-2xl hover:text-gray-300 transition">
            <i class="fas fa-times"></i>
        </button>
        <div class="text-center mb-4">
            <i class="fas fa-headphones text-6xl text-indigo-400"></i>
        </div>
        <h3 id="audioTitle" class="text-white text-center text-xl mb-6"></h3>
        <audio id="audioPlayer" class="w-full" controls>
            <source id="audioSource" src="">
            Browser Anda tidak mendukung audio.
        </audio>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ================= VIDEO MODAL =================
    function openVideoModal(url, title) {
        const modal = document.getElementById('videoModal');
        const videoPlayer = document.getElementById('videoPlayer');
        const videoSource = document.getElementById('videoSource');
        const videoTitle = document.getElementById('videoTitle');
        
        videoSource.src = url;
        videoPlayer.load();
        videoTitle.textContent = title;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Play video
        videoPlayer.play().catch(e => console.log('Auto-play prevented:', e));
    }
    
    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const videoPlayer = document.getElementById('videoPlayer');
        
        videoPlayer.pause();
        videoPlayer.currentTime = 0;
        
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    // ================= AUDIO MODAL =================
    function openAudioModal(url, title) {
        const modal = document.getElementById('audioModal');
        const audioPlayer = document.getElementById('audioPlayer');
        const audioSource = document.getElementById('audioSource');
        const audioTitle = document.getElementById('audioTitle');
        
        audioSource.src = url;
        audioPlayer.load();
        audioTitle.textContent = title;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Play audio
        audioPlayer.play().catch(e => console.log('Auto-play prevented:', e));
    }
    
    function closeAudioModal() {
        const modal = document.getElementById('audioModal');
        const audioPlayer = document.getElementById('audioPlayer');
        
        audioPlayer.pause();
        audioPlayer.currentTime = 0;
        
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    // ================= CLOSE MODAL WITH ESC =================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeVideoModal();
            closeAudioModal();
        }
    });
    
    // ================= FADE UP ANIMATION =================
    const fadeElements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    fadeElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
    
    // Add show class for initial elements
    const style = document.createElement('style');
    style.textContent = `
        .fade-up.show {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    `;
    document.head.appendChild(style);
    
    // Make functions global
    window.openVideoModal = openVideoModal;
    window.closeVideoModal = closeVideoModal;
    window.openAudioModal = openAudioModal;
    window.closeAudioModal = closeAudioModal;
</script>
@endpush



