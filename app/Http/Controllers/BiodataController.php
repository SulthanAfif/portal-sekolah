<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BiodataController extends Controller
{
    /**
     * Tampilkan biodata siswa (setelah login)
     */
    public function show(Request $request): View
    {
        $user = $request->user()->load('kelas');

        if ($user->role !== 'siswa') {
            abort(403, 'Halaman biodata khusus siswa.');
        }

        return view('biodata.show', [
            'user' => $user,
            'isFirstVisit' => is_null($user->profile_completed_at),
        ]);
    }

    /**
     * Update biodata dari form
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->role !== 'siswa') {
            abort(403);
        }

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()
            ->route('biodata.show')
            ->with('status', 'biodata-updated');
    }

    /**
     * Konfirmasi biodata & lanjut ke dashboard
     */
    public function continueToDashboard(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->role !== 'siswa') {
            return redirect()->route('dashboard');
        }

        if (is_null($user->profile_completed_at)) {
            $user->forceFill(['profile_completed_at' => now()])->save();
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Selamat datang di Portal Sekolah!');
    }
}
