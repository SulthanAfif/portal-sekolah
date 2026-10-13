<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $q = Jadwal::with(['kelas', 'mapel', 'guru'])->orderBy('hari')->orderBy('jam_mulai');
        if ($kelasId) {
            $q->where('kelas_id', $kelasId);
        }
        $jadwals = $q->paginate(30)->withQueryString();
        $kelasList = Kelas::orderBy('nama')->get();

        return view('admin.jadwal.index', compact('jadwals', 'kelasList', 'kelasId'));
    }

    public function create()
    {
        return view('admin.jadwal.create', [
            'kelasList' => Kelas::orderBy('nama')->get(),
            'mapels'    => Mapel::orderBy('nama')->get(),
            'gurus'     => User::where('role', 'guru')->orderBy('name')->get(),
            'hariList'  => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kelas_id'    => 'required|exists:kelas,id',
            'mapel_id'    => 'required|exists:mapels,id',
            'guru_id'     => 'required|exists:users,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'ruangan'     => 'nullable|string|max:50',
        ]);
        Jadwal::create($data);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        return view('admin.jadwal.edit', [
            'jadwal'    => $jadwal,
            'kelasList' => Kelas::orderBy('nama')->get(),
            'mapels'    => Mapel::orderBy('nama')->get(),
            'gurus'     => User::where('role', 'guru')->orderBy('name')->get(),
            'hariList'  => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        ]);
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $data = $request->validate([
            'kelas_id'    => 'required|exists:kelas,id',
            'mapel_id'    => 'required|exists:mapels,id',
            'guru_id'     => 'required|exists:users,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'ruangan'     => 'nullable|string|max:50',
        ]);
        $jadwal->update($data);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return back()->with('success', 'Jadwal dihapus.');
    }
}
