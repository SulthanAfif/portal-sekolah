<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $items = Pengumuman::with('pembuat')->latest()->paginate(15);

        return view('admin.pengumuman.index', compact('items'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'isi'          => 'required|string',
            'target'       => 'required|in:semua,siswa,guru',
            'is_published' => 'nullable|boolean',
        ]);
        $data['user_id'] = Auth::id();
        $data['is_published'] = $request->boolean('is_published', true);
        $data['published_at'] = $data['is_published'] ? now() : null;
        Pengumuman::create($data);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman dibuat.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'isi'          => 'required|string',
            'target'       => 'required|in:semua,siswa,guru',
            'is_published' => 'nullable|boolean',
        ]);
        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && ! $pengumuman->published_at) {
            $data['published_at'] = now();
        }
        $pengumuman->update($data);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return back()->with('success', 'Pengumuman dihapus.');
    }
}
