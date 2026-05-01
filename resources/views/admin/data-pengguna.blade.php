@extends('layouts.app')

@section('content')
    <h1>Data Pengguna</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Pengguna</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <button type="button" class="btn btn-sm btn-primary ">Tambah Pengguna</button>
                    </div>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>ID_User</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Super Admin</td>
                                <td>1</td>
                                <td>
                                    <span class="badge badge-primary">admin</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">OTP</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>pengelola1</td>
                                <td>2</td>
                                <td>
                                    <span class="badge badge-warning">pengelola</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">OTP</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Muhamad Rizki Ramdhani</td>
                                <td>3</td>
                                <td>
                                    <span class="badge badge-danger">mahasiswa</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm">OTP</button>
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