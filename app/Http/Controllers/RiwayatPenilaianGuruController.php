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
    // Gunakan id_guru secara hardcoded sementara (contoh: 1)
    $idGuru = 1;

    // Cek apakah guru dengan id tersebut ada (opsional, untuk keamanan)
    $guruExists = DB::table('guru')->where('id_guru', $idGuru)->exists();

    if (!$guruExists) {
        abort(403, 'Data guru tidak ditemukan.');
    }

    // Query awal: hanya data milik guru dengan id tersebut
    $query = Penilaian::with(['guru', 'kelas', 'mapel', 'detailPenilaian.kriteria'])
        ->where('id_guru', $idGuru);

    // Filter berdasarkan semester (jika dipilih)
    if ($request->filled('semester')) {
        $query->where('semester', $request->semester);
    }

    // Ambil semua data penilaian terurut dari tanggal terbaru
    $penilaian = $query->orderByDesc('tanggal')->get();

    // Ambil daftar semester unik dari data penilaian milik guru
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
