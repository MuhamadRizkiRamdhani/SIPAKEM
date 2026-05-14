<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center"
        style="justify-content: flex-start; padding-left: 25px;">
        <a class="navbar-brand brand-logo d-flex align-items-center" href="#"
            style="text-decoration: none; gap: 10px; margin: 0;">
            <img src="{{ asset('assets/images/logo_sipakem.png') }}" alt="Logo" class="logo-mini-img">
            <span class="brand-text">SIPAKEM</span>
        </a>

        {{-- TAMBAHKAN INI --}}
        <a class="navbar-brand brand-logo-mini" href="#" style="text-decoration: none; margin: 0;">
            <img src="{{ asset('assets/images/logo_sipakem.png') }}" alt="Logo" class="logo-mini-img">
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-logout">
                <a class="nav-link d-flex align-items-center" href="#" id="logoutBtn" title="Logout">
                    <span class="logout-text d-none d-md-inline-block">Keluar</span>
                    <i class="mdi mdi-power"></i>
                </a>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('logoutBtn').addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b66dff',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form POST ke route logout
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('logout') }}';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>