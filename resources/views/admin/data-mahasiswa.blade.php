@extends('layouts.app')

@section('content')
    <h1>Data Mahasiswa</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Mahasiswa</h4>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <th>NIM</th>
                                <th>Prodi</th>
                                <th>Fakultas</th>
                                <th>Poin Kredit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Jacob</td>
                                <td>53275531</td>
                                <td> Teknik Informatika</td>
                                <td> Fakultas Teknik</td>
                                <td> 85</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Jacob</td>
                                <td>53275531</td>
                                <td> Teknik Informatika</td>
                                <td> Fakultas Teknik</td>
                                <td> 85</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Jacob</td>
                                <td>53275531</td>
                                <td> Teknik Informatika</td>
                                <td> Fakultas Teknik</td>
                                <td> 85</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Jacob</td>
                                <td>53275531</td>
                                <td> Teknik Informatika</td>
                                <td> Fakultas Teknik</td>
                                <td> 85</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Jacob</td>
                                <td>53275531</td>
                                <td> Teknik Informatika</td>
                                <td> Fakultas Teknik</td>
                                <td> 85</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
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