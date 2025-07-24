<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardGuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:guru']);
    }

public function index()
{
    // Sementara, gunakan id_guru langsung tanpa Auth
    $idGuru = 1;

    // Ambil data guru dari database
    $guru = DB::table('guru')->where('id_guru', $idGuru)->first();

    if (!$guru) {
        abort(403, 'Data guru tidak ditemukan.');
    }

    // Hitung rata-rata nilai guru ini
    $rataNilai = DB::table('detail_penilaian')
        ->join('penilaian', 'detail_penilaian.id_penilaian', '=', 'penilaian.id_penilaian')
        ->where('penilaian.id_guru', $guru->id_guru)
        ->avg('nilai');

    // Hitung total penilaian
    $totalPenilaian = DB::table('penilaian')->where('id_guru', $guru->id_guru)->count();

    // Ambil semua guru dengan rata-rata nilai mereka
    $rankingData = DB::table('guru')
        ->join('penilaian', 'guru.id_guru', '=', 'penilaian.id_guru')
        ->join('detail_penilaian', 'penilaian.id_penilaian', '=', 'detail_penilaian.id_penilaian')
        ->select('guru.id_guru', DB::raw('AVG(detail_penilaian.nilai) as rata_nilai'))
        ->groupBy('guru.id_guru')
        ->orderByDesc('rata_nilai')
        ->get();

    // Cari ranking guru login
    $peringkat = $rankingData->search(fn ($item) => $item->id_guru == $guru->id_guru) + 1;

    // Grafik nilai per bulan
    $nilaiPerBulan = DB::table('detail_penilaian')
        ->join('penilaian', 'detail_penilaian.id_penilaian', '=', 'penilaian.id_penilaian')
        ->select(
            DB::raw("DATE_FORMAT(penilaian.tanggal, '%Y-%m') as bulan"),
            DB::raw("CAST(AVG(detail_penilaian.nilai) AS DECIMAL(10,2)) as rata")
        )
        ->where('penilaian.id_guru', $guru->id_guru)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    return view('dashboard.guru', compact(
        'totalPenilaian',
        'rataNilai',
        'nilaiPerBulan',
        'peringkat'
    ));
}



}
