<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';
    protected $primaryKey = 'id_sertifikat';

    protected $fillable = [
        'nama_sertifikat',
        'file_sertifikat',
        'id_kategori',
        'id_sub_kategori',
        'id_level'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function subKategori()
    {
        return $this->belongsTo(SubKategori::class, 'id_sub_kategori');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level');
    }

    public function pengajuanSertifikat()
    {
        return $this->hasMany(PengajuanSertifikat::class, 'id_sertifikat');
    }
}
