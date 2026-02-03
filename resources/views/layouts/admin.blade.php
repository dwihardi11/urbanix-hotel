<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Urbanix Admin</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --primary: #0a192f;
            --primary-light: #112240;
            --secondary: #1d3557;
            --accent: #e6c68a;
            --accent-light: #f0d9a8;
            --accent-dark: #d4a574;
            --teal: #64ffda;
            --bg-dark: #020c1b;
            --text-primary: #ccd6f6;
            --text-secondary: #8892b0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-light) 100%);
            border-right: 1px solid rgba(230, 198, 138, 0.1);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.75rem 1.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(230, 198, 138, 0.1);
            letter-spacing: 2px;
        }

        .sidebar-brand span { 
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-brand small {
            font-size: 0.7rem;
            opacity: 0.5;
            font-weight: 400;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            padding: 0.75rem 1.5rem 0.5rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent);
            margin-top: 1rem;
            font-weight: 600;
        }

        .nav-item {
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 3px solid transparent;
            margin: 0.25rem 0;
            position: relative;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: linear-gradient(90deg, rgba(230, 198, 138, 0.1), transparent);
            transition: width 0.3s ease;
        }

        .nav-item:hover::before,
        .nav-item.active::before {
            width: 100%;
        }

        .nav-item:hover, .nav-item.active {
            color: var(--text-primary);
            border-left-color: var(--accent);
        }

        .nav-item.active { 
            color: var(--accent);
            background: rgba(230, 198, 138, 0.05);
        }

        .nav-item i {
            width: 24px;
            margin-right: 0.875rem;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
        }

        .nav-item span {
            position: relative;
            z-index: 1;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            background: linear-gradient(180deg, var(--primary-light) 0%, rgba(17, 34, 64, 0.95) 100%);
            backdrop-filter: blur(10px);
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(230, 198, 138, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar h4 {
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .content {
            padding: 2rem;
        }

        /* Cards */
        .stat-card {
            background: linear-gradient(145deg, rgba(17, 34, 64, 0.8), rgba(10, 25, 47, 0.9));
            border-radius: 16px;
            padding: 1.75rem;
            border: 1px solid rgba(230, 198, 138, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(230, 198, 138, 0.3), transparent);
        }

        .stat-card:hover {
            border-color: var(--accent);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3),
                        0 0 30px rgba(230, 198, 138, 0.1);
        }

        .stat-card .icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, rgba(230, 198, 138, 0.2), rgba(230, 198, 138, 0.05));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--accent);
            transition: all 0.4s ease;
        }

        .stat-card:hover .icon {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: var(--primary);
            transform: scale(1.1);
        }

        .stat-card h3 { 
            font-size: 2.25rem; 
            margin: 0.75rem 0 0.25rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--text-primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-card p { 
            color: var(--text-secondary); 
            margin: 0; 
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Tables */
        .table-dark-custom {
            background: linear-gradient(145deg, rgba(17, 34, 64, 0.8), rgba(10, 25, 47, 0.9));
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(230, 198, 138, 0.1);
        }

        .table-dark-custom th {
            background: rgba(0,0,0,0.3);
            color: var(--accent);
            font-weight: 600;
            border: none;
            padding: 1.25rem 1rem;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }

        .table-dark-custom td {
            background: transparent;
            border-bottom: 1px solid rgba(230, 198, 138, 0.05);
            padding: 1.25rem 1rem;
            vertical-align: middle;
            color: var(--text-primary);
        }

        .table-dark-custom tbody tr {
            transition: all 0.3s ease;
        }

        .table-dark-custom tbody tr:hover td {
            background: rgba(230, 198, 138, 0.03);
        }

        /* Buttons */
        .btn-gold {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border: none;
            color: var(--primary);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(230, 198, 138, 0.3);
            color: var(--primary);
        }

        .btn-outline-gold {
            border: 2px solid var(--accent);
            color: var(--accent);
            background: transparent;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-outline-gold:hover {
            background: var(--accent);
            color: var(--primary);
        }

        /* Forms */
        .form-control, .form-select {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(230, 198, 138, 0.15);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.05);
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(230, 198, 138, 0.15);
            color: var(--text-primary);
        }

        .form-label { 
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        /* Badges */
        .badge-gold { 
            background: linear-gradient(135deg, var(--accent), var(--accent-dark)); 
            color: var(--primary);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        .badge-teal {
            background: rgba(100, 255, 218, 0.2);
            color: var(--teal);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        /* Glass Card */
        .glass-card {
            background: linear-gradient(145deg, rgba(17, 34, 64, 0.8), rgba(10, 25, 47, 0.9));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(230, 198, 138, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(230, 198, 138, 0.3), transparent);
        }

        /* Alert styles */
        .alert {
            border: none;
            border-radius: 12px;
        }

        .alert-success {
            background: rgba(100, 255, 218, 0.1);
            color: var(--teal);
            border-left: 4px solid var(--teal);
        }

        .alert-danger {
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
            border-left: 4px solid #ff6b6b;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        /* Pagination Styles */
        .pagination {
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination .page-item .page-link {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(230, 198, 138, 0.15);
            color: var(--text-secondary);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            min-width: 44px;
            text-align: center;
            font-weight: 500;
        }

        .pagination .page-item .page-link:hover {
            background: rgba(230, 198, 138, 0.1);
            border-color: var(--accent);
            color: var(--accent);
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-color: var(--accent);
            color: var(--primary);
            box-shadow: 0 4px 15px rgba(230, 198, 138, 0.3);
        }

        .pagination .page-item.disabled .page-link {
            background: rgba(255,255,255,0.02);
            border-color: rgba(230, 198, 138, 0.05);
            color: var(--text-secondary);
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            border-radius: 10px;
        }

        /* Pagination info text */
        .pagination-info {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        /* Navigation arrows styling */
        nav[aria-label="Pagination Navigation"] {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        nav[aria-label="Pagination Navigation"] p {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin: 0;
        }

        nav[aria-label="Pagination Navigation"] span[aria-current="page"] span {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark)) !important;
            border-color: var(--accent) !important;
            color: var(--primary) !important;
            box-shadow: 0 4px 15px rgba(230, 198, 138, 0.3);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            URBAN<span>IX</span> <small class="ms-2">Admin</small>
        </div>
        
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> <span>Dashboard</span>
            </a>

            <div class="nav-section">Reservations</div>
            <a href="{{ route('admin.bookings.index') }}" class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> <span>Bookings</span>
            </a>
            <a href="{{ route('admin.bookings.calendar') }}" class="nav-item">
                <i class="bi bi-calendar3"></i> <span>Calendar</span>
            </a>
            <a href="{{ route('admin.guests.index') }}" class="nav-item {{ request()->routeIs('admin.guests.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> <span>Guests</span>
            </a>

            <div class="nav-section">Hotel Management</div>
            <a href="{{ route('admin.rooms.index') }}" class="nav-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <i class="bi bi-door-open"></i> <span>Rooms</span>
            </a>
            <a href="{{ route('admin.room-types.index') }}" class="nav-item {{ request()->routeIs('admin.room-types.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> <span>Room Types</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="topbar">
            <h4>@yield('header', 'Dashboard')</h4>
            <div class="d-flex align-items-center gap-3">
                <span class="text-secondary">
                    <i class="bi bi-person-circle me-2"></i>{{ auth()->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-gold btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="content">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
