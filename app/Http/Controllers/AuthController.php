<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form pendaftaran
     */
    public function showRegister()
    {
        return $this->renderView('auth.register');
    }

    /**
     * Memproses pendaftaran pengguna baru
     */
    public function register(Request $request)
    {
        // 1. Validasi input & cek agar email tidak kembar
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // butuh input name="password_confirmation" di form
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // 2. Simpan user baru (role otomatis 'user')
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'is_active' => true,
        ]);

        // 3. Langsung login otomatis setelah daftar & arahkan ke dasbor user
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang.');
    }

    /**
     * Menampilkan halaman form login
     */
    public function showLogin()
    {
        return $this->renderView('auth.login');
    }

    /**
     * Memproses login pengguna maupun admin
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Coba cocokkan email dan password
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek apakah akun dinonaktifkan oleh Admin
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Admin.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            // Arahkan halaman berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses keluar (logout) dari sistem
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}