@extends('layouts.app')
@section('title','Input Nilai')
@section('content')
<h4 class="page-title mb-4">Input Nilai Siswa</h4>
<div class="card" style="max-width:560px"><div class="card-body">
<form method="POST" action="{{ route('guru.nilai.store') }}">@csrf
<div class="mb-3"><label class="form-label small fw-semibold">Siswa</label>
<select name="siswa_id" class="form-select" required>@foreach($siswaList as $s)<option value="{{ $s->id }}">{{ $s->name }} ({{ $s->nis_nip }})</option>@endforeach</select></div>
<div class="mb-3"><label class="form-label small fw-semibold">Mapel</label>
<select name="mapel_id" class="form-select" required>@foreach($mapels as $m)<option value="{{ $m->id }}">{{ $m->nama }}</option>@endforeach</select></div>
<div class="mb-3"><label class="form-label small fw-semibold">Kelas</label>
<select name="kelas_id" class="form-select" required>@foreach($kelasList as $k)<option value="{{ $k->id }}">{{ $k->nama }}</option>@endforeach</select></div>
<div class="mb-3"><label class="form-label small fw-semibold">Jenis</label>
<select name="jenis" class="form-select"><option>Harian</option><option>Tugas</option><option>UTS</option><option>UAS</option></select></div>
<div class="mb-3"><label class="form-label small fw-semibold">Nilai</label><input type="number" step="0.01" min="0" max="100" name="nilai" class="form-control" required></div>
<div class="row g-2 mb-3">
<div class="col"><label class="form-label small fw-semibold">Semester</label><select name="semester" class="form-select"><option>Ganjil</option><option>Genap</option></select></div>
<div class="col"><label class="form-label small fw-semibold">Tahun Ajaran</label><input name="tahun_ajaran" class="form-control" value="2025/2026" required></div>
</div>
<div class="mb-3"><label class="form-label small fw-semibold">Catatan (opsional)</label><input name="catatan" class="form-control"></div>
<button class="btn btn-primary">Kirim ke TU/Admin</button>
<a href="{{ route('guru.nilai.index') }}" class="btn btn-outline-secondary">Batal</a>
</form></div></div>
@endsection
