<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mapel;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_mapel' => 'Matematika'],
            ['nama_mapel' => 'Bahasa Indonesia'],
            ['nama_mapel' => 'Fisika'],
            ['nama_mapel' => 'Ekonomi'],
        ];

        foreach ($data as $mapel) {
            Mapel::create($mapel);
        }
    }
}
