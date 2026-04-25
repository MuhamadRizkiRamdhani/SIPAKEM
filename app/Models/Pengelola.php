<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengelola extends Model
{
    protected $table = 'pengelola'; // 🔥 WAJIB
    protected $primaryKey = 'id_pengelola';

    protected $fillable = [
        'nama_pengelola',
        'id_user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
