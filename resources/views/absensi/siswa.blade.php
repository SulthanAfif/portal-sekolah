@extends('layouts.app')

@section('title', 'Absensi Saya')

@section('content')
<div class="mb-4">
    <h4 class="page-title mb-1">Absensi Saya</h4>
    <p class="text-muted mb-0">
        Absensi mandiri hanya aktif saat terhubung <strong>WiFi Sekolah</strong>
        • Pukul {{ $jamMulai }} – {{ $jamSelesai }}
    </p>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-body text-center py-5">
                @if($absensiHariIni)
                    <div class="mb-3">
                        @if($absensiHariIni->status === 'hadir')
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width:80px;height:80px;">
                                <i class="bi bi-check-lg fs-1"></i>
                            </div>
                        @else
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center" style="width:80px;height:80px;">
                                <i class="bi bi-info-lg fs-1"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="fw-bold text-capitalize">{{ $absensiHariIni->status }}</h5>
                    <p class="text-muted small mb-1">
                        {{ $absensiHariIni->waktu_absen?->format('H:i') ?? '-' }}
                        • {{ $absensiHariIni->metode === 'self' ? 'Self check-in' : 'Dicatat guru' }}
                    </p>
                    @if($absensiHariIni->ip_address)
                        <small class="text-muted">IP: {{ $absensiHariIni->ip_address }}</small>
                    @endif
                @else
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width:80px;height:80px;">
                            <i class="bi bi-wifi fs-1"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold">Belum Absen Hari Ini</h5>
                    <p class="text-muted small mb-4">
                        Pastikan perangkat terhubung WiFi Sekolah,<br>
                        lalu tekan tombol di bawah.
                    </p>

                    @if($dalamJamAbsen)
                        <form action="{{ route('absensi.checkin') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-geo-alt me-2"></i>Absen Sekarang
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning border-0 d-inline-block">
                            <i class="bi bi-clock me-1"></i>
                            Di luar jam absensi ({{ $jamMulai }} – {{ $jamSelesai }})
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar-check me-2 text-primary"></i>Rekap Bulan Ini</span>
                <span class="badge bg-light text-dark">{{ now()->locale('id')->isoFormat('MMMM Y') }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Tanggal</th>
                                <th>Status</th>
                                <th>Metode</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absensiBulanIni as $a)
                                <tr>
                                    <td class="ps-3">{{ $a->tanggal->format('d M Y') }}</td>
                                    <td>
                                        @php
                                            $badge = match($a->status) {
                                                'hadir' => 'success',
                                                'izin'  => 'primary',
                                                'sakit' => 'warning',
                                                'alpha' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badge }} text-capitalize">{{ $a->status }}</span>
                                    </td>
                                    <td class="small text-muted">
                                        {{ $a->metode === 'self' ? 'WiFi Self' : 'Manual' }}
                                    </td>
                                    <td class="small text-muted">
                                        {{ $a->waktu_absen?->format('H:i') ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data absensi bulan ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 bg-light">
    <div class="card-body d-flex align-items-start gap-3">
        <i class="bi bi-info-circle text-primary fs-5"></i>
        <div class="small text-muted">
            <strong>Cara kerja absensi WiFi:</strong>
            Sistem memverifikasi bahwa perangkat Anda terhubung ke jaringan WiFi sekolah (berdasarkan IP address).
            Absensi di luar jaringan sekolah akan ditolak. Jam absensi: <strong>{{ $jamMulai }} – {{ $jamSelesai }}</strong>.
        </div>
    </div>
</div>
@endsection
