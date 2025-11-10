<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free-V6/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('template/plugins/toastr/toastr.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/css/custom.css') }}" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="dashboard-container">
        <!-- Dashboard Sidebar -->
        <aside class="dashboard-sidebar" id="dashboardSidebar">
            <div class="dashboard-brand">
                <button class="dashboard-sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="logo">TaskTomo</a>
            </div>

            @include('control.sidebar')

            <!-- Back to Site Button -->
            <div class="sidebar-footer">
                <a href="#" class="btn btn-secondary sidebar-back-button">
                    <i class="fas fa-fas fa-palette fa-1x"></i>
                    <span class="btn-label">
                        <div class="theme-toggle" id="theme-toggle">
                            <div class="theme-option active" data-theme="light">Light</div>
                            <div class="theme-option" data-theme="dark">Dark</div>
                        </div>
                    </span>
                </a>
            </div>
        </aside>

        <div class="dashboard-sidebar-overlay" id="dashboardSidebarOverlay"></div>

        <!-- Dashboard Main Content -->
        <main class="dashboard-main">
            <!-- Dashboard Header -->
            <header class="dashboard-header">
                <!-- Header Content -->
                <div class="dashboard-header-content">
                    <button class="dashboard-sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="dashboard-header-title" id="dashboardTitle">Dashboard</h1>
                </div>

                <!-- Search Container -->
                <div class="search-container" id="searchContainer">
                    {{-- <span class="search-icon fas fa-search"></span> --}}
                    {{-- <input type="search" class="search-input form-input" placeholder="Management Information System Office" id="searchInput" readonly/> --}}
                    <h3 class="dashboard-header-title">Management Information System Office</h3>
                    <button class="search-close btn" id="searchClose">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>

                <!-- Header Actions -->
                <div class="dashboard-header-actions">
                    <!-- Mobile Search Button -->
                    <button class="mobile-search-btn btn btn-ghost" id="mobileSearchBtn">
                        <span class="fas fa-search"></span>
                    </button>

                    <!-- Notification Button -->
                    <div class="notification-button">
                        <span class="fas fa-bell"></span>
                        <div class="notification-badge">3</div>
                    </div>

                    <!-- User Profile -->
                    <div class="user-menu" id="userMenu">
                        <div class="user-menu-trigger" id="user-menu-trigger">
                            <div class="user-avatar-small">
                                <img src="{{ asset('template/img/user.jpg') }}" alt="User Avatar" />
                            </div>
                        </div>
                        <div class="user-menu-dropdown">
                            <a href="#" class="user-menu-item">
                                <i class="icon fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="#" class="user-menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="icon fas fa-power-off"></i>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            @yield('body')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('template/js/script.js') }}"></script>

    <!-- jQuery -->
    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script> 
    <script src="{{ asset('template/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('template/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('template/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
    

    <!-- Timer Script -->
    @include('allscripts.timerScript')

    <!-- Pulse Script -->
    @include('allscripts.pulseScript')

    <!-- Music Script -->
    @include('allscripts.musicScript')

    <!-- Music Script -->
    @include('allscripts.accom.dailySerialize')

    <script>
        $(function () {
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4',
            })
        });
    </script>

</body>

</html>