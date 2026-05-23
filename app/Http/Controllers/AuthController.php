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
            'username' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:5', 'max:50'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username harus diisi',
            'username.alpha' => 'Username hanya boleh huruf tanpa simbol',
            'username.min' => 'Username minimal 5 karakter',
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
                'nama_mahasiswa' => ['required', 'string', 'min:5', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],

                'username' => [
                    'required',
                    'string',
                    'min:10',
                    'max:50',
                    'unique:users,username',
                    'regex:/^[a-zA-Z\s]+$/'
                ],

                'password' => ['required', 'string', 'min:6'],

                'nim' => [
                    'required',
                    'digits_between:8,10',
                    'unique:mahasiswa,nim',
                    'regex:/^[a-zA-Z\s]+$/'
                ],

                'prodi' => ['required', 'exists:prodi,id_prodi'],

                'penerima_beasiswa' => ['required', 'boolean'],

                'tahun_angkatan' => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . date('Y'), 'regex:/^[a-zA-Z\s]+$/'],
            ], [
                'nama_mahasiswa.required' => 'Nama harus diisi',
                'nama_mahasiswa.min' => 'Nama minimal 5 karakter',
                'nama_mahasiswa.max' => 'Nama maksimal 50 karakter',

                'username.required' => 'Username harus diisi',
                'username.min' => 'Username minimal 10 karakter',
                'username.max' => 'Username maksimal 50 karakter',
                'username.unique' => 'Username sudah digunakan',

                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 6 karakter',

                'nim.required' => 'NIM harus diisi',
                'nim.digits_between' => 'NIM harus antara 8 sampai 10 digit',
                'nim.unique' => 'NIM sudah terdaftar',

                'prodi.required' => 'Program studi harus dipilih',
                'prodi.exists' => 'Prodi tidak valid',

                'penerima_beasiswa.required' => 'Status beasiswa harus dipilih',
                'tahun_angkatan.required' => 'Tahun angkatan harus diisi',
                'tahun_angkatan.digits' => 'Tahun angkatan harus 4 digit',
                'tahun_angkatan.integer' => 'Tahun angkatan harus berupa angka',
                'tahun_angkatan.min' => 'Tahun angkatan tidak valid',
                'tahun_angkatan.max' => 'Tahun angkatan tidak valid',
            ]);

            // BUAT USER
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa'
            ]);

            // BUAT MAHASISWA
            Mahasiswa::create([
                'nim' => $request->nim,
                'nama_mhs' => $request->nama_mahasiswa,
                'id_user' => $user->id_user,
                'id_prodi' => $request->prodi,
                'poin_kredit' => 0,
                'beasiswa' => (bool) $request->penerima_beasiswa,

                // AUTO (RECOMMENDED)
                'tahun_angkatan' => now()->year

                // ATAU kalau mau dari input:
                // 'tahun_angkatan' => $request->tahun_angkatan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan login.',
                'username' => $request->username
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
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
}
