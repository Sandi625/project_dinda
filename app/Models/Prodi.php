<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi'; // Nama tabel (opsional, bisa dihapus jika sesuai konvensi)

    protected $fillable = [
        'nama_prodi',
    ];


public function guru()
{
    return $this->hasMany(Guru::class); // Default foreign key: prodi_id
}


}
