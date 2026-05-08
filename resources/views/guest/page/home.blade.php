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
            <h2 class="text-4xl font-bold fade-up">
                Pusat Literasi dan Referensi Terpercaya
            </h2>
            
            <a href="{{ route('final_project.koleksi', 'ebook') }}" class="block">
            <button class="mt-6 bg-indigo-500 px-8 py-3 rounded-full glow hover:scale-110 transition fade-up">
                Mulai Membaca
            </button>
            </a>
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
            </a>

        </section>

        <!-- PRODUCT SHOWCASE -->
        <section class="mt-40 px-10">
            <h2 class="text-4xl font-bold text-center mb-16 fade-up">
            Layanan Unggulan
            </h2>

            <div class="grid md:grid-cols-2 gap-16 items-center">
                <!-- TEXT -->
                <div class="fade-up">
                    <h3 class="text-3xl font-semibold mb-4">
                        Repository KTI & Digital Library
                    </h3>
                    <p class="text-gray-400 mb-6">
                        Akses khusus bagi civitas akademika AKPER HKBP Balige untuk mengeksplorasi Karya Tulis Ilmiah (KTI) alumni, hingga jurnal kesehatan dalam satu platform terintegrasi.
                    </p>

                    <ul class="space-y-3 text-gray-300">
                        <li>✔ Akses Full-Text KTI Alumni</li>
                        <li>✔ Koleksi Video Prosedur Keperawatan</li>
                        <li>✔ Unggah Mandiri Tugas Akhir (Upload KTI)</li>
                    </ul>
                    <a href="{{ route('final_project.kti') }}" class="block">
                        <button class="magnetic mt-8 bg-indigo-500 px-6 py-3 rounded-full glow">
                            Lihat Repository
                        </button>
                    </a>
                </div>

                <!-- IMAGE -->
                <div class="tilt glass p-6 rounded-3xl shadow-2xl float">
                    <img src="assets/img/KTII.png" alt="Gambar Repository"
                        class="rounded-2xl depth-3 w-full">
                </div>
            </div>
        </section>

        <!-- PRODUCT GRID -->
        <section class="mt-40 px-10">
    <h2 class="text-3xl font-bold text-center mb-12 fade-up">Jelajahi Koleksi</h2>
    <div class="grid md:grid-cols-3 gap-8">

        <a href="{{ route('final_project.koleksi', 'ebook') }}  " class="block">
        <div class="card3d glass p-6 rounded-2xl text-center fade-up hover:scale-105 transition">
        <div class="text-5xl mb-4">📖</div>
        <h3 class="font-semibold text-lg">E-Book</h3>
        <p class="text-gray-400 text-sm mt-2">Buku digital keperawatan siap dibaca kapan saja</p>
        </div></a>

        <a href="{{ route('final_project.koleksi', 'video') }}" class="block">
        <div class="card3d glass p-6 rounded-2xl text-center fade-up hover:scale-105 transition">
        <div class="text-5xl mb-4">🎬</div>
        <h3 class="font-semibold text-lg">Video Prosedur</h3>
        <p class="text-gray-400 text-sm mt-2">Tutorial prosedur keperawatan dalam format video</p>
        </div></a>

        <a href="{{ route('final_project.koleksi', 'e_article') }}" class="block">
        <div class="card3d glass p-6 rounded-2xl text-center fade-up hover:scale-105 transition">
        <div class="text-5xl mb-4">📄</div>
        <h3 class="font-semibold text-lg">Jurnal</h3>
        <p class="text-gray-400 text-sm mt-2">Artikel ilmiah dan jurnal kesehatan terkini</p>
        </div></a>

    </div>
    </section>
        <!-- TESTIMONIAL -->
        <section class="mt-40 px-10 text-center">

            <h2 class="text-3xl font-bold mb-12 fade-up">
                Kesan & Pesan Pemustaka
            </h2>

            <div class="grid md:grid-cols-3 gap-8">

                <div class="glass p-6 rounded-2xl fade-up">
                    <p class="text-gray-400 mb-4">
                        “Sangat membantu untuk mencari buku pengayaan dan referensi tugas akhir. Detail jurnal dan majalahnya juga sangat lengkap untuk riset saya.”
                    </p>
                    <h4 class="font-semibold">Alex, Mahasiswa IT</h4>
                </div>

                <div class="glass p-6 rounded-2xl fade-up">
                    <p class="text-gray-400 mb-4">
                        “Akses ke E-Book dan video tutorialnya sangat cepat. Belajar jadi lebih fleksibel karena bisa diakses kapan saja dan di mana saja.”
                    </p>
                    <h4 class="font-semibold">Kairi, Pengguna Digital</h4>
                </div>

                <div class="glass p-6 rounded-2xl fade-up">
                    <p class="text-gray-400 mb-4">
                        “Proses upload Tugas Akhir (TA) di sini sangat sistematis dan mudah diikuti. Fitur riwayat peminjaman juga membantu saya memantau pinjaman buku.”
                    </p>
                    <h4 class="font-semibold">John, Alumni</h4>
                </div>

            </div>

        </section>

        <!-- PRICING -->
        <section class="mt-40 px-10 text-center">

            <h2 class="text-3xl font-bold mb-12 fade-up">Perpustakaan dalam Angka</h2>
    <div class="grid md:grid-cols-3 gap-8">
        <div class="glass p-8 rounded-2xl fade-up">
        <h3 class="text-5xl font-bold text-indigo-400">1.200+</h3>
        <p class="mt-3 text-gray-300">Koleksi Buku Fisik</p>
        </div>
        <div class="glass p-8 rounded-2xl glow fade-up">
        <h3 class="text-5xl font-bold text-indigo-400">350+</h3>
        <p class="mt-3 text-gray-300">E-Book</p>
        </div>
        <div class="glass p-8 rounded-2xl fade-up">
        <h3 class="text-5xl font-bold text-indigo-400">500+</h3>
        <p class="mt-3 text-gray-300">KTI Alumni Tersedia</p>
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
        <div class="glass p-10 rounded-2xl text-center fade-up">

            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085"
                class="rounded-xl mb-4 cursor-pointer"
                onclick="openModal(this)">

            <!-- JUDUL DIBESARKAN -->
        <h2 class="font-semibold text-2xl tracking-wide"></h2>
            <!-- DESKRIPSI DIBESARKAN -->
            <h3 class="font-semibold text-lg mb-15 leading-relaxed">Gedung Perpustakaan AKPER HKBP Balige</h3>
            <p class="text-gray-400 text-sm mt-2 mb-4">
            Fasilitas modern yang mendukung kegiatan belajar dan riset civitas akademika.
            </p>
            <div class="flex justify-center gap-3">
        <a href="{{ route('guest.profile.tugas-fungsi') }}">
            <button class="magnetic bg-indigo-500 px-5 py-2 rounded-full text-sm">
                Tentang Kami
            </button>
        </a>
        <a href="{{ route('guest.profile.struktur') }}">
            <button class="magnetic bg-white/10 border border-indigo-400 px-5 py-2 rounded-full text-sm">
                Struktur Organisasi
            </button>
        </a>
    </div>
        </div>

    <!-- SCROLL TO TOP BUTTON -->
    <button id="scrollTopBtn" onclick="scrollToTop()"
        class="fixed bottom-6 right-6 opacity-0 pointer-events-none transition-all duration-300 z-[9999] group">
        <div class="relative flex items-center justify-center w-12 h-12">
            <!-- Ring animasi -->
            <span class="absolute inset-0 rounded-full bg-indigo-500/20 animate-ping"></span>
            <span class="absolute inset-0 rounded-full border border-indigo-400/40"></span>
            <!-- Tombol utama -->
            <span class="relative flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-indigo-600 to-violet-600 shadow-lg shadow-indigo-500/40 group-hover:shadow-indigo-500/70 group-hover:scale-110 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white group-hover:-translate-y-0.5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
                </svg>
            </span>
        </div>
    </button>

        <!-- FINAL CTA -->
        <section class="mt-32 mb-32 text-center px-6">
    <h3 class="text-4xl md:text-5xl font-bold fade-up leading-tight mb-4">
        Siap Mulai Membaca?
    </h3>
    <p class="text-gray-400 mb-8 fade-up">
        Login untuk akses penuh koleksi digital, pinjam buku, dan upload KTI Anda.
    </p>
    <div class="flex justify-center gap-4 flex-wrap fade-up">
        <a href="{{ route('login') }}">
        <button class="magnetic bg-indigo-500 px-8 py-3 rounded-full glow hover:scale-105 transition">
            Login Sekarang
        </button>
        </a>
        <a href="{{ route('panduan') }}">
        <button class="magnetic bg-white/10 border border-indigo-400 px-8 py-3 rounded-full hover:scale-105 transition">
            Lihat Panduan
        </button>
        </a>
    </div>
    </section>
        @endsection

        @push('scripts')
        <script>
        // ==========================
        // JAVASCRIPT KHUSUS UNTUK HALAMAN HOME
        // ==========================

        // Scroll to Top
    const scrollTopBtn = document.getElementById('scrollTopBtn');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.remove('opacity-0', 'pointer-events-none');
            scrollTopBtn.classList.add('opacity-100');
        } else {
            scrollTopBtn.classList.add('opacity-0', 'pointer-events-none');
            scrollTopBtn.classList.remove('opacity-100');
        }
    });

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

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
