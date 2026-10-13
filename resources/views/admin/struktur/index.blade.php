@extends('layouts.app')
@section('title','Struktur Sekolah')
@section('content')
@push('styles')
<style>
    .struktur-photo-editor[hidden] { display: none; }
    .struktur-photo-viewport {
        position: relative;
        width: 100%;
        max-width: 420px;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: #0b1220;
        cursor: grab;
        touch-action: none;
        user-select: none;
    }
    .struktur-photo-viewport.is-dragging { cursor: grabbing; }
    .struktur-photo-viewport img {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        max-width: none;
        pointer-events: none;
        -webkit-user-drag: none;
    }
    .struktur-photo-grid {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image:
            linear-gradient(to right, transparent 33.2%, rgba(255,255,255,.28) 33.4%, rgba(255,255,255,.28) 33.6%, transparent 33.8%, transparent 66.2%, rgba(255,255,255,.28) 66.4%, rgba(255,255,255,.28) 66.6%, transparent 66.8%),
            linear-gradient(to bottom, transparent 33.2%, rgba(255,255,255,.28) 33.4%, rgba(255,255,255,.28) 33.6%, transparent 33.8%, transparent 66.2%, rgba(255,255,255,.28) 66.4%, rgba(255,255,255,.28) 66.6%, transparent 66.8%);
    }
</style>
@endpush
<h4 class="page-title mb-1">Kelola Struktur Organisasi</h4>
<p class="text-muted mb-4">Tambah pejabat + foto untuk diagram di beranda</p>
@if(session('success'))<div class="alert alert-success border-0">{{ session('success') }}</div>@endif
<div class="row g-4">
<div class="col-lg-4">
<div class="card"><div class="card-header">Tambah Anggota</div><div class="card-body">
<form method="POST" action="{{ route('admin.struktur.store') }}" enctype="multipart/form-data">@csrf
<div class="mb-2"><label class="form-label small fw-semibold">Jabatan</label>
<input name="jabatan" class="form-control" placeholder="Kepala Sekolah" required></div>
<div class="mb-2"><label class="form-label small fw-semibold">Nama</label>
<input name="nama" class="form-control" required></div>
<div class="mb-2"><label class="form-label small fw-semibold">NIP/ID Pendidik</label>
<input name="nip" class="form-control" maxlength="50"></div>
<div class="mb-2"><label class="form-label small fw-semibold">Status</label>
<select name="is_active" class="form-select" required>
<option value="1" selected>Aktif</option>
<option value="0">Nonaktif</option>
</select></div>
@include('admin.struktur._photo-cropper', ['label' => 'Foto'])
<button class="btn btn-primary w-100">Simpan</button>
</form></div></div>
</div>
<div class="col-lg-8">
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0 align-middle">
<thead><tr><th class="ps-3">Foto</th><th>Jabatan</th><th>Nama</th><th>NIP/ID Pendidik</th><th>Status</th><th></th></tr></thead>
<tbody>
@forelse($items as $item)
<tr>
<td class="ps-3"><img src="{{ $item->fotoUrl() }}" alt="Foto {{ $item->nama }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;" loading="lazy" decoding="async"></td>
<td class="fw-semibold">{{ $item->jabatan }}</td>
<td>{{ $item->nama }}</td>
<td>{{ $item->nip ?: '—' }}</td>
<td>@if($item->is_active)<span class="badge bg-success">Aktif</span>@else<span class="badge bg-secondary">Nonaktif</span>@endif</td>
<td class="text-end pe-3">
<div class="table-actions">
<details class="d-inline-block text-start">
<summary class="btn btn-sm btn-outline-primary">Edit</summary>
<form action="{{ route('admin.struktur.update', $item) }}" method="POST" enctype="multipart/form-data" class="card card-body mt-2" style="min-width:260px;">
@csrf @method('PATCH')
<label class="form-label small fw-semibold">Jabatan</label>
<input name="jabatan" class="form-control mb-2" value="{{ $item->jabatan }}" required>
<label class="form-label small fw-semibold">Nama</label>
<input name="nama" class="form-control mb-2" value="{{ $item->nama }}" required>
<label class="form-label small fw-semibold">NIP/ID Pendidik</label>
<input name="nip" class="form-control mb-2" maxlength="50" value="{{ $item->nip }}">
<label class="form-label small fw-semibold">Status</label>
<select name="is_active" class="form-select mb-2" required>
<option value="1" @selected($item->is_active)>Aktif</option>
<option value="0" @selected(! $item->is_active)>Nonaktif</option>
</select>
@include('admin.struktur._photo-cropper', ['label' => 'Foto baru (opsional)'])
<button class="btn btn-sm btn-primary">Simpan Perubahan</button>
</form>
</details>
<form action="{{ route('admin.struktur.destroy',$item) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</div>
</td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data — tambah Kepala Sekolah dulu</td></tr>@endforelse
</tbody></table></div></div>
</div>
</div>
@endsection
@push('scripts')
<script>
    document.querySelectorAll('[data-photo-cropper]').forEach((cropper) => {
        const input = cropper.querySelector('[data-photo-file]');
        const editor = cropper.querySelector('[data-photo-editor]');
        const viewport = cropper.querySelector('[data-photo-viewport]');
        const image = cropper.querySelector('[data-photo-image]');
        const zoom = cropper.querySelector('[data-photo-zoom]');
        const zoomValue = cropper.querySelector('[data-photo-zoom-value]');
        const recenter = cropper.querySelector('[data-photo-recenter]');
        const message = cropper.querySelector('[data-photo-message]');
        const form = cropper.closest('form');
        let imageUrl = null;
        let zoomLevel = 1;
        let imageLeft = 0;
        let imageTop = 0;
        let scaledWidth = 0;
        let scaledHeight = 0;
        let pointer = null;
        let processing = false;

        const clampPosition = () => {
            const bounds = viewport.getBoundingClientRect();
            imageLeft = Math.min(0, Math.max(bounds.width - scaledWidth, imageLeft));
            imageTop = Math.min(0, Math.max(bounds.height - scaledHeight, imageTop));
            image.style.width = `${scaledWidth}px`;
            image.style.height = `${scaledHeight}px`;
            image.style.left = `${imageLeft}px`;
            image.style.top = `${imageTop}px`;
        };

        const renderCrop = (keepCenter = true) => {
            const bounds = viewport.getBoundingClientRect();
            if (!image.naturalWidth || !bounds.width || !bounds.height) {
                return;
            }

            const previousWidth = scaledWidth;
            const previousHeight = scaledHeight;
            const focusX = keepCenter && previousWidth
                ? (bounds.width / 2 - imageLeft) / previousWidth
                : 0.5;
            const focusY = keepCenter && previousHeight
                ? (bounds.height / 2 - imageTop) / previousHeight
                : 0.5;
            const fitScale = Math.max(bounds.width / image.naturalWidth, bounds.height / image.naturalHeight);

            scaledWidth = image.naturalWidth * fitScale * zoomLevel;
            scaledHeight = image.naturalHeight * fitScale * zoomLevel;
            imageLeft = bounds.width / 2 - focusX * scaledWidth;
            imageTop = bounds.height / 2 - focusY * scaledHeight;
            clampPosition();
        };

        input.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file) {
                editor.hidden = true;
                message.textContent = '';
                return;
            }

            if (imageUrl) {
                URL.revokeObjectURL(imageUrl);
            }

            imageUrl = URL.createObjectURL(file);
            image.onload = () => {
                zoomLevel = 1;
                zoom.value = '1';
                zoomValue.value = '1.00×';
                editor.hidden = false;
                renderCrop(false);
                message.textContent = 'Geser gambar di dalam kotak untuk memilih bagian foto.';
            };
            image.onerror = () => {
                editor.hidden = true;
                message.textContent = 'Gambar tidak dapat dibuka. Silakan pilih file gambar lain.';
            };
            image.src = imageUrl;
        });

        zoom.addEventListener('input', () => {
            zoomLevel = Number(zoom.value);
            zoomValue.value = `${zoomLevel.toFixed(2)}×`;
            renderCrop();
        });

        recenter.addEventListener('click', () => {
            imageLeft = 0;
            imageTop = 0;
            renderCrop(false);
        });

        viewport.addEventListener('pointerdown', (event) => {
            if (!image.naturalWidth) {
                return;
            }
            pointer = { id: event.pointerId, x: event.clientX, y: event.clientY };
            viewport.setPointerCapture(event.pointerId);
            viewport.classList.add('is-dragging');
        });

        viewport.addEventListener('pointermove', (event) => {
            if (!pointer || pointer.id !== event.pointerId) {
                return;
            }
            imageLeft += event.clientX - pointer.x;
            imageTop += event.clientY - pointer.y;
            pointer.x = event.clientX;
            pointer.y = event.clientY;
            clampPosition();
        });

        const stopDragging = () => {
            pointer = null;
            viewport.classList.remove('is-dragging');
        };

        viewport.addEventListener('pointerup', stopDragging);
        viewport.addEventListener('pointercancel', stopDragging);
        window.addEventListener('resize', () => renderCrop());

        form.addEventListener('submit', async (event) => {
            if (processing || !input.files?.[0] || editor.hidden) {
                return;
            }

            event.preventDefault();
            const submitButton = event.submitter;
            const bounds = viewport.getBoundingClientRect();
            const sourceScale = scaledWidth / image.naturalWidth;
            const sourceX = Math.max(0, -imageLeft / sourceScale);
            const sourceY = Math.max(0, -imageTop / sourceScale);
            const sourceWidth = Math.min(bounds.width / sourceScale, image.naturalWidth - sourceX);
            const sourceHeight = Math.min(bounds.height / sourceScale, image.naturalHeight - sourceY);
            const canvas = document.createElement('canvas');
            canvas.width = 1200;
            canvas.height = 900;
            const context = canvas.getContext('2d');

            if (!context) {
                message.textContent = 'Pemotongan gambar gagal. Silakan muat ulang halaman dan coba lagi.';
                return;
            }

            context.drawImage(image, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, canvas.width, canvas.height);
            message.textContent = 'Menyiapkan foto...';
            if (submitButton) {
                submitButton.disabled = true;
            }

            try {
                const blob = await new Promise((resolve, reject) => {
                    canvas.toBlob((result) => {
                        if (result) {
                            resolve(result);
                        } else {
                            reject(new Error('Foto gagal diproses.'));
                        }
                    }, 'image/jpeg', 0.9);
                });
                const croppedFile = new File(
                    [blob],
                    `${input.files[0].name.replace(/\.[^.]+$/, '')}-crop.jpg`,
                    { type: 'image/jpeg' }
                );
                const transfer = new DataTransfer();
                transfer.items.add(croppedFile);
                input.files = transfer.files;

                processing = true;
                form.requestSubmit(submitButton ?? undefined);
            } catch (error) {
                message.textContent = 'Foto gagal diproses. Silakan coba pilih gambar lain.';
                if (submitButton) {
                    submitButton.disabled = false;
                }
            }
        });
    });
</script>
@endpush
