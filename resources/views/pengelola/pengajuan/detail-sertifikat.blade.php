@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-note-search-outline"></i>
                </span> Detail Pengajuan Sertifikat
            </h3>
        </div>

        {{-- LEFT: PREVIEW FILE --}}
        <div class="col-md-6">
            <div class="card p-3">

                @if($pengajuan->file_path)
                    @php
                        $ext = pathinfo($pengajuan->file_path, PATHINFO_EXTENSION);
                    @endphp

                    @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                        <img src="{{ asset('storage/' . $pengajuan->file_path) }}" class="img-fluid">
                    @elseif($ext == 'pdf')
                        <iframe src="{{ asset('storage/' . $pengajuan->file_path) }}" width="100%" height="500px"></iframe>
                    @else
                        <p>Format tidak didukung</p>
                    @endif
                @else
                    <p>Tidak ada file</p>
                @endif

            </div>
        </div>

        {{-- RIGHT: DATA + FORM --}}
        <div class="col-md-6">
            <div class="card p-3">

                <p><strong>Nama:</strong> {{ $pengajuan->mahasiswa->nama_mhs }}</p>
                <p><strong>NIM:</strong> {{ $pengajuan->nim }}</p>
                <p><strong>Nama Sertifikat:</strong> {{ $pengajuan->nama_sertifikat }}</p>
                <p><strong>Kategori:</strong> {{ $pengajuan->kategori->nama_kategori ?? '-' }}</p>
                <p><strong>Sub Kategori:</strong> {{ $pengajuan->subKategori->nama_sub_kategori ?? '-' }}</p>
                <p><strong>Level:</strong> {{ $pengajuan->level->nama_level ?? '-' }}</p>
                <p><strong>Estimasi Poin:</strong> {{ $pengajuan->poin_akhir ?? '-' }}</p>
                <p><strong>Tanggal:</strong> {{ $pengajuan->tgl_pengajuan_sertifikat->format('d-m-Y') }}</p>

                <hr>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pengelola.pengajuan-sertifikat.update', $pengajuan->id_pengajuan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- STATUS --}}
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $pengajuan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diterima" {{ $pengajuan->status == 'diterima' ? 'selected' : '' }}>Diterima
                            </option>
                            <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    {{-- FEEDBACK --}}
                    <div class="mb-3">
                        <label>Feedback</label>
                        <textarea name="feedback" class="form-control" rows="4">{{ $pengajuan->feedback }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">Simpan</button>

                        <a href="{{ route('pengelola.pengajuan-sertifikat.index') }}" class="btn btn-danger">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection