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
        ->join('penilaian', 'detail_penilaian.id_penilaian', '=', 'penilaian.id_penilaian')
        ->join('users', 'penilaian.id_user', '=', 'users.id_user') // ✅ gunakan id_user
        ->join('kriteria_penilaian', 'detail_penilaian.id_kriteria', '=', 'kriteria_penilaian.id_kriteria')
        ->select(
            'users.name as nama_user',
            'kriteria_penilaian.nama as kriteria',
            DB::raw("DATE_FORMAT(penilaian.created_at, '%Y-%m') as periode"),
            DB::raw('AVG(detail_penilaian.nilai) as rata_rata')
        )
        ->groupBy(
            'users.id_user', // ✅ ganti id ke id_user
            'users.name',
            'kriteria_penilaian.id_kriteria',
            'kriteria_penilaian.nama',
            DB::raw("DATE_FORMAT(penilaian.created_at, '%Y-%m')")
        )
        ->orderBy('periode')
        ->get()
        ->map(function ($item) {
            return (object)[
                'user' => $item->nama_user,
                'kriteria' => $item->kriteria,
                'periode' => $item->periode,
                'rata_rata' => round($item->rata_rata, 2),
            ];
        });

    $totalFeedback = DB::table('feedback')->count();
    $totalUser = DB::table('users')->count();

    return view('dashboard.admin', compact('penilaian', 'totalFeedback', 'totalUser'));
}









}
