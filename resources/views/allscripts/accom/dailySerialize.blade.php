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