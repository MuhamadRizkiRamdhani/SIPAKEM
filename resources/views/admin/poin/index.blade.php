@extends('layouts.app')

@section('content')
    <h1>Data Poin</h1>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Poin</h4>

                    {{-- SEARCH & FILTER --}}
                    <form method="GET" class="mb-3">
                        <div class="d-flex flex-wrap gap-2 align-items-stretch">

                            {{-- SEARCH --}}
                            <div style="flex:1; min-width:200px;">
                                <input type="text" name="search" class="form-control h-100" placeholder="Cari poin..."
                                    value="{{ request('search') }}">
                            </div>

                            {{-- FILTER KATEGORI --}}
                            <div style="width:200px;">
                                <select name="kategori" class="form-control h-100">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- FILTER LEVEL --}}
                            <div style="width:200px;">
                                <select name="level" class="form-control h-100">
                                    <option value="">Semua Level</option>
                                    @foreach($levels as $l)
                                        <option value="{{ $l->id_level }}" {{ request('level') == $l->id_level ? 'selected' : '' }}>
                                            {{ $l->nama_level }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary">Search</button>

                                @if(request()->hasAny(['search', 'kategori', 'level']))
                                    <a href="{{ route('admin.poin.index') }}" class="btn btn-danger">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    {{-- BUTTON TAMBAH --}}
                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.poin.create') }}" class="btn btn-sm btn-primary">
                            Tambah Point Rules
                        </a>
                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Rules</th>
                                    <th>Kategori</th>
                                    <th>Sub Kategori</th>
                                    <th>Level</th>
                                    <th>Poin Akhir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pointRules as $pr)
                                    <tr>
                                        <td>{{ $pr->id_rules }}</td>
                                        <td>{{ $pr->kategori->nama_kategori ?? '-' }}</td>
                                        <td>{{ $pr->subKategori->nama_sub_kategori ?? '-' }}</td>
                                        <td>{{ $pr->level->nama_level ?? '-' }}</td>
                                        <td>{{ $pr->poin_akhir }}</td>
                                        <td>
                                            {{-- EDIT --}}
                                            <a href="{{ route('admin.poin.edit', $pr->id_rules) }}"
                                                class="btn btn-primary btn-sm">
                                                Edit
                                            </a>

                                            {{-- DELETE --}}
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $pr->id_rules }}" data-nama="Rule {{ $pr->id_rules }}">
                                                Delete
                                            </button>

                                            <form id="delete-form-{{ $pr->id_rules }}"
                                                action="{{ route('admin.poin.destroy', $pr->id_rules) }}" method="POST"
                                                style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <em>Belum ada data</em>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- PAGINATION --}}
                        <div class="d-flex justify-content-end mt-3">
                            {{ $pointRules->links() }}
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

        // ERROR ALERT (optional tapi bagus)
        @if(session('error'))
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
                    title: 'Hapus Data?',
                    text: `${nama} akan dihapus`,
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