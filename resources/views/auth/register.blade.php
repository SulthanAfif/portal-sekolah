<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar — Portal Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { margin: 0; min-height: 100vh; background: #f4f6fb; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
        .card-reg {
            background: #fff; border-radius: 20px; border: 1px solid #e8ecf4;
            box-shadow: 0 12px 40px rgba(15,23,42,0.08); max-width: 440px; width: 100%; padding: 2rem;
        }
        .form-control, .form-select { border-radius: 12px; border: 1.5px solid #e8ecf4; padding: 0.7rem 1rem; }
        .form-control:focus, .form-select:focus { border-color: #a5b4fc; box-shadow: 0 0 0 4px rgba(79,70,229,0.12); }
        .btn-reg {
            background: linear-gradient(135deg,#6366f1,#4f46e5); border: none; border-radius: 12px;
            padding: 0.85rem; font-weight: 650; color: #fff; width: 100%;
            box-shadow: 0 4px 16px rgba(79,70,229,0.35);
        }
        .btn-reg:hover { color: #fff; filter: brightness(1.05); }
        .domain-hint { background: #eef2ff; border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.8rem; color: #4338ca; }
    </style>
</head>
<body>
<div class="card-reg">
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center rounded-3 text-white mb-2"
             style="width:48px;height:48px;background:linear-gradient(135deg,#6366f1,#4f46e5);">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <h4 class="fw-bold mb-1" style="letter-spacing:-0.03em;">Buat Akun</h4>
        <p class="text-muted small mb-0">Hanya email domain sekolah yang diterima</p>
    </div>

    <div class="domain-hint mb-3">
        <i class="bi bi-shield-check me-1"></i>
        Domain diizinkan: <strong>@{{ implode(', @', $domains) }}</strong>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label small fw-semibold">Nama Lengkap</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label small fw-semibold">Email Sekolah</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="nama@sekolah.sch.id">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label small fw-semibold">Daftar sebagai</label>
            <select name="role" class="form-select" required>
                <option value="siswa" @selected(old('role')==='siswa')>Siswa</option>
                <option value="guru" @selected(old('role')==='guru')>Guru</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-semibold">NIS / NIP (opsional)</label>
            <input type="text" name="nis_nip" class="form-control" value="{{ old('nis_nip') }}">
        </div>
        <div class="mb-3">
            <label class="form-label small fw-semibold">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="form-label small fw-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-reg mb-3">Daftar</button>
        <div class="text-center small">
            Sudah punya akun? <a href="{{ route('login') }}" style="color:#4f46e5;font-weight:600;">Masuk</a>
        </div>
    </form>
</div>
</body>
</html>
