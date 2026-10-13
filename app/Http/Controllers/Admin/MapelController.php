<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::with('guru')->orderBy('nama')->paginate(20);

        return view('admin.mapel.index', compact('mapels'));
    }

    public function create()
    {
        $gurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('admin.mapel.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:100',
            'kode'    => 'required|string|max:20|unique:mapels,kode',
            'guru_id' => 'nullable|exists:users,id',
        ]);
        Mapel::create($data);

        return redirect()->route('admin.mapel.index')->with('success', 'Mapel ditambahkan.');
    }

    public function edit(Mapel $mapel)
    {
        $gurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('admin.mapel.edit', compact('mapel', 'gurus'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:100',
            'kode'    => 'required|string|max:20|unique:mapels,kode,'.$mapel->id,
            'guru_id' => 'nullable|exists:users,id',
        ]);
        $mapel->update($data);

        return redirect()->route('admin.mapel.index')->with('success', 'Mapel diperbarui.');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();

        return back()->with('success', 'Mapel dihapus.');
    }
}
