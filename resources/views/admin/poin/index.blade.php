@extends('layouts.app')

@section('content')
    <h1>Data Poin</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Poin</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <button type="button" class="btn btn-sm btn-primary ">Tambah Point Rules</button>
                    </div>
                    </p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID_Rules</th>
                                    <th>Kategori</th>
                                    <th>Sub-Kategori</th>
                                    <th>Level</th>
                                    <th>Poin Akhir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pointRules as $pr)
                                    <tr>
                                        <td>{{ $pr->id_rules }}</td>
                                        <td>{{ $pr->kategori->nama_kategori ?? '-' }}</td>
                                        <td>{{ $pr->subKategori->nama_sub_kategori ?? '-' }}</td>
                                        <td>{{ $pr->level->nama_level ?? '-' }}</td>
                                        <td>{{ $pr->poin_akhir }}</td>
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
    </div>

@endsection