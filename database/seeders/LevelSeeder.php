<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Level::insert([
            ['nama_level' => 'Juara 1'],
            ['nama_level' => 'Juara 2'],
            ['nama_level' => 'Juara 3'],
            ['nama_level' => 'Peserta'],
        ]);
    }
}
