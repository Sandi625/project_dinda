<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';
    protected $primaryKey = 'id_penilaian';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_guru',
        'id_user',
        'id_kelas',
        'id_mapel',
        'tanggal',
        'semester', // ✅ tambahkan di sini
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'semester' => 'string', // ✅ opsional: pastikan di-cast sebagai string
    ];

    // ❌ Hapus accessor jika tidak ambil dari relasi guru
    // public function getSemesterAttribute()
    // {
    //     return $this->guru?->semester;
    // }

    // Relasi ke guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    // Relasi ke user (misalnya yang menilai)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    // Relasi ke mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id');
    }

    // Relasi ke detail penilaian
    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'id_penilaian', 'id_penilaian');
    }

    // Relasi ke feedback
    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'id_penilaian', 'id_penilaian');
    }
}
