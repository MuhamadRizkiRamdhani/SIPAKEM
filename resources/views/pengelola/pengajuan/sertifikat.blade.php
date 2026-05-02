@extends('layouts.app')

@section('content')
    <h1>Data Pengajuan Sertifikat</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Pengajuan Sertifikat</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <button type="button" class="btn btn-sm btn-success ">Export PDF</button>
                    </div>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <th>NIM</th>
                                <th>Nama Sertifikat</th>
                                <th>File Sertifikat</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanSertifikats as $ps)
                                <tr>
                                    <!-- Nama Mahasiswa -->
                                    <td>{{ $ps->mahasiswa->nama_mhs ?? '-' }}</td>

                                    <!-- NIM -->
                                    <td>{{ $ps->nim }}</td>

                                    <!-- Nama Sertifikat -->
                                    <td>{{ $ps->nama_sertifikat }}</td>

                                    <!-- File Sertifikat -->
                                    <td>
                                        @if($ps->file_path)
                                            <a href="{{ asset('storage/' . $ps->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-info">
                                                Lihat File
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <!-- Tanggal -->
                                    <td>{{ \Carbon\Carbon::parse($ps->tgl_pengajuan_sertifikat)->format('d-m-Y') }}</td>

                                    <!-- Status -->
                                    <td>
                                        <span
                                            class="badge badge-{{ $ps->status === 'diterima' ? 'success' : ($ps->status === 'ditolak' ? 'danger' : ($ps->status === 'diproses' ? 'warning' : 'secondary')) }}">
                                            {{ $ps->status }}
                                        </span>
                                    </td>

                                    <!-- Action -->
                                    <td>
                                        <button class="btn btn-primary btn-sm">Tinjau</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center"><em>Belum ada data</em></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection