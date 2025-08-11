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
        'id_user',
        'id_kelas',
        'id_mapel',
        'tanggal',
        'id_semester',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'semester' => 'string', // opsional, tergantung kebutuhan
    ];

    // ❌ Relasi ke guru dihapus
    // public function guru()
    // {
    //     return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    // }

    // ✅ Relasi ke user (guru via users)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

//     public function user()
// {
//     return $this->belongsTo(User::class, 'user_id'); // asumsinya 'user_id' adalah foreign key
// }


   public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }






    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id');
    }

    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'id_penilaian', 'id_penilaian');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'id_penilaian', 'id_penilaian');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'id_penilaian', 'id_penilaian');
    }

// App\Models\Penilaian.php

public function semester()
{
    return $this->belongsTo(Semester::class, 'id_semester', 'id');
}







// public function semester()
// {
//     return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
// }



    // App\Models\Penilaian.php

// public function semester()
// {
//     return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
// }




// User.php
public function mapels()
{
    return $this->hasMany(Mapel::class, 'user_id'); // tanpa pivot
}





}

