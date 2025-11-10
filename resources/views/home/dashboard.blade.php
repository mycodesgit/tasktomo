@extends('layouts.master')

@section('title')
    MIS TaskTomo - Dashboard
@endsection

@section('body')
    <div class="dashboard-content">
        <!-- Dashboard View -->
        <div class="dashboard-view active" id="dashboard">
            <!-- Charts -->
            <div class="chart-grid">
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h2 class="text-center" id="timeHeader">Start Time</h2>
                        <div class="d-flex justify-content-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sessionType" id="shortBreak" value="600" onchange="setDuration()">
                                <label class="form-check-label" for="shortBreak">
                                    Short Break
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sessionType" id="longBreak" value="1500" onchange="setDuration()">
                                <label class="form-check-label" for="longBreak">
                                    Long Break
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sessionType" id="allDay" value="28800" onchange="setDuration()">
                                <label class="form-check-label" for="allDay">
                                    All Day
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <h1 class="text-center timer-display" id="timer">00:00</h1>
                        <p class="text-center" id="focusLabel" style="display: none;">Focus Time Left:</p>
                        <div class="d-flex justify-content-center gap-2">
                            <div id="timerControls">
                                <button class="btn btn-success btn-lg" id="startBtn" onclick="startTimer()"><i class="fas fa-play"></i> Start</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-card-header">
                        <h2 class="text-left">Daily Work Pulse</h2>
                        <p class="chart-card-subtitle">
                            <i class="fas fa-circle text-gray"></i> Rest &nbsp;&nbsp;&nbsp;
                            <i class="fas fa-circle text-lessgreen"></i> Less Productive  &nbsp;&nbsp;&nbsp;
                            <i class="fas fa-circle text-success"></i> More Productive 
                        </p>
                    </div>
                    <div class="chart-container" id="activityChart">
                        
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="text-left" id="musicHeader">Focus Music</h2>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right gap-2">
                                    <div id="musicControls">
                                        <button class="btn btn-success btn-lg" id="musicPlayPause"><i class="fas fa-play"></i> Play</button>
                                        <button class="btn btn-warning btn-lg ml-2" id="musicNext"><i class="fas fa-forward-step"></i> Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <div class="text-center" id="musicyoutube" style="border-radius: 15px;">
                            <i class="fas fa-music fa-10x text-center"></i>
                            <!-- <iframe 
                                width="100%" 
                                height="200" 
                                src="https://www.youtube.com/embed/5yx6BWlEVcY?autoplay=0&loop=1&playlist=5yx6BWlEVcY&controls=1&modestbranding=1&rel=0" 
                                title="Chillhop Radio - Jazzy & Lofi Hip Hop Beats" 
                                frameborder="0" 
                                allowfullscreen>
                            </iframe> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Total Projects</div>
                        <div class="stat-card-icon primary">
                            <span class="fas fa-folder"></span>
                        </div>
                    </div>
                    <div class="stat-card-value">12</div>
                    <div class="stat-card-change positive">
                        <span class="fas fa-chart-line"></span>
                        <span>+2 this week</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Completed Tasks</div>
                        <div class="stat-card-icon success">
                            <span class="fas fa-circle-check"></span>
                        </div>
                    </div>
                    <div class="stat-card-value">48</div>
                    <div class="stat-card-change positive">
                        <span class="fas fa-chart-line"></span>
                        <span>+15% from last week</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Pending Tasks</div>
                        <div class="stat-card-icon warning">
                            <span class="fas fa-clock"></span>
                        </div>
                    </div>
                    <div class="stat-card-value">23</div>
                    <div class="stat-card-change negative">
                        <span class="fas fa-chart-line"></span>
                        <span>-3 from last week</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Team Members</div>
                        <div class="stat-card-icon info">
                            <span class="fas fa-users"></span>
                        </div>
                    </div>
                    <div class="stat-card-value">8</div>
                    <div class="stat-card-change positive">
                        <span class="fas fa-users"></span>
                        <span>+1 new member</span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="dashboard-table-container">
                <div class="dashboard-table-header">
                    <h3 class="dashboard-table-title">Recent Projects</h3>
                    <a href="#" class="btn btn-secondary">View All</a>
                </div>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="project-title-cell">
                                    <div class="project-icon">
                                        <span class="fas fa-globe"></span>
                                    </div>
                                    <div class="project-info">
                                        <div class="project-title-text">Website Redesign</div>
                                        <div class="project-meta-text">Frontend • 5 tasks</div>
                                    </div>
                                </div>
                            </td>
                            <td>85%</td>
                            <td><span class="status-badge success">In Progress</span></td>
                            <td>Dec 15, 2024</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="project-title-cell">
                                    <div class="project-icon">
                                        <span class="fas fa-mobile"></span>
                                    </div>
                                    <div class="project-info">
                                        <div class="project-title-text">Mobile App</div>
                                        <div class="project-meta-text">Mobile • 8 tasks</div>
                                    </div>
                                </div>
                            </td>
                            <td>60%</td>
                            <td><span class="status-badge warning">In Progress</span></td>
                            <td>Jan 20, 2025</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="project-title-cell">
                                    <div class="project-icon">
                                        <span class="fas fa-server"></span>
                                    </div>
                                    <div class="project-info">
                                        <div class="project-title-text">Database Migration</div>
                                        <div class="project-meta-text">Backend • 3 tasks</div>
                                    </div>
                                </div>
                            </td>
                            <td>100%</td>
                            <td><span class="status-badge success">Completed</span></td>
                            <td>Nov 30, 2024</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tasks View -->
        <div class="dashboard-view" id="tasks">
            @include('task.daily')
        </div>

        <!-- Reports View -->
        <div class="dashboard-view" id="reports">
            @include('reports.list')
        </div>

        <!-- Settings View -->
        <div class="dashboard-view" id="settings">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <span class="material-symbols-rounded">settings</span>
                </div>
                <h3 class="empty-state-title">Settings</h3>
                <p class="empty-state-description">Configure your dashboard preferences, manage team members,
                    and customize your workspace.</p>
            </div>
        </div>
    </div>
@endsection