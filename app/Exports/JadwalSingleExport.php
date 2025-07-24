<?php

namespace App\Exports;

use App\Models\JadwalMengajar;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JadwalSingleExport implements FromArray, WithHeadings
{
    protected $jadwal;

    public function __construct(JadwalMengajar $jadwal)
    {
        $this->jadwal = $jadwal;
    }

    public function array(): array
    {
        $jamMapping = [
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

        return [[
            $this->jadwal->hari,
            'Jam ke-' . $this->jadwal->jam_ke . ' (' . ($jamMapping[$this->jadwal->jam_ke] ?? '-') . ')',
            $this->jadwal->mapel->nama_mapel,
            $this->jadwal->kelas->nama_kelas,
            $this->jadwal->guru->nama ?? '-', // jika relasi guru tersedia
        ]];
    }

    public function headings(): array
    {
        return ['Hari', 'Jam', 'Mata Pelajaran', 'Kelas', 'Nama Guru'];
    }
}
