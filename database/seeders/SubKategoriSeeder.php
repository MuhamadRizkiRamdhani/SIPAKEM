<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\SubKategori;

class SubKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perlombaan = Kategori::where('nama_kategori', 'Perlombaan')->first();
        $organisasi = Kategori::where('nama_kategori', 'Organisasi')->first();

        SubKategori::insert([
            // Perlombaan
            ['nama_sub_kategori' => 'Nasional', 'id_kategori' => $perlombaan->id_kategori],
            ['nama_sub_kategori' => 'Internasional', 'id_kategori' => $perlombaan->id_kategori],

            // Organisasi
            ['nama_sub_kategori' => 'Ketua', 'id_kategori' => $organisasi->id_kategori],
            ['nama_sub_kategori' => 'Anggota', 'id_kategori' => $organisasi->id_kategori],
        ]);
    }
}
