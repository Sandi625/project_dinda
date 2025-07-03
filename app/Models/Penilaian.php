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
        'id_user', // ✅ Tambahkan ini
        'periode',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

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
