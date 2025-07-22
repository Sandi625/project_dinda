<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPembelajaran;

class KepsekLaporanController extends Controller
{
    /**
     * Tampilkan semua laporan pembelajaran untuk kepala sekolah.
     */
    public function index()
    {
        // Ambil semua laporan dengan relasi kelas, mapel, dan guru
        $laporanList = LaporanPembelajaran::with(['kelas', 'mapel', 'guru'])
            ->orderByDesc('bulan')
            ->get();

        return view('kepsek.laporan.index', compact('laporanList'));
    }

    /**
     * Tampilkan detail laporan.
     */
    public function show($id)
    {
        $laporan = LaporanPembelajaran::with(['kelas', 'mapel', 'guru'])->findOrFail($id);

        return view('kepsek.laporan.show', compact('laporan'));
    }
}
