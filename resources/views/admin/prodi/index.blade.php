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

                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $p->id_prodi }}" data-nama="{{ $p->nama_prodi }}">
                                                Delete
                                            </button>

                                            <form id="delete-form-{{ $p->id_prodi }}"
                                                action="{{ route('admin.prodi.destroy', $p->id_prodi) }}" method="POST"
                                                style="display:none;">
                                                @csrf
                                                @method('DELETE')
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: true
            });
        @endif
    </script>

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Hapus Program Studi?',
                    text: `Prodi "${nama}" akan dihapus`,
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