@extends('layouts.app')

@section('content')
    <h1>Data Mahasiswa</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Mahasiswa</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-sm btn-primary">Tambah Mahasiswa</a>
                        <button type="button" class="btn btn-sm btn-success">Export PDF</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>Fakultas</th>
                                    <th>Poin Kredit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mahasiswas as $m)
                                    <tr>
                                        <td>{{ $m->nama_mhs }}</td>
                                        <td>{{ $m->nim }}</td>
                                        <td>{{ $m->prodi->nama_prodi ?? '-' }}</td>
                                        <td>{{ $m->prodi->fakultas->nama_fakultas ?? '-' }}</td>
                                        <td>{{ $m->poin_kredit }}</td>
                                        <td>
                                            <a href="{{ route('admin.mahasiswa.edit', $m->nim) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $m->nim }}"
                                                data-nama="{{ $m->nama_mhs }}">
                                                Delete
                                            </button>
                                            <form id="delete-form-{{ $m->nim }}"
                                                action="{{ route('admin.mahasiswa.destroy', $m->nim) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Alert untuk success message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: true
            });
        @endif

        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus mahasiswa "${nama}"`,
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