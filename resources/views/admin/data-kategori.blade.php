@extends('layouts.app')

@section('content')
    <h1>Data Kategori Sertifikat</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Kategori Sertifikat</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <button type="button" class="btn btn-sm btn-primary ">Tambah Kategori</button>
                    </div>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>ID_Kategori</th>
                                <th>Sub Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategoris as $k)
                                <tr>
                                    <td>{{ $k->nama_kategori }}</td>
                                    <td>{{ $k->id_kategori }}</td>
                                    <td>
                                        @if($k->subKategori->count() > 0)
                                            @foreach($k->subKategori as $sk)
                                                {{ $sk->nama_sub_kategori }}<br>
                                            @endforeach
                                        @else
                                            <em>Tidak ada sub kategori</em>
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