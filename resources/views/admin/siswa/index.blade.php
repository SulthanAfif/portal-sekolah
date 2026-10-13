@extends('layouts.app')
@section('title','Data Siswa')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate-fade-up">
    <div><h4 class="page-title mb-1">Data Siswa</h4><p class="text-muted mb-0">Kelola siswa berdasarkan kelas, angkatan, lokal, dan jurusan</p></div>
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah Siswa</a>
</div>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<form method="GET" action="{{ route('admin.siswa.index') }}" class="card mb-3 animate-fade-up"><div class="card-body row g-2 align-items-end">
    <div class="col-md-6 col-xl-2"><label class="form-label small fw-semibold" for="student-search">Cari</label><input id="student-search" type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nama atau email"></div>
    <div class="col-md-6 col-xl-2"><label class="form-label small fw-semibold" for="student-nis">NIS</label><input id="student-nis" type="text" name="nis" value="{{ request('nis') }}" class="form-control" placeholder="Cari NIS"></div>
    <div class="col-md-6 col-xl-2"><label class="form-label small fw-semibold" for="student-tingkat">Angkatan / Tingkat</label><select id="student-tingkat" name="tingkat" class="form-select"><option value="">Semua tingkat</option>@foreach($tingkatList as $tingkat)<option value="{{ $tingkat }}" @selected(request('tingkat') === $tingkat)>{{ $tingkat }}</option>@endforeach</select></div>
    <div class="col-md-6 col-xl-2"><label class="form-label small fw-semibold" for="student-jurusan">Jurusan</label><select id="student-jurusan" name="jurusan" class="form-select"><option value="">Semua jurusan</option>@foreach($jurusanList as $jurusan)<option value="{{ $jurusan }}" @selected(request('jurusan') === $jurusan)>{{ $jurusan }}</option>@endforeach</select></div>
    <div class="col-md-6 col-xl-2"><label class="form-label small fw-semibold" for="student-lokal">Lokal</label><select id="student-lokal" name="lokal" class="form-select"><option value="">Semua lokal</option>@foreach($lokalList as $lokal)<option value="{{ $lokal }}" @selected(request('lokal') === $lokal)>{{ $lokal }}</option>@endforeach</select></div>
    <div class="col-md-6 col-xl-2"><label class="form-label small fw-semibold" for="student-kelas">Kelas</label><select id="student-kelas" name="kelas_id" class="form-select"><option value="">Semua kelas</option>@foreach($kelasList as $k)<option value="{{ $k->id }}" @selected(request('kelas_id') == $k->id)>{{ $k->nama }}</option>@endforeach</select></div>
    <div class="col-12 d-flex justify-content-end gap-2"><a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">Reset</a><button class="btn btn-outline-primary"><i class="bi bi-funnel me-1"></i>Filter</button></div>
</div></form>
<div class="d-flex justify-content-between align-items-center mb-2"><span class="small text-muted">{{ $siswa->total() }} siswa ditemukan</span></div>
<div class="card animate-fade-up animate-delay-1"><div class="table-responsive"><table class="table table-hover mb-0 align-middle">
<thead><tr><th class="ps-3">Nama</th><th>NIS</th><th>Kelas</th><th>Email</th><th>Status</th><th></th></tr></thead>
<tbody>
@forelse($siswa as $s)
<tr>
<td class="ps-3 fw-semibold">{{ $s->name }}</td>
<td class="small text-muted">{{ $s->nis_nip }}</td>
<td>{{ $s->kelas?->nama ?? '—' }}</td>
<td class="small">{{ $s->email }}</td>
<td>@if($s->is_active)<span class="badge bg-success">Aktif</span>@else<span class="badge bg-secondary">Nonaktif</span>@endif</td>
<td class="text-end pe-3">
<a href="{{ route('admin.siswa.edit',$s) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
<form action="{{ route('admin.siswa.destroy',$s) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus siswa ini?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data</td></tr>@endforelse
</tbody></table></div>
@if($siswa->hasPages())<div class="card-footer">{{ $siswa->links() }}</div>@endif
</div>
@endsection
