@extends('layouts.app')
@section('title','Struktur Sekolah')
@section('content')
<h4 class="page-title mb-1">Struktur Organisasi</h4>
<p class="text-muted mb-4">{{ $s['school_name'] ?? 'Sekolah' }}</p>
<div class="row g-4">
<div class="col-lg-5">
<div class="card text-center mb-3">
<div class="card-body py-4">
<div class="mx-auto mb-2 d-flex align-items-center justify-content-center text-white"
style="width:64px;height:64px;border-radius:16px;background:linear-gradient(135deg,#6366f1,#4f46e5);font-size:1.5rem;">
<i class="bi bi-person-badge"></i></div>
<div class="text-muted small">Kepala Sekolah</div>
<div class="fw-bold fs-5">{{ $kepala }}</div>
</div></div>
<div class="card"><div class="card-header">Hirarki</div><div class="card-body">
@foreach($lines as $i => $line)
<div class="d-flex align-items-center gap-2 mb-2">
<span class="badge bg-primary bg-opacity-10 text-primary">{{ $i+1 }}</span>
<span class="fw-semibold">{{ $line }}</span>
</div>
@endforeach
</div></div>
</div>
<div class="col-lg-7">
<div class="card"><div class="card-header">Wali Kelas</div>
<div class="table-responsive"><table class="table table-hover mb-0">
<thead><tr><th class="ps-3">Kelas</th><th>Wali Kelas</th></tr></thead>
<tbody>
@foreach($wali as $k)
<tr><td class="ps-3 fw-semibold">{{ $k->nama }}</td><td>{{ $k->waliKelas?->name ?? '—' }}</td></tr>
@endforeach
</tbody></table></div></div>
</div>
</div>
@endsection
