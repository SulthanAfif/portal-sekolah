<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $q = Nilai::with(['siswa', 'mapel', 'kelas', 'guru'])->latest();
        if ($request->kelas_id) $q->where('kelas_id', $request->kelas_id);
        if ($request->mapel_id) $q->where('mapel_id', $request->mapel_id);
        if ($request->status) $q->where('status', $request->status);
        $nilais = $q->paginate(25)->withQueryString();

        return view('admin.nilai.index', [
            'nilais' => $nilais,
            'kelasList' => Kelas::orderBy('nama')->get(),
            'mapels' => Mapel::orderBy('nama')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.nilai.create', [
            'siswaList' => User::where('role', 'siswa')->orderBy('name')->get(),
            'mapels' => Mapel::orderBy('nama')->get(),
            'kelasList' => Kelas::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis' => 'required|string|max:50',
            'nilai' => 'required|numeric|min:0|max:100',
            'semester' => 'required|string|max:20',
            'tahun_ajaran' => 'required|string|max:20',
        ]);
        $data['guru_id'] = Auth::id();
        $data['status'] = 'approved';
        Nilai::create($data);

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai ditambahkan.');
    }

    public function approve(Nilai $nilai)
    {
        $nilai->update(['status' => 'approved']);
        return back()->with('success', 'Nilai disetujui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return back()->with('success', 'Nilai dihapus.');
    }
}
