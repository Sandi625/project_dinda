<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianSiswa extends Model
{
    use HasFactory;

    protected $table = 'penilaiansiswa';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'nilai',
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Relasi ke mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
}
