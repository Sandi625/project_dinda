<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna yang sedang login.
     */
    public function show()
    {
        $user = Auth::user();

        // Pastikan user terautentikasi
        if (!$user instanceof User) {
            abort(403, 'Akses ditolak');
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Tampilkan form untuk mengedit profil.
     */
    public function edit()
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            abort(403, 'Akses ditolak');
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Simpan perubahan profil.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            abort(403, 'Akses ditolak');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id_user . ',id_user',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save(); // Simpan perubahan

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password pengguna.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            abort(403, 'Akses ditolak');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save(); // Simpan password baru

        return redirect()->route('profile.show')->with('success', 'Password berhasil diubah.');
    }
}
