<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SekolahBot — Portal Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh;
            background: #0b1220;
            color: #f1f5f9;
            display: flex; flex-direction: column;
        }
        .top {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0.85rem 1.25rem;
            background: rgba(15,23,42,0.9);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .brand { display: flex; align-items: center; gap: 0.65rem; font-weight: 700; }
        .brand-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg,#6366f1,#4f46e5);
            display: flex; align-items: center; justify-content: center; color: #fff;
        }
        .chat-wrap {
            flex: 1; max-width: 720px; width: 100%; margin: 0 auto;
            display: flex; flex-direction: column;
            padding: 1rem; min-height: 0;
        }
        .chat-box {
            flex: 1; overflow-y: auto; padding: 1rem 0.25rem;
            display: flex; flex-direction: column; gap: 0.75rem;
        }
        .bubble-user {
            align-self: flex-end; max-width: 85%;
            background: linear-gradient(135deg,#6366f1,#4f46e5);
            color: #fff; border-radius: 16px 16px 4px 16px;
            padding: 0.7rem 1rem; font-size: 0.925rem;
        }
        .bubble-bot {
            align-self: flex-start; max-width: 85%;
            background: #151c2e; border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px 16px 16px 4px;
            padding: 0.7rem 1rem; font-size: 0.925rem; color: #e2e8f0;
        }
        .bot-row { display: flex; gap: 0.5rem; align-items: flex-start; }
        .bot-av {
            width: 32px; height: 32px; border-radius: 50%;
            background: rgba(99,102,241,0.25); color: #a5b4fc;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .input-bar {
            display: flex; gap: 0.5rem; padding: 0.75rem;
            background: #151c2e; border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; margin-top: 0.5rem;
        }
        .input-bar input {
            flex: 1; background: transparent; border: none; outline: none;
            color: #f1f5f9; font-size: 0.95rem;
        }
        .input-bar input::placeholder { color: #64748b; }
        .input-bar button {
            width: 42px; height: 42px; border: none; border-radius: 12px;
            background: linear-gradient(135deg,#6366f1,#4f46e5); color: #fff;
            display: flex; align-items: center; justify-content: center;
        }
        .btn-ghost {
            background: transparent; border: 1px solid rgba(255,255,255,0.12);
            color: #94a3b8; border-radius: 10px; padding: 0.35rem 0.75rem;
            font-size: 0.85rem; text-decoration: none;
        }
        .btn-ghost:hover { color: #fff; border-color: rgba(255,255,255,0.25); }
        .welcome { text-align: center; padding: 2.5rem 1rem; color: #94a3b8; }
        .welcome .icon {
            width: 64px; height: 64px; border-radius: 50%; margin: 0 auto 1rem;
            background: rgba(99,102,241,0.2); color: #a5b4fc;
            display: flex; align-items: center; justify-content: center; font-size: 1.75rem;
        }
        .typing { color: #94a3b8; font-size: 0.85rem; padding-left: 2.5rem; }
    </style>
</head>
<body>
<div class="top">
    <div class="brand">
        <div class="brand-icon"><i class="bi bi-robot"></i></div>
        <div>
            <div style="font-size:0.95rem;">SekolahBot</div>
            <div style="font-size:0.7rem;color:#94a3b8;font-weight:500;">Asisten Virtual Portal Sekolah</div>
        </div>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <button type="button" id="btn-reset" class="btn-ghost"><i class="bi bi-arrow-clockwise"></i> Baru</button>
        <a href="{{ url('/') }}" class="btn-ghost"><i class="bi bi-house"></i></a>
        <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
    </div>
</div>

<div class="chat-wrap">
    <div class="chat-box" id="chat-box">
        @forelse($history as $item)
            @if($item['role'] === 'user')
                <div class="bubble-user">{{ $item['text'] }}</div>
            @else
                <div class="bot-row">
                    <div class="bot-av"><i class="bi bi-robot"></i></div>
                    <div class="bubble-bot">{!! nl2br(e($item['text'])) !!}</div>
                </div>
            @endif
        @empty
            <div class="welcome" id="welcome">
                <div class="icon"><i class="bi bi-robot"></i></div>
                <h6 class="text-white fw-semibold mb-1">Halo! Saya SekolahBot</h6>
                <p class="small mb-0">Tanyakan seputar sekolah.<br>Contoh: jadwal, absensi, pengumuman, kontak...</p>
            </div>
        @endforelse
    </div>
    <form id="chat-form" class="input-bar" autocomplete="off">
        <input type="text" id="message" placeholder="Ketik pertanyaan..." required maxlength="1000">
        <button type="submit"><i class="bi bi-send-fill"></i></button>
    </form>
</div>

<script>
const box = document.getElementById('chat-box');
const form = document.getElementById('chat-form');
const input = document.getElementById('message');
const csrf = document.querySelector('meta[name="csrf-token"]').content;

function scrollBottom() { box.scrollTop = box.scrollHeight; }

function addUser(text) {
    const w = document.getElementById('welcome');
    if (w) w.remove();
    const d = document.createElement('div');
    d.className = 'bubble-user';
    d.textContent = text;
    box.appendChild(d);
    scrollBottom();
}

function addBot(text) {
    const row = document.createElement('div');
    row.className = 'bot-row';
    row.innerHTML = '<div class="bot-av"><i class="bi bi-robot"></i></div><div class="bubble-bot"></div>';
    row.querySelector('.bubble-bot').innerHTML = text.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    box.appendChild(row);
    scrollBottom();
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const text = input.value.trim();
    if (!text) return;
    input.value = '';
    addUser(text);
    const typing = document.createElement('div');
    typing.className = 'typing';
    typing.id = 'typing';
    typing.textContent = 'SekolahBot mengetik...';
    box.appendChild(typing);
    scrollBottom();
    try {
        const res = await fetch("{{ route('chatbot.chat') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: JSON.stringify({ message: text }),
        });
        const data = await res.json();
        document.getElementById('typing')?.remove();
        addBot(data.reply || 'Maaf, tidak ada jawaban.');
    } catch (err) {
        document.getElementById('typing')?.remove();
        addBot('Maaf, terjadi gangguan. Coba lagi.');
    }
});

document.getElementById('btn-reset')?.addEventListener('click', async () => {
    await fetch("{{ route('chatbot.reset') }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf },
    });
    location.reload();
});
</script>
</body>
</html>
