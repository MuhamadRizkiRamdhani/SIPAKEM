<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prodi;
use App\Models\Fakultas;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID fakultas berdasarkan nama (biar aman)
        $teknik = Fakultas::where('nama_fakultas', 'Fakultas Teknik')->first();
        $febi = Fakultas::where('nama_fakultas', 'Fakultas Ekonomi dan Bisnis Islam')->first();
        $fkom = Fakultas::where('nama_fakultas', 'Fakultas Komputer')->first();
        $faperta = Fakultas::where('nama_fakultas', 'Fakultas Pertanian')->first();
        $fkip = Fakultas::where('nama_fakultas', 'Fakultas Keguruan dan Ilmu Pendidikan')->first();

        Prodi::insert([
            // FTEK
            ['nama_prodi' => 'Teknik Informatika', 'id_fakultas' => $teknik->id_fakultas],
            ['nama_prodi' => 'Teknik Industri', 'id_fakultas' => $teknik->id_fakultas],

            // FEBI
            ['nama_prodi' => 'Manajemen Bisnis Syariah', 'id_fakultas' => $febi->id_fakultas],
            ['nama_prodi' => 'Perbankan Syariah', 'id_fakultas' => $febi->id_fakultas],

            // FKOM
            ['nama_prodi' => 'Sistem Informasi', 'id_fakultas' => $fkom->id_fakultas],
            ['nama_prodi' => 'Bisnis Digital', 'id_fakultas' => $fkom->id_fakultas],
            ['nama_prodi' => 'Komputerisasi Akuntansi', 'id_fakultas' => $fkom->id_fakultas],

            // FISIP
            ['nama_prodi' => 'Ilmu Komunikasi', 'id_fakultas' => $faperta->id_fakultas],
            ['nama_prodi' => 'Administrasi Publik', 'id_fakultas' => $faperta->id_fakultas],

            //FKIP
            ['nama_prodi' => 'Bimbingan Konseling', 'id_fakultas' => $fkip->id_fakultas],
            ['nama_prodi' => 'Pendidikan Bahasa Inggris', 'id_fakultas' => $fkip->id_fakultas],
        ]);
    }
}
