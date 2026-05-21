<!-- NAVBAR MODERN FUTURISTIC -->
<header class="fixed top-0 left-0 w-full z-[999] px-6 py-4">
    <div class="navbar-container flex items-center justify-between">

        <!-- LOGO SECTION (tidak berubah) -->
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-400/30">
                <img src="{{ asset('assets/img/logo akper.png') }}"
                    alt="Logo AKPER"
                    class="w-14 h-14 object-contain">
                    <!-- Ubah w-7 h-7 menjadi w-14 h-14 di atas agar gambar membesar -->
            </div>
            <div>
                <span class="nav-logo">AKPER HKBP</span>
                <div class="text-[11px] text-indigo-300/60 tracking-wider">BALIGE</div>
            </div>
        </div>

        <!-- DESKTOP MENU (tidak berubah) -->
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
                    <li><a href="{{ route('guest.profile.visi-misi') }}" class="dropdown-item-modern">Visi Misi</a></li>
                    <li><a href="{{ route('guest.profile.kerjasama') }}" class="dropdown-item-modern">Kerjasama</a></li>
                    <li><a href="{{ route('guest.profile.struktur') }}" class="dropdown-item-modern">Struktur</a></li>
                    <li><a href="{{ route('guest.profile.tugas-fungsi') }}" class="dropdown-item-modern">Tugas & Fungsi</a></li>
                </ul>
            </li>

            <!-- LAYANAN DROPDOWN -->
            <li class="dropdown-modern nav-item-modern">
                <button class="flex items-center gap-1 px-3 py-2">
                    Layanan <svg class="chevron w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <ul class="dropdown-menu-modern">
                    <li><a href="{{ route('waktu.layanan') }}" class="dropdown-item-modern">Waktu Layanan</a></li>
                </ul>
            </li>

            <!-- KOLEKSI DROPDOWN (dengan submenu) -->
            <li class="dropdown-modern nav-item-modern">
                <button class="flex items-center gap-1 px-3 py-2">
                    Koleksi <svg class="chevron w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <ul class="dropdown-menu-modern" style="min-width: 240px;">
                    <li class="submenu-modern">
                        <a href="#" class="dropdown-item-modern flex justify-between items-center">
                            Koleksi Elektronik <span class="text-indigo-400 text-xs">▶</span>
                        </a>
                        <ul class="submenu-menu-modern">
                            <li><a href="{{ route('guest.koleksi_elektronik.ebook') }}" class="dropdown-item-modern">E-book</a></li>
                            <li><a href="{{ route('guest.koleksi_elektronik.earticle') }}" class="dropdown-item-modern">E-article</a></li>
                            <li><a href="{{ route('guest.koleksi_elektronik.cd') }}" class="dropdown-item-modern">CD/DVD</a></li>
                            <li><a href="{{ route('guest.koleksi_elektronik.video') }}" class="dropdown-item-modern">Video Edukasi</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <!-- BERITA -->
            <li class="nav-item-modern">
                <a href="{{ url('/berita') }}" class="px-3 py-2 block">Berita</a>
            </li>

            <!-- INFORMASI DROPDOWN -->
            <li class="dropdown-modern nav-item-modern">
                <button class="flex items-center gap-1 px-3 py-2">
                    Informasi <svg class="chevron w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <ul class="dropdown-menu-modern">
                    <li><a href="{{ route('panduan') }}" class="dropdown-item-modern">Panduan</a></li>
                </ul>
            </li>
        </ul>

        <!-- AREA LOGIN / PROFIL + MOBILE MENU BUTTON -->
        <div class="flex items-center gap-3">
            @auth
                <!-- Tampilkan ikon profil + nama user (bisa diklik ke halaman menu profil) -->
                <a href="{{ route('profile.menu') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-300 group">
                    <!-- Ikon Profil (siluet user) -->
                    <svg class="w-5 h-5 text-indigo-300 group-hover:text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <!-- Nama User -->
                    <span class="text-sm font-medium text-indigo-200 truncate max-w-[120px]">
                        {{ session('user')['name'] ?? '' }}
                    </span>
                </a>
            @else
                <!-- Tombol Login (jika belum login) -->
                <button onclick="window.location.href='{{ route('login') }}'" class="btn-login-modern">
                    <span class="hidden sm:inline">Login</span>
                </button>
            @endauth

            <!-- Mobile Menu Button (tetap) -->
            <div class="mobile-menu-btn" id="mobileMenuBtn">
                <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ktiMenu = document.getElementById("kti-menu");

    if (ktiMenu) {
        ktiMenu.addEventListener("click", function (e) {
            e.preventDefault();

            if (confirm("Silakan login terlebih dahulu untuk mengakses KTI Digital. Login sekarang?")) {
                window.location.href = "{{ route('login') }}";
            }
        });
    }
});
</script>
