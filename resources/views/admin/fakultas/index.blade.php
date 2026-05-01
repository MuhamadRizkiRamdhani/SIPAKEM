@extends('layouts.app')

@section('content')
    <h1>Data Fakultas</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Fakultas</h4>
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
                            @forelse($fakultas as $f)
                                <tr>
                                    <td>{{ $f->nama_fakultas }}</td>
                                    <td>{{ $f->id_fakultas }}</td>
                                    <td>
                                        @if($f->prodi->count() > 0)
                                            @foreach($f->prodi as $p)
                                                {{ $p->nama_prodi }}<br>
                                            @endforeach
                                        @else
                                            <em>Tidak ada prodi</em>
                                        @endif
                                    </td>
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