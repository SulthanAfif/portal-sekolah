@extends('layouts.app')
@section('title', 'Jadwal Pelajaran')
@section('content')
<div class="mb-4 animate-fade-up">
    <h4 class="fw-bold mb-1">Jadwal Pelajaran</h4>
    <p class="text-muted mb-0">Lihat jadwal per kelas</p>
</div>

<form method="GET" class="card mb-4 animate-fade-up animate-delay-1">
    <div class="card-body row g-3 align-items-end">
        <div class="col-md-6">
            <label class="form-label small fw-semibold">Kelas</label>
            <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" @selected($kelasId == $k->id)>{{ $k->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>

@foreach($hariList as $hi => $h)
    @php $items = $jadwals->get($h, collect()); @endphp
    @if($items->count())
    <div class="card mb-3 animate-fade-up" style="animation-delay: {{ 0.05 * ($hi+1) }}s">
        <div class="card-header fw-semibold">{{ $h }}</div>
        <div class="list-group list-group-flush">
            @foreach($items as $j)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-primary fw-semibold me-2">
                            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                        </span>
                        <strong>{{ $j->mapel->nama }}</strong>
                        <small class="text-muted ms-2">{{ $j->guru->name }} • {{ $j->ruangan }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endforeach

@if($jadwals->flatten()->isEmpty())
<div class="card"><div class="card-body text-center text-muted py-5">Belum ada jadwal untuk kelas ini</div></div>
@endif
@endsection
