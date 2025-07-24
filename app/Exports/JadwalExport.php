<?php

namespace App\Exports;

use App\Models\JadwalMengajar;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JadwalExport implements FromArray, WithHeadings
{
    protected $jamMapping = [
        1 => '07:00 - 07:45',
        2 => '07:45 - 08:30',
        3 => '08:30 - 09:15',
        4 => '09:15 - 10:00',
        5 => '10:20 - 11:05',
        6 => '11:05 - 11:50',
        7 => '12:30 - 13:10',
        8 => '13:10 - 13:50',
        9 => '13:50 - 14:30',
        10 => '14:30 - 15:10',
    ];

    public function array(): array
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $data = [];

        foreach ($days as $day) {
            $row = [$day];

            for ($jam = 1; $jam <= 10; $jam++) {
                $jadwals = JadwalMengajar::with(['kelas', 'mapel', 'guru'])
                    ->where('hari', $day)
                    ->where('jam_ke', $jam)
                    ->get();

                if ($jadwals->isNotEmpty()) {
                    $cell = $jadwals->map(function ($j) {
                        $namaMapel = $j->mapel->nama_mapel ?? '-';
                        $namaKelas = $j->kelas->nama_kelas ?? '-';
                        $namaGuru = $j->guru->nama ?? '-';
                        return "$namaMapel / $namaKelas / $namaGuru";
                    })->implode("\n");
                } else {
                    $cell = '';
                }

                $row[] = $cell;
            }

            $data[] = $row;
        }

        return $data;
    }

    public function headings(): array
    {
        $headers = ['Hari'];
        foreach ($this->jamMapping as $jamKe => $waktu) {
            $headers[] = "$jamKe ($waktu)";
        }
        return $headers;
    }
}
