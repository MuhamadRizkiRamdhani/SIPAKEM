@extends('layouts.app')

@section('content')
    <h1>Data Kategori Sertifikat</h1>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Kategori Sertifikat</h4>

                    {{-- SEARCH --}}
                    <form method="GET" class="mb-3">
                        <div class="d-flex flex-wrap gap-2 align-items-stretch">

                            <div style="flex: 1; min-width: 220px;">
                                <input type="text" name="search" class="form-control h-100"
                                    placeholder="Cari nama / ID kategori..." value="{{ request('search') }}">
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-primary">Search</button>

                                @if(request()->has('search'))
                                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-danger">
                                        Clear
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.kategori.create') }}" class="btn btn-sm btn-primary">
                            Tambah Kategori
                        </a>
                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>ID Kategori</th>
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

                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $k->id_kategori }}" data-nama="{{ $k->nama_kategori }}">
                                                Delete
                                            </button>

                                            <form id="delete-form-{{ $k->id_kategori }}"
                                                action="{{ route('admin.kategori.destroy', $k->id_kategori) }}" method="POST"
                                                style="display:none;">
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
                            {{ $kategoris->links() }}
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
        // SUCCESS
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: true
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}'
            });
        @endif

        // DELETE CONFIRM
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Hapus Kategori?',
                    text: `Kategori "${nama}" akan dihapus`,
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