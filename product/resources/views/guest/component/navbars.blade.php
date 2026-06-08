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
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li>
                <a href="#">Profile <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('guest.profile.visi-misi') }}">Visi Misi</a></li>
                    <li><a href="{{ route('guest.profile.kerjasama') }}">Kerjasama</a></li>
                    <li><a href="{{ route('guest.profile.struktur') }}">Struktur Pengurus</a></li>
                    <li><a href="{{ route('guest.profile.tugas-fungsi') }}">Tugas, Fungsi, Tujuan</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('waktu.layanan') }}">Layanan <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('waktu.layanan') }}">Waktu Layanan</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Koleksi Elektronik <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('guest.koleksi_elektronik.ebook') }}">E-book</a></li>
                    <li><a href="{{ route('guest.koleksi_elektronik.earticle') }}">E-article</a></li>
                    <li><a href="{{ route('guest.koleksi_elektronik.cd') }}">CD</a></li>
                    <li><a href="{{ route('guest.koleksi_elektronik.video') }}">Video</a></li>
                </ul>
            </li>
            <li><a href="{{ url('/berita') }}" class="{{ request()->is('berita*') ? 'active' : '' }}">Berita</a></li>
            <li>
                <a href="#">Informasi <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('panduan') }}">Panduan</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    @auth
        <a href="{{ route('profile.menu') }}" class="login-btn">
            <i class="fas fa-user-circle"></i> <span>{{ session('user')['name'] ?? 'Profil' }}</span>
        </a>
    @else
        <a href="{{ route('login') }}" class="login-btn">
            <i class="fas fa-sign-in-alt"></i> <span>LOGIN</span>
        </a>
    @endauth
</header>

<style>
    /* =============== NAVBAR STYLE (PUTIH) - MODERN & ELEGAN =============== */
    header {
        background-color: #ffffff;
        color: var(--text-dark);
        padding: 0.6rem 3%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 20px rgba(15, 74, 49, 0.08);
        position: sticky;
        top: 0;
        z-index: 1000;
        backdrop-filter: blur(0px);
        transition: all 0.3s ease;
    }

    /* Logo Container */
    .logo-container {
        display: flex;
        align-items: center;
        gap: 12px;
        transition: transform 0.2s ease;
    }
    .logo-container:hover {
        transform: scale(1.01);
    }

    .logo-img {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, var(--primary-color), var(--deep-green));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: box-shadow 0.3s;
    }
    .logo-img:hover {
        box-shadow: 0 4px 12px rgba(26, 107, 71, 0.2);
    }
    .logo-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .logo-text h1 {
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        line-height: 1.2;
        color: var(--text-dark);
        margin-bottom: 2px;
    }
    .logo-text span {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Navigasi */
    nav ul {
        list-style: none;
        display: flex;
        gap: 8px;
        margin: 0;
        padding: 0;
    }

    nav ul li {
        position: relative;
    }

    nav ul li a {
        padding: 10px 14px;
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.25s ease;
        color: var(--text-dark);
        border-radius: 40px;
        letter-spacing: 0.3px;
    }

    /* Hover efek */
    nav ul li a:hover {
        color: var(--primary-color);
        background-color: rgba(26, 107, 71, 0.06);
        transform: translateY(-1px);
    }

    /* Active menu - underline stylized */
    nav ul li a.active {
        color: var(--primary-color);
        background-color: rgba(26, 107, 71, 0.08);
        position: relative;
    }
    nav ul li a.active::after {
        content: '';
        position: absolute;
        bottom: 6px;
        left: 50%;
        transform: translateX(-50%);
        width: 24px;
        height: 3px;
        background: var(--accent-green);
        border-radius: 4px;
        transition: width 0.2s;
    }
    nav ul li a.active:hover::after {
        width: 32px;
    }

    /* Dropdown modern */
    .dropdown-menu {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        background: #ffffff;
        min-width: 230px;
        box-shadow: 0 15px 30px rgba(15, 74, 49, 0.12);
        border-radius: 16px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-12px);
        transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        z-index: 100;
        border: 1px solid #eef3ef;
        backdrop-filter: blur(0px);
        padding: 8px 0;
    }

    nav ul li:hover > .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
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
        transition: all 0.2s;
        background: transparent;
        border-radius: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .dropdown-menu li a i {
        font-size: 0.75rem;
        color: var(--accent-green);
        width: 18px;
        transition: transform 0.2s;
    }
    .dropdown-menu li a:hover {
        background-color: #f0f9f4;
        color: var(--primary-color) !important;
        padding-left: 24px;
    }
    .dropdown-menu li a:hover i {
        transform: translateX(4px);
    }

    /* Tombol Login */
    .login-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--deep-green));
        color: #fff !important;
        padding: 8px 24px;
        border-radius: 40px;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 6px rgba(15, 74, 49, 0.15);
        letter-spacing: 0.3px;
    }
    .login-btn i {
        font-size: 1rem;
    }
    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(15, 74, 49, 0.25);
        background: linear-gradient(135deg, var(--deep-green), var(--primary-color));
    }
    .login-btn:active {
        transform: translateY(1px);
    }

    /* Responsive */
    @media (max-width: 1100px) {
        nav ul {
            gap: 4px;
        }
        nav ul li a {
            font-size: 0.75rem;
            padding: 8px 10px;
        }
        .login-btn {
            padding: 6px 18px;
            font-size: 0.75rem;
        }
    }
    @media (max-width: 800px) {
        nav {
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: thin;
            -webkit-overflow-scrolling: touch;
        }
        nav ul {
            display: inline-flex;
        }
        .logo-text h1 {
            font-size: 0.8rem;
        }
        .logo-text span {
            font-size: 0.6rem;
        }
        .logo-img {
            width: 44px;
            height: 44px;
        }
        .login-btn span {
            display: none;
        }
        .login-btn i {
            margin: 0;
        }
    }
    @media (max-width: 480px) {
        header {
            padding: 0.5rem 4%;
        }
        .logo-text h1 {
            font-size: 0.7rem;
        }
    }
</style>
