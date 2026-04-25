<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pengelola;
use Illuminate\Support\Facades\Hash;

class PengelolaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'pengelola1',
            'password' => Hash::make('pengelola123'),
            'role' => 'pengelola'
        ]);

        Pengelola::create([
            'nama_pengelola' => 'Pengelola Sistem',
            'id_user' => $user->id_user
        ]);
    }
}
