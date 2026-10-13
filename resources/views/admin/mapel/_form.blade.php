@php $m = $mapel ?? null; @endphp
<div class="mb-3"><label class="form-label small fw-semibold">Kode</label><input name="kode" class="form-control" value="{{ old('kode',$m->kode??'') }}" required></div>
<div class="mb-3"><label class="form-label small fw-semibold">Nama</label><input name="nama" class="form-control" value="{{ old('nama',$m->nama??'') }}" required></div>
<div class="mb-3"><label class="form-label small fw-semibold">Guru Pengampu</label>
<select name="guru_id" class="form-select"><option value="">—</option>
@foreach($gurus as $g)<option value="{{ $g->id }}" @selected(old('guru_id',$m->guru_id??'')==$g->id)>{{ $g->name }}</option>@endforeach
</select></div>
