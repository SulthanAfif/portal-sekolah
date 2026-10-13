<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('waliKelas')->withCount(['siswa'])->orderBy('nama')->paginate(20);

        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $gurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('admin.kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'          => 'required|string|max:100',
            'tingkat'       => 'required|string|max:10',
            'jurusan'       => 'nullable|string|max:50',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);
        Kelas::create($data);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        $kelas = $kela;
        $gurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('admin.kelas.edit', compact('kelas', 'gurus'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $data = $request->validate([
            'nama'          => 'required|string|max:100',
            'tingkat'       => 'required|string|max:10',
            'jurusan'       => 'nullable|string|max:50',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);
        $kela->update($data);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();

        return back()->with('success', 'Kelas dihapus.');
    }
}
