<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

/* ================= NAVBAR MODERN ================= */
.navbar {
    position: sticky;
    top: 0; 
    width: 100%;
    backdrop-filter: blur(14px);
    background: linear-gradient(135deg, rgba(10,20,80,0.85), rgba(40,0,80,0.85));
    border-bottom: 1px solid rgba(255,255,255,0.08);
    color: white;
    padding: 8px 16px;
    font-size: 0.8rem;
    z-index: 1000;

    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}
            <!-- PROFILE DROPDOWN -->
            <li class="dropdown-modern nav-item-modern">
                <button class="flex items-center gap-1 px-3 py-2">
                    Profile <svg class="chevron w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <ul class="dropdown-menu-modern">
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('user.profile.visi_misi') }}"class="dropdown-item-modern">Visi Misi</a></li>
                        <li><a href="{{ route('user.profile.tugas_fungsi') }}"class="dropdown-item-modern">Tugas & Fungsi</a></li>
                        <li><a href="{{ route('user.profile.struktur') }}"class="dropdown-item-modern">Struktur Pengurus</a></li>
                        <li><a href="{{ route('user.profile.kerjasama') }}"class="dropdown-item-modern">Kerjasama</a></li>
                    </ul>
                </ul>
            </li>

/* LOGO */
.logo-container {
    display: flex;
    align-items: center;
    gap: 8px;
}

.logo-img {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(168,85,247,0.2));
    border: 1px solid rgba(99,102,241,0.4);
    font-size: 18px;
}
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
                            <li><a href="{{ route('user.koleksi.jurnal') }}"class="dropdown-item-modern">Jurnal</a></li>
                            <li><a href="{{ route('user.koleksi.buku_pengayaan') }}"class="dropdown-item-modern">Buku Pengayaan</a></li>
                            <li><a href="{{ route('user.koleksi.buku_referensi') }}"class="dropdown-item-modern">Buku Referensi</a></li>
                            <li><a href="{{ route('user.koleksi.majalah') }}"class="dropdown-item-modern">Majalah</a></li>
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

.logo-text h1 {
    font-size: 0.9rem;
    margin: 0;
    font-weight: 600;
}

.logo-text span {
    font-size: 0.65rem;
    color: rgba(255,255,255,0.6);
}

/* MENU */
.navbar nav ul {
    display: flex;
    gap: 6px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.navbar nav ul li a {
    color: #e0e7ff;
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 8px;
    transition: all 0.25s ease;
}

.navbar nav ul li a:hover {
    background: rgba(99,102,241,0.2);
    color: #fff;
}

/* DROPDOWN */
.dropdown-menu {
    display: none;
    position: absolute;
    top: 110%;
    left: 0;
    background: rgba(20,20,60,0.95);
    backdrop-filter: blur(12px);
    border-radius: 12px;
    padding: 6px 0;
    min-width: 180px;
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.navbar nav ul li:hover > .dropdown-menu {
    display: block;
}

.dropdown-menu li a {
    padding: 8px 12px;
    display: block;
    border-radius: 6px;
}

.dropdown-menu li a:hover {
    background: rgba(99,102,241,0.25);
}

/* SUBMENU */
.submenu {
    left: 100%;
    top: 0;
}

/* SEARCH */
.navbar form {
    display: flex;
    gap: 6px;
    align-items: center;
}

.navbar form input,
.navbar form select {
    padding: 6px 8px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.05);
    color: white;
    font-size: 0.75rem;
}

.navbar form input::placeholder {
    color: rgba(255,255,255,0.5);
}

.navbar form button {
    padding: 6px 10px;
    border-radius: 8px;
    border: none;
    background: linear-gradient(135deg, #6366f1, #a855f7);
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

.navbar form button:hover {
    opacity: 0.85;
}

/* USER AREA */
.user-area button {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    padding: 6px 10px;
    border-radius: 10px;
    color: #facc15;
}

/* NOTIF */
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
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .navbar form input,
    .navbar form select,
    .navbar form button {
        width: 48%;
    }

    .navbar form button {
        width: 100%;
    }

    .dropdown-menu {
        position: relative;
    }

    .submenu {
        left: 0;
    }
}
</style>
