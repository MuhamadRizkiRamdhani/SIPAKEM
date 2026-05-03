@extends('layouts.app')

@section('content')
    <h1>Data Pengelola</h1>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Manajemen Data Pengelola</h4>

                    <form method="GET" class="mb-3">
                        <div class="d-flex flex-wrap gap-2 align-items-stretch ">

                            {{-- SEARCH --}}
                            <div style="flex: 1; min-width: 220px;">
                                <input type="text" name="search" class="form-control h-100"
                                    placeholder="Cari nama pengelola..." value="{{ request('search') }}">
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary">Search</button>

                                {{-- CLEAR FILTER --}}
                                @if(request('search') || request('role'))
                                    <a href="{{ route('admin.pengelola.index') }}" class="btn btn-danger">
                                        Clear
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>

                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.pengelola.create') }}" class="btn btn-sm btn-primary">
                            Tambah Pengelola
                        </a>
                        <button type="button" class="btn btn-sm btn-success">
                            Export PDF
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Pengelola</th>
                                    <th>ID_Pengelola</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($pengelolas as $pg)
                                    <tr>
                                        <td>{{ $pg->nama_pengelola }}</td>
                                        <td>{{ $pg->id_pengelola }}</td>
                                        <td>{{ $pg->user->username ?? '-' }}</td>

                                        <td>
                                            <a href="{{ route('admin.pengelola.edit', $pg->id_pengelola) }}"
                                                class="btn btn-primary btn-sm">
                                                Edit
                                            </a>

                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $pg->id_pengelola }}" data-nama="{{ $pg->nama_pengelola }}">
                                                Delete
                                            </button>

                                            <form id="delete-form-{{ $pg->id_pengelola }}"
                                                action="{{ route('admin.pengelola.destroy', $pg->id_pengelola) }}" method="POST"
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

                        {{-- PAGINATION (SUDAH BENAR, TIDAK DIUBAH) --}}
                        <div class="d-flex justify-content-end mt-3">
                            {{ $pengelolas->links() }}
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

        // DELETE CONFIRM
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus pengelola "${nama}"`,
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