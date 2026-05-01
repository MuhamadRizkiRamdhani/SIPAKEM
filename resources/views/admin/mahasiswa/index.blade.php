@extends('layouts.app')

@section('content')
    <h1>Data Mahasiswa</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Mahasiswa</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <button type="button" class="btn btn-sm btn-primary ">Tambah Mahasiswa</button>
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
                                <th>Poin Kredit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mahasiswas as $m)
                                <tr>
                                    <td>{{ $m->nama_mhs }}</td>
                                    <td>{{ $m->nim }}</td>
                                    <td>{{ $m->prodi->nama_prodi ?? '-' }}</td>
                                    <td>{{ $m->prodi->fakultas->nama_fakultas ?? '-' }}</td>
                                    <td>{{ $m->poin_kredit }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Edit</button>
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