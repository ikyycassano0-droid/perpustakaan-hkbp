<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HKBP Dashboard - Sistem Informasi Perpustakaan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #0B2B40 0%, #0A1C2A 100%);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 30px 24px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2E8B57, #1E6B3F);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .logo-icon i {
            font-size: 30px;
            color: white;
        }

        .sidebar-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }

        .sidebar-header p {
            font-size: 0.7rem;
            opacity: 0.7;
            margin: 5px 0 0;
        }

        .nav-section {
            padding: 0 24px;
            margin: 20px 0 10px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.5);
        }

        .sidebar .nav-item {
            margin: 5px 16px;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 16px;
            border-radius: 12px;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .sidebar .nav-link:hover {
            background: rgba(46, 139, 86, 0.2);
            color: white;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #2E8B57, #1E6B3F);
            color: white;
            box-shadow: 0 4px 15px rgba(46, 139, 86, 0.3);
        }

        .sidebar .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
        }

        /* Top Navigation */
        .top-nav {
            background: white;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .page-title h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a2c3e;
            margin: 0;
        }

        .page-title p {
            font-size: 0.85rem;
            color: #6c757d;
            margin: 5px 0 0;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
        }

        .notification-icon i {
            font-size: 1.3rem;
            color: #6c757d;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #2E8B57, #1E6B3F);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-details {
            text-align: right;
        }

        .user-name {
            font-weight: 700;
            color: #1a2c3e;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6c757d;
        }

        /* Content Area */
        .content-area {
            padding: 32px;
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, #2E8B57 0%, #1E6B3F 100%);
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 32px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .welcome-card h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-card p {
            opacity: 0.9;
            margin-bottom: 0;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #1a2c3e;
            margin: 10px 0 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .stat-change {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .stat-change.positive {
            color: #2E8B57;
        }

        .stat-change.negative {
            color: #dc3545;
        }

        /* Chart Cards */
        .chart-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            height: 100%;
            transition: all 0.3s;
        }

        .chart-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-header h5 {
            font-weight: 700;
            color: #1a2c3e;
            margin: 0;
        }

        .chart-header i {
            color: #2E8B57;
            font-size: 1.2rem;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h5 {
            font-weight: 700;
            color: #1a2c3e;
            margin: 0;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #2E8B57, #1E6B3F);
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 139, 86, 0.3);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8f9fa;
            border: none;
            padding: 12px 16px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #495057;
        }

        .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-active {
            background: #d4edda;
            color: #155724;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content-area {
                padding: 20px;
            }
            .top-nav {
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->

<!-- Main Content -->
<div class="main-content">
    @yield('admin_content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>