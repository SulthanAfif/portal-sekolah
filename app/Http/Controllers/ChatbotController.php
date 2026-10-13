<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function index()
    {
        $history = session('chat_history', []);

        // Guest pakai halaman standalone; user login pakai layout app
        if (! auth()->check()) {
            return view('chatbot.public', compact('history'));
        }

        return view('chatbot.index', compact('history'));
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = trim($request->input('message'));
        $history = session('chat_history', []);

        // 1) Jawaban lokal (jadwal, absensi, dll) — selalu prioritas
        $local = $this->localReply($userMessage);

        if ($local !== null) {
            $reply = $local;
        } else {
            // 2) Gemini AI
            try {
                $reply = $this->askGemini($userMessage, $history);
            } catch (\Throwable $e) {
                Log::warning('Gemini Error: '.$e->getMessage());
                $reply = $this->fallbackReply($userMessage);
            }
        }

        $history[] = ['role' => 'user', 'text' => $userMessage];
        $history[] = ['role' => 'model', 'text' => $reply];
        if (count($history) > 20) {
            $history = array_slice($history, -20);
        }
        session(['chat_history' => $history]);

        return response()->json([
            'reply' => $reply,
            'timestamp' => now()->format('H:i'),
        ]);
    }

    public function reset()
    {
        session()->forget('chat_history');

        return response()->json(['message' => 'Percakapan telah direset.']);
    }

    private function localReply(string $message): ?string
    {
        $msg = mb_strtolower($message);
        $user = Auth::user();
        $school = config('school.nama', 'Sekolah');

        if (preg_match('/\b(halo|hai|hello|hi|selamat)\b/u', $msg) && mb_strlen($msg) < 40) {
            $name = $user?->name ?? 'teman';

            return "Halo, **{$name}**! 👋 Saya SekolahBot, asisten virtual {$school}.\n\n"
                ."Anda bisa bertanya tentang:\n"
                ."• Jadwal pelajaran\n"
                ."• Absensi WiFi\n"
                ."• Pengumuman\n"
                ."• Kontak sekolah\n"
                ."• Cara login / register\n\n"
                .'Silakan ketik pertanyaan Anda.';
        }

        if (preg_match('/jadwal|pelajaran|mapel|jam\s*berapa/u', $msg)) {
            return $this->replyJadwal($user, $msg);
        }

        if (preg_match('/absen|kehadiran|presensi|check.?in/u', $msg)) {
            $mulai = config('school.absensi.mulai', '06:00');
            $selesai = config('school.absensi.selesai', '08:00');

            return "📋 **Absensi Sekolah**\n\n"
                ."• Siswa absen mandiri di menu **Absensi**.\n"
                ."• Wajib terhubung **WiFi sekolah**.\n"
                ."• Jam absensi: **{$mulai} – {$selesai}**.\n"
                .'• Guru dapat mengisi absensi manual per kelas.';
        }

        if (preg_match('/pengumuman|berita/u', $msg)) {
            $items = Pengumuman::where('is_published', true)->latest('published_at')->take(5)->get();
            if ($items->isEmpty()) {
                return 'Saat ini belum ada pengumuman terbaru. Cek menu **Pengumuman**.';
            }
            $lines = ["📢 **Pengumuman terbaru:**\n"];
            foreach ($items as $i => $p) {
                $tgl = optional($p->published_at)->format('d M Y') ?? '-';
                $lines[] = ($i + 1).". **{$p->judul}** ({$tgl})";
            }

            return implode("\n", $lines);
        }

        if (preg_match('/kontak|alamat|telepon|telp|email|hubungi|lokasi/u', $msg)) {
            return "🏫 **Kontak {$school}**\n\n"
                .'📍 '.config('school.alamat')."\n"
                .'📞 '.config('school.telepon')."\n"
                .'✉️ '.config('school.email')."\n"
                .'🕐 '.config('school.jam_operasional');
        }

        if (preg_match('/nilai|rapor|raport|uts|uas/u', $msg)) {
            return '📊 Nilai dikelola guru/admin. Cek menu akademik atau hubungi wali kelas.';
        }

        if (preg_match('/login|daftar|register|akun|password|masuk/u', $msg)) {
            return "🔐 **Login & Registrasi**\n\n"
                ."• Register hanya email domain sekolah (`@sekolah.sch.id`, `@siswa.sch.id`).\n"
                ."• Pilih peran **Siswa** atau **Guru**.\n"
                .'• Admin/TU dibuatkan oleh administrator.';
        }

        if (preg_match('/wifi|wi-fi|jaringan/u', $msg)) {
            return '📶 Absensi mandiri hanya aktif jika perangkat terhubung ke **WiFi sekolah**. Hubungi TU jika kesulitan.';
        }

        if (preg_match('/bantuan|help|fitur|menu|apa yang bisa/u', $msg)) {
            return "Saya bisa bantu:\n1. Jadwal\n2. Absensi\n3. Pengumuman\n4. Kontak\n5. Login/register\n\nContoh: `jadwal hari ini`";
        }

        return null;
    }

    private function replyJadwal($user, string $msg): string
    {
        $hariMap = [
            'senin' => 'Senin', 'selasa' => 'Selasa', 'rabu' => 'Rabu',
            'kamis' => 'Kamis', 'jumat' => 'Jumat', 'sabtu' => 'Sabtu',
        ];

        $hari = null;
        foreach ($hariMap as $key => $label) {
            if (str_contains($msg, $key)) {
                $hari = $label;
                break;
            }
        }

        if (! $hari) {
            $phpDay = now()->locale('id')->isoFormat('dddd');
            $hari = $hariMap[mb_strtolower($phpDay)] ?? 'Senin';
            if (str_contains($msg, 'besok')) {
                $phpDay = now()->addDay()->locale('id')->isoFormat('dddd');
                $hari = $hariMap[mb_strtolower($phpDay)] ?? $hari;
            }
        }

        $query = Jadwal::with(['mapel', 'guru', 'kelas'])->where('hari', $hari)->orderBy('jam_mulai');

        if ($user?->role === 'siswa' && $user->kelas_id) {
            $query->where('kelas_id', $user->kelas_id);
        } elseif ($user?->role === 'guru') {
            $query->where('guru_id', $user->id);
        }

        $rows = $query->get();

        if ($rows->isEmpty()) {
            return "📅 Tidak ada jadwal untuk **{$hari}**.\nCoba: `jadwal senin` atau buka menu **Jadwal**.";
        }

        $lines = ["📅 **Jadwal {$hari}:**\n"];
        foreach ($rows as $j) {
            $mulai = substr((string) $j->jam_mulai, 0, 5);
            $selesai = substr((string) $j->jam_selesai, 0, 5);
            $mapel = $j->mapel->nama ?? '-';
            $guru = $j->guru->name ?? '-';
            $ruang = $j->ruangan ?: '-';
            $kelas = $j->kelas->nama ?? '';
            $lines[] = "• **{$mulai}–{$selesai}** {$mapel}".($kelas ? " ({$kelas})" : '')." — {$guru}, ruang {$ruang}";
        }

        return implode("\n", $lines);
    }

    private function fallbackReply(string $message): string
    {
        return "Maaf, saya belum menemukan jawaban spesifik.\n\n"
            ."Coba tanyakan:\n"
            ."• `jadwal hari ini`\n"
            ."• `absensi`\n"
            ."• `pengumuman`\n"
            ."• `kontak sekolah`\n"
            .'• `cara login`';
    }

    /**
     * Panggil Gemini API sesuai dokumentasi resmi:
     * https://ai.google.dev/gemini-api/docs/generate-content/api-key
     * Auth: header x-goog-api-key
     */
    private function askGemini(string $userMessage, array $history = []): string
    {
        $apiKey = trim((string) (config('services.gemini.key') ?: env('GEMINI_API_KEY')));
        $model = trim((string) (config('services.gemini.model') ?: env('GEMINI_MODEL', 'gemini-2.0-flash')));

        if ($apiKey === '') {
            throw new \RuntimeException('GEMINI_API_KEY belum di-set di file .env');
        }

        $school = config('school.nama', 'Sekolah');
        $systemInstruction = "Kamu adalah SekolahBot, asisten virtual portal {$school}. "
            .'Jawab singkat, ramah, bahasa Indonesia. Fokus info sekolah. '
            .'Jika tidak tahu, arahkan ke menu portal atau TU.';

        $contents = [];
        foreach ($history as $item) {
            $contents[] = [
                'role' => ($item['role'] ?? '') === 'model' ? 'model' : 'user',
                'parts' => [['text' => $item['text'] ?? '']],
            ];
        }
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $systemInstruction]],
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.6,
                'maxOutputTokens' => 500,
            ],
        ];

        $modelsToTry = array_values(array_unique([
            $model,
            'gemini-2.0-flash',
            'gemini-flash-latest',
            'gemini-2.5-flash',
            'gemini-1.5-flash',
        ]));

        $lastError = null;

        foreach ($modelsToTry as $tryModel) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$tryModel}:generateContent";

            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'x-goog-api-key' => $apiKey, // cara resmi 2026
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($text) {
                    return $text;
                }
                $lastError = 'Respons kosong dari '.$tryModel;
                continue;
            }

            $lastError = "[{$response->status()}] {$tryModel}: ".$response->body();
            Log::warning('Gemini try failed', ['model' => $tryModel, 'status' => $response->status(), 'body' => $response->body()]);

            // 403/401 = key problem, stop early
            if (in_array($response->status(), [401, 403], true)) {
                break;
            }
        }

        throw new \RuntimeException('Gemini gagal: '.$lastError);
    }
}
