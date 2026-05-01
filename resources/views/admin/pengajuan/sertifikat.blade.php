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
                                <th>Sertifikat</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanSertifikats as $ps)
                                <tr>
                                    <td>{{ $ps->mahasiswa->nama_mhs ?? '-' }}</td>
                                    <td>{{ $ps->nim }}</td>
                                    <td>{{ $ps->sertifikat->nama_sertifikat ?? '-' }}</td>
                                    <td>{{ $ps->tgl_pengajuan_sertifikat }}</td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $ps->status === 'diterima' ? 'success' : ($ps->status === 'ditolak' ? 'danger' : ($ps->status === 'diproses' ? 'warning' : 'secondary')) }}">
                                            {{ $ps->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Tinjau</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center"><em>Belum ada data</em></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection