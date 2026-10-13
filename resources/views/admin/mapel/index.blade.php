@extends('layouts.app')
@section('title','Mata Pelajaran')
@section('content')
<div class="d-flex justify-content-between mb-4"><div><h4 class="page-title mb-1">Mata Pelajaran</h4></div>
<a href="{{ route('admin.mapel.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah</a></div>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0">
<thead><tr><th class="ps-3">Kode</th><th>Nama</th><th>Guru</th><th></th></tr></thead>
<tbody>
@foreach($mapels as $m)
<tr><td class="ps-3"><span class="badge bg-primary bg-opacity-10 text-primary">{{ $m->kode }}</span></td>
<td class="fw-semibold">{{ $m->nama }}</td><td>{{ $m->guru?->name ?? '—' }}</td>
<td class="text-end pe-3">
<a href="{{ route('admin.mapel.edit',$m) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
<form action="{{ route('admin.mapel.destroy',$m) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td></tr>
@endforeach
</tbody></table></div>{{ $mapels->links() }}</div>
@endsection
