<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    // Nama tabel jika tidak sesuai konvensi (default 'gurus')
    protected $table = 'guru';

    // Primary key yang bukan 'id'
    protected $primaryKey = 'id_guru';

    // Jika primary key bertipe integer dan auto increment (default true)
    public $incrementing = true;

    // Jika primary key bukan bertipe integer, ubah ke false (tidak perlu jika integer)
    protected $keyType = 'int';

    // Mass assignable fields
    protected $fillable = [
        'id_user',
        'nip',
        'nama',
        'alamat',
    ];

    // Relasi ke User (assuming model User ada di App\Models\User)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function penilaian()
{
    return $this->hasMany(Penilaian::class, 'id_guru', 'id_guru');
}

}
