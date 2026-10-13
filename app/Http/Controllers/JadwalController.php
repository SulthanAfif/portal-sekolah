<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        if ($user->canManageData()) {
            $kelasId = $request->get('kelas_id');
            $jadwals = Jadwal::with(['kelas', 'mapel', 'guru'])
                ->when($kelasId, fn ($query) => $query->where('kelas_id', $kelasId))
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->paginate(30)
                ->withQueryString();

            return view('admin.jadwal.index', [
                'jadwals' => $jadwals,
                'kelasList' => Kelas::orderBy('nama')->get(),
                'kelasId' => $kelasId,
            ]);
        }

        $hariIni = now()->locale('id')->isoFormat('dddd');
        $hariAktif = $request->query('hari');
        if (! in_array($hariAktif, $hariList, true)) {
            $hariAktif = in_array($hariIni, $hariList, true) ? $hariIni : $hariList[0];
        }

        $jadwalsQuery = Jadwal::with(['kelas', 'mapel', 'guru'])
            ->when($user->isGuru(), fn ($query) => $query->where('guru_id', $user->id))
            ->when($user->isSiswa(), fn ($query) => $query->where('kelas_id', $user->kelas_id))
            ->orderBy('jam_mulai');
        $jadwals = $jadwalsQuery->get()->groupBy('hari');
        $jadwalHariIni = $jadwals->get($hariAktif, collect());

        return view($user->isGuru() ? 'jadwal.guru' : 'jadwal.siswa', [
            'hariList' => $hariList,
            'hariAktif' => $hariAktif,
            'jadwalHariIni' => $jadwalHariIni,
            'jadwals' => $jadwals,
        ]);
    }
}
