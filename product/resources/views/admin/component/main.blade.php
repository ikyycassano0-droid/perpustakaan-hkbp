<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        /* Sidebar - Soft Navy */
        .sidebar-dark {
            background: #0a0f1c;
            border-right: 1px solid #1e2a3a;
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
            /* Meningkatkan kualitas rendering gambar */
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            image-rendering: pixelated;
            /* Mencegah anti-aliasing berlebihan */
            transform: translateZ(0);
            backface-visibility: hidden;
        }

        /* Style untuk container logo dengan background */
        .logo-container {
            background: rgba(59, 130, 246, 0.1);
            border-radius: 14px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Style untuk teks logo alternatif (jika gambar tidak muncul) */
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
    </style>

    @stack('styles')
</head>
<body class="overflow-hidden bg-[#f7f9fc]">

    <div class="flex h-screen">
        <!-- SIDEBAR - NAVY ELEGANT -->
        <aside class="w-72 sidebar-dark flex-shrink-0 overflow-y-auto">
            <div class="p-6 border-b border-white/5">
                <div class="flex items-center gap-3">
                    <!-- LOGO GAMBAR - DENGAN UKURAN YANG OPTIMAL -->
                    @php
                        // Cek apakah file logo ada di storage
                        $logoPath = public_path('assets/img/logo akper.png');
                        $defaultLogo = 'data:image/svg+xml,' . urlencode('<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><text x="8" y="16" font-size="10" fill="#3b82f6" font-weight="bold">H</text></svg>');
                    @endphp

                    @if(file_exists($logoPath))
                        <img src="{{ asset('assets/img/logo akper.png') }}"
                             alt="Logo Perpustakaan HKBP"
                             class="logo-image"
                             loading="eager">
                    @else
                        <!-- Fallback jika logo tidak ditemukan - lebih jelas -->
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
                <!-- NAVIGASI UTAMA -->
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
                        <span>Sirkulasi & Peminjaman</span>
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

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden bg-[#f7f9fc]">
            <!-- NAVBAR CLEAN - Lebih premium -->
            <header class="navbar-clean px-8 py-4 flex justify-between items-center bg-white/80 backdrop-blur-sm sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <div class="lg:hidden">
                        <i class="fas fa-bars text-slate-500 text-xl cursor-pointer hover:text-indigo-600 transition"></i>
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

            <!-- PAGE CONTENT dengan padding lebih lega -->
            <main class="flex-1 overflow-y-auto p-8 lg:p-10">
                <div class="animate-fadeIn max-w-[1600px] mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js untuk dropdown interaktif -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
</body>
</html>
