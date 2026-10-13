@extends('layouts.app')

@section('title', 'Kelola Absensi')

@section('content')
<div class="mb-4">
    <h4 class="page-title mb-1">Kelola Absensi</h4>
    <p class="text-muted mb-0">Input & pantau kehadiran siswa per kelas</p>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('absensi.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Kelas</label>
                <select name="kelas_id" class="form-select">
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" @selected($kelas && $kelas->id == $k->id)>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

@if($kelas && $siswa->count())
<form action="{{ route('absensi.bulk') }}" method="POST">
    @csrf
    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
    <input type="hidden" name="tanggal" value="{{ $tanggal }}">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-people me-2 text-primary"></i>
                {{ $kelas->nama }} — {{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('D MMMM Y') }}
            </span>
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Semua
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width:40px;">#</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th style="min-width:280px;">Status</th>
                        <th>Info</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $i => $s)
                        @php $abs = $absensiMap->get($s->id); @endphp
                        <tr>
                            <td class="ps-3 text-muted">{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $s->name }}</td>
                            <td class="small text-muted">{{ $s->nis_nip }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    @foreach(['hadir','izin','sakit','alpha'] as $st)
                                        <input type="radio" class="btn-check" name="status[{{ $s->id }}]"
                                               id="st-{{ $s->id }}-{{ $st }}" value="{{ $st }}"
                                               @checked(($abs->status ?? 'hadir') === $st) required>
                                        <label class="btn btn-outline-{{ match($st) {
                                            'hadir' => 'success',
                                            'izin'  => 'primary',
                                            'sakit' => 'warning',
                                            'alpha' => 'danger',
                                        } }}" for="st-{{ $s->id }}-{{ $st }}">
                                            {{ ucfirst($st) }}
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                            <td class="small text-muted">
                                @if($abs)
                                    @if($abs->metode === 'self')
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            <i class="bi bi-wifi"></i> Self {{ $abs->waktu_absen?->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">Manual</span>
                                    @endif
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white text-end">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Absensi
            </button>
        </div>
    </div>
</form>
@elseif($kelas)
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            <i class="bi bi-people fs-2 d-block mb-2 opacity-50"></i>
            Belum ada siswa di kelas {{ $kelas->nama }}
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            Pilih kelas untuk menampilkan data absensi
        </div>
    </div>
@endif
@endsection
