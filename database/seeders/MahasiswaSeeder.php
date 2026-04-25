<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodi = Prodi::first(); // ambil 1 prodi

        for ($i = 1; $i <= 5; $i++) {

            $user = User::create([
                'username' => 'mhs' . $i,
                'password' => Hash::make('password'),
                'role' => 'mahasiswa'
            ]);

            Mahasiswa::create([
                'nim' => '202300' . $i,
                'nama_mhs' => 'Mahasiswa ' . $i,
                'id_user' => $user->id_user,
                'id_prodi' => $prodi->id_prodi,
                'poin_kredit' => 0,
                'beasiswa' => false,
                'tahun_angkatan' => 2023
            ]);
        }
    }
}

