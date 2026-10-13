@extends('layouts.app')
@section('title','Kelola Nilai')
@section('content')
<div class="d-flex justify-content-between mb-4"><div><h4 class="page-title mb-1">Kelola Nilai</h4></div>
<a href="{{ route('admin.nilai.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Input Nilai</a></div>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<form class="card mb-3"><div class="card-body row g-2">
<div class="col-md-4"><select name="kelas_id" class="form-select" onchange="this.form.submit()"><option value="">Semua kelas</option>@foreach($kelasList as $k)<option value="{{ $k->id }}" @selected(request('kelas_id')==$k->id)>{{ $k->nama }}</option>@endforeach</select></div>
<div class="col-md-4"><select name="mapel_id" class="form-select" onchange="this.form.submit()"><option value="">Semua mapel</option>@foreach($mapels as $m)<option value="{{ $m->id }}" @selected(request('mapel_id')==$m->id)>{{ $m->nama }}</option>@endforeach</select></div>
</div></form>
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0">
<thead><tr><th class="ps-3">Siswa</th><th>Mapel</th><th>Jenis</th><th>Nilai</th><th>Semester</th><th></th></tr></thead>
<tbody>
@forelse($nilais as $n)
<tr>
<td class="ps-3 fw-semibold">{{ $n->siswa->name }}</td>
<td>{{ $n->mapel->nama }}</td>
<td>{{ $n->jenis }}</td>
<td><span class="fw-bold {{ $n->nilai>=75?'text-success':'text-danger' }}">{{ $n->nilai }}</span></td>
<td class="small">{{ $n->semester }} {{ $n->tahun_ajaran }}</td>
<td class="text-end pe-3">
<form action="{{ route('admin.nilai.destroy',$n) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-4">Belum ada nilai</td></tr>@endforelse
</tbody></table></div>{{ $nilais->links() }}</div>
@endsection
