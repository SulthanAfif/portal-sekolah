@php $p = $pengumuman ?? null; @endphp
<div class="mb-3"><label class="form-label small fw-semibold">Judul</label><input name="judul" class="form-control" value="{{ old('judul',$p->judul??'') }}" required></div>
<div class="mb-3"><label class="form-label small fw-semibold">Isi</label><textarea name="isi" class="form-control" rows="6" required>{{ old('isi',$p->isi??'') }}</textarea></div>
<div class="mb-3"><label class="form-label small fw-semibold">Target</label>
<select name="target" class="form-select">
@foreach(['semua','siswa','guru'] as $t)
<option value="{{ $t }}" @selected(old('target',$p->target??'semua')===$t)>{{ ucfirst($t) }}</option>
@endforeach
</select></div>
<div class="form-check"><input type="checkbox" name="is_published" value="1" class="form-check-input" id="pub" @checked(old('is_published',$p->is_published??true))><label for="pub" class="form-check-label">Publikasikan</label></div>
