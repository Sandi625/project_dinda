<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKinerja extends Model
{
    use HasFactory;

    protected $table = 'laporan_kinerja';

    protected $fillable = [
        'id_guru',
    'id_semester', // tambahkan ini
        'created_at',
        'updated_at',
    ];

    // Relasi ke model Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    // Relasi ke detail laporan
    public function detail()
    {
        return $this->hasMany(LaporanKinerjaDetail::class, 'laporan_kinerja_id');
    }

    // LaporanKinerja.php


public function user()
{
    return $this->guru ? $this->guru->user() : null; // opsional, jika butuh user langsung
}

public function semester()
{
    return $this->belongsTo(Semester::class, 'id_semester');
}


}
