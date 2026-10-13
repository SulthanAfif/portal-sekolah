@extends('layouts.app')
@section('title', $pengumuman->judul)
@section('content')
<nav aria-label="breadcrumb" class="mb-3 animate-fade-up">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
        <li class="breadcrumb-item active text-truncate" style="max-width:200px;">{{ $pengumuman->judul }}</li>
    </ol>
</nav>

<div class="row g-4">
    <div class="col-lg-8 animate-fade-up">
        <div class="card">
            <div class="card-body p-4">
                <span class="badge bg-primary bg-opacity-10 text-primary text-capitalize mb-2">{{ $pengumuman->target }}</span>
                <h3 class="fw-bold mb-3">{{ $pengumuman->judul }}</h3>
                <div class="d-flex flex-wrap gap-3 text-muted small mb-4">
                    <span><i class="bi bi-person me-1"></i>{{ $pengumuman->pembuat?->name ?? 'Admin' }}</span>
                    <span><i class="bi bi-calendar3 me-1"></i>{{ $pengumuman->published_at?->format('d M Y, H:i') }}</span>
                </div>
                <div class="pengumuman-isi" style="line-height:1.8;">
                    {!! nl2br(e($pengumuman->isi)) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 animate-fade-up animate-delay-1">
        <div class="card">
            <div class="card-header"><i class="bi bi-megaphone me-2 text-primary"></i>Lainnya</div>
            <div class="list-group list-group-flush">
                @forelse($related as $r)
                    <a href="{{ route('pengumuman.show', $r) }}" class="list-group-item list-group-item-action">
                        <div class="fw-semibold small">{{ $r->judul }}</div>
                        <small class="text-muted">{{ $r->published_at?->diffForHumans() }}</small>
                    </a>
                @empty
                    <div class="p-3 text-muted small">Tidak ada pengumuman lain</div>
                @endforelse
            </div>
        </div>
        <a href="{{ route('pengumuman.index') }}" class="btn btn-outline-primary w-100 mt-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection
