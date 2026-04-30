@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @php
            $user = auth()->user();
            $userName = '';
            $userRole = ucfirst($user->role);

            if ($user->role === 'admin') {
                $userName = $user->admin->nama_admin ?? 'Admin';
            } elseif ($user->role === 'mahasiswa') {
                $userName = $user->mahasiswa->nama_mhs ?? 'Mahasiswa';
            } elseif ($user->role === 'pengelola') {
                $userName = $user->pengelola->nama_pengelola ?? 'Pengelola';
            }
        @endphp
        <h1>Selamat Datang {{ $userName }}</h1>
    </div>
@endsection