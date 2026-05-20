<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Jimpitan Online') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #10B981; /* Emerald 500 */
            --primary-dark: #059669; /* Emerald 600 */
            --primary-light: #34D399; /* Emerald 400 */
            --secondary: #3B82F6; /* Blue 500 */
            --accent: #F59E0B; /* Amber 500 */
            --bg-body: #FFFBEB; /* Cream / Amber 50 Base */
            --text-main: #064E3B; /* Emerald 900 */
            --text-muted: #047857; /* Emerald 700 */
            --sidebar-bg: #FEFCE8; /* Lighter Cream */
            --card-bg: rgba(255, 255, 255, 0.8); /* White Glass */
            --card-border: rgba(16, 185, 129, 0.25); /* Emerald Border */
            --card-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.1), 0 4px 6px -4px rgba(16, 185, 129, 0.05);
            --card-shadow-hover: 0 20px 25px -5px rgba(16, 185, 129, 0.2), 0 8px 10px -6px rgba(16, 185, 129, 0.1);
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.25) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(252, 211, 77, 0.15) 0px, transparent 50%), /* Soft warm glow */
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.25) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(252, 211, 77, 0.15) 0px, transparent 50%);
            background-attachment: fixed;
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Professional Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid rgba(16, 185, 129, 0.2);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 4px 0 15px rgba(0,0,0,0.2);
        }

        .sidebar-header {
            padding: 2.5rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-wrapper {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.4rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .sidebar-brand {
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .sidebar-menu {
            flex: 1;
            padding: 0 1rem;
            list-style: none;
            overflow-y: auto;
        }

        .menu-item {
            margin-bottom: 4px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1rem;
            text-decoration: none;
            color: var(--text-muted);
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .menu-link i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        .menu-link:hover {
            background: rgba(16, 185, 129, 0.15);
            color: var(--text-main);
        }

        .menu-link.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(16, 185, 129, 0.2);
        }

        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1rem;
            background: #FFF1F2;
            border: 1px solid #FECDD3;
            color: #E11D48;
            font-family: inherit;
            font-weight: 700;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: #E11D48;
            color: white;
            border-color: #E11D48;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2.5rem;
            min-height: 100vh;
        }

        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .page-info h1 {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.025em;
        }

        .page-info p {
            color: var(--text-muted);
            font-size: 1rem;
            font-weight: 500;
        }

        .user-pill {
            background: var(--card-bg);
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            backdrop-filter: blur(8px);
        }

        .user-name {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-main);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Professional Cards */
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid var(--card-border);
            box-shadow: var(--card-shadow);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: var(--card-shadow-hover);
            border-color: rgba(16, 185, 129, 0.5);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.875rem;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: rgba(16, 185, 129, 0.1);
            color: var(--primary-light);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.5);
            color: white;
        }

        /* Forms */
        .form-control, input, select, textarea {
            background: rgba(255, 255, 255, 0.9) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--card-border) !important;
        }
        .form-control::placeholder, input::placeholder, textarea::placeholder {
            color: rgba(4, 120, 87, 0.5) !important; /* Emerald 700 with opacity */
        }
        .form-control:focus, input:focus, select:focus, textarea:focus {
            outline: none !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid var(--card-border);
        }

        .alert-success {
            color: #34D399;
            border-left: 4px solid #10B981;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .badge-success { background: rgba(16, 185, 129, 0.2); color: #34D399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .badge-danger { background: rgba(225, 29, 72, 0.2); color: #FDA4AF; border: 1px solid rgba(225, 29, 72, 0.3); }



        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: var(--primary-very-light);
            color: var(--primary-dark);
            border: 1px solid var(--primary-pastel);
        }

        .alert-danger {
            background-color: #FDEDEC;
            color: #C0392B;
            border: 1px solid #F5B7B1;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success { background-color: var(--primary-very-light); color: var(--primary-dark); }
        .badge-danger { background-color: #FDEDEC; color: #C0392B; }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo-wrapper">
                <i class="fas fa-leaf"></i>
            </div>
            <span class="sidebar-brand">Jimpitan Online</span>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('payments.scan') }}" class="menu-link {{ request()->routeIs('payments.scan') ? 'active' : '' }}">
                    <i class="fas fa-qrcode"></i> Scan QR
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('houses.index') }}" class="menu-link {{ request()->routeIs('houses.*') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Data Rumah
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('payments.history') }}" class="menu-link {{ request()->routeIs('payments.history') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Riwayat Bayar
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('expenses.index') }}" class="menu-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-usd"></i> Pengeluaran
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('notifications.index') }}" class="menu-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                    <i class="fab fa-whatsapp"></i> Log Notifikasi
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('reports.index') }}" class="menu-link {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i> Laporan
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('settings.index') }}" class="menu-link {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                    <i class="fas fa-sliders-h"></i> Pengaturan
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-power-off"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <header class="top-nav">
            <div class="page-info">
                <h1>@yield('title')</h1>
                <p>@yield('subtitle', 'Manajemen Iuran Warga RT')</p>
            </div>
            <div class="user-pill">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <div class="user-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
