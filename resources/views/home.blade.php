<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $school['nama'] }} — Portal Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #818cf8;
            --primary-strong: #6366f1;
            --bg: #070b14;
            --surface: rgba(255,255,255,0.04);
            --surface-2: rgba(255,255,255,0.07);
            --border: rgba(255,255,255,0.08);
            --text: #f1f5f9;
            --muted: #94a3b8;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 40% at 10% 0%, rgba(99,102,241,0.25), transparent),
                radial-gradient(ellipse 50% 40% at 90% 20%, rgba(14,165,233,0.12), transparent),
                radial-gradient(ellipse 40% 30% at 50% 100%, rgba(139,92,246,0.15), transparent);
            pointer-events: none;
            z-index: 0;
        }
        .navbar {
            background: rgba(7,11,20,0.75) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            z-index: 100;
        }
        .navbar-brand { color: #fff !important; font-weight: 800; letter-spacing: -0.03em; }
        .nav-link { color: var(--muted) !important; font-weight: 500; font-size: 0.9rem; transition: color 0.2s; }
        .nav-link:hover { color: #fff !important; }
        .btn-glow {
            background: linear-gradient(135deg, #818cf8, #6366f1);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.4rem 0.9rem;
            font-size: 0.85rem;
            box-shadow: 0 3px 14px rgba(99,102,241,0.35);
            transition: all 0.25s cubic-bezier(0.22,1,0.36,1);
        }
        .btn-glow:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.5); color: #fff; }
        .btn-ghost {
            background: transparent;
            border: 1.5px solid var(--border);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.4rem 0.9rem;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .btn-ghost:hover { background: var(--surface-2); border-color: rgba(255,255,255,0.2); color: #fff; }
        .btn-glow.btn-lg, .btn-ghost.btn-lg {
            padding: 0.45rem 1rem !important;
            font-size: 0.875rem !important;
            border-radius: 10px !important;
        }

        .hero {
            position: relative;
            z-index: 1;
            padding: 7rem 0 5rem;
            overflow: hidden;
        }
        @if(!empty($school['bg_url']) || !empty($school['bg']))
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(7,11,20,0.2), rgba(7,11,20,0.42)), url('{{ !empty($school['bg_url']) ? $school['bg_url'] : asset('storage/'.$school['bg']) }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            pointer-events: none;
            z-index: 0;
        }
        .hero > .container { position: relative; z-index: 1; }
        @endif
        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: float 8s ease-in-out infinite;
        }
        .hero-orb-1 {
            width: 400px; height: 400px;
            background: rgba(99,102,241,0.35);
            top: -10%; left: -5%;
        }
        .hero-orb-2 {
            width: 300px; height: 300px;
            background: rgba(14,165,233,0.2);
            bottom: 0; right: 5%;
            animation-delay: -3s;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -30px); }
        }
        .hero h1 {
            font-size: clamp(2.4rem, 5vw, 3.75rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }
        .hero .lead { color: var(--muted); font-size: 1.1rem; max-width: 520px; }

        .stat-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 1.5rem;
            text-align: center;
            backdrop-filter: blur(12px);
            transition: all 0.35s cubic-bezier(0.22,1,0.36,1);
        }
        .stat-box:hover {
            transform: translateY(-8px) scale(1.02);
            background: var(--surface-2);
            border-color: rgba(129,140,248,0.3);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .stat-box .num {
            font-size: 2.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, #a5b4fc, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        @media (max-width: 575.98px) {
            .stat-box {
                padding: 0.75rem 0.35rem;
                border-radius: 14px;
            }
            .stat-box .num { font-size: 1.7rem; }
            .stat-box .text-muted.small {
                font-size: 0.75rem;
                line-height: 1.25;
            }
            .stat-box:hover { transform: translateY(-3px); }
        }

        .section-title {
            font-weight: 800;
            letter-spacing: -0.03em;
            font-size: 1.85rem;
        }
        .section-sub { color: var(--muted); }

        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.75rem;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.22,1,0.36,1);
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            background: var(--surface-2);
            border-color: rgba(129,140,248,0.25);
            box-shadow: 0 24px 48px rgba(0,0,0,0.35);
        }
        .feature-card:hover::before { opacity: 1; }
        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem;
            margin-bottom: 1.1rem;
            background: linear-gradient(135deg, rgba(99,102,241,0.25), rgba(129,140,248,0.1));
            color: var(--primary);
            transition: transform 0.3s;
        }
        .feature-card:hover .feature-icon { transform: scale(1.1) rotate(-5deg); }

        .announcement-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            height: 100%;
            transition: all 0.35s cubic-bezier(0.22,1,0.36,1);
        }
        .announcement-card:hover {
            transform: translateY(-6px);
            border-color: rgba(129,140,248,0.3);
            box-shadow: 0 16px 40px rgba(0,0,0,0.3);
        }
        .announcement-card .badge {
            background: rgba(99,102,241,0.2) !important;
            color: #a5b4fc !important;
        }

        .glass-panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            backdrop-filter: blur(16px);
        }

        footer {
            background: rgba(0,0,0,0.3);
            border-top: 1px solid var(--border);
            color: var(--muted);
            position: relative;
            z-index: 1;
        }

        /* Animations */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s cubic-bezier(0.22,1,0.36,1), transform 0.7s cubic-bezier(0.22,1,0.36,1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.22,1,0.36,1) both;
        }
        .fade-in-d1 { animation-delay: 0.1s; }
        .fade-in-d2 { animation-delay: 0.2s; }
        .fade-in-d3 { animation-delay: 0.35s; }
        .fade-in-d4 { animation-delay: 0.5s; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(28px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(99,102,241,0.4); }
            50% { box-shadow: 0 0 0 12px rgba(99,102,241,0); }
        }
        .pulse-btn { animation: pulse-glow 2.5s infinite; }

        .text-gradient {
            background: linear-gradient(135deg, #e0e7ff, #a5b4fc, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        section { position: relative; z-index: 1; }
        .text-muted { color: var(--muted) !important; }

        .struktur-flow {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }
        .struktur-node {
            width: 100%;
            max-width: 280px;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--surface);
            text-align: center;
            box-shadow: 0 16px 36px rgba(0,0,0,0.18);
            backdrop-filter: blur(12px);
        }
        .struktur-node.struktur-top {
            max-width: 300px;
            border-color: rgba(129,140,248,0.4);
            box-shadow: 0 18px 42px rgba(79,70,229,0.18);
        }
        .struktur-photo,
        .struktur-avatar-placeholder {
            display: flex;
            width: 100%;
            aspect-ratio: 4 / 3;
            align-items: center;
            justify-content: center;
            object-fit: cover;
            object-position: center 25%;
            background: linear-gradient(135deg,rgba(99,102,241,0.2),rgba(14,165,233,0.12));
            color: #c7d2fe;
            font-size: 2.5rem;
        }
        .struktur-node-body { padding: 1.1rem 1rem 1.25rem; }
        .struktur-jabatan {
            margin-bottom: 0.35rem;
            color: #a5b4fc;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
        }
        .struktur-nama {
            color: #f8fafc;
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.4;
            overflow-wrap: anywhere;
        }
        .struktur-line {
            width: 2px;
            height: 24px;
            background: linear-gradient(to bottom,rgba(129,140,248,0.75),rgba(129,140,248,0.12));
        }
        .struktur-row {
            display: grid;
            width: 100%;
            grid-template-columns: repeat(auto-fit,minmax(min(100%,220px),1fr));
            justify-items: center;
            gap: 1.25rem;
        }

        @media (max-width: 575.98px) {
            #struktur.py-5 { padding-block: 2.5rem !important; }
            #struktur .container { padding-block: 0.75rem !important; }
            #struktur .text-center.mb-5 { margin-bottom: 1.5rem !important; }
            .struktur-flow { gap: 1rem; }
            .struktur-node { max-width: 200px; border-radius: 15px; }
            .struktur-node.struktur-top { max-width: 250px; }
            .struktur-photo, .struktur-avatar-placeholder { aspect-ratio: 3 / 2; }
            .struktur-node-body { padding: 0.8rem 0.7rem 0.9rem; }
            .struktur-jabatan { font-size: 0.7rem; margin-bottom: 0.25rem; }
            .struktur-nama { font-size: 0.92rem; }
            .struktur-line { height: 18px; }
            .struktur-row {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.75rem;
            }
        }

        @media (max-width: 380px) {
            .struktur-node { max-width: 170px; }
            .struktur-row { gap: 0.55rem; }
            .struktur-node-body { padding: 0.7rem 0.55rem 0.75rem; }
            .struktur-nama { font-size: 0.85rem; }
        }

        .chat-fab {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            width: 58px; height: 58px;
            border-radius: 18px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.45rem;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.45);
            z-index: 1050;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            animation: pulse-glow 2.5s infinite;
        }
        .chat-fab:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 32px rgba(79, 70, 229, 0.55);
            color: white;
        }

        @media (max-width: 767.98px) {
            body { font-size: 0.94rem; }
            .container { --bs-gutter-x: 1.25rem; }
            .navbar { padding-block: 0.45rem; }
            .navbar-brand { font-size: 0.98rem; }
            .navbar-brand > span { width: 32px !important; height: 32px !important; }
            .navbar-collapse { padding-top: 0.55rem; }
            .navbar-nav { gap: 0.1rem; }
            .navbar-nav .nav-link { padding: 0.5rem 0.25rem; font-size: 0.86rem; }
            .navbar-nav .btn { margin-top: 0.25rem; }

            .hero { padding: 4rem 0 3rem; }
            .hero h1 { font-size: clamp(1.8rem, 7vw, 2.25rem); line-height: 1.12; }
            .hero .lead { font-size: 0.94rem; line-height: 1.55; margin-bottom: 1.2rem !important; }
            .hero .badge { font-size: 0.75rem; padding: 0.4rem 0.7rem !important; }
            .hero .btn { padding: 0.55rem 0.75rem; font-size: 0.82rem; }
            .hero .d-flex.flex-wrap { gap: 0.5rem !important; }

            section.py-5 { padding-top: 2.5rem !important; padding-bottom: 2.5rem !important; }
            section .container.py-3 { padding-top: 0.25rem !important; padding-bottom: 0.25rem !important; }
            .section-title { font-size: 1.5rem; }
            .section-sub { font-size: 0.88rem; }
            .text-center.mb-5 { margin-bottom: 1.5rem !important; }
            .row.g-4 { --bs-gutter-x: 1rem; --bs-gutter-y: 1rem; }

            .feature-card { padding: 1.1rem; border-radius: 16px; }
            .feature-icon { width: 44px; height: 44px; border-radius: 12px; font-size: 1.15rem; margin-bottom: 0.8rem; }
            .feature-card h5 { font-size: 1rem; }
            .feature-card h6 { font-size: 0.92rem; }
            .feature-card p, .feature-card li { font-size: 0.82rem; line-height: 1.5; }

            .announcement-card { border-radius: 15px; }
            .announcement-card .card-body.p-4 { padding: 1rem !important; }
            .announcement-card h6 { font-size: 0.92rem; }
            .glass-panel.p-4 { padding: 1rem !important; border-radius: 16px; }
            .glass-panel.p-5 { padding: 1.25rem !important; }
            .chat-fab { width: 50px; height: 50px; right: 1rem; bottom: 1rem; border-radius: 15px; font-size: 1.2rem; }
            footer.py-4 { padding-block: 1rem !important; }
        }

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3 text-white"
                      style="width:36px;height:36px;background:linear-gradient(135deg,#818cf8,#6366f1);font-size:1rem;">
                    <i class="bi bi-mortarboard-fill"></i>
                </span>
                {{ $school['nama'] }}
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <i class="bi bi-list text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pengumuman">Pengumuman</a></li>
                    <li class="nav-item"><a class="nav-link" href="#profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#struktur">Struktur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                    @auth
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-glow btn-sm" href="{{ route('dashboard') }}">
                                <i class="bi bi-grid me-1"></i> Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-ghost btn-sm" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-glow btn-sm" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i> Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge rounded-pill px-3 py-2 mb-3 fade-in" style="background:rgba(255,255,255,0.08);border:1px solid var(--border);color:#c7d2fe;font-weight:500;">
                        Portal Digital Sekolah
                    </span>
                    <h1 class="mb-3 fade-in fade-in-d1">
                        Belajar lebih<br><span class="text-gradient">terorganisir.</span>
                    </h1>
                    <p class="lead mb-4 fade-in fade-in-d2">
                        Jadwal, absensi WiFi, nilai, pengumuman, dan asisten AI — semua dalam satu portal modern untuk siswa & guru.
                    </p>
                    <div class="d-flex flex-wrap gap-2 fade-in fade-in-d3">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-glow pulse-btn">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Portal
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-ghost">
                                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-glow">
                                <i class="bi bi-grid me-2"></i>Ke Dashboard
                            </a>
                        @endguest
                        <a href="#profil" class="btn btn-ghost">Profil Sekolah</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-flex justify-content-center fade-in fade-in-d4">
                    <div class="glass-panel p-4 text-center" style="width:280px;">
                        <div class="mb-3" style="font-size:4rem;line-height:1;">🎓</div>
                        <div class="fw-bold mb-1">{{ $school['nama'] }}</div>
                        <small class="text-muted">{{ $school['jam'] }}</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="pb-5" style="margin-top:-2rem;">
        <div class="container">
            <div class="row g-3">
                <div class="col-4 reveal">
                    <div class="stat-box">
                        <div class="num">{{ $stats['siswa'] }}</div>
                        <div class="text-muted small">Siswa Aktif</div>
                    </div>
                </div>
                <div class="col-4 reveal">
                    <div class="stat-box">
                        <div class="num">{{ $stats['guru'] }}</div>
                        <div class="text-muted small">Guru & Staff</div>
                    </div>
                </div>
                <div class="col-4 reveal">
                    <div class="stat-box">
                        <div class="num">{{ $stats['kelas'] }}</div>
                        <div class="text-muted small">Kelas</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan -->
    <section id="layanan" class="py-5">
        <div class="container py-3">
            <div class="text-center mb-5 reveal">
                <h2 class="section-title">Layanan Portal</h2>
                <p class="section-sub">Fitur digital untuk kegiatan belajar mengajar</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 reveal">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-calendar3"></i></div>
                        <h5 class="fw-bold">Jadwal & Akademik</h5>
                        <p class="text-muted small mb-0">Jadwal pelajaran, nilai, dan rekap kehadiran secara real-time.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-wifi"></i></div>
                        <h5 class="fw-bold">Absensi WiFi Sekolah</h5>
                        <p class="text-muted small mb-0">Siswa absen mandiri hanya saat terhubung jaringan WiFi sekolah.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-robot"></i></div>
                        <h5 class="fw-bold">SekolahBot AI</h5>
                        <p class="text-muted small mb-0">Asisten virtual menjawab pertanyaan seputar sekolah kapan saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pengumuman -->
    <section id="pengumuman" class="py-5">
        <div class="container py-3">
            <div class="mb-4 reveal">
                <h2 class="section-title mb-1">Pengumuman</h2>
                <p class="section-sub mb-0">Informasi terbaru untuk publik</p>
            </div>
            <div class="row g-3">
                @forelse($pengumumanPublik as $p)
                    <div class="col-md-6 col-lg-4 reveal">
                        <div class="announcement-card">
                            <div class="card-body p-4">
                                <span class="badge mb-2">
                                    {{ optional($p->published_at)->format('d M Y') ?? optional($p->created_at)->format('d M Y') ?? '-' }}
                                </span>
                                <h6 class="fw-semibold text-white">{{ $p->judul }}</h6>
                                <p class="text-muted small mb-0">{{ Str::limit(strip_tags($p->isi), 100) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="glass-panel p-5 text-center text-muted reveal">
                            <i class="bi bi-megaphone fs-2 d-block mb-2 opacity-50"></i>
                            Belum ada pengumuman publik
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Register -->
    <section class="py-5">
        <div class="container">
            <div class="glass-panel p-4 p-md-5 reveal">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <h2 class="section-title mb-2">Siap bergabung?</h2>
                        <p class="text-muted mb-0">
                            Daftar dengan email domain sekolah
                            (<strong class="text-white">(@sekolah.sch.id / @siswa.sch.id)</strong>.
                            Siswa, guru, dan staf bisa mengakses portal sesuai peran masing-masing.
                        </p>
                    </div>
                    <div class="col-lg-5 text-lg-end">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-glow me-2 mb-2">
                                <i class="bi bi-person-plus me-1"></i> Daftar
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-ghost mb-2">Masuk</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-glow">Buka Dashboard</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Profil Sekolah (publik) -->
    <section id="profil" class="py-5">
        <div class="container py-3">
            <div class="text-center mb-5 reveal">
                <h2 class="section-title">Profil Sekolah</h2>
                <p class="section-sub">{{ $school['nama'] }}</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 reveal">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-bullseye"></i></div>
                        <h5 class="fw-bold">Visi</h5>
                        <p class="text-muted small mb-0">{{ $school['visi'] ?: 'Menjadi sekolah unggul yang menghasilkan lulusan berkarakter dan berprestasi.' }}</p>
                    </div>
                </div>
                <div class="col-md-6 reveal">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-flag"></i></div>
                        <h5 class="fw-bold">Misi</h5>
                        <ul class="text-muted small mb-0 ps-3">
                            @foreach(array_filter(array_map('trim', explode("\n", $school['misi'] ?: "Pendidikan berkualitas.\nKarakter beriman dan berilmu.\nKompetensi guru."))) as $m)
                                <li class="mb-1">{{ $m }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Struktur (flowchart) -->
    <section id="struktur" class="py-5">
        <div class="container py-3">
            <div class="text-center mb-5 reveal">
                <h2 class="section-title">Struktur Organisasi</h2>
                <p class="section-sub">Hirarki kepemimpinan sekolah</p>
            </div>
            <div class="struktur-flow reveal">
                @php $list = $struktur ?? collect(); @endphp
                @if($list->count())
                    @php
                        $top = $list->firstWhere('jabatan', 'Kepala Sekolah') ?? $list->first();
                        $rest = $list->filter(fn($x) => $x->id !== ($top->id ?? null));
                    @endphp
                    @if($top)
                    <div class="struktur-node struktur-top">
                        <img src="{{ $top->fotoUrl() }}" alt="Foto {{ $top->nama }}" class="struktur-photo" loading="lazy" decoding="async">
                        <div class="struktur-node-body">
                            <div class="struktur-jabatan">{{ $top->jabatan }}</div>
                            <div class="struktur-nama">{{ $top->nama }}</div>
                        </div>
                    </div>
                    <div class="struktur-line"></div>
                    @endif
                    <div class="struktur-row">
                        @foreach($rest as $anggota)
                        <div class="struktur-node">
                            <img src="{{ $anggota->fotoUrl() }}" alt="Foto {{ $anggota->nama }}" class="struktur-photo" loading="lazy" decoding="async">
                            <div class="struktur-node-body">
                                <div class="struktur-jabatan">{{ $anggota->jabatan }}</div>
                                <div class="struktur-nama">{{ $anggota->nama }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="glass-panel p-4 text-center text-muted">
                        <div class="struktur-node struktur-top mx-auto mb-3">
                            <div class="struktur-avatar-placeholder"><i class="bi bi-person-badge"></i></div>
                            <div class="struktur-node-body">
                                <div class="struktur-jabatan">Kepala Sekolah</div>
                                <div class="struktur-nama">{{ $school['kepala'] ?: 'Belum diisi' }}</div>
                            </div>
                        </div>
                        <small>Admin dapat menambahkan foto & pejabat di menu Struktur</small>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak" class="py-5">
        <div class="container py-3">
            <div class="text-center mb-4 reveal">
                <h2 class="section-title">Hubungi Kami</h2>
            </div>
            <div class="row g-3 justify-content-center">
                <div class="col-md-4 reveal">
                    <div class="feature-card text-center">
                        <div class="feature-icon mx-auto"><i class="bi bi-geo-alt"></i></div>
                        <h6 class="fw-semibold">Alamat</h6>
                        <p class="text-muted small mb-0">{{ $school['alamat'] }}</p>
                    </div>
                </div>
                <div class="col-md-4 reveal">
                    <div class="feature-card text-center">
                        <div class="feature-icon mx-auto"><i class="bi bi-telephone"></i></div>
                        <h6 class="fw-semibold">Telepon</h6>
                        <p class="text-muted small mb-0">{{ $school['telepon'] }}</p>
                    </div>
                </div>
                <div class="col-md-4 reveal">
                    <div class="feature-card text-center">
                        <div class="feature-icon mx-auto"><i class="bi bi-envelope"></i></div>
                        <h6 class="fw-semibold">Email</h6>
                        <p class="text-muted small mb-0">{{ $school['email'] }}</p>
                    </div>
                </div>
            </div>
            <p class="text-center text-muted small mt-4 reveal">
                <i class="bi bi-clock me-1"></i> {{ $school['jam'] }}
            </p>
        </div>
    </section>

    <footer class="py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-mortarboard-fill text-primary"></i>
                <span class="fw-semibold text-white">{{ $school['nama'] }}</span>
            </div>
            <div class="small">&copy; {{ date('Y') }} Portal Sekolah</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const reveals = document.querySelectorAll('.reveal');
        const io = new IntersectionObserver((entries) => {
            entries.forEach((e, i) => {
                if (e.isIntersecting) {
                    e.target.style.transitionDelay = (i % 3) * 0.08 + 's';
                    e.target.classList.add('visible');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });
        reveals.forEach(el => io.observe(el));
    </script>
    <a href="{{ route('chatbot.index') }}" class="chat-fab" title="Tanya SekolahBot">
        <i class="bi bi-robot"></i>
    </a>
</body>
</html>
