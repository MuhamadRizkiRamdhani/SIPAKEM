<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointRules extends Model
{
    protected $table = 'point_rules';
    protected $primaryKey = 'id_rules';

    protected $fillable = [
        'id_kategori',
        'id_sub_kategori',
        'id_level',
        'poin_akhir'
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
        return $this->hasMany(PengajuanSertifikat::class, 'id_rules');
    }
}
