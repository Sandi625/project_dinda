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
    $idUser = Auth::id();

    $guru = DB::table('guru')->where('id_user', $idUser)->first();

    if (!$guru) {
        abort(403, 'Data guru tidak ditemukan.');
    }

    $rataNilai = DB::table('detail_penilaian')
        ->join('penilaian', 'detail_penilaian.id_penilaian', '=', 'penilaian.id_penilaian')
        ->where('penilaian.id_user', $idUser)
        ->avg('nilai');

    $totalPenilaian = DB::table('penilaian')
        ->where('id_user', $idUser)
        ->count();

    $rankingData = DB::table('users')
        ->leftJoin('penilaian', 'users.id_user', '=', 'penilaian.id_user')
        ->leftJoin('detail_penilaian', 'penilaian.id_penilaian', '=', 'detail_penilaian.id_penilaian')
        ->select('users.id_user', DB::raw('AVG(detail_penilaian.nilai) as rata_nilai'))
        ->groupBy('users.id_user')
        ->orderByDesc('rata_nilai')
        ->get();

    $peringkat = $rankingData->search(fn ($item) => $item->id_user == $idUser) + 1;

    $nilaiPerBulan = DB::table('detail_penilaian')
        ->join('penilaian', 'detail_penilaian.id_penilaian', '=', 'penilaian.id_penilaian')
        ->select(
            DB::raw("DATE_FORMAT(penilaian.tanggal, '%Y-%m') as bulan"),
            DB::raw("CAST(AVG(detail_penilaian.nilai) AS DECIMAL(10,2)) as rata")
        )
        ->where('penilaian.id_user', $idUser)
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
