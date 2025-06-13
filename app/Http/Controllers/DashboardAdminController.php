<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

// Controller
public function index()
{
    $penilaian = DB::table('detail_penilaian')
        ->join('kriteria_penilaian', 'detail_penilaian.id_kriteria', '=', 'kriteria_penilaian.id_kriteria')
        ->select('kriteria_penilaian.nama as kriteria', DB::raw('AVG(detail_penilaian.nilai) as rata_rata'))
        ->groupBy('detail_penilaian.id_kriteria', 'kriteria_penilaian.nama')
        ->get()
        ->map(function ($item) {
            return (object)[
                'kriteria' => $item->kriteria,
                'rata_rata' => (float) $item->rata_rata,
            ];
        });

    $totalFeedback = DB::table('feedback')->count();
    $totalGuru = DB::table('guru')->count();

    return view('dashboard.admin', compact('penilaian', 'totalFeedback', 'totalGuru'));
}




}
