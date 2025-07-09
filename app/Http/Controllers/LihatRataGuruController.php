<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LihatRataGuruController extends Controller
{
    // Menampilkan daftar guru dengan rata-rata nilai siswa
    public function index()
    {
        $data = Guru::with('mapel') // Relasi ke mapel
            ->get()
            ->map(function ($guru) {
                // Ambil siswa yang diajar guru berdasarkan id_mapel
                $siswa = Siswa::where('id_mapel', $guru->id_mapel)->get();

                // Hitung rata-rata nilai
                $rataRata = $siswa->avg('nilai');

                return [
                    'guru' => $guru,
                    'mapel' => $guru->mapel ? $guru->mapel->nama_mapel : '-',
                    'jumlah_siswa' => $siswa->count(),
                    'rata_nilai' => $rataRata !== null ? round($rataRata, 2) : 'Belum dinilai',
                ];
            });

        return view('kepsek.rata_nilai_guru', compact('data'));
    }
}
