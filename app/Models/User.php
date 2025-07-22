<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Pastikan extend-nya benar

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];




    // App\Models\User.php
public function profile()
{
    return $this->hasOne(Profile::class, 'user_id', 'id_user'); // sesuaikan foreign key
}

// App\Models\User.php
public function guru()
{
    return $this->hasOne(Guru::class, 'id_user', 'id_user');
}




}
