@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="mb-4 animate-fade-up">
    <h4 class="page-title mb-1">Selamat datang, {{ auth()->user()->name }} 👋</h4>
    <p class="text-muted mb-0">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
</div>

@if($kelasWali ?? null)
<div class="alert alert-primary border-0 d-flex align-items-center gap-3 mb-4 animate-fade-up">
    <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width:48px;height:48px;">
        <i class="bi bi-person-workspace fs-4"></i>
    </div>
    <div>
        <div class="fw-semibold">Anda adalah Wali Kelas</div>
        <div class="small">{{ $kelasWali->nama }} • {{ $totalSiswaWali ?? 0 }} siswa</div>
    </div>
</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-lg-7 animate-fade-up animate-delay-1">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar3 me-2 text-primary"></i>Jadwal Mengajar Hari Ini</span>
                <span class="badge bg-primary">{{ now()->locale('id')->isoFormat('dddd') }}</span>
            </div>
            <div class="card-body p-0">
                @forelse($jadwalHariIni ?? [] as $j)
                    <div class="d-flex align-items-center gap-3 px-3 py-3 border-bottom">
                        <div class="text-center" style="min-width:72px;">
                            <div class="fw-bold text-primary">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}</div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</small>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $j->mapel->nama ?? '-' }}</div>
                            <small class="text-muted">{{ $j->kelas->nama ?? '-' }} • {{ $j->ruangan ?? '-' }}</small>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                        Tidak ada jadwal mengajar hari ini
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-5 animate-fade-up animate-delay-2">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-megaphone me-2 text-primary"></i>Pengumuman</div>
            <div class="list-group list-group-flush">
                @forelse($pengumuman ?? [] as $p)
                    <div class="list-group-item px-3 py-3">
                        <div class="fw-semibold mb-1">{{ $p->judul }}</div>
                        <small class="text-muted">{{ optional($p->published_at)->diffForHumans() }}</small>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">Belum ada pengumuman</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-6 col-md-3">
        <a href="{{ route('absensi.index') }}" class="card stat-card text-decoration-none h-100">
            <div class="card-body text-center py-4">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary mx-auto mb-2"><i class="bi bi-clipboard-check"></i></div>
                <div class="fw-semibold small" style="color:#e2e8f0">Input Absensi</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('guru.nilai.index') }}" class="card stat-card text-decoration-none h-100">
            <div class="card-body text-center py-4">
                <div class="stat-icon bg-success bg-opacity-10 text-success mx-auto mb-2"><i class="bi bi-award"></i></div>
                <div class="fw-semibold small" style="color:#e2e8f0">Input Nilai</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('jadwal.index') }}" class="card stat-card text-decoration-none h-100">
            <div class="card-body text-center py-4">
                <div class="stat-icon bg-info bg-opacity-10 text-info mx-auto mb-2"><i class="bi bi-calendar3"></i></div>
                <div class="fw-semibold small" style="color:#e2e8f0">Lihat Jadwal</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('guru.cuti.index') }}" class="card stat-card text-decoration-none h-100">
            <div class="card-body text-center py-4">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning mx-auto mb-2"><i class="bi bi-calendar2-check"></i></div>
                <div class="fw-semibold small" style="color:#e2e8f0">Cuti / Izin</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('chatbot.index') }}" class="card stat-card text-decoration-none h-100">
            <div class="card-body text-center py-4">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary mx-auto mb-2"><i class="bi bi-robot"></i></div>
                <div class="fw-semibold small" style="color:#e2e8f0">SekolahBot</div>
            </div>
        </a>
    </div>
</div>
@endsection
