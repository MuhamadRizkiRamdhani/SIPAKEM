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
        <div class="col-lg-12 grid-margin stretch-card">
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
                                name="nama_sertifikat" placeholder="Masukkan nama sertifikat yang Anda miliki" required>
                            @error('nama_sertifikat')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label class="form-label">File Sertifikat <span class="text-danger">*</span></label>

                            <div class="upload-zone" id="uploadZone">
                                <input type="file" id="fileInput" name="file_sertifikat"
                                    class="@error('file_sertifikat') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png"
                                    required>

                                {{-- Tampilan kosong --}}
                                <div class="upload-empty" id="uploadEmpty">
                                    <div class="upload-icon">
                                        <i class="mdi mdi-cloud-upload" style="font-size:28px; color:#6c757d;"></i>
                                    </div>
                                    <p class="upload-title">Drag & drop file di sini</p>
                                    <p class="upload-sub">atau</p>
                                    <span class="btn-browse-label">Pilih File</span>
                                    <p class="upload-formats">PDF, JPG, JPEG, PNG &nbsp;·&nbsp; Maks. 2MB</p>
                                </div>

                                {{-- Preview di dalam kotak --}}
                                <div class="upload-preview-inner" id="uploadPreviewInner">
                                    <div class="file-icon-box" id="previewIconBox">
                                        <i class="mdi" id="previewIcon" style="font-size:26px;"></i>
                                    </div>
                                    <div>
                                        <div class="file-name-text" id="previewName"></div>
                                        <div class="file-size-text" id="previewSize"></div>
                                    </div>
                                    <div class="progress-thin">
                                        <div class="progress-thin-bar" id="pbar"></div>
                                    </div>
                                    <span class="badge-ready" id="readyBadge">✓ File siap diajukan</span>
                                    <button type="button" class="btn-remove-file" id="removeBtn">
                                        <i class="mdi mdi-close" style="font-size:14px;"></i> Ganti file
                                    </button>
                                </div>
                            </div>

                            <div id="uploadError" style="display:none;" class="invalid-feedback d-block mt-2"></div>

                            @error('file_sertifikat')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
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

        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;

            const namaSertifikat = document.querySelector('[name="nama_sertifikat"]').value || '-';

            const kategoriSelect = document.getElementById('kategori');
            const kategoriText = kategoriSelect.options[kategoriSelect.selectedIndex]?.text || '-';

            const subKategoriSelect = document.getElementById('subKategori');
            const subKategoriText = subKategoriSelect.options[subKategoriSelect.selectedIndex]?.text || '-';
            const subKategoriVal = subKategoriSelect.value;

            const levelSelect = document.getElementById('level');
            const levelText = levelSelect.options[levelSelect.selectedIndex]?.text || '-';
            const levelVal = levelSelect.value;

            const fileInput = document.getElementById('fileInput');
            const fileName = fileInput.files[0]?.name || '-';

            const rowStyle = 'margin-bottom: 12px;';
            const labelStyle = 'font-size: 12px; font-weight: 600; color: #adb5bd; text-transform: uppercase; letter-spacing: 0.5px;';
            const valueStyle = 'font-size: 14px; color: #212529; margin-top: 2px;';

            function row(label, value, optional = false) {
                if (optional && (!value || value === '-' || value.includes('Pilih'))) {
                    return `
                                                    <div style="${rowStyle}">
                                                        <div style="${labelStyle}">${label}</div>
                                                        <div style="${valueStyle} color: #adb5bd; font-style: italic;">Tidak dipilih</div>
                                                    </div>`;
                }
                return `
                                                <div style="${rowStyle}">
                                                    <div style="${labelStyle}">${label}</div>
                                                    <div style="${valueStyle}">${value}</div>
                                                </div>`;
            }

            Swal.fire({
                title: 'Konfirmasi Pengajuan',
                html: `
                                                <div style="text-align: left; padding: 4px 0;">
                                                    <div style="background: #f8f9fa; border-radius: 8px; padding: 14px 16px; margin-bottom: 4px;">
                                                        ${row('Kategori', kategoriText)}
                                                        ${row('Sub Kategori', subKategoriText, true)}
                                                        ${row('Level', levelText, true)}
                                                        ${row('Nama Sertifikat', namaSertifikat)}
                                                        ${row('File', fileName)}
                                                    </div>
                                                    <p style="font-size: 13px; color: #6c757d; margin: 10px 0 0; text-align: center;">
                                                        Pastikan semua data sudah benar sebelum mengajukan.
                                                    </p>
                                                </div>
                                            `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ajukan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2C5EAD',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
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

        (function () {
            const zone = document.getElementById('uploadZone');
            const input = document.getElementById('fileInput');
            const empty = document.getElementById('uploadEmpty');
            const inner = document.getElementById('uploadPreviewInner');
            const errBox = document.getElementById('uploadError');
            const iconBox = document.getElementById('previewIconBox');
            const icon = document.getElementById('previewIcon');
            const nameEl = document.getElementById('previewName');
            const sizeEl = document.getElementById('previewSize');
            const bar = document.getElementById('pbar');
            const badge = document.getElementById('readyBadge');
            const removeBtn = document.getElementById('removeBtn');

            const MAX = 2 * 1024 * 1024;
            const ALLOWED = ['application/pdf', 'image/jpeg', 'image/png'];

            zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
            zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
            zone.addEventListener('drop', e => {
                e.preventDefault();
                zone.classList.remove('drag-over');
                const f = e.dataTransfer.files[0];
                const dt = new DataTransfer();
                dt.items.add(f);
                input.files = dt.files;
                if (f) handleFile(f);
            });
            input.addEventListener('change', () => { if (input.files[0]) handleFile(input.files[0]); });

            removeBtn.addEventListener('click', () => {
                input.value = '';
                bar.style.width = '0';
                badge.style.display = 'none';
                inner.style.display = 'none';
                empty.style.display = 'flex';
                zone.classList.remove('has-file');
                errBox.style.display = 'none';
            });

            function fmt(b) {
                if (b < 1024) return b + ' B';
                if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
                return (b / 1048576).toFixed(2) + ' MB';
            }

            function handleFile(file) {
                errBox.style.display = 'none';
                if (!ALLOWED.includes(file.type)) { showErr('Format tidak didukung. Gunakan PDF, JPG, JPEG, atau PNG.'); return; }
                if (file.size > MAX) { showErr('Ukuran file terlalu besar (maks. 2MB).'); return; }
                renderPreview(file);
            }

            function showErr(msg) {
                errBox.textContent = msg;
                errBox.style.display = 'block';
            }

            function renderPreview(file) {
                const isPdf = file.type === 'application/pdf';
                iconBox.className = 'file-icon-box ' + (isPdf ? 'pdf' : 'img');
                icon.className = 'mdi ' + (isPdf ? 'mdi-file-pdf-box' : 'mdi-image');
                icon.style.color = isPdf ? '#fd7e3b' : '#20c997';
                nameEl.textContent = file.name;
                sizeEl.textContent = fmt(file.size);

                bar.style.width = '0';
                badge.style.display = 'none';
                empty.style.display = 'none';
                inner.style.display = 'flex';
                zone.classList.add('has-file');

                let w = 0;
                const iv = setInterval(() => {
                    w += Math.random() * 30 + 10;
                    if (w >= 100) {
                        w = 100;
                        clearInterval(iv);
                        badge.style.display = 'inline-block';
                    }
                    bar.style.width = w + '%';
                }, 70);
            }
        })();
    </script>
@endsection