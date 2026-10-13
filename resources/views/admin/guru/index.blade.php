@extends('layouts.app')
@section('title','Data Guru')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
<div><h4 class="page-title mb-1">Data Guru</h4><p class="text-muted mb-0">Kelola akun guru</p></div>
<a href="{{ route('admin.guru.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah Guru</a>
</div>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<form class="card mb-3"><div class="card-body row g-2"><div class="col-md-8"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari..."></div><div class="col-md-4"><button class="btn btn-outline-primary w-100">Cari</button></div></div></form>
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0 align-middle">
<thead><tr><th class="ps-3">Nama</th><th>NIP</th><th>Email</th><th>Status</th><th></th></tr></thead>
<tbody>
@forelse($guru as $g)
<tr><td class="ps-3 fw-semibold">{{ $g->name }}</td><td>{{ $g->nis_nip }}</td><td class="small">{{ $g->email }}</td>
<td>@if($g->is_active)<span class="badge bg-success">Aktif</span>@else<span class="badge bg-secondary">Nonaktif</span>@endif</td>
<td class="text-end pe-3">
<a href="{{ route('admin.guru.edit',$g) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
<form action="{{ route('admin.guru.destroy',$g) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td></tr>
@empty<tr><td colspan="5" class="text-center text-muted py-4">Belum ada data</td></tr>@endforelse
</tbody></table></div>{{ $guru->links() }}</div>
@endsection
