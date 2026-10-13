<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CutiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function (Request $request, Closure $next): Response {
                abort_unless($request->user()?->role === 'guru', 403);

                return $next($request);
            },
        ];
    }

    public function index()
    {
        $items = PengajuanCuti::where('user_id', Auth::id())->latest()->paginate(15);

        return view('guru.cuti.index', compact('items'));
    }

    public function create()
    {
        return view('guru.cuti.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis' => 'required|in:cuti,izin,sakit,dinas',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:1000',
        ]);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        PengajuanCuti::create($data);

        return redirect()->route('guru.cuti.index')
            ->with('success', 'Pengajuan berhasil dikirim ke Admin/TU.');
    }

    public function destroy(PengajuanCuti $cuti)
    {
        abort_unless($cuti->user_id === Auth::id() && $cuti->status === 'pending', 403);
        $cuti->delete();

        return back()->with('success', 'Pengajuan dibatalkan.');
    }
}
