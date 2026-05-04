<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-text d-flex flex-column">
                    @php
                        $user = auth()->user();
                        $userName = '';
                        $userRole = ucfirst($user->role);

                        if ($user->role === 'admin') {
                            $userName = $user->admin->nama_admin ?? 'Admin';
                        } elseif ($user->role === 'mahasiswa') {
                            $userName = $user->mahasiswa->nama_mhs ?? 'Mahasiswa';
                        } elseif ($user->role === 'pengelola') {
                            $userName = $user->pengelola->nama_pengelola ?? 'Pengelola';
                        }
                    @endphp
                    <span class="font-weight-bold mb-2">{{ $userName }}</span>
                    <span class="text-secondary text-small">{{ $userRole }}</span>
                </div>
            </a>
        </li>

        {{-- MENU ADMIN --}}
        @if($user->role === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#data-manajemen" aria-expanded="false"
                    aria-controls="data-manajemen">
                    <span class="menu-title">Data Pengguna</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-database menu-icon"></i>
                </a>
                <div class="collapse" id="data-manajemen">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.pengguna.index') }}">Data Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.mahasiswa.index') }}">Data Mahasiswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.pengelola.index') }}">Data Pengelola</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#data-fakultas" aria-expanded="false"
                    aria-controls="data-fakultas">
                    <span class="menu-title">Data Fakultas</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-domain menu-icon"></i>
                </a>
                <div class="collapse" id="data-fakultas">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.fakultas.index') }}">Data
                                Fakultas</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.prodi.index') }}">Data Program
                                Studi</a> </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#data-manajemen-kategori" aria-expanded="false"
                    aria-controls="data-manajemen-kategori">
                    <span class="menu-title">Data Kategori</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-shape-plus-outline menu-icon"></i>
                </a>
                <div class="collapse" id="data-manajemen-kategori">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.kategori.index') }}">Data Kategori</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.sub-kategori.index') }}">Data Sub-Kategori</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.level.index') }}">Data Level</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#data-pengajuan" aria-expanded="false"
                    aria-controls="data-pengajuan">
                    <span class="menu-title">Data Pengajuan</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-note-text-outline menu-icon"></i>
                </a>
                <div class="collapse" id="data-pengajuan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.data-pengajuan-sertifikat') }}">Data Pengajuan
                                Sertifikat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.data-pengajuan-skpi') }}">Data Pengajuan
                                SKPI</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu-poin" aria-expanded="false"
                    aria-controls="menu-poin">
                    <span class="menu-title">Kelola Poin</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-star-four-points-outline menu-icon"></i>
                </a>
                <div class="collapse" id="menu-poin">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.poin.index') }}">Aturan Poin</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        {{-- MENU PENGELOLA --}}
        @if($user->role === 'pengelola')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pengelola.dashboard') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#data-manajemen" aria-expanded="false"
                    aria-controls="data-manajemen">
                    <span class="menu-title">Manajemen Data</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-database menu-icon"></i>
                </a>
                <div class="collapse" id="data-manajemen">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengelola.data-mahasiswa') }}">Data Mahasiswa</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#data-pengajuan" aria-expanded="false"
                    aria-controls="data-pengajuan">
                    <span class="menu-title">Data Pengajuan</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-note-text-outline menu-icon"></i>
                </a>
                <div class="collapse" id="data-pengajuan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengelola.data-pengajuan-sertifikat') }}">Data Pengajuan
                                Sertifikat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengelola.data-pengajuan-skpi') }}">Data Pengajuan
                                SKPI</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        {{-- MENU MAHASISWA --}}
        @if($user->role === 'mahasiswa')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class=" mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#mhs-menu" aria-expanded="false"
                    aria-controls="mhs-menu">
                    <span class="menu-title">Menu Mahasiswa</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-file-document menu-icon"></i>
                </a>
                <div class="collapse" id="mhs-menu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mahasiswa.pengajuan-sertifikat') }}">Ajukan Sertifikat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mahasiswa.pengajuan-skpi') }}">Ajukan SKPI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mahasiswa.riwayat-pengajuan') }}">Riwayat Pengajuan</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
    </ul>
</nav>