@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-history"></i>
                </span> Riwayat Pengajuan
            </h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Riwayat Pengajuan</h4>

                    {{-- FORM SEARCH & FILTER --}}
                    <form method="GET" class="mb-3">
                        <div class="d-flex flex-wrap gap-2 align-items-stretch">

                            {{-- FILTER JENIS PENGAJUAN --}}
                            <div style="flex: 1; min-width: 220px;">
                                <select name="jenis" class="form-control h-100">
                                    <option value="">Semua Jenis</option>
                                    <option value="sertifikat" {{ request('jenis') == 'sertifikat' ? 'selected' : '' }}>
                                        Sertifikat</option>
                                    <option value="skpi" {{ request('jenis') == 'skpi' ? 'selected' : '' }}>SKPI</option>
                                </select>
                            </div>

                            {{-- FILTER STATUS --}}
                            <div style="flex: 1; min-width: 220px;">
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

                                @if(request()->hasAny(['status', 'jenis']))
                                    <a href="{{ route('mahasiswa.riwayat-pengajuan') }}" class="btn btn-danger">
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
                                    <th class="text-nowrap">Nama Sertifikat</th>
                                    <th class="text-nowrap">ID Pengajuan</th>
                                    <th class="text-nowrap">Jenis</th>
                                    <th class="text-nowrap">Poin</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($pengajuanSertifikat instanceof \Illuminate\Support\Collection)
                                    @forelse($pengajuanSertifikat as $p)
                                        <tr>
                                            <td class="align-middle">{{ $p->nama_sertifikat }}</td>
                                            <td class="align-middle">{{ $p->id_pengajuan }}</td>
                                            <td class="align-middle">Sertifikat</td>
                                            <td class="align-middle">{{ $p->poin_akhir ?? '-' }}</td>
                                            <td class="align-middle">
                                                @if($p->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($p->status == 'diproses')
                                                    <span class="badge badge-info">Diproses</span>
                                                @elseif($p->status == 'diterima')
                                                    <span class="badge badge-success">Diterima</span>
                                                @elseif($p->status == 'ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <a href="{{ route('mahasiswa.detail-sertifikat', $p->id_pengajuan) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="mdi mdi-note-text-outline"></i>
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                @else
                                    @forelse($pengajuanSertifikat as $p)
                                        <tr>
                                            <td class="align-middle">{{ $p->nama_sertifikat }}</td>
                                            <td class="align-middle">{{ $p->id_pengajuan }}</td>
                                            <td class="align-middle">Sertifikat</td>
                                            <td class="align-middle">{{ $p->poin_akhir ?? '-' }}</td>
                                            <td class="align-middle">
                                                @if($p->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($p->status == 'diproses')
                                                    <span class="badge badge-info">Diproses</span>
                                                @elseif($p->status == 'diterima')
                                                    <span class="badge badge-success">Diterima</span>
                                                @elseif($p->status == 'ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                <a href="{{ route('mahasiswa.detail-sertifikat', $p->id_pengajuan) }}"
                                                    class="btn btn-primary btn-sm">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                @endif

                                {{-- Pengajuan SKPI --}}
                                @if($pengajuanSKPI instanceof \Illuminate\Support\Collection)
                                    @forelse($pengajuanSKPI as $s)
                                        <tr>
                                            <td class="align-middle">SKPI</td>
                                            <td class="align-middle">{{ $s->id_pengajuan_skpi }}</td>
                                            <td class="align-middle">SKPI</td>
                                            <td class="align-middle">-</td>
                                            <td class="align-middle">
                                                @if($s->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($s->status == 'diproses')
                                                    <span class="badge badge-info">Diproses</span>
                                                @elseif($s->status == 'diterima')
                                                    <span class="badge badge-success">Diterima</span>
                                                @elseif($s->status == 'ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                @if($s->status === 'diterima')
                                                    <a href="{{ route('mahasiswa.print-skpi', $s->id_pengajuan_skpi) }}"
                                                        class="btn btn-warning btn-sm" target="_blank">
                                                        <i class="mdi mdi-printer"></i> Cetak SKPI
                                                    </a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm" disabled>
                                                        <i class="mdi mdi-printer"></i> Cetak SKPI
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                @else
                                    @forelse($pengajuanSKPI as $s)
                                        <tr>
                                            <td class="align-middle">SKPI</td>
                                            <td class="align-middle">{{ $s->id_pengajuan_skpi }}</td>
                                            <td class="align-middle">SKPI</td>
                                            <td class="align-middle">-</td>
                                            <td class="align-middle">
                                                @if($s->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($s->status == 'diterima')
                                                    <span class="badge badge-success">Diterima</span>
                                                @elseif($s->status == 'ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                @if($s->status === 'diterima')
                                                    <a href="{{ route('mahasiswa.print-skpi', $s->id_pengajuan_skpi) }}"
                                                        class="btn btn-warning btn-sm" target="_blank">
                                                        <i class="mdi mdi-printer"></i> Cetak
                                                    </a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm" disabled>
                                                        <i class="mdi mdi-printer"></i> Cetak
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                @endif

                                @if(($pengajuanSertifikat instanceof \Illuminate\Support\Collection ? $pengajuanSertifikat->isEmpty() : $pengajuanSertifikat->count() == 0) && ($pengajuanSKPI instanceof \Illuminate\Support\Collection ? $pengajuanSKPI->isEmpty() : $pengajuanSKPI->count() == 0))
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <em>Belum ada data pengajuan</em>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        {{-- PAGINATION --}}
                        @if($pengajuanSertifikat instanceof \Illuminate\Pagination\Paginator || $pengajuanSertifikat instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="d-flex justify-content-end mt-3">
                                {{ $pengajuanSertifikat->links() }}
                            </div>
                        @elseif($pengajuanSKPI instanceof \Illuminate\Pagination\Paginator || $pengajuanSKPI instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="d-flex justify-content-end mt-3">
                                {{ $pengajuanSKPI->links() }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection