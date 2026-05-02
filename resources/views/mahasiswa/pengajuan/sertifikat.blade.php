@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-certificate"></i>
            </span> Formulir Pengajuan Sertifikat
        </h3>
    </div>

    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Pengajuan Sertifikat Baru</h4>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('mahasiswa.pengajuan-sertifikat.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Mahasiswa (Auto) -->
                        <div class="mb-3">
                            <label class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nama_mhs }}" disabled>
                        </div>

                        <!-- Tanggal Pengajuan (Auto) -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" value="{{ now()->toDateString() }}" disabled>
                            <input type="hidden" name="tgl_pengajuan" value="{{ now()->toDateString() }}">
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_kategori') is-invalid @enderror" id="kategori"
                                name="id_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sub Kategori -->
                        <div class="mb-3">
                            <label class="form-label">Sub Kategori</label>
                            <select class="form-control" id="subKategori" name="id_sub_kategori">
                                <option value="">-- Pilih Sub Kategori (Opsional) --</option>
                            </select>
                        </div>

                        <!-- Level -->
                        <div class="mb-3">
                            <label class="form-label">Level</label>
                            <select class="form-control" id="level" name="id_level">
                                <option value="">-- Pilih Level (Opsional) --</option>
                            </select>
                        </div>

                        <!-- Nama Sertifikat -->
                        <div class="mb-3">
                            <label class="form-label">Nama Sertifikat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_sertifikat') is-invalid @enderror"
                                name="nama_sertifikat"
                                placeholder="Contoh: Python Bootcamp, IELTS, Sertifikat Pelatihan Web Development" required>
                            <small class="form-text text-muted">Masukkan nama sertifikat yang Anda miliki</small>
                            @error('nama_sertifikat')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label class="form-label">File Sertifikat <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('file_sertifikat') is-invalid @enderror"
                                name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png" required>
                            <small class="form-text text-muted">Format: PDF, JPG, JPEG, PNG | Max: 2MB</small>
                            @error('file_sertifikat')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Ajukan</button>
                            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Kategori Change - Load Sub Kategori
        document.getElementById('kategori').addEventListener('change', async function () {
            const kategoriId = this.value;
            const subKategoriSelect = document.getElementById('subKategori');

            // Reset
            subKategoriSelect.innerHTML = '<option value="">-- Pilih Sub Kategori (Opsional) --</option>';

            if (!kategoriId) return;

            try {
                const response = await fetch(`/api/sub-kategori/${kategoriId}`);
                const subKategoris = await response.json();

                if (subKategoris.length > 0) {
                    subKategoris.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id_sub_kategori;
                        option.textContent = sub.nama_sub_kategori;
                        subKategoriSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });

        // Load all levels on page load
        async function loadAllLevels() {
            try {
                const response = await fetch('/api/level');
                const levels = await response.json();
                const levelSelect = document.getElementById('level');

                levels.forEach(level => {
                    const option = document.createElement('option');
                    option.value = level.id_level;
                    option.textContent = level.nama_level;
                    levelSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading levels:', error);
            }
        }

        loadAllLevels();
    </script>
@endsection