<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PenyediaJasa; // Import model PenyediaJasa
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:pengguna,penyedia_jasa'], // Validasi role
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, // Ambil role dari request
            'password' => Hash::make($request->password),
        ]);

        // Jika role adalah 'penyedia_jasa', simpan data ke tabel penyedia_jasa
        if ($user->role === 'penyedia_jasa') {
            PenyediaJasa::create([
                'nama' => $user->name,
                'email' => $user->email,
                'user_id' => $user->id,
                'foto' => 'default.jpg', // Default foto, bisa diubah sesuai kebutuhan
                'telpon' => '0000000000000', // Pastikan telpon ada di form
                'gender' => 'Laki-Laki', // Pastikan gender ada di form
                'alamat' => 'Kosong', // Pastikan alamat ada di form
                'tanggal_lahir' => date(00 - 00 - 00), // Pastikan tanggal_lahir ada di form
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Arahkan pengguna ke halaman berdasarkan role
        if ($user->role === 'penyedia_jasa') {
            return redirect()->route('penyediajasa'); // Route untuk penyedia jasa
        }
        if ($user->role === 'pengguna') {
            return redirect()->route('pengguna'); // Route untuk pengguna
        }

        return redirect()->intended(route('dashboard')); // Default dashboard
    }
}
