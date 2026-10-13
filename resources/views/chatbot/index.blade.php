@extends('layouts.app')

@section('title', 'SekolahBot')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="card overflow-hidden" style="height: calc(100vh - 140px); min-height: 500px;">
            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                        <i class="bi bi-robot fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">SekolahBot</div>
                        <small class="opacity-75">Asisten Virtual Portal Sekolah</small>
                    </div>
                </div>
                <button id="btn-reset" class="btn btn-sm btn-light">
                    <i class="bi bi-arrow-clockwise"></i> <span class="d-none d-sm-inline">Mulai Baru</span>
                </button>
            </div>

            <!-- Chat Area -->
            <div class="card-body p-3 overflow-auto" id="chat-box" style="background: #f8fafc;">
                @forelse($history as $item)
                    @if($item['role'] === 'user')
                        <div class="d-flex justify-content-end mb-3">
                            <div class="bg-primary text-white rounded-3 px-3 py-2 shadow-sm" style="max-width: 85%;">
                                {{ $item['text'] }}
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-start mb-3 gap-2">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;">
                                <i class="bi bi-robot"></i>
                            </div>
                            <div class="bg-white border rounded-3 px-3 py-2 shadow-sm" style="max-width: 85%;">
                                {!! nl2br(e($item['text'])) !!}
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center text-muted py-5">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:64px;height:64px;">
                            <i class="bi bi-robot fs-2"></i>
                        </div>
                        <h6 class="fw-semibold">Halo! Saya SekolahBot</h6>
                        <p class="small mb-0">Tanyakan apa saja seputar sekolah.<br>Contoh: jadwal, nilai, pengumuman, kontak...</p>
                    </div>
                @endforelse
            </div>

            <!-- Input -->
            <div class="card-footer bg-white border-top p-3">
                <form id="chat-form" class="d-flex gap-2">
                    <input type="text" id="message" class="form-control form-control-lg border-0 bg-light"
                           placeholder="Ketik pertanyaan..." autocomplete="off" required
                           style="border-radius: 50px;">
                    <button type="submit" class="btn btn-primary btn-lg rounded-circle d-flex align-items-center justify-content-center"
                            id="btn-send" style="width:48px;height:48px;">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const chatBox = document.getElementById('chat-box');
const form = document.getElementById('chat-form');
const input = document.getElementById('message');
const btnSend = document.getElementById('btn-send');
const btnReset = document.getElementById('btn-reset');

chatBox.scrollTop = chatBox.scrollHeight;

form.addEventListener('submit', async function (e) {
    e.preventDefault();
    const message = input.value.trim();
    if (!message) return;

    appendMessage(message, 'user');
    input.value = '';
    btnSend.disabled = true;

    // Typing indicator
    const typing = document.createElement('div');
    typing.id = 'typing';
    typing.className = 'd-flex justify-content-start mb-3 gap-2';
    typing.innerHTML = `
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
            <i class="bi bi-robot"></i>
        </div>
        <div class="bg-white border rounded-3 px-3 py-2 shadow-sm">
            <span class="spinner-border spinner-border-sm text-primary"></span>
        </div>`;
    chatBox.appendChild(typing);
    chatBox.scrollTop = chatBox.scrollHeight;

    try {
        const res = await fetch("{{ route('chatbot.chat') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message })
        });
        const data = await res.json();
        document.getElementById('typing')?.remove();
        appendMessage(data.reply || 'Terjadi kesalahan.', 'bot');
    } catch {
        document.getElementById('typing')?.remove();
        appendMessage('Gagal terhubung ke server.', 'bot');
    }

    btnSend.disabled = false;
});

btnReset.addEventListener('click', async () => {
    if (!confirm('Yakin ingin menghapus percakapan?')) return;
    await fetch("{{ route('chatbot.reset') }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    chatBox.innerHTML = `
        <div class="text-center text-muted py-5">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:64px;height:64px;">
                <i class="bi bi-robot fs-2"></i>
            </div>
            <h6 class="fw-semibold">Halo! Saya SekolahBot</h6>
            <p class="small mb-0">Percakapan telah direset. Silakan tanyakan sesuatu.</p>
        </div>`;
});

function appendMessage(text, type) {
    const div = document.createElement('div');
    if (type === 'user') {
        div.className = 'd-flex justify-content-end mb-3';
        div.innerHTML = `<div class="bg-primary text-white rounded-3 px-3 py-2 shadow-sm" style="max-width:85%">${escapeHtml(text)}</div>`;
    } else {
        div.className = 'd-flex justify-content-start mb-3 gap-2';
        div.innerHTML = `
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;">
                <i class="bi bi-robot"></i>
            </div>
            <div class="bg-white border rounded-3 px-3 py-2 shadow-sm" style="max-width:85%">
                ${escapeHtml(text).replace(/\n/g, '<br>')}
            </div>`;
    }
    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}

function escapeHtml(text) {
    const d = document.createElement('div');
    d.textContent = text;
    return d.innerHTML;
}
</script>
@endpush
