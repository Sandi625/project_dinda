<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileKepsekController extends Controller
{
    /**
     * Tampilkan halaman profil kepala sekolah.
     */
    public function show()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'kepala_sekolah') {
            abort(403, 'Akses ditolak');
        }

        return view('profilekepsek.show', compact('user'));
    }

    /**
     * Tampilkan form edit profil kepala sekolah.
     */
    public function edit()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'kepala_sekolah') {
            abort(403, 'Akses ditolak');
        }

        return view('profilekepsek.edit', compact('user'));
    }

    /**
     * Simpan perubahan data profil kepala sekolah.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'kepala_sekolah') {
            abort(403, 'Akses ditolak');
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id_user . ',id_user',
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return redirect()->route('kepsek.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Ubah password kepala sekolah.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'kepala_sekolah') {
            abort(403, 'Akses ditolak');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak cocok.',
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('kepsek.profile.show')->with('success', 'Password berhasil diubah.');
    }
}
