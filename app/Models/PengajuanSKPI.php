<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSKPI extends Model
{
    protected $table = 'pengajuan_skpi';

    protected $primaryKey = 'id_pengajuan_skpi';

    protected $fillable = [
        'nim',
        'status',
        'tgl_pengajuan_skpi'
    ];

    protected $casts = [
        'tgl_pengajuan_skpi' => 'datetime'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
}