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
                        <h2 class="mb-5">{{ $totalMahasiswa }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Pengelola Sistem <i
                                class="mdi mdi-security mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5">{{ $totalPengelola }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Pengajuan <i
                                class="mdi mdi-note-check-outline mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5">{{ $totalPengajuan }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-15 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Permintaan Pengajuan Terbaru</h4>
                        <div class="table-responsive" style="max-height: 260px; overflow-y: auto;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th>Sertifikat</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengajuanTerbaru as $p)
                                        <tr>
                                            <td>{{ $p->mahasiswa->nama_mhs ?? '-' }}</td>
                                            <td>{{ $p->nim }}</td>
                                            <td>{{ $p->nama_sertifikat }}</td>
                                            <td>{{ \Carbon\Carbon::parse($p->tgl_pengajuan_sertifikat)->format('d-m-Y') }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $p->status === 'diterima' ? 'success' : ($p->status === 'ditolak' ? 'danger' : ($p->status === 'diproses' ? 'warning' : 'secondary')) }}">
                                                    {{ $p->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center"><em>Belum ada data</em></td>
                                        </tr>
                                    @endforelse
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
                                        <th>Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($top5Mahasiswa as $m)
                                        <tr>
                                            <td>{{ $m->nama_mhs }}</td>
                                            <td>{{ $m->nim }}</td>
                                            <td>{{ $m->prodi->nama_prodi ?? '-' }}</td>
                                            <td>{{ $m->poin_kredit }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center"><em>Belum ada data</em></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection