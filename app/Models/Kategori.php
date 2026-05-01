<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori'
    ];

    public function subKategori()
    {
        return $this->hasMany(SubKategori::class, 'id_kategori');
    }

    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'id_kategori');
    }

    public function pointRules()
    {
        return $this->hasMany(PointRules::class, 'id_kategori');
    }
}
