<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSertifikat extends Model
{
    protected $table = 'pengajuan_sertifikat';
    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'nim',
        'id_sertifikat',
        'status',
        'tgl_pengajuan_sertifikat',
        'id_pengelola',
        'feedback',
        'id_rules',
        'poin_akhir'
    ];

    protected $dates = [
        'tgl_pengajuan_sertifikat'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }

    public function sertifikat()
    {
        return $this->belongsTo(Sertifikat::class, 'id_sertifikat');
    }

    public function pengelola()
    {
        return $this->belongsTo(Pengelola::class, 'id_pengelola');
    }

    public function pointRules()
    {
        return $this->belongsTo(PointRules::class, 'id_rules');
    }
}
