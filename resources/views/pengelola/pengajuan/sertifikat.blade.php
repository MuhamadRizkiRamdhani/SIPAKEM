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
                                <th>Prodi</th>
                                <th>Fakultas</th>
                                <th>File Sertifikat</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ahmad Baihaqi</td>
                                <td>53275531</td>
                                <td> Teknik Informatika</td>
                                <td> Fakultas Teknik</td>
                                <td> <button class="btn btn-info btn-sm">Lihat File</button>
                                </td>
                                <td>
                                    <span class="badge badge-primary">Disetujui</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Tinjau</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Ahmad Baihaqi</td>
                                <td>53275531</td>
                                <td> Teknik Informatika</td>
                                <td> Fakultas Teknik</td>
                                <td> <button class="btn btn-info btn-sm">Lihat File</button>
                                </td>
                                <td>
                                    <span class="badge badge-primary">Disetujui</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Tinjau</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Ahmad Baihaqi</td>
                                <td>53275531</td>
                                <td> Teknik Informatika</td>
                                <td> Fakultas Teknik</td>
                                <td> <button class="btn btn-info btn-sm">Lihat File</button>
                                </td>
                                <td>
                                    <span class="badge badge-primary">Disetujui</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Tinjau</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Ahmad Baihaqi</td>
                                <td>53275531</td>
                                <td> Teknik Informatika</td>
                                <td> Fakultas Teknik</td>
                                <td> <button class="btn btn-info btn-sm">Lihat File</button>
                                </td>
                                <td>
                                    <span class="badge badge-primary">Disetujui</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Tinjau</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Ahmad Baihaqi</td>
                                <td>53275531</td>
                                <td> Teknik Informatika</td>
                                <td> Fakultas Teknik</td>
                                <td> <button class="btn btn-info btn-sm">Lihat File</button>
                                </td>
                                <td>
                                    <span class="badge badge-primary">Disetujui</span>
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
@endsection