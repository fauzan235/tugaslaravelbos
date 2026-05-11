<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen UKS SMKN 1 Purwokerto">
    <title>@yield('title', 'UKS') — Manajemen UKS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
    <style>
        /* ==========================================
           RESET & BASE
           ========================================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            color: #1a1a2e;
            min-height: 100vh;
            display: flex;
        }

        /* ==========================================
           SIDEBAR
           ========================================== */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            color: #fff;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }
        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        .sidebar-brand h2 {
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .sidebar-brand span {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
            display: block;
            margin-top: 4px;
        }
        .sidebar-brand .brand-icon {
            font-size: 2rem;
            margin-bottom: 4px;
        }
        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
            overflow-y: auto;
        }
        .sidebar-nav .nav-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.35);
            padding: 12px 20px 6px;
            font-weight: 600;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        .sidebar-nav a:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            border-left-color: #e94560;
        }
        .sidebar-nav a.active {
            background: rgba(233,69,96,0.15);
            color: #fff;
            border-left-color: #e94560;
        }
        .sidebar-nav a .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-footer .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .sidebar-footer .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e94560, #0f3460);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .sidebar-footer .user-name {
            font-size: 0.85rem;
            font-weight: 600;
        }
        .sidebar-footer .user-role {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.5);
            text-transform: capitalize;
        }
        .sidebar-footer .btn-logout {
            width: 100%;
            padding: 8px;
            background: rgba(233,69,96,0.2);
            border: 1px solid rgba(233,69,96,0.3);
            color: #e94560;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .sidebar-footer .btn-logout:hover {
            background: #e94560;
            color: #fff;
        }

        /* ==========================================
           MAIN CONTENT
           ========================================== */
        .main-content {
            margin-left: 260px;
            flex: 1;
            min-height: 100vh;
        }
        .topbar {
            background: #fff;
            padding: 16px 30px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a1a2e;
        }
        .topbar .breadcrumb {
            font-size: 0.8rem;
            color: #64748b;
        }
        .content-area {
            padding: 24px 30px;
        }

        /* ==========================================
           CARDS
           ========================================== */
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            padding: 24px;
            margin-bottom: 20px;
            transition: box-shadow 0.2s;
        }
        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .card-header h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a2e;
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }
        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .stat-icon.blue { background: linear-gradient(135deg, #667eea, #764ba2); }
        .stat-icon.green { background: linear-gradient(135deg, #11998e, #38ef7d); }
        .stat-icon.orange { background: linear-gradient(135deg, #f2994a, #f2c94c); }
        .stat-icon.red { background: linear-gradient(135deg, #e94560, #c62828); }
        .stat-info .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a2e;
            line-height: 1;
        }
        .stat-info .stat-label {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 4px;
        }

        /* ==========================================
           TABLES
           ========================================== */
        .table-container { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            background: #f8fafc;
            padding: 12px 16px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }
        table td {
            padding: 12px 16px;
            font-size: 0.88rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }
        table tbody tr {
            transition: background 0.15s;
        }
        table tbody tr:hover {
            background: #f8fafc;
        }

        /* ==========================================
           BUTTONS
           ========================================== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-success {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: #fff;
        }
        .btn-success:hover { opacity: 0.9; }
        .btn-warning {
            background: linear-gradient(135deg, #f2994a, #f2c94c);
            color: #fff;
        }
        .btn-warning:hover { opacity: 0.9; }
        .btn-danger {
            background: linear-gradient(135deg, #e94560, #c62828);
            color: #fff;
        }
        .btn-danger:hover { opacity: 0.9; }
        .btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }
        .btn-secondary:hover { background: #cbd5e1; }
        .btn-sm { padding: 6px 12px; font-size: 0.78rem; }
        .btn-group { display: flex; gap: 6px; }

        /* ==========================================
           FORMS
           ========================================== */
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.88rem;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #fff;
            color: #1a1a2e;
        }
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }
        .form-error {
            color: #e94560;
            font-size: 0.78rem;
            margin-top: 4px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ==========================================
           BADGES
           ========================================== */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-secondary { background: #e2e8f0; color: #475569; }

        /* ==========================================
           ALERTS
           ========================================== */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ==========================================
           FILTER BAR
           ========================================== */
        .filter-bar {
            display: flex;
            gap: 12px;
            align-items: flex-end;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 10px;
        }
        .filter-bar .form-group {
            margin-bottom: 0;
            min-width: 180px;
        }
        .filter-bar .form-control {
            padding: 8px 12px;
            font-size: 0.82rem;
        }

        /* ==========================================
           EMPTY STATE
           ========================================== */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: #94a3b8;
        }
        .empty-state .empty-icon {
            font-size: 3rem;
            margin-bottom: 12px;
        }
        .empty-state p {
            font-size: 0.9rem;
        }

        /* ==========================================
           RESPONSIVE
           ========================================== */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #1a1a2e;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .mobile-toggle {
                display: block;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">🏥</div>
            <h2>UKS Digital</h2>
            <span>SMKN 1 Purwokerto</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span> Dashboard
            </a>
            <a href="{{ route('treatments.index') }}" class="{{ request()->routeIs('treatments.*') ? 'active' : '' }}">
                <span class="nav-icon">🩺</span> Kunjungan
            </a>
            <a href="{{ route('medicines.index') }}" class="{{ request()->routeIs('medicines.*') ? 'active' : '' }}">
                <span class="nav-icon">💊</span> Stok Obat
            </a>

            @if(auth()->user()->isAdmin())
                <div class="nav-label">Data Master</div>
                <a href="{{ route('kelas.index') }}" class="{{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                    <span class="nav-icon">🏫</span> Data Kelas
                </a>
                <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
                    <span class="nav-icon">👨‍🎓</span> Data Siswa
                </a>

                <div class="nav-label">Laporan</div>
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <span class="nav-icon">📈</span> Laporan Bulanan
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ auth()->user()->role }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">🚪 Keluar</button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="topbar">
            <div>
                <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button>
                <h1>@yield('title', 'Dashboard')</h1>
            </div>
            <div class="breadcrumb">@yield('breadcrumb')</div>
        </div>

        <div class="content-area">
            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
