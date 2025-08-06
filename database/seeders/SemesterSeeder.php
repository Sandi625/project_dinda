<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['semester' => 'ganjil', 'tahun' => '2023', 'created_at' => now(), 'updated_at' => now()],
            ['semester' => 'genap', 'tahun' => '2023', 'created_at' => now(), 'updated_at' => now()],
            ['semester' => 'ganjil', 'tahun' => '2024', 'created_at' => now(), 'updated_at' => now()],
            ['semester' => 'genap', 'tahun' => '2024', 'created_at' => now(), 'updated_at' => now()],
            ['semester' => 'ganjil', 'tahun' => '2025', 'created_at' => now(), 'updated_at' => now()],
            ['semester' => 'genap', 'tahun' => '2025', 'created_at' => now(), 'updated_at' => now()],
            ['semester' => 'ganjil', 'tahun' => '2026', 'created_at' => now(), 'updated_at' => now()],
            ['semester' => 'genap', 'tahun' => '2026', 'created_at' => now(), 'updated_at' => now()],
            ['semester' => 'ganjil', 'tahun' => '2027', 'created_at' => now(), 'updated_at' => now()],
            ['semester' => 'genap', 'tahun' => '2027', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('semester')->insert($data);
    }
}
