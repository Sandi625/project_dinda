<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id_guru';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'nip',
        'nama',
        'alamat',
        'id_mapel',
        'id_kelas',     // tetap ada
        'id_prodi',     // ✅ ditambahkan ke fillable
        'semester',     // ✅ kolom baru
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_guru', 'id_guru');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
  public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi'); // ✅ eksplisit karena nama kolomnya id_prodi
    }

    // Guru.php
public function laporanKinerja()
{
    return $this->hasMany(LaporanKinerja::class, 'id_guru', 'id_guru');
}



}
