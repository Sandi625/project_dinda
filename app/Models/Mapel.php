<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';

    protected $fillable = [
        'nama_mapel',
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_mapel');
    }

    // Relasi ke penilaian siswa
    public function penilaianSiswa()
    {
        return $this->hasMany(PenilaianSiswa::class, 'mapel_id');
    }
}
