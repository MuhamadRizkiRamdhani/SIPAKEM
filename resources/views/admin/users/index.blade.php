@extends('layouts.app')

@section('content')
    <h1>Data Pengguna</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Pengguna</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.pengguna.create') }}" class="btn btn-sm btn-primary">Tambah Pengguna</a>
                    </div>
                    </p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>ID_User</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $u)
                                    <tr>
                                        <td>{{ $u->username }}</td>
                                        <td>{{ $u->id_user }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $u->role === 'admin' ? 'primary' : ($u->role === 'pengelola' ? 'warning' : 'danger') }}">
                                                {{ $u->role }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pengguna.edit', $u->id_user) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.pengguna.destroy', $u->id_user) }}" method="POST"
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