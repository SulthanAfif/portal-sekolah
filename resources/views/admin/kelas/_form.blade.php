@php $k = $kelas ?? null; @endphp
<div class="mb-3"><label class="form-label small fw-semibold">Nama Kelas</label><input name="nama" class="form-control" value="{{ old('nama',$k->nama??'') }}" required></div>
<div class="mb-3"><label class="form-label small fw-semibold">Tingkat</label><input name="tingkat" class="form-control" value="{{ old('tingkat',$k->tingkat??'') }}" placeholder="X / XI / XII" required></div>
<div class="mb-3"><label class="form-label small fw-semibold">Jurusan</label><input name="jurusan" class="form-control" value="{{ old('jurusan',$k->jurusan??'') }}"></div>
<div class="mb-3"><label class="form-label small fw-semibold">Wali Kelas</label>
<select name="wali_kelas_id" class="form-select"><option value="">—</option>
@foreach($gurus as $g)<option value="{{ $g->id }}" @selected(old('wali_kelas_id',$k->wali_kelas_id??'')==$g->id)>{{ $g->name }}</option>@endforeach
</select></div>
