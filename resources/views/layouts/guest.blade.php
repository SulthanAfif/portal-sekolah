<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Portal Sekolah') }} - @yield('title', 'Login')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2563eb; --primary-dark: #1d4ed8; }
        * { font-family: 'Inter', sans-serif; }
        body { margin: 0; min-height: 100vh; background: #0f172a; }
        .auth-wrapper { min-height: 100vh; display: flex; }
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            display: flex; flex-direction: column; justify-content: center;
            padding: 3rem; color: white; position: relative; overflow: hidden;
        }
        .auth-left::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .auth-left-content { position: relative; z-index: 1; max-width: 420px; }
        .auth-right {
            width: 480px; max-width: 100%;
            background: #fff;
            display: flex; flex-direction: column; justify-content: center;
            padding: 2.5rem;
        }
        .auth-card { max-width: 380px; margin: 0 auto; width: 100%; }
        .form-control {
            border-radius: 0.75rem; padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0; transition: all 0.2s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
        }
        .btn-primary {
            background: var(--primary); border: none; border-radius: 0.75rem;
            padding: 0.75rem; font-weight: 600;
            transition: all 0.2s;
        }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
        .logo-icon {
            width: 56px; height: 56px; border-radius: 16px;
            background: rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.75rem; margin-bottom: 1.5rem;
        }
        .feature-item {
            display: flex; align-items: center; gap: 0.75rem;
            margin-bottom: 1rem; opacity: 0.9;
        }
        .feature-item i {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
        }
        @media (max-width: 991.98px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; }
        }
        /* Animations */
        .fade-up {
            animation: fadeUp 0.6s ease both;
        }
        .fade-up-delay-1 { animation-delay: 0.1s; }
        .fade-up-delay-2 { animation-delay: 0.2s; }
        .fade-up-delay-3 { animation-delay: 0.3s; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-left">
            <div class="auth-left-content">
                <div class="logo-icon fade-up">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h1 class="fw-bold mb-3 fade-up fade-up-delay-1">Portal Sekolah</h1>
                <p class="opacity-75 mb-4 fade-up fade-up-delay-2">
                    Akses layanan digital sekolah: jadwal, absensi WiFi, nilai, pengumuman, dan asisten AI.
                </p>
                <div class="fade-up fade-up-delay-3">
                    <div class="feature-item">
                        <i class="bi bi-wifi"></i>
                        <span>Absensi berbasis WiFi Sekolah</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-robot"></i>
                        <span>SekolahBot — asisten virtual AI</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Aman untuk siswa dan guru</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="auth-right">
            <div class="auth-card fade-up">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
