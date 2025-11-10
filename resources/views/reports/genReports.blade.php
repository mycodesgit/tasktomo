<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style>
		body {
			font-size: 9;
			font-family: Times New Roman;
		}
	    .title_task{
	        font-size: 12pt;
	        font-family: Arial, sans-serif;
	        font-weight: bold;
	        text-align: center;
	    }
	    .date_task{
	        margin-top: -15px;
	        font-size: 11pt;
	        font-family: Arial, sans-serif;
	        text-align: center;
	    }
	    table {
	        border-collapse: collapse;
	        width: 100%;
	        font-family: Arial, sans-serif;
	        font-size: 12px;
	    }
	    th, td {
	        padding: 8px;
	        text-align: left;
	        border: 1px solid #bbb;
	    }
	    th {
	        background-color: #f2f2f2;
	    }
	    tfoot td {
	        font-weight: bold;
	    }
	    .name_person{
	        padding-right: 50px;
	        padding-top: 30px;
	        font-size: 11pt;
	        font-weight: bold;
	        font-family: Arial, sans-serif;
	        text-align: right;
	    }
	    .position_person{
	        padding-right: 100px;
	        margin-top: -30px;
	        font-size: 11pt;
	        font-family: Arial, sans-serif;
	        text-align: right;
	    }
	    .supervisor_person{
	        padding-left: 30px;
	        padding-top: 30px;
	        font-size: 11pt;
	        font-weight: bold;
	        font-family: Arial, sans-serif;
	        text-align: left;
	    }
	    .supervisor_position{
	        padding-left: 35px;
	        margin-top: -30px;
	        font-size: 11pt;
	        font-family: Arial, sans-serif;
	        text-align: left;
	    }
	    .footer-logo-container {
	        position: absolute;
	        left: 10;
	        bottom: -10;
	        width: 100%;
	        text-align: center;
	    }

	    .footer-logo {
	        max-width: 100%;
	        max-height: 20%;
	        display: inline-block;
	        vertical-align: bottom;
	    }
	</style>
</head>
<body>
	<div>
	    <center>
	        <img src="{{ public_path('template/img/headerLogoNew1.png') }}" width="95%" height="14%" style="margin-top: -8px;">
	    </center>
	</div>

	<div>
	    <p class="title_task">Accomplishment Report</p>
	</div>
	<div>
	    <p class="date_task">
			@php
			    $start_date = request('start_date');
			    $end_date = request('end_date');
			    $formatted_from_date = date('F d', strtotime($start_date));
			    $formatted_to_date = date(' d, Y', strtotime($end_date));
			@endphp
			<p class='date_task'>{{ $formatted_from_date }} - {{ $formatted_to_date }}</p>
	    </p>
	</div>

	<div style="padding-right: 20px; padding-left: 20px;">
	    <table>
	        <thead>
	            <tr>
	                <th>No.</th>
	                <th>Task</th>
	                <th>Accommodation</th>
	            </tr>
	        </thead>
	        <tbody>
	            @if ($accom->isEmpty())
				<tr>
				    <td colspan="3" style="text-align: center;">No Accomplishment Report.</td>
				</tr>
				@else
					@php $no = 1; @endphp
				    @foreach ($accom as $generateReport)
				        <tr>
				            <td>{{ $no++ }}</td>
				            <td>{{ $generateReport->tasktitle }}</td>
				            <td>
							    @if ($group == "on")
							        {!! str_replace('-', '<br>', $generateReport->grouped_no_accom) !!}
							    @else
							        {!! str_replace('-', '<br>', $generateReport->no_accom) !!}
							    @endif
							</td>


				        </tr>
				    @endforeach
				@endif
	        </tbody>
	    </table>
	</div>

	<div class="name_person">
	    <p>{{ Auth::user()->fname }} {{ Auth::user()->mname }}. {{ Auth::user()->lname }}</p>
	</div>

	<div class="position_person">
	    <p>MIS Staff</p>
	</div>

	<div class="supervisor_person">
	    <p>MICHAEL A. BALIVIA</p>
	</div>

	<div class="supervisor_position">
	    <p>Immediate Supervisor</p>
	</div>

	<div class="footer-logo-container">
	    <img src="{{ public_path('template/img/footerLogoNew.png') }}" class="footer-logo" width="100%">
	</div>

</body>
</html>