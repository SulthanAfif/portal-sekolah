<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $q = User::where('role', 'guru')->latest();
        if ($s = $request->get('q')) {
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%")->orWhere('nis_nip', 'like', "%$s%");
            });
        }
        $guru = $q->paginate(15)->withQueryString();

        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nis_nip'  => 'nullable|string|max:50|unique:users,nis_nip',
            'no_hp'    => 'nullable|string|max:20',
            'is_active'=> 'nullable|boolean',
        ]);
        $data['role'] = 'guru';
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);
        User::create($data);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit(User $guru)
    {
        abort_unless($guru->role === 'guru', 404);

        return view('admin.guru.edit', ['guru' => $guru]);
    }

    public function update(Request $request, User $guru)
    {
        abort_unless($guru->role === 'guru', 404);
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$guru->id,
            'password' => 'nullable|min:8',
            'nis_nip'  => 'nullable|string|max:50|unique:users,nis_nip,'.$guru->id,
            'no_hp'    => 'nullable|string|max:20',
            'is_active'=> 'nullable|boolean',
        ]);
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $data['is_active'] = $request->boolean('is_active');
        $guru->update($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru diperbarui.');
    }

    public function destroy(User $guru)
    {
        abort_unless($guru->role === 'guru', 404);
        $guru->delete();

        return back()->with('success', 'Guru dihapus.');
    }
}
