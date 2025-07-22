<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KriteriaPenilaian;

class KriteriaPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Kedisiplinan', 'bobot' => 20.00],
            ['nama' => 'Komunikasi', 'bobot' => 15.00],
            ['nama' => 'Tanggung Jawab', 'bobot' => 25.00],
            ['nama' => 'Kreativitas', 'bobot' => 20.00],
            ['nama' => 'Kerja Sama', 'bobot' => 20.00],
        ];

        foreach ($data as $item) {
            KriteriaPenilaian::create($item);
        }
    }
}
