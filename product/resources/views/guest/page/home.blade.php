@extends('guest.component.master')

@section('title', 'Perpustakaan Sekolah Keperawatan HKBP')

@section('hero')
  <section class="hero" data-aos="fade-up" data-aos-duration="1000">
    <h2 data-aos="fade-down" data-aos-delay="300">Gerbang Literasi Keperawatan HKBP</h2>
    <p data-aos="fade-up" data-aos-delay="500">Akses menyeluruh ke ribuan koleksi literatur medis, jurnal klinis terakreditasi, dan arsip penelitian eksklusif untuk mendukung keunggulan akademik di Akper HKBP Balige.</p>

    <form class="search-container" method="GET" action="{{ route('guest.global_search') }}" data-aos="zoom-in" data-aos-delay="800">
      <input type="text" name="keyword" placeholder="Cari referensi medis, buku, atau artikel ilmiah...">
      <button type="submit" class="search-btn"><i class="fas fa-search"></i> Cari Katalog</button>
    </form>
  </section>
@endsection

@push('styles')
  <style>
    /* ============================================
       GAYA KHUSUS UNTUK HALAMAN HOME (GUEST)
       SAMA PERSIS DENGAN USER
    ============================================ */

    /* ---------- HERO SECTION ---------- */
    .hero {
      position: relative;
      min-height: 520px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      background: linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.65)), url('{{ asset("assets/img/AKper.jpeg") }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      color: white;
      padding: 60px 20px 80px;
      overflow: hidden;
    }

    .hero h2 {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      margin-bottom: 16px;
      font-weight: 900;
      letter-spacing: -1px;
      color: white;
      position: relative;
      z-index: 2;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .hero p {
      font-size: 1.15rem;
      margin-bottom: 32px;
      max-width: 650px;
      opacity: 0.92;
      color: rgba(255, 255, 255, 0.95);
      position: relative;
      z-index: 2;
      text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    }

    .search-container {
      background-color: white;
      padding: 8px;
      border-radius: 60px;
      box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.25);
      width: 90%;
      max-width: 800px;
      display: flex;
      gap: 8px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      position: relative;
      z-index: 2;
    }

    .search-container select {
      padding: 12px 20px;
      border: none;
      background: #f0f9f4;
      border-radius: 50px;
      outline: none;
      font-weight: 600;
      color: var(--primary-color);
      cursor: pointer;
    }

    .search-container input {
      flex: 1;
      padding: 12px 20px;
      border: none;
      outline: none;
      font-size: 0.95rem;
      color: var(--text-dark);
      background: transparent;
    }

    .search-btn {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 12px 32px;
      border-radius: 50px;
      cursor: pointer;
      font-weight: 700;
      font-size: 0.9rem;
      transition: 0.3s;
      box-shadow: 0 2px 8px rgba(26, 107, 71, 0.3);
    }

    .search-btn:hover {
      background-color: var(--deep-green);
      transform: scale(0.98);
    }

    /* ---------- FEATURE SECTION ---------- */
    .feature-section {
      padding: 50px 5%;
      background: linear-gradient(to bottom, var(--primary-color) 26%, var(--light-bg) 26%);
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
      border-radius: 24px;
      text-align: center;
      box-shadow: 0 8px 24px rgba(15, 74, 49, 0.08);
      transition: 0.4s ease;
      border: 1px solid #e8f2ec;
    }

    .feature-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 36px rgba(15, 74, 49, 0.12);
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

    /* ---------- JAM LAYANAN ---------- */
    .jam-layanan-section {
      padding: 30px 10%;
      background: var(--light-bg);
    }

    .jam-banner {
      background: linear-gradient(100deg, var(--deep-green) 40%, rgba(15, 74, 49, 0.85) 100%), url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1000&q=80');
      background-size: cover;
      padding: 40px;
      border-radius: 28px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      box-shadow: 0 12px 32px rgba(15, 74, 49, 0.25);
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

    /* ---------- MATRIX / LAYANAN ---------- */
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

    .matrix-wrapper-layanan .section-container {
      padding: 40px 54px;
    }

    .section-container {
      padding: 40px 5%;
      position: relative;
      z-index: 5;
    }

    .label-header {
      background-color: var(--primary-color);
      color: white;
      padding: 8px 30px;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-weight: 700;
      border-radius: 40px;
      margin-bottom: 23px;
      font-size: 0.9rem;
      letter-spacing: 0.5px;
    }

    .grid-layanan-modern {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }

    .card-layanan {
      background: white;
      color: var(--text-dark);
      padding: 28px;
      border-radius: 24px;
      transition: 0.3s;
      text-align: left;
      display: flex;
      flex-direction: column;
      gap: 12px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
      border: 1px solid var(--border-color);
    }

    .card-layanan:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.1);
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

    /* ---------- PERPUSTAKAAN DALAM ANGKA ---------- */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 18px;
      margin-bottom: 50px;
      padding: 10px 60px;
    }

    .stats-label {
      margin-left: 60px;
      margin-bottom: 18px;
      padding: 8px 25px;
    }

    .stat-item {
      background: white;
      padding: 22px;
      border-radius: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border: 1px solid #d4e5d9;
      box-shadow: 0 4px 16px rgba(15, 74, 49, 0.05);
      transition: 0.3s;
    }

    .stat-item:hover {
      border-color: var(--accent-green);
      box-shadow: 0 8px 24px rgba(15, 74, 49, 0.1);
    }

    .stat-item > i {
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

    /* ============================================================
       KOLEKSI UNGGULAN - SAMA PERSIS DENGAN USER
    ============================================================ */
    .koleksi-unggulan-section {
      padding: 40px 7%;
      background: var(--card-bg);
      border-radius: 40px;
      box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.06);
      margin: 55px 57px;
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

    /* GRID UTAMA */
    .koleksi-unggulan-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: auto auto;
      gap: 20px;
      max-width: 1300px;
      margin: 0 auto;
    }

    /* --- CARD BESAR (HERO) --- */
    .koleksi-hero-card {
      grid-column: 1;
      grid-row: 1 / 3;
      border-radius: 28px;
      overflow: hidden;
      position: relative;
      min-height: 600px;
      max-height: 720px;
      cursor: pointer;
      background: var(--deep-green);
    }

    .koleksi-hero-card .card-cover {
      padding: 1px;
      width: 100%;
      height: 100%;
      min-height: 600px;
      max-height: 720px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .koleksi-hero-card .card-cover img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      object-position: center;
      display: block;
      background-color: #f0f4f2;
      transition: transform 0.6s ease, opacity 0.6s ease;
    }

    .koleksi-hero-card:hover .card-cover img {
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
      padding: 30px;
      pointer-events: none;
    }
    .koleksi-hero-overlay a {
      pointer-events: auto;
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
      pointer-events: auto;
    }

    .koleksi-hero-btn:hover {
      background: #a8f0c8;
      transform: translateY(-2px);
    }

    /* --- CARD RISET (KANAN ATAS) --- */
    .koleksi-riset-card {
      grid-column: 2;
      grid-row: 1;
      border: 1px solid #d4e5d9;
      border-radius: 28px;
      padding: 30px;
      display: flex;
      gap: 24px;
      align-items: flex-start;
      background: white;
      transition: box-shadow 0.3s, transform 0.3s;
      cursor: pointer;
      min-height: 210px;
    }

    .koleksi-riset-card:hover {
      box-shadow: 0 12px 35px rgba(15, 74, 49, 0.1);
      transform: translateY(-4px);
      border-color: var(--accent-green);
    }

    .koleksi-riset-book-cover {
      min-width: 110px;
      width: 110px;
      height: 155px;
      flex-shrink: 0;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(15, 74, 49, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--primary-color);
    }

    .koleksi-riset-book-cover img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      display: block;
    }

    .koleksi-riset-book-cover.illustrated {
      flex-direction: column;
      padding: 14px 12px;
      gap: 8px;
      background: var(--primary-color);
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

    /* --- MINI GRID (KANAN BAWAH) --- */
    .koleksi-mini-grid {
      grid-column: 2;
      grid-row: 2;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .koleksi-mini-card {
      border: 1px solid #d4e5d9;
      border-radius: 28px;
      padding: 30px 24px;
      background: white;
      text-align: center;
      cursor: pointer;
      transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 180px;
    }

    .koleksi-mini-card:hover {
      box-shadow: 0 12px 35px rgba(15, 74, 49, 0.1);
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

    /* ---------- BERITA & KEGIATAN ---------- */
    .berita-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      perspective: 1000px;
      padding: 0 53px;
    }

    .news-label {
      background-color: var(--primary-color);
      color: white;
      display: inline-flex;
      align-items: center;
      gap: 20px;
      font-weight: 700;
      border-radius: 40px;
      margin-bottom: 25px;
      font-size: 0.9rem;
      letter-spacing: 0.5px;
      margin-left: 60px;
    }

    .news-card {
      background: white;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 8px 24px rgba(15, 74, 49, 0.06);
      transition: transform 0.2s ease-out;
      transform-style: preserve-3d;
      border: 1px solid #e4eeea;
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
      border-radius: 40px;
      text-transform: uppercase;
      box-shadow: 0 4px 10px rgba(15, 74, 49, 0.25);
      z-index: 2;
    }

    .news-all-link {
      color: var(--primary-color);
      font-weight: 800;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      border-bottom: 2px solid var(--primary-color);
      padding-bottom: 2px;
      text-decoration: none;
      transition: gap 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      margin-right: 53px;
      margin-top: 13px;
    }

    .news-all-link:hover {
      gap: 10px;
      color: var(--deep-green);
      border-color: var(--deep-green);
    }

    .news-body {
      padding: 23px;
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

    /* ---------- REWARD (TOP PEMINJAM) ---------- */
    .reward-wrapper {
      padding: 60px 0;
      background-color: #edf5f0;
    }

    .reward-header {
      text-align: center;
      margin-bottom: 40px;
    }

    .reward-header h2 {
      font-family: 'Playfair Display', serif;
      color: #1a3b2e;
      font-size: 2.4rem;
      margin-bottom: 10px;
    }

    .reward-header-line {
      width: 80px;
      height: 3px;
      background: var(--primary-color);
      margin: 12px auto;
      border-radius: 2px;
    }

    .reward-header p {
      color: #6b7280;
      max-width: 540px;
      margin: 0 auto;
    }

    .reward-container {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
      max-width: 1140px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .reward-card {
      background: white;
      width: 320px;
      padding: 35px 28px 30px;
      border-radius: 28px;
      box-shadow: 0 12px 28px rgba(15, 74, 49, 0.08);
      text-align: center;
      border: 1px solid #e0ece6;
      transition: all 0.3s ease;
    }

    .reward-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 32px rgba(15, 74, 49, 0.12);
      border-color: var(--accent-green);
    }

    .reward-avatar {
      width: 100px;
      height: 100px;
      margin: 0 auto 20px;
      border-radius: 50%;
      overflow: hidden;
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.05);
    }

    .reward-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .reward-stats {
      display: flex;
      justify-content: center;
      gap: 16px;
      margin: 20px 0 24px;
    }

    .stat-badge {
      background: #edf5f0;
      border-radius: 60px;
      padding: 8px 18px;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.02), 0 2px 4px rgba(0, 0, 0, 0.02);
      transition: all 0.2s;
    }

    .stat-badge i {
      font-size: 0.9rem;
      color: var(--primary-color);
    }

    .stat-badge span {
      font-size: 1.1rem;
      font-weight: 800;
      color: #1a3b2e;
      line-height: 1;
    }

    .stat-badge small {
      font-size: 0.7rem;
      font-weight: 600;
      color: #4a6b5c;
      letter-spacing: 0.3px;
    }

    .reward-card:hover .stat-badge {
      background: #e0ece6;
      transform: translateY(-2px);
    }

    .reward-user h4 {
      color: #1a3b2e;
      font-size: 1.15rem;
      margin-bottom: 6px;
      font-weight: 800;
      letter-spacing: -0.2px;
    }

    .reward-user span {
      font-size: 0.75rem;
      color: #2d6a4f;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .reward-empty {
      text-align: center;
      color: #6c7c6f;
      padding: 40px;
    }

    .reward-empty i {
      font-size: 3rem;
      margin-bottom: 12px;
      opacity: 0.5;
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 1100px) {
      .grid-layanan-modern {
        grid-template-columns: repeat(2, 1fr);
      }
      .card-layanan:nth-child(5),
      .card-layanan:nth-child(6) {
        grid-column: span 1;
      }
      .koleksi-unggulan-grid {
        grid-template-columns: 1fr;
      }
      .koleksi-hero-card {
        grid-column: 1;
        grid-row: 1;
        min-height: 500px;
        max-height: 600px;
      }
      .koleksi-hero-card .card-cover {
        min-height: 500px;
        max-height: 600px;
      }
      .koleksi-riset-card {
        grid-column: 1;
        grid-row: 2;
      }
      .koleksi-mini-grid {
        grid-column: 1;
        grid-row: 3;
      }
    }

    @media (max-width: 768px) {
      .hero h2 {
        font-size: 2.2rem;
      }
      .jam-banner {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
      }
      .koleksi-unggulan-header {
        flex-direction: column;
        align-items: flex-start;
      }
      .koleksi-unggulan-header-left h2 {
        font-size: 2rem;
      }
      .koleksi-mini-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 640px) {
      .grid-layanan-modern {
        grid-template-columns: 1fr;
      }
      .search-container {
        flex-wrap: wrap;
        background: transparent;
        box-shadow: none;
      }
      .search-container select,
      .search-container input,
      .search-btn {
        width: 100%;
        border-radius: 50px;
      }
      .feature-grid {
        gap: 15px;
      }
      .stats-grid {
        gap: 12px;
      }
    }

    /* ---------- BACK TO TOP ---------- */
    .back-to-top {
      position: fixed;
      bottom: 32px;
      right: 32px;
      z-index: 9999;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: var(--primary-color);
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 6px 20px rgba(15, 74, 49, 0.35);
      opacity: 0;
      visibility: hidden;
      transform: translateY(16px);
      transition: opacity 0.35s ease, transform 0.35s ease,
                  visibility 0.35s ease, background 0.25s ease,
                  box-shadow 0.25s ease;
    }

    .back-to-top.visible {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .back-to-top:hover {
      background: #1a4a34;
      box-shadow: 0 10px 28px rgba(15, 74, 49, 0.45);
      transform: translateY(-3px);
    }

    .back-to-top:active {
      transform: translateY(0);
      box-shadow: 0 4px 12px rgba(15, 74, 49, 0.3);
    }

    .back-to-top i {
      color: white;
      font-size: 1.1rem;
      line-height: 1;
    }

    .back-to-top::before {
      content: '';
      position: absolute;
      inset: -3px;
      border-radius: 50%;
      background: conic-gradient(
        #1f7d54 var(--scroll-pct, 0%),
        rgba(93, 93, 93, 0.15) var(--scroll-pct, 0%)
      );
      z-index: -1;
      transition: none;
    }

    @media (max-width: 640px) {
      .back-to-top {
        bottom: 20px;
        right: 20px;
        width: 44px;
        height: 44px;
      }
      .back-to-top i {
        font-size: 1rem;
      }
    }
  </style>
@endpush

@section('content')
  {{-- Feature Section --}}
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
      <div class="feature-card animate-float" style="animation-delay: 1.5s;" data-aos="fade-up" data-aos-delay="700">
        <i class="fas fa-book"></i>
        <h3>Buku Tercetak</h3>
        <p>Koleksi buku fisik keperawatan dan medis yang tersedia secara lengkap di rak perpustakaan untuk peminjaman luring.</p>
      </div>
    </div>
  </section>

  {{-- Jam Layanan --}}
  <section class="jam-layanan-section" data-aos="fade-left" data-aos-duration="1000">
    <div class="jam-banner">
      <div class="jam-text">
        <h2>Jam Layanan Perpustakaan</h2>
        <a href="{{ route('waktu.layanan') }}" class="info-btn">Informasi Lengkap <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="jam-table">
        <div class="jam-row"><span>Senin</span><span>08.30 - 20.00 WIB</span></div>
        <div class="jam-row"><span>Selasa - Jumat</span><span>08.00 - 20.00 WIB</span></div>
        <div class="jam-row"><span>Sabtu - Minggu</span><span class="status-tutup">TUTUP</span></div>
      </div>
    </div>
  </section>

  {{-- Layanan --}}
  <div class="matrix-wrapper-layanan">
    <canvas id="matrix-canvas-layanan"></canvas>
    <section class="section-container">
      <div class="label-header" data-aos="fade-right">
        <i class="fas fa-stethoscope"></i> Layanan Perpustakaan
      </div>
      <div class="grid-layanan-modern">
        <div class="card-layanan" data-aos="flip-left" data-aos-delay="100"><i class="fas fa-search"></i><h3>Katalog Online</h3><p>Katalog online memudahkan pengguna menjelajahi berbagai koleksi perpustakaan secara efisien.</p></div>
        <div class="card-layanan" data-aos="flip-left" data-aos-delay="200"><i class="fas fa-book-open"></i><h3>Repositori</h3><p>Menyimpan karya ilmiah mahasiswa dan dosen dalam format digital yang mudah diakses kapan saja.</p></div>
        <div class="card-layanan" data-aos="flip-left" data-aos-delay="300"><i class="fas fa-archive"></i><h3>Arsip Dupak Dosen</h3><p>Layanan pengelolaan arsip angka kredit bagi dosen untuk keperluan administratif dan karir.</p></div>
        <div class="card-layanan" data-aos="flip-left" data-aos-delay="400"><i class="fas fa-file-invoice"></i><h3>Cek Pinjaman</h3><p>Memantau status peminjaman buku dan masa pengembalian dengan sistem yang terintegrasi.</p></div>
        <div class="card-layanan" data-aos="fade-up" data-aos-delay="500"><i class="fas fa-map"></i><h3>Panduan Sumberdaya</h3><p>Informasi mendalam mengenai cara menggunakan seluruh fasilitas dan koleksi perpustakaan.</p></div>
        <div class="card-layanan" data-aos="fade-up" data-aos-delay="600"><i class="fas fa-binoculars"></i><h3>EBSCO DISCOVERY</h3><p>Mesin pencari terpadu untuk mencari artikel jurnal internasional berkualitas secara instan.</p></div>
      </div>
    </section>
  </div>

  <section class="section-container" style="background: #f4f7f5;">
    {{-- Perpustakaan Dalam Angka --}}
    <div class="label-header stats-label" data-aos="fade-right">
      <i class="fas fa-chart-pie"></i> Perpustakaan Dalam Angka
    </div>
    <div class="stats-grid">
      <div class="stat-item" data-aos="zoom-in" data-aos-delay="100"><div class="stat-info"><span>{{ number_format($totalVerifiedUsers ?? 0, 0, ',', '.') }}+</span><p>Mahasiswa Terverifikasi</p></div><i class="fas fa-user-graduate"></i></div>
      <div class="stat-item" data-aos="zoom-in" data-aos-delay="200"><div class="stat-info"><span>{{ number_format($totalLoans ?? 0, 0, ',', '.') }}</span><p>Buku Dipinjam (Aktif)</p></div><i class="fas fa-book-reader"></i></div>
      <div class="stat-item" data-aos="zoom-in" data-aos-delay="300"><div class="stat-info"><span>{{ number_format($totalUniqueTitles ?? 0, 0, ',', '.') }}+</span><p>Total Judul Unik</p></div><i class="fas fa-notes-medical"></i></div>
      <div class="stat-item" data-aos="zoom-in" data-aos-delay="400"><div class="stat-info"><span>{{ number_format($totalPrintedCollections ?? 0, 0, ',', '.') }}</span><p>Koleksi Tercetak</p></div><i class="fas fa-users-cog"></i></div>
    </div>

    {{-- Koleksi Unggulan - SAMA PERSIS DENGAN USER --}}
    <section class="koleksi-unggulan-section">
      <div class="koleksi-unggulan-header" data-aos="fade-up">
        <div class="koleksi-unggulan-header-left">
          <div class="subtitle-label">Kurasi Pustakawan</div>
          <h2>Koleksi Unggulan</h2>
        </div>
        <a href="{{ route('guest.koleksi_elektronik.ebook') }}" class="koleksi-lihat-semua">
          Lihat Semua Koleksi <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      @php
        $topBook = $topBooks->first() ?? null;
      @endphp

      <div class="koleksi-unggulan-grid">
        @if($topBook)
        <div class="koleksi-hero-card" data-aos="fade-right" data-aos-duration="800">
          <div class="card-cover">
            <img src="{{ $topBook->cover_image ? asset('storage/'.$topBook->cover_image) : asset('assets/img/placeholder-book.jpg') }}" alt="{{ $topBook->title }}">
          </div>
          <div class="koleksi-hero-overlay">
            <span class="koleksi-hero-badge">Paling Diminati</span>
            <h3>{{ $topBook->title }}</h3>
            <p>{{ \Str::limit($topBook->description ?? 'Koleksi unggulan perpustakaan.', 120) }}</p>
            <a href="{{ route('login') }}" class="koleksi-hero-btn">Lihat Detail</a>
          </div>
        </div>
        @else
        <div class="koleksi-hero-card" data-aos="fade-right" data-aos-duration="800">
          <div class="card-cover">
            <img src="https://images.unsplash.com/photo-1532012197367-2d5970d7b5c3?q=80&w=800&auto=format&fit=crop" alt="Belum ada data">
          </div>
          <div class="koleksi-hero-overlay">
            <span class="koleksi-hero-badge">Segera Hadir</span>
            <h3>Belum ada peminjaman</h3>
            <p>Buku terpopuler akan muncul setelah ada aktivitas peminjaman.</p>
            <a href="{{ route('guest.koleksi_elektronik.ebook') }}" class="koleksi-hero-btn">Lihat Katalog</a>
          </div>
        </div>
        @endif

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
                <rect x="18" y="10" width="10" height="5" rx="2" fill="currentColor" opacity="0.3" />
                <rect x="20" y="14" width="6" height="28" rx="3" fill="currentColor" opacity="0.6" />
                <circle cx="23" cy="48" r="5" fill="currentColor" opacity="0.8" />
                <rect x="38" y="8" width="8" height="4" rx="2" fill="currentColor" opacity="0.3" />
                <rect x="40" y="12" width="4" height="22" rx="2" fill="currentColor" opacity="0.6" />
                <path d="M38 34 h8 v4 a4 4 0 0 1-8 0 v-4z" fill="currentColor" opacity="0.8" />
                <line x1="41" y1="18" x2="43" y2="18" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                <line x1="41" y1="22" x2="43" y2="22" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                <line x1="41" y1="26" x2="43" y2="26" stroke="white" stroke-width="1.5" stroke-linecap="round" />
              </svg>
            </div>
            <h4>Farmakologi</h4>
            <p>Referensi komprehensif obat-obatan dan farmakokinetika terbaru.</p>
          </div>
          <div class="koleksi-mini-card">
            <div class="koleksi-mini-icon">
              <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="32" cy="20" r="10" stroke="currentColor" stroke-width="2.5" fill="none" opacity="0.8" />
                <circle cx="28" cy="18" r="1.5" fill="currentColor" opacity="0.8" />
                <circle cx="36" cy="18" r="1.5" fill="currentColor" opacity="0.8" />
                <path d="M28 23 Q32 27 36 23" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.8" />
                <path d="M24 34 Q24 30 32 30 Q40 30 40 34 L40 46 Q40 48 38 48 H26 Q24 48 24 46 Z" fill="currentColor" opacity="0.2" />
                <line x1="32" y1="35" x2="32" y2="45" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.7" />
                <line x1="27" y1="39" x2="37" y2="39" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.7" />
              </svg>
            </div>
            <h4>Keperawatan Anak</h4>
            <p>Spesialisasi perawatan pediatrik dan manajemen neonatologi.</p>
          </div>
        </div>
      </div>
    </section>

    {{-- Berita --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;" data-aos="fade-up">
      <div class="label-header news-label" style="margin-bottom:0;"><i class="fas fa-bullhorn"></i> Berita & Kegiatan</div>
      <a href="{{ route('guest.berita.index') }}" class="news-all-link">Semua Berita <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="berita-grid">
      @forelse($berita_terbaru as $berita)
      <div class="news-card tilt-effect" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
        <div class="news-image-wrapper">
          <span class="news-badge">{{ $berita->category }}</span>
          <img src="{{ $berita->image ? asset('storage/'.$berita->image) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=500&q=60' }}" alt="{{ $berita->title }}">
        </div>
        <div class="news-body">
          <div class="news-meta">
            <span><i class="far fa-calendar-alt"></i> {{ $berita->created_at->format('d M Y') }}</span>
            <span><i class="far fa-user"></i> {{ $berita->created_by ?? 'Admin' }}</span>
          </div>
          <h4 class="news-title">{{ $berita->title }}</h4>
          <p class="news-excerpt">{{ $berita->excerpt ?? \Str::limit(strip_tags($berita->content), 100) }}</p>
          <div class="news-footer">
            <a href="{{ route('guest.berita.show', $berita->slug) }}" class="read-more-btn">Baca Selengkapnya <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
      @empty
      <div class="col-span-full text-center text-slate-400 py-10">
        <i class="fas fa-newspaper text-4xl mb-2"></i>
        <p>Belum ada berita terbaru.</p>
      </div>
      @endforelse
    </div>
  </section>

  {{-- Reward --}}
  <section class="reward-wrapper">
    <div class="reward-header" data-aos="fade-up">
      <h2>Peminjam Teraktif</h2>
      <div class="reward-header-line"></div>
      <p>Apresiasi kepada pengguna dengan total peminjaman terbanyak dan paling beragam.</p>
    </div>
    <div class="reward-container" data-aos="fade-up" data-aos-delay="100">
      @forelse($topBorrowers as $borrower)
        <div class="reward-card">
          <div class="reward-avatar">
            <img src="{{ $borrower->avatar }}" alt="{{ $borrower->name }}">
          </div>
          <div class="reward-stats">
            <div class="stat-badge">
              <i class="fas fa-book-open"></i>
              <span>{{ $borrower->total_borrowed }}</span>
              <small>Peminjaman</small>
            </div>
            <div class="stat-badge">
              <i class="fas fa-tags"></i>
              <span>{{ $borrower->distinct_titles }}</span>
              <small>Judul</small>
            </div>
          </div>
          <div class="reward-user">
            <h4>{{ $borrower->name }}</h4>
            <span>{{ $borrower->role->name ?? 'Anggota' }}</span>
          </div>
        </div>
      @empty
        <div class="reward-empty">
          <i class="fas fa-users"></i>
          <p>Belum ada data peminjam teraktif.</p>
        </div>
      @endforelse
    </div>
  </section>

  {{-- Back to Top Button --}}
  <button class="back-to-top" id="backToTop" onclick="scrollToTop()" aria-label="Kembali ke atas">
    <i class="fas fa-chevron-up"></i>
  </button>
@endsection

@push('scripts')
  <script>
    const canvas = document.getElementById('matrix-canvas-layanan');
    if (canvas) {
      const ctx = canvas.getContext('2d');
      let width = canvas.parentElement.clientWidth;
      let height = canvas.parentElement.clientHeight;
      canvas.width = width;
      canvas.height = height;
      const chars = "01";
      const fontSize = 14;
      let columns = Math.floor(width / fontSize);
      let drops = new Array(columns).fill(1);

      function drawMatrix() {
        if (!canvas || !ctx) return;
        ctx.fillStyle = 'rgba(244, 247, 245, 0.08)';
        ctx.fillRect(0, 0, width, height);
        ctx.fillStyle = '#2d6a4f';
        ctx.font = `${fontSize}px monospace`;
        for (let i = 0; i < drops.length; i++) {
          const text = chars[Math.floor(Math.random() * chars.length)];
          ctx.fillText(text, i * fontSize, drops[i] * fontSize);
          if (drops[i] * fontSize > height && Math.random() > 0.975) drops[i] = 0;
          drops[i]++;
        }
      }

      setInterval(drawMatrix, 60);
      window.addEventListener('resize', () => {
        width = canvas.parentElement.clientWidth;
        height = canvas.parentElement.clientHeight;
        canvas.width = width;
        canvas.height = height;
        columns = Math.floor(width / fontSize);
        drops = new Array(columns).fill(1);
      });
    }

    (function () {
      const btn = document.getElementById('backToTop');
      if (!btn) return;

      const SHOW_AFTER = 300;

      function updateProgress() {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const pct = docHeight > 0 ? Math.round((scrollTop / docHeight) * 100) : 0;
        btn.style.setProperty('--scroll-pct', pct + '%');

        if (scrollTop > SHOW_AFTER) {
          btn.classList.add('visible');
        } else {
          btn.classList.remove('visible');
        }
      }

      window.addEventListener('scroll', updateProgress, { passive: true });
      updateProgress();
    })();

    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  </script>
@endpush