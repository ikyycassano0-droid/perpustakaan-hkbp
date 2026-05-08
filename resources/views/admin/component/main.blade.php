<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Neptix Admin</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <!-- Google Fonts: Inter Only -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: #0f172a;
        }
        
        /* Sidebar - Solid Dark Elegant */
        .sidebar-dark {
            background: #0f172a;
            border-right: 1px solid #1e293b;
        }
        
        /* Navbar Clean */
        .navbar-clean {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }
        
        /* Card Modern */
        .card-modern {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .card-modern:hover {
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.08);
            border-color: #e2e8f0;
        }
        
        /* Menu Item Minimal */
        .menu-item-minimal {
            transition: all 0.2s ease;
            border-radius: 12px;
            color: #94a3b8;
        }
        
        .menu-item-minimal:hover {
            background: #1e293b;
            color: #ffffff;
        }
        
        .menu-item-minimal.active {
            background: #1e293b;
            color: #ffffff;
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
            border-radius: 10px;
            color: #94a3b8;
            font-size: 0.8rem;
        }
        
        .submenu-item:hover {
            background: #1e293b;
            color: #ffffff;
        }
        
        .submenu-item.active {
            background: #1e293b;
            color: #ffffff;
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
        
        /* Scrollbar Minimal */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
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
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out;
        }
        
        /* Badge Minimal */
        .badge-success {
            background: #dcfce7;
            color: #166534;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .badge-warning {
            background: #fef9c3;
            color: #854d0e;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    
    @stack('styles')
</head>
<body class="overflow-hidden bg-slate-50">

    <div class="flex h-screen">
        <!-- SIDEBAR - DARK ELEGANT -->
        <aside class="w-72 sidebar-dark flex-shrink-0 overflow-y-auto">
            <div class="p-6 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-500 flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-sm"></i>
                    </div>
                    <div>
                        <h1 class="text-white text-xl font-semibold tracking-tight">Neptix</h1>
                        <p class="text-slate-500 text-[11px]">Admin Dashboard</p>
                    </div>
                </div>
            </div>
            
            <div class="px-4 py-6">
                <!-- MAIN MENU -->
                <p class="text-slate-500 text-[10px] uppercase tracking-wider font-semibold mb-3 px-3">Main</p>
                <nav class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.home') }}" class="menu-item-minimal {{ request()->routeIs('admin.home') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-th-large w-4 text-sm"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Manajemen Anggota -->
                    <a href="{{ route('admin.members.index') }}" class="menu-item-minimal {{ request()->routeIs('admin.members.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-users w-4 text-sm"></i>
                        <span>Manajemen Anggota</span>
                    </a>

                    <!-- Profile Website -->
                    <a href="{{ route('admin.profile.index') }}" class="menu-item-minimal {{ request()->routeIs('admin.profile.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-globe w-4 text-sm"></i>
                        <span>Profile Website</span>
                    </a>

                    <!-- Berita (lengkap) -->
                    <a href="{{ route('admin.berita.index') }}" class="menu-item-minimal {{ request()->routeIs('admin.berita.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-newspaper w-4 text-sm"></i>
                        <span>Berita</span>
                    </a>

                    <!-- Koleksi (DROPDOWN dengan Submenu) -->
                    <div x-data="{ open: {{ request()->routeIs('admin.collections.*') || request()->routeIs('admin.koleksi_elektronik.*') ? 'true' : 'false' }} }" class="w-full">
                        <div @click="open = !open" class="menu-item-minimal flex items-center justify-between px-4 py-2.5 text-sm font-medium cursor-pointer {{ (request()->routeIs('admin.collections.*') || request()->routeIs('admin.koleksi_elektronik.*')) ? 'active' : '' }}">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-book w-4 text-sm"></i>
                                <span>Koleksi</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs transition-transform" :class="open ? 'rotate-90' : ''"></i>
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
                    <a href="{{ route('admin.orders.index') }}"class="menu-item-minimal {{ request()->is('admin/orders*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-hand-holding-heart w-4 text-sm"></i>
                        <span>Peminjaman</span>
                    </a>

                    <!-- Analytics -->
                    <a href="#" class="menu-item-minimal {{ request()->routeIs('admin.analytics') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-chart-bar w-4 text-sm"></i>
                        <span>Analytics</span>
                    </a>

                    <!-- Projects -->
                    <a href="{{ route('admin.panduan.index') }}" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-folder w-4 text-sm"></i>
                        <span>Panduan</span>
                    </a>

                     <a href="{{ route('admin.waktu_layanan.index') }}" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-folder w-4 text-sm"></i>
                        <span>Waktu Layanan</span>
                    </a>

                    <a href="{{ route('admin.kti.index') }}" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-folder w-4 text-sm"></i>
                        <span>KTI</span>
                    </a>
                </nav>
                
                <!-- MANAGEMENT MENU -->
                <p class="text-slate-500 text-[10px] uppercase tracking-wider font-semibold mt-6 mb-3 px-3">Management</p>
                <nav class="space-y-1">
                    <a href="#" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-shopping-cart w-4 text-sm"></i>
                        <span>Orders</span>
                        <span class="ml-auto bg-slate-800 text-slate-300 text-[10px] px-2 py-0.5 rounded-full">12</span>
                    </a>
                    <a href="#" class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium">
                        <i class="fas fa-tag w-4 text-sm"></i>
                        <span>Products</span>
                    </a><form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="menu-item-minimal flex items-center gap-3 px-4 py-2.5 text-sm font-medium w-full text-left">
                            <i class="fas fa-sign-out-alt w-4 text-sm"></i>
                            <span>Logout</span>
                        </button>
                        </form>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden bg-slate-50">
            <!-- NAVBAR CLEAN -->
            <header class="navbar-clean px-8 py-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="lg:hidden">
                        <i class="fas fa-bars text-slate-600 text-xl cursor-pointer"></i>
                    </div>
                    <div class="relative hidden md:block">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Search..." class="pl-9 pr-4 py-2 rounded-xl border border-slate-200 w-72 focus:outline-none focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition text-sm bg-slate-50">
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <div class="relative">
                        <i class="far fa-bell text-slate-500 text-lg cursor-pointer hover:text-indigo-600 transition"></i>
                        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-indigo-500 rounded-full text-white text-[8px] flex items-center justify-center">3</span>
                    </div>
                    <div class="flex items-center gap-3 cursor-pointer group">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-slate-700">Alex Devara</p>
                            <p class="text-[11px] text-slate-400">Administrator</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?background=3b82f6&color=fff&bold=true&size=40&name=AD" class="w-9 h-9 rounded-xl border border-slate-200 group-hover:border-indigo-300 transition">
                    </div>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-8">
                <div class="animate-fadeIn">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js untuk dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
</body>
</html>