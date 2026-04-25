<!-- NAVBAR MODERN FUTURISTIC -->
<header class="fixed top-0 left-0 w-full z-[999] px-6 py-4">
    <div class="navbar-container flex items-center justify-between">
        
        <!-- LOGO SECTION -->
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-400/30">
                <img src="{{ asset('assets/img/logo akper.png') }}" 
                    alt="Logo AKPER"
                    class="w-7 h-7 object-contain">
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
                    <li>
                        <a href="{{ route('guest.profile.visi-misi') }}" class="dropdown-item-modern">
                            Visi Misi
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('guest.profile.kerjasama') }}" class="dropdown-item-modern">
                            Kerjasama
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('guest.profile.struktur') }}" class="dropdown-item-modern">
                            Struktur
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('guest.profile.tugas-fungsi') }}" class="dropdown-item-modern">
                            Tugas & Fungsi
                        </a>
                    </li>
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

            <!-- KOLEKSI DROPDOWN (Dengan Submenu) -->
            <li class="dropdown-modern nav-item-modern">
                <button class="flex items-center gap-1 px-3 py-2">
                    Koleksi <svg class="chevron w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <ul class="dropdown-menu-modern" style="min-width: 240px;">
                    
                    <!-- KOLEKSI TERCETAK (dengan submenu ke samping) -->
                    <li class="submenu-modern">
                        <a href="#" class="dropdown-item-modern flex justify-between items-center">
                             Koleksi Tercetak <span class="text-indigo-400 text-xs">▶</span>
                        </a>
                        <ul class="submenu-menu-modern">
                            <li><a href="#" class="dropdown-item-modern">Jurnal</a></li>
                            <li><a href="#" class="dropdown-item-modern">Buku Pengayaan</a></li>
                            <li><a href="#" class="dropdown-item-modern">Buku Referensi</a></li>
                            <li><a href="#" class="dropdown-item-modern">Majalah</a></li>
                            <li><a href="#" class="dropdown-item-modern">Skripsi/Tesis</a></li>
                        </ul>
                    </li>
                    
                    <!-- KOLEKSI ELEKTRONIK (dengan submenu ke samping) -->
                    <li class="submenu-modern">
                        <a href="#" class="dropdown-item-modern flex justify-between items-center">
                             Koleksi Elektronik <span class="text-indigo-400 text-xs">▶</span>
                        </a>
                        <ul class="submenu-menu-modern">
                            <li><a href="#" class="dropdown-item-modern">E-book</a></li>
                            <li><a href="#" class="dropdown-item-modern">E-article</a></li>
                            <li><a href="#" class="dropdown-item-modern">CD/DVD</a></li>
                            <li><a href="#" class="dropdown-item-modern">Video Edukasi</a></li>
                            <li><a href="#" class="dropdown-item-modern">KTI Digital</a></li>
                            <li><a href="#" class="dropdown-item-modern">Jurnal Online</a></li>
                        </ul>
                    </li>
                    
                </ul>
            </li>

            <!-- BERITA -->
            <li class="nav-item-modern">
                <a href="{{ route('guest.berita.index') }}" class="px-3 py-2 block">Berita</a>
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

        <!-- LOGIN BUTTON & MOBILE MENU -->
        <div class="flex items-center gap-3">
            <button onclick="window.location.href='{{ route('login') }}'" class="btn-login-modern">
                <span class="hidden sm:inline"></span> Login
            </button>
            <div class="mobile-menu-btn" id="mobileMenuBtn">
                <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </div>
        </div>
    </div>
</header>