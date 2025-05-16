<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    use HasFactory;

    // Nama tabel (default 'detail_penilaians', jadi override)
    protected $table = 'detail_penilaian';

    // Primary key custom
    protected $primaryKey = 'id_detail';

    // Primary key auto increment
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Fields yang boleh diisi massal
    protected $fillable = [
        'id_penilaian',
        'id_kriteria',
        'nilai',
    ];

    // Relasi ke Penilaian
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'id_penilaian', 'id_penilaian');
    }

    // Relasi ke KriteriaPenilaian
    public function kriteria()
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'id_kriteria', 'id_kriteria');
    }

}
