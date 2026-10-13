<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class StrukturController extends Controller
{
    public function index()
    {
        $items = StrukturAnggota::orderBy('urutan')->get();

        return view('admin.struktur.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jabatan' => 'required|string|max:100',
            'nama' => 'required|string|max:150',
            'nip' => 'nullable|string|max:50',
            'is_active' => 'required|boolean',
            'foto' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('struktur', 'public');
            if (! is_string($foto)) {
                throw new RuntimeException('Foto anggota struktur gagal disimpan.');
            }
            $data['foto'] = $foto;
        }
        $data['urutan'] = (StrukturAnggota::max('urutan') ?? -1) + 1;
        StrukturAnggota::create($data);

        return back()->with('success', 'Anggota struktur ditambahkan.');
    }

    public function update(Request $request, StrukturAnggota $struktur)
    {
        $data = $request->validate([
            'jabatan' => 'required|string|max:100',
            'nama' => 'required|string|max:150',
            'nip' => 'nullable|string|max:50',
            'is_active' => 'required|boolean',
            'foto' => 'nullable|image|max:2048',
        ]);
        $oldFoto = $struktur->foto;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('struktur', 'public');
            if (! is_string($foto)) {
                throw new RuntimeException('Foto anggota struktur gagal disimpan.');
            }
            $data['foto'] = $foto;
        }
        $struktur->update($data);
        if (isset($data['foto']) && $oldFoto) {
            Storage::disk('public')->delete($oldFoto);
        }

        return back()->with('success', 'Data diperbarui.');
    }

    public function destroy(StrukturAnggota $struktur)
    {
        if ($struktur->foto) {
            Storage::disk('public')->delete($struktur->foto);
        }
        $struktur->delete();

        return back()->with('success', 'Dihapus.');
    }
}
