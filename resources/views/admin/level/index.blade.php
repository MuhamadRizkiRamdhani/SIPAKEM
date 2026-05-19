@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-format-list-bulleted-type"></i>
                </span> Data Level
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manajemen Data Level</h4>

                {{-- SEARCH --}}
                <form method="GET" class="mb-3 d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari level..."
                        value="{{ request('search') }}">

                    <button class="btn btn-primary">Search</button>

                    @if(request('search'))
                        <a href="{{ route('admin.level.index') }}" class="btn btn-danger">Clear</a>
                    @endif
                </form>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('admin.level.create') }}" class="btn btn-primary btn-sm">
                        Tambah Level
                    </a>
                </div>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-hover table-borderless">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($levels as $level)
                                <tr>
                                    <td>{{ $level->id_level }}</td>
                                    <td>{{ $level->nama_level }}</td>
                                    <td>
                                        <a href="{{ route('admin.level.edit', $level->id_level) }}"
                                            class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i> Edit</a>

                                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $level->id_level }}"
                                            data-nama="{{ $level->nama_level }}">
                                            <i class="mdi mdi-trash-can"></i> Delete
                                        </button>

                                        <form id="delete-form-{{ $level->id_level }}"
                                            action="{{ route('admin.level.destroy', $level->id_level) }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $levels->links() }}

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // SUCCESS
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000
            });
        @endif

        // DELETE
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                Swal.fire({
                    title: 'Hapus Level?',
                    text: `Level "${nama}" akan dihapus`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!'
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            });
        });
    </script>
@endpush