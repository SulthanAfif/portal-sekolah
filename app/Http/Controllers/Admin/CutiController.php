<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    public function index(Request $request)
    {
        $q = PengajuanCuti::with('user')->latest();
        if ($request->status) {
            $q->where('status', $request->status);
        }
        $items = $q->paginate(20)->withQueryString();

        return view('admin.cuti.index', compact('items'));
    }

    public function update(Request $request, PengajuanCuti $cuti)
    {
        $data = $request->validate([
            'status' => 'required|in:approved,rejected',
            'catatan_admin' => 'nullable|string|max:500',
        ]);
        $data['reviewed_by'] = Auth::id();
        $cuti->update($data);

        return back()->with('success', 'Status pengajuan diperbarui.');
    }
}
