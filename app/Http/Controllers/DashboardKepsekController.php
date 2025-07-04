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
        // Ambil data penilaian: rata-rata nilai per guru, kriteria, dan periode
        $penilaian = DB::table('detail_penilaian')
            ->join('penilaian', 'detail_penilaian.id_penilaian', '=', 'penilaian.id_penilaian')
            ->join('guru', 'penilaian.id_guru', '=', 'guru.id_guru')
            ->join('kriteria_penilaian', 'detail_penilaian.id_kriteria', '=', 'kriteria_penilaian.id_kriteria')
            ->select(
                'guru.nama as nama_guru',
                'kriteria_penilaian.nama as kriteria',
                DB::raw("DATE_FORMAT(penilaian.created_at, '%Y-%m') as periode"),
                DB::raw('AVG(detail_penilaian.nilai) as rata_rata')
            )
            ->groupBy(
                'guru.id_guru',
                'guru.nama',
                'kriteria_penilaian.id_kriteria',
                'kriteria_penilaian.nama',
                DB::raw("DATE_FORMAT(penilaian.created_at, '%Y-%m')")
            )
            ->orderBy('periode')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'guru' => $item->nama_guru,
                    'kriteria' => $item->kriteria,
                    'periode' => $item->periode,
                    'rata_rata' => round($item->rata_rata, 2),
                ];
            });

        $totalFeedback = DB::table('feedback')->count();
        $totalGuru = DB::table('guru')->count();

        return view('dashboard.kepsek', compact('penilaian', 'totalFeedback', 'totalGuru'));
    }
}
