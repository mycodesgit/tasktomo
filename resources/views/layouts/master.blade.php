<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free-V6/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}">
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

    <!-- Timer Script -->
    @include('allscripts.timerScript')

    <!-- Pulse Script -->
    @include('allscripts.pulseScript')

    <!-- Music Script -->
    @include('allscripts.musicScript')


</body>

</html>