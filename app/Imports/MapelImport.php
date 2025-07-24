<?php

namespace App\Imports;

use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\ToModel;

class MapelImport implements ToModel
{
    public function model(array $row)
    {
        return new Mapel([
            'nama_mapel' => $row[0],
        ]);
    }
}
