@extends('layouts.app')

@section('content')
    <h1>Data Fakultas & Program Studi</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Fakultas & Program Studi</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <button type="button" class="btn btn-sm btn-primary ">Tambah Fakultas</button>
                    </div>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Fakultas</th>
                                <th>ID_Fakultas</th>
                                <th>Program Studi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Fakultas Teknik</td>
                                <td>0001</td>
                                <td>Informatika <br>
                                    Industri<br>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Fakultas Teknik</td>
                                <td>0001</td>
                                <td>Informatika <br>
                                    Industri<br>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Fakultas Teknik</td>
                                <td>0001</td>
                                <td>Informatika <br>
                                    Industri<br>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Fakultas Teknik</td>
                                <td>0001</td>
                                <td>Informatika <br>
                                    Industri<br>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Fakultas Teknik</td>
                                <td>0001</td>
                                <td>Informatika <br>
                                    Industri<br>
                                </td>
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