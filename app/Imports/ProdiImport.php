<?php

namespace App\Imports;

use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Prodi([
            'nama_prodi' => $row['nama_prodi'], // pastikan kolom di Excel pakai heading "nama_prodi"
        ]);
    }
}
