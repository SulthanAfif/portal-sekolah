<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NilaiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function (Request $request, Closure $next): Response {
                if ($request->user()?->role !== 'guru') {
                    abort(403, 'Hanya guru yang dapat mengakses.');
                }

                return $next($request);
            },
        ];
    }

    public function index()
    {
        $nilais = Nilai::with(['siswa', 'mapel', 'kelas'])
            ->where('guru_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('guru.nilai.index', compact('nilais'));
    }

    public function create()
    {
        $mapels = Mapel::where('guru_id', Auth::id())->orderBy('nama')->get();
        if ($mapels->isEmpty()) {
            $mapels = Mapel::orderBy('nama')->get();
        }

        return view('guru.nilai.create', [
            'siswaList' => User::where('role', 'siswa')->where('is_active', true)->orderBy('name')->get(),
            'mapels' => $mapels,
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
            'catatan' => 'nullable|string|max:255',
        ]);
        $data['guru_id'] = Auth::id();
        $data['status'] = 'submitted';
        Nilai::create($data);

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Nilai berhasil diinput dan dikirim ke TU/Admin.');
    }

    public function destroy(Nilai $nilai)
    {
        abort_unless($nilai->guru_id === Auth::id(), 403);
        $nilai->delete();

        return back()->with('success', 'Nilai dihapus.');
    }
}
