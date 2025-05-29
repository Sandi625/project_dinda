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
        'periode',
        'tanggal',
    ];

    // Tambahkan ini:
    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'id_penilaian', 'id_penilaian');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'id_penilaian', 'id_penilaian');
    }
}

