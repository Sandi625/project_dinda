<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPenilaianGuruController extends Controller
{
public function index(Request $request)
{
    // Ambil id_guru dari user yang login lewat relasi
    $idGuru = Auth::user()->guru->id_guru ?? null;

    if (!$idGuru) {
        abort(403, 'Anda tidak memiliki akses ke data ini.');
    }

    // Query awal: hanya data milik guru yang sedang login
    $query = Penilaian::with(['guru', 'kelas', 'mapel', 'detailPenilaian.kriteria'])
        ->where('id_guru', $idGuru);

    // Filter berdasarkan semester (jika dipilih)
    if ($request->filled('semester')) {
        $query->where('semester', $request->semester);
    }

    // Ambil semua data penilaian terurut dari tanggal terbaru
    $penilaian = $query->orderByDesc('tanggal')->get();

    // Ambil daftar semester unik dari data penilaian milik guru yang login
    $daftarSemester = Penilaian::where('id_guru', $idGuru)
        ->select('semester')
        ->distinct()
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
