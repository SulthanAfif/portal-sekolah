@extends('layouts.app')
@section('title', 'Pengumuman')
@section('content')
<div class="mb-4 animate-fade-up">
    <h4 class="page-title mb-1">Pengumuman</h4>
    <p class="text-muted mb-0">Informasi & berita terbaru dari sekolah</p>
</div>

<form method="GET" class="mb-4 animate-fade-up animate-delay-1">
    <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        <input type="text" name="q" class="form-control" placeholder="Cari pengumuman..." value="{{ request('q') }}">
        <button class="btn btn-primary">Cari</button>
    </div>
</form>

<div class="row g-3">
    @forelse($pengumumans as $i => $p)
        <div class="col-md-6 animate-fade-up" style="animation-delay: {{ 0.05 * ($i + 1) }}s">
            <a href="{{ route('pengumuman.show', $p) }}" class="card h-100 text-decoration-none text-dark hover-lift">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary text-capitalize">{{ $p->target }}</span>
                        <small class="text-muted">{{ $p->published_at?->diffForHumans() }}</small>
                    </div>
                    <h6 class="fw-semibold mb-2">{{ $p->judul }}</h6>
                    <p class="text-muted small mb-0">{{ Str::limit(strip_tags($p->isi), 120) }}</p>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <small class="text-muted"><i class="bi bi-person me-1"></i>{{ $p->pembuat?->name ?? 'Admin' }}</small>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    <i class="bi bi-megaphone fs-2 d-block mb-2 opacity-50"></i>
                    Tidak ada pengumuman
                </div>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $pengumumans->links() }}</div>
@endsection
