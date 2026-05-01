<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FakultasSeeder::class,
            ProdiSeeder::class,
            AdminSeeder::class,
            PengelolaSeeder::class,
            KategoriSeeder::class,
            SubKategoriSeeder::class,
            LevelSeeder::class,
            PointRulesSeeder::class,
            // MahasiswaSeeder::class,
        ]);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
