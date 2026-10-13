@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="mb-4">
    <h4 class="page-title mb-1">Halo, {{ auth()->user()->name }} 👋</h4>
    <p class="text-muted mb-0">
        @if($kelas) Kelas <strong>{{ $kelas->nama }}</strong> • @endif
        {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
    </p>
</div>

<!-- Absensi Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card text-center py-3">
            <div class="fs-3 fw-bold text-success">{{ $totalHadir }}</div>
            <div class="small text-muted">Hadir</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card text-center py-3">
            <div class="fs-3 fw-bold text-primary">{{ $totalIzin }}</div>
            <div class="small text-muted">Izin</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card text-center py-3">
            <div class="fs-3 fw-bold text-warning">{{ $totalSakit }}</div>
            <div class="small text-muted">Sakit</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card text-center py-3">
            <div class="fs-3 fw-bold text-danger">{{ $totalAlpha }}</div>
            <div class="small text-muted">Alpha</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Jadwal Hari Ini -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-calendar3 me-2 text-primary"></i>Jadwal Hari Ini</span>
                <span class="badge bg-primary">{{ now()->locale('id')->isoFormat('dddd') }}</span>
            </div>
            <div class="card-body p-0">
                @forelse($jadwalHariIni as $j)
                    <div class="d-flex align-items-center gap-3 px-3 py-3 border-bottom">
                        <div class="text-center" style="min-width:70px;">
                            <div class="fw-bold text-primary">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}</div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</small>
                        </div>
                        <div class="vr"></div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $j->mapel->nama }}</div>
                            <small class="text-muted">{{ $j->guru->name }} • {{ $j->ruangan }}</small>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                        Tidak ada jadwal hari ini
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pengumuman -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-megaphone me-2 text-warning"></i>Pengumuman
            </div>
            <div class="list-group list-group-flush">
                @forelse($pengumuman as $p)
                    <div class="list-group-item px-3 py-3">
                        <div class="fw-semibold">{{ $p->judul }}</div>
                        <small class="text-muted">{{ $p->published_at?->diffForHumans() }}</small>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">Belum ada pengumuman</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
