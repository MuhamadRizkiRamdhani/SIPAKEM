@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-note-check-outline"></i>
            </span> Formulir Pengajuan SKPI
        </h3>
    </div>

    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Pengajuan Surat Keterangan Pendamping Ijazah (SKPI)</h4>

                    @if(!$cukupPoin)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-alert-circle"></i>
                            <strong>Poin Anda Belum Memenuhi Syarat!</strong>
                            <br>
                            Poin saat ini: <strong>{{ $mahasiswa->poin_kredit }}</strong> / <strong>{{ $maxPoin }}</strong>
                            <br>
                            <small>Silakan ajukan sertifikat untuk menambah poin Anda.</small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @else
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-circle"></i>
                            <strong>Poin Anda Sudah Memenuhi Syarat!</strong>
                            <br>
                            Poin saat ini: <strong>{{ $mahasiswa->poin_kredit }}</strong> / <strong>{{ $maxPoin }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('mahasiswa.pengajuan-skpi.store') }}" method="POST">
                        @csrf

                        <!-- NIM (Auto) -->
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nim }}" disabled>
                        </div>

                        <!-- Nama Mahasiswa (Auto) -->
                        <div class="mb-3">
                            <label class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nama_mhs }}" disabled>
                        </div>

                        <!-- Tanggal Pengajuan (Auto) -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" value="{{ now()->toDateString() }}" disabled>
                        </div>

                        <!-- Program Studi -->
                        <div class="mb-3">
                            <label class="form-label">Program Studi</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->prodi->nama_prodi ?? '-' }}"
                                disabled>
                        </div>

                        <!-- Fakultas -->
                        <div class="mb-3">
                            <label class="form-label">Fakultas</label>
                            <input type="text" class="form-control"
                                value="{{ $mahasiswa->prodi->fakultas->nama_fakultas ?? '-' }}" disabled>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" {{ !$cukupPoin ? 'disabled' : '' }}>
                                {{ !$cukupPoin ? 'Poin Belum Cukup' : 'Ajukan SKPI' }}
                            </button>
                            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="alert alert-info">
                        <h5 class="alert-heading">Informasi SKPI</h5>
                        <p class="mb-0">
                            Surat Keterangan Pendamping Ijazah (SKPI) adalah surat yang diberikan oleh institusi pendidikan
                            kepada setiap lulusan yang berisi rekam jejak akademik dan prestasi yang telah dicapai selama
                            menjalani program pendidikan. SKPI dapat diajukan setelah Anda memenuhi syarat poin minimum.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Persyaratan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            @if($mahasiswa->beasiswa)
                                <i class="mdi mdi-check-circle text-success"></i> Poin minimal: 150
                                <br>
                                <small class="text-muted">(Penerima Beasiswa)</small>
                            @else
                                <i class="mdi mdi-check-circle text-success"></i> Poin minimal: 100
                                <br>
                                <small class="text-muted">(Bukan Penerima Beasiswa)</small>
                            @endif
                        </li>
                        <li class="mb-2">
                            <i
                                class="mdi mdi-{{ $cukupPoin ? 'check-circle text-success' : 'alert-circle text-warning' }}"></i>
                            Poin saat ini: <strong>{{ $mahasiswa->poin_kredit }} / {{ $maxPoin }}</strong>
                        </li>
                        <li class="mb-2">
                            <i class="mdi mdi-check-circle text-success"></i> Semua administrasi lunas
                        </li>
                    </ul>

                    @if(!$cukupPoin)
                        <div class="mt-3">
                            <p class="text-muted small">Anda perlu <strong>{{ $maxPoin - $mahasiswa->poin_kredit }} poin
                                    lagi</strong> untuk mengajukan SKPI.</p>
                            <a href="{{ route('mahasiswa.pengajuan-sertifikat') }}"
                                class="btn btn-sm btn-outline-primary w-100">
                                <i class="mdi mdi-plus"></i> Ajukan Sertifikat
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;

            Swal.fire({
                title: 'Konfirmasi Pengajuan SKPI',
                html: `
                                <div style="text-align: left; padding: 4px 0;">
                                    <div style="background: #f8f9fa; border-radius: 8px; padding: 14px 16px; margin-bottom: 4px;">
                                        <div style="margin-bottom: 12px;">
                                            <div style="font-size:12px; font-weight:600; color:#adb5bd; text-transform:uppercase; letter-spacing:0.5px;">NIM</div>
                                            <div style="font-size:14px; color:#212529; margin-top:2px;">{{ $mahasiswa->nim }}</div>
                                        </div>
                                        <div style="margin-bottom: 12px;">
                                            <div style="font-size:12px; font-weight:600; color:#adb5bd; text-transform:uppercase; letter-spacing:0.5px;">Nama Mahasiswa</div>
                                            <div style="font-size:14px; color:#212529; margin-top:2px;">{{ $mahasiswa->nama_mhs }}</div>
                                        </div>
                                        <div style="margin-bottom: 12px;">
                                            <div style="font-size:12px; font-weight:600; color:#adb5bd; text-transform:uppercase; letter-spacing:0.5px;">Program Studi</div>
                                            <div style="font-size:14px; color:#212529; margin-top:2px;">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div style="font-size:12px; font-weight:600; color:#adb5bd; text-transform:uppercase; letter-spacing:0.5px;">Poin Kredit</div>
                                            <div style="font-size:14px; color:#198754; font-weight:600; margin-top:2px;">{{ $mahasiswa->poin_kredit }} / {{ $maxPoin }}</div>
                                        </div>
                                    </div>
                                    <p style="font-size:13px; color:#6c757d; margin:10px 0 0; text-align:center;">
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
    </script>
@endsection