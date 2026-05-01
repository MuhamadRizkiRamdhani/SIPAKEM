<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Mahasiswa;
use App\Models\Pengelola;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login dengan data fakultas dan prodi
     */
    public function showLogin()
    {
        // Ambil semua fakultas
        $fakultasData = Fakultas::select('id_fakultas as id', 'nama_fakultas as nama')->get();

        // Ambil semua prodi dan kelompokkan by fakultas
        $prodiMap = [];
        $prodiList = Prodi::select('id_prodi', 'id_fakultas', 'nama_prodi')->get();

        foreach ($prodiList as $prodi) {
            $fakultasId = $prodi->id_fakultas;
            if (!isset($prodiMap[$fakultasId])) {
                $prodiMap[$fakultasId] = [];
            }
            $prodiMap[$fakultasId][] = [
                'value' => $prodi->id_prodi,
                'label' => $prodi->nama_prodi
            ];
        }

        return view('auth.login', [
            'fakultasData' => $fakultasData,
            'prodiMap' => $prodiMap
        ]);
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username harus diisi',
            'username.alpha' => 'Username hanya boleh huruf tanpa simbol',
            'username.max' => 'Username maksimal 50 karakter',
            'password.required' => 'Password harus diisi',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah'
            ], 401);
        }

        // Generate session atau token jika menggunakan API
        auth()->login($user);

        // Return user data dengan role
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'user' => [
                'id' => $user->id_user,
                'username' => $user->username,
                'role' => $user->role
            ],
            'redirect' => $this->getDashboardUrl($user->role)
        ]);
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'nama_mahasiswa' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],

                'username' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50', 'unique:users,username'],

                'password' => ['required', 'string', 'min:6'],

                'nim' => ['required', 'digits_between:1,10', 'unique:mahasiswa,nim'],

                'fakultas' => ['required', 'string'],

                'prodi' => ['required', 'numeric'],

                'penerima_beasiswa' => ['required', 'boolean'],
            ], [
                'nama_mahasiswa.regex' => 'Nama hanya boleh huruf dan spasi',

                'username.alpha' => 'Username hanya boleh huruf tanpa simbol',
                'username.max' => 'Username maksimal 50 karakter',
                'username.unique' => 'Username sudah digunakan',

                'nim.digits_between' => 'NIM harus berupa angka maksimal 10 digit',
                'nim.unique' => 'NIM sudah terdaftar',
            ]);

            // Buat user dengan role mahasiswa
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa'
            ]);

            // Buat data mahasiswa
            Mahasiswa::create([
                'nim' => $request->nim,
                'nama_mhs' => $request->nama_mahasiswa,
                'id_user' => $user->id_user,
                'id_prodi' => $request->prodi,
                'poin_kredit' => 0,
                'beasiswa' => $request->penerima_beasiswa ? true : false,
                'tahun_angkatan' => now()->year
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan login.',
                'username' => $request->username
            ]);
        } catch (ValidationException $e) {
            Log::warning('Register validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Register error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('message', 'Logout berhasil');
    }

    /**
     * Get dashboard URL berdasarkan role
     */
    private function getDashboardUrl($role)
    {
        return match ($role) {
            'admin' => '/admin/dashboard',
            'mahasiswa' => '/mahasiswa/dashboard',
            'pengelola' => '/pengelola/dashboard',
            default => '/'
        };
    }

    /**
     * Generate NIM (Nomor Induk Mahasiswa)
     * Format: YYYYNNNN (tahun + angka urut)
     */
    // private function generateNIM()
    // {
    //     $year = now()->year;
    //     $lastMahasiswa = Mahasiswa::where('nim', 'like', $year . '%')
    //         ->orderBy('nim', 'desc')
    //         ->first();

    //     if ($lastMahasiswa) {
    //         $lastNum = (int) substr($lastMahasiswa->nim, 4);
    //         $newNum = $lastNum + 1;
    //     } else {
    //         $newNum = 1;
    //     }

    //     return $year . str_pad($newNum, 4, '0', STR_PAD_LEFT);
    // }
}
