@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-note-search-outline"></i>
                </span> Pengajuan Sertifikat
            </h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Pengajuan Sertifikat</h4>

                    <form method="GET" class="mb-3">
                        <div class="d-flex flex-wrap gap-2 align-items-stretch">

                            {{-- SEARCH --}}
                            <div style="flex: 1; min-width: 220px;">
                                <input type="text" name="search" class="form-control h-100"
                                    placeholder="Cari nama / NIM / sertifikat..." value="{{ request('search') }}">
                            </div>

                            {{-- FILTER STATUS --}}
                            <div style="width: 200px;">
                                <select name="status" class="form-control h-100">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima
                                    </option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                    </option>
                                </select>
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary">Search</button>

                                @if(request()->hasAny(['search', 'status']))
                                    <a href="{{ route($role . '.pengajuan-sertifikat.index') }}" class="btn btn-danger">
                                        Clear
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Nama Sertifikat</th>
                                    <th>File Sertifikat</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuanSertifikats as $ps)
                                    <tr>
                                        <!-- Nama Mahasiswa -->
                                        <td>{{ $ps->mahasiswa->nama_mhs ?? '-' }}</td>

                                        <!-- NIM -->
                                        <td>{{ $ps->nim }}</td>

                                        <!-- Nama Sertifikat -->
                                        <td>{{ $ps->nama_sertifikat }}</td>

                                        <!-- File Sertifikat -->
                                        <td>
                                            @if($ps->file_path)
                                                <a href="{{ asset('storage/' . $ps->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-info">
                                                    Lihat File
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <!-- Tanggal -->
                                        <td>{{ \Carbon\Carbon::parse($ps->tgl_pengajuan_sertifikat)->format('d-m-Y') }}</td>

                                        <!-- Status -->
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'pending' => 'secondary',
                                                    'diproses' => 'warning',
                                                    'diterima' => 'success',
                                                    'ditolak' => 'danger'
                                                ];
                                            @endphp

                                            <span class="badge badge-{{ $statusClass[$ps->status] ?? 'secondary' }}">
                                                {{ ucfirst($ps->status) }}
                                            </span>
                                        </td>

                                        <!-- Action -->
                                        <td>
                                            <a href="{{ route('pengelola.pengajuan-sertifikat.show', $ps->id_pengajuan) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="mdi mdi-eye"></i> Tinjau
                                            </a>

                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $ps->id_pengajuan }}">
                                                <i class="mdi mdi-trash-can"></i> Delete
                                            </button>

                                            <form id="delete-form-{{ $ps->id_pengajuan }}"
                                                action="{{ route('pengelola.pengajuan-sertifikat.destroy', $ps->id_pengajuan) }}"
                                                method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center"><em>Belum ada data</em></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $pengajuanSertifikats->appends(request()->query())->links() }}
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
        // ✅ SUCCESS ALERT
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: true
            });
        @endif

        // ❌ DELETE CONFIRMATION
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