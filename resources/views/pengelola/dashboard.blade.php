@extends('layouts.app')

@section('content')

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

    <h3 class="mb-4">Selamat Datang {{ $userName }}</h3>

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
        </h3>
    </div>

    <div class="row">
        <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Mahasiswa <i
                                class="mdi mdi-account-school mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5">nanti ganti pake query</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Pengajuan Sertifikat <i
                                class="mdi mdi-certificate-outline mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5">nanti ganti pake query</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Pengajuan SKPI <i
                                class="mdi mdi-note-check-outline mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5">nanti ganti pake query</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-15 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Permintaan Pengajuan</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th>Prodi</th>
                                        <th>Fakultas</th>
                                        <th>File Sertifikat</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Joko</td>
                                        <td>53275531</td>
                                        <td> Teknik Informatika</td>
                                        <td> Fakultas Teknik</td>
                                        <td> <button class="btn btn-info btn-sm">Lihat File</button>
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">Pending</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm">Tinjau</button>
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Joko</td>
                                        <td>53275531</td>
                                        <td> Teknik Informatika</td>
                                        <td> Fakultas Teknik</td>
                                        <td> <button class="btn btn-info btn-sm">Lihat File</button>
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">Pending</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm">Tinjau</button>
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Joko</td>
                                        <td>53275531</td>
                                        <td> Teknik Informatika</td>
                                        <td> Fakultas Teknik</td>
                                        <td> <button class="btn btn-info btn-sm">Lihat File</button>
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">Pending</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm">Tinjau</button>
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Top 5 Mahasiswa Poin Tertinggi</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Program Studi</th>
                                        <th>Fakultas</th>
                                        <th>Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Agus</td>
                                        <td>53275531</td>
                                        <td> Teknik Informatika</td>
                                        <td> Fakultas Teknik</td>
                                        <td> 95</td>
                                    </tr>
                                    <tr>
                                        <td>Agus</td>
                                        <td>53275531</td>
                                        <td> Teknik Informatika</td>
                                        <td> Fakultas Teknik</td>
                                        <td> 95</td>
                                    </tr>
                                    <tr>
                                        <td>Agus</td>
                                        <td>53275531</td>
                                        <td> Teknik Informatika</td>
                                        <td> Fakultas Teknik</td>
                                        <td> 95</td>
                                    </tr>
                                    <tr>
                                        <td>Agus</td>
                                        <td>53275531</td>
                                        <td> Teknik Informatika</td>
                                        <td> Fakultas Teknik</td>
                                        <td> 95</td>
                                    </tr>
                                    <tr>
                                        <td>Agus</td>
                                        <td>53275531</td>
                                        <td> Teknik Informatika</td>
                                        <td> Fakultas Teknik</td>
                                        <td> 95</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection