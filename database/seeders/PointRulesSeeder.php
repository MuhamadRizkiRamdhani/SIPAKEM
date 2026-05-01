<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\Level;
use App\Models\PointRules;

class PointRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perlombaan = Kategori::where('nama_kategori', 'Perlombaan')->first();
        $organisasi = Kategori::where('nama_kategori', 'Organisasi')->first();

        $nasional = SubKategori::where('nama_sub_kategori', 'Nasional')->first();
        $internasional = SubKategori::where('nama_sub_kategori', 'Internasional')->first();
        $ketua = SubKategori::where('nama_sub_kategori', 'Ketua')->first();

        $juara1 = Level::where('nama_level', 'Juara 1')->first();
        $juara2 = Level::where('nama_level', 'Juara 2')->first();
        $peserta = Level::where('nama_level', 'Peserta')->first();

        PointRules::insert([
            // Perlombaan Nasional
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $nasional->id_sub_kategori,
                'id_level' => $juara1->id_level,
                'poin_akhir' => 100,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $nasional->id_sub_kategori,
                'id_level' => $juara2->id_level,
                'poin_akhir' => 80,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $nasional->id_sub_kategori,
                'id_level' => $peserta->id_level,
                'poin_akhir' => 30,
            ],

            // Perlombaan Internasional
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $internasional->id_sub_kategori,
                'id_level' => $juara1->id_level,
                'poin_akhir' => 150,
            ],

            // Organisasi Ketua (tanpa level)
            [
                'id_kategori' => $organisasi->id_kategori,
                'id_sub_kategori' => $ketua->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 70,
            ],
        ]);
    }
}
