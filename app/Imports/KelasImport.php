<?php

namespace App\Imports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;

class KelasImport implements ToModel
{
    public function model(array $row)
    {
        if ($row[0] === 'nama_kelas' || $row[0] === null) {
            return null;
        }

        return new Kelas([
            'nama_kelas' => $row[0],
        ]);
    }
}
