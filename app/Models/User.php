<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // 🔥 WAJIB ADA

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
        'role'
    ];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id_user');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_user');
    }

    public function pengelola()
    {
        return $this->hasOne(Pengelola::class, 'id_user');
    }
}
