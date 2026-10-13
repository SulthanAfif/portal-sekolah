<div class="struktur-photo-cropper mb-3" data-photo-cropper>
    <label class="form-label small fw-semibold">{{ $label }}</label>
    <input type="file" name="foto" class="form-control" accept="image/*" data-photo-file>
    <div class="struktur-photo-editor mt-3" data-photo-editor hidden>
        <div class="struktur-photo-viewport" data-photo-viewport role="img" aria-label="Pratinjau area foto yang akan disimpan">
            <img data-photo-image alt="Pratinjau foto yang dipilih" draggable="false">
            <span class="struktur-photo-grid" aria-hidden="true"></span>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2">
            <label class="form-label small mb-0">Zoom</label>
            <input type="range" class="form-range flex-grow-1 mb-0" min="1" max="3" step="0.01" value="1" aria-label="Atur zoom foto" data-photo-zoom>
            <output class="small text-nowrap" data-photo-zoom-value>1.00×</output>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" data-photo-recenter>Atur ulang posisi</button>
        <div class="small text-muted mt-2">Geser gambar di dalam kotak, lalu atur zoom. Bagian di dalam kotak rasio 4:3 yang akan disimpan.</div>
        <div class="small text-danger mt-1" role="status" data-photo-message aria-live="polite"></div>
    </div>
</div>
