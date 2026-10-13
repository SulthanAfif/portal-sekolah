<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\User;
use App\Models\Kelas;

class InfoSekolahController extends Controller
{
    public function profil()
    {
        $s = SiteSetting::allKeyed();
        $stats = [
            'siswa' => User::where('role', 'siswa')->where('is_active', true)->count(),
            'guru' => User::where('role', 'guru')->where('is_active', true)->count(),
            'kelas' => Kelas::count(),
        ];

        return view('info.profil', compact('s', 'stats'));
    }

    public function struktur()
    {
        $s = SiteSetting::allKeyed();
        $lines = array_filter(array_map('trim', explode("\n", $s['school_struktur'] ?? '')));
        $kepala = $s['school_kepala'] ?? '-';
        $wali = Kelas::with('waliKelas')->orderBy('nama')->get();

        return view('info.struktur', compact('s', 'lines', 'kepala', 'wali'));
    }
}
