<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Sekolah — {{ $school['nama'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #818cf8;
            --bg: #070b14;
            --surface: rgba(255,255,255,0.05);
            --border: rgba(255,255,255,0.08);
            --muted: #94a3b8;
        }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: #f1f5f9;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 50% 40% at 20% 0%, rgba(99,102,241,0.22), transparent),
                radial-gradient(ellipse 40% 30% at 80% 80%, rgba(139,92,246,0.12), transparent);
            pointer-events: none; z-index: 0;
        }
        .navbar { background: rgba(7,11,20,0.8)!important; backdrop-filter: blur(16px); border-bottom: 1px solid var(--border); }
        .navbar-brand { color: #fff!important; font-weight: 800; }
        .nav-link { color: var(--muted)!important; }
        .nav-link:hover { color: #fff!important; }
        .btn-glow {
            background: linear-gradient(135deg,#818cf8,#6366f1); border: none; color: #fff;
            font-weight: 600; border-radius: 12px; padding: 0.5rem 1.1rem;
            box-shadow: 0 4px 16px rgba(99,102,241,0.35);
        }
        .btn-glow:hover { color: #fff; filter: brightness(1.08); }
        .hero-profil {
            position: relative; z-index: 1;
            padding: 5rem 0 3rem;
        }
        .hero-profil h1 { font-weight: 800; letter-spacing: -0.03em; }
        .card-dark {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 1.5rem;
            height: 100%;
            transition: transform 0.3s, border-color 0.3s;
        }
        .card-dark:hover { transform: translateY(-4px); border-color: rgba(129,140,248,0.3); }
        .icon-box {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(99,102,241,0.2); color: var(--primary);
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
        }
        .text-muted { color: var(--muted)!important; }
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.6s cubic-bezier(0.22,1,0.36,1); }
        .reveal.visible { opacity: 1; transform: none; }
        footer { border-top: 1px solid var(--border); color: var(--muted); position: relative; z-index: 1; }
        section { position: relative; z-index: 1; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <i class="bi bi-mortarboard-fill text-primary"></i> {{ $school['nama'] }}
        </a>
        <div class="d-flex gap-2">
            <a href="{{ url('/') }}" class="nav-link">Beranda</a>
            @guest
                <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-glow btn-sm">Daftar</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-glow btn-sm">Dashboard</a>
            @endguest
        </div>
    </div>
</nav>

<section class="hero-profil">
    <div class="container">
        <span class="badge rounded-pill mb-3 px-3 py-2" style="background:rgba(99,102,241,0.2);color:#a5b4fc;">Profil Sekolah</span>
        <h1 class="mb-2">{{ $school['nama'] }}</h1>
        <p class="text-muted col-lg-8">Portal digital resmi sekolah untuk mendukung kegiatan belajar mengajar secara modern dan terintegrasi.</p>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-md-6 reveal">
                <div class="card-dark">
                    <div class="d-flex gap-3 mb-3">
                        <div class="icon-box"><i class="bi bi-bullseye"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1">Visi</h5>
                            <p class="text-muted small mb-0">{{ $profil['visi'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 reveal">
                <div class="card-dark">
                    <div class="d-flex gap-3 mb-3">
                        <div class="icon-box"><i class="bi bi-flag"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1">Misi</h5>
                            <ul class="text-muted small mb-0 ps-3">
                                @foreach($profil['misi'] as $m)
                                    <li class="mb-1">{{ $m }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4 reveal">
                <div class="card-dark text-center">
                    <div class="icon-box mx-auto mb-3"><i class="bi bi-geo-alt"></i></div>
                    <h6 class="fw-semibold">Alamat</h6>
                    <p class="text-muted small mb-0">{{ $school['alamat'] }}</p>
                </div>
            </div>
            <div class="col-md-4 reveal">
                <div class="card-dark text-center">
                    <div class="icon-box mx-auto mb-3"><i class="bi bi-telephone"></i></div>
                    <h6 class="fw-semibold">Telepon</h6>
                    <p class="text-muted small mb-0">{{ $school['telepon'] }}</p>
                </div>
            </div>
            <div class="col-md-4 reveal">
                <div class="card-dark text-center">
                    <div class="icon-box mx-auto mb-3"><i class="bi bi-envelope"></i></div>
                    <h6 class="fw-semibold">Email</h6>
                    <p class="text-muted small mb-0">{{ $school['email'] }}</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6 reveal">
                <div class="card-dark">
                    <h5 class="fw-bold mb-3"><i class="bi bi-clock me-2 text-primary"></i>Jam Operasional</h5>
                    <p class="text-muted mb-0">{{ $school['jam'] }}</p>
                </div>
            </div>
            <div class="col-md-6 reveal">
                <div class="card-dark">
                    <h5 class="fw-bold mb-3"><i class="bi bi-bar-chart me-2 text-primary"></i>Data Singkat</h5>
                    <div class="d-flex gap-4">
                        <div><div class="fs-3 fw-bold text-primary">{{ $stats['siswa'] }}</div><small class="text-muted">Siswa</small></div>
                        <div><div class="fs-3 fw-bold text-primary">{{ $stats['guru'] }}</div><small class="text-muted">Guru</small></div>
                        <div><div class="fs-3 fw-bold text-primary">{{ $stats['kelas'] }}</div><small class="text-muted">Kelas</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="py-4">
    <div class="container text-center small">
        <a href="{{ url('/') }}" class="text-decoration-none text-muted">← Kembali ke beranda</a>
        <div class="mt-2">&copy; {{ date('Y') }} {{ $school['nama'] }}</div>
    </div>
</footer>
<script>
document.querySelectorAll('.reveal').forEach((el,i) => {
    setTimeout(() => el.classList.add('visible'), 100 + i*80);
});
</script>
</body>
</html>
