@php $g = $guru ?? null; @endphp
<div class="row g-3">
<div class="col-md-6"><label class="form-label small fw-semibold">Nama</label><input name="name" class="form-control" value="{{ old('name',$g->name??'') }}" required></div>
<div class="col-md-6"><label class="form-label small fw-semibold">Email</label><input type="email" name="email" class="form-control" value="{{ old('email',$g->email??'') }}" required></div>
<div class="col-md-6"><label class="form-label small fw-semibold">Password {{ $g?'(opsional)':'' }}</label><input type="password" name="password" class="form-control" {{ $g?'':'required' }}></div>
<div class="col-md-6"><label class="form-label small fw-semibold">NIP</label><input name="nis_nip" class="form-control" value="{{ old('nis_nip',$g->nis_nip??'') }}"></div>
<div class="col-md-6"><label class="form-label small fw-semibold">No. HP</label><input name="no_hp" class="form-control" value="{{ old('no_hp',$g->no_hp??'') }}"></div>
<div class="col-12"><div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="act" @checked(old('is_active',$g->is_active??true))><label for="act" class="form-check-label">Aktif</label></div></div>
</div>
