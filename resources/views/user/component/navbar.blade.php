<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

/* Basic navbar styling */
.navbar {
    position: sticky;
    top: 0;
    width: 100%;
    background: rgba(2, 30, 105);
    color: white;
    padding: 5px 10px;
    font-size: 0.75rem;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.navbar .logo-container {
    display: flex;
    align-items: center;
    gap: 5px;
}

.navbar nav ul {
    display: flex;
    gap: 10px;
    list-style: none;
    margin: 0;
    padding: 0;
    flex-wrap: wrap;
}

.navbar nav ul li {
    position: relative;
}

.navbar nav ul li a {
    color: white;
    text-decoration: none;
    padding: 5px 8px;
    display: block;
}

.navbar nav ul li a:hover {
    background: rgba(255, 255, 255, 0.1);
}

.navbar nav ul li ul.dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background: rgba(2,30,105);
    list-style: none;
    padding: 5px 0;
    min-width: 150px;
    z-index: 1000;
}

.navbar nav ul li:hover > ul.dropdown-menu {
    display: block;
}

.navbar nav ul li ul.submenu {
    left: 100%;
    top: 0;
}

/* Search form */
.navbar form {
    display: flex;
    gap: 5px;
    align-items: center;
}

.navbar form input, .navbar form select {
    padding: 3px 5px;
    font-size: 0.7rem;
}

.navbar form button {
    padding: 3px 6px;
    font-size: 0.7rem;
    cursor: pointer;
}

/* USER AREA */
.user-area button {
    background: none;
    border: none;
    color: #ffc107;
    cursor: pointer;
}

/* Pulse animation for notification */
#notif-badge {
    animation: pulse 1s infinite;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .navbar nav ul {
        flex-direction: column;
        width: 100%;
    }

    .navbar form {
        width: 100%;
        margin-top: 5px;
        flex-wrap: wrap;
    }

    .navbar form input, .navbar form select, .navbar form button {
        width: 48%;
    }

    .navbar form button {
        width: 100%;
        margin-top: 3px;
    }

    .navbar nav ul li ul.dropdown-menu {
        position: relative;
    }

    .navbar nav ul li ul.submenu {
        left: 0;
    }
}
</style>

<div class="navbar">
    <!-- LOGO -->
    <div class="logo-container">
        <div class="logo-img"><i class="fas fa-plus-square"></i></div>
        <div class="logo-text">
            <h1 style="font-size:0.9rem; margin:0;">Perpustakaan AKPER HKBP</h1>
            <span style="font-size:0.7rem;">Sekolah Keperawatan HKBP</span>
        </div>
    </div>

    <!-- MENU & SEARCH -->
    <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
        <!-- MENU -->
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li>
                    <a href="#">Profile <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Visi Misi</a></li>
                        <li><a href="#">Kerjasama</a></li>
                        <li><a href="#">Struktur Pengurus</a></li>
                        <li><a href="#">Tugas & Fungsi</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Layanan <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('user.pinjam') }}">Pinbal</a></li>
                        <li><a href="#">Upload TA</a></li>
                        <li><a href="#">Waktu Layanan</a></li>
                    </ul>
                </li>
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
 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('user/final-project/*') ? 'active' : '' }}" 
                       href="#" role="button" data-bs-toggle="dropdown">Koleksi Elektronik</a>
                    <ul class="dropdown-menu">
                        <!-- KTI (user upload) -->
                        <li><a class="dropdown-item" href="{{ route('final_project.kti') }}">KTI</a></li>

                        <!-- Admin Upload -->
                        <li><a class="dropdown-item" href="{{ route('final_project.index', ['category' => 'ebook']) }}">E-Book</a></li>

                        <li><a class="dropdown-item" href="{{ route('final_project.index', ['category' => 'e-article']) }}">E-Article</a></li>

                        <li><a class="dropdown-item" href="{{ route('final_project.index', ['category' => 'cd']) }}">CD</a></li>

                        <li><a class="dropdown-item" href="{{ route('final_project.index', ['category' => 'video']) }}">Video</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#">Berita</a></li>
                <li>
                    <a href="#">Informasi <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Panduan</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- SEARCH FORM -->
        <form action="{{ route('user.global_search') }}" method="GET">
            <input type="text" name="keyword" placeholder="Cari koleksi..." required>
            <select name="category">
                <option value="">Semua</option>
                <option value="collection">Koleksi Tercetak</option>
                <option value="cd">CD</option>
                <option value="e_book">E-Book</option>
                <option value="e_article">E-Article</option>
                <option value="video">Video</option>
            </select>
            <button type="submit">🔍</button>
        </form>
    </div>

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