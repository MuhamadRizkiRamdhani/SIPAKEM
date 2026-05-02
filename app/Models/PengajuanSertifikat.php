<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSertifikat extends Model
{
    protected $table = 'pengajuan_sertifikat';
    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'nim',
        'nama_sertifikat', // 🔥 WAJIB
        'file_path',
        'id_kategori',
        'id_sub_kategori',
        'id_level',
        'status',
        'tgl_pengajuan_sertifikat',
        'id_pengelola',
        'feedback',
        'id_rules',
        'poin_akhir'
    ];

    protected $casts = [
        'tgl_pengajuan_sertifikat' => 'date'
    ];

    // 🔗 RELASI
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }

    public function pengelola()
    {
        return $this->belongsTo(Pengelola::class, 'id_pengelola');
    }

    public function pointRules()
    {
        return $this->belongsTo(PointRules::class, 'id_rules');
    }

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
}
