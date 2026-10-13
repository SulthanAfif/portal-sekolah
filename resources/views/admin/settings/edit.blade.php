@extends('layouts.app')
@section('title','Pengaturan Website')
@section('content')
<h4 class="page-title mb-1">Pengaturan Website</h4>
<p class="text-muted mb-4">Hanya Admin — kelola info & latar dashboard</p>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<form method="POST" action="{{ route('admin.settings.update') }}" class="card" enctype="multipart/form-data">
<div class="card-body">
@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label small fw-semibold">Nama Sekolah</label>
<input name="school_name" class="form-control" value="{{ old('school_name', $settings['school_name'] ?? '') }}" required></div>
<div class="col-md-6"><label class="form-label small fw-semibold">Kepala Sekolah</label>
<input name="school_kepala" class="form-control" value="{{ old('school_kepala', $settings['school_kepala'] ?? '') }}"></div>
<div class="col-12"><label class="form-label small fw-semibold">Alamat</label>
<input name="school_address" class="form-control" value="{{ old('school_address', $settings['school_address'] ?? '') }}" required></div>
<div class="col-md-4"><label class="form-label small fw-semibold">Telepon</label>
<input name="school_phone" class="form-control" value="{{ old('school_phone', $settings['school_phone'] ?? '') }}" required></div>
<div class="col-md-4"><label class="form-label small fw-semibold">Email</label>
<input name="school_email" type="email" class="form-control" value="{{ old('school_email', $settings['school_email'] ?? '') }}" required></div>
<div class="col-md-4"><label class="form-label small fw-semibold">Jam Operasional</label>
<input name="school_hours" class="form-control" value="{{ old('school_hours', $settings['school_hours'] ?? '') }}" required></div>
<div class="col-12"><label class="form-label small fw-semibold">Visi</label>
<textarea name="school_visi" class="form-control" rows="3" required>{{ old('school_visi', $settings['school_visi'] ?? '') }}</textarea></div>
<div class="col-12"><label class="form-label small fw-semibold">Misi (satu baris per poin)</label>
<textarea name="school_misi" class="form-control" rows="4" required>{{ old('school_misi', $settings['school_misi'] ?? '') }}</textarea></div>
<div class="col-12"><label class="form-label small fw-semibold">Struktur teks (opsional)</label>
<textarea name="school_struktur" class="form-control" rows="4">{{ old('school_struktur', $settings['school_struktur'] ?? '') }}</textarea></div>
<div class="col-12"><label class="form-label small fw-semibold">Foto Latar Dashboard</label>
<input type="file" name="dashboard_bg" class="form-control" accept="image/*">
<div class="form-text mb-2">Pilih file gambar, atau masukkan tautan langsung ke gambar di bawah.</div>
<label for="dashboard-bg-url" class="form-label small fw-semibold">Link Gambar (opsional)</label>
<input id="dashboard-bg-url" type="url" name="dashboard_bg_url" class="form-control" maxlength="2048" placeholder="https://contoh.com/gambar-latar.jpg" value="{{ old('dashboard_bg_url', $settings['dashboard_bg_url'] ?? '') }}">
@error('dashboard_bg_url')<div class="small text-danger mt-1">{{ $message }}</div>@enderror
<div class="form-text">Gunakan tautan langsung ke file JPG, PNG, atau WebP yang bisa dibuka publik.</div>
@if(!empty($settings['dashboard_bg_url']))
<img src="{{ $settings['dashboard_bg_url'] }}" alt="Pratinjau latar dari tautan" class="mt-2 rounded" style="max-height:120px;max-width:100%;object-fit:cover;">
@elseif(!empty($settings['dashboard_bg']))
<img src="{{ asset('storage/'.$settings['dashboard_bg']) }}" alt="Pratinjau latar yang diunggah" class="mt-2 rounded" style="max-height:120px;max-width:100%;object-fit:cover;">
@endif
</div>
</div>
<button class="btn btn-primary mt-4">Simpan Pengaturan</button>
</div></form>
@endsection
