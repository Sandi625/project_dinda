<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    // Nama tabel (opsional, jika nama model dan tabel berbeda)
    protected $table = 'semester';

    // Kolom yang boleh diisi (jika ingin pakai mass assignment)
    protected $fillable = [
        'semester',
        'tahun',
    ];



    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'id_semester', 'id');
    }

}
