<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::insert([
            ['nama_kategori' => 'BEM'],
            ['nama_kategori' => 'DPM'],
            ['nama_kategori' => 'HIMA'],
            ['nama_kategori' => 'UKM'],
            ['nama_kategori' => 'MBKM/KEGIATAN LLDIKTI'],
            ['nama_kategori' => 'MAGANG'],
            ['nama_kategori' => 'SEMINAR'],
            ['nama_kategori' => 'PERLOMBAAN'],
            ['nama_kategori' => 'KEPANITIAAN ACARA'],
            ['nama_kategori' => 'WORKSHOP'],
            ['nama_kategori' => 'DELEGASI KAMPUS'],
        ]);
    }
}
