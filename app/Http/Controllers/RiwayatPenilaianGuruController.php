<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RiwayatPenilaianGuruController extends Controller
{
public function index(Request $request)
{
    $user = Auth::user();

    $query = Penilaian::with(['guru', 'kelas', 'mapel', 'detailPenilaian.kriteria'])
        ->orderByDesc('tanggal');

    // Jika user adalah guru, hanya tampilkan data miliknya berdasarkan id_user
    if ($user->role === 'guru') {
        $query->where('id_user', $user->id_user);
    }

    // Filter berdasarkan semester jika dipilih
    if ($request->filled('semester')) {
        $query->where('semester', $request->semester);
    }

    $penilaian = $query->get();

    // Ambil daftar semester unik dari penilaian milik user (jika guru)
    $daftarSemesterQuery = Penilaian::select('semester')->distinct();

    if ($user->role === 'guru') {
        $daftarSemesterQuery->where('id_user', $user->id_user);
    }

    $daftarSemester = $daftarSemesterQuery
        ->pluck('semester')
        ->filter()
        ->sort()
        ->values();

    return view('guru.riwayat.index', compact('penilaian', 'daftarSemester'));
}





    public function detail($id)
{
    $penilaian = Penilaian::with(['kelas', 'mapel', 'user', 'detailPenilaian.kriteria'])
        ->where('id_penilaian', $id)
        ->where('id_guru', Auth::user()->id_guru)
        ->firstOrFail();

    return view('guru.riwayat.detail', compact('penilaian'));
}

}
