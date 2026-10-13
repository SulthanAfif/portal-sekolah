<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
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
                abort_unless($request->user()?->role === 'siswa', 403);

                return $next($request);
            },
        ];
    }

    public function index()
    {
        $nilais = Nilai::with(['mapel', 'guru'])
            ->where('siswa_id', Auth::id())
            ->whereIn('status', ['submitted', 'approved'])
            ->latest()
            ->paginate(30);

        return view('siswa.nilai.index', compact('nilais'));
    }
}
