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
                <a class="nav-link" href="{{ route('dashboard-admin') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#admin-data" aria-expanded="false"
                    aria-controls="admin-data">
                    <span class="menu-title">Data Management</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-database menu-icon"></i>
                </a>
                <div class="collapse" id="admin-data">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('data-mahasiswa') }}">Data Mahasiswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('data-pengelola') }}">Data Pengelola</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('data-fakultas') }}">Data Fakultas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('data-kategori') }}">Data Kategori</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        {{-- MENU PENGELOLA --}}
        @if($user->role === 'pengelola')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard-pengelola') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('data-pengajuan') }}">
                    <span class="menu-title">Data Pengajuan</span>
                    <i class="mdi mdi-file-document menu-icon"></i>
                </a>
            </li>
        @endif

        {{-- MENU MAHASISWA --}}
        @if($user->role === 'mahasiswa')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard-mahasiswa') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
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
                            <a class="nav-link" href="#">Lihat Pengajuan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profile</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="menu-title">Logout</span>
                <i class="mdi mdi-logout menu-icon"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>