@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-note-search-outline"></i>
                </span> Pengajuan SKPI
            </h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">
                        Manajemen Data Pengajuan SKPI
                    </h4>

                    {{-- SEARCH + FILTER --}}
                    <form method="GET" class="mb-3">

                        <div class="d-flex flex-wrap gap-2 align-items-stretch">

                            {{-- SEARCH --}}
                            <div style="flex:1; min-width:220px;">
                                <input type="text" name="search" class="form-control h-100" placeholder="Cari nama / NIM..."
                                    value="{{ request('search') }}">
                            </div>

                            {{-- STATUS --}}
                            <div style="width:200px;">
                                <select name="status" class="form-control h-100">
                                    <option value="">Semua Status</option>

                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>
                                        Diterima
                                    </option>

                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                </select>
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary">
                                    Search
                                </button>

                                @if(request()->hasAny(['search', 'status']))
                                    <a href="{{ route($role . '.pengajuan-skpi.index') }}" class="btn btn-danger">
                                        Clear
                                    </a>
                                @endif
                            </div>

                        </div>

                    </form>

                    {{-- TABLE --}}
                    <div class="table-responsive">

                        <table class="table table-hover table-borderless">

                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>Fakultas</th>
                                    <th>Poin Kredit</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($pengajuanSKPIs as $psk)

                                    <tr>

                                        <td>
                                            {{ $psk->mahasiswa->nama_mhs ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $psk->nim }}
                                        </td>

                                        <td>
                                            {{ $psk->mahasiswa->prodi->nama_prodi ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $psk->mahasiswa->prodi->fakultas->nama_fakultas ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $psk->mahasiswa->poin_kredit ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $psk->tgl_pengajuan_skpi->format('d-m-Y') }}
                                        </td>

                                        {{-- STATUS --}}
                                        <td>

                                            @php
                                                $statusClass = [
                                                    'pending' => 'secondary',
                                                    'diproses' => 'warning',
                                                    'diterima' => 'success',
                                                    'ditolak' => 'danger'
                                                ];
                                            @endphp

                                            <span class="badge badge-{{ $statusClass[$psk->status] ?? 'secondary' }}">
                                                {{ ucfirst($psk->status) }}
                                            </span>

                                        </td>

                                        {{-- ACTION --}}
                                        <td>

                                            <a href="{{ route($role . '.pengajuan-skpi.show', $psk->id_pengajuan_skpi) }}"
                                                class="btn btn-primary btn-sm"><i class="mdi mdi-eye"></i>
                                                Tinjau
                                            </a>

                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $psk->id_pengajuan_skpi }}">
                                                <i class="mdi mdi-trash-can"></i> Delete
                                            </button>

                                            <form id="delete-form-{{ $psk->id_pengajuan_skpi }}"
                                                action="{{ route($role . '.pengajuan-skpi.destroy', $psk->id_pengajuan_skpi) }}"
                                                method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <em>Belum ada data</em>
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                        {{-- PAGINATION --}}
                        <div class="d-flex justify-content-end mt-3">
                            {{ $pengajuanSKPIs->appends(request()->query())->links() }}
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
                timer: 3000,
                showConfirmButton: true
            });
        @endif

        // DELETE
        document.querySelectorAll('.delete-btn').forEach(button => {

            button.addEventListener('click', function () {

                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: 'Data pengajuan akan dihapus permanen',
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