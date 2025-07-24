<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKinerjaDetail extends Model
{
    use HasFactory;

    protected $table = 'laporan_kinerja_detail';

    protected $fillable = [
        'laporan_kinerja_id',
        'kategori',
        'indikator',
        'keterangan',
        'file_bukti',
        // 'poin',
        'created_at',
        'updated_at',
    ];

    // Relasi ke laporan utama
    public function laporan()
    {
        return $this->belongsTo(LaporanKinerja::class, 'laporan_kinerja_id');
    }
}
