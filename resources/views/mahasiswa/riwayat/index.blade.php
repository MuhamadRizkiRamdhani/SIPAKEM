@extends('layouts.app')

@section('content')
    <h1>Riwayat Pengajuan</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Riwayat Pengajuan</h4>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Sertifikat</th>
                                <th>ID_Pengajuan</th>
                                <th>Jenis Pengajuan</th>
                                <th>Estimasi Perolehan Poin</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Pengajuan Sertifikat --}}
                            @forelse($pengajuanSertifikat as $p)
                                <tr>
                                    <td>{{ $p->nama_sertifikat }}</td>
                                    <td>{{ $p->id_pengajuan }}</td>
                                    <td>Sertifikat</td>
                                    <td>{{ $p->poin_akhir ?? '-' }}</td>
                                    <td>
                                        @if($p->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($p->status == 'diproses')
                                            <span class="badge badge-info">Diproses</span>
                                        @elseif($p->status == 'diterima')
                                            <span class="badge badge-success">Disetujui</span>
                                        @elseif($p->status == 'ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/' . $p->file_path) }}" target="_blank"
                                            class="btn btn-primary btn-sm">
                                            Tinjau
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pengajuan sertifikat</td>
                                </tr>
                            @endforelse

                            {{-- Pengajuan SKPI --}}
                            @forelse($pengajuanSKPI as $s)
                                <tr>
                                    <td>SKPI</td>
                                    <td>{{ $s->id_pengajuan_skpi }}</td>
                                    <td>SKPI</td>
                                    <td>-</td>
                                    <td>
                                        @if($s->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($s->status == 'diproses')
                                            <span class="badge badge-info">Diproses</span>
                                        @elseif($s->status == 'diterima')
                                            <span class="badge badge-success">Disetujui</span>
                                        @elseif($s->status == 'ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm" disabled>Tinjau</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pengajuan SKPI</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection