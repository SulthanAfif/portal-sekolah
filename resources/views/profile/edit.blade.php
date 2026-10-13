@extends('layouts.app')
@section('title','Profil')
@section('content')
<div class="mb-4">
    <h4 class="page-title mb-1">Profil Saya</h4>
    <p class="text-muted mb-0">Kelola data & foto akun</p>
</div>
@if(session('status')==='profile-updated')
<div class="alert alert-success border-0">Profil berhasil diperbarui.</div>
@endif
<div class="row g-4">
<div class="col-lg-4">
<div class="card text-center">
<div class="card-body py-4">
<img src="{{ $user->profilePhotoUrl() }}" alt="Foto" class="rounded-circle mb-3 object-fit-cover"
     style="width:96px;height:96px;border:3px solid rgba(99,102,241,0.4);">
<h5 class="fw-bold mb-1">{{ $user->name }}</h5>
<span class="badge bg-primary bg-opacity-10 text-primary text-capitalize">{{ $user->role }}</span>
<div class="text-start small mt-3">
<div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">Email</span><strong>{{ $user->email }}</strong></div>
<div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">NIS/NIP</span><strong>{{ $user->nis_nip ?? '—' }}</strong></div>
@if($user->role==='siswa')
<div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">Kelas</span><strong>{{ $user->kelas?->nama ?? '—' }}</strong></div>
@endif
<div class="d-flex justify-content-between py-2"><span class="text-muted">No. HP</span><strong>{{ $user->no_hp ?? '—' }}</strong></div>
</div>
</div></div>
</div>
<div class="col-lg-8">
<div class="card mb-4">
<div class="card-header">Ubah Data & Foto</div>
<div class="card-body">
<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">@csrf @method('PATCH')
<div class="row g-3">
<div class="col-md-6"><label class="form-label small fw-semibold">Nama</label>
<input name="name" class="form-control" value="{{ old('name',$user->name) }}" required></div>
<div class="col-md-6"><label class="form-label small fw-semibold">Email</label>
<input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}" required></div>
<div class="col-12"><label class="form-label small fw-semibold">Foto Profil (JPG/PNG, max 2MB)</label>
<input type="file" name="profile_photo" class="form-control" accept="image/*"></div>
</div>
<button class="btn btn-primary mt-3">Simpan</button>
</form>
</div></div>
<div class="card">
<div class="card-header">Ubah Password</div>
<div class="card-body">
<form method="POST" action="{{ route('password.update') }}">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-4"><label class="form-label small fw-semibold">Password saat ini</label>
<input type="password" name="current_password" class="form-control" required></div>
<div class="col-md-4"><label class="form-label small fw-semibold">Password baru</label>
<input type="password" name="password" class="form-control" required></div>
<div class="col-md-4"><label class="form-label small fw-semibold">Konfirmasi</label>
<input type="password" name="password_confirmation" class="form-control" required></div>
</div>
<button class="btn btn-outline-primary mt-3">Update Password</button>
</form>
</div></div>
</div>
</div>
@endsection
