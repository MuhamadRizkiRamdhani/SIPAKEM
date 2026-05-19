@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-format-list-bulleted-type"></i>
                </span> Data Sub Kategori
            </h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Sub Kategori Sertifikat</h4>

                    {{-- FORM SEARCH & FILTER --}}
                    <form method="GET" class="mb-3">
                        <div class="d-flex flex-wrap gap-2 align-items-stretch">

                            {{-- SEARCH --}}
                            <div style="flex: 1; min-width: 220px;">
                                <input type="text" name="search" class="form-control h-100"
                                    placeholder="Cari nama / ID sub kategori..." value="{{ request('search') }}">
                            </div>

                            {{-- FILTER KATEGORI --}}
                            <div style="width: 200px;">
                                <select name="kategori" class="form-control h-100">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary">Search</button>

                                @if(request()->hasAny(['search', 'kategori']))
                                    <a href="{{ route('admin.sub-kategori.index') }}" class="btn btn-danger">
                                        Clear
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.sub-kategori.create') }}" class="btn btn-sm btn-primary">
                            Tambah Sub Kategori
                        </a>
                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama Sub Kategori</th>
                                    <th>ID Sub Kategori</th>
                                    <th>Kategori</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subkategoris as $sk)
                                    <tr>
                                        <td>{{ $sk->nama_sub_kategori }}</td>
                                        <td>{{ $sk->id_sub_kategori }}</td>
                                        <td>{{ $sk->kategori->nama_kategori ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.sub-kategori.edit', $sk->id_sub_kategori) }}"
                                                class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i> Edit</a>

                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $sk->id_sub_kategori }}" data-nama="{{ $sk->nama_sub_kategori }}">
                                                <i class="mdi mdi-trash-can"></i> Delete
                                            </button>

                                            <form id="delete-form-{{ $sk->id_sub_kategori }}"
                                                action="{{ route('admin.sub-kategori.destroy', $sk->id_sub_kategori) }}"
                                                method="POST" style="display:none;">
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
                            {{ $subkategoris->links() }}
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
                timer: 2500,
                showConfirmButton: true
            });
        @endif

        // DELETE ALERT
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Hapus Sub Kategori?',
                    text: `Sub kategori "${nama}" akan dihapus`,
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