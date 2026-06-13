<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin') - Perpustakaan HKBP Balige</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f8fafc;
        }

        /* Sidebar - Soft Navy (Desktop) */
        .sidebar-dark {
            background: #0a0f1c;
            border-right: 1px solid #1e2a3a;
        }

        /* Mobile sidebar sebagai off-canvas */
        @media (max-width: 1023px) {
            .sidebar-mobile {
                position: fixed;
                top: 0;
                left: -100%;
                width: 280px;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease-in-out;
                overflow-y: auto;
                box-shadow: 2rem 0 2rem -1rem rgba(0,0,0,0.3);
            }
            .sidebar-mobile.open {
                left: 0;
            }
            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s;
            }
            .sidebar-overlay.open {
                opacity: 1;
                visibility: visible;
            }
            /* Sembunyikan sidebar desktop pada mobile */
            .sidebar-desktop {
                display: none;
            }
            /* Main content penuh */
            .main-content-full {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }

        /* Tampilkan sidebar desktop pada layar >= 1024px */
        @media (min-width: 1024px) {
            .sidebar-mobile, .sidebar-overlay {
                display: none;
            }
            .sidebar-desktop {
                display: block;
                width: 288px; /* w-72 = 18rem = 288px */
                flex-shrink: 0;
            }
            .main-content-with-sidebar {
                flex: 1;
                overflow: hidden;
            }
        }

        /* Navbar Clean */
        .navbar-clean {
            background: #ffffff;
            border-bottom: 1px solid #eef2f6;
        }

        /* Card Modern - Glassmorphism ringan */
        .card-modern {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #f0f2f5;
            transition: all 0.25s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03), 0 1px 1px rgba(0,0,0,0.02);
        }

        .card-modern:hover {
            box-shadow: 0 12px 28px -8px rgba(0,0,0,0.08);
            border-color: #e2e8f0;
            transform: translateY(-2px);
        }

        /* Menu Item - Lebih halus */
        .menu-item-minimal {
            transition: all 0.2s ease;
            border-radius: 14px;
            color: #9ca3af;
            font-weight: 450;
            letter-spacing: -0.01em;
        }

        .menu-item-minimal:hover {
            background: #111827;
            color: #f1f5f9;
        }

        .menu-item-minimal.active {
            background: #111827;
            color: white;
        }

        .menu-item-minimal.active i {
            color: #3b82f6;
        }

        /* Submenu styling */
        .submenu {
            margin-left: 28px;
            padding-left: 12px;
            border-left: 1px solid #1e293b;
        }

        .submenu-item {
            transition: all 0.2s ease;
            border-radius: 12px;
            color: #9ca3af;
            font-size: 0.8rem;
        }

        .submenu-item:hover {
            background: #111827;
            color: #f1f5f9;
        }

        .submenu-item.active {
            background: #111827;
            color: white;
        }

        .submenu-item.active i {
            color: #3b82f6;
        }

        /* Dropdown arrow rotation */
        .dropdown-toggle .dropdown-arrow {
            transition: transform 0.2s ease;
        }

        .dropdown-toggle.open .dropdown-arrow {
            transform: rotate(90deg);
        }

        /* Scrollbar - clean */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f0f2f5;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animasi Halus */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.35s ease-out;
        }

        /* Badge lebih refined */
        .badge-success {
            background: #e6f9ed;
            color: #0b5e2e;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: -0.2px;
        }

        .badge-warning {
            background: #fef6e0;
            color: #9b4a00;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-danger {
            background: #ffe6e5;
            color: #b91c1c;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            color: #1e293b;
        }

        /* Teks lebih tajam */
        h1, h2, h3, .font-semibold {
            letter-spacing: -0.02em;
        }

        /* Dashboard card number */
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.03em;
        }

        /* Logo Image Styling - OPTIMASI SUPER TAJAM */
        .logo-image {
            width: 48px;
            height: 48px;
            object-fit: contain;
            object-position: center;
            border-radius: 12px;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            image-rendering: pixelated;
            transform: translateZ(0);
            backface-visibility: hidden;
        }

        .logo-container {
            background: rgba(59, 130, 246, 0.1);
            border-radius: 14px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text-fallback {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
            box-shadow: 0 4px 10px rgba(59,130,246,0.3);
        }

        /* Tambahan untuk responsive input search */
        @media (max-width: 640px) {
            .navbar-clean .hidden.md\:block {
                display: none !important;
            }
            .px-8 {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .p-8 {
                padding: 1rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="overflow-hidden bg-[#f7f9fc]">

    <div class="flex h-screen relative">
        <!-- OVERLAY MOBILE (untuk menutup sidebar saat terbuka) -->
        <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>

        <!-- SIDEBAR VERSI MOBILE (off-canvas) -->
        <aside id="mobileSidebar" class="sidebar-mobile sidebar-dark flex-shrink-0 overflow-y-auto">
            <div class="p-6 border-b border-white/5">
                <div class="flex items-center gap-3">
                    @php
                        $logoPath = public_path('assets/img/logo akper.png');
                    @endphp

                    @if(file_exists($logoPath))
                        <img src="{{ asset('assets/img/logo akper.png') }}"
                             alt="Logo Perpustakaan HKBP"
                             class="logo-image"
                             loading="eager">
                    @else
                        <div class="w-[42px] h-[42px] rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                    @endif

                    <div>
                        <h1 class="text-white text-xl font-bold tracking-tight">Perpustakaan HKBP</h1>
                        <p class="text-slate-400 text-[11px] font-medium">Akademik Keperawatan</p>
                    </div>
                </div>
            </div>

            <div class="px-4 py-6">
                <p class="text-slate-500 text-[10px] uppercase tracking-wider font-bold mb-3 px-3">Menu Utama</p>
                <nav class="space-y-1.5">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.home') }}" class="menu-item-minimal {{ request()->routeIs('admin.home') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-th-large w-4 text-base"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Manajemen Anggota -->
                    <a href="{{ route('admin.members.index') }}" class="menu-item-minimal {{ request()->routeIs('admin.members.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-users w-4 text-base"></i>
                        <span>Manajemen Anggota</span>
                    </a>

                    <!-- Profile Website -->
                    <a href="{{ route('admin.profile.index') }}" class="menu-item-minimal {{ request()->routeIs('admin.profile.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-globe w-4 text-base"></i>
                        <span>Profil Website</span>
                    </a>

                    <!-- Berita -->
                    <a href="{{ route('admin.berita.index') }}" class="menu-item-minimal {{ request()->routeIs('admin.berita.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-newspaper w-4 text-base"></i>
                        <span>Kelola Berita</span>
                    </a>

                    <!-- Koleksi (DROPDOWN) -->
                    <div x-data="{ open: {{ request()->routeIs('admin.collections.*') || request()->routeIs('admin.koleksi_elektronik.*') ? 'true' : 'false' }} }" class="w-full">
                        <div @click="open = !open" class="menu-item-minimal flex items-center justify-between px-4 py-2.5 text-sm font-medium cursor-pointer {{ (request()->routeIs('admin.collections.*') || request()->routeIs('admin.koleksi_elektronik.*')) ? 'active' : '' }}">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-book w-4 text-base"></i>
                                <span>Koleksi Perpustakaan</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs transition-transform duration-200" :class="open ? 'rotate-90' : ''"></i>
                        </div>
                        <div x-show="open" x-transition class="submenu mt-1 space-y-1">
                            <a href="{{ route('admin.collections.index') }}" class="submenu-item flex items-center gap-3 px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.collections.*') ? 'active' : '' }}">
                                <i class="fas fa-book-open w-3 text-xs"></i>
                                <span>Koleksi Tercetak</span>
                            </a>
                            <a href="{{ route('admin.koleksi_elektronik.index') }}" class="submenu-item flex items-center gap-3 px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.koleksi_elektronik.*') ? 'active' : '' }}">
                                <i class="fas fa-laptop w-3 text-xs"></i>
                                <span>Koleksi Elektronik</span>
                            </a>
                        </div>
                    </div>

                    <!-- Peminjaman -->
                    <a href="{{ route('admin.orders.index') }}" class="menu-item-minimal {{ request()->is('admin/orders*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-hand-holding-heart w-4 text-base"></i>
                        <span>Peminjaman</span>
                    </a>

                    <!-- Panduan -->
                    <a href="{{ route('admin.panduan.index') }}" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-folder w-4 text-base"></i>
                        <span>Panduan</span>
                    </a>

                    <!-- Waktu Layanan -->
                    <a href="{{ route('admin.waktu_layanan.index') }}" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-clock w-4 text-base"></i>
                        <span>Jam Layanan</span>
                    </a>

                    <!-- KTI / Karya Ilmiah -->
                    <a href="{{ route('admin.kti.index') }}" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-file-alt w-4 text-base"></i>
                        <span>KTI / Skripsi</span>
                    </a>

                    <div class="pt-4 mt-2 border-t border-white/5">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium w-full text-left">
                                <i class="fas fa-sign-out-alt w-4 text-base"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- SIDEBAR VERSI DESKTOP (selalu tampil) -->
        <aside class="sidebar-desktop sidebar-dark flex-shrink-0 overflow-y-auto">
            <div class="p-6 border-b border-white/5">
                <div class="flex items-center gap-3">
                    @if(file_exists($logoPath))
                        <img src="{{ asset('assets/img/logo akper.png') }}"
                             alt="Logo Perpustakaan HKBP"
                             class="logo-image"
                             loading="eager">
                    @else
                        <div class="w-[42px] h-[42px] rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-sm">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                    @endif

                    <div>
                        <h1 class="text-white text-xl font-bold tracking-tight">Perpustakaan HKBP</h1>
                        <p class="text-slate-400 text-[11px] font-medium">Akademik Keperawatan</p>
                    </div>
                </div>
            </div>

            <div class="px-4 py-6">
                <p class="text-slate-500 text-[10px] uppercase tracking-wider font-bold mb-3 px-3">Menu Utama</p>
                <nav class="space-y-1.5">
                    <!-- Sama seperti di atas, duplikasi untuk desktop (atau bisa pakai include jika blade) -->
                    <a href="{{ route('admin.home') }}" class="menu-item-minimal {{ request()->routeIs('admin.home') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-th-large w-4 text-base"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="menu-item-minimal {{ request()->routeIs('admin.members.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-users w-4 text-base"></i>
                        <span>Manajemen Anggota</span>
                    </a>
                    <a href="{{ route('admin.profile.index') }}" class="menu-item-minimal {{ request()->routeIs('admin.profile.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-globe w-4 text-base"></i>
                        <span>Profil Website</span>
                    </a>
                    <a href="{{ route('admin.berita.index') }}" class="menu-item-minimal {{ request()->routeIs('admin.berita.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-newspaper w-4 text-base"></i>
                        <span>Kelola Berita</span>
                    </a>

                    <div x-data="{ open: {{ request()->routeIs('admin.collections.*') || request()->routeIs('admin.koleksi_elektronik.*') ? 'true' : 'false' }} }" class="w-full">
                        <div @click="open = !open" class="menu-item-minimal flex items-center justify-between px-4 py-2.5 text-sm font-medium cursor-pointer {{ (request()->routeIs('admin.collections.*') || request()->routeIs('admin.koleksi_elektronik.*')) ? 'active' : '' }}">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-book w-4 text-base"></i>
                                <span>Koleksi Perpustakaan</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs transition-transform duration-200" :class="open ? 'rotate-90' : ''"></i>
                        </div>
                        <div x-show="open" x-transition class="submenu mt-1 space-y-1">
                            <a href="{{ route('admin.collections.index') }}" class="submenu-item flex items-center gap-3 px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.collections.*') ? 'active' : '' }}">
                                <i class="fas fa-book-open w-3 text-xs"></i>
                                <span>Koleksi Tercetak</span>
                            </a>
                            <a href="{{ route('admin.koleksi_elektronik.index') }}" class="submenu-item flex items-center gap-3 px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.koleksi_elektronik.*') ? 'active' : '' }}">
                                <i class="fas fa-laptop w-3 text-xs"></i>
                                <span>Koleksi Elektronik</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.orders.index') }}" class="menu-item-minimal {{ request()->is('admin/orders*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-hand-holding-heart w-4 text-base"></i>
                        <span>Peminjaman</span>
                    </a>
                    <a href="{{ route('admin.panduan.index') }}" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-folder w-4 text-base"></i>
                        <span>Panduan</span>
                    </a>
                    <a href="{{ route('admin.waktu_layanan.index') }}" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-clock w-4 text-base"></i>
                        <span>Jam Layanan</span>
                    </a>
                    <a href="{{ route('admin.kti.index') }}" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-file-alt w-4 text-base"></i>
                        <span>KTI / Skripsi</span>
                    </a>

                    <div class="pt-4 mt-2 border-t border-white/5">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium w-full text-left">
                                <i class="fas fa-sign-out-alt w-4 text-base"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden bg-[#f7f9fc] main-content-with-sidebar">
            <!-- NAVBAR CLEAN - dengan tombol toggle mobile -->
            <header class="navbar-clean px-8 py-4 flex justify-between items-center bg-white/80 backdrop-blur-sm sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <!-- Tombol Hamburger untuk mobile -->
                    <div class="lg:hidden">
                        <button id="mobileMenuBtn" onclick="toggleMobileSidebar()" class="text-slate-500 text-xl hover:text-indigo-600 transition focus:outline-none">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    <div class="relative hidden md:block">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" placeholder="Cari anggota, buku, atau laporan..." class="pl-9 pr-4 py-2.5 rounded-full border border-slate-200 w-80 focus:outline-none focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 transition text-sm bg-slate-50">
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="relative">
                        <i class="far fa-bell text-slate-500 text-xl cursor-pointer hover:text-indigo-600 transition"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-indigo-500 rounded-full text-white text-[9px] flex items-center justify-center font-bold">3</span>
                    </div>
                    <div class="flex items-center gap-3 cursor-pointer group">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-800">Pustakawan Utama</p>
                            <p class="text-[11px] text-slate-500 font-medium">Administrator Sistem</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?background=1e293b&color=fff&bold=true&size=40&name=HKBP" class="w-10 h-10 rounded-full border-2 border-white shadow-sm group-hover:border-indigo-200 transition">
                    </div>
                </div>
            </header>

            <!-- PAGE CONTENT dengan padding responsif -->
            <main class="flex-1 overflow-y-auto p-5 md:p-8 lg:p-10">
                <div class="animate-fadeIn max-w-[1600px] mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js untuk dropdown interaktif -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Script untuk toggle mobile sidebar -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
            // Cegah scroll body saat sidebar terbuka
            if (sidebar.classList.contains('open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        // Tutup sidebar jika layar di-resize ke ukuran desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('mobileSidebar');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar.classList.contains('open')) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('open');
                    document.body.style.overflow = '';
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
