@extends('user.component.master')

@section('title', 'Profil Mahasiswa - AKPER HKBP Balige')

@push('styles')
<style>
    /* ===== KHUSUS UNTUK HALAMAN PROFIL ===== */
    .profile-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        border: 1px solid rgba(99, 102, 241, 0.3);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto;
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
    }

    .profile-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .profile-label {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .profile-value {
        color: #c7d2fe;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .menu-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(99, 102, 241, 0.3);
        height: 100%;
        cursor: pointer;
    }

    .menu-card:hover {
        transform: translateY(-8px);
        border-color: rgba(99, 102, 241, 0.7);
        box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.4);
    }

    .menu-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        display: inline-block;
    }

    .menu-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    .menu-desc {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .badge-notif {
        background: #ef4444;
        color: white;
        border-radius: 20px;
        padding: 2px 8px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-left: 8px;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.05); }
    }
</style>
@endpush

@section('content')
<div class="main-content">

    <!-- HERO SECTION -->
    <section class="pt-28 pb-8 text-center px-5">
        <div class="inline-block glass-card px-5 py-2 rounded-full mb-5 fade-up">
            <span class="text-indigo-300 text-sm font-medium tracking-wide">👤 AKPER HKBP BALIGE</span>
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight title-main fade-up">
            Profil Mahasiswa
        </h1>
        <p class="text-gray-400 mt-5 max-w-2xl mx-auto fade-up">
            Kelola informasi akun, lihat riwayat peminjaman, dan atur preferensi notifikasi Anda.
        </p>
    </section>

    <!-- KONTEN UTAMA -->
    <section class="section max-w-6xl mx-auto px-5">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- SIDEBAR KIRI: INFORMASI PROFIL -->
            <div class="lg:col-span-1">
                <div class="profile-card p-6">
                    <div class="profile-avatar">
                        👨‍🎓
                    </div>
                    <h2 class="text-center text-xl font-bold text-indigo-200 mt-4">{{ auth()->user()->name }}</h2>
                    <p class="text-center text-xs text-indigo-300/70">{{ auth()->user()->role ?? 'Mahasiswa' }}</p>

                    <div class="mt-6 space-y-2">
                        <div class="profile-info-item">
                            <span class="profile-label">📧 Email</span>
                            <span class="profile-value">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-label">🆔 NPM / NIDN</span>
                            <span class="profile-value">{{ auth()->user()->npm ?? '-' }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-label">🎓 Program Studi</span>
                            <span class="profile-value">{{ auth()->user()->study_program ?? 'D3 Keperawatan' }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-label">📅 Angkatan</span>
                            <span class="profile-value">{{ auth()->user()->angkatan ?? '-' }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-label">📱 No. Telepon</span>
                            <span class="profile-value">{{ auth()->user()->phone ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-white/10 text-center">
                        <button onclick="editProfile()" class="btn-outline w-full text-sm py-2">
                            ✏️ Edit Profil
                        </button>
                    </div>
                </div>
            </div>

            <!-- SISI KANAN: MENU-MENU -->
            <div class="lg:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- MENU HISTORY PEMINJAMAN -->
                    <a href="{{ route('user.history') }}" class="no-underline block">
                        <div class="menu-card">
                            <div class="menu-icon">📚</div>
                            <h3 class="menu-title">History Peminjaman</h3>
                            <p class="menu-desc">Lihat riwayat peminjaman buku Anda, status, dan denda</p>
                            <div class="mt-3 text-indigo-400 text-sm">Lihat detail →</div>
                        </div>
                    </a>

                    <!-- MENU INBOX (NOTIFIKASI) -->
                    <a href="{{ route('user.inbox') }}" class="no-underline block">
                        <div class="menu-card">
                            <div class="menu-icon">📥</div>
                            <h3 class="menu-title">
                                Inbox
                                @if(($unreadNotif ?? 0) > 0)
                                    <span class="badge-notif">{{ $unreadNotif }}</span>
                                @endif
                            </h3>
                            <p class="menu-desc">Pesan dan notifikasi dari sistem perpustakaan</p>
                            <div class="mt-3 text-indigo-400 text-sm">Buka kotak masuk →</div>
                        </div>
                    </a>

                    <!-- MENU PENGATURAN -->
                    <div class="menu-card" onclick="settings()">
                        <div class="menu-icon">⚙️</div>
                        <h3 class="menu-title">Pengaturan</h3>
                        <p class="menu-desc">Atur preferensi akun, notifikasi, dan keamanan</p>
                        <div class="mt-3 text-indigo-400 text-sm">Kelola →</div>
                    </div>

                    <!-- MENU LOGOUT (opsional, bisa ditambahkan) -->
                    <div class="menu-card" onclick="logout()">
                        <div class="menu-icon">🚪</div>
                        <h3 class="menu-title">Logout</h3>
                        <p class="menu-desc">Keluar dari akun Anda</p>
                        <div class="mt-3 text-red-400 text-sm">Logout →</div>
                    </div>

                </div>

                <!-- INFO TAMBAHAN / STATISTIK SINGKAT -->
                <div class="glass-card p-5 rounded-xl mt-6">
                    <h3 class="text-indigo-200 font-semibold mb-3">📊 Statistik Akun</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-indigo-300">{{ $totalPinjam ?? 0 }}</div>
                            <div class="text-xs text-gray-400">Total Peminjaman</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-indigo-300">{{ $aktifPinjam ?? 0 }}</div>
                            <div class="text-xs text-gray-400">Sedang Dipinjam</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-indigo-300">{{ $totalKti ?? 0 }}</div>
                            <div class="text-xs text-gray-400">KTI Terupload</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-indigo-300">{{ $point ?? 0 }}</div>
                            <div class="text-xs text-gray-400">Poin Aktivitas</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>