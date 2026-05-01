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
            ['nama_kategori' => 'Perlombaan'],
            ['nama_kategori' => 'Organisasi'],
            ['nama_kategori' => 'Workshop'],
        ]);
    }
}
