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
                        <h4 class="font-weight-normal mb-3">Total Poin <i
                                class="mdi mdi-star-four-points-outline mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-3">{{ $totalPoin }}/{{ $maxPoin }}</h2>
                        <div class="progress mb-3" style="height: 5px;">
                            <div class="progress-bar" role="progressbar"
                                style="width: {{ min(($totalPoin / $maxPoin) * 100, 100) }}%;"
                                aria-valuenow="{{ $totalPoin }}" aria-valuemin="0" aria-valuemax="{{ $maxPoin }}"></div>
                        </div>
                        <small class="text-white">
                            {{ $mahasiswa->beasiswa ? 'Penerima Beasiswa (Min Capaian 150 Poin)' : 'Bukan Penerima Beasiswa (Min Capaian 100 Poin)' }}
                        </small>
                        <br>
                        <a href="{{ route('mahasiswa.pengajuan-skpi') }}" class="btn btn-light mt-2">
                            Ajukan SKPI
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Pengajuan disetujui <i
                                class="mdi mdi-check-decagram-outline mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5">{{ $totalApproved }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Ajukan Sertifikat <i
                                class="mdi mdi-receipt-send-outline mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5">Ajukan sertifikat anda</h2>
                        <a href="{{ route('mahasiswa.pengajuan-sertifikat') }}" class="btn btn-light">
                            Ajukan Sertifikat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5 grid-margin ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Panduan Pengajuan</h4>
                        <p class="card-description">
                            Berikut adalah panduan untuk melakukan pengajuan sertifikat dan SKPI.
                        </p>
                        <button class="btn btn-primary">Baca Panduan</button>
                    </div>
                </div>
            </div>
            <div class="col-md-7 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Status Pengajuan</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Jenis Pengajuan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statusPengajuan as $item)
                                    <tr>
                                        <td>{{ $item->jenis }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y')}}</td>
                                        <td>
                                            @if($item->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($item->status === 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($item->status === 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada pengajuan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

@endsection