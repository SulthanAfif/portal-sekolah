@extends('layouts.app')
@section('title', 'Jadwal Mengajar')
@section('content')
<div class="mb-4 animate-fade-up">
    <h4 class="page-title mb-1">Jadwal Mengajar</h4>
    <p class="text-muted mb-0">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
</div>

<ul class="nav nav-pills gap-1 mb-4 flex-nowrap overflow-auto animate-fade-up animate-delay-1">
    @foreach($hariList as $h)
        <li class="nav-item">
            <a class="nav-link {{ $hariAktif === $h ? 'active' : '' }}"
               href="{{ route('jadwal.index', ['hari' => $h]) }}">{{ $h }}</a>
        </li>
    @endforeach
</ul>

<div class="card animate-fade-up animate-delay-2">
    <div class="card-header d-flex justify-content-between">
        <span><i class="bi bi-calendar3 me-2 text-primary"></i>Mengajar — {{ $hariAktif }}</span>
        <span class="badge bg-primary">{{ $jadwalHariIni->count() }} sesi</span>
    </div>
    <div class="card-body p-0">
        @forelse($jadwalHariIni as $i => $j)
            <div class="d-flex align-items-center gap-3 px-3 py-3 border-bottom animate-fade-up" style="animation-delay: {{ 0.05 * ($i+1) }}s">
                <div class="text-center" style="min-width:72px;">
                    <div class="fw-bold text-primary">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}</div>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</small>
                </div>
                <div class="vr opacity-25"></div>
                <div class="flex-grow-1">
                    <div class="fw-semibold">{{ $j->mapel->nama }}</div>
                    <small class="text-muted">{{ $j->kelas->nama }} • {{ $j->ruangan ?? '-' }}</small>
                </div>
                <span class="badge bg-light text-dark">{{ $j->kelas->tingkat }}</span>
            </div>
        @empty
            <div class="p-5 text-center text-muted">
                <i class="bi bi-calendar-x fs-2 d-block mb-2 opacity-50"></i>
                Tidak ada jadwal mengajar di hari {{ $hariAktif }}
            </div>
        @endforelse
    </div>
</div>
@endsection
