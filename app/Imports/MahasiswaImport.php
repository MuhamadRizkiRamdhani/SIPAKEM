<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToCollection, WithHeadingRow
{
    public array $importErrors = [];
    public int $successCount = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNum = $index + 2;

            try {
                if (empty($row['nim']) || empty($row['nama_mhs']) || empty($row['username']) || empty($row['id_prodi'])) {
                    $this->importErrors[] = "Baris {$rowNum}: Kolom nim, nama_mhs, username, id_prodi wajib diisi.";
                    continue;
                }

                if (Mahasiswa::where('nim', $row['nim'])->exists()) {
                    $this->importErrors[] = "Baris {$rowNum}: NIM {$row['nim']} sudah terdaftar.";
                    continue;
                }

                if (!Prodi::where('id_prodi', $row['id_prodi'])->exists()) {
                    $this->importErrors[] = "Baris {$rowNum}: id_prodi {$row['id_prodi']} tidak ditemukan.";
                    continue;
                }

                $user = User::firstOrCreate(
                    ['username' => $row['username']],
                    [
                        'password' => Hash::make($row['password'] ?? '12345678'),
                        'role' => 'mahasiswa',
                    ]
                );

                if (Mahasiswa::where('id_user', $user->id_user)->exists()) {
                    $this->importErrors[] = "Baris {$rowNum}: Username {$row['username']} sudah terhubung ke mahasiswa lain.";
                    continue;
                }

                Mahasiswa::create([
                    'nim' => $row['nim'],
                    'nama_mhs' => $row['nama_mhs'],
                    'id_user' => $user->id_user,
                    'id_prodi' => $row['id_prodi'],
                    'poin_kredit' => $row['poin_kredit'] ?? 0,
                    'tahun_angkatan' => $row['tahun_angkatan'],
                    'beasiswa' => $row['beasiswa'] ?? 0,
                ]);

                $this->successCount++;

            } catch (\Exception $e) {
                $this->importErrors[] = "Baris {$rowNum}: " . $e->getMessage();
            }
        }
    }
}