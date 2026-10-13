@extends('layouts.app')
@section('title','Data Kelas')
@section('content')
<div class="d-flex justify-content-between mb-4"><div><h4 class="page-title mb-1">Data Kelas</h4></div>
<a href="{{ route('admin.kelas.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah</a></div>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0">
<thead><tr><th class="ps-3">Nama</th><th>Tingkat</th><th>Jurusan</th><th>Wali Kelas</th><th>Siswa</th><th></th></tr></thead>
<tbody>
@foreach($kelas as $k)
<tr>
<td class="ps-3 fw-semibold">{{ $k->nama }}</td><td>{{ $k->tingkat }}</td><td>{{ $k->jurusan }}</td>
<td>{{ $k->waliKelas?->name ?? '—' }}</td><td>{{ $k->siswa_count }}</td>
<td class="text-end pe-3">
<a href="{{ route('admin.kelas.edit',$k) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
<form action="{{ route('admin.kelas.destroy',$k) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td></tr>
@endforeach
</tbody></table></div>{{ $kelas->links() }}</div>
@endsection
