<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request): View
    {
        $role = $request->user()->role;
        $pengumumans = Pengumuman::with('pembuat')
            ->where('is_published', true)
            ->whereIn('target', ['semua', $role])
            ->when($request->filled('q'), function ($query) use ($request): void {
                $search = $request->string('q')->trim()->toString();
                $query->where(function ($query) use ($search): void {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('isi', 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('pengumuman.index', compact('pengumumans'));
    }

    public function show(Request $request, Pengumuman $pengumuman): View
    {
        abort_unless(
            $pengumuman->is_published && in_array($pengumuman->target, ['semua', $request->user()->role], true),
            404,
        );

        $related = Pengumuman::with('pembuat')
            ->where('is_published', true)
            ->whereIn('target', ['semua', $request->user()->role])
            ->whereKeyNot($pengumuman->getKey())
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('pengumuman.show', compact('pengumuman', 'related'));
    }
}
