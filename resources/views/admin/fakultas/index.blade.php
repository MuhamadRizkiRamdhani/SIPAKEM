@extends('layouts.app')

@section('content')
    <h1>Data Fakultas</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Fakultas</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.fakultas.create') }}" class="btn btn-sm btn-primary">Tambah Fakultas</a>
                    </div>
                    </p>
                    <div class="table-responsive">
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
                                            <a href="{{ route('admin.fakultas.edit', $f->id_fakultas) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.fakultas.destroy', $f->id_fakultas) }}" method="POST"
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