{{-- resources/views/user/component/navbars.blade.php --}}
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
    <button class="hamburger" id="hamburgerBtn">☰</button>
    <nav>
        <ul>
            <li><a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Home</a></li>

            <li>
                <a href="#" class="{{ request()->routeIs('user.profile.*') ? 'active' : '' }}">Profile <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('user.profile.visi_misi') }}">Visi Misi</a></li>
                    <li><a href="{{ route('user.profile.kerjasama') }}">Kerjasama</a></li>
                    <li><a href="{{ route('user.profile.struktur') }}">Struktur Pengurus</a></li>
                    <li><a href="{{ route('user.profile.tugas_fungsi') }}">Tugas, Fungsi, Tujuan</a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="{{ request()->routeIs('user.pinbal.index') || request()->routeIs('user.waktu.layanan') ? 'active' : '' }}">Layanan <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('user.pinbal.index') }}">Pinjam Buku</a></li>
                    <li><a href="{{ route('user.waktu.layanan') }}">Waktu Layanan</a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="{{ request()->routeIs('user.koleksi.*') ? 'active' : '' }}">Koleksi Tercetak <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('user.koleksi.jurnal') }}">Jurnal</a></li>
                    <li><a href="{{ route('user.koleksi.buku_pengayaan') }}">Buku Pengayaan</a></li>
                    <li><a href="{{ route('user.koleksi.buku_referensi') }}">Buku Referensi</a></li>
                    <li><a href="{{ route('user.koleksi.majalah') }}">Majalah</a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="{{ request()->routeIs('final_project.koleksi') || request()->routeIs('final_project.kti') ? 'active' : '' }}">Koleksi Elektronik <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('final_project.koleksi', 'ebook') }}">E-book</a></li>
                    <li><a href="{{ route('final_project.koleksi', 'e-article') }}">E-article</a></li>
                    <li><a href="{{ route('final_project.koleksi', 'cd') }}">CD/DVD</a></li>
                    <li><a href="{{ route('final_project.koleksi', 'video') }}">Video Edukasi</a></li>
                    <li><a href="{{ route('final_project.kti') }}">KTI Digital</a></li>
                </ul>
            </li>

            <li><a href="{{ route('user.berita') }}" class="{{ request()->routeIs('user.berita') ? 'active' : '' }}">Berita</a></li>

            <li>
                <a href="#" class="{{ request()->routeIs('user.panduan') ? 'active' : '' }}">Informasi <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('user.panduan') }}">Panduan</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    {{-- Bagian kanan: notifikasi + login/profil dinamis --}}
    <div style="display: flex; align-items: center; gap: 15px;">
        @if(session()->has('user'))
            @php
                $userId = session('user_id') ?? session('user')['id'] ?? 0;
                $unreadNotif = \App\Models\Notification::where('user_id', $userId)
                    ->where('is_read', false)
                    ->count();
                $allNotifications = \App\Models\Notification::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->take(20)
                    ->get()
                    ->groupBy(function($item) {
                        return \Carbon\Carbon::parse($item->created_at)->isToday() ? 'HARI INI' : 'SEBELUMNYA';
                    });
            @endphp

            {{-- Tombol Notifikasi (POPUP) --}}
            <div class="notification-icon-wrapper" id="notificationBell" onclick="openNotifModal()">
                <i class="fas fa-bell"></i>
                @if($unreadNotif > 0)
                    <span class="notification-badge" id="notifBadge">
                        {{ $unreadNotif > 9 ? '9+' : $unreadNotif }}
                    </span>
                @endif
            </div>

            {{-- Tombol Profil --}}
            <div class="profile-dropdown-wrapper">
                <button class="profile-btn" aria-label="Menu Profil">
                    <span class="profile-avatar"><i class="fas fa-user"></i></span>
                    <span class="user-name">{{ session('user')['name'] ?? 'Profil' }}</span>
                    <i class="fas fa-caret-down profile-caret"></i>
                </button>
                <ul class="profile-dropdown-menu">
                    <li class="logout-item">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                    <li><a href="{{ route('profile.menu') }}"><i class="fas fa-user-cog"></i> Pengaturan Profil</a></li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="login-btn"><i class="fas fa-sign-in-alt"></i> LOGIN</a>
        @endif
    </div>
</header>

{{-- Form Logout Tersembunyi --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

{{-- MODAL NOTIFIKASI POPUP --}}
<div id="notificationModal" class="notification-modal" style="display: none;">
    <div class="notification-panel">
        <div class="notif-header">
            <h3><i class="fas fa-inbox"></i> Inbox Notifikasi</h3>
            <span class="close-notif" onclick="closeNotifModal()">&times;</span>
        </div>
        <div class="notif-body">
            @if(session()->has('user'))
                @forelse($allNotifications as $group => $items)
                    <div class="notif-group">
                        <div class="group-title">{{ $group }} · {{ $items->count() }} PESAN</div>
                        @foreach($items as $notif)
                            <div class="notif-item {{ $notif->is_read ? 'read' : '' }}"
                                 data-id="{{ $notif->id }}"
                                 onclick="markAsRead({{ $notif->id }})">
                                <div class="notif-icon">
                                    <i class="fas {{ $notif->icon ?? 'fa-bell' }}"></i>
                                </div>
                                <div class="notif-content">
                                    <div class="notif-title">{{ $notif->title }}</div>
                                    <div class="notif-desc">{{ $notif->message }}</div>
                                    <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px 20px; color: #5a7060;">
                        <i class="fas fa-bell-slash" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                        <p>Belum ada notifikasi</p>
                    </div>
                @endforelse
            @endif
        </div>
        <div class="notif-footer" onclick="markAllAsRead()">
            Tandai semua telah dibaca
        </div>
    </div>
</div>

<style>
    /* =============== NAVBAR STYLE (PUTIH) =============== */
        header {
        background-color: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(8px);
        color: var(--text-dark);
        padding: 0.6rem 3%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);

        /* PAKAI FIXED AGAR PASTI SELALU DI ATAS */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;

        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-img {
        width: 45px;
        height: 45px;
        background-color: var(--primary-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .logo-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
    }

    .logo-text h1 {
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        line-height: 1.2;
        color: var(--text-dark);
        letter-spacing: -0.3px;
    }

    .logo-text span {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    nav ul {
        list-style: none;
        display: flex;
        gap: 8px;
    }

    nav ul li {
        position: relative;
    }

    nav ul li a {
        padding: 8px 14px;
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        transition: 0.2s;
        color: var(--text-dark);
        border-radius: 30px;
    }

    nav ul li a:hover,
    nav ul li > a.active {
        color: var(--primary-color);
        background-color: rgba(26, 107, 71, 0.08);
    }

    /* CSS untuk indikator active yang lebih jelas */
    nav ul li a.active {
        color: var(--primary-color);
        background-color: rgba(26, 107, 71, 0.12);
        font-weight: 700;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background-color: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(12px);
        min-width: 220px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
        border-radius: 16px;
        display: none;
        z-index: 100;
        border: 1px solid rgba(0, 0, 0, 0.05);
        padding: 8px 0;
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
        border-radius: 0;
    }

    .dropdown-menu li a:hover {
        background-color: rgba(26, 107, 71, 0.08);
        color: var(--primary-color) !important;
        padding-left: 24px;
    }

    nav ul li:hover > .dropdown-menu {
        display: block;
    }

    .login-btn {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1f7d54 100%);
        color: #fff !important;
        padding: 9px 22px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 10px rgba(26, 107, 71, 0.3);
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(15, 74, 49, 0.4);
    }

    /* ========== PROFILE BUTTON & DROPDOWN ========== */
    .profile-dropdown-wrapper {
        position: relative;
    }

    .profile-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #1a6b47 0%, #219150 100%);
        color: #fff;
        border: none;
        padding: 6px 16px 6px 6px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(26, 107, 71, 0.35);
    }

    .profile-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(15, 74, 49, 0.45);
    }

    .profile-avatar {
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: white;
    }

    .user-name {
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .profile-caret {
        font-size: 0.7rem;
        opacity: 0.9;
        transition: transform 0.3s;
    }

    .profile-dropdown-wrapper:hover .profile-caret {
        transform: rotate(180deg);
    }

    .profile-dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        min-width: 200px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(15, 74, 49, 0.2);
        border: 1px solid rgba(26, 107, 71, 0.15);
        padding: 8px 0;
        list-style: none;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.25s ease;
        z-index: 200;
    }

    .profile-dropdown-menu::before {
        content: '';
        position: absolute;
        top: -8px;
        right: 20px;
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-bottom: 8px solid rgba(255, 255, 255, 0.85);
        filter: drop-shadow(0 -2px 2px rgba(15, 74, 49, 0.05));
    }

    .profile-dropdown-wrapper:hover .profile-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .profile-dropdown-menu li a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        color: #1a3b2f !important;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s;
        text-decoration: none;
    }

    .profile-dropdown-menu li a i {
        width: 18px;
        text-align: center;
        color: var(--primary-color);
    }

    .profile-dropdown-menu li a:hover {
        background: rgba(26, 107, 71, 0.08);
        padding-left: 25px;
    }

    .logout-item a {
        color: #c0392b !important;
    }

    .logout-item a i {
        color: #c0392b !important;
    }

    /* ========== NOTIFICATION ICON ========== */
    .notification-icon-wrapper {
        position: relative;
        cursor: pointer;
        font-size: 1.2rem;
        color: var(--text-dark);
        transition: 0.2s;
        background: rgba(0, 0, 0, 0.04);
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .notification-icon-wrapper:hover {
        background: rgba(26, 107, 71, 0.1);
        color: var(--primary-color);
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #e74c3c;
        color: white;
        font-size: 0.6rem;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 30px;
        min-width: 18px;
        text-align: center;
    }

    /* ========== MODAL NOTIFIKASI ========== */
    .notification-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        display: none;
    }

    .notification-panel {
        background: #fff;
        max-width: 480px;
        width: 90%;
        border-radius: 32px;
        box-shadow: 0 25px 45px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        animation: fadeSlideUp 0.3s ease;
        border-top: 4px solid #f1c40f;
    }

    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .notif-header {
        padding: 20px 24px;
        background: white;
        border-bottom: 1px solid #d4e5d9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notif-header h3 {
        font-size: 1.3rem;
        font-weight: 800;
        color: #0d2137;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .notif-header h3 i {
        color: #f1c40f;
    }

    .close-notif {
        font-size: 1.5rem;
        cursor: pointer;
        color: #9aa6b5;
        transition: 0.2s;
        line-height: 1;
    }

    .close-notif:hover {
        color: #e74c3c;
    }

    .notif-body {
        max-height: 500px;
        overflow-y: auto;
        padding: 8px 0;
    }

    .notif-group {
        margin: 16px 0;
    }

    .group-title {
        padding: 8px 24px;
        font-size: 0.7rem;
        font-weight: 800;
        color: #5a7060;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: #f8fbf9;
        border-top: 1px solid #d4e5d9;
        border-bottom: 1px solid #d4e5d9;
    }

    .notif-item {
        display: flex;
        gap: 14px;
        padding: 16px 24px;
        border-bottom: 1px solid #d4e5d9;
        transition: 0.2s;
        cursor: pointer;
    }

    .notif-item:hover {
        background: #fafdfb;
    }

    .notif-item.read {
        opacity: 0.7;
        background: #fcfdfc;
    }

    .notif-icon {
        width: 40px;
        height: 40px;
        background: rgba(26, 107, 71, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1a6b47;
        font-size: 1rem;
    }

    .notif-content {
        flex: 1;
    }

    .notif-title {
        font-weight: 700;
        color: #0d2137;
        font-size: 0.9rem;
        margin-bottom: 4px;
    }

    .notif-desc {
        font-size: 0.75rem;
        color: #5a7060;
        line-height: 1.4;
    }

    .notif-time {
        font-size: 0.65rem;
        color: #5a7060;
        margin-top: 6px;
    }

    .notif-footer {
        padding: 16px 24px;
        border-top: 1px solid #d4e5d9;
        text-align: center;
        font-size: 0.8rem;
        color: #1a6b47;
        font-weight: 600;
        cursor: pointer;
    }

    .notif-footer:hover {
        background: #f0f7f3;
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

        .profile-btn {
            padding: 6px 12px 6px 6px;
        }

        .user-name {
            max-width: 70px;
        }
    }
</style>

@push('scripts')
    <script>
        function openNotifModal() {
            document.getElementById('notificationModal').style.display = 'flex';
        }

        function closeNotifModal() {
            document.getElementById('notificationModal').style.display = 'none';
        }

        function markAsRead(id) {
            fetch('/notifications/' + id + '/read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      const item = document.querySelector(`.notif-item[data-id="${id}"]`);
                      if (item) item.classList.add('read');
                      updateBadge();
                  }
              });
        }

        function markAllAsRead() {
            fetch('/notifications/read-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      document.querySelectorAll('.notif-item').forEach(item => item.classList.add('read'));
                      updateBadge();
                  }
              });
        }

        function updateBadge() {
            const badge = document.getElementById('notifBadge');
            if (!badge) return;
            const unreadItems = document.querySelectorAll('.notif-item:not(.read)').length;
            if (unreadItems === 0) {
                badge.style.display = 'none';
            } else {
                badge.textContent = unreadItems > 9 ? '9+' : unreadItems;
                badge.style.display = 'inline-block';
            }
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('notificationModal');
            if (e.target === modal) closeNotifModal();
        });
    </script>
@endpush
