@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account-school"></i>
                </span> Data Mahasiswa
            </h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Mahasiswa</h4>
                    
                    <form method="GET" class="mb-3">
                    <div class="d-flex flex-wrap gap-2 align-items-stretch">

                        {{-- SEARCH --}}
                        <div style="flex: 1; min-width: 220px;">
                            <input type="text"
                                name="search"
                                class="form-control  h-100"
                                placeholder="Cari nama / NIM..."
                                value="{{ request('search') }}">
                        </div>

                        {{-- FILTER FAKULTAS --}}
                        <div style="width: 200px;">
                            <select name="fakultas" id="fakultas" class="form-control  h-100">
                                <option value="">Semua Fakultas</option>
                                @foreach($fakultas as $f)
                                    <option value="{{ $f->id_fakultas }}"
                                        {{ request('fakultas') == $f->id_fakultas ? 'selected' : '' }}>
                                        {{ $f->nama_fakultas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER PRODI --}}
                        <div style="width: 200px;">
                            <select name="prodi" id="prodi" class="form-control  h-100">
                                <option value="">Semua Prodi</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->id_prodi }}"
                                        data-fakultas="{{ $p->id_fakultas }}"
                                        {{ request('prodi') == $p->id_prodi ? 'selected' : '' }}>
                                        {{ $p->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER TAHUN --}}
                        <div style="width: 200px;">
                            <input type="text"
                                name="tahun_angkatan"
                                class="form-control  h-100"
                                placeholder="Tahun Angkatan"
                                value="{{ request('tahun_angkatan') }}">
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">Search</button>

                            @if(request()->hasAny(['search','prodi','fakultas','tahun_angkatan']))
                                <a href="{{ route($role.'.mahasiswa.index') }}"
                                class="btn btn-danger">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </div>
                    </form>

                    <div class="d-flex justify-content-end mb-3 gap-3">
                        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-sm btn-primary">Tambah Mahasiswa</a>
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalImport">
                            <i class="mdi mdi-upload"></i> Import Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalExport">
                            <i class="mdi mdi-download"></i> Export PDF
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Tahun Angkatan</th>
                                    <th>Prodi</th>
                                    <th>Fakultas</th>
                                    <th>Poin Kredit</th>
                                    <th>Status Beasiswa</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mahasiswas as $m)
                                    <tr>
                                        <td>{{ $m->nama_mhs }}</td>
                                        <td>{{ $m->nim }}</td>
                                        <td>{{ $m->tahun_angkatan }}</td>
                                        <td>{{ $m->prodi->nama_prodi ?? '-' }}</td>
                                        <td>{{ $m->prodi->fakultas->nama_fakultas ?? '-' }}</td>
                                        <td>{{ $m->poin_kredit }}</td>
                                        <td> 
                                            @if($m->beasiswa == 1)
                                                <span class="badge bg-success">Penerima</span>
                                            @else
                                                <span class="badge bg-secondary">Bukan Penerima</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.mahasiswa.edit', $m->nim) }}"
                                                class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i> Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $m->nim }}"
                                                data-nama="{{ $m->nama_mhs }}">
                                                <i class="mdi mdi-trash-can"></i> Delete
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
                        <div class="d-flex justify-content-end mt-3">
                            {{ $mahasiswas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========== MODAL IMPORT ========== --}}
    <div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImportLabel">
                        <i class="mdi mdi-upload me-1"></i> Import Data Mahasiswa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route($role.'.mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        @if(session('import_errors'))
                            <div class="alert alert-warning py-2">
                                <strong><i class="mdi mdi-alert"></i> Beberapa baris dilewati:</strong>
                                <ul class="mb-0 mt-1 ps-3" style="font-size: 13px; max-height: 120px; overflow-y: auto;">
                                    @foreach(session('import_errors') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih File <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                            <small class="text-muted">Format: .xlsx, .xls, atau .csv. Maksimal 10MB.</small>
                        </div>

                        <div class="alert alert-info py-2 mb-0" style="font-size: 13px;">
                            <strong><i class="mdi mdi-information-outline"></i> Format kolom yang diperlukan:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li><code>nim</code> — 8–10 digit angka <span class="text-danger">*</span></li>
                                <li><code>nama_mhs</code> — Nama lengkap <span class="text-danger">*</span></li>
                                <li><code>username</code> — Username akun <span class="text-danger">*</span></li>
                                <li><code>password</code> — Min. 8 karakter</li>
                                <li><code>id_prodi</code> — ID program studi <span class="text-danger">*</span></li>
                                <li><code>tahun_angkatan</code> — Format YYYY <span class="text-danger">*</span></li>
                                <li><code>poin_kredit</code> — Angka <em>(opsional, default: 0)</em></li>
                                <li><code>beasiswa</code> — <code>0</code> = Bukan Penerima, <code>1</code> = Penerima <em>(opsional)</em></li>
                            </ul>
                            <small class="text-danger d-block mt-1">* wajib diisi</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class=""></i> Import</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ========== MODAL EXPORT PDF ========== --}}
    <div class="modal fade" id="modalExport" tabindex="-1" aria-labelledby="modalExportLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExportLabel">
                        <i class="mdi mdi-download me-1"></i> Export PDF Mahasiswa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3" style="font-size: 13px;">
                        Pilih filter yang ingin diterapkan pada PDF. Kosongkan untuk export semua data.
                    </p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Fakultas</label>
                        <select id="export-fakultas" class="form-control">
                            <option value="">Semua Fakultas</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id_fakultas }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Program Studi</label>
                        <select id="export-prodi" class="form-control">
                            <option value="">Semua Prodi</option>
                            @foreach($prodis as $p)
                                <option value="{{ $p->id_prodi }}" data-fakultas="{{ $p->id_fakultas }}">
                                    {{ $p->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tahun Angkatan</label>
                        <input type="text" id="export-tahun" class="form-control" placeholder="cth: 2022">
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">Status Beasiswa</label>
                        <select id="export-beasiswa" class="form-control">
                            <option value="">Semua</option>
                            <option value="1">Penerima Beasiswa</option>
                            <option value="0">Bukan Penerima</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-export-pdf">
                        <i class="mdi mdi-file-pdf"></i> Export PDF
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
                timer: 3000,
                showConfirmButton: true
            });
        @endif

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

        // Filter prodi by fakultas (tabel utama)
        const fakultasSelect = document.getElementById('fakultas');
        const prodiSelect = document.getElementById('prodi');
        fakultasSelect.addEventListener('change', function () {
            const selected = this.value;
            Array.from(prodiSelect.options).forEach(option => {
                if (!option.value) return;
                option.style.display = (!selected || option.dataset.fakultas === selected) ? 'block' : 'none';
            });
            prodiSelect.value = '';
        });

        // Filter prodi by fakultas (modal export)
        const exportFakultasSelect = document.getElementById('export-fakultas');
        const exportProdiSelect = document.getElementById('export-prodi');
        exportFakultasSelect.addEventListener('change', function () {
            const selected = this.value;
            Array.from(exportProdiSelect.options).forEach(option => {
                if (!option.value) return;
                option.style.display = (!selected || option.dataset.fakultas === selected) ? 'block' : 'none';
            });
            exportProdiSelect.value = '';
        });

        // Tombol export PDF — build URL dengan query params dari modal
        document.getElementById('btn-export-pdf').addEventListener('click', function () {
            const params = new URLSearchParams();
            const fakultas = exportFakultasSelect.value;
            const prodi = exportProdiSelect.value;
            const tahun = document.getElementById('export-tahun').value;
            const beasiswa = document.getElementById('export-beasiswa').value;

            if (fakultas) params.append('fakultas', fakultas);
            if (prodi) params.append('prodi', prodi);
            if (tahun) params.append('tahun_angkatan', tahun);
            if (beasiswa !== '') params.append('beasiswa', beasiswa);

            const baseUrl = "{{ route($role.'.mahasiswa.exportPdf') }}";
            window.location.href = baseUrl + '?' + params.toString();
        });

        @if(session('import_errors'))
            var modalImport = new bootstrap.Modal(document.getElementById('modalImport'));
            modalImport.show();
        @endif
    </script>
@endpush