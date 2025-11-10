<div class="chart-grid">
    <div class="chart-card">
        <div class="chart-card-header">
            <h4 class="text-left" id="timeHeader">Add Task</h4>
        </div>
        <div class="">
            <form action="">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="">Select Task Title:</label>
                            <input type="text" name="" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="">Add Task Description:</label>
                            <textarea name="" id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="">Select Task Tag:</label>
                            <select name="tasktag" id="" class="form-control form-control-sm">
                                <option value=""> --Select Tag-- </option>
                                <option value="">Development</option>
                                <option value="">Database</option>
                                <option value="">Documents</option>
                                <option value="">Server</option>
                                <option value="">Network</option>
                                <option value="">Monitoring</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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

