@extends('layouts.app')

@section('content')
    <h1>Riwayat Pengajuan</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Riwayat Pengajuan</h4>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Sertifikat</th>
                                <th>ID_Pengajuan</th>
                                <th>Jenis Pengajuan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lomba Mancing</td>
                                <td>0001</td>
                                <td>Sertifikat</td>
                                <td>
                                    <span class="badge badge-primary">Disetujui</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Tinjau</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Pengajuan SKPI</td>
                                <td>0002</td>
                                <td>SKPI</td>
                                <td>
                                    <span class="badge badge-danger">Ditolak</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Tinjau</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection