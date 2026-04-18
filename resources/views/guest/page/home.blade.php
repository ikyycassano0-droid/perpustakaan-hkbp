@extends('guest.component.master')

@section('title', 'Ultra 3D Website')

@section('content')
<!-- HERO -->
<section class="text-center mt-40 px-6">
      <h2 class="text-5xl md:text-7xl font-bold fade-up depth-2">
        Perpustakaan Digital<br>AKPER HKBP Balige
    </h2>

    <p class="mt-6 text-gray-300 max-w-xl mx-auto fade-up depth-1">
        Menyediakan koleksi buku, jurnal, dan referensi ilmiah keperawatan yang terintegrasi dan mudah diakses kapan saja.
    </p>

    <div class="mt-10 fade-up">
        <button class="bg-indigo-500 px-8 py-3 rounded-full glow hover:scale-110 transition">
            Mulai Jelajah
        </button>
    </div>

    <!-- 3D CARD -->
    <div class="mt-20 flex justify-center">
        <div class="tilt glass p-8 rounded-3xl shadow-2xl float" id="tiltCard">
            
            <img src="https://images.unsplash.com/photo-1522542550221-31fd19575a2d"
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

    <div class="glass p-6 rounded-2xl fade-up hover:scale-110 transition">
        <h3 class="text-lg font-semibold mb-2">Real 3D Depth</h3>
        <p class="text-gray-400 text-sm">
            Multi-layer perspective and movement.
        </p>
    </div>

    <div class="glass p-6 rounded-2xl fade-up hover:scale-110 transition">
        <h3 class="text-lg font-semibold mb-2">Interactive UI</h3>
        <p class="text-gray-400 text-sm">
            Responds to cursor and scroll.
        </p>
    </div>

    <div class="glass p-6 rounded-2xl fade-up hover:scale-110 transition">
        <h3 class="text-lg font-semibold mb-2">Premium Design</h3>
        <p class="text-gray-400 text-sm">
            Inspired by top modern websites.
        </p>
    </div>

</section>

<!-- CTA -->
<section class="mt-40 text-center">
    <h2 class="text-4xl font-bold fade-up">
        Build Something Amazing
    </h2>

    <button class="mt-6 bg-indigo-500 px-8 py-3 rounded-full glow hover:scale-110 transition fade-up">
        Get Started
    </button>
</section>

<!-- PARALLAX SECTION -->
<!-- ===== PARALLAX SECTION YANG DIUBAH MENJADI CAROUSEL BUKU ===== -->
<section class="relative mt-40 h-[550px] overflow-hidden">
    <!-- Background layer -->
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/40 to-black/60"></div>
    
    <!-- Carousel Buku -->
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="book-carousel-full">
            <div class="book-carousel-track" id="bookTrack">
                <!-- Buku 1 -->
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?w=300&h=380&fit=crop" alt="Buku Keperawatan" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Fundamental Keperawatan Klinis</div>
                        <div class="book-author-large">Ns. Siti Aminah, M.Kep</div>
                    </div>
                </div>
                <!-- Buku 2 -->
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=300&h=380&fit=crop" alt="Buku Anatomi" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Anatomi Manusia Edisi X</div>
                        <div class="book-author-large">Prof. Dr. Budi Santoso</div>
                    </div>
                </div>
                <!-- Buku 3 -->
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=300&h=380&fit=crop" alt="Buku Farmakologi" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Farmakologi Dasar untuk Perawat</div>
                        <div class="book-author-large">apt. Dewi Lestari, M.Sc</div>
                    </div>
                </div>
                <!-- Buku 4 -->
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=300&h=380&fit=crop" alt="Buku Keperawatan Anak" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Keperawatan Anak Holistik</div>
                        <div class="book-author-large">Ns. Maya Sari, M.Kep</div>
                    </div>
                </div>
                <!-- Buku 5 -->
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1518779578993-ec3579fee39f?w=300&h=380&fit=crop" alt="Buku Medikal Bedah" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Keperawatan Medikal Bedah</div>
                        <div class="book-author-large">Ns. Rudi Hartono, M.Kep</div>
                    </div>
                </div>
                <!-- Buku 6 -->
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=300&h=380&fit=crop" alt="Buku Kesehatan Masyarakat" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Kesehatan Masyarakat</div>
                        <div class="book-author-large">Dr. Andi Pratama</div>
                    </div>
                </div>
                <!-- Buku 7 -->
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1532619187608-e5375cab36aa?w=300&h=380&fit=crop" alt="Buku Penelitian" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Metodologi Penelitian Kesehatan</div>
                        <div class="book-author-large">Dr. Rina Wijaya</div>
                    </div>
                </div>
                <!-- Buku 8 -->
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=300&h=380&fit=crop" alt="Buku Etika" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Etika Keperawatan Profesional</div>
                        <div class="book-author-large">Prof. Dr. Maria Ulfah</div>
                    </div>
                </div>
                <!-- Duplikasi untuk efek infinite scroll -->
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?w=300&h=380&fit=crop" alt="Buku Keperawatan" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Fundamental Keperawatan Klinis</div>
                        <div class="book-author-large">Ns. Siti Aminah, M.Kep</div>
                    </div>
                </div>
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=300&h=380&fit=crop" alt="Buku Anatomi" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Anatomi Manusia Edisi X</div>
                        <div class="book-author-large">Prof. Dr. Budi Santoso</div>
                    </div>
                </div>
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=300&h=380&fit=crop" alt="Buku Farmakologi" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Farmakologi Dasar untuk Perawat</div>
                        <div class="book-author-large">apt. Dewi Lestari, M.Sc</div>
                    </div>
                </div>
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=300&h=380&fit=crop" alt="Buku Keperawatan Anak" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Keperawatan Anak Holistik</div>
                        <div class="book-author-large">Ns. Maya Sari, M.Kep</div>
                    </div>
                </div>
                <div class="book-card-large">
                    <img src="https://images.unsplash.com/photo-1518779578993-ec3579fee39f?w=300&h=380&fit=crop" alt="Buku Medikal Bedah" class="book-cover-large">
                    <div class="book-info-overlay">
                        <div class="book-title-large">Keperawatan Medikal Bedah</div>
                        <div class="book-author-large">Ns. Rudi Hartono, M.Kep</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INTERACTIVE CARDS -->
<section class="mt-40 grid md:grid-cols-3 gap-10 px-10">

    <!-- Card -->
    <div class="tilt glass p-6 rounded-2xl card3d">
        <h3 class="text-lg font-semibold mb-2">Hover Me</h3>
        <p class="text-gray-400 text-sm">
            Card reacts with depth.
        </p>
    </div>

    <div class="tilt glass p-6 rounded-2xl card3d">
        <h3 class="text-lg font-semibold mb-2">Dynamic UI</h3>
        <p class="text-gray-400 text-sm">
            Smooth and responsive.
        </p>
    </div>

    <div class="tilt glass p-6 rounded-2xl card3d">
        <h3 class="text-lg font-semibold mb-2">Immersive</h3>
        <p class="text-gray-400 text-sm">
            Feels like a real app.
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