<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileGuruController extends Controller
{
    /**
     * Tampilkan halaman profil guru.
     */
    public function show()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'guru') {
            abort(403, 'Akses ditolak.');
        }

        return view('profileguru.show', compact('user'));
    }

    /**
     * Tampilkan form edit profil guru.
     */
    public function edit()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'guru') {
            abort(403, 'Akses ditolak.');
        }

        return view('profileguru.edit', compact('user'));
    }

    /**
     * Simpan perubahan data profil guru.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'guru') {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id_user . ',id_user',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return redirect()->route('guru.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Ubah password guru.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'guru') {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return redirect()->route('guru.profile.show')->with('success', 'Password berhasil diperbarui.');
    }
}
