@extends('layouts.app')

@section('content')
    <h1>Data Program Studi</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Program Studi</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <button type="button" class="btn btn-sm btn-primary ">Tambah Program Studi</button>
                    </div>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Prodi</th>
                                <th>ID_Prodi</th>
                                <th>Fakultas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prodis as $p)
                                <tr>
                                    <td>{{ $p->nama_prodi }}</td>
                                    <td>{{ $p->id_prodi }}</td>
                                    <td>{{ $p->fakultas->nama_fakultas ?? '-' }}</td>
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