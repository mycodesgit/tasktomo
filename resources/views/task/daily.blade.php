<div class="chart-grid">
    <div class="chart-card">
        <div class="chart-card-header">
            <h4 class="text-left" id="timeHeader">Add Task</h4>
        </div>
        <div class="">
            <form method="POST" action="{{ route('store.task') }}" id="addDailytask">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="form-row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="">Select Task Title:</label>
                            <select name="tasktitle" class="form-control form-control-sm select2bs4" style="width: 100%;">
                                <option value="">--- Select ---</option>
                                @foreach ($option as $data)
                                    <option value="{{ $data->option_name }}">{{ $data->option_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="">Add Task Description:</label>
                            <textarea name="taskdesc" id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="">Select Task Tag:</label>
                            <select name="tasktag" id="" class="form-control form-control-sm select2bs4">
                                <option value=""> --Select Tag-- </option>
                                <option value="Development">Development</option>
                                <option value="Database">Database</option>
                                <option value="Documents">Documents</option>
                                <option value="Server">Server</option>
                                <option value="Network">Network</option>
                                <option value="Monitoring">Monitoring</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-card-header">
            <h4 class="text-left" id="timeHeader">My Task within this 15 days</h4>
        </div>
        <div class="">
            <div class="dashboard-table-header">
            </div>
            <div>
                <table id="dailyTable" class="table table-hover" width="100%" style="font-size: 10pt;">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Accomodation</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var dailyReadRoute = "{{ route('fetch.tasks') }}";
    var dailyCreateRoute = "{{ route('store.task') }}";
</script>


