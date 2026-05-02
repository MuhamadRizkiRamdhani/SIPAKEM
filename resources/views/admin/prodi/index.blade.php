@extends('layouts.app')

@section('content')
    <h1>Data Program Studi</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Program Studi</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.prodi.create') }}" class="btn btn-sm btn-primary">Tambah Program Studi</a>
                    </div>
                    </p>
                    <div class="table-responsive">
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
                                            <a href="{{ route('admin.prodi.edit', $p->id_prodi) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.prodi.destroy', $p->id_prodi) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                            </form>
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
    </div>

@endsection