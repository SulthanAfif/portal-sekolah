@extends('layouts.app')
@section('title','Input Nilai')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div><h4 class="page-title mb-1">Nilai Saya Input</h4><p class="text-muted mb-0">Nilai yang Anda kirim ke TU/Admin</p></div>
    <a href="{{ route('guru.nilai.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Input Nilai</a>
</div>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0">
<thead><tr><th class="ps-3">Siswa</th><th>Mapel</th><th>Jenis</th><th>Nilai</th><th>Status</th><th></th></tr></thead>
<tbody>
@forelse($nilais as $n)
<tr>
<td class="ps-3 fw-semibold">{{ $n->siswa->name }}</td>
<td>{{ $n->mapel->nama }}</td>
<td>{{ $n->jenis }}</td>
<td class="fw-bold">{{ $n->nilai }}</td>
<td>
@if(($n->status??'')==='approved')<span class="badge bg-success">Disetujui</span>
@else<span class="badge bg-warning text-dark">Terkirim ke TU</span>@endif
</td>
<td class="text-end pe-3">
<form action="{{ route('guru.nilai.destroy',$n) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-4">Belum ada nilai</td></tr>@endforelse
</tbody></table></div>{{ $nilais->links() }}</div>
@endsection
