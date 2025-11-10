<div class="chart-grid">
    <div class="chart-card">
        <div class="chart-card-header">
            <h4 class="text-left" id="timeHeader">Generate Reports</h4>
        </div>
        <div class="">
            <form id="reportForm" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <div class="d-flex align-items-end flex-wrap gap-3">
                        <!-- From -->
                        <div class="col-md-3">
                            <label for="start_date" class="form-label mb-1">From:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>

                        <!-- To -->
                        <div class="col-md-3">
                            <label for="end_date" class="form-label mb-1">To:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success"> 
                                <i class="fas fa-file-pdf"></i> OK, Generate
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="chart-grid">
    <div class="chart-card">
        <div class="chart-card-header">
            <h4 class="text-left" id="timeHeader">Generated Reports</h4>
        </div>
        <div class="">
            <!-- Placeholder icon (visible when no report) -->
            <div id="noReportIcon" class="text-center" style="margin-top: 30px;">
                <i class="fas fa-file-pdf fa-10x text-muted"></i>
                <p class="mt-2">No report generated yet. Please select dates and generate.</p>
            </div>
            
            <!-- Iframe (hidden initially, shown on load) -->
            <div id="pdfContainer" style="display: none;">
                <iframe id="pdfIframe" src="" width="100%" height="600px" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>


