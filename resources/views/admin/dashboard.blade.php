<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Perpustakaan AKPER HKBP</title>

    <!-- Google Fonts & Font Awesome (Sama dengan Landing Page) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        :root {
            --primary: #021e69;      /* Deep Blue HKBP */
            --secondary: #032a91;    /* Light Blue HKBP */
            --accent: #f1c40f;       /* Yellow Accent */
            --bg-light: #f0f7ff;     /* Background medis */
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            color: #333;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background: var(--primary);
            color: white;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 25px 20px;
            background: rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .logo-box {
            width: 35px;
            height: 35px;
            background: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: bold;
        }

        .user-profile {
            padding: 30px 20px;
            text-align: center;
        }

        .user-profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid var(--accent);
            padding: 3px;
            background: #fff;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .user-profile h6 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .nav-menu {
            list-style: none;
            padding: 0 15px;
        }

        .nav-item { margin-bottom: 5px; }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-link i {
            width: 25px;
            font-size: 1.1rem;
            margin-right: 10px;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--accent);
            color: var(--primary) !important;
            box-shadow: 0 4px 10px rgba(241, 196, 15, 0.3);
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .page-content {
            padding: 30px;
        }

        /* --- STYLED CARDS (Sama dengan Landing Page) --- */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: 0.3s;
        }

        .card:hover { transform: translateY(-5px); }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            padding: 20px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
        }

        .btn-primary:hover { background-color: var(--secondary); }

        .btn-warning {
            background-color: var(--accent);
            border: none;
            color: var(--primary);
            font-weight: 600;
        }

        .logout-btn {
            margin-top: 50px;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
        }

        .logout-link {
            color: #ff7675 !important;
        }

        /* Responsive Mobile */
        @media (max-width: 992px) {
            .sidebar { left: -var(--sidebar-width); }
            .main-content { margin-left: 0; }
            .sidebar.active { left: 0; }
        }
    </style>
    @stack('css')
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-box"><i class="fas fa-plus-square"></i></div>
            <div>
                <h6 class="m-0" style="font-size: 0.8rem;">ADMIN PANEL</h6>
                <small style="font-size: 0.65rem; opacity: 0.7;">Perpus AKPER HKBP</small>
            </div>
        </div>

        <div class="user-profile">
            <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : 'https://ui-avatars.com/api/?background=021e69&color=fff&name='.Auth::user()->name }}" alt="Admin">
            <h6>{{ Auth::user()->name }}</h6>
            <span class="badge badge-pill badge-warning mt-2">Administrator</span>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-md"></i> Manajemen Anggota
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-book-medical"></i> Katalog Buku
                </a>
            </li>
            
            <li class="nav-item logout-btn">
                <a href="#" class="nav-link logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Keluar Sistem
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOPBAR -->
        <nav class="topbar">
            <button class="btn btn-light d-lg-none" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="d-flex align-items-center">
                <i class="far fa-calendar-alt text-muted mr-2"></i>
                <span class="text-muted small font-weight-bold">{{ date('l, d F Y') }}</span>
            </div>
            <div class="ml-auto">
                <div class="dropdown">
                    <a href="#" class="text-dark font-weight-bold" style="text-decoration: none;">
                        <i class="fas fa-hospital-user mr-1 text-primary"></i> Admin HKBP
                    </a>
                </div>
            </div>
        </nav>

        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Toggle Sidebar Mobile
        $('#toggleSidebar').click(function() {
            $('#sidebar').toggleClass('active');
        });

        // Efek smooth fade out untuk alert
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 4000);
    </script>
    @stack('js')
</body>
</html>