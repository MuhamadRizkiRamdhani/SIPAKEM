<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SIPAKEM</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->

    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo_sipakem.png') }}" />
</head>
<style>
    /* ===== PERBAIKAN NAVBAR & SIDEBAR ===== */

    /* Navbar full width - override col-lg-12 */
    .content-wrapper .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
    }

    .content-wrapper .col-lg-12,
    .content-wrapper .col-12 {
        padding-left: 0 !important;
        padding-right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }

    @media (max-width: 768px) {
        .table {
            table-layout: auto !important;
        }

        .table th,
        .table td {
            width: auto !important;
        }
    }

    .navbar.default-layout-navbar {
        width: 100vw !important;
        left: 0 !important;
        right: 0 !important;
        margin-left: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        height: 63px;
        z-index: 1030;
    }

    /* Brand wrapper - fixed width samain sidebar */
    .navbar .navbar-brand-wrapper {
        width: 260px !important;
        min-width: 260px !important;
        height: 63px !important;
        flex-shrink: 0;
        justify-content: flex-start !important;
        padding-left: 25px !important;
    }

    /* Menu wrapper - ngisi sisa ruang */
    .navbar .navbar-menu-wrapper {
        flex: 1 !important;
        width: auto !important;
    }

    /* Page body wrapper */
    .page-body-wrapper {
        padding-top: 63px !important;
    }

    /* Main panel - dorong ke kanan */
    .main-panel {
        margin-left: 260px !important;
        width: calc(100% - 260px) !important;
        transition: all 0.3s ease;
    }

    .content-wrapper {
        padding: 25px 20px !important;
    }

    /* Sidebar */
    .sidebar {
        width: 260px !important;
        position: fixed !important;
        top: 63px !important;
        left: 0 !important;
        bottom: 0 !important;
        height: calc(100vh - 63px) !important;
        z-index: 1020;
        padding-top: 0 !important;
    }

    /* Saat sidebar diminimize, non-aktifkan submenu */
    .sidebar-icon-only .sidebar .nav-item .collapse {
        display: none !important;
        pointer-events: none !important;
    }

    /* Hover popup submenu saat minimize */
    .sidebar-icon-only .sidebar .nav-item {
        position: relative;
    }

    .sidebar-icon-only .sidebar .nav-item:hover .collapse {
        display: block !important;
        pointer-events: auto !important;
        position: absolute;
        left: 70px;
        top: 0;
        width: 200px;
        background: #fff;
        border-radius: 0 8px 8px 0;
        box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 999;
        padding: 8px 0;
    }

    .sidebar-icon-only .sidebar .nav-item:hover .collapse .nav-item .nav-link {
        padding: 10px 20px !important;
        font-size: 13px;
        white-space: nowrap;
        color: #333;
        display: block;
    }

    .sidebar-icon-only .sidebar .nav-item:hover .collapse .nav-item .nav-link:hover {
        background: #f0f4ff;
        color: #4b7cf3;
        padding-left: 25px !important;
        transition: all 0.2s ease;
    }

    /* === SAAT SIDEBAR MINIMIZE === */
    .sidebar-mini .navbar-brand-wrapper,
    .sidebar-icon-only .navbar-brand-wrapper {
        width: 70px !important;
        min-width: 70px !important;
        padding-left: 15px !important;
    }

    .sidebar-mini .main-panel,
    .sidebar-icon-only .main-panel {
        margin-left: 70px !important;
        width: calc(100% - 70px) !important;
    }

    .sidebar-mini .sidebar,
    .sidebar-icon-only .sidebar {
        width: 70px !important;
    }

    /* Logo brand */
    .brand-logo-mini {
        display: none !important;
    }

    .sidebar-mini .brand-logo,
    .sidebar-icon-only .brand-logo {
        display: none !important;
    }

    .sidebar-mini .brand-logo-mini,
    .sidebar-icon-only .brand-logo-mini {
        display: flex !important;
    }

    /* Logo image */
    .logo-mini-img {
        width: 35px;
        height: 35px;
        object-fit: contain;
        flex-shrink: 0;
    }

    /* Footer */
    .footer {
        margin-left: 0 !important;
        transition: all 0.3s ease;
    }

    .sidebar-mini .footer,
    .sidebar-icon-only .footer {
        margin-left: 0 !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {
        .navbar.default-layout-navbar {
            width: 100vw !important;
            height: 60px;
        }

        .navbar .navbar-brand-wrapper {
            width: auto !important;
            min-width: auto !important;
            padding-left: 15px !important;
            flex: 1;
            justify-content: flex-start !important;
        }

        /* Logo + text di kiri */
        .navbar .brand-logo {
            display: flex !important;
        }

        .navbar .brand-logo-mini {
            display: none !important;
        }

        /* Menu wrapper di kanan */
        .navbar .navbar-menu-wrapper {
            flex: 0 !important;
            width: auto !important;
            padding-right: 10px !important;
        }

        /* Tombol hamburger & logout */
        .navbar-toggler {
            margin-right: 5px !important;
        }

        .nav-logout {
            margin-left: 5px !important;
        }

        .main-panel {
            margin-left: 0 !important;
            width: 100% !important;
        }

        .sidebar {
            left: -260px !important;
            top: 60px !important;
        }

        .sidebar.show,
        .sidebar-offcanvas.active {
            left: 0 !important;
        }

        /* Logo ukuran mobile */
        .logo-mini-img {
            width: 30px;
            height: 30px;
        }

        .brand-text {
            font-size: 16px;
        }

        /* Sembunyikan teks logout di mobile, tampilin icon doang */
        .logout-text {
            display: none !important;
        }
    }
</style>

<body>

    <div class="container-scroller">
        @include('sweetalert::alert')

        <!-- NAVBAR -->
        <!-- partial:partials/_navbar.html -->
        @include('layouts.partials.navbar')


        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- SIDEBAR -->
            <!-- partial:partials/_sidebar.html -->
            @include('layouts.partials.sidebar')
            <!-- partial -->


            <!-- MAIN CONTENT -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->


                <!-- FOOTER -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    @include('layouts.partials.footer')
                </footer>
                <!-- partial -->


            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src=" {{ asset('assets/js/dashboard.js') }}"></script>
    <!-- End custom js for this page -->
    @stack('scripts')
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggler = document.querySelector('.sidebar-toggler');

        if (sidebarToggler) {
            sidebarToggler.addEventListener('click', function () {
                setTimeout(() => {
                    const isMinimized = document.body.classList.contains('sidebar-icon-only');
                    if (isMinimized) {
                        sidebar.querySelectorAll('.collapse.show').forEach(el => {
                            const instance = bootstrap.Collapse.getInstance(el);
                            if (instance) instance.hide();
                        });
                    }
                }, 50);
            });
        }
    </script>

</body>

</html>