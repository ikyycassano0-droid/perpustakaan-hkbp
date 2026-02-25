<!DOCTYPE html>
<html lang="en">
<head>
    <title>ModernAdmin | Dashboard Precision UI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* --- ENGINE DARK/LIGHT MODE --- */
        :root {
            --bg-body: #0b111e;
            --bg-card: #151c2c;
            --bg-sidebar: #111827;
            --bg-sidebar-footer: #0f172a;
            --border-color: #1f2937;
            --text-main: #ffffff;
            --text-muted: #94a3b8;
            --primary: #3b82f6;
            --success: #10b981;
            --search-bg: #111827;
        }

        body.light-mode {
            --bg-body: #f4f7fa;
            --bg-card: #ffffff;
            --bg-sidebar: #ffffff;
            --bg-sidebar-footer: #f8fafc;
            --border-color: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --search-bg: #ffffff;
        }

        body {
            background-color: var(--bg-body) !important;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            margin: 0;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .pcoded-navbar {
            background: var(--bg-sidebar) !important;
            border-right: 1px solid var(--border-color);
            width: 260px;
            transition: background 0.3s ease;
        }
        .pcoded-inner-navbar { padding: 15px 10px !important; }
        .pcoded-navbar .pcoded-mtext, .pcoded-navbar a { color: var(--text-main); }
        
        .pcoded-menu-caption { 
            padding: 20px 20px 5px !important; 
            color: var(--text-muted) !important;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .nav-item a { border-radius: 8px; margin: 2px 10px; padding: 12px 15px !important; }
        .nav-item.active a { background: rgba(59, 130, 246, 0.1) !important; color: var(--primary) !important; }

        .sidebar-user-footer {
            position: absolute; bottom: 0; width: 100%;
            padding: 15px 20px; background: var(--bg-sidebar-footer) !important;
            border-top: 1px solid var(--border-color);
            display: flex; align-items: center;
            transition: background 0.3s ease;
        }

        .pcoded-header {
            background: var(--bg-body) !important;
            border-bottom: 1px solid var(--border-color);
            height: 70px;
            padding: 0 30px !important;
            display: flex; align-items: center;
            transition: background 0.3s ease;
        }
        
        #theme-toggle, .logout-trigger { cursor: pointer; transition: transform 0.2s; }
        #theme-toggle:hover, .logout-trigger:hover { transform: scale(1.1); color: var(--primary) !important; }

        .search-wrapper { position: relative; width: 400px; }
        .search-wrapper i { position: absolute; left: 15px; top: 12px; color: var(--text-muted); }
        .search-input {
            background: var(--search-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            padding: 10px 45px !important;
            border-radius: 10px !important;
            width: 100%; height: 44px;
        }
        .search-badge {
            position: absolute; right: 12px; top: 10px;
            background: var(--bg-sidebar-footer); color: var(--text-muted);
            padding: 2px 8px; border-radius: 6px; font-size: 11px;
            border: 1px solid var(--border-color);
        }

        .pcoded-main-container { margin-left: 260px; background: var(--bg-body) !important; transition: background 0.3s ease; }
        .pcoded-content { padding: 30px !important; }

        .card { 
            background: var(--bg-card) !important; 
            border-radius: 16px !important; 
            border: none !important;
            margin-bottom: 24px;
            color: var(--text-main);
            transition: background 0.3s ease;
        }

        .greeting-card {
            background: linear-gradient(135deg, #1e293b, #0f172a) !important;
            min-height: 200px;
            position: relative;
            color: #ffffff !important;
        }
        .greeting-img {
            position: absolute; right: 30px; bottom: 20px;
            width: 180px; opacity: 0.8;
        }

        .stat-card {
            height: 200px;
            display: flex; flex-direction: column;
            justify-content: space-between;
            padding: 25px;
        }
        .stat-icon-box {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(255,255,255,0.05);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }

        .donut-container {
            width: 240px; height: 240px; border-radius: 50%;
            margin: 20px auto; border: 15px solid var(--primary);
            border-left-color: #f59e0b; border-bottom-color: var(--success); border-top-color: #06b6d4;
            display: flex; align-items: center; justify-content: center;
        }

        .progress-custom {
            height: 12px; background: var(--border-color); border-radius: 20px;
            margin-bottom: 25px; overflow: hidden;
        }
        .progress-bar-custom { border-radius: 20px; height: 100%; }

        .f-12 { font-size: 12px; }
        .text-muted { color: var(--text-muted) !important; }
    </style>
</head>

<body>
    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Sidebar -->
    <nav class="pcoded-navbar">
        <div class="navbar-wrapper">
            <div class="navbar-content">
                <div class="p-4"><h4 class="font-weight-bold">ModernAdmin</h4></div>
                <ul class="nav pcoded-inner-navbar">
                    <li class="nav-item active"><a href="#"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a></li>
                    <li class="nav-item pcoded-menu-caption"><label>APPS</label></li>
                    <li class="nav-item"><a href="#"><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">Calendar</span></a></li>
                    <li class="nav-item"><a href="#"><span class="pcoded-micon"><i class="feather icon-list"></i></span><span class="pcoded-mtext">Kanban Board</span></a></li>
                    <li class="nav-item"><a href="#"><span class="pcoded-micon"><i class="feather icon-message-circle"></i></span><span class="pcoded-mtext">Chat</span></a></li>
                    <li class="nav-item"><a href="#"><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Contacts</span></a></li>
                </ul>
                <div class="sidebar-user-footer">
                    <img src="{{ asset('admin/assets/images/user/avatar-1.jpg') }}" class="img-radius wid-40 mr-3" alt="User">
                    <div class="mr-auto">
                        <h6 class="mb-0 f-13">{{ Auth::user()->name }}</h6>
                        <small class="text-muted">{{ strtoupper(Auth::user()->role) }}</small>
                    </div>
                    <!-- Logout Trigger Icon -->
                    <i class="feather icon-log-out text-muted logout-trigger" title="Logout" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></i>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="pcoded-header">
        <div class="m-header"><a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a></div>
        <div class="search-wrapper ml-3">
            <i class="feather icon-search"></i>
            <input type="text" class="search-input" placeholder="Search...">
            <span class="search-badge">Ctrl+K</span>
        </div>
        <div class="ml-auto d-flex align-items-center">
            <!-- Logout Icon in Header -->
            <i class="feather icon-log-out text-muted px-3 logout-trigger" title="Logout"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></i>
            
            <i class="feather icon-sun text-muted px-3" id="theme-toggle" title="Toggle Theme"></i>
            
            <span class="text-muted px-3 font-weight-bold">US</span>
            <div class="position-relative px-3">
                <i class="feather icon-bell text-muted"></i>
                <span class="badge badge-danger position-absolute" style="top:-5px; right:5px; border-radius:50%; padding:3px 5px; font-size:9px;">3</span>
            </div>
            <img src="{{ asset('admin/assets/images/user/avatar-1.jpg') }}" class="img-radius wid-35 ml-3" alt="User">
        </div>
    </header>

    <!-- Main Content -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <h4 class="mb-1">Dashboard</h4>
                <p class="text-muted f-12">ModernAdmin / Dashboard</p>
            </div>

            <div class="row mt-4">
                <div class="col-xl-6">
                    <div class="card greeting-card p-4">
                        <h6 class="text-white-50">Good day,</h6>
                        <h2 class="font-weight-bold text-white">{{ Auth::user()->name }}!</h2>
                        <div class="mt-5 text-white-50 f-12">
                            <i class="feather icon-calendar mr-2"></i> {{ date('M d, Y') }} &nbsp; 
                            <i class="feather icon-clock mr-2"></i> <span id="real-time"></span>
                        </div>
                        <img src="https://via.placeholder.com/150" class="greeting-img" alt="Illustration">
                    </div>
                </div>

                <div class="col-xl-2 col-md-4">
                    <div class="card stat-card">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted font-weight-bold">ORDERS</small>
                            <div class="stat-icon-box text-primary"><i class="feather icon-shopping-bag"></i></div>
                        </div>
                        <div><h2 class="mb-1 font-weight-bold">9,754</h2><span class="text-success f-12"><i class="feather icon-arrow-up"></i> 1.89%</span></div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card stat-card">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted font-weight-bold">REVENUE</small>
                            <div class="stat-icon-box text-success"><i class="feather icon-dollar-sign"></i></div>
                        </div>
                        <div><h2 class="mb-1 font-weight-bold">$75.21k</h2><span class="text-success f-12"><i class="feather icon-arrow-up"></i> 5.23%</span></div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card stat-card">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted font-weight-bold">GROWTH</small>
                            <div class="stat-icon-box text-info"><i class="feather icon-trending-up"></i></div>
                        </div>
                        <div><h2 class="mb-1 font-weight-bold">+25.08%</h2><span class="text-success f-12"><i class="feather icon-arrow-up"></i> 4.87%</span></div>
                    </div>
                </div>
            </div>

            <!-- Chart Sections (Placeholder) -->
            <div class="row">
                <div class="col-xl-5">
                    <div class="card p-2" style="min-height: 420px;">
                        <div class="chart-header p-3 d-flex justify-content-between"><h6>Store Performance</h6><i class="feather icon-refresh-cw text-muted"></i></div>
                        <div class="card-body">
                            <div class="donut-container">
                                <div class="text-center"><small class="text-muted">Total</small><h1 class="mb-0 font-weight-bold">140</h1></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="card p-2" style="min-height: 420px;">
                        <div class="chart-header p-3 d-flex justify-content-between"><h6>Weekly Insights</h6><i class="feather icon-more-vertical text-muted"></i></div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between f-12 text-muted mb-1"><span>Mon</span><span>65%</span></div>
                                <div class="progress-custom"><div class="progress-bar-custom bg-primary" style="width: 65%;"></div></div>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between f-12 text-muted mb-1"><span>Tue</span><span>78%</span></div>
                                <div class="progress-custom"><div class="progress-bar-custom bg-primary" style="width: 78%;"></div></div>
                            </div>
                            <div class="mb-1">
                                <div class="d-flex justify-content-between f-12 text-muted mb-1"><span>Sat</span><span>95%</span></div>
                                <div class="progress-custom"><div class="progress-bar-custom bg-success" style="width: 95%;"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Assets -->
    <script src="{{ asset('admin/assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugins/bootstrap.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Toggle Logic
            const themeToggle = document.getElementById('theme-toggle');
            const body = document.body;
            const currentTheme = localStorage.getItem('theme');
            
            if (currentTheme === 'light') {
                body.classList.add('light-mode');
                themeToggle.classList.replace('icon-sun', 'icon-moon');
            }

            themeToggle.addEventListener('click', function() {
                body.classList.toggle('light-mode');
                if (body.classList.contains('light-mode')) {
                    themeToggle.classList.replace('icon-sun', 'icon-moon');
                    localStorage.setItem('theme', 'light');
                } else {
                    themeToggle.classList.replace('icon-moon', 'icon-sun');
                    localStorage.setItem('theme', 'dark');
                }
            });

            // Sidebar Toggle
            document.getElementById('mobile-collapse').addEventListener('click', function(e) {
                e.preventDefault();
                body.classList.toggle('navbar-collapsed');
            });

            // Real-time Clock
            function updateTime() {
                const now = new Date();
                document.getElementById('real-time').innerText = now.toLocaleTimeString();
            }
            setInterval(updateTime, 1000);
            updateTime();
        });
    </script>
</body>
</html>