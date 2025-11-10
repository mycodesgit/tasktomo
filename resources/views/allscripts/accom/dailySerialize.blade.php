<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right"
    };
    $(document).ready(function() {
        $('#addDailytask').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: dailyCreateRoute,
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        //console.log(response);
                        $(document).trigger('dailyAdded');
                        $('#addDailytask')[0].reset();
                        $('.select2, .select2bs4').val('').trigger('change');
                    } else {
                        toastr.error(response.message);
                        console.log(response);
                    }
                },
                error: function(xhr, status, error, message) {
                    var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                    toastr.error(errorMessage);
                }
            });
        });

        function formatDate(dateString) {
            return moment(dateString).format('MMM DD, YYYY');
        }

        var dataTable = $('#dailyTable').DataTable({
            "ajax": {
                "url": dailyReadRoute,
                "type": "GET",
                "data": function(d) {
                    d.year = $('#yearSelect').val();
                    d.month = $('#monthSelect').val();
                }
            },
            info: true,
            responsive: false,
            lengthChange: false,
            searching: false,
            paging: false,
            "columns": [
                {data: 'tasktitle'},
                {data: 'taskdesc'},
                {
                    data: 'acrt',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return formatDate(data); // Assuming formatDate function formats date as 'M. j, Y'
                        } else {
                            return data;
                        }
                    }
                },
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.id); 
            }
        });
        $(document).on('dailyAdded', function() {
            dataTable.ajax.reload();
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#reportForm').submit(function(event) {
            event.preventDefault();
            const formData = $(this).serialize();

            // Show loading state (optional)
            $('#noReportIcon').html('<i class="fas fa-spinner fa-spin fa-10x"></i><p>Generating report...</p>');

            // Submit via AJAX to POST route for generation
            $.ajax({
                url: "{{ route('generate.reports') }}",
                type: "POST",
                data: formData,
                xhrFields: {
                    responseType: 'blob' // For PDF binary
                },
                success: function(response, status, xhr) {
                    // Hide icon, show iframe
                    $('#noReportIcon').hide();
                    $('#pdfContainer').show();
                    
                    // Create blob URL for iframe src
                    const blob = new Blob([response], { type: 'application/pdf' });
                    const url = URL.createObjectURL(blob);
                    $('#pdfIframe').attr('src', url);
                    
                    toastr.success('Report generated successfully!');
                },
                error: function(xhr) {
                    console.error('Error generating PDF:', xhr);
                    // Reset to no-report state on error
                    $('#noReportIcon').html('<i class="fas fa-file-pdf fa-10x text-muted"></i><p class="mt-2">No report generated yet. Please select dates and generate.</p>').show();
                    $('#pdfContainer').hide();
                    $('#pdfIframe').attr('src', '');
                    toastr.error('Failed to generate report. Please check dates and try again.');
                }
            });
        });
    });
</script>