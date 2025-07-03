<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    public $incrementing = true;
    protected $keyType = 'int';


    protected $fillable = [
        'judul',
        'slug',
        'gambar',
        'ringkasan',
        'isi_berita',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Slug otomatis saat membuat atau mengupdate.
     */
    protected static function booted()
    {
        static::creating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });

        static::updating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id_user');
    }

 public function getRouteKeyName()
{
    return 'slug';
}



}
