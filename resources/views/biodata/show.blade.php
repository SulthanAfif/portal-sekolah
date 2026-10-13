@extends('layouts.app')

@section('title', 'Biodata Siswa')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4 animate-fade-up">
    <div>
        <h4 class="page-title mb-1">
            @if($isFirstVisit)
                Lengkapi / Periksa Biodata Anda
            @else
                Biodata Saya
            @endif
        </h4>
        <p class="text-muted mb-0">
            @if($isFirstVisit)
                Sebelum masuk ke dashboard, pastikan data diri Anda sudah benar.
            @else
                Data profil siswa yang terdaftar di portal sekolah.
            @endif
        </p>
    </div>
    <div class="d-flex gap-2">
        <button type="button" id="btnEditBiodata" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i> Edit Biodata
        </button>
        <button type="button" id="btnBatalEdit" class="btn btn-outline-secondary d-none">
            <i class="bi bi-x-lg me-1"></i> Batal
        </button>
    </div>
</div>

@if(session('status') === 'biodata-updated')
    <div class="alert alert-success border-0 shadow-sm animate-fade-up">
        <i class="bi bi-check-circle me-2"></i>Biodata berhasil diperbarui.
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger border-0 shadow-sm animate-fade-up">
        <i class="bi bi-exclamation-triangle me-2"></i>
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

@if($isFirstVisit)
<div class="alert alert-primary border-0 shadow-sm d-flex align-items-start gap-3 mb-4 animate-fade-up">
    <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;">
        <i class="bi bi-person-vcard fs-5"></i>
    </div>
    <div>
        <div class="fw-semibold">Langkah 1 dari 2 — Verifikasi Biodata</div>
        <div class="small">Periksa data di bawah. Klik <strong>Edit Biodata</strong> jika ada yang perlu diubah, lalu klik <strong>Lanjut ke Dashboard</strong>.</div>
    </div>
</div>
@endif

<div class="row g-4">
    <!-- Kartu identitas -->
    <div class="col-lg-4 animate-fade-up animate-delay-1">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center text-white fw-bold"
                     style="width:88px;height:88px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#1d4ed8);font-size:2rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1" id="displayName">{{ $user->name }}</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary mb-3">Siswa</span>

                <div class="text-start small">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">NIS</span>
                        <strong>{{ $user->nis_nip ?? '—' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Kelas</span>
                        <strong>{{ $user->kelas?->nama ?? '—' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Tingkat</span>
                        <strong>{{ $user->kelas?->tingkat ?? '—' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Jurusan</span>
                        <strong>{{ $user->kelas?->jurusan ?? '—' }}</strong>
                    </div>
                </div>

                <button type="button" id="btnEditBiodataMobile" class="btn btn-outline-primary btn-sm w-100 mt-3 d-lg-none">
                    <i class="bi bi-pencil-square me-1"></i> Edit Biodata
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-8 animate-fade-up animate-delay-2">
        <!-- MODE LIHAT (default) -->
        <div id="viewMode" class="card mb-4 {{ $errors->any() ? 'd-none' : '' }}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-person-lines-fill me-2 text-primary"></i>Detail Biodata</span>
                <button type="button" class="btn btn-sm btn-primary btn-edit-trigger">
                    <i class="bi bi-pencil me-1"></i> Edit
                </button>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Nama Lengkap</div>
                        <div class="fw-semibold">{{ $user->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Email</div>
                        <div class="fw-semibold">{{ $user->email }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">No. HP / WhatsApp</div>
                        <div class="fw-semibold">{{ $user->no_hp ?: '—' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">NIS</div>
                        <div class="fw-semibold">{{ $user->nis_nip ?? '—' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Kelas</div>
                        <div class="fw-semibold">{{ $user->kelas?->nama ?? '—' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Status Akun</div>
                        <div>
                            @if($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODE EDIT -->
        <div id="editMode" class="card mb-4 {{ $errors->any() ? '' : 'd-none' }}">
            <div class="card-header d-flex justify-content-between align-items-center" style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;">
                <span><i class="bi bi-pencil-square me-2"></i>Edit Biodata</span>
                <button type="button" class="btn btn-sm btn-light btn-cancel-edit">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('biodata.update') }}" id="formBiodata">
                    @csrf
                    @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                   value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxxxxxxxx">
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">NIS <span class="text-muted">(tidak dapat diubah)</span></label>
                            <input type="text" class="form-control bg-light" value="{{ $user->nis_nip }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Kelas <span class="text-muted">(tidak dapat diubah)</span></label>
                            <input type="text" class="form-control bg-light" value="{{ $user->kelas?->nama ?? '—' }}" disabled>
                        </div>
                    </div>

                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-cancel-edit">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lanjut ke Dashboard -->
        <div class="card border-primary border-opacity-25" style="background: rgba(37,99,235,0.06);">
            <div class="card-body d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                <div>
                    <div class="fw-semibold text-primary">
                        @if($isFirstVisit)
                            Data sudah benar?
                        @else
                            Siap masuk portal?
                        @endif
                    </div>
                    <small class="text-muted">Lanjutkan ke dashboard untuk melihat jadwal, absensi, dan pengumuman.</small>
                </div>
                <form method="POST" action="{{ route('biodata.continue') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        Lanjut ke Dashboard
                        <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const viewMode = document.getElementById('viewMode');
    const editMode = document.getElementById('editMode');
    const btnEdit = document.getElementById('btnEditBiodata');
    const btnEditMobile = document.getElementById('btnEditBiodataMobile');
    const btnBatal = document.getElementById('btnBatalEdit');

    function showEdit() {
        viewMode.classList.add('d-none');
        editMode.classList.remove('d-none');
        btnEdit?.classList.add('d-none');
        btnBatal?.classList.remove('d-none');
        editMode.scrollIntoView({ behavior: 'smooth', block: 'start' });
        const firstInput = editMode.querySelector('input[name="name"]');
        if (firstInput) firstInput.focus();
    }

    function showView() {
        editMode.classList.add('d-none');
        viewMode.classList.remove('d-none');
        btnEdit?.classList.remove('d-none');
        btnBatal?.classList.add('d-none');
    }

    btnEdit?.addEventListener('click', showEdit);
    btnEditMobile?.addEventListener('click', showEdit);
    btnBatal?.addEventListener('click', showView);
    document.querySelectorAll('.btn-edit-trigger').forEach(el => el.addEventListener('click', showEdit));
    document.querySelectorAll('.btn-cancel-edit').forEach(el => el.addEventListener('click', showView));
})();
</script>
@endpush
