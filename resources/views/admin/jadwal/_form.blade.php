@php $j = $jadwal ?? null; @endphp
<div class="mb-3"><label class="form-label small fw-semibold">Kelas</label>
<select name="kelas_id" class="form-select" required>@foreach($kelasList as $k)<option value="{{ $k->id }}" @selected(old('kelas_id',$j->kelas_id??'')==$k->id)>{{ $k->nama }}</option>@endforeach</select></div>
<div class="mb-3"><label class="form-label small fw-semibold">Mapel</label>
<select name="mapel_id" class="form-select" required>@foreach($mapels as $m)<option value="{{ $m->id }}" @selected(old('mapel_id',$j->mapel_id??'')==$m->id)>{{ $m->nama }}</option>@endforeach</select></div>
<div class="mb-3"><label class="form-label small fw-semibold">Guru</label>
<select name="guru_id" class="form-select" required>@foreach($gurus as $g)<option value="{{ $g->id }}" @selected(old('guru_id',$j->guru_id??'')==$g->id)>{{ $g->name }}</option>@endforeach</select></div>
<div class="mb-3"><label class="form-label small fw-semibold">Hari</label>
<select name="hari" class="form-select" required>@foreach($hariList as $h)<option value="{{ $h }}" @selected(old('hari',$j->hari??'')==$h)>{{ $h }}</option>@endforeach</select></div>
<div class="row g-2 mb-3">
<div class="col"><label class="form-label small fw-semibold">Jam Mulai</label><input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai', isset($j)?substr($j->jam_mulai,0,5):'') }}" required></div>
<div class="col"><label class="form-label small fw-semibold">Jam Selesai</label><input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai', isset($j)?substr($j->jam_selesai,0,5):'') }}" required></div>
</div>
<div class="mb-3"><label class="form-label small fw-semibold">Ruangan</label><input name="ruangan" class="form-control" value="{{ old('ruangan',$j->ruangan??'') }}"></div>
