<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Halaman absensi (berbeda per role)
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isSiswa()) {
            return $this->siswaAbsensi();
        }

        if ($user->isGuru() || $user->isAdmin()) {
            return $this->guruAbsensi($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman absensi.');
    }

    /**
     * Siswa: halaman self check-in (WAJIB WiFi sekolah)
     */
    private function siswaAbsensi()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $absensiHariIni = Absensi::where('siswa_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        $absensiBulanIni = Absensi::where('siswa_id', $user->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->orderByDesc('tanggal')
            ->get();

        $jamMulai   = config('school.absensi.mulai', '06:00');
        $jamSelesai = config('school.absensi.selesai', '08:00');
        $sekarang   = now()->format('H:i');
        $dalamJamAbsen = $sekarang >= $jamMulai && $sekarang <= $jamSelesai;

        return view('absensi.siswa', compact(
            'absensiHariIni',
            'absensiBulanIni',
            'jamMulai',
            'jamSelesai',
            'dalamJamAbsen'
        ));
    }

    /**
     * Guru/Admin: daftar absensi per kelas
     */
    private function guruAbsensi(Request $request)
    {
        $user = Auth::user();
        $tanggal = $request->get('tanggal', now()->toDateString());
        $kelasId = $request->get('kelas_id');

        // Kelas yang bisa dilihat guru (wali kelas atau semua jika admin)
        if ($user->isAdmin()) {
            $kelasList = Kelas::orderBy('nama')->get();
        } else {
            $kelasList = Kelas::where('wali_kelas_id', $user->id)->orderBy('nama')->get();
            // Juga kelas yang dia ajar (opsional: dari jadwal)
            if ($kelasList->isEmpty()) {
                $kelasList = Kelas::orderBy('nama')->get();
            }
        }

        $kelas = $kelasId
            ? Kelas::find($kelasId)
            : $kelasList->first();

        $siswa = collect();
        $absensiMap = collect();

        if ($kelas) {
            $siswa = User::where('role', 'siswa')
                ->where('kelas_id', $kelas->id)
                ->orderBy('name')
                ->get();

            $absensiMap = Absensi::where('kelas_id', $kelas->id)
                ->whereDate('tanggal', $tanggal)
                ->get()
                ->keyBy('siswa_id');
        }

        return view('absensi.guru', compact(
            'kelasList',
            'kelas',
            'siswa',
            'absensiMap',
            'tanggal'
        ));
    }

    /**
     * Siswa self check-in — HANYA lewat WiFi sekolah (middleware school.wifi)
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();

        if (! $user->isSiswa()) {
            return back()->with('error', 'Hanya siswa yang dapat melakukan absensi mandiri.');
        }

        if (! $user->kelas_id) {
            return back()->with('error', 'Akun Anda belum terhubung ke kelas. Hubungi admin.');
        }

        $jamMulai   = config('school.absensi.mulai', '06:00');
        $jamSelesai = config('school.absensi.selesai', '08:00');
        $sekarang   = now()->format('H:i');

        if ($sekarang < $jamMulai || $sekarang > $jamSelesai) {
            return back()->with('error', "Absensi hanya dapat dilakukan pukul {$jamMulai} – {$jamSelesai}.");
        }

        $today = now()->toDateString();

        $existing = Absensi::where('siswa_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah melakukan absensi hari ini ('.$existing->status.').');
        }

        Absensi::create([
            'siswa_id'     => $user->id,
            'kelas_id'     => $user->kelas_id,
            'tanggal'      => $today,
            'status'       => 'hadir',
            'keterangan'   => 'Self check-in via WiFi Sekolah',
            'dicatat_oleh' => $user->id,
            'ip_address'   => $request->ip(),
            'metode'       => 'self',
            'waktu_absen'  => now(),
        ]);

        return back()->with('success', 'Absensi berhasil! Anda tercatat hadir pada '.now()->format('H:i').'.');
    }

    /**
     * Guru/Admin: input/update absensi manual
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (! $user->isGuru() && ! $user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'siswa_id'    => 'required|exists:users,id',
            'kelas_id'    => 'required|exists:kelas,id',
            'tanggal'     => 'required|date',
            'status'      => 'required|in:hadir,izin,sakit,alpha',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        Absensi::updateOrCreate(
            [
                'siswa_id' => $request->siswa_id,
                'tanggal'  => $request->tanggal,
            ],
            [
                'kelas_id'     => $request->kelas_id,
                'status'       => $request->status,
                'keterangan'   => $request->keterangan,
                'dicatat_oleh' => $user->id,
                'ip_address'   => $request->ip(),
                'metode'       => 'manual',
                'waktu_absen'  => now(),
            ]
        );

        return back()->with('success', 'Absensi berhasil disimpan.');
    }

    /**
     * Bulk update absensi satu kelas
     */
    public function bulkStore(Request $request)
    {
        $user = Auth::user();

        if (! $user->isGuru() && ! $user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'kelas_id'          => 'required|exists:kelas,id',
            'tanggal'           => 'required|date',
            'status'            => 'required|array',
            'status.*'          => 'in:hadir,izin,sakit,alpha',
        ]);

        foreach ($request->status as $siswaId => $status) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tanggal'  => $request->tanggal,
                ],
                [
                    'kelas_id'     => $request->kelas_id,
                    'status'       => $status,
                    'dicatat_oleh' => $user->id,
                    'ip_address'   => $request->ip(),
                    'metode'       => 'manual',
                    'waktu_absen'  => now(),
                ]
            );
        }

        return back()->with('success', 'Absensi kelas berhasil disimpan.');
    }
}
