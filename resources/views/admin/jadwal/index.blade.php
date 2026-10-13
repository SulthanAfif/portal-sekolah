@extends('layouts.app')
@section('title','Kelola Jadwal')
@section('content')
<div class="d-flex justify-content-between mb-4"><div><h4 class="page-title mb-1">Kelola Jadwal</h4></div>
<a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah</a></div>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<form class="card mb-3"><div class="card-body row g-2 align-items-end">
<div class="col-md-6"><select name="kelas_id" class="form-select" onchange="this.form.submit()"><option value="">Semua kelas</option>
@foreach($kelasList as $k)<option value="{{ $k->id }}" @selected($kelasId==$k->id)>{{ $k->nama }}</option>@endforeach
</select></div></div></form>
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0 small">
<thead><tr><th class="ps-3">Hari</th><th>Jam</th><th>Mapel</th><th>Kelas</th><th>Guru</th><th>Ruang</th><th></th></tr></thead>
<tbody>
@forelse($jadwals as $j)
<tr>
<td class="ps-3">{{ $j->hari }}</td>
<td>{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</td>
<td class="fw-semibold">{{ $j->mapel->nama }}</td>
<td>{{ $j->kelas->nama }}</td>
<td>{{ $j->guru->name }}</td>
<td>{{ $j->ruangan }}</td>
<td class="text-end pe-3">
<a href="{{ route('admin.jadwal.edit',$j) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
<form action="{{ route('admin.jadwal.destroy',$j) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td></tr>
@empty<tr><td colspan="7" class="text-center text-muted py-4">Belum ada jadwal</td></tr>@endforelse
</tbody></table></div>{{ $jadwals->links() }}</div>
@endsection
