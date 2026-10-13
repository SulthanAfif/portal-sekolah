@php $s = $siswa ?? null; @endphp
<div class="row g-3">
<div class="col-md-6"><label class="form-label small fw-semibold">Nama</label><input name="name" class="form-control" value="{{ old('name',$s->name??'') }}" required></div>
<div class="col-md-6"><label class="form-label small fw-semibold">Email</label><input type="email" name="email" class="form-control" value="{{ old('email',$s->email??'') }}" required></div>
<div class="col-md-6"><label class="form-label small fw-semibold">Password {{ $s ? '(kosongkan jika tidak diubah)' : '' }}</label><input type="password" name="password" class="form-control" {{ $s?'':'required' }}></div>
<div class="col-md-6"><label class="form-label small fw-semibold">NIS</label><input name="nis_nip" class="form-control" value="{{ old('nis_nip',$s->nis_nip??'') }}"></div>
<div class="col-md-6"><label class="form-label small fw-semibold">No. HP</label><input name="no_hp" class="form-control" value="{{ old('no_hp',$s->no_hp??'') }}"></div>
<div class="col-md-6"><label class="form-label small fw-semibold">Kelas</label>
<select name="kelas_id" class="form-select"><option value="">—</option>
@foreach($kelasList as $k)<option value="{{ $k->id }}" @selected(old('kelas_id',$s->kelas_id??'')==$k->id)>{{ $k->nama }}</option>@endforeach
</select></div>
<div class="col-12"><div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="act" @checked(old('is_active',$s->is_active??true))><label for="act" class="form-check-label">Aktif</label></div></div>
</div>
