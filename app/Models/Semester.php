<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';
    protected $primaryKey = 'id'; // pastikan sesuai dengan DB
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'semester',
        'tahun',
    ];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'id_semester', 'id');
    }

    // di App\Models\Semester
public function getSemesterAttribute($value)
{
    return $value ? ucfirst($value) : null;
}


}
