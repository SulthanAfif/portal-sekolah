@extends('layouts.app')
@section('title','Ajukan Cuti')
@section('content')
<h4 class="page-title mb-4">Form Pengajuan</h4>
<div class="card" style="max-width:560px"><div class="card-body">
<form method="POST" action="{{ route('guru.cuti.store') }}">@csrf
<div class="mb-3"><label class="form-label small fw-semibold">Jenis</label>
<select name="jenis" class="form-select" required>
<option value="cuti">Cuti</option>
<option value="izin">Izin</option>
<option value="sakit">Sakit</option>
<option value="dinas">Dinas / Tugas Luar</option>
</select></div>
<div class="row g-2 mb-3">
<div class="col"><label class="form-label small fw-semibold">Mulai</label>
<input type="date" name="tanggal_mulai" class="form-control" required></div>
<div class="col"><label class="form-label small fw-semibold">Selesai</label>
<input type="date" name="tanggal_selesai" class="form-control" required></div>
</div>
<div class="mb-3"><label class="form-label small fw-semibold">Alasan</label>
<textarea name="alasan" class="form-control" rows="4" required></textarea></div>
<button class="btn btn-primary">Kirim Pengajuan</button>
<a href="{{ route('guru.cuti.index') }}" class="btn btn-outline-secondary">Batal</a>
</form></div></div>
@endsection
