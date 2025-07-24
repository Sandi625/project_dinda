<?php

namespace App\Http\Controllers;

use App\Exports\JadwalExport;
use Maatwebsite\Excel\Facades\Excel;

class JadwalExportController extends Controller
{
    public function export()
    {
        return Excel::download(new JadwalExport, 'jadwal-mengajar.xlsx');
    }
}
