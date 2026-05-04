@extends('layouts.app')

@section('content')
    <h1>Data Sub Kategori Sertifikat</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Sub Kategori Sertifikat</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.sub-kategori.create') }}" class="btn btn-sm btn-primary">Tambah Sub
                            Kategori</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Sub-Kategori</th>
                                    <th>ID Sub Kategori</th>
                                    <th>Nama Kategori</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subkategoris as $sk)
                                    <tr>
                                        <td>{{ $sk->nama_sub_kategori }}</td>
                                        <td>{{ $sk->id_sub_kategori }}</td>
                                        <td>{{ $sk->kategori->nama_kategori ?? 'Kategori tidak ditemukan' }}</td>
                                        <td>
                                            <a href="{{ route('admin.sub-kategori.edit', $sk->id_sub_kategori) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.sub-kategori.destroy', $sk->id_sub_kategori) }}"
                                                method="POST" style="display:inline;">
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