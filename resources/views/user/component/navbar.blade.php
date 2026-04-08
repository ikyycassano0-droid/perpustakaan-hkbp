<style>
    @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>
<div class="navbar" style="position: sticky; top: 0; width: 100%; background: rgba(2, 30, 105); color: white; padding: 5px 10px; font-size: 0.75rem; z-index:1000; display:flex; justify-content:space-between; align-items:center;">

    <!-- LOGO -->
    <div class="logo-container d-flex align-items-center gap-2">
        <div class="logo-img"><i class="fas fa-plus-square"></i></div>
        <div class="logo-text">
            <h1 style="font-size:0.9rem; margin:0;">Perpustakaan AKPER HKBP</h1>
            <span style="font-size:0.7rem;">Sekolah Keperawatan HKBP</span>
        </div>
    </div>

    <!-- MENU -->
    <nav>
        <ul style="display:flex; gap:5px; list-style:none; margin:0;">
            
            <li><a href="#">Home</a></li>

            <!-- PROFILE -->
            <li>
                <a href="#">Profile <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Visi Misi</a></li>
                    <li><a href="#">Kerjasama</a></li>
                    <li><a href="#">Struktur Pengurus</a></li>
                    <li><a href="#">Tugas & Fungsi</a></li>
                </ul>
            </li>

            <!-- LAYANAN -->
            <li>
                <a href="#">Layanan <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('user.pinjam') }}">Pinbal</a></li>
                    <li><a href="#">Upload TA</a></li>
                    <li><a href="#">Waktu Layanan</a></li>
                </ul>
            </li>

            <!-- KOLEKSI -->
            <li>
                <a href="#">Koleksi <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">Koleksi Tercetak <i class="fas fa-caret-right" style="float:right;"></i></a>
                        <ul class="dropdown-menu submenu">
                            <li><a href="{{ route('user.koleksi.jurnal') }}">Jurnal</a></li>
                            <li><a href="{{ route('user.koleksi.buku_pengayaan') }}">Buku Pengayaan</a></li>
                            <li><a href="{{ route('user.koleksi.buku_referensi') }}">Buku Referensi</a></li>
                            <li><a href="{{ route('user.koleksi.majalah') }}">Majalah</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">Koleksi Elektronik <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/koleksi/ebook') }}">E-book</a></li>
                    <li><a href="{{ url('/koleksi/e-article') }}">E-article</a></li>
                    <li><a href="{{ url('/koleksi/cd') }}">CD</a></li>
                    <li><a href="{{ url('/koleksi/video') }}">Video</a></li>
                    <li><a href="{{ url('/koleksi/kti') }}">KTI</a></li>
                </ul>
            </li>

            <!-- BERITA -->
            <li><a href="#">Berita</a></li>

            <!-- INFORMASI -->
            <li>
                <a href="#">Informasi <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Panduan</a></li>
                </ul>
            </li>

        </ul>
    </nav>

    <!-- USER AREA -->
    <div class="user-area">
        @auth
        <button class="user-name btn btn-link text-warning text-decoration-none"
            data-bs-toggle="offcanvas" data-bs-target="#sidebarUser">
            <i class="fas fa-user-circle"></i> 
            {{ auth()->user()->name }}
        </button>
        @endauth
    </div>

</div>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarUser">

    <div class="offcanvas-header">
        <h5>Menu Mahasiswa</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <div class="mb-3">
            <strong>
                <i class="fas fa-user"></i> 
                {{ auth()->user()->name ?? 'Mahasiswa AKPER' }}
            </strong>
        </div>

        <hr>

        <ul class="list-group">

            <!-- HISTORY -->
            <li class="list-group-item">
                <a href="{{ route('user.history') }}" class="text-decoration-none">
                    📚 History Peminjaman
                </a>
            </li>

            <!-- INBOX -->
            <li class="list-group-item d-flex justify-content-between align-items-center">

                <a href="{{ route('user.inbox') }}" class="text-decoration-none">
                    📥 Inbox
                </a>

                @auth
                    @if(($unreadNotif ?? 0) > 0)
                        <span id="notif-badge" class="badge bg-danger rounded-pill" style="animation: pulse 1s infinite;">
                            {{ $unreadNotif }}
                        </span>
                    @endif
                @endauth

            </li>

            <!-- PENGATURAN -->
            <li class="list-group-item">
                <a href="#" class="text-decoration-none">
                    ⚙️ Pengaturan
                </a>
            </li>

        </ul>

        <hr>

        <a href="{{ route('home') }}" class="btn btn-danger w-100">
            Logout
        </a>

    </div>
</div>