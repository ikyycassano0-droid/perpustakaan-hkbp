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
            <li><a href="{{ route('user.dashboard') }}">Home</a></li>
            <li>
                <a href="#">Profile <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('user.profile.visi_misi') }}">Visi Misi</a></li>
                    <li><a href="{{ route('user.profile.kerjasama') }}">Kerjasama</a></li>
                    <li><a href="{{ route('user.profile.struktur') }}">Struktur Pengurus</a></li>
                    <li><a href="{{ route('user.profile.tugas_fungsi') }}">Tugas, Fungsi, Tujuan</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Layanan <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('user.pinbal.index') }}">Pinjam Buku</a></li>
                    <li><a href="{{ route('user.waktu.layanan') }}">Waktu Layanan</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Koleksi Tercetak <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('user.koleksi.jurnal') }}">Jurnal</a></li>
                    <li><a href="{{ route('user.koleksi.buku_pengayaan') }}">Buku Pengayaan</a></li>
                    <li><a href="{{ route('user.koleksi.buku_referensi') }}">Buku Referensi</a></li>
                    <li><a href="{{ route('user.koleksi.majalah') }}">Majalah</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Koleksi Elektronik <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('guest.koleksi_elektronik.ebook') }}">E-book</a></li>
                    <li><a href="{{ route('guest.koleksi_elektronik.earticle') }}">E-article</a></li>
                    <li><a href="{{ route('guest.koleksi_elektronik.cd') }}">CD</a></li>
                    <li><a href="{{ route('guest.koleksi_elektronik.video') }}">Video</a></li>
                    <li><a href="{{ route('final_project.kti') }}">KTI Digital</a></li>
                </ul>
            </li>
            <li><a href="{{ route('user.berita') }}">Berita</a></li>
            <li>
                <a href="#">Informasi <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('panduan') }}">Panduan</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    @auth
        <a href="{{ route('profile.menu') }}" class="login-btn" style="background-color: #1a6b47; color:white;">
            <i class="fas fa-user-circle"></i> {{ session('user')['name'] ?? 'Profil' }}
        </a>
    @else
        <a href="{{ route('login') }}" class="login-btn"><i class="fas fa-sign-in-alt"></i> LOGIN</a>
    @endauth
</header>

<style>
    /* =============== NAVBAR STYLE (PUTIH) =============== */
    header {
        background-color: #ffffff;
        color: var(--text-dark);
        padding: 0.8rem 3%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 12px rgba(15, 74, 49, 0.10);
        position: sticky;
        top: 0;
        z-index: 1000;
        border-bottom: 2px solid #e6f0ea;
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-img {
        width: 50px;
        height: 50px;
        background-color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .logo-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .logo-text h1 {
        font-size: 0.95rem;
        font-weight: 700;
        text-transform: uppercase;
        line-height: 1.2;
        color: var(--text-dark);
    }

    .logo-text span {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    nav ul {
        list-style: none;
        display: flex;
        gap: 5px;
    }

    nav ul li {
        position: relative;
    }

    nav ul li a {
        padding: 10px 12px;
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        transition: 0.3s;
        color: var(--text-dark);
    }

    nav ul li a:hover,
    nav ul li > a.active {
        color: var(--primary-color);
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #ffffff;
        min-width: 220px;
        box-shadow: 0 8px 20px rgba(15, 74, 49, 0.12);
        border-radius: 8px;
        display: none;
        z-index: 100;
        border-top: 3px solid var(--accent-green);
    }

    .dropdown-menu li {
        width: 100%;
    }

    .dropdown-menu li a {
        color: var(--text-dark) !important;
        padding: 10px 15px;
        border-bottom: 1px solid #f0f5f2;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .dropdown-menu li a:hover {
        background-color: #f0f9f4;
        color: var(--primary-color) !important;
        padding-left: 20px;
    }

    nav ul li:hover > .dropdown-menu {
        display: block;
    }

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

    @media (max-width: 1100px) {
        nav ul {
            gap: 2px;
        }
        nav ul li a {
            font-size: 0.75rem;
            padding: 10px 8px;
        }
    }
    @media (max-width: 800px) {
        nav {
            overflow-x: auto;
            white-space: nowrap;
        }
        nav ul {
            display: inline-flex;
        }
        .logo-text h1 {
            font-size: 0.8rem;
        }
    }
</style>
