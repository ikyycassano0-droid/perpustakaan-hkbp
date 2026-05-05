@extends('user.component.master')

@section('title', 'Detail Buku Pengayaan - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN DETAIL BUKU Referensi
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

    {{-- 🔥 NOTIFICATION --}}
    @if(session('success'))
        <div id="notif" class="notification">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="notif" class="notification" style="border-color:red">
            {{ session('error') }}
        </div>
    @endif

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

                        <div class="book-cover-large">
                            <img src="{{ $collection->cover_image ? asset('storage/'.$collection->cover_image) : 'https://via.placeholder.com/400x500' }}"
                                class="w-full">
                        </div>

                        <!-- BUTTON SECTION - LOGIKA SAMA DENGAN HALAMAN KOLEKSI -->
                        <div class="mt-4 flex flex-col gap-3">

                            @php
                                $hasPending = false;

                                if(auth()->check()) {
                                    $hasPending = \App\Models\Order::where('user_id', auth()->id())
                                        ->where('status', 'PENDING')
                                        ->whereHas('details', function($q) use ($collection) {
                                            $q->where('collection_id', $collection->id);
                                        })
                                        ->exists();
                                }
                            @endphp

                            @auth
                                @if($hasPending)
                                    <button class="btn-primary w-full opacity-50" disabled>
                                        ⏳ Menunggu Persetujuan
                                    </button>
                                    <small class="text-center text-yellow-500 text-xs">Anda sudah meminjam buku ini, menunggu konfirmasi admin</small>
                                @elseif($collection->available_stock > 0)
                                    <button onclick="openModal({{ $collection->id }}, '{{ $collection->title }}')"
                                            class="btn-primary w-full">
                                        📖 Pinjam Buku
                                    </button>
                                @else
                                    <button class="btn-outline w-full opacity-50" disabled>
                                        ❌ Stok Habis
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-primary w-full text-center">
                                    🔐 Login untuk Pinjam
                                </a>
                            @endauth

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
                            @if($collection->available_stock > 0)
                                <span class="text-green-400 font-semibold">
                                    ✅ Tersedia ({{ $collection->available_stock }} tersisa)
                                </span>
                            @else
                                <span class="text-red-400 font-semibold">
                                    ❌ Tidak tersedia
                                </span>
                            @endif

                            <p class="text-xs text-gray-500 mt-2">
                                📍 {{ $collection->location->name ?? '-' }}
                            </p>
                        </div>

                    </div>

                    <!-- DETAIL -->
                    <div class="lg:col-span-2">

                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-indigo-200 mb-3">
                                📖 Deskripsi
                            </h2>

                            <p class="text-gray-300">
                                {{ $collection->description ?? '-' }}
                            </p>
                        </div>

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

                        @if($collection->keywords)
                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-indigo-200 mb-3">
                                🏷️ Keywords
                            </h2>

                            <div class="flex flex-wrap gap-2">
                                @foreach($collection->keywords as $key)
                                    <span class="category-badge category-pengayaan">{{ $key }}</span>
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

{{-- ================= MODAL PINJAM (SAMA DENGAN KOLEKSI) ================= --}}
<div id="pinjamModal"
     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center">

    <div class="bg-slate-900 w-full max-w-md rounded-2xl border border-indigo-500/30 p-6">

        <h2 class="text-xl font-bold text-indigo-300 mb-4">
            Form Peminjaman
        </h2>

        <form id="pinjamForm" method="POST" action="{{ route('orders.store') }}">
            @csrf

            <input type="hidden" name="collection_id" id="collection_id">

            <div class="mb-3">
                <label class="text-xs text-gray-400">Judul Buku</label>
                <input type="text" id="book_title"
                       class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700"
                       readonly>
            </div>

            <div class="mb-3">
                <label class="text-xs text-gray-400">Tanggal Pinjam</label>
                <input type="date" name="borrow_date" id="borrow_date"
                       class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700"
                       required>
            </div>

            <div class="mb-3">
                <label class="text-xs text-gray-400">Tanggal Kembali</label>
                <input type="date" name="return_date" id="return_date"
                       class="w-full p-2 rounded bg-slate-800 text-white border border-slate-700"
                       required>
            </div>

            <div class="flex gap-2">
                <button type="button"
                        onclick="closeModal()"
                        class="w-full py-2 rounded bg-gray-700 text-white">
                    Batal
                </button>

                <button type="submit"
                        class="w-full py-2 rounded bg-indigo-600 text-white font-semibold">
                    Pinjam
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
        }, 3000);
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

    // Reset value dulu
    borrowInput.value = '';
    returnInput.value = '';

    // Set ulang
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
        btn.innerText = 'Memproses...';
        btn.disabled = true;
    }
});

</script>
@endpush