<nav class="dashboard-nav">
    <div class="dashboard-nav-section">
        <a href="{{ route('index.dashboard') }}" class="dashboard-nav-item active" data-view="dashboard">
            <i class="nav-icon fas fa-th"></i>
            <span class="nav-label">Dashboard</span>
        </a>
        <a href="{{ route('index.task') }}" class="dashboard-nav-item" data-view="tasks">
            <sipan class="nav-icon fas fa-tasks"></sipan>
            <span class="nav-label">Daily Task</span>
        </a>
        <a href="#" class="dashboard-nav-item" data-view="reports">
            <i class="nav-icon fas fa-chart-simple"></i>
            <span class="nav-label">Reports</span>
        </a>
        <a href="#" class="dashboard-nav-item" data-view="users">
            <i class="nav-icon fas fa-users"></i>
            <span class="nav-label">Users</span>
        </a>
    </div>
</nav>