<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Nama tabel jika beda dari default (default: feedbacks)
    protected $table = 'feedback';

    // Primary key kustom
    protected $primaryKey = 'id_feedback';

    // Primary key auto increment
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Mass assignable attributes
    protected $fillable = [
        'id_penilaian',
        'isi',
        'tanggal',
    ];

    // Relasi ke Penilaian (asumsi model Penilaian ada)
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'id_penilaian', 'id_penilaian');
    }
}
