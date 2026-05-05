
<!-- NAVBAR MODERN FUTURISTIC (SEMUA RUTE SUDAH DIPERBAIKI) -->
<header class="fixed top-0 left-0 w-full z-[999] px-6 py-4">
    <div class="navbar-container flex items-center justify-between">

        <!-- LOGO SECTION -->
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-400/30">
                <img src="{{ asset('assets/img/logo akper.png') }}" alt="Logo AKPER" class="w-7 h-7 object-contain">
            </div>
            <div>
                <span class="nav-logo">AKPER HKBP</span>
                <div class="text-[10px] text-indigo-300/60 tracking-wider">BALIGE</div>
            </div>
        </div>

        <!-- DESKTOP MENU -->
        <ul class="desktop-menu flex items-center gap-1 lg:gap-2">
            <!-- HOME -->
            <li class="nav-item-modern">
                <a href="{{ route('home') }}" class="px-3 py-2 block">Home</a>
            </li>

            <!-- PROFILE DROPDOWN -->
            <li class="dropdown-modern nav-item-modern">
                <button class="flex items-center gap-1 px-3 py-2">
                    Profile
                    <svg class="chevron w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul class="dropdown-menu-modern">
                    <li><a href="{{ route('user.profile.visi_misi') }}" class="dropdown-item-modern">Visi Misi</a></li>
                    <li><a href="{{ route('user.profile.kerjasama') }}" class="dropdown-item-modern">Kerjasama</a></li>
                    <li><a href="{{ route('user.profile.struktur') }}" class="dropdown-item-modern">Struktur</a></li>
                    <li><a href="{{ route('user.profile.tugas_fungsi') }}" class="dropdown-item-modern">Tugas & Fungsi</a></li>
                </ul>
            </li>

            <!-- LAYANAN DROPDOWN -->
            <li class="dropdown-modern nav-item-modern">
                <button class="flex items-center gap-1 px-3 py-2">
                    Layanan <svg class="chevron w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <ul class="dropdown-menu-modern">
                    <li><a href="{{ route('guest.layanan.show', 'pinjam_buku') }}" class="dropdown-item-modern">Pinjam Buku</a></li>
                    <li><a href="{{ route('guest.layanan.show', 'upload_ta') }}" class="dropdown-item-modern">Upload TA</a></li>
                    <li><a href="{{ route('guest.layanan.show', 'waktu_layanan') }}" class="dropdown-item-modern">Waktu Layanan</a></li>
                </ul>
            </li>

            <!-- KOLEKSI DROPDOWN (Rute koleksi elektronik diperbaiki) -->
            <li class="dropdown-modern nav-item-modern">
                <button class="flex items-center gap-1 px-3 py-2">
                    Koleksi <svg class="chevron w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <ul class="dropdown-menu-modern" style="min-width: 240px;">
                    <!-- Koleksi Tercetak -->
                    <li class="submenu-modern">
                        <a href="#" class="dropdown-item-modern flex justify-between items-center">
                            Koleksi Tercetak <span class="text-indigo-400 text-xs">▶</span>
                        </a>
                        <ul class="submenu-menu-modern">
                            <li><a href="{{ route('user.koleksi.jurnal') }}" class="dropdown-item-modern">Jurnal</a></li>
                            <li><a href="{{ route('user.koleksi.buku_pengayaan') }}" class="dropdown-item-modern">Buku Pengayaan</a></li>
                            <li><a href="{{ route('user.koleksi.buku_referensi') }}" class="dropdown-item-modern">Buku Referensi</a></li>
                            <li><a href="{{ route('user.koleksi.majalah') }}" class="dropdown-item-modern">Majalah</a></li>
                            <li><a href="{{ route('final_project.kti') }}" class="dropdown-item-modern">Skripsi/Tesis</a></li>
                        </ul>
                    </li>
                    <!-- Koleksi Elektronik (perbaikan: pakai final_project.koleksi) -->
                    <li class="submenu-modern">
                        <a href="#" class="dropdown-item-modern flex justify-between items-center">
                            Koleksi Elektronik <span class="text-indigo-400 text-xs">▶</span>
                        </a>
                        <ul class="submenu-menu-modern">
                            <li><a href="{{ route('final_project.koleksi', 'ebook') }}" class="dropdown-item-modern">E-book</a></li>
                            <li><a href="{{ route('final_project.koleksi', 'e-article') }}" class="dropdown-item-modern">E-article</a></li>
                            <li><a href="{{ route('final_project.koleksi', 'cd') }}" class="dropdown-item-modern">CD/DVD</a></li>
                            <li><a href="{{ route('final_project.koleksi', 'video') }}" class="dropdown-item-modern">Video Edukasi</a></li>
                            <li><a href="{{ route('final_project.kti') }}" class="dropdown-item-modern">KTI Digital</a></li>
                            <li><a href="#" class="dropdown-item-modern">Jurnal Online</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <!-- BERITA -->
            <li class="nav-item-modern">
                <a href="{{ route('user.berita') }}" class="px-3 py-2 block">Berita</a>
            </li>

            <!-- INFORMASI DROPDOWN -->
            <li class="dropdown-modern nav-item-modern">
                <button class="flex items-center gap-1 px-3 py-2">
                    Informasi <svg class="chevron w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <ul class="dropdown-menu-modern">
                    <li><a href="#" class="dropdown-item-modern">Panduan</a></li>
                </ul>
            </li>
        </ul>

        <!-- AREA LOGIN / PROFIL + MOBILE MENU BUTTON -->
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('profile.menu') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-300 group">
                    <svg class="w-5 h-5 text-indigo-300 group-hover:text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-sm font-medium text-indigo-200 truncate max-w-[120px]">
                        {{ Auth::user()->name }}
                    </span>
                </a>
            @else
                <button onclick="window.location.href='{{ route('login') }}'" class="btn-login-modern">
                    <span class="hidden sm:inline">Login</span>
                </button>
            @endauth

            <div class="mobile-menu-btn" id="mobileMenuBtn">
                <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </div>
        </div>
    </div>
</header>

<!-- FORM LOGOUT TERSEMBUNYI (POST + CSRF) -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- CSS DAN SCRIPT (tambahan) -->
@push('styles')
<style>
    /* ===== DROPDOWN & SUBMENU STYLES ===== */
    .dropdown-modern { position: relative; }
    .dropdown-modern .dropdown-menu-modern {
        position: absolute; top: 100%; left: 0;
        background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(12px);
        border-radius: 1rem; border: 1px solid rgba(99, 102, 241, 0.4);
        padding: 0.5rem 0; min-width: 180px;
        opacity: 0; visibility: hidden; transform: translateY(-10px);
        transition: all 0.2s ease; z-index: 1000;
    }
    .dropdown-modern:hover .dropdown-menu-modern {
        opacity: 1; visibility: visible; transform: translateY(0);
    }
    .dropdown-item-modern {
        display: block; padding: 0.5rem 1.2rem;
        color: #c7d2fe; transition: all 0.2s; font-size: 0.9rem;
    }
    .dropdown-item-modern:hover { background: rgba(99, 102, 241, 0.3); color: white; }
    .submenu-modern { position: relative; }
    .submenu-menu-modern {
        position: absolute; left: 100%; top: 0;
        background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(12px);
        border-radius: 1rem; border: 1px solid rgba(99, 102, 241, 0.4);
        padding: 0.5rem 0; min-width: 180px;
        opacity: 0; visibility: hidden; transform: translateX(-10px);
        transition: all 0.2s ease; z-index: 1001;
    }
    .submenu-modern:hover .submenu-menu-modern {
        opacity: 1; visibility: visible; transform: translateX(0);
    }
    .glass-card {
        background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px);
        border: 1px solid rgba(99, 102, 241, 0.3); border-radius: 1rem;
    }
    .btn-outline {
        background: transparent; border: 1px solid #6366f1;
        color: #c7d2fe; padding: 0.5rem 1rem; border-radius: 0.75rem;
        transition: all 0.2s;
    }
    .btn-outline:hover { background: rgba(99, 102, 241, 0.2); }
    .btn-login-modern {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 0.5rem 1.2rem; border-radius: 2rem; color: white;
        font-weight: 500; transition: all 0.2s; border: none; cursor: pointer;
    }
    .btn-login-modern:hover { transform: scale(1.02); box-shadow: 0 0 10px rgba(99, 102, 241, 0.5); }
    .nav-item-modern a, .nav-item-modern button {
        color: #c7d2fe; font-weight: 500; transition: all 0.2s;
        background: transparent; border: none;
    }
    .nav-item-modern:hover a, .nav-item-modern:hover button { color: white; text-shadow: 0 0 5px #6366f1; }
    .mobile-menu-btn { display: none; cursor: pointer; }
    @media (max-width: 1024px) {
        .desktop-menu { display: none; }
        .mobile-menu-btn { display: block; }
    }
</style>
@endpush

@push('scripts')
<script>
    window.logout = function() {
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            document.getElementById('logout-form').submit();
        }
    };
</script>
@endpush
