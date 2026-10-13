<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pengumuman;
use App\Models\SiteSetting;
use App\Models\StrukturAnggota;
use App\Models\User;

class HomeController extends Controller
{
    private function schoolData(): array
    {
        try {
            $s = SiteSetting::allKeyed();
            if (! empty($s)) {
                return [
                    'nama' => $s['school_name'] ?? config('school.nama'),
                    'alamat' => $s['school_address'] ?? config('school.alamat'),
                    'telepon' => $s['school_phone'] ?? config('school.telepon'),
                    'email' => $s['school_email'] ?? config('school.email'),
                    'jam' => $s['school_hours'] ?? config('school.jam_operasional'),
                    'visi' => $s['school_visi'] ?? '',
                    'misi' => $s['school_misi'] ?? '',
                    'kepala' => $s['school_kepala'] ?? '',
                    'bg' => $s['dashboard_bg'] ?? null,
                    'bg_url' => $s['dashboard_bg_url'] ?? null,
                ];
            }
        } catch (\Throwable $e) {
        }

        return [
            'nama' => config('school.nama'),
            'alamat' => config('school.alamat'),
            'telepon' => config('school.telepon'),
            'email' => config('school.email'),
            'jam' => config('school.jam_operasional'),
            'visi' => '',
            'misi' => '',
            'kepala' => '',
            'bg' => null,
            'bg_url' => null,
        ];
    }

    private function stats(): array
    {
        return [
            'siswa' => User::where('role', 'siswa')->where('is_active', true)->count(),
            'guru' => User::where('role', 'guru')->where('is_active', true)->count(),
            'kelas' => Kelas::count(),
        ];
    }

    public function index()
    {
        $pengumumanPublik = Pengumuman::where('is_published', true)
            ->whereIn('target', ['semua'])
            ->latest('published_at')
            ->take(6)
            ->get();

        $struktur = [];
        try {
            $struktur = StrukturAnggota::where('is_active', true)->orderBy('urutan')->get();
        } catch (\Throwable $e) {
        }

        return view('home', [
            'pengumumanPublik' => $pengumumanPublik,
            'stats' => $this->stats(),
            'school' => $this->schoolData(),
            'struktur' => $struktur,
        ]);
    }

    public function profilSekolah()
    {
        return redirect()->to(url('/').'#profil');
    }
}
