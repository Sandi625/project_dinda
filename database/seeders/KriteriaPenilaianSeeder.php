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
            ['nama' => 'Kedisiplinan'],
            ['nama' => 'Komunikasi'],
            ['nama' => 'Tanggung Jawab'],
            ['nama' => 'Kreativitas'],
            ['nama' => 'Kerja Sama'],
        ];

        foreach ($data as $item) {
            KriteriaPenilaian::create($item);
        }
    }
}
