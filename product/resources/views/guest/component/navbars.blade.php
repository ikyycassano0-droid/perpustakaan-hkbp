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
            <li>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') || request()->is('/') ? 'active' : '' }}">Home</a>
            </li>

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

            <li>
                <a href="{{ url('/berita') }}" class="{{ request()->is('berita*') ? 'active' : '' }}">Berita</a>
            </li>

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
