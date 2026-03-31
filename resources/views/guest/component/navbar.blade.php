<style>
    .login-btn {
        background-color: var(--accent-yellow);
        color: #000 !important;
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: bold;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }

    .login-btn:hover {
        background-color: white;
        transform: translateY(-2px);
    }

    nav ul { list-style: none; display: flex; gap: 15px; }
    nav ul li { position: relative; }
    nav ul li a { color: white; text-decoration: none; padding: 5px 10px; display: block; }
    .dropdown-menu { display: none; position: absolute; background: var(--primary-color); padding: 10px; top: 100%; left: 0; min-width: 180px; border-radius: 5px; }
    .dropdown-menu li a { color: white; }
    li:hover > .dropdown-menu { display: block; }
    .submenu { left: 100%; top: 0; }
</style>

<div class="navbar" style="position: sticky; top: 0; width: 100%; background: rgba(2, 30, 105); color: white; padding: 5px 10px; font-size: 0.75rem; z-index:1000;">
    <div class="logo-container">
        <div class="logo-img"><i class="fas fa-plus-square"></i></div>
        <div class="logo-text">
            <h1>Perpustakaan AKPER HKBP</h1>
            <span>Sekolah Keperawatan HKBP</span>
        </div>
    </div>
    
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>

            <li>
                <a href="#">Profile <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('guest.page.profile.visi-misi') }}">Visi Misi</a></li>
                    <li><a href="#">Kerjasama</a></li>
                    <li><a href="{{ route('guest.page.profile.struktur pengurus') }}">Struktur Pengurus</a></li>
                    <li><a href="{{ route('guest.berita.index') }}">Berita</a></li>
                </ul>
            </li>

            <li>
                <a href="#">Layanan <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('pinbal.html') }}">Pinbal (Peminjaman & Pengembalian)</a></li>
                    <li><a href="{{ url('upload-ta.html') }}">Upload TA</a></li>
                    <li><a href="{{ url('waktu_layanan.html') }}">Waktu Layanan</a></li>
                </ul>
            </li>

            <li>
                <a href="#">Koleksi <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">Koleksi Tercetak <i class="fas fa-caret-right" style="float:right;"></i></a>
                        <ul class="dropdown-menu submenu">
                            <li><a href="{{ url('jurnal.html') }}">Jurnal</a></li>
                            <li><a href="{{ url('buku-pengayaan.html') }}">Buku Pengayaan</a></li>
                            <li><a href="{{ url('buku-referensi.html') }}">Buku Referensi</a></li>
                            <li><a href="{{ url('majalah.html') }}">Majalah</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#">Koleksi Elektronik <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('ebook.html') }}">E-book</a></li>
                    <li><a href="{{ url('e-article.html') }}">E-article</a></li>
                    <li><a href="{{ url('cd.html') }}">CD</a></li>
                    <li><a href="{{ url('video.html') }}">Video</a></li>
                    <li><a href="{{ url('kti.html') }}">KTI</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('guest.berita.index') }}"
                ">Berita</a>
            </li>
            <li>
                <a href="#">Informasi <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('panduan.html') }}">Panduan</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <a href="{{ route('login') }}" class="login-btn"><i class="fas fa-sign-in-alt"></i> LOGIN</a>
</div>