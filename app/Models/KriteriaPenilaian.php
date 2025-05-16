<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    use HasFactory;

    // Nama tabel (defaultnya 'kriteria_penilaians', jadi kita override)
    protected $table = 'kriteria_penilaian';

    // Primary key kustom
    protected $primaryKey = 'id_kriteria';

    // Primary key auto increment
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Mass assignable fields
    protected $fillable = [
        'nama',
        'bobot',
    ];
}
