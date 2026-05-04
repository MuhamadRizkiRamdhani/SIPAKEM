<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    protected $table = 'sub_kategori';
    protected $primaryKey = 'id_sub_kategori';

    protected $fillable = [
        'nama_sub_kategori',
        'id_kategori'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // public function sertifikat()
    // {
    //     return $this->hasMany(Sertifikat::class, 'id_sub_kategori');
    // }

    public function pointRules()
    {
        return $this->hasMany(PointRules::class, 'id_sub_kategori');
    }
}
