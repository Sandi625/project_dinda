<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use Illuminate\Support\Facades\Auth;

class JadwalGuruController extends Controller
{
    /**
     * Tampilkan jadwal guru yang sedang login.
     */
    public function index()
    {
        // Ambil user yang login
        $user = Auth::user();

        // Pastikan user punya relasi ke guru
        $idGuru = optional($user->guru)->id_guru;

        if (!$idGuru) {
            return back()->with('error', 'Data guru tidak ditemukan untuk akun ini.');
        }

        // Ambil jadwal berdasarkan id_guru
        $jadwal = JadwalMengajar::with(['mapel', 'kelas']) // relasi ke model lain
                    ->where('id_guru', $idGuru)
                    ->orderBy('hari')
                    ->orderBy('jam_ke')
                    ->get();

        return view('guru.jadwal', compact('jadwal'));
    }
}
