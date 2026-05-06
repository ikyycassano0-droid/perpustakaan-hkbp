@extends('guest.component.master')

@section('title', 'Beranda - AKPER HKBP Balige')

@push('styles')
<style>
    /* ============================================
       CSS KHUSUS UNTUK HALAMAN HOME
       Hanya CSS yang BELUM ADA di master blade
    ============================================ */

    /* Carousel Buku */
    .book-carousel-section {
        position: relative;
        width: 100%;
        overflow: hidden;
        padding: 40px 0;
        margin-top: 40px;
    }

    .book-carousel-container {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .book-carousel-track {
        display: flex;
        gap: 30px;
        width: max-content;
        animation: scrollBooksRight 35s linear infinite;
    }

    .book-carousel-track:hover {
        animation-play-state: paused;
    }

    @keyframes scrollBooksRight {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    /* Card Buku */
    .book-card-medium {
        width: 220px;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(99, 102, 241, 0.35);
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        flex-shrink: 0;
        position: relative;
    }

    .book-card-medium:hover {
        transform: translateY(-10px) scale(1.03);
        border-color: rgba(99, 102, 241, 0.8);
        box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.4);
    }

    .book-cover-medium {
        width: 100%;
        height: 280px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .book-card-medium:hover .book-cover-medium {
        transform: scale(1.05);
    }

    .book-info-overlay-medium {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 14px 12px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.95), rgba(0, 0, 0, 0.7), transparent);
        transform: translateY(100%);
        transition: transform 0.35s ease;
    }

    .book-card-medium:hover .book-info-overlay-medium {
        transform: translateY(0);
    }

    .book-title-medium {
        font-weight: 700;
        font-size: 0.85rem;
        color: white;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .book-author-medium {
        font-size: 0.65rem;
        color: #cbd5e1;
    }

    /* Section background carousel */
    .carousel-bg-section {
        position: relative;
        margin-top: 60px;
        margin-bottom: 60px;
        padding: 50px 0;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(139, 92, 246, 0.03));
        border-top: 1px solid rgba(99, 102, 241, 0.2);
        border-bottom: 1px solid rgba(99, 102, 241, 0.2);
    }

    .carousel-title-section {
        text-align: center;
        margin-bottom: 40px;
    }

    .carousel-title-section h2 {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #ffffff, #c7d2fe);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    .carousel-title-section p {
        color: #94a3b8;
        margin-top: 8px;
        font-size: 0.9rem;
    }

    /* Cart & Modal styles */
    #cart {
        transition: transform 0.3s ease;
    }

    /* Responsif untuk mobile */
    @media (max-width: 768px) {
        .book-card-medium {
            width: 180px;
        }
        .book-cover-medium {
            height: 230px;
        }
        .book-carousel-track {
            gap: 20px;
        }
    }
</style>
@endpush

@section('content')
<!-- HERO -->
<!-- HERO -->
<section class="text-center mt-40 px-6">
      <h2 class="text-5xl md:text-7xl font-bold fade-up depth-2">
        Perpustakaan Digital<br>AKPER HKBP Balige
    </h2>

    <p class="mt-6 text-gray-300 max-w-xl mx-auto fade-up depth-1">
        Menyediakan koleksi buku, jurnal, dan referensi ilmiah keperawatan yang terintegrasi dan mudah diakses kapan saja.
    </p>

    <div class="mt-10 fade-up">
    <div class="max-w-3xl mx-auto">
        <form action="{{ route('guest.global_search') }}" method="GET" class="relative">
            <div class="relative flex items-center">
                <!-- Input Search -->
                <input type="text" name="keyword"
                    class="w-full px-6 py-4 pl-14 pr-32 rounded-full bg-white/10 backdrop-blur-sm border border-indigo-500/30 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/50 text-white placeholder-gray-400 transition-all duration-300"
                    placeholder="Cari judul buku, penulis, atau kata kunci...">

                <!-- Ikon Search di Kiri -->
                <div class="absolute left-5 top-1/2 transform -translate-y-1/2 text-indigo-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Tombol Cari di Kanan -->
                <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-1.5 rounded-full text-sm font-medium transition-all duration-300 shadow-md hover:shadow-lg">
                    Cari
                </button>
            </div>
        </form>
    </div>
</div>

    <!-- 3D CARD -->
    <div class="mt-20 flex justify-center">
        <div class="tilt glass p-8 rounded-3xl shadow-2xl float" id="tiltCard">
            <img src="assets/img/gedung.png" alt="Gambar Perpustakaan"
                 class="rounded-2xl w-[600px] max-w-full depth-3">

        </div>
    </div>
</section>

<!-- FLOATING ELEMENTS -->
<div class="absolute top-40 left-10 text-indigo-400 float">✦</div>
<div class="absolute top-60 right-20 text-indigo-300 float">✧</div>
<div class="absolute bottom-40 left-20 text-indigo-500 float">✦</div>

<!-- FEATURES -->
<section class="mt-40 grid md:grid-cols-3 gap-10 px-10 text-center">

    <a href="{{ route('guest.profile.visi-misi') }}" class="block">
    <div class="glass p-6 rounded-2xl fade-up hover:scale-110 transition">
        <h3 class="text-lg font-semibold mb-2">Visi & Misi</h3>
        <p class="text-gray-400 text-sm">
            Arah dan tujuan pengembangan perpustakaan.
        </p>
    </div>

    <a href="{{ route('guest.profile.struktur') }}" class="block">
    <div class="glass p-6 rounded-2xl fade-up hover:scale-110 transition">
        <h3 class="text-lg font-semibold mb-2">Struktur Organisasi</h3>
        <p class="text-gray-400 text-sm">
            Informasi pengurus dan peran dalam organisasi.
        </p>
    </div>

    <a href="{{ route('guest.berita.index') }}" class="block">
    <div class="glass p-6 rounded-2xl fade-up hover:scale-110 transition">
        <h3 class="text-lg font-semibold mb-2">Berita</h3>
        <p class="text-gray-400 text-sm">
            Update kegiatan dan informasi terbaru.
        </p>
    </div>

</section>

<!-- CTA -->
<section class="mt-40 text-center">
    <a href="{{ route('final_project.koleksi', 'ebook') }}" class="block">
    <h2 class="text-4xl font-bold fade-up">
        Pusat Literasi dan Referensi Terpercaya
    </h2>
</a>

    <button class="mt-6 bg-indigo-500 px-8 py-3 rounded-full glow hover:scale-110 transition fade-up">
        Mulai Membaca
    </button>
</section>

<!-- PARALLAX SECTION -->
<!-- ===== PARALLAX SECTION YANG DIUBAH MENJADI CAROUSEL BUKU ===== -->
<!-- CAROUSEL BUKU SECTION -->
<div class="carousel-bg-section">
    <div class="carousel-title-section">
        <h2>📚 Koleksi Buku Unggulan</h2>
        <p>Rekomendasi buku terpopuler di perpustakaan digital kami</p>
    </div>

    <div class="book-carousel-container">
        <div class="book-carousel-track">
            <!-- Buku 1 -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/EGC Malpraktik dalam keperawatan.jpg') }}" alt="Buku Keperawatan" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Malpraktik+Keperawatan'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Malpraktik dalam Keperawatan</div>
                    <div class="book-author-medium">Ns. Siti Aminah, M.Kep</div>
                </div>
            </div>
            <!-- Buku 2 -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/Noltes The Human Brain_ An Introduction to its Functional Anatomy.jpg') }}" alt="Buku Anatomi" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Anatomi+Otak'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Nolte's The Human Brain</div>
                    <div class="book-author-medium">Prof. Dr. Budi Santoso</div>
                </div>
            </div>
            <!-- Buku 3 -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/[TERBARU] Original Farmakologi dan Terapi Ed 6 UI FKUI 2017.jpg') }}" alt="Buku Farmakologi" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Farmakologi+dan+Terapi'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Farmakologi dan Terapi</div>
                    <div class="book-author-medium">apt. Dewi Lestari, M.Sc</div>
                </div>
            </div>
            <!-- Buku 4 -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/Ilmu Dasar Keperawatan Anak.jpg') }}" alt="Buku Keperawatan Anak" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Keperawatan+Anak'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Ilmu Dasar Keperawatan Anak</div>
                    <div class="book-author-medium">Ns. Maya Sari, M.Kep</div>
                </div>
            </div>
            <!-- Buku 5 -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/Deepublish - Buku Buku Ajar Keperawatan Medikal Bedah Sistem Persyarafan - Buku Keperawatan.jpg') }}" alt="Buku Medikal Bedah" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Keperawatan+Medikal+Bedah'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Keperawatan Medikal Bedah</div>
                    <div class="book-author-medium">Ns. Rudi Hartono, M.Kep</div>
                </div>
            </div>
            <!-- Buku 6 -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/Buku Pendidikan dan Promosi Kesehatan - Original.jpg') }}" alt="Buku Kesehatan Masyarakat" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Pendidikan+Kesehatan'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Pendidikan & Promosi Kesehatan</div>
                    <div class="book-author-medium">Dr. Andi Pratama</div>
                </div>
            </div>
            <!-- Buku 7 -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/EGC Metodologi Penelitian Kedokteran dan Kesehatan.jpg') }}" alt="Buku Penelitian" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Metodologi+Penelitian'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Metodologi Penelitian Kesehatan</div>
                    <div class="book-author-medium">Dr. Rina Wijaya</div>
                </div>
            </div>
            <!-- Buku 8 -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/EGC Malpraktik dalam keperawatan.jpg') }}" alt="Buku Etika" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Etika+Keperawatan'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Etika Keperawatan Profesional</div>
                    <div class="book-author-medium">Prof. Dr. Maria Ulfah</div>
                </div>
            </div>

            <!-- DUPLIKASI UNTUK EFEK INFINITE SCROLL -->
            <!-- Buku 2 duplicate -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/Noltes The Human Brain_ An Introduction to its Functional Anatomy.jpg') }}" alt="Buku Anatomi" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Anatomi+Otak'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Nolte's The Human Brain</div>
                    <div class="book-author-medium">Prof. Dr. Budi Santoso</div>
                </div>
            </div>
            <!-- Buku 3 duplicate -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/[TERBARU] Original Farmakologi dan Terapi Ed 6 UI FKUI 2017.jpg') }}" alt="Buku Farmakologi" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Farmakologi+dan+Terapi'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Farmakologi dan Terapi</div>
                    <div class="book-author-medium">apt. Dewi Lestari, M.Sc</div>
                </div>
            </div>
            <!-- Buku 4 duplicate -->
            <div class="book-card-medium">
                <img src="{{ asset('assets/img/Ilmu Dasar Keperawatan Anak.jpg') }}" alt="Buku Keperawatan Anak" class="book-cover-medium" onerror="this.src='https://placehold.co/220x280/1e293b/6366f1?text=Keperawatan+Anak'">
                <div class="book-info-overlay-medium">
                    <div class="book-title-medium">Ilmu Dasar Keperawatan Anak</div>
                    <div class="book-author-medium">Ns. Maya Sari, M.Kep</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- INTERACTIVE CARDS -->
<section class="mt-40 grid md:grid-cols-3 gap-10 px-10">

    <!-- Card -->
    <a href="{{ route('user.pinjam') }}" class="block">
    <div class="tilt glass p-6 rounded-2xl card3d">
        <h3 class="text-lg font-semibold mb-2">Layanan Pinjam Buku</h3>
        <p class="text-gray-400 text-sm">
            Nikmati kemudahan layanan Pinjam Balik secara mandiri melalui sistem informasi kami.
        </p>
    </div>

    <a href="#">
    <div class="tilt glass p-6 rounded-2xl card3d">
        <h3 class="text-lg font-semibold mb-2">Waktu Layanan</h3>
        <p class="text-gray-400 text-sm">
            Cek jadwal operasional perpustakaan dan batas waktu peminjaman buku untuk kenyamanan Anda.
        </p>
    </div>

    <a href="{{ route('panduan') }}" class="block">
    <div class="tilt glass p-6 rounded-2xl card3d">
        <h3 class="text-lg font-semibold mb-2">Panduan Pustaka</h3>
        <p class="text-gray-400 text-sm">
            Bingung cara mencari buku atau akses jurnal? Pelajari panduan penggunaan fitur website di sini.
        </p>
    </div>

</section>

<!-- PRODUCT SHOWCASE -->
<section class="mt-40 px-10">

    <h2 class="text-4xl font-bold text-center mb-16 fade-up">
        Featured Product
    </h2>

    <div class="grid md:grid-cols-2 gap-16 items-center">

        <!-- TEXT -->
        <div class="fade-up">
            <h3 class="text-3xl font-semibold mb-4">
                Ultra Smart Device
            </h3>

            <p class="text-gray-400 mb-6">
                Designed with cutting-edge technology and futuristic aesthetics.
                Built to deliver performance, style, and innovation.
            </p>

            <ul class="space-y-3 text-gray-300">
                <li>✔ AI Powered</li>
                <li>✔ Ultra Fast Processing</li>
                <li>✔ Premium Material</li>
            </ul>

            <button class="magnetic mt-8 bg-indigo-500 px-6 py-3 rounded-full glow">
                Buy Now
            </button>
        </div>

        <!-- IMAGE -->
        <div class="tilt glass p-6 rounded-3xl shadow-2xl float">
            <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8"
                 class="rounded-2xl depth-3 w-full">
        </div>

    </div>

</section>
<!-- PRODUCT GRID -->
<section class="mt-40 px-10">

    <h2 class="text-3xl font-bold text-center mb-12 fade-up">
        Our Products
    </h2>

    <div class="grid md:grid-cols-3 gap-8">

        <!-- CARD -->
        <div class="card3d glass p-6 rounded-2xl text-center fade-up">
            <img src="https://images.unsplash.com/photo-1518770660439-4636190af475"
                 class="rounded-xl mb-4">
            <h3 class="font-semibold">Product One</h3>
            <p class="text-gray-400 text-sm mb-4">Minimal & powerful</p>
            <button class="magnetic bg-indigo-500 px-4 py-2 rounded-full">
                Buy
            </button>
        </div>

        <div class="card3d glass p-6 rounded-2xl text-center fade-up">
            <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8"
                 class="rounded-xl mb-4">
            <h3 class="font-semibold">Product Two</h3>
            <p class="text-gray-400 text-sm mb-4">Elegant design</p>
            <button class="magnetic bg-indigo-500 px-4 py-2 rounded-full">
                Buy
            </button>
        </div>

        <div class="card3d glass p-6 rounded-2xl text-center fade-up">
            <img src="https://images.unsplash.com/photo-1492724441997-5dc865305da7"
                 class="rounded-xl mb-4">
            <h3 class="font-semibold">Product Three</h3>
            <p class="text-gray-400 text-sm mb-4">Future ready</p>
            <button class="magnetic bg-indigo-500 px-4 py-2 rounded-full">
                Buy
            </button>
        </div>

    </div>

</section>
<!-- TESTIMONIAL -->
<section class="mt-40 px-10 text-center">

    <h2 class="text-3xl font-bold mb-12 fade-up">
        What People Say
    </h2>

    <div class="grid md:grid-cols-3 gap-8">

        <div class="glass p-6 rounded-2xl fade-up">
            <p class="text-gray-400 mb-4">
                “This product changed my workflow completely.”
            </p>
            <h4 class="font-semibold">Alex</h4>
        </div>

        <div class="glass p-6 rounded-2xl fade-up">
            <p class="text-gray-400 mb-4">
                “Feels like using something from the future.”
            </p>
            <h4 class="font-semibold">Sarah</h4>
        </div>

        <div class="glass p-6 rounded-2xl fade-up">
            <p class="text-gray-400 mb-4">
                “Premium quality and amazing performance.”
            </p>
            <h4 class="font-semibold">John</h4>
        </div>

    </div>

</section>
<!-- PRICING -->
<section class="mt-40 px-10 text-center">

    <h2 class="text-3xl font-bold mb-12 fade-up">
        Pricing Plan
    </h2>

    <div class="grid md:grid-cols-3 gap-8">

        <div class="glass p-8 rounded-2xl fade-up">
            <h3 class="text-xl mb-4">Basic</h3>
            <p class="text-4xl font-bold mb-4">$29</p>
            <button class="magnetic bg-indigo-500 px-6 py-2 rounded-full">
                Choose
            </button>
        </div>

        <div class="glass p-8 rounded-2xl glow fade-up">
            <h3 class="text-xl mb-4">Pro</h3>
            <p class="text-4xl font-bold mb-4">$59</p>
            <button class="magnetic bg-indigo-500 px-6 py-2 rounded-full">
                Choose
            </button>
        </div>

        <div class="glass p-8 rounded-2xl fade-up">
            <h3 class="text-xl mb-4">Enterprise</h3>
            <p class="text-4xl font-bold mb-4">$99</p>
            <button class="magnetic bg-indigo-500 px-6 py-2 rounded-full">
                Choose
            </button>
        </div>

    </div>
    <br>
    <br>
    <br>
<!-- PRODUCT MODAL -->
<div id="productModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-[9999]">

    <div class="glass p-8 rounded-3xl max-w-lg w-full relative">

        <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-xl">
            ✕
        </button>

        <img id="modalImg" class="rounded-xl mb-4">

        <h3 id="modalTitle" class="text-xl font-semibold mb-2"></h3>
        <p id="modalDesc" class="text-gray-400 mb-4"></p>

        <button class="magnetic bg-indigo-500 px-6 py-2 rounded-full w-full">
            Add to Cart
        </button>

    </div>

</div>
<!-- UPDATE PRODUCT CARD -->
<div class="card3d glass p-10 rounded-2xl text-center fade-up">

    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085"
         class="rounded-xl mb-4 cursor-pointer"
         onclick="openModal(this)">

    <!-- JUDUL DIBESARKAN -->
<h2 class="font-semibold text-2xl tracking-wide"></h2>
    <!-- DESKRIPSI DIBESARKAN -->
     <h3 class="font-semibold text-lg mb-15 leading-relaxed">Minimal & powerful</h3>
    <div class="flex justify-center gap-3">

        <!-- TEKS BUTTON DIBESARKAN -->
        <button class="magnetic bg-indigo-500 px-4 py-2 rounded-full text-base">
            Buy
        </button>

        <button onclick="toggleWishlist(this)" class="text-xl">
            🤍
        </button>

    </div>
</div>

<!-- FILTER -->
<div class="flex justify-center gap-4 mt-10">

    <button onclick="filterProducts('all')" class="magnetic px-4 py-2 glass rounded-full">
        All
    </button>

    <button onclick="filterProducts('tech')" class="magnetic px-4 py-2 glass rounded-full">
        Tech
    </button>

    <button onclick="filterProducts('design')" class="magnetic px-4 py-2 glass rounded-full">
        Design
    </button>

</div>
<!-- CART -->
<div id="cart" class="fixed top-0 right-0 w-80 h-full bg-black/90 p-6 hidden z-[9999]">

    <h2 class="text-xl mb-4">Cart</h2>

    <div id="cartItems" class="space-y-3"></div>

    <div class="mt-6">
        <button class="bg-indigo-500 w-full py-2 rounded-full">
            Checkout
        </button>
    </div>

</div>

<button onclick="toggleCart()" class="fixed bottom-6 right-6 bg-indigo-500 p-4 rounded-full glow">
    🛒
</button>
</section>

<!-- FINAL CTA -->
<section class="mt-32 mb-32 text-center px-6">

    <h3 class="text-4xl md:text-5xl font-bold fade-up leading-tight mb-8">
        Ready to Experience the Future?
    </h3>

    <button onclick="openStartForm()"
        class="magnetic bg-indigo-500 px-8 py-3 rounded-full glow hover:scale-105 transition">
        Get Started
    </button>

</section>
@endsection

@push('scripts')
<script>
// ==========================
// JAVASCRIPT KHUSUS UNTUK HALAMAN HOME
// ==========================

// Cart functions
function toggleCart() {
    const cart = document.getElementById('cart');
    if (cart.classList.contains('hidden')) {
        cart.classList.remove('hidden');
    } else {
        cart.classList.add('hidden');
    }
}

function openStartForm() {
    showNotif('Fitur segera hadir!', 'success');
}

function toggleWishlist(btn) {
    if (btn.innerHTML === '🤍') {
        btn.innerHTML = '❤️';
        showNotif('Ditambahkan ke wishlist', 'success');
    } else {
        btn.innerHTML = '🤍';
        showNotif('Dihapus dari wishlist', 'warning');
    }
}

function openModal(imgElement) {
    alert('Detail produk akan segera hadir');
}

function closeModal() {
    // Fungsi untuk menutup modal
}

function filterProducts(category) {
    showNotif(`Menampilkan produk kategori: ${category}`, 'success');
}

console.log('Halaman Home siap dengan carousel buku dan efek 3D!');
</script>
@endpush
