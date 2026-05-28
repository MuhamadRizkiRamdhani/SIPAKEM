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
        // Kategori
        $bem = Kategori::where('nama_kategori', 'BEM')->first();
        $dpm = Kategori::where('nama_kategori', 'DPM')->first();
        $hima = Kategori::where('nama_kategori', 'HIMA')->first();
        $ukm = Kategori::where('nama_kategori', 'UKM')->first();
        $magang = Kategori::where('nama_kategori', 'MAGANG')->first();
        $mbkm = Kategori::where('nama_kategori', 'MBKM/KEGIATAN LLDIKTI')->first();
        $seminar = Kategori::where('nama_kategori', 'SEMINAR')->first();
        $kepanitiaan = Kategori::where('nama_kategori', 'KEPANITIAAN ACARA')->first();
        $perlombaan = Kategori::where('nama_kategori', 'PERLOMBAAN')->first();
        $workshop = Kategori::where('nama_kategori', 'WORKSHOP')->first();
        $delegasi = Kategori::where('nama_kategori', 'DELEGASI KAMPUS')->first();

        // Sub
        $nasional = SubKategori::where('nama_sub_kategori', 'Nasional')->first();
        $internasional = SubKategori::where('nama_sub_kategori', 'Internasional')->first();
        $provinsi = SubKategori::where('nama_sub_kategori', 'Provinsi')->first();
        $kabupaten = SubKategori::where('nama_sub_kategori', 'Kabupaten/Kota')->first();
        $ketua = SubKategori::where('nama_sub_kategori', 'Ketua')->first();
        $pengurus_hima = SubKategori::where('nama_sub_kategori', 'Pengurus')->first();
        $anggota = SubKategori::where('nama_sub_kategori', 'Anggota')->first();
        $presma = SubKategori::where('nama_sub_kategori', 'Presiden Mahasiswa')->first();
        $wakil_presma = SubKategori::where('nama_sub_kategori', 'Wakil Presiden Mahasiswa')->first();
        $anggota_bem = SubKategori::where('nama_sub_kategori', 'Anggota')->where('id_kategori', $bem->id_kategori)->first();
        $ketua_dpm = SubKategori::where('nama_sub_kategori', 'Ketua')->where('id_kategori', $dpm->id_kategori)->first();
        $pengurus_dpm = SubKategori::where('nama_sub_kategori', 'Pengurus')->where('id_kategori', $dpm->id_kategori)->first();
        $internal = SubKategori::where('nama_sub_kategori', 'Internal')->first();
        $eksternal = SubKategori::where('nama_sub_kategori', 'Eksternal')->first();

        // Level
        $juara1 = Level::where('nama_level', 'Juara 1')->first();
        $juara2 = Level::where('nama_level', 'Juara 2')->first();
        $juara3 = Level::where('nama_level', 'Juara 3')->first();
        $peserta = Level::where('nama_level', 'Peserta')->first();

        PointRules::insert([
            // BEM
            [
                'id_kategori' => $bem->id_kategori,
                'id_sub_kategori' => $presma->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 50,
            ],
            [
                'id_kategori' => $bem->id_kategori,
                'id_sub_kategori' => $wakil_presma->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 40,
            ],
            [
                'id_kategori' => $bem->id_kategori,
                'id_sub_kategori' => $anggota_bem->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 30,
            ],

            // DPM
            [
                'id_kategori' => $dpm->id_kategori,
                'id_sub_kategori' => $ketua_dpm->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 40,
            ],
            [
                'id_kategori' => $dpm->id_kategori,
                'id_sub_kategori' => $pengurus_dpm->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 20,
            ],

            // HIMA
            [
                'id_kategori' => $hima->id_kategori,
                'id_sub_kategori' => $ketua->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 40,
            ],
            [
                'id_kategori' => $hima->id_kategori,
                'id_sub_kategori' => $pengurus_hima->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 20,
            ],

            // UKM
            [
                'id_kategori' => $ukm->id_kategori,
                'id_sub_kategori' => $ketua->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 30,
            ],
            [
                'id_kategori' => $ukm->id_kategori,
                'id_sub_kategori' => $anggota->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 20,
            ],

            //MBKM
            [
                'id_kategori' => $mbkm->id_kategori,
                'id_sub_kategori' => null,
                'id_level' => null,
                'poin_akhir' => 50,
            ],

            //Magang
            [
                'id_kategori' => $magang->id_kategori,
                'id_sub_kategori' => $internal->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 25,
            ],
            [
                'id_kategori' => $magang->id_kategori,
                'id_sub_kategori' => $eksternal->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 30,
            ],

            //Seminar
            [
                'id_kategori' => $seminar->id_kategori,
                'id_sub_kategori' => $internal->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 20,
            ],
            [
                'id_kategori' => $seminar->id_kategori,
                'id_sub_kategori' => $eksternal->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 15,
            ],

            // Kepanitiaan Acara
            [
                'id_kategori' => $kepanitiaan->id_kategori,
                'id_sub_kategori' => $ketua->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 25,
            ],
            [
                'id_kategori' => $kepanitiaan->id_kategori,
                'id_sub_kategori' => $anggota->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 20,
            ],

            // Workshop
            [
                'id_kategori' => $workshop->id_kategori,
                'id_sub_kategori' => $internal->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 20,
            ],
            [
                'id_kategori' => $workshop->id_kategori,
                'id_sub_kategori' => $eksternal->id_sub_kategori,
                'id_level' => null,
                'poin_akhir' => 25,
            ],

            // Delegasi
            [
                'id_kategori' => $delegasi->id_kategori,
                'id_sub_kategori' => null,
                'id_level' => null,
                'poin_akhir' => 25,
            ],

            // Perlombaan Nasional
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $nasional->id_sub_kategori,
                'id_level' => $juara1->id_level,
                'poin_akhir' => 30,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $nasional->id_sub_kategori,
                'id_level' => $juara2->id_level,
                'poin_akhir' => 30,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $nasional->id_sub_kategori,
                'id_level' => $juara3->id_level,
                'poin_akhir' => 30,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $nasional->id_sub_kategori,
                'id_level' => $peserta->id_level,
                'poin_akhir' => 10,
            ],

            // Perlombaan Internasional
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $internasional->id_sub_kategori,
                'id_level' => $juara1->id_level,
                'poin_akhir' => 40,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $internasional->id_sub_kategori,
                'id_level' => $juara2->id_level,
                'poin_akhir' => 40,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $internasional->id_sub_kategori,
                'id_level' => $juara3->id_level,
                'poin_akhir' => 40,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $internasional->id_sub_kategori,
                'id_level' => $peserta->id_level,
                'poin_akhir' => 20,
            ],

            // Perlombaan Provinsi
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $provinsi->id_sub_kategori,
                'id_level' => $juara1->id_level,
                'poin_akhir' => 25,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $provinsi->id_sub_kategori,
                'id_level' => $juara2->id_level,
                'poin_akhir' => 25,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $provinsi->id_sub_kategori,
                'id_level' => $juara3->id_level,
                'poin_akhir' => 25,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $provinsi->id_sub_kategori,
                'id_level' => $peserta->id_level,
                'poin_akhir' => 10,
            ],

            // Perlombaan Kabupaten/Kota
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $kabupaten->id_sub_kategori,
                'id_level' => $juara1->id_level,
                'poin_akhir' => 20,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $kabupaten->id_sub_kategori,
                'id_level' => $juara2->id_level,
                'poin_akhir' => 20,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $kabupaten->id_sub_kategori,
                'id_level' => $juara3->id_level,
                'poin_akhir' => 20,
            ],
            [
                'id_kategori' => $perlombaan->id_kategori,
                'id_sub_kategori' => $kabupaten->id_sub_kategori,
                'id_level' => $peserta->id_level,
                'poin_akhir' => 10,
            ],
        ]);
    }
}
