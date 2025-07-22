<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_kelas' => 'X IPA 1'],
            ['nama_kelas' => 'X IPA 2'],
            ['nama_kelas' => 'XI IPS 1'],
            ['nama_kelas' => 'XII IPA 3'],
        ];

        foreach ($data as $kelas) {
            Kelas::create($kelas);
        }
    }
}
