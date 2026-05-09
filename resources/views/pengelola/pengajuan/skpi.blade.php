@extends('layouts.app')

@section('content')
    <h1>Data Pengajuan SKPI</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Pengajuan SKPI</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <button type="button" class="btn btn-sm btn-success ">Export PDF</button>
                    </div>
                    </p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>Fakultas</th>
                                    <th>Poin Kredit</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuanSKPIs as $psk)
                                    <tr>
                                        <td>{{ $psk->mahasiswa->nama_mhs ?? '-' }}</td>
                                        <td>{{ $psk->nim }}</td>
                                        <td>{{ $psk->mahasiswa->prodi->nama_prodi ?? '-' }}</td>
                                        <td>{{ $psk->mahasiswa->prodi->fakultas->nama_fakultas ?? '-' }}</td>
                                        <td>{{ $psk->mahasiswa->poin_kredit ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $psk->status === 'diterima' ? 'success' : ($psk->status === 'ditolak' ? 'danger' : ($psk->status === 'diproses' ? 'warning' : 'secondary')) }}">
                                                {{ $psk->status }}
                                            </span>
                                        </td>
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
    </div>
@endsection