<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Pengumuman;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin', 'tu' => $this->adminDashboard(),
            'guru'        => $this->guruDashboard(),
            'siswa'       => $this->siswaDashboard(),
            default       => abort(403, 'Role tidak dikenali.'),
        };
    }

    // ===================== ADMIN =====================
    private function adminDashboard()
    {
        $data = [
            'totalSiswa'      => User::where('role', 'siswa')->count(),
            'totalGuru'       => User::where('role', 'guru')->count(),
            'totalKelas'      => Kelas::count(),
            'totalPengumuman' => Pengumuman::where('is_published', true)->count(),
            'pengumumanTerbaru' => Pengumuman::with('pembuat')
                                        ->where('is_published', true)
                                        ->latest()
                                        ->take(5)
                                        ->get(),
            'siswaTerbaru'    => User::where('role', 'siswa')
                                        ->latest()
                                        ->take(5)
                                        ->get(),
        ];

        return view('dashboard.admin', $data);
    }

    // ===================== GURU =====================
    private function guruDashboard()
    {
        $user = Auth::user();

        // Kelas yang diampu sebagai wali kelas
        $kelasWali = Kelas::where('wali_kelas_id', $user->id)->first();

        // Jadwal mengajar hari ini
        $hariIni = now()->locale('id')->isoFormat('dddd'); // Senin, Selasa, dst
        $jadwalHariIni = Jadwal::with(['kelas', 'mapel'])
            ->where('guru_id', $user->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        $data = [
            'kelasWali'      => $kelasWali,
            'jadwalHariIni'  => $jadwalHariIni,
            'totalSiswaWali' => $kelasWali ? $kelasWali->siswa()->count() : 0,
            'pengumuman'     => Pengumuman::whereIn('target', ['semua', 'guru'])
                                        ->where('is_published', true)
                                        ->latest()
                                        ->take(5)
                                        ->get(),
        ];

        return view('dashboard.guru', $data);
    }

    // ===================== SISWA =====================
    private function siswaDashboard()
    {
        $user = Auth::user();

        $hariIni = now()->locale('id')->isoFormat('dddd');

        $jadwalHariIni = Jadwal::with(['mapel', 'guru'])
            ->where('kelas_id', $user->kelas_id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        // Nilai terbaru
        $nilaiTerbaru = Nilai::with('mapel')
            ->where('siswa_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Absensi bulan ini
        $absensiBulanIni = Absensi::where('siswa_id', $user->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->get();

        $data = [
            'kelas'           => $user->kelas,
            'jadwalHariIni'   => $jadwalHariIni,
            'nilaiTerbaru'    => $nilaiTerbaru,
            'totalHadir'      => $absensiBulanIni->where('status', 'hadir')->count(),
            'totalIzin'       => $absensiBulanIni->where('status', 'izin')->count(),
            'totalSakit'      => $absensiBulanIni->where('status', 'sakit')->count(),
            'totalAlpha'      => $absensiBulanIni->where('status', 'alpha')->count(),
            'pengumuman'      => Pengumuman::whereIn('target', ['semua', 'siswa'])
                                        ->where('is_published', true)
                                        ->latest()
                                        ->take(5)
                                        ->get(),
        ];

        return view('dashboard.siswa', $data);
    }
}
