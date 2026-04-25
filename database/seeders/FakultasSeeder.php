<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fakultas;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fakultas::insert([
            ['nama_fakultas' => 'Fakultas Teknik'],
            ['nama_fakultas' => 'Fakultas Ekonomi dan Bisnis Islam'],
            ['nama_fakultas' => 'Fakultas Komputer'],
            ['nama_fakultas' => 'Fakultas Pertanian'],
            ['nama_fakultas' => 'Fakultas Keguruan dan Ilmu Pendidikan'],
        ]);
    }
}
