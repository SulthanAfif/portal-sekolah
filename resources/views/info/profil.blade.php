@extends('layouts.app')
@section('title','Profil Sekolah')
@section('content')
<h4 class="page-title mb-1">Profil Sekolah</h4>
<p class="text-muted mb-4">Informasi resmi lembaga</p>
<div class="row g-4">
<div class="col-lg-8">
<div class="card mb-4"><div class="card-body">
<h5 class="fw-bold mb-2">{{ $s['school_name'] ?? 'Sekolah' }}</h5>
<p class="text-muted small mb-0"><i class="bi bi-geo-alt me-1"></i>{{ $s['school_address'] ?? '-' }}</p>
</div></div>
<div class="card mb-4"><div class="card-header">Visi</div><div class="card-body">{{ $s['school_visi'] ?? '-' }}</div></div>
<div class="card mb-4"><div class="card-header">Misi</div><div class="card-body">
<ul class="mb-0">@foreach(array_filter(array_map('trim', explode("\n", $s['school_misi'] ?? ''))) as $m)<li class="mb-1">{{ $m }}</li>@endforeach</ul>
</div></div>
</div>
<div class="col-lg-4">
<div class="card mb-3"><div class="card-body">
<div class="small text-muted">Kepala Sekolah</div>
<div class="fw-bold">{{ $s['school_kepala'] ?? '-' }}</div>
</div></div>
<div class="card mb-3"><div class="card-body">
<div class="small text-muted mb-2">Kontak</div>
<div class="small mb-1"><i class="bi bi-telephone me-1"></i>{{ $s['school_phone'] ?? '-' }}</div>
<div class="small mb-1"><i class="bi bi-envelope me-1"></i>{{ $s['school_email'] ?? '-' }}</div>
<div class="small"><i class="bi bi-clock me-1"></i>{{ $s['school_hours'] ?? '-' }}</div>
</div></div>
<div class="card"><div class="card-body d-flex gap-3">
<div><div class="fs-4 fw-bold text-primary">{{ $stats['siswa'] }}</div><small class="text-muted">Siswa</small></div>
<div><div class="fs-4 fw-bold text-primary">{{ $stats['guru'] }}</div><small class="text-muted">Guru</small></div>
<div><div class="fs-4 fw-bold text-primary">{{ $stats['kelas'] }}</div><small class="text-muted">Kelas</small></div>
</div></div>
</div>
</div>
@endsection
