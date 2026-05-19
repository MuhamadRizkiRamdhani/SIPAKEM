@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Detail Pengajuan Sertifikat</h4>
                        <a href="{{ route('mahasiswa.riwayat-pengajuan') }}" class="btn btn-secondary btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-2">Nama Sertifikat</p>
                            <h6>{{ $pengajuan->nama_sertifikat }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-2">ID Pengajuan</p>
                            <h6>{{ $pengajuan->id_pengajuan }}</h6>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-2">Tanggal Pengajuan</p>
                            <h6>{{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan_sertifikat)->format('d-m-Y') }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-2">Status</p>
                            <div>
                                @if($pengajuan->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($pengajuan->status == 'diproses')
                                    <span class="badge bg-info">Diproses</span>
                                @elseif($pengajuan->status == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($pengajuan->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-2">Kategori</p>
                            <h6>{{ $pengajuan->kategori->nama_kategori ?? '-' }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-2">Estimasi Poin</p>
                            <h6>
                                @if($pengajuan->poin_akhir)
                                    <span class="badge bg-primary">{{ $pengajuan->poin_akhir }} Poin</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </h6>
                        </div>
                    </div>

                    <hr>
                    @if($pengajuan->feedback)
                        <div class="alert alert-info mb-4" role="alert">
                            <h6 class="alert-heading">Feedback</h6>
                            <p class="mb-0">{{ $pengajuan->feedback }}</p>
                        </div>
                    @endif

                    @if($pengajuan->file_path)
                        <div class="mb-4">
                            <p class="text-muted mb-2">File Sertifikat</p>
                            <div class="d-flex gap-2">
                                <a href="{{ asset('storage/' . $pengajuan->file_path) }}" target="_blank"
                                    class="btn btn-primary btn-sm">
                                    <i class="mdi mdi-eye"></i> Lihat File
                                </a>
                                <a href="{{ asset('storage/' . $pengajuan->file_path) }}" download
                                    class="btn btn-secondary btn-sm">
                                    <i class="mdi mdi-download"></i> Download
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection