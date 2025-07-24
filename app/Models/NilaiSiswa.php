<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSiswa extends Model
{
    use HasFactory;

    protected $table = 'nilai_siswa'; // Nama tabel

    protected $fillable = [
        'nama_siswa',
        'nisn',
        'kelas',
        'mapel',
        'kriteria',
        'semester',
        'nilai',
        'tanggal',
        'nama_guru', // tambahkan ini

    ];



    public function siswa()
{
    return $this->belongsTo(Siswa::class, 'id_siswa');
}

}
