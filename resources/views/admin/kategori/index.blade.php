@extends('layouts.app')

@section('content')
    <h1>Data Kategori Sertifikat</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Kategori Sertifikat</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.kategori.create') }}" class="btn btn-sm btn-primary">Tambah Kategori</a>
                    </div>
                    </p>
                    <div class="table-responsive">
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
                                            <a href="{{ route('admin.kategori.edit', $k->id_kategori) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.kategori.destroy', $k->id_kategori) }}" method="POST"
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