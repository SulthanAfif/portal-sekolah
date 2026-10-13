<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $allKelas = Kelas::query()
            ->select(['id', 'nama', 'tingkat', 'jurusan'])
            ->orderBy('nama')
            ->get();
        $kelasList = $allKelas->unique('nama')->values();
        $tingkatList = $allKelas->pluck('tingkat')
            ->filter()
            ->unique()
            ->sortBy(fn (string $tingkat): int => ['X' => 1, 'XI' => 2, 'XII' => 3][$tingkat] ?? 99)
            ->values();
        $jurusanList = $allKelas->pluck('jurusan')->filter()->unique()->sort()->values();
        $lokalList = $allKelas->map(function (Kelas $kelas): ?string {
            return preg_match('/\s+(\d+)$/', $kelas->nama, $matches) === 1
                ? $matches[1]
                : null;
        })->filter()->unique()->sortBy(fn (string $lokal): int => (int) $lokal)->values();

        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'nis' => ['nullable', 'string', 'max:50'],
            'kelas_id' => ['nullable', 'integer', 'exists:kelas,id'],
            'tingkat' => ['nullable', 'string', Rule::in($tingkatList->all())],
            'jurusan' => ['nullable', 'string', Rule::in($jurusanList->all())],
            'lokal' => ['nullable', 'string', Rule::in($lokalList->all())],
        ]);

        $query = User::where('role', 'siswa')->with('kelas')->latest();
        if (! empty($filters['q'])) {
            $query->where(function (Builder $studentQuery) use ($filters): void {
                $search = $filters['q'];
                $studentQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nis_nip', 'like', "%{$search}%");
            });
        }
        if (! empty($filters['nis'])) {
            $query->where('nis_nip', 'like', '%'.$filters['nis'].'%');
        }
        $selectedKelas = ! empty($filters['kelas_id'])
            ? $allKelas->firstWhere('id', (int) $filters['kelas_id'])?->nama
            : null;
        if ($selectedKelas !== null || ! empty($filters['tingkat']) || ! empty($filters['jurusan']) || ! empty($filters['lokal'])) {
            $query->whereHas('kelas', function (Builder $kelasQuery) use ($filters, $selectedKelas): void {
                if ($selectedKelas !== null) {
                    $kelasQuery->where('nama', $selectedKelas);
                }
                if (! empty($filters['tingkat'])) {
                    $kelasQuery->where('tingkat', $filters['tingkat']);
                }
                if (! empty($filters['jurusan'])) {
                    $kelasQuery->where('jurusan', $filters['jurusan']);
                }
                if (! empty($filters['lokal'])) {
                    $kelasQuery->where('nama', 'like', '% '.$filters['lokal']);
                }
            });
        }

        $siswa = $query->paginate(15)->withQueryString();

        return view('admin.siswa.index', compact('siswa', 'kelasList', 'tingkatList', 'jurusanList', 'lokalList'));
    }

    public function create()
    {
        $kelasList = Kelas::orderBy('nama')->get();

        return view('admin.siswa.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nis_nip' => 'nullable|string|max:50|unique:users,nis_nip',
            'no_hp' => 'nullable|string|max:20',
            'kelas_id' => 'nullable|exists:kelas,id',
            'is_active' => 'nullable|boolean',
        ]);
        $data['role'] = 'siswa';
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);
        User::create($data);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);
        $kelasList = Kelas::orderBy('nama')->get();

        return view('admin.siswa.edit', compact('siswa', 'kelasList'));
    }

    public function update(Request $request, User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$siswa->id,
            'password' => 'nullable|min:8',
            'nis_nip' => 'nullable|string|max:50|unique:users,nis_nip,'.$siswa->id,
            'no_hp' => 'nullable|string|max:20',
            'kelas_id' => 'nullable|exists:kelas,id',
            'is_active' => 'nullable|boolean',
        ]);
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $data['is_active'] = $request->boolean('is_active');
        $siswa->update($data);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa diperbarui.');
    }

    public function destroy(User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);
        $siswa->delete();

        return back()->with('success', 'Siswa dihapus.');
    }
}
