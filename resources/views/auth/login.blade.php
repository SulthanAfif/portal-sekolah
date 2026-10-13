<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Portal Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
        }
        * { font-family: 'Inter', system-ui, sans-serif; box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; background: #0b1220; -webkit-font-smoothing: antialiased; }

        .auth-wrapper { min-height: 100vh; display: flex; }

        .auth-left {
            flex: 1.15;
            background:
                radial-gradient(ellipse 80% 60% at 20% 20%, rgba(99,102,241,0.35), transparent),
                radial-gradient(ellipse 60% 50% at 80% 80%, rgba(59,130,246,0.2), transparent),
                linear-gradient(160deg, #0b1220 0%, #1e1b4b 50%, #312e81 100%);
            display: flex; flex-direction: column; justify-content: center;
            padding: 3.5rem; color: white; position: relative; overflow: hidden;
        }

        .auth-left::after {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 28px 28px;
            mask-image: linear-gradient(to bottom, black, transparent);
            pointer-events: none;
        }

        .auth-left-content { position: relative; z-index: 1; max-width: 440px; }

        .brand-pill {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(8px);
            padding: 0.4rem 0.9rem 0.4rem 0.4rem;
            border-radius: 50px;
            font-size: 0.85rem; font-weight: 500;
            margin-bottom: 2rem;
        }
        .brand-pill .icon {
            width: 28px; height: 28px; border-radius: 50%;
            background: linear-gradient(135deg, #818cf8, #4f46e5);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
        }

        .auth-left h1 {
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.15;
            margin-bottom: 1rem;
        }

        .auth-left .lead {
            color: rgba(255,255,255,0.65);
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }

        .feature-grid { display: grid; gap: 0.85rem; }
        .feature-item {
            display: flex; align-items: center; gap: 0.9rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 0.9rem 1.1rem;
            transition: background 0.2s;
        }
        .feature-item:hover { background: rgba(255,255,255,0.1); }
        .feature-item .fi {
            width: 40px; height: 40px; border-radius: 12px;
            background: rgba(99,102,241,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; flex-shrink: 0; color: #a5b4fc;
        }
        .feature-item span { font-size: 0.9rem; font-weight: 500; color: rgba(255,255,255,0.9); }

        .auth-right {
            width: 480px; max-width: 100%;
            background: #fff;
            display: flex; flex-direction: column; justify-content: center;
            padding: 2.5rem 2.75rem;
        }

        .auth-card { max-width: 380px; margin: 0 auto; width: 100%; }

        .auth-card h2 {
            font-weight: 800;
            letter-spacing: -0.03em;
            font-size: 1.65rem;
            margin-bottom: 0.35rem;
        }

        .form-label { font-weight: 600; font-size: 0.8rem; color: #334155; margin-bottom: 0.4rem; }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e8ecf4;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #a5b4fc;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        .input-group-text {
            border-radius: 12px 0 0 12px;
            border: 1.5px solid #e8ecf4;
            background: #f8fafc;
            color: #94a3b8;
        }
        .input-group .form-control { border-radius: 0 12px 12px 0; }

        .btn-login {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none;
            border-radius: 12px;
            padding: 0.9rem;
            font-weight: 650;
            color: white;
            width: 100%;
            font-size: 0.95rem;
            box-shadow: 0 4px 16px rgba(79, 70, 229, 0.35);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.45);
            color: white;
            background: linear-gradient(135deg, #4f46e5, #4338ca);
        }

        .demo-box {
            background: #f8fafc;
            border: 1px solid #e8ecf4;
            border-radius: 14px;
            padding: 1rem 1.15rem;
            font-size: 0.78rem;
            color: #64748b;
            margin-top: 1.75rem;
            line-height: 1.7;
        }
        .demo-box strong { color: #334155; font-size: 0.8rem; }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        @media (max-width: 991.98px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; min-height: 100vh; padding: 2rem 1.5rem; }
        }

        .fade-up { animation: fadeUp 0.65s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .d1 { animation-delay: 0.08s; }
        .d2 { animation-delay: 0.16s; }
        .d3 { animation-delay: 0.28s; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-left">
        <div class="auth-left-content">
            <div class="brand-pill fade-up">
                <span class="icon"><i class="bi bi-mortarboard-fill"></i></span>
                Portal Sekolah
            </div>
            <h1 class="fade-up d1">Belajar lebih<br>terorganisir.</h1>
            <p class="lead fade-up d2">
                Satu portal untuk jadwal, absensi WiFi, nilai, pengumuman, dan asisten AI sekolah.
            </p>
            <div class="feature-grid fade-up d3">
                <div class="feature-item">
                    <div class="fi"><i class="bi bi-wifi"></i></div>
                    <span>Absensi berbasis WiFi Sekolah</span>
                </div>
                <div class="feature-item">
                    <div class="fi"><i class="bi bi-robot"></i></div>
                    <span>SekolahBot — asisten virtual AI</span>
                </div>
                <div class="feature-item">
                    <div class="fi"><i class="bi bi-shield-check"></i></div>
                    <span>Aman untuk siswa, guru & staf</span>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-card fade-up">
            <div class="text-center mb-4 d-lg-none">
                <div class="d-inline-flex align-items-center justify-content-center rounded-3 text-white mb-2"
                     style="width:48px;height:48px;background:linear-gradient(135deg,#6366f1,#4f46e5);">
                    <i class="bi bi-mortarboard-fill fs-5"></i>
                </div>
                <div class="fw-bold">Portal Sekolah</div>
            </div>

            <h2>Selamat datang</h2>
            <p class="text-muted mb-4" style="font-size:0.95rem;">Masuk ke akun portal Anda</p>

            @if (session('status'))
                <div class="alert alert-success border-0 small rounded-3">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               required autofocus autocomplete="username" placeholder="nama@email.com">
                    </div>
                    @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input id="password" type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required autocomplete="current-password" placeholder="••••••••">
                    </div>
                    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color:#4f46e5;font-weight:500;">Lupa password?</a>
                    @endif
                </div>
                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
            </form>

            <div class="demo-box">
                <strong class="d-block mb-1">Akun demo</strong>
                admin@sekolah.sch.id · password<br>
                andi.pratama@siswa.sch.id · password<br>
                tu@sekolah.sch.id · password
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="small text-muted text-decoration-none fw-medium">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke beranda</a><br><a href="{{ route('register') }}" class="small text-decoration-none fw-semibold" style="color:#4f46e5;">Belum punya akun? Daftar
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
