<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardKepsekController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:kepala_sekolah']);
    }

public function index()
{
    $penilaian = DB::select("
        SELECT
            users.name AS nama_user,
            kriteria_penilaian.nama AS kriteria,
            DATE_FORMAT(penilaian.created_at, '%Y-%m') AS periode,
            AVG(detail_penilaian.nilai) AS rata_rata
        FROM detail_penilaian
        INNER JOIN penilaian ON detail_penilaian.id_penilaian = penilaian.id_penilaian
        INNER JOIN users ON penilaian.id_user = users.id_user
        INNER JOIN kriteria_penilaian ON detail_penilaian.id_kriteria = kriteria_penilaian.id_kriteria
        GROUP BY users.id_user, users.name, kriteria_penilaian.id_kriteria, kriteria_penilaian.nama, DATE_FORMAT(penilaian.created_at, '%Y-%m')
        ORDER BY periode ASC
        LIMIT 0, 25
    ");

    // Konversi rata-rata ke 2 desimal dan ubah properti jadi konsisten
    $penilaian = collect($penilaian)->map(function ($item) {
        return (object)[
            'user' => $item->nama_user,
            'kriteria' => $item->kriteria,
            'periode' => $item->periode,
            'rata_rata' => round($item->rata_rata, 2),
        ];
    });

    $totalFeedback = DB::table('feedback')->count();
    $totalUser = DB::table('users')->count();

    return view('dashboard.kepsek', compact('penilaian', 'totalFeedback', 'totalUser'));
}








}
