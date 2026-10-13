<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $domains = config('school.allowed_email_domains', ['sekolah.sch.id']);

        return view('auth.register', compact('domains'));
    }

    public function store(Request $request): RedirectResponse
    {
        $domains = config('school.allowed_email_domains', ['sekolah.sch.id']);

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:siswa,guru'],
            'nis_nip'  => ['nullable', 'string', 'max:50'],
        ]);

        $email = strtolower($request->email);
        $domain = substr(strrchr($email, '@') ?: '', 1);

        if (! in_array($domain, $domains, true)) {
            throw ValidationException::withMessages([
                'email' => 'Registrasi hanya diizinkan menggunakan email domain sekolah: '.implode(', ', $domains),
            ]);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'nis_nip'  => $request->nis_nip,
            'is_active'=> true,
        ]);

        event(new Registered($user));
        Auth::login($user);

        if ($user->role === 'siswa') {
            return redirect()->route('biodata.show');
        }

        return redirect()->route('dashboard');
    }
}
