<?php

namespace App\Imports;

use App\Models\NilaiSiswa;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;

class NilaiSiswaImport implements ToModel
{
    public function model(array $row)
    {
        // Lewati baris header
        if ($row[0] === 'nama_siswa' || $row[0] === null) {
            return null;
        }

        // Konversi tanggal Excel atau fallback
        $tanggal = null;

        try {
            $tanggal = is_numeric($row[7])
                ? Carbon::instance(Date::excelToDateTimeObject($row[7]))->format('Y-m-d')
                : Carbon::parse($row[7])->format('Y-m-d');
        } catch (\Exception $e) {
            throw new \Exception('Tanggal tidak valid di baris: ' . implode(', ', $row));
        }

        return new NilaiSiswa([
            'nama_siswa' => $row[0],
            'nisn'       => $row[1],
            'kelas'      => $row[2],
            'mapel'      => $row[3],
            'kriteria'   => $row[4],
            'semester'   => strtolower($row[5]),
            'nilai'      => $row[6],
            'tanggal'    => $tanggal,
            'nama_guru'  => $row[8] ?? null, // ✅ Tambahkan ini
        ]);
    }
}
