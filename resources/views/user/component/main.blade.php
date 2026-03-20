<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Area - Perpustakaan Sekolah Keperawatan HKBP</title>
    <!-- Link Font Awesome untuk Ikon -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Desa Taon Marisi</title>
    <link rel="icon" href="{{ asset('assets/img/8.png') }}" type="image/png">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <style>
        /* --- SEMUA STYLE SAMA PERSIS DENGAN SEBELUM LOGIN --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f0f7ff;
            color: #333;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        :root {
            --primary-color: #021e69; 
            --secondary-color: #032a91; 
            --deep-blue: #011445; 
            --accent-yellow: #f1c40f;
            --text-light: #ffffff;
            --dark: #1a1a1a;
            --light-bg: #ebf5fb;
            --blue-gradient-top: #032a91;
            --blue-gradient-bottom: #021e69;
            --logout-red: #e74c3c;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        header {
            background-color: var(--primary-color);
            color: var(--text-light);
            padding: 0.8rem 3%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-img {
            width: 45px;
            height: 45px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: bold;
        }

        .logo-text h1 {
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .logo-text span {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 5px;
        }

        nav ul li {
            position: relative;
        }

        nav ul li a {
            padding: 10px 12px;
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
            color: white;
        }

        nav ul li a:hover {
            color: var(--accent-yellow);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            min-width: 220px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
            border-radius: 4px;
            display: none;
            z-index: 100;
            border-top: 3px solid var(--accent-yellow);
        }

        .dropdown-menu li a {
            color: #333 !important;
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.8rem;
        }

        .dropdown-menu li a:hover {
            background-color: #f8f9fa;
            color: var(--primary-color) !important;
        }

        nav ul li:hover > .dropdown-menu {
            display: block;
        }

        .submenu {
            left: 100%;
            top: 0;
            border-left: 3px solid var(--accent-yellow);
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: bold;
            color: var(--accent-yellow);
        }

        .logout-btn {
            background-color: var(--logout-red);
            color: white !important;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color: white;
            color: var(--logout-red) !important;
            transform: translateY(-2px);
        }

        .hero {
            background: linear-gradient(rgba(2, 30, 105, 0.8), rgba(2, 30, 105, 0.8)), 
                        url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1350&q=80');
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

        .hero h2 { font-size: 2.2rem; margin-bottom: 10px; }
        .hero p { font-size: 1.1rem; margin-bottom: 30px; }

        .search-container {
            background-color: white;
            padding: 12px;
            border-radius: 50px;
            width: 90%;
            max-width: 800px;
            display: flex;
            gap: 10px;
        }

        .search-container select {
            padding: 8px 15px;
            border: none;
            background: #f1f7ff;
            border-radius: 25px;
            color: var(--primary-color);
            font-weight: bold;
        }

        .search-container input { flex: 1; border: none; outline: none; padding: 10px; }

        .search-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
        }

        .feature-section {
            padding: 50px 5%;
            background: linear-gradient(to bottom, var(--primary-color) 40%, #f0f7ff 40%); 
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
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .animate-float { animation: floating 3s ease-in-out infinite; }
        .feature-card i { color: var(--accent-yellow); font-size: 3.5rem; margin-bottom: 20px; display: block; }
        .feature-card h3 { color: var(--primary-color); font-size: 1.2rem; margin-bottom: 15px; }

        /* --- ADDED: JAM LAYANAN BANNER --- */
        .jam-layanan-section { padding: 30px 5%; }
        .jam-banner {
            background: linear-gradient(90deg, var(--primary-color) 40%, rgba(2, 30, 105, 0.7) 100%), 
                        url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            padding: 40px;
            border-radius: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .jam-text h2 { font-size: 1.8rem; margin-bottom: 10px; }
        .jam-table { font-size: 0.95rem; min-width: 280px; }
        .jam-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.2); }

        .section-container { padding: 40px 5%; }
        
        .label-header {
            background-color: var(--primary-color);
            color: white;
            padding: 8px 15px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            border-radius: 3px;
            margin-bottom: 25px;
        }

        .grid-layanan-modern {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .card-layanan {
            background: linear-gradient(180deg, var(--blue-gradient-top), var(--blue-gradient-bottom));
            color: white;
            padding: 25px;
            border-radius: 8px;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .card-layanan:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
        .card-layanan i { font-size: 2.2rem; color: var(--accent-yellow); }
        .card-layanan:nth-child(5), .card-layanan:nth-child(6) { grid-column: span 2; }

        /* --- ADDED: STATS & BERITA --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }
        .stat-item {
            background: white;
            padding: 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #d4e6f1;
        }
        .stat-info span { font-size: 1.4rem; font-weight: bold; color: var(--primary-color); display: block; }
        .stat-item i { font-size: 2rem; color: var(--primary-color); opacity: 0.3; }

        .berita-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }
        .news-item { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .news-thumb { height: 160px; background-size: cover; background-position: center; position: relative; }
        .news-tag { position: absolute; bottom: 0; width: 100%; background: rgba(2, 30, 105, 0.8); color: white; padding: 5px 10px; font-size: 0.75rem; }
        .news-desc { padding: 15px; }
        .news-desc h4 { font-size: 0.95rem; color: var(--primary-color); line-height: 1.4; }

        .footer {
            background-color: var(--primary-color);
            color: #bdc3c7;
            padding: 4rem 5% 2rem;
            margin-top: 50px;
            text-align: center;
        }

        .copyright {
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 0.85rem;
        }

        @media (max-width: 992px) {
            .grid-layanan-modern { grid-template-columns: repeat(2, 1fr); }
            .card-layanan:nth-child(5), .card-layanan:nth-child(6) { grid-column: span 1; }
        }
    </style>
</head>
<body>

    <div class="content">
        @yield('user_content')
    </div>

<script src="{{URL:: asset('assets/js/main.js') }}"></script>

<script src="{{URL:: asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{URL:: asset('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{URL:: asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{URL:: asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{URL:: asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{URL:: asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{URL:: asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{URL:: asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{URL:: asset('assets/js/main.js') }}"></script>
</body>
</html>