@extends('layouts.app')

@section('content')
    <h1>Data Pengguna</h1>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Pengguna</h4>

                    {{-- FORM SEARCH & FILTER --}}
                    <form method="GET" class="mb-3">
                        <div class="d-flex flex-wrap gap-2 align-items-stretch">

                            {{-- SEARCH --}}
                            <div style="flex: 1; min-width: 220px;">
                                <input type="text" name="search" class="form-control h-100"
                                    placeholder="Cari username / ID..." value="{{ request('search') }}">
                            </div>

                            {{-- FILTER ROLE --}}
                            <div style="width: 200px;">
                                <select name="role" class="form-control h-100">
                                    <option value="">Semua Role</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="pengelola" {{ request('role') == 'pengelola' ? 'selected' : '' }}>Pengelola
                                    </option>
                                    <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                                    </option>
                                </select>
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary">Search</button>

                                @if(request()->hasAny(['search', 'role']))
                                    <a href="{{ route('admin.pengguna.index') }}" class="btn btn-danger">
                                        Clear
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>

                    {{-- BUTTON TAMBAH --}}
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.pengguna.create') }}" class="btn btn-sm btn-primary">
                            Tambah Pengguna
                        </a>
                    </div>

                    {{-- TABLE --}}
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

                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $u->id_user }}" data-nama="{{ $u->username }}">
                                                Delete
                                            </button>

                                            <form id="delete-form-{{ $u->id_user }}"
                                                action="{{ route('admin.pengguna.destroy', $u->id_user) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <em>Belum ada data</em>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- PAGINATION --}}
                        <div class="d-flex justify-content-end mt-3">
                            {{ $users->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // SUCCESS ALERT
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: true
            });
        @endif

        // DELETE CONFIRMATION
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus user "${nama}"`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            });
        });
    </script>
@endpush