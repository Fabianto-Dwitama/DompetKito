<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna/admin
     */
    public function edit()
    {
        $user = Auth::user();
        return $this->renderView('profile.edit', compact('user'));
    }

    /**
     * Memperbarui nama dan email profil
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id), // Boleh pakai email sendiri, tapi tolak jika dipakai user lain
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return back()->with('success_profile', 'Data profil berhasil diperbarui.');
    }

    /**
     * Mengubah kata sandi akun sendiri
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password', // Otomatis cek kecocokan password lama
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Kata sandi lama wajib diisi.',
            'current_password.current_password' => 'Kata sandi lama tidak sesuai.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success_password', 'Kata sandi berhasil diubah.');
    }
}