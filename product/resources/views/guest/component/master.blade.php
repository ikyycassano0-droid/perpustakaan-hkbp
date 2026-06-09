{{-- master.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan Sekolah Keperawatan HKBP')</title>

    {{-- CSS Libraries --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Custom CSS --}}
    <style>
        /* ============================================
           PALET WARNA — REFERENSI GAMBAR
           - Navbar    : putih / #ffffff
           - Primary   : hijau teal  #1a6b47
           - Secondary : hijau gelap #0f4a31
           - Accent    : hijau muda  #2daa6e
           - Navy text : #0d2137
           - BG utama  : #f4f7f5
           - BG card   : #ffffff
        ============================================ */

        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DM Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f7f5;
            color: #0d2137;
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* CSS Variables */
        :root {
            --primary-color: #1a6b47;
            --secondary-color: #1f7d54;
            --deep-green: #0f4a31;
            --accent-green: #2daa6e;
            --green: #2daa6e;
            --accent-yellow: #f1c40f;
            --text-dark: #0d2137;
            --text-muted: #5a7060;
            --text-light: #ffffff;
            --dark: #0d2137;
            --light-bg: #f4f7f5;
            --card-bg: #ffffff;
            --border-color: #d4e5d9;
            --teal: #1a6b47;
            --teal-light: #2daa6e;
            --blue-gradient-top: #1f7d54;
            --blue-gradient-bottom: #0f4a31;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        /* ===========================
           HEADER / NAVBAR — PUTIH
        =========================== */
        header {
            background-color: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            color: var(--text-dark);
            padding: 0.6rem 3%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-img {
            width: 45px;
            height: 45px;
            background-color: var(--primary-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .logo-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        .logo-text h1 {
            font-size: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.2;
            color: var(--text-dark);
            letter-spacing: -0.3px;
        }

        .logo-text span {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 8px;
        }

        nav ul li {
            position: relative;
        }

        nav ul li a {
            padding: 8px 14px;
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.2s;
            color: var(--text-dark);
            border-radius: 30px;
        }

        nav ul li a:hover,
        nav ul li > a.active {
            color: var(--primary-color);
            background-color: rgba(26, 107, 71, 0.08);
        }

        /* CSS untuk indikator active yang lebih jelas */
        nav ul li a.active {
            color: var(--primary-color);
            background-color: rgba(26, 107, 71, 0.12);
            font-weight: 700;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            min-width: 220px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            display: none;
            z-index: 100;
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 8px 0;
        }

        .dropdown-menu li {
            width: 100%;
        }

        .dropdown-menu li a {
            color: var(--text-dark) !important;
            padding: 10px 18px;
            border-bottom: none;
            font-weight: 500;
            font-size: 0.8rem;
            border-radius: 0;
        }

        .dropdown-menu li a:hover {
            background-color: rgba(26, 107, 71, 0.08);
            color: var(--primary-color) !important;
            padding-left: 24px;
        }

        nav ul li:hover > .dropdown-menu {
            display: block;
        }

        /* LOGIN BUTTON — Hijau solid */
        .login-btn {
            background-color: var(--primary-color);
            color: #fff !important;
            padding: 9px 22px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            border: 2px solid var(--primary-color);
        }

        .login-btn:hover {
            background-color: var(--deep-green);
            border-color: var(--deep-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 74, 49, 0.25);
        }

        /* FOOTER — Hijau gelap */
        footer {
            background: linear-gradient(135deg, var(--deep-green) 0%, #0a3b2a 100%);
            color: rgba(220, 240, 230, 0.9);
            padding: 3rem 5% 1.5rem;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            border-top: 5px solid var(--accent-green);
            box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.05);
        }

        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 2.5rem;
        }

        .footer-col h4 {
            color: #ffffff;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--accent-green);
            padding-left: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            position: relative;
        }

        .footer-col h4::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--accent-green);
            border-radius: 2px;
        }

        .footer-col ul {
            list-style: none;
            padding-left: 0;
        }

        .footer-col ul li {
            margin-bottom: 12px;
            transition: transform 0.2s ease;
        }

        .footer-col ul li:hover {
            transform: translateX(5px);
        }

        .footer-col ul li a {
            color: rgba(210, 235, 220, 0.85);
            transition: 0.25s;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .footer-col ul li a i {
            font-size: 0.7rem;
            color: var(--accent-green);
            transition: 0.2s;
        }

        .footer-col ul li a:hover {
            color: white;
            text-shadow: 0 0 2px rgba(255,255,255,0.3);
        }

        .footer-col ul li a:hover i {
            transform: translateX(3px);
            color: #f1c40f;
        }

        .footer-col p {
            font-size: 0.88rem;
            line-height: 1.7;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .footer-col p i {
            width: 20px;
            color: var(--accent-green);
            font-size: 1rem;
        }

        .social-links {
            display: flex;
            gap: 20px;
            margin-top: 0.5rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: #e0f0e5;
            font-size: 1.2rem;
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-links a:hover {
            background: var(--accent-green);
            color: var(--deep-green);
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .copyright {
            text-align: center;
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 0.85rem;
        }

        .copyright p {
            margin: 5px 0;
        }

        .copyright .tagline {
            font-size: 0.8rem;
            color: var(--accent-green);
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .footer-content {
                gap: 2rem;
                text-align: center;
            }
            .footer-col h4 {
                text-align: center;
                border-left: none;
                border-bottom: 2px solid var(--accent-green);
                padding-left: 0;
                padding-bottom: 8px;
                display: inline-block;
            }
            .footer-col h4::after {
                display: none;
            }
            .footer-col p {
                justify-content: center;
            }
            .social-links {
                justify-content: center;
            }
            .footer-col ul li {
                text-align: center;
            }
            .footer-col ul li a {
                justify-content: center;
            }

            .social-links {
                display: flex;
                gap: 24px;
                margin-top: 0.5rem;
            }

            .social-links a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 42px;
                height: 42px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                color: #e0f0e5;
                font-size: 1.3rem;
                transition: all 0.3s;
                text-decoration: none;
            }

            .social-links a:not(:last-child) {
                margin-right: 4px;
            }
        }

        @media (max-width: 1100px) {
            nav ul {
                gap: 2px;
            }

            nav ul li a {
                font-size: 0.75rem;
                padding: 10px 8px;
            }
        }

        @media (max-width: 640px) {
            .koleksi-mini-grid {
                grid-template-columns: 1fr;
            }

            .koleksi-unggulan-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Header --}}
    <header>
        <div class="logo-container">
            <div class="logo-img">
                <img src="{{ asset('assets/img/logo akper.png') }}" alt="Logo Perpustakaan AKPER HKBP">
            </div>
            <div class="logo-text">
                <h1>Perpustakaan AKPER HKBP</h1>
                <span>Sekolah Keperawatan HKBP Balige</span>
            </div>
        </div>
        <nav>
            <ul>
                {{-- MENU HOME dengan active class yang diperbaiki --}}
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') || request()->is('/') ? 'active' : '' }}">Home</a></li>
                <li>
                    <a href="#" class="{{ request()->routeIs('guest.profile.*') ? 'active' : '' }}">Profile <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('guest.profile.visi-misi') }}">Visi Misi</a></li>
                        <li><a href="{{ route('guest.profile.kerjasama') }}">Kerjasama</a></li>
                        <li><a href="{{ route('guest.profile.struktur') }}">Struktur Pengurus</a></li>
                        <li><a href="{{ route('guest.profile.tugas-fungsi') }}">Tugas, Fungsi, Tujuan</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('waktu.layanan') }}" class="{{ request()->routeIs('waktu.layanan') ? 'active' : '' }}">Layanan <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('waktu.layanan') }}">Waktu Layanan</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="{{ request()->routeIs('guest.koleksi_elektronik.*') ? 'active' : '' }}">Koleksi Elektronik <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('guest.koleksi_elektronik.ebook') }}">E-book</a></li>
                        <li><a href="{{ route('guest.koleksi_elektronik.earticle') }}">E-article</a></li>
                        <li><a href="{{ route('guest.koleksi_elektronik.cd') }}">CD</a></li>
                        <li><a href="{{ route('guest.koleksi_elektronik.video') }}">Video</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/berita') }}" class="{{ request()->is('berita*') ? 'active' : '' }}">Berita</a></li>
                <li>
                    <a href="#" class="{{ request()->routeIs('panduan') ? 'active' : '' }}">Informasi <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('panduan') }}">Panduan</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <a href="{{ route('login') }}" class="login-btn"><i class="fas fa-sign-in-alt"></i> LOGIN</a>
    </header>

    @include('guest.component.navbars')
    {{-- Hero Section (optional, bisa diisi oleh child) --}}
    @yield('hero')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer>
        <div class="footer-content">
            <div class="footer-col" data-aos="fade-right" data-aos-delay="200">
                <h4>Sekolah Keperawatan HKBP Balige</h4>
                <p><i class="fas fa-map-marker-alt"></i> Kompleks HKBP, Jl. Keperawatan No. 1<br>Sumatera Utara, Indonesia.</p>
                <p><i class="fas fa-phone-alt"></i> (061) 1234567</p>
                <p><i class="fas fa-envelope"></i> library@akperhkbp.ac.id</p>
            </div>
            <div class="footer-col" data-aos="fade-up" data-aos-delay="400">
                <h4>Sumber Daya</h4>
                <ul>
                    {{-- Jurnal Keperawatan (butuh login) --}}
                    <li><a href="{{ route('user.koleksi.jurnal') }}"><i class="fas fa-chevron-right"></i> Jurnal Keperawatan</a></li>
                    {{-- Panduan Sitasi APA (butuh login) --}}
                    <li><a href="{{ route('user.panduan') }}"><i class="fas fa-chevron-right"></i> Panduan Sitasi APA</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Cek Kemiripan Teks</a></li>
                    {{-- Koleksi Tugas Akhir (butuh login) --}}
                    <li><a href="{{ route('final_project.kti') }}"><i class="fas fa-chevron-right"></i> Koleksi Tugas Akhir</a></li>
                </ul>
            </div>
            <div class="footer-col" data-aos="fade-left" data-aos-delay="600">
                <h4>Akses Cepat</h4>
                <ul>
                    <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Pendaftaran Anggota</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Bebas Pustaka</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Usulan Buku Baru</a></li>
                    <li><a href="{{ route('guest.profile.kerjasama') }}"><i class="fas fa-chevron-right"></i> Hubungi Pustakawan</a></li>
                </ul>
            </div>
            <div class="footer-col" data-aos="fade-left" data-aos-delay="600">
                <h4>Ikuti Kami</h4>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
                <p style="margin-top: 20px; font-size: 0.85rem;">Temukan informasi terbaru dan kegiatan perpustakaan di media sosial kami.</p>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; {{ date('Y') }} Perpustakaan Sekolah Keperawatan HKBP. All Rights Reserved.</p>
            <p class="tagline">Melayani untuk Generasi Sehat dan Berilmu</p>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Search Function (global, jika ada form dengan class search-container)
        function handleSearch(event) {
            event.preventDefault();
            const input = document.querySelector('.search-container input');
            if (input && input.value.trim() === "") {
                alert("Mohon masukkan kata kunci!");
            } else if (input) {
                alert("Mencari: " + input.value);
            }
        }

        // Testimonial Slider (jika ada elemen terkait)
        let currentTranslate = 0;
        let slider = null;

        function initTestimonialSlider() {
            slider = document.getElementById('testimonialSlider');
            if (!slider) return;
            const containerBox = document.querySelector('.testimonial-container-box');
            if (!containerBox) return;
            const cards = document.querySelectorAll('.testimonial-card');
            if (cards.length === 0) return;
            const cardWidth = 380;
            const maxTranslate = (cards.length - Math.floor(containerBox.offsetWidth / cardWidth)) * cardWidth;
            window.moveSlide = function(direction) {
                currentTranslate -= (direction * cardWidth);
                if (currentTranslate > 0) currentTranslate = 0;
                if (Math.abs(currentTranslate) > maxTranslate) currentTranslate = -maxTranslate;
                slider.style.transform = `translateX(${currentTranslate}px)`;
            };
        }

        // Tilt Effect
        function initTiltEffect() {
            const newsCards = document.querySelectorAll('.tilt-effect');
            newsCards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const rotateX = ((y - rect.height / 2) / rect.height / 2) * -10;
                    const rotateY = ((x - rect.width / 2) / rect.width / 2) * 10;
                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg)`;
                });
            });
        }

        // Canvas Particle (untuk halaman yang memiliki #matrix-canvas-layanan)
        function initCanvasParticle() {
            const canvas = document.getElementById('matrix-canvas-layanan');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let particles = [];
            const mouse = { x: null, y: null, radius: 180 };

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = canvas.parentElement ? canvas.parentElement.offsetHeight : 400;
            }

            window.addEventListener('resize', () => {
                resizeCanvas();
            });

            window.addEventListener('mousemove', (e) => {
                const rect = canvas.getBoundingClientRect();
                mouse.x = e.clientX - rect.left;
                mouse.y = e.clientY - rect.top;
            });

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 2 + 1;
                    this.speedX = Math.random() * 1.5 - 0.75;
                    this.speedY = Math.random() * 1.5 - 0.75;
                    this.density = (Math.random() * 30) + 5;
                }
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    if (this.x > canvas.width || this.x < 0) this.speedX *= -1;
                    if (this.y > canvas.height || this.y < 0) this.speedY *= -1;
                    let dx = mouse.x - this.x;
                    let dy = mouse.y - this.y;
                    let distance = Math.sqrt(dx * dx + dy * dy);
                    if (distance < mouse.radius) {
                        let force = (mouse.radius - distance) / mouse.radius;
                        this.x -= (dx / distance) * force * this.density;
                        this.y -= (dy / distance) * force * this.density;
                    }
                }
                draw() {
                    ctx.fillStyle = 'rgba(26, 107, 71, 0.20)';
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            const vertices = [
                { x: -1, y: 0.618, z: 0 }, { x: 1, y: 0.618, z: 0 }, { x: -1, y: -0.618, z: 0 }, { x: 1, y: -0.618, z: 0 },
                { x: 0, y: -1, z: 0.618 }, { x: 0, y: 1, z: 0.618 }, { x: 0, y: -1, z: -0.618 }, { x: 0, y: 1, z: -0.618 },
                { x: 0.618, y: 0, z: -1 }, { x: 0.618, y: 0, z: 1 }, { x: -0.618, y: 0, z: -1 }, { x: -0.618, y: 0, z: 1 }
            ];

            const structs = [
                { posX: 0.15, posY: 0.25, size: 140, rotX: 0, rotY: 0, rotZ: 0, speedX: 0.005, speedY: 0.007 },
                { posX: 0.85, posY: 0.35, size: 170, rotX: 0, rotY: 0, rotZ: 0, speedX: -0.004, speedY: 0.006 },
                { posX: 0.20, posY: 0.80, size: 150, rotX: 0, rotY: 0, rotZ: 0, speedX: 0.006, speedY: -0.005 },
                { posX: 0.80, posY: 0.85, size: 160, rotX: 0, rotY: 0, rotZ: 0, speedX: -0.005, speedY: -0.004 }
            ];

            function rotate3D(v, rotX, rotY, rotZ) {
                let x = v.x, y = v.y, z = v.z;
                let cosX = Math.cos(rotX), sinX = Math.sin(rotX);
                let y1 = y * cosX - z * sinX;
                let z1 = y * sinX + z * cosX;
                let cosY = Math.cos(rotY), sinY = Math.sin(rotY);
                let x2 = x * cosY + z1 * sinY;
                let z2 = -x * sinY + z1 * cosY;
                let cosZ = Math.cos(rotZ), sinZ = Math.sin(rotZ);
                let x3 = x2 * cosZ - y1 * sinZ;
                let y3 = x2 * sinZ + y1 * cosZ;
                return { x: x3, y: y3, z: z2 };
            }

            function draw3DStructs() {
                structs.forEach(st => {
                    st.rotX += st.speedX;
                    st.rotY += st.speedY;
                    st.rotZ += 0.002;
                    const centerX = st.posX * canvas.width;
                    const centerY = st.posY * canvas.height;
                    const projected = vertices.map(v => {
                        let r = rotate3D(v, st.rotX, st.rotY, st.rotZ);
                        return { x: centerX + r.x * st.size, y: centerY + r.y * st.size };
                    });
                    ctx.beginPath();
                    ctx.strokeStyle = 'rgba(26, 107, 71, 0.30)';
                    ctx.lineWidth = 2;
                    for (let i = 0; i < projected.length; i++) {
                        for (let j = i + 1; j < projected.length; j++) {
                            let d = Math.hypot(vertices[i].x - vertices[j].x, vertices[i].y - vertices[j].y, vertices[i].z - vertices[j].z);
                            if (d < 1.5) {
                                ctx.moveTo(projected[i].x, projected[i].y);
                                ctx.lineTo(projected[j].x, projected[j].y);
                            }
                        }
                    }
                    ctx.stroke();
                });
            }

            function animate() {
                if (!canvas || !ctx) return;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                draw3DStructs();
                particles.forEach(p => {
                    p.update();
                    p.draw();
                });
                requestAnimationFrame(animate);
            }

            resizeCanvas();
            for (let i = 0; i < 90; i++) particles.push(new Particle());
            animate();
        }

        // Jalankan inisialisasi setelah DOM siap
        document.addEventListener('DOMContentLoaded', () => {
            initTestimonialSlider();
            initTiltEffect();
            initCanvasParticle();
        });
    </script>

    @stack('scripts')
</body>
</html>
