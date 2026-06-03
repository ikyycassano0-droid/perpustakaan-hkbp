{{-- home.blade.php --}}
@extends('guest.component.master')

@section('title', 'Beranda | Perpustakaan Sekolah Keperawatan HKBP')

@push('styles')
<style>
    /* ===========================
       HERO SECTION
    =========================== */
    .hero {
        background: linear-gradient(rgba(13, 33, 55, 0.72), rgba(15, 74, 49, 0.70)), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        padding: 20px;
    }

    .hero h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.4rem;
        margin-bottom: 10px;
        font-weight: 900;
        letter-spacing: -0.5px;
    }

    .hero p {
        font-size: 1.05rem;
        margin-bottom: 30px;
        max-width: 600px;
        opacity: 0.92;
    }

    .search-container {
        background-color: white;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
        width: 90%;
        max-width: 800px;
        display: flex;
        gap: 10px;
        border: 2px solid #e6f0ea;
    }

    .search-container select {
        padding: 8px 14px;
        border: none;
        background: #f0f9f4;
        border-radius: 7px;
        outline: none;
        font-weight: 600;
        color: var(--primary-color);
    }

    .search-container input {
        flex: 1;
        padding: 10px 16px;
        border: none;
        outline: none;
        font-size: 0.95rem;
        color: var(--text-dark);
    }

    .search-btn {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 28px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 700;
        font-size: 0.9rem;
        transition: 0.3s;
    }

    .search-btn:hover {
        background-color: var(--deep-green);
    }

    /* ===========================
       FEATURE SECTION
    =========================== */
    .feature-section {
        padding: 50px 5%;
        background: linear-gradient(to bottom, var(--primary-color) 40%, var(--light-bg) 40%);
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .feature-card {
        background: white;
        padding: 30px 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.10);
        transition: 0.4s ease;
        border: 1.5px solid #e8f2ec;
    }

    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(15, 74, 49, 0.16);
        border-color: var(--accent-green);
    }

    .animate-float {
        animation: floating 3s ease-in-out infinite;
    }

    .feature-card i {
        color: var(--primary-color);
        font-size: 3rem;
        margin-bottom: 18px;
        display: block;
    }

    .feature-card h3 {
        color: var(--text-dark);
        font-size: 1.1rem;
        margin-bottom: 12px;
        font-weight: 700;
    }

    .feature-card p {
        color: var(--text-muted);
        font-size: 0.88rem;
    }

    /* ===========================
       JAM LAYANAN
    =========================== */
    .jam-layanan-section {
        padding: 30px 5%;
        background: var(--light-bg);
    }

    .jam-banner {
        background: linear-gradient(100deg, var(--deep-green) 40%, rgba(15, 74, 49, 0.75) 100%), url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1000&q=80');
        background-size: cover;
        padding: 40px;
        border-radius: 16px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        box-shadow: 0 8px 28px rgba(15, 74, 49, 0.20);
    }

    .jam-banner h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.7rem;
        margin-bottom: 10px;
    }

    .info-btn {
        color: #a8f0c8;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.3s;
    }

    .info-btn:hover {
        color: white;
    }

    .jam-table {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .jam-row {
        display: flex;
        justify-content: space-between;
        gap: 40px;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .status-tutup {
        font-weight: 800;
        color: #ff8a8a;
    }

    /* ===========================
       MATRIX / LAYANAN SECTION
    =========================== */
    .matrix-wrapper-layanan {
        position: relative;
        background: #f4f7f5;
        overflow: hidden;
    }

    #matrix-canvas-layanan {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        pointer-events: none;
    }

    .section-container {
        padding: 40px 5%;
        position: relative;
        z-index: 5;
    }

    .label-header {
        background-color: var(--primary-color);
        color: white;
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        border-radius: 6px;
        margin-bottom: 25px;
        font-size: 0.9rem;
    }

    .grid-layanan-modern {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .card-layanan {
        background: white;
        color: var(--text-dark);
        padding: 25px;
        border-radius: 12px;
        transition: 0.3s;
        text-align: left;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
    }

    .card-layanan:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        border-color: var(--accent-green);
    }

    .card-layanan i {
        font-size: 2.2rem;
        color: var(--accent-green);
        margin-bottom: 5px;
    }

    .card-layanan h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .card-layanan p {
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .card-layanan:nth-child(5),
    .card-layanan:nth-child(6) {
        grid-column: span 2;
    }

    /* STATISTIK */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 18px;
        margin-bottom: 50px;
    }

    .stat-item {
        background: white;
        padding: 22px;
        border-radius: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1.5px solid #d4e5d9;
        box-shadow: 0 4px 16px rgba(15, 74, 49, 0.07);
        transition: 0.3s;
    }

    .stat-item:hover {
        border-color: var(--accent-green);
        box-shadow: 0 8px 24px rgba(15, 74, 49, 0.14);
    }

    .stat-item>i {
        font-size: 2rem;
        color: var(--accent-green);
        opacity: 0.7;
    }

    .stat-info span {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--primary-color);
        display: block;
        font-family: 'Playfair Display', serif;
    }

    .stat-info p {
        font-size: 0.85rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* KOLEKSI UNGGULAN */
    .koleksi-unggulan-section {
        padding: 60px 5%;
        background: var(--card-bg);
        border-radius: 32px;
        box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
        margin: 30px 0;
    }

    .koleksi-unggulan-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 40px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .koleksi-unggulan-header-left .subtitle-label {
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--primary-color);
        margin-bottom: 8px;
    }

    .koleksi-unggulan-header-left h2 {
        font-size: 2.6rem;
        font-weight: 900;
        color: var(--text-dark);
        line-height: 1.1;
        font-family: 'Playfair Display', serif;
    }

    .koleksi-lihat-semua {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.88rem;
        font-weight: 800;
        color: var(--primary-color);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: gap 0.3s;
        text-decoration: none;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 2px;
    }

    .koleksi-lihat-semua:hover {
        gap: 14px;
        color: var(--deep-green);
        border-color: var(--deep-green);
    }

    .koleksi-unggulan-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: auto auto;
        gap: 20px;
        max-width: 1300px;
        margin: 0 auto;
    }

    .koleksi-hero-card {
        grid-column: 1;
        grid-row: 1 / 3;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        min-height: 520px;
        cursor: pointer;
        background: var(--deep-green);
    }

    .koleksi-hero-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.70;
        transition: transform 0.6s ease, opacity 0.6s ease;
        display: block;
    }

    .koleksi-hero-card:hover img {
        transform: scale(1.05);
        opacity: 0.55;
    }

    .koleksi-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10, 45, 28, 0.94) 40%, transparent 75%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
    }

    .koleksi-hero-badge {
        display: inline-block;
        background: var(--accent-green);
        color: white;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 50px;
        margin-bottom: 18px;
        width: fit-content;
    }

    .koleksi-hero-overlay h3 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 900;
        color: white;
        line-height: 1.15;
        margin-bottom: 16px;
    }

    .koleksi-hero-overlay p {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.78);
        line-height: 1.6;
        margin-bottom: 30px;
        max-width: 480px;
    }

    .koleksi-hero-btn {
        display: inline-block;
        background: white;
        color: var(--deep-green);
        font-weight: 800;
        font-size: 0.92rem;
        padding: 13px 30px;
        border-radius: 50px;
        transition: background 0.3s, transform 0.3s;
        width: fit-content;
    }

    .koleksi-hero-btn:hover {
        background: #a8f0c8;
        transform: translateY(-2px);
    }

    .koleksi-riset-card {
        grid-column: 2;
        grid-row: 1;
        border: 1.5px solid #d4e5d9;
        border-radius: 20px;
        padding: 30px;
        display: flex;
        gap: 24px;
        align-items: flex-start;
        background: white;
        transition: box-shadow 0.3s, transform 0.3s;
        cursor: pointer;
    }

    .koleksi-riset-card:hover {
        box-shadow: 0 12px 35px rgba(15, 74, 49, 0.12);
        transform: translateY(-4px);
        border-color: var(--accent-green);
    }

    .koleksi-riset-book-cover {
        min-width: 110px;
        width: 110px;
        height: 155px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(15, 74, 49, 0.18);
        flex-shrink: 0;
    }

    .koleksi-riset-book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .koleksi-riset-book-cover.illustrated {
        background: var(--primary-color);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 14px 12px;
        gap: 8px;
    }

    .koleksi-riset-book-cover.illustrated .book-title-mini {
        font-size: 0.65rem;
        font-weight: 700;
        color: white;
        text-align: center;
        line-height: 1.3;
    }

    .koleksi-riset-book-cover.illustrated .book-sub-mini {
        font-size: 0.55rem;
        color: rgba(255, 255, 255, 0.75);
        text-align: center;
    }

    .koleksi-riset-info .riset-label {
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--primary-color);
        margin-bottom: 10px;
    }

    .koleksi-riset-info h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.45rem;
        font-weight: 900;
        color: var(--text-dark);
        margin-bottom: 14px;
        line-height: 1.2;
    }

    .koleksi-riset-info p {
        font-size: 0.88rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .koleksi-akses-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.88rem;
        font-weight: 800;
        color: var(--primary-color);
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 2px;
        transition: color 0.3s, border-color 0.3s;
        text-decoration: none;
    }

    .koleksi-akses-link:hover {
        color: var(--deep-green);
        border-color: var(--deep-green);
    }

    .koleksi-mini-grid {
        grid-column: 2;
        grid-row: 2;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .koleksi-mini-card {
        border: 1.5px solid #d4e5d9;
        border-radius: 20px;
        padding: 30px 24px;
        background: white;
        text-align: center;
        cursor: pointer;
        transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;
    }

    .koleksi-mini-card:hover {
        box-shadow: 0 12px 35px rgba(15, 74, 49, 0.12);
        transform: translateY(-4px);
        border-color: var(--accent-green);
    }

    .koleksi-mini-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .koleksi-mini-icon svg {
        width: 100%;
        height: 100%;
        color: var(--primary-color);
    }

    .koleksi-mini-card h4 {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .koleksi-mini-card p {
        font-size: 0.83rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* BERITA & KEGIATAN */
    .berita-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 28px;
        perspective: 1000px;
    }

    .news-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(15, 74, 49, 0.08);
        transition: transform 0.1s ease-out;
        transform-style: preserve-3d;
        border: 1.5px solid #e4eeea;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .news-card:hover {
        border-color: var(--accent-green);
    }

    .news-image-wrapper {
        position: relative;
        height: 200px;
        overflow: hidden;
        transform: translateZ(20px);
    }

    .news-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .news-card:hover .news-image-wrapper img {
        transform: scale(1.08);
    }

    .news-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--primary-color);
        color: white;
        padding: 5px 12px;
        font-size: 0.7rem;
        font-weight: 800;
        border-radius: 50px;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(15, 74, 49, 0.25);
        z-index: 2;
    }

    .news-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        transform: translateZ(30px);
    }

    .news-meta {
        display: flex;
        gap: 15px;
        font-size: 0.75rem;
        color: #8aa08e;
        margin-bottom: 12px;
        font-weight: 600;
    }

    .news-meta span i {
        color: var(--primary-color);
        margin-right: 5px;
    }

    .news-title {
        font-size: 1.1rem;
        color: var(--text-dark);
        margin-bottom: 12px;
        line-height: 1.4;
        font-weight: 700;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-excerpt {
        font-size: 0.86rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-footer {
        margin-top: auto;
        border-top: 1px solid #eaf2ed;
        padding-top: 14px;
    }

    .read-more-btn {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: 0.3s;
    }

    .read-more-btn:hover {
        color: var(--deep-green);
        gap: 10px;
    }

    /* TESTIMONIALS */
    .testimonials-wrapper {
        padding: 60px 0;
        background-color: #edf5f0;
        position: relative;
    }

    .testimonial-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .testimonial-header h2 {
        font-family: 'Playfair Display', serif;
        color: var(--text-dark);
        font-size: 2.4rem;
        margin-bottom: 10px;
    }

    .testimonial-header p {
        color: var(--text-muted);
        max-width: 540px;
        margin: 0 auto;
    }

    .testimonial-container-box {
        overflow: hidden;
        width: 100%;
        max-width: 1140px;
        margin: 0 auto;
        padding: 10px 0 40px;
        position: relative;
    }

    .testimonial-slider {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        width: max-content;
    }

    .testimonial-card {
        background: white;
        width: 350px;
        min-width: 350px;
        margin: 0 15px;
        padding: 35px 25px;
        border-radius: 20px;
        box-shadow: 0 8px 28px rgba(15, 74, 49, 0.08);
        text-align: center;
        position: relative;
        border: 1.5px solid #e0ece6;
        transition: 0.4s;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        border-color: var(--accent-green);
    }

    .profile-wrapper {
        width: 90px;
        height: 90px;
        margin: 0 auto 20px;
        border-radius: 50%;
        padding: 5px;
        border: 2px solid var(--accent-green);
    }

    .profile-wrapper img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .stars {
        color: #f5a623;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .testimonial-text {
        font-style: italic;
        color: var(--text-muted);
        font-size: 0.92rem;
        margin-bottom: 25px;
        line-height: 1.7;
    }

    .user-info h4 {
        color: var(--text-dark);
        font-size: 1.05rem;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .user-info span {
        font-size: 0.78rem;
        color: var(--primary-color);
        font-weight: 700;
        text-transform: uppercase;
    }

    .control-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: white;
        color: var(--primary-color);
        border: 2px solid var(--border-color);
        width: 48px;
        height: 48px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: 0.3s;
        box-shadow: 0 4px 14px rgba(15, 74, 49, 0.12);
        z-index: 10;
    }

    .control-btn:hover {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: translateY(-50%) scale(1.1);
    }

    .prev-btn {
        left: 10px;
    }

    .next-btn {
        right: 10px;
    }

    /* RESPONSIVE */
    @media (max-width: 1100px) {
        .koleksi-unggulan-grid {
            grid-template-columns: 1fr;
        }

        .koleksi-hero-card {
            grid-column: 1;
            grid-row: 1;
            min-height: 400px;
        }

        .koleksi-riset-card {
            grid-column: 1;
            grid-row: 2;
        }

        .koleksi-mini-grid {
            grid-column: 1;
            grid-row: 3;
        }

        .grid-layanan-modern {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .koleksi-mini-grid {
            grid-template-columns: 1fr;
        }

        .koleksi-unggulan-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .koleksi-unggulan-header-left h2 {
            font-size: 2rem;
        }

        .grid-layanan-modern {
            grid-template-columns: 1fr;
        }

        .card-layanan:nth-child(5),
        .card-layanan:nth-child(6) {
            grid-column: span 1;
        }
    }
</style>
@endpush

@section('hero')
<section class="hero" data-aos="fade-up" data-aos-duration="1000">
    <h2 data-aos="fade-down" data-aos-delay="300">Gerbang Literasi Keperawatan HKBP</h2>
    <p data-aos="fade-up" data-aos-delay="500">Akses menyeluruh ke ribuan koleksi literatur medis, jurnal klinis terakreditasi, dan arsip penelitian eksklusif untuk mendukung keunggulan akademik di Akper HKBP Balige.</p>
    <form class="search-container" onsubmit="handleSearch(event)" data-aos="zoom-in" data-aos-delay="800">
        <select>
            <option value="all">Semua</option>
            <option value="jurnal">Jurnal Medis</option>
            <option value="buku">Buku Keperawatan</option>
        </select>
        <input type="text" placeholder="Cari referensi medis, buku, atau artikel ilmiah...">
        <button type="submit" class="search-btn"><i class="fas fa-search"></i> Cari Katalog</button>
    </form>
</section>
@endsection

@section('content')
<section class="feature-section">
    <div class="feature-grid">
        <div class="feature-card animate-float" data-aos="fade-up" data-aos-delay="100">
            <i class="far fa-list-alt"></i>
            <h3>Jurnal Elektronik</h3>
            <p>Akses e-jurnal penting bagi peneliti dan mahasiswa untuk menemukan dan mengunduh artikel akademis secara online.</p>
        </div>
        <div class="feature-card animate-float" style="animation-delay: 0.5s;" data-aos="fade-up" data-aos-delay="300">
            <i class="far fa-bookmark"></i>
            <h3>Buku Elektronik</h3>
            <p>Akses eBook memungkinkan pengguna membaca buku digital secara praktis dan mudah melalui perangkat mereka.</p>
        </div>
        <div class="feature-card animate-float" style="animation-delay: 1s;" data-aos="fade-up" data-aos-delay="500">
            <i class="fas fa-graduation-cap"></i>
            <h3>KTI (Karya Tulis Ilmiah)</h3>
            <p>Akses digital ke hasil penelitian dan Karya Tulis Ilmiah mahasiswa sebagai referensi akademik yang kredibel dan teruji.</p>
        </div>
        <div class="feature-card" data-aos="fade-up" data-aos-delay="700">
            <i class="fas fa-book"></i>
            <h3>Buku Tercetak</h3>
            <p>Koleksi buku fisik keperawatan dan medis yang tersedia secara lengkap di rak perpustakaan untuk peminjaman luring.</p>
        </div>
    </div>
</section>

<section class="jam-layanan-section" data-aos="fade-left" data-aos-duration="1000">
    <div class="jam-banner">
        <div class="jam-text">
            <h2>Jam Layanan Perpustakaan</h2>
            <a href="#" class="info-btn">Informasi Lengkap <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="jam-table">
            <div class="jam-row"><span>Senin</span><span>08.30 - 20.00 WIB</span></div>
            <div class="jam-row"><span>Selasa - Jumat</span><span>08.00 - 20.00 WIB</span></div>
            <div class="jam-row"><span>Sabtu - Minggu</span><span class="status-tutup">TUTUP</span></div>
        </div>
    </div>
</section>

<div class="matrix-wrapper-layanan">
    <canvas id="matrix-canvas-layanan"></canvas>
    <section class="section-container">
        <div class="label-header" data-aos="fade-right">
            <i class="fas fa-stethoscope"></i> Layanan Perpustakaan
        </div>
        <div class="grid-layanan-modern">
            <div class="card-layanan" data-aos="flip-left" data-aos-delay="100">
                <i class="fas fa-search"></i>
                <h3>Katalog Online</h3>
                <p>Katalog online memudahkan pengguna menjelajahi berbagai koleksi perpustakaan secara efisien.</p>
            </div>
            <div class="card-layanan" data-aos="flip-left" data-aos-delay="200">
                <i class="fas fa-book-open"></i>
                <h3>Repositori</h3>
                <p>Menyimpan karya ilmiah mahasiswa dan dosen dalam format digital yang mudah diakses kapan saja.</p>
            </div>
            <div class="card-layanan" data-aos="flip-left" data-aos-delay="300">
                <i class="fas fa-archive"></i>
                <h3>Arsip Dupak Dosen</h3>
                <p>Layanan pengelolaan arsip angka kredit bagi dosen untuk keperluan administratif dan karir.</p>
            </div>
            <div class="card-layanan" data-aos="flip-left" data-aos-delay="400">
                <i class="fas fa-file-invoice"></i>
                <h3>Cek Pinjaman</h3>
                <p>Memantau status peminjaman buku dan masa pengembalian dengan sistem yang terintegrasi.</p>
            </div>
            <div class="card-layanan" data-aos="fade-up" data-aos-delay="500">
                <i class="fas fa-map"></i>
                <h3>Panduan Sumberdaya</h3>
                <p>Informasi mendalam mengenai cara menggunakan seluruh fasilitas dan koleksi perpustakaan.</p>
            </div>
            <div class="card-layanan" data-aos="fade-up" data-aos-delay="600">
                <i class="fas fa-binoculars"></i>
                <h3>EBSCO DISCOVERY</h3>
                <p>Mesin pencari terpadu untuk mencari artikel jurnal internasional berkualitas secara instan.</p>
            </div>
        </div>
    </section>
</div>

<section class="section-container" style="background: #f4f7f5;">
    <div class="label-header" data-aos="fade-right">
        <i class="fas fa-chart-pie"></i> Perpustakaan Dalam Angka
    </div>
    <div class="stats-grid">
        <div class="stat-item" data-aos="zoom-in" data-aos-delay="100">
            <div class="stat-info"><span>3.200+</span><p>Mahasiswa Terdaftar</p></div>
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stat-item" data-aos="zoom-in" data-aos-delay="200">
            <div class="stat-info"><span>12.500</span><p>Buku Dipinjam</p></div>
            <i class="fas fa-book-reader"></i>
        </div>
        <div class="stat-item" data-aos="zoom-in" data-aos-delay="300">
            <div class="stat-info"><span>8.000+</span><p>Koleksi Medis</p></div>
            <i class="fas fa-notes-medical"></i>
        </div>
        <div class="stat-item" data-aos="zoom-in" data-aos-delay="400">
            <div class="stat-info"><span>250</span><p>Pengunjung Harian</p></div>
            <i class="fas fa-users-cog"></i>
        </div>
    </div>

    <section class="koleksi-unggulan-section">
        <div class="koleksi-unggulan-header" data-aos="fade-up">
            <div class="koleksi-unggulan-header-left">
                <div class="subtitle-label">Kurasi Pustakawan</div>
                <h2>Koleksi Unggulan</h2>
            </div>
            <a href="#" class="koleksi-lihat-semua">
                Lihat Semua Koleksi <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="koleksi-unggulan-grid">
            <div class="koleksi-hero-card" data-aos="fade-right" data-aos-duration="800">
                <img src="https://images.unsplash.com/photo-1532012197367-2d5970d7b5c3?q=80&w=800&auto=format&fit=crop" alt="Jurnal Medis Klasik">
                <div class="koleksi-hero-overlay">
                    <span class="koleksi-hero-badge">Jurnal Medis</span>
                    <h3>Jurnal Medis Klasik</h3>
                    <p>Koleksi langka catatan medis dan perkembangan kedokteran dari masa kolonial hingga awal kemerdekaan Indonesia.</p>
                    <a href="#" class="koleksi-hero-btn">Pelajari Sejarah</a>
                </div>
            </div>

            <div class="koleksi-riset-card" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100">
                <div class="koleksi-riset-book-cover illustrated">
                    <i class="fas fa-plus" style="font-size:1.4rem;color:rgba(255,255,255,0.35);"></i>
                    <div class="book-title-mini">TESIS<br>KLINIS MODERN</div>
                    <div class="book-sub-mini">Pendekatan Bukti<br>untuk Praktik<br>Klinis</div>
                </div>
                <div class="koleksi-riset-info">
                    <div class="riset-label">Riset Modern</div>
                    <h3>Tesis Klinis Modern</h3>
                    <p>Kumpulan penelitian terbaru mahasiswa mengenai manajemen perawatan kritis di era transformasi digital.</p>
                    <a href="#" class="koleksi-akses-link">Akses Repository <i class="fas fa-arrow-right" style="font-size:0.75rem;"></i></a>
                </div>
            </div>

            <div class="koleksi-mini-grid" data-aos="fade-up" data-aos-delay="200">
                <div class="koleksi-mini-card">
                    <div class="koleksi-mini-icon">
                        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="18" y="10" width="10" height="5" rx="2" fill="currentColor" opacity="0.3"/>
                            <rect x="20" y="14" width="6" height="28" rx="3" fill="currentColor" opacity="0.6"/>
                            <circle cx="23" cy="48" r="5" fill="currentColor" opacity="0.8"/>
                            <rect x="38" y="8" width="8" height="4" rx="2" fill="currentColor" opacity="0.3"/>
                            <rect x="40" y="12" width="4" height="22" rx="2" fill="currentColor" opacity="0.6"/>
                            <path d="M38 34 h8 v4 a4 4 0 0 1-8 0 v-4z" fill="currentColor" opacity="0.8"/>
                            <line x1="41" y1="18" x2="43" y2="18" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="41" y1="22" x2="43" y2="22" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="41" y1="26" x2="43" y2="26" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h4>Farmakologi</h4>
                    <p>Referensi komprehensif obat-obatan dan farmakokinetika terbaru.</p>
                </div>
                <div class="koleksi-mini-card">
                    <div class="koleksi-mini-icon">
                        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="32" cy="20" r="10" stroke="currentColor" stroke-width="2.5" fill="none" opacity="0.8"/>
                            <circle cx="28" cy="18" r="1.5" fill="currentColor" opacity="0.8"/>
                            <circle cx="36" cy="18" r="1.5" fill="currentColor" opacity="0.8"/>
                            <path d="M28 23 Q32 27 36 23" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.8"/>
                            <path d="M24 34 Q24 30 32 30 Q40 30 40 34 L40 46 Q40 48 38 48 H26 Q24 48 24 46 Z" fill="currentColor" opacity="0.2"/>
                            <line x1="32" y1="35" x2="32" y2="45" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.7"/>
                            <line x1="27" y1="39" x2="37" y2="39" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.7"/>
                        </svg>
                    </div>
                    <h4>Keperawatan Anak</h4>
                    <p>Spesialisasi perawatan pediatrik dan manajemen neonatologi.</p>
                </div>
            </div>
        </div>
    </section>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;" data-aos="fade-up">
        <div class="label-header" style="margin-bottom:0;"><i class="fas fa-bullhorn"></i> Berita & Kegiatan</div>
        <a href="#" style="color:var(--primary-color);font-weight:800;font-size:0.9rem;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid var(--primary-color);padding-bottom:2px;">Semua Berita <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="berita-grid">
        <div class="news-card tilt-effect" data-aos="fade-up" data-aos-delay="100">
            <div class="news-image-wrapper"><span class="news-badge">Workshop</span><img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=500&q=60" alt="News 1"></div>
            <div class="news-body">
                <div class="news-meta"><span><i class="far fa-calendar-alt"></i> 12 Okt 2024</span><span><i class="far fa-user"></i> Admin</span></div>
                <h4 class="news-title">Workshop Literasi Medis: Cara Mengakses Jurnal Internasional</h4>
                <p class="news-excerpt">Tingkatkan kemampuan riset Anda dengan mempelajari teknik pencarian database jurnal internasional seperti EBSCO dan Scopus bersama ahli perpustakaan.</p>
                <div class="news-footer"><a href="#" class="read-more-btn">Baca Selengkapnya <i class="fas fa-chevron-right"></i></a></div>
            </div>
        </div>
        <div class="news-card tilt-effect" data-aos="fade-up" data-aos-delay="200">
            <div class="news-image-wrapper"><span class="news-badge">Koleksi</span><img src="https://images.unsplash.com/photo-1581056771107-24ca5f033842?auto=format&fit=crop&w=500&q=60" alt="News 2"></div>
            <div class="news-body">
                <div class="news-meta"><span><i class="far fa-calendar-alt"></i> 08 Okt 2024</span><span><i class="far fa-user"></i> Pustakawan</span></div>
                <h4 class="news-title">Penambahan Koleksi Buku Keperawatan Gawat Darurat Edisi Terbaru</h4>
                <p class="news-excerpt">Perpustakaan AKPER HKBP baru saja menambah 50 judul buku terbaru mengenai penanganan gawat darurat dan intensif untuk mendukung kurikulum terbaru.</p>
                <div class="news-footer"><a href="#" class="read-more-btn">Baca Selengkapnya <i class="fas fa-chevron-right"></i></a></div>
            </div>
        </div>
        <div class="news-card tilt-effect" data-aos="fade-up" data-aos-delay="300">
            <div class="news-image-wrapper"><span class="news-badge">Event</span><img src="https://images.unsplash.com/photo-1527613426441-4da17471b66d?auto=format&fit=crop&w=500&q=60" alt="News 3"></div>
            <div class="news-body">
                <div class="news-meta"><span><i class="far fa-calendar-alt"></i> 17 Sep 2024</span><span><i class="far fa-user"></i> Humas</span></div>
                <h4 class="news-title">Perayaan Hari Perawat Nasional di Lingkungan AKPER HKBP</h4>
                <p class="news-excerpt">Rayakan kebersamaan dalam memperingati Hari Perawat Nasional dengan rangkaian seminar kesehatan dan lomba edukasi literasi keperawatan.</p>
                <div class="news-footer"><a href="#" class="read-more-btn">Baca Selengkapnya <i class="fas fa-chevron-right"></i></a></div>
            </div>
        </div>
        <div class="news-card tilt-effect" data-aos="fade-up" data-aos-delay="400">
            <div class="news-image-wrapper"><span class="news-badge">Sosial</span><img src="https://images.unsplash.com/photo-1505751172676-43ad3358c38c?auto=format&fit=crop&w=500&q=60" alt="News 4"></div>
            <div class="news-body">
                <div class="news-meta"><span><i class="far fa-calendar-alt"></i> 05 Sep 2024</span><span><i class="far fa-user"></i> Admin</span></div>
                <h4 class="news-title">Program Pengabdian Masyarakat: Literasi Kesehatan di Panti Asuhan</h4>
                <p class="news-excerpt">Mahasiswa dan Pustakawan AKPER HKBP berkolaborasi memberikan edukasi kesehatan dasar dan donasi buku bacaan ke panti asuhan sekitar.</p>
                <div class="news-footer"><a href="#" class="read-more-btn">Baca Selengkapnya <i class="fas fa-chevron-right"></i></a></div>
            </div>
        </div>
    </div>
</section>

<section class="testimonials-wrapper">
    <div class="testimonial-header" data-aos="fade-up">
        <h2>Testimonials</h2>
        <div style="width:80px;height:3px;background:var(--primary-color);margin:10px auto;border-radius:2px;"></div>
        <p>Apa kata mereka tentang pengalaman menggunakan layanan perpustakaan digital Sekolah Keperawatan HKBP Balige.</p>
    </div>
    <div class="testimonial-container-box" data-aos="fade-up">
        <button class="control-btn prev-btn" onclick="moveSlide(-1)"><i class="fas fa-chevron-left"></i></button>
        <button class="control-btn next-btn" onclick="moveSlide(1)"><i class="fas fa-chevron-right"></i></button>
        <div class="testimonial-slider" id="testimonialSlider">
            <div class="testimonial-card">
                <div class="profile-wrapper"><img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=200&auto=format&fit=crop" alt="User"></div>
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p class="testimonial-text">Layanan jurnal elektroniknya sangat membantu saya dalam menyusun Tugas Akhir. Koleksinya sangat update dan relevan dengan dunia medis saat ini.</p>
                <div class="user-info"><h4>Amanda Wilson</h4><span>Mahasiswa Keperawatan</span></div>
            </div>
            <div class="testimonial-card">
                <div class="profile-wrapper"><img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=200&auto=format&fit=crop" alt="User"></div>
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p class="testimonial-text">Ruang baca yang tenang dan sistem pinjam buku online-nya sangat praktis. Sebagai dosen, saya sangat dimudahkan dalam mencari referensi pengajaran.</p>
                <div class="user-info"><h4>Ryan Thompson</h4><span>Dosen Medis</span></div>
            </div>
            <div class="testimonial-card">
                <div class="profile-wrapper"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200&auto=format&fit=crop" alt="User"></div>
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p class="testimonial-text">Akses E-Book 24 jam memungkinkan saya belajar kapan saja, bahkan saat praktek lapangan. Perpustakaan ini benar-benar mendukung kompetensi kami.</p>
                <div class="user-info"><h4>Rachel Chen</h4><span>Alumni Perawat</span></div>
            </div>
            <div class="testimonial-card">
                <div class="profile-wrapper"><img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=200&auto=format&fit=crop" alt="User"></div>
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p class="testimonial-text">Pengalaman meminjam buku jadi jauh lebih modern. Katalog online-nya sangat membantu saya mencari buku dalam hitungan detik.</p>
                <div class="user-info"><h4>Budi Santoso</h4><span>Mahasiswa</span></div>
            </div>
        </div>
    </div>
</section>
@endsection
