<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Portal Sekolah') }} - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-soft: rgba(79, 70, 229, 0.08);
            --primary-glow: rgba(79, 70, 229, 0.25);
            --sidebar-bg: #0b1220;
            --sidebar-hover: rgba(255,255,255,0.06);
            --sidebar-active: #4f46e5;
            --sidebar-width: 272px;
            --header-height: 68px;
            --bg: #0b1220;
            --surface: #151c2e;
            --surface-2: #1a2338;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --border: rgba(148, 163, 184, 0.18);
            --radius: 16px;
            --radius-sm: 12px;
            --shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
            --shadow-lg: 0 12px 40px rgba(15, 23, 42, 0.1);
            --font: 'Inter', system-ui, -apple-system, sans-serif;
        }

        * { box-sizing: border-box; }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background: var(--sidebar-bg);
            color: #94a3b8;
            z-index: 1040;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            overflow-x: hidden;
            border-right: 1px solid rgba(255,255,255,0.04);
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .sidebar-brand {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 1.35rem;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            font-weight: 700;
            font-size: 1.05rem;
            color: #fff;
            letter-spacing: -0.02em;
        }

        .sidebar-brand .brand-icon {
            width: 38px; height: 38px;
            border-radius: 11px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.15rem;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        .sidebar-nav { padding: 1.1rem 0.85rem 2rem; }

        .nav-section {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #475569;
            padding: 1rem 0.85rem 0.4rem;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: #94a3b8;
            border-radius: 11px;
            padding: 0.7rem 0.9rem;
            margin-bottom: 0.15rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
            opacity: 0.85;
        }

        .sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: #e2e8f0;
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .sidebar .nav-link.active i { opacity: 1; }

        /* ===== MAIN ===== */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .topbar {
            height: var(--header-height);
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .topbar h6 {
            font-size: 0.95rem;
            letter-spacing: -0.01em;
        }

        .content { padding: 1.75rem; }

        /* ===== CARDS ===== */
        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--surface);
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.25s ease, transform 0.25s ease, border-color 0.25s ease;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 1.05rem 1.35rem;
            color: var(--text);
        }

        .card-body { padding: 1.35rem; }
        .card-footer {
            background: transparent;
            border-top: 1px solid var(--border);
            padding: 1rem 1.35rem;
        }

        .hover-lift:hover,
        .card.hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
            border-color: #dce3f0;
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--surface);
            box-shadow: var(--shadow-sm);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            background: radial-gradient(circle at top right, var(--primary-soft), transparent 70%);
            pointer-events: none;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow);
            border-color: #c7d2fe;
        }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        /* ===== BUTTONS ===== */
        .btn {
            border-radius: 11px;
            font-weight: 550;
            font-size: 0.9rem;
            padding: 0.55rem 1.15rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            box-shadow: 0 4px 16px rgba(79, 70, 229, 0.4);
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            border: 1.5px solid #c7d2fe;
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary-soft);
            border-color: var(--primary);
            color: var(--primary-hover);
        }

        .btn-lg { padding: 0.75rem 1.5rem; border-radius: 13px; }

        /* ===== FORMS ===== */
        .form-control, .form-select {
            border-radius: 11px;
            border: 1.5px solid var(--border);
            padding: 0.65rem 0.95rem;
            font-size: 0.9rem;
            transition: all 0.2s;
            background: #fff;
        }

        .form-control:focus, .form-select:focus {
            border-color: #a5b4fc;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        .form-control.bg-light { background: #f8fafc !important; }

        /* ===== BADGES ===== */
        .badge {
            font-weight: 550;
            letter-spacing: 0.01em;
            padding: 0.35em 0.7em;
            border-radius: 8px;
        }

        /* ===== LIST GROUP ===== */
        .list-group-item {
            border-color: var(--border);
            padding: 0.95rem 1.25rem;
            transition: background 0.15s;
        }

        .list-group-item-action:hover {
            background: #f8fafc;
        }

        /* ===== TABLE ===== */
        .table {
            --bs-table-bg: transparent;
            font-size: 0.9rem;
        }

        .table thead th {
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-muted);
            border-bottom-width: 1px;
            background: #f8fafc;
        }

        .table-hover tbody tr:hover { background: #f8fafc; }

        /* ===== NAV PILLS (jadwal tabs) ===== */
        .nav-pills .nav-link {
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text-muted);
            padding: 0.5rem 1rem;
            white-space: nowrap;
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            box-shadow: 0 2px 10px rgba(79, 70, 229, 0.3);
        }

        /* ===== USER ===== */
        .user-btn {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 0.3rem 0.9rem 0.3rem 0.3rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text);
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .user-btn:hover {
            border-color: #c7d2fe;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.1);
        }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .dropdown-menu {
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item {
            border-radius: 9px;
            padding: 0.55rem 0.85rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .dropdown-item:hover { background: var(--primary-soft); color: var(--primary); }

        /* ===== ALERTS ===== */
        .alert {
            border-radius: var(--radius-sm);
            border: none;
            font-size: 0.9rem;
        }

        /* ===== CHAT FAB ===== */
        .chat-fab {
            position: fixed;
            bottom: 1.5rem; right: 1.5rem;
            width: 58px; height: 58px;
            border-radius: 18px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.45rem;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.4);
            z-index: 1050;
            border: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .chat-fab:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 32px rgba(79, 70, 229, 0.5);
            color: white;
        }

        /* ===== MOBILE ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(11, 18, 32, 0.55);
            backdrop-filter: blur(4px);
            z-index: 1035;
        }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .main-wrapper { margin-left: 0; }
            .content { padding: 1.15rem; }
            .topbar { padding: 0 1rem; }
        }

        /* ===== ANIMATIONS ===== */
        .animate-fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.55s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .animate-delay-1 { animation-delay: 0.08s; }
        .animate-delay-2 { animation-delay: 0.16s; }
        .animate-delay-3 { animation-delay: 0.24s; }
        .animate-delay-4 { animation-delay: 0.32s; }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s cubic-bezier(0.22, 1, 0.36, 1), transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .stat-card { animation: fadeUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both; }

        /* Page title accent */
        .page-title {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--text);
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 0.15rem;
        }

        /* Soft gradient page bg accent */
        .content {
            background:
                radial-gradient(ellipse 80% 50% at 100% -20%, rgba(99, 102, 241, 0.06), transparent),
                var(--bg);
            min-height: calc(100vh - var(--header-height));
        }

        /* Breadcrumb */
        .breadcrumb { font-size: 0.85rem; }
        .breadcrumb-item a { color: var(--primary); }

        /* Input group */
        .input-group-text {
            border-radius: 11px 0 0 11px;
            border: 1.5px solid var(--border);
            background: #f8fafc;
        }
        .input-group .form-control { border-radius: 0 11px 11px 0; }
    
        /* ===== FIX KONTRAS TEMA GELAP ===== */
        body, .main-wrapper {
            background: var(--bg) !important;
            color: var(--text) !important;
        }
        .content {
            background-color: var(--bg) !important;
            color: var(--text) !important;
        }
        .page-title, h1, h2, h3, h4, h5, h6, .fw-bold, .fw-semibold {
            color: #f8fafc !important;
        }
        .text-muted, small, .small, .page-subtitle {
            color: #94a3b8 !important;
        }
        .card, .stat-card {
            background: var(--surface) !important;
            border: 1px solid var(--border) !important;
            color: #f1f5f9 !important;
        }
        .card-header {
            color: #e2e8f0 !important;
            border-bottom-color: var(--border) !important;
            background: transparent !important;
        }
        .card-body, .card-footer {
            color: #e2e8f0 !important;
        }
        .list-group-item {
            background: transparent !important;
            color: #e2e8f0 !important;
            border-color: var(--border) !important;
        }
        .list-group-item-action:hover {
            background: rgba(255,255,255,0.04) !important;
            color: #fff !important;
        }
        .table {
            --bs-table-bg: transparent;
            --bs-table-color: #e2e8f0;
            --bs-table-border-color: var(--border);
            --bs-table-hover-bg: rgba(255,255,255,0.03);
            color: #e2e8f0 !important;
        }
        .table thead th {
            background: rgba(255,255,255,0.03) !important;
            color: #94a3b8 !important;
            border-color: var(--border) !important;
        }
        .table td, .table th {
            border-color: var(--border) !important;
            color: #e2e8f0 !important;
        }
        .table-hover > tbody > tr:hover > * {
            background-color: #202b40 !important;
            box-shadow: none !important;
            color: #f1f5f9 !important;
        }
        .table-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
            flex-wrap: wrap;
            min-width: max-content;
        }
        .table-actions > form { display: inline-flex; margin: 0; }
        .table-actions .btn {
            min-width: 2.4rem;
            min-height: 2.25rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .table-actions details { position: static; }
        .table-actions details > summary { list-style: none; cursor: pointer; }
        .table-actions details > summary::-webkit-details-marker { display: none; }
        .table-actions details[open]::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(2, 6, 23, 0.72);
            backdrop-filter: blur(3px);
        }
        .table-actions details[open] > form {
            position: fixed;
            z-index: 1050;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: min(28rem, calc(100vw - 2rem));
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
            margin: 0;
            box-shadow: 0 1.5rem 4rem rgba(0, 0, 0, 0.5);
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus-visible {
            background: rgba(99, 102, 241, 0.16) !important;
            border-color: #818cf8 !important;
            color: #c7d2fe !important;
        }
        .btn-outline-secondary:hover, .btn-outline-secondary:focus-visible {
            background: rgba(148, 163, 184, 0.14) !important;
            border-color: #94a3b8 !important;
            color: #f1f5f9 !important;
        }
        .btn-outline-danger:hover, .btn-outline-danger:focus-visible {
            background: rgba(248, 113, 113, 0.14) !important;
            border-color: #f87171 !important;
            color: #fca5a5 !important;
        }
        .btn-outline-success:hover, .btn-outline-success:focus-visible {
            background: rgba(74, 222, 128, 0.14) !important;
            border-color: #4ade80 !important;
            color: #bbf7d0 !important;
        }
        .btn-outline-warning:hover, .btn-outline-warning:focus-visible {
            background: rgba(251, 191, 36, 0.14) !important;
            border-color: #fbbf24 !important;
            color: #fde68a !important;
        }
        .btn-outline-info:hover, .btn-outline-info:focus-visible {
            background: rgba(56, 189, 248, 0.14) !important;
            border-color: #38bdf8 !important;
            color: #bae6fd !important;
        }
        .form-control, .form-select, .form-control:focus, .form-select:focus {
            background: #1a2338 !important;
            border-color: var(--border) !important;
            color: #f1f5f9 !important;
        }
        .form-control::placeholder { color: #64748b !important; }
        .form-label, label { color: #cbd5e1 !important; }
        .topbar {
            background: rgba(11,18,32,0.9) !important;
            border-bottom: 1px solid var(--border) !important;
            color: #f1f5f9 !important;
        }
        .topbar h6, .topbar .text-muted { color: #94a3b8 !important; }
        .user-btn {
            background: #1a2338 !important;
            border-color: var(--border) !important;
            color: #f1f5f9 !important;
        }
        .dropdown-menu {
            background: #1a2338 !important;
            border: 1px solid var(--border) !important;
        }
        .dropdown-item { color: #e2e8f0 !important; }
        .dropdown-item:hover, .dropdown-item:focus {
            background: rgba(99,102,241,0.2) !important;
            color: #c7d2fe !important;
        }
        .dropdown-divider { border-color: var(--border) !important; }
        .alert-primary {
            background: rgba(99,102,241,0.15) !important;
            color: #c7d2fe !important;
            border: 1px solid rgba(99,102,241,0.25) !important;
        }
        .alert-success {
            background: rgba(34,197,94,0.12) !important;
            color: #86efac !important;
        }
        .alert-danger, .alert-warning {
            background: rgba(239,68,68,0.12) !important;
            color: #fca5a5 !important;
        }
        /* Quick action tiles on dashboard */
        a.card, .card a, .quick-link, .action-tile {
            color: #e2e8f0 !important;
            text-decoration: none !important;
        }
        a.card:hover, .action-tile:hover {
            border-color: rgba(129,140,248,0.4) !important;
            color: #fff !important;
        }
        .badge.bg-primary { background: #4f46e5 !important; }
        .text-primary { color: #818cf8 !important; }
        .text-success { color: #4ade80 !important; }
        .text-danger { color: #f87171 !important; }
        .text-warning { color: #fbbf24 !important; }
        .text-info { color: #38bdf8 !important; }
        .text-dark, .text-black, .text-body {
            color: #f1f5f9 !important;
        }
        .bg-white, .bg-light {
            background: var(--surface) !important;
            color: var(--text) !important;
        }
        .border, .border-bottom, .border-top {
            border-color: var(--border) !important;
        }
        .pagination .page-link {
            background: var(--surface);
            border-color: var(--border);
            color: #e2e8f0;
        }
        .pagination .page-item.active .page-link {
            background: #4f46e5;
            border-color: #4f46e5;
        }
        .nav-pills .nav-link { color: #94a3b8 !important; }
        .nav-pills .nav-link.active { color: #fff !important; }
        /* Empty state text */
        .text-center.text-muted, .opacity-50 {
            color: #94a3b8 !important;
            opacity: 1 !important;
        }

    </style>

    @stack('styles')
</head>
<body>
    <!-- Overlay Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <span>Portal Sekolah</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Menu</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            @if(auth()->user()->canManageSite())
                <div class="nav-section">Website</div>
                <a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i> Pengaturan Situs
                </a>
            @endif

            @if(auth()->user()->canManageData())
                <div class="nav-section">Administrasi</div>
                <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}"><i class="bi bi-people-fill"></i> Data Siswa</a>
                <a href="{{ route('admin.guru.index') }}" class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}"><i class="bi bi-person-badge-fill"></i> Data Guru</a>
                <a href="{{ route('admin.kelas.index') }}" class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}"><i class="bi bi-building"></i> Data Kelas</a>
                <a href="{{ route('admin.mapel.index') }}" class="nav-link {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> Mata Pelajaran</a>
                <a href="{{ route('admin.pengumuman.index') }}" class="nav-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}"><i class="bi bi-megaphone"></i> Kelola Pengumuman</a>
                <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}"><i class="bi bi-calendar-week"></i> Kelola Jadwal</a>
                <a href="{{ route('admin.nilai.index') }}" class="nav-link {{ request()->routeIs('admin.nilai.*') ? 'active' : '' }}"><i class="bi bi-award"></i> Kelola Nilai</a>
                <a href="{{ route('admin.cuti.index') }}" class="nav-link {{ request()->routeIs('admin.cuti.*') ? 'active' : '' }}"><i class="bi bi-calendar2-check"></i> Persetujuan Cuti</a>
                <a href="{{ route('admin.struktur.index') }}" class="nav-link {{ request()->routeIs('admin.struktur.*') ? 'active' : '' }}"><i class="bi bi-diagram-3"></i> Kelola Struktur</a>
                <a href="{{ route('admin.export.siswa') }}" class="nav-link"><i class="bi bi-file-earmark-excel"></i> Ekspor Data</a>
            @endif

            @if(auth()->user()->isGuru())
                <div class="nav-section">Akademik</div>
                <a href="{{ route('jadwal.index') }}" class="nav-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}"><i class="bi bi-calendar3"></i> Jadwal Mengajar</a>
                <a href="{{ route('absensi.index') }}" class="nav-link {{ request()->routeIs('absensi.*') ? 'active' : '' }}"><i class="bi bi-clipboard-check"></i> Absensi Kelas</a>
                <a href="{{ route('guru.nilai.index') }}" class="nav-link {{ request()->routeIs('guru.nilai.*') ? 'active' : '' }}"><i class="bi bi-award"></i> Input Nilai</a>
                <a href="{{ route('guru.cuti.index') }}" class="nav-link {{ request()->routeIs('guru.cuti.*') ? 'active' : '' }}"><i class="bi bi-calendar2-check"></i> Cuti / Izin</a>
            @endif

            @if(auth()->user()->isSiswa())
                <div class="nav-section">Akademik</div>
                <a href="{{ route('biodata.show') }}" class="nav-link {{ request()->routeIs('biodata.*') ? 'active' : '' }}"><i class="bi bi-person-vcard"></i> Biodata</a>
                <a href="{{ route('jadwal.index') }}" class="nav-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}"><i class="bi bi-calendar3"></i> Jadwal Saya</a>
                <a href="{{ route('absensi.index') }}" class="nav-link {{ request()->routeIs('absensi.*') ? 'active' : '' }}"><i class="bi bi-clipboard-check"></i> Absensi Saya</a>
                <a href="{{ route('siswa.nilai.index') }}" class="nav-link {{ request()->routeIs('siswa.nilai.*') ? 'active' : '' }}"><i class="bi bi-award"></i> Nilai Saya</a>
            @endif

            <div class="nav-section">Lainnya</div>
            <a href="{{ route('pengumuman.index') }}" class="nav-link {{ request()->routeIs('pengumuman.*') ? 'active' : '' }}"><i class="bi bi-megaphone-fill"></i> Pengumuman</a>
            <a href="{{ route('chatbot.index') }}" class="nav-link {{ request()->routeIs('chatbot.*') ? 'active' : '' }}"><i class="bi bi-robot"></i> SekolahBot</a>
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"><i class="bi bi-person-circle"></i> Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                    <i class="bi bi-box-arrow-left"></i> Keluar
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" id="btnSidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="d-none d-md-block">
                    <h6 class="mb-0 fw-semibold">@yield('title', 'Dashboard')</h6>
                    <small class="text-muted">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</small>
                </div>
            </div>

            <div class="dropdown">
                <button class="user-btn" data-bs-toggle="dropdown">
                    <div class="user-avatar" style="overflow:hidden;padding:0;">
                        <img src="{{ auth()->user()->profilePhotoUrl() }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                    <i class="bi bi-chevron-down small"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li class="px-3 py-2">
                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                        <small class="text-muted text-capitalize">{{ auth()->user()->role }}</small>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profil</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <!-- Page Content -->
        <main class="content">
            @yield('content')
        </main>
    </div>

    <!-- Floating Chat Button (kecuali di halaman chatbot) -->
    @unless(request()->routeIs('chatbot.*'))
        <a href="{{ route('chatbot.index') }}" class="chat-fab" title="Tanya SekolahBot">
            <i class="bi bi-robot"></i>
        </a>
    @endunless

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const btnSidebar = document.getElementById('btnSidebar');

        btnSidebar?.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    </script>


    <script>
        // Scroll reveal
        const revealEls = document.querySelectorAll('.reveal');
        if (revealEls.length && 'IntersectionObserver' in window) {
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('visible');
                        io.unobserve(e.target);
                    }
                });
            }, { threshold: 0.12 });
            revealEls.forEach(el => io.observe(el));
        } else {
            revealEls.forEach(el => el.classList.add('visible'));
        }

        // Stagger stat cards
        document.querySelectorAll('.stat-card').forEach((el, i) => {
            el.style.animationDelay = (i * 0.08) + 's';
        });
    </script>

    @stack('scripts')
</body>
</html>
