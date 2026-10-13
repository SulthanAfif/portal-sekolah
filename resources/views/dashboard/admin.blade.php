@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-4">
    <h4 class="page-title mb-1">Selamat datang, {{ auth()->user()->name }} 👋</h4>
    <p class="text-muted mb-0">Ringkasan data portal sekolah hari ini</p>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $totalSiswa }}</div>
                    <div class="text-muted small">Total Siswa</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $totalGuru }}</div>
                    <div class="text-muted small">Total Guru</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $totalKelas }}</div>
                    <div class="text-muted small">Total Kelas</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-megaphone-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $totalPengumuman }}</div>
                    <div class="text-muted small">Pengumuman</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Pengumuman -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-megaphone me-2 text-primary"></i>Pengumuman Terbaru</span>
                <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="list-group list-group-flush">
                @forelse($pengumumanTerbaru as $p)
                    <div class="list-group-item px-3 py-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold">{{ $p->judul }}</div>
                                <small class="text-muted">
                                    {{ $p->published_at?->diffForHumans() }} •
                                    <span class="badge bg-light  text-capitalize">{{ $p->target }}</span>
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">Belum ada pengumuman</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Siswa Terbaru -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-person-plus me-2 text-success"></i>Siswa Terbaru
            </div>
            <div class="list-group list-group-flush">
                @forelse($siswaTerbaru as $s)
                    <div class="list-group-item px-3 py-3 d-flex align-items-center gap-3">
                        <div class="user-avatar" style="width:40px;height:40px;font-size:0.9rem;">
                            {{ strtoupper(substr($s->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $s->name }}</div>
                            <small class="text-muted">{{ $s->nis_nip }} • {{ $s->kelas?->nama ?? '-' }}</small>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">Belum ada data</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
