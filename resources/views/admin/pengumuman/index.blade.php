@extends('layouts.app')
@section('title','Kelola Pengumuman')
@section('content')
<div class="d-flex justify-content-between mb-4"><div><h4 class="page-title mb-1">Kelola Pengumuman</h4></div>
<a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Buat</a></div>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<div class="card"><div class="list-group list-group-flush">
@forelse($items as $p)
<div class="list-group-item d-flex justify-content-between align-items-start gap-3 py-3">
<div>
<span class="badge bg-primary bg-opacity-10 text-primary text-capitalize mb-1">{{ $p->target }}</span>
@if(!$p->is_published)<span class="badge bg-secondary">Draft</span>@endif
<div class="fw-semibold">{{ $p->judul }}</div>
<small class="text-muted">{{ $p->published_at?->diffForHumans() ?? $p->created_at->diffForHumans() }}</small>
</div>
<div class="d-flex gap-1">
<a href="{{ route('admin.pengumuman.edit',$p) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
<form action="{{ route('admin.pengumuman.destroy',$p) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</div></div>
@empty<div class="p-4 text-center text-muted">Belum ada pengumuman</div>@endforelse
</div>{{ $items->links() }}</div>
@endsection
