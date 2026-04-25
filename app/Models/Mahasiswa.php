<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa'; // 🔥 WAJIB
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama_mhs',
        'id_user',
        'id_prodi',
        'poin_kredit',
        'beasiswa',
        'tahun_angkatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }
}
