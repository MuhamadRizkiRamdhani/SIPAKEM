@extends('layouts.app')

@section('content')
    <h1>Data Pengelola</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Pengelola</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <button type="button" class="btn btn-sm btn-primary ">Tambah Pengelola</button>
                        <button type="button" class="btn btn-sm btn-success ">Export PDF</button>
                    </div>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Pengelola</th>
                                <th>ID_Pengelola</th>
                                <th>Username</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengelolas as $pg)
                                <tr>
                                    <td>{{ $pg->nama_pengelola }}</td>
                                    <td>{{ $pg->id_pengelola }}</td>
                                    <td>{{ $pg->user->username ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
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
@endsection