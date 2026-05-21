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
    
    /* Info Grid 3 Columns */
    .info-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    
    /* Stats Card */
    .stats-card {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05));
        border: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    /* Badge Container */
    .badge-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
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
                📚 {{ strtoupper(str_replace('_', ' ', $collection->menu_type ?? 'KOLEKSI')) }}
            </span>
        </div>

        <h1 class="text-3xl md:text-5xl font-extrabold title-main fade-up">
            {{ $collection->title }}
        </h1>

        <div class="flex flex-wrap justify-center gap-3 mt-4 text-gray-400 text-sm fade-up">
            <span><i class="fas fa-user-edit mr-1"></i> {{ is_array($collection->author) ? implode(', ', $collection->author) : $collection->author }}</span>

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
                            @php
                                $hasPending = false;
                                if(is_logged_in()) {
                                    $hasPending = \App\Models\Order::where('user_id', user_id())
                                        ->where('status', 'PENDING')
                                        ->whereHas('details', function($q) use ($collection) {
                                            $q->where('collection_id', $collection->id);
                                        })
                                        ->exists();
                                }
                            @endphp

                            @if(session()->has('user'))
                                @if($hasPending)
                                    <button class="btn-primary w-full opacity-50" disabled>
                                        ⏳ Menunggu Persetujuan
                                    </button>
                                    <small class="text-center text-yellow-500 text-xs">
                                        <i class="fas fa-clock mr-1"></i> Anda sudah meminjam buku ini, menunggu konfirmasi admin
                                    </small>
                                @elseif($collection->stock > 0)
                                    <button onclick="openModal({{ $collection->id }}, '{{ addslashes($collection->title) }}')"
                                            class="btn-primary w-full">
                                        <i class="fas fa-book-open mr-2"></i> Pinjam Buku
                                    </button>
                                @else
                                    <button class="btn-outline w-full opacity-50" disabled>
                                        <i class="fas fa-times-circle mr-2"></i> Stok Habis
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-primary w-full text-center">
                                    <i class="fas fa-lock mr-2"></i> Login untuk Pinjam
                                </a>
                            @endif

                            @if($collection->file_url)
                                <a href="{{ asset('storage/'.$collection->file_url) }}"
                                   target="_blank"
                                   class="btn-outline w-full text-center">
                                    <i class="fas fa-file-pdf mr-2"></i> Baca Online / Download PDF
                                </a>
                            @endif
                        </div>

                        <!-- STATUS CARD -->
                        <div class="glass-card p-4 mt-6 stats-card">
                            <div class="text-center">
                                @if($collection->stock > 0)
                                    <div class="text-green-400 font-semibold text-lg">
                                        <i class="fas fa-check-circle mr-2"></i> Tersedia
                                    </div>
                                    <div class="text-sm text-gray-400 mt-1">{{ $collection->stock }} buku tersedia</div>
                                @else
                                    <div class="text-red-400 font-semibold text-lg">
                                        <i class="fas fa-times-circle mr-2"></i> Tidak Tersedia
                                    </div>
                                @endif

                                @if($collection->location)
                                <div class="mt-3 pt-3 border-t border-gray-700">
                                    <div class="text-xs text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-1"></i> LOKASI RAK
                                    </div>
                                    <div class="text-sm text-indigo-300 font-semibold mt-1">
                                        {{ $collection->location->name }}
                                    </div>
                                </div>
                                @endif

                                @if($collection->format)
                                <div class="mt-2 text-xs text-gray-500">
                                    <i class="fas fa-file-alt mr-1"></i> Format: {{ $collection->format }}
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN - DETAIL INFORMASI -->
                    <div class="lg:col-span-2">

                        <!-- DESKRIPSI -->
                        @if($collection->description)
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-align-left mr-2"></i> Deskripsi
                            </h2>
                            <div class="mt-3 text-gray-300 leading-relaxed">
                                {{ $collection->description }}
                            </div>
                        </div>
                        @endif

                        <!-- INFORMASI LENGKAP (SEMUA ATRIBUT) -->
                        <div class="mb-8">
                            <h2 class="section-title">
                                <i class="fas fa-info-circle mr-2"></i> Informasi Lengkap
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

                                <!-- Publisher -->
                                @if($collection->publisher)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-building mr-1"></i> Penerbit
                                    </div>
                                    <div class="metadata-value">{{ $collection->publisher }}</div>
                                </div>
                                @endif

                                <!-- ISBN (PENTING - PASTIKAN TAMPIL) -->
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-barcode mr-1"></i> ISBN
                                    </div>
                                    <div class="metadata-value">
                                        {{ $collection->isbn ?? '-' }}
                                        @if(!$collection->isbn)
                                            <span class="text-gray-500 text-xs">(Tidak tersedia)</span>
                                        @endif
                                    </div>
                                </div>

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

                                <!-- Stok -->
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-boxes mr-1"></i> Stok Tersedia
                                    </div>
                                    <div class="metadata-value">
                                        <span class="{{ $collection->stock > 0 ? 'text-green-400' : 'text-red-400' }} font-bold">
                                            {{ $collection->stock ?? 0 }} Buku
                                        </span>
                                    </div>
                                </div>

                                <!-- Series Title -->
                                @if($collection->series_title)
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-layer-group mr-1"></i> Series Title
                                    </div>
                                    <div class="metadata-value">{{ $collection->series_title }}</div>
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
                                    <span class="category-badge category-pengayaan">
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

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- BACK BUTTON -->
    <div class="text-center mt-10 mb-20">
        <a href="{{ url()->previous() }}" class="btn-outline px-6 py-3 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Koleksi
        </a>
    </div>

</div>

{{-- ================= MODAL PINJAM ================= --}}
<div id="pinjamModal"
     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center">

    <div class="bg-gradient-to-br from-slate-900 to-slate-800 w-full max-w-md rounded-2xl border border-indigo-500/30 p-6 shadow-2xl">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-indigo-300">
                <i class="fas fa-book mr-2"></i> Form Peminjaman
            </h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-200 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="collection_id" id="collection_id">

            <div class="mb-4">
                <label class="text-xs text-gray-400 block mb-1">
                    <i class="fas fa-book mr-1"></i> Judul Buku
                </label>
                <input type="text" id="book_title"
                       class="w-full p-2.5 rounded-lg bg-slate-800 text-white border border-slate-700 focus:border-indigo-500 focus:outline-none transition"
                       readonly>
            </div>

            <div class="mb-4">
                <label class="text-xs text-gray-400 block mb-1">
                    <i class="fas fa-calendar-plus mr-1"></i> Tanggal Pinjam
                </label>
                <input type="date" name="borrow_date" id="borrow_date"
                       class="w-full p-2.5 rounded-lg bg-slate-800 text-white border border-slate-700 focus:border-indigo-500 focus:outline-none transition"
                       required>
            </div>

            <div class="mb-6">
                <label class="text-xs text-gray-400 block mb-1">
                    <i class="fas fa-calendar-check mr-1"></i> Tanggal Kembali
                </label>
                <input type="date" name="return_date" id="return_date"
                       class="w-full p-2.5 rounded-lg bg-slate-800 text-white border border-slate-700 focus:border-indigo-500 focus:outline-none transition"
                       required>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i> * Maksimal peminjaman 7 hari
                </p>
            </div>

            <div class="flex gap-3">
                <button type="button"
                        onclick="closeModal()"
                        class="flex-1 py-2.5 rounded-lg bg-gray-700 text-white font-medium hover:bg-gray-600 transition">
                    Batal
                </button>

                <button type="submit"
                        class="flex-1 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:from-indigo-700 hover:to-purple-700 transition">
                    <i class="fas fa-check mr-2"></i> Konfirmasi Pinjam
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>

// ================= FORMAT DATE =================
function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

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

// ================= OPEN MODAL =================
function openModal(id, title) {
    const modal = document.getElementById('pinjamModal');
    modal.classList.remove('hidden');

    document.getElementById('collection_id').value = id;
    document.getElementById('book_title').value = title;

    const today = new Date();
    today.setHours(0,0,0,0);

    const borrowInput = document.getElementById('borrow_date');
    const returnInput = document.getElementById('return_date');

    borrowInput.value = '';
    returnInput.value = '';

    borrowInput.min = formatDate(today);
    borrowInput.value = formatDate(today);

    const minReturn = new Date(today);
    minReturn.setDate(minReturn.getDate() + 1);

    const maxReturn = new Date(today);
    maxReturn.setDate(maxReturn.getDate() + 7);

    returnInput.min = formatDate(minReturn);
    returnInput.max = formatDate(maxReturn);
    returnInput.value = formatDate(minReturn);
}

// ================= CLOSE MODAL =================
function closeModal() {
    document.getElementById('pinjamModal').classList.add('hidden');
}

// Klik luar modal
document.addEventListener('click', function(e){
    const modal = document.getElementById('pinjamModal');
    if (e.target === modal) closeModal();
});

// ================= UPDATE RETURN DINAMIS =================
document.addEventListener('change', function(e){
    if (e.target.id === 'borrow_date') {
        const borrow = new Date(e.target.value);
        borrow.setHours(0,0,0,0);

        const returnInput = document.getElementById('return_date');
        const minReturn = new Date(borrow);
        minReturn.setDate(minReturn.getDate() + 1);
        const maxReturn = new Date(borrow);
        maxReturn.setDate(maxReturn.getDate() + 7);

        returnInput.min = formatDate(minReturn);
        returnInput.max = formatDate(maxReturn);

        const currentReturn = new Date(returnInput.value);
        if (currentReturn < minReturn || currentReturn > maxReturn) {
            returnInput.value = formatDate(minReturn);
        }
    }
});

// ================= VALIDASI SUBMIT =================
document.addEventListener('submit', function(e){
    if (e.target.id === 'pinjamForm') {
        const borrow = new Date(document.getElementById('borrow_date').value);
        const ret = new Date(document.getElementById('return_date').value);

        borrow.setHours(0,0,0,0);
        ret.setHours(0,0,0,0);

        const diff = (ret - borrow) / (1000 * 60 * 60 * 24);

        if (diff < 1) {
            alert('⚠️ Minimal peminjaman 1 hari');
            e.preventDefault();
            return;
        }

        if (diff > 7) {
            alert('⚠️ Maksimal peminjaman hanya 7 hari');
            e.preventDefault();
            return;
        }

        const btn = e.target.querySelector('button[type="submit"]');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
        btn.disabled = true;
    }
});

</script>
@endpush