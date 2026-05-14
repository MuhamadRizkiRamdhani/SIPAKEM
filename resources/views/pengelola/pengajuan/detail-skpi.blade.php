@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-12">

            <div class="card shadow-sm">

                <div class="card-body">

                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>
                            <h3 class="mb-1">Detail Pengajuan SKPI</h3>
                            <p class="text-muted mb-0">
                                Detail data pengajuan mahasiswa
                            </p>
                        </div>

                        @php
                            $statusClass = [
                                'pending' => 'secondary',
                                'diterima' => 'success',
                                'ditolak' => 'danger',
                            ];
                        @endphp

                        <span class="badge badge-{{ $statusClass[$pengajuan->status] ?? 'secondary' }} p-2">
                            {{ ucfirst($pengajuan->status) }}
                        </span>

                    </div>

                    <hr>

                    {{-- DATA --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Nama Mahasiswa</label>
                            <h5>{{ $pengajuan->mahasiswa->nama_mhs }}</h5>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted">NIM</label>
                            <h5>{{ $pengajuan->nim }}</h5>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Program Studi</label>
                            <h5>{{ $pengajuan->mahasiswa->prodi->nama_prodi ?? '-' }}</h5>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Fakultas</label>
                            <h5>{{ $pengajuan->mahasiswa->prodi->fakultas->nama_fakultas ?? '-' }}</h5>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Poin Kredit</label>
                            <h5>{{ $pengajuan->mahasiswa->poin_kredit ?? 0 }}</h5>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Tanggal Pengajuan</label>
                            <h5>{{ $pengajuan->tgl_pengajuan_skpi->format('d-m-Y') }}</h5>
                        </div>

                    </div>

                    <hr>

                    {{-- FORM --}}
                    @php
                        $prefix = auth()->user()->role;
                    @endphp

                    <form action="{{ route($prefix . '.pengajuan-skpi.update', $pengajuan->id_pengajuan_skpi) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status Pengajuan</label>
                                    <select name="status" class="form-control">
                                        <option value="pending" {{ $pengajuan->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="diproses" {{ $pengajuan->status == 'diproses' ? 'selected' : '' }}>
                                            Diproses</option>
                                        <option value="diterima" {{ $pengajuan->status == 'diterima' ? 'selected' : '' }}>
                                            Diterima</option>
                                        <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex">
                            <button class="btn btn-success me-2">Simpan Perubahan</button>
                            <a href="{{ route(auth()->user()->role . '.pengajuan-skpi.index') }}"
                                class="btn btn-light border">Kembali</a>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection