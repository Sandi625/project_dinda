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

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

// public function guru()
// {
//     return $this->belongsToMany(Guru::class, 'guru_mapel', 'id_mapel', 'id_guru');
// }

// public function gurus()
// {
//     return $this->belongsToMany(Guru::class, 'guru_mapel', 'id_mapel', 'id_guru');
// }



public function guru()
{
    return $this->belongsToMany(Guru::class, 'guru_mapel', 'id_mapel', 'id_guru');
}






}
