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
        $bem = Kategori::where('nama_kategori', 'BEM')->first();
        $dpm = Kategori::where('nama_kategori', 'DPM')->first();
        $hima = Kategori::where('nama_kategori', 'HIMA')->first();
        $ukm = Kategori::where('nama_kategori', 'UKM')->first();
        $magang = Kategori::where('nama_kategori', 'MAGANG')->first();
        $seminar = Kategori::where('nama_kategori', 'SEMINAR')->first();
        $kepanitiaan = Kategori::where('nama_kategori', 'KEPANITIAAN ACARA')->first();
        $perlombaan = Kategori::where('nama_kategori', 'PERLOMBAAN')->first();
        $workshop = Kategori::where('nama_kategori', 'WORKSHOP')->first();


        SubKategori::insert([
            // BEM
            ['nama_sub_kategori' => 'Presiden Mahasiswa', 'id_kategori' => $bem->id_kategori],
            ['nama_sub_kategori' => 'Wakil Presiden Mahasiswa', 'id_kategori' => $bem->id_kategori],
            ['nama_sub_kategori' => 'Anggota', 'id_kategori' => $bem->id_kategori],

            // DPM
            ['nama_sub_kategori' => 'Ketua', 'id_kategori' => $dpm->id_kategori],
            ['nama_sub_kategori' => 'Pengurus', 'id_kategori' => $dpm->id_kategori],

            // HIMA
            ['nama_sub_kategori' => 'Ketua', 'id_kategori' => $hima->id_kategori],
            ['nama_sub_kategori' => 'Pengurus', 'id_kategori' => $hima->id_kategori],

            // UKM
            ['nama_sub_kategori' => 'Ketua', 'id_kategori' => $ukm->id_kategori],
            ['nama_sub_kategori' => 'Anggota', 'id_kategori' => $ukm->id_kategori],

            // Magang
            ['nama_sub_kategori' => 'Internal', 'id_kategori' => $magang->id_kategori],
            ['nama_sub_kategori' => 'Eksternal', 'id_kategori' => $magang->id_kategori],

            // Seminar
            ['nama_sub_kategori' => 'Internal', 'id_kategori' => $seminar->id_kategori],
            ['nama_sub_kategori' => 'Eksternal', 'id_kategori' => $seminar->id_kategori],

            // Perlombaan
            ['nama_sub_kategori' => 'Internasional', 'id_kategori' => $perlombaan->id_kategori],
            ['nama_sub_kategori' => 'Nasional', 'id_kategori' => $perlombaan->id_kategori],
            ['nama_sub_kategori' => 'Provinsi', 'id_kategori' => $perlombaan->id_kategori],
            ['nama_sub_kategori' => 'Kabupaten/Kota', 'id_kategori' => $perlombaan->id_kategori],

            // Kepanitiaan Acara
            ['nama_sub_kategori' => 'Ketua', 'id_kategori' => $kepanitiaan->id_kategori],
            ['nama_sub_kategori' => 'Anggota', 'id_kategori' => $kepanitiaan->id_kategori],

            //Workshop
            ['nama_sub_kategori' => 'Internal', 'id_kategori' => $workshop->id_kategori],
            ['nama_sub_kategori' => 'Eksternal', 'id_kategori' => $workshop->id_kategori],
        ]);
    }
}
