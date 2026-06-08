{{-- resources/views/guest/page/profile/struktur-pengurus.blade.php --}}
@extends('guest.component.master')

@section('title', 'Struktur Pengurus - Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
    <style>
        /* ============================================
           STYLE (sama seperti sebelumnya)
        ============================================ */
        :root {
            --primary-color: #1a6b47;
            --deep-green: #0f4a31;
            --accent-green: #2daa6e;
            --accent-yellow: #f1c40f;
            --text-dark: #0d2137;
            --text-muted: #5a7060;
            --light-bg: #f4f7f5;
            --card-bg: #ffffff;
            --border-color: #d4e5d9;
        }

        .page-banner {
            background: linear-gradient(rgba(15, 74, 49, 0.85), rgba(26, 107, 71, 0.85)),
                        url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1500&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 70px 5% 80px;
            text-align: center;
        }

        .page-banner h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            margin-bottom: 10px;
            font-weight: 900;
        }

        .page-banner p {
            font-size: 1.05rem;
            opacity: 0.92;
        }

        .main-layout {
            display: flex;
            max-width: 1300px;
            margin: 40px auto 80px;
            padding: 0 20px;
            gap: 30px;
            position: relative;
            z-index: 10;
        }

        .content-area {
            flex: 1;
            background: var(--card-bg);
            padding: 50px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            text-align: center;
            border-top: 4px solid var(--accent-yellow);
        }

        .org-header {
            color: var(--primary-color);
            font-weight: 800;
            margin-bottom: 50px;
            font-size: 1.8rem;
            letter-spacing: 1px;
            font-family: 'Playfair Display', serif;
        }

        .org-section {
            margin-bottom: 60px;
            position: relative;
        }

        .category-label {
            background-color: var(--primary-color);
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 25px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 35px;
            box-shadow: 0 4px 10px rgba(15, 74, 49, 0.2);
        }

        .category-label i {
            color: var(--accent-yellow);
        }

        .cards-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .member-item {
            width: 160px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s;
        }

        .member-item:hover {
            transform: translateY(-5px);
        }

        .image-box {
            position: relative;
            margin-bottom: 15px;
            line-height: 0;
            border: 3px solid #000000;
            padding: 3px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .member-item img {
            width: 140px;
            height: 180px;
            object-fit: cover;
            border-radius: 4px;
        }

        .image-box::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: var(--accent-yellow);
            border-radius: 2px;
        }

        .member-item .m-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1.3;
            margin-top: 10px;
            min-height: 40px;
        }

        .member-item .m-role {
            font-size: 0.7rem;
            color: var(--text-muted);
            line-height: 1.2;
            font-weight: 500;
        }

        /* Ukuran khusus untuk Direktur */
        .section-top .member-item {
            width: 220px;
        }

        .section-top .image-box {
            border-width: 4px;
        }

        .section-top .member-item img {
            width: 200px;
            height: 260px;
        }

        .section-top .member-item .m-name {
            font-size: 1rem;
        }

        .sidebar {
            flex: 0 0 320px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
            padding: 25px;
            height: fit-content;
            position: sticky;
            top: 100px;
            border: 1px solid var(--border-color);
            transition: 0.3s;
        }

        .sidebar:hover {
            box-shadow: 0 16px 36px rgba(15, 74, 49, 0.12);
            border-color: var(--accent-green);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-brand .logo-img-small {
            width: 45px;
            height: 45px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .sidebar-brand h3 {
            font-size: 0.9rem;
            color: var(--text-dark);
            line-height: 1.3;
            font-weight: 700;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 10px;
            color: var(--text-muted);
            font-weight: 600;
            transition: 0.3s;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .sidebar-menu li a i {
            font-size: 1.1rem;
            color: #9cb5a8;
            width: 20px;
            text-align: center;
        }

        .sidebar-menu li a.active {
            background-color: #e0f0e8;
            color: var(--primary-color);
        }

        .sidebar-menu li a.active i {
            color: var(--primary-color);
        }

        .sidebar-menu li a:hover:not(.active) {
            background-color: #f0f7f3;
            color: var(--primary-color);
        }

        @media (max-width: 1100px) {
            .main-layout {
                flex-direction: column;
            }

            .sidebar {
                position: static;
                width: 100%;
                order: 2;
            }

            .content-area {
                order: 1;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-banner" data-aos="fade-up">
        <h1>Struktur Organisasi</h1>
        <p>Arah dan Kepemimpinan Perpustakaan AKPER HKBP</p>
    </div>

    <div class="main-layout">
        <main class="content-area" data-aos="fade-up" data-aos-delay="100">
            <h2 class="org-header">Organisasi Perpustakaan</h2>

            @php
                use Illuminate\Support\Facades\Storage;

                $strukturData = isset($struktur) ? $struktur->sortBy('order') : collect();
                $hasData = $strukturData->count() > 0;

                $direktur = null;
                $kepalaPengurus = null;
                $anggota = collect();

                if ($hasData) {
                    // Clone karena kita akan shift data asli
                    $temp = clone $strukturData;
                    $direktur = $temp->shift();
                    $kepalaPengurus = $temp->shift();
                    $anggota = $temp;
                }
            @endphp

            @if($hasData)
                {{-- DIREKTUR --}}
                @if($direktur)
                    <div class="org-section section-top">
                        <div class="category-label"><i class="fas fa-crown"></i> Direktur</div>
                        <div class="cards-container">
                            <div class="member-item">
                                <div class="image-box">
                                    @php
                                        $imgUrl = null;
                                        if ($direktur->image && Storage::disk('public')->exists($direktur->image)) {
                                            $imgUrl = asset('storage/' . $direktur->image);
                                        }
                                    @endphp
                                    @if($imgUrl)
                                        <img src="{{ $imgUrl }}" alt="{{ $direktur->title }}">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80" alt="Direktur">
                                    @endif
                                </div>
                                <div class="m-name">{{ $direktur->title ?? '-' }}</div>
                                <div class="m-role">{{ $direktur->jabatan ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- KEPALA PENGURUS --}}
                @if($kepalaPengurus)
                    <div class="org-section">
                        <div class="category-label"><i class="fas fa-user-tie"></i> Kepala Pengurus</div>
                        <div class="cards-container">
                            <div class="member-item">
                                <div class="image-box">
                                    @php
                                        $imgUrl = null;
                                        if ($kepalaPengurus->image && Storage::disk('public')->exists($kepalaPengurus->image)) {
                                            $imgUrl = asset('storage/' . $kepalaPengurus->image);
                                        }
                                    @endphp
                                    @if($imgUrl)
                                        <img src="{{ $imgUrl }}" alt="{{ $kepalaPengurus->title }}">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80" alt="Kepala Pengurus">
                                    @endif
                                </div>
                                <div class="m-name">{{ $kepalaPengurus->title }}</div>
                                <div class="m-role">{{ $kepalaPengurus->jabatan }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ANGGOTA --}}
                @if($anggota->count() > 0)
                    <div class="org-section">
                        <div class="category-label"><i class="fas fa-users"></i> Anggota</div>
                        <div class="cards-container">
                            @foreach($anggota as $member)
                                <div class="member-item">
                                    <div class="image-box">
                                        @php
                                            $imgUrl = null;
                                            if ($member->image && Storage::disk('public')->exists($member->image)) {
                                                $imgUrl = asset('storage/' . $member->image);
                                            }
                                        @endphp
                                        @if($imgUrl)
                                            <img src="{{ $imgUrl }}" alt="{{ $member->title }}">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=400&q=80" alt="Anggota">
                                        @endif
                                    </div>
                                    <div class="m-name">{{ $member->title }}</div>
                                    <div class="m-role">{{ $member->jabatan }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                {{-- FALLBACK STATIS (sama seperti sebelumnya) --}}
                <div class="org-section section-top">
                    <div class="category-label"><i class="fas fa-crown"></i> Direktur</div>
                    <div class="cards-container">
                        <div class="member-item">
                            <div class="image-box"><img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80" alt="Direktur"></div>
                            <div class="m-name">Prof. Dr. Ryadni Efendi, S.Si., M.I.T.</div>
                            <div class="m-role">Direktur Perpustakaan</div>
                        </div>
                    </div>
                </div>
                <div class="org-section">
                    <div class="category-label"><i class="fas fa-user-tie"></i> Kepala Pengurus</div>
                    <div class="cards-container">
                        <div class="member-item">
                            <div class="image-box"><img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80" alt="Kepala Pengurus"></div>
                            <div class="m-name">Bandari, S.Sos., M.Si.</div>
                            <div class="m-role">Kepala Pengurus & Sekretaris</div>
                        </div>
                    </div>
                </div>
                <div class="org-section">
                    <div class="category-label"><i class="fas fa-users"></i> Anggota</div>
                    <div class="cards-container">
                        <div class="member-item"><div class="image-box"><img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=400&q=80" alt="Anggota"></div><div class="m-name">Murniaty, S.Sos.</div><div class="m-role">Pengelola Koleksi</div></div>
                        <div class="member-item"><div class="image-box"><img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=400&q=80" alt="Anggota"></div><div class="m-name">Suparlan, S.Sos.</div><div class="m-role">Pengadaan Pustaka</div></div>
                        <div class="member-item"><div class="image-box"><img src="https://images.unsplash.com/photo-1559839734-2b71f1536b8a?auto=format&fit=crop&w=400&q=80" alt="Anggota"></div><div class="m-name">Helly Gailam, S.Sos.</div><div class="m-role">Layanan Teknis</div></div>
                        <div class="member-item"><div class="image-box"><img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80" alt="Anggota"></div><div class="m-name">Windi Sri Rahayu</div><div class="m-role">Layanan Pemustaka</div></div>
                        <div class="member-item"><div class="image-box"><img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400&q=80" alt="Anggota"></div><div class="m-name">Adelia Lubis, S.T.</div><div class="m-role">Pengelola IT</div></div>
                        <div class="member-item"><div class="image-box"><img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?auto=format&fit=crop&w=400&q=80" alt="Anggota"></div><div class="m-name">Doni Sinaga, S.Kom.</div><div class="m-role">Software Developer</div></div>
                    </div>
                </div>
            @endif
        </main>

        <aside class="sidebar" data-aos="fade-left" data-aos-delay="200">
            <div class="sidebar-brand">
                <div class="logo-img-small"><i class="fas fa-plus-square"></i></div>
                <h3>Perpustakaan<br>AKPER HKBP</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('guest.profile.visi-misi') }}"><i class="fas fa-lightbulb"></i> Visi, Misi, & Sasaran</a></li>
                <li><a href="{{ route('guest.profile.kerjasama') }}"><i class="fas fa-handshake"></i> Kerjasama</a></li>
                <li><a href="{{ route('guest.profile.struktur') }}" class="active"><i class="fas fa-users"></i> Struktur Pengurus</a></li>
                <li><a href="{{ route('guest.profile.tugas-fungsi') }}"><i class="fas fa-tasks"></i> Tugas, Fungsi, Tujuan</a></li>
            </ul>
        </aside>
    </div>
@endsection
