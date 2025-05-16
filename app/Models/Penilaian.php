<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'penilaian';

    // Primary key custom
    protected $primaryKey = 'id_penilaian';

    // Jika primary key bertipe integer auto increment (default true)
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Fields yang boleh diisi massal
    protected $fillable = [
        'id_guru',
        'periode',
        'tanggal',
    ];

    // Relasi ke Guru (asumsi model Guru sudah ada)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }
    // Pada model Penilaian
    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'id_penilaian', 'id_penilaian');
    }


}
