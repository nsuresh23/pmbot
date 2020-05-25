<style>
	div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;		
    }
	.dataTables_wrapper {
		overflow: inherit;
	}
	.modal-footer {
		display:none !important;
	}
	.modal-body{height:470px;}
	.dataTables_scrollBody{ height:300px !important;}
</style>
<div id='popuploader' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
<table id="example" class="display nowrap example" cellspacing="0" width="100%">
        <thead>
            <tr>
				<th style='background-color:#fff;'>Job Id</th>
				<th>Order Id</th>  
				<th>Project Type</th> 
				<th>Publisher</th>  
				<th>Total Ticket</th>
				<th>Pending Ticket</th>
				<th>Progress Ticket</th>
				<th>Completed Ticket</th>	
				<th>Query Ticket</th>	
				<th>Target Date</th>								
				<th>Journal Id</th>
				<th>Source</th>  
				<th>Issue</th>				
				<th>Vol</th> 
				<th>YOP</th>	
				<th >Source File Name & Location</th> 
				<th>View</th> 
            </tr>
        </thead>
        <tbody>
            @if (count($result))
				@foreach ($result as $k => $results)
					<tr> 
						<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->project_type }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->totalticket }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pendingticket }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->progressticket }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->completedticket }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->queryticket }}</td>
		
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->duedate != '' ? date('d-M-y', strtotime($results->duedate)) : "" }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srcid }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srctitle }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->issfirst }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->volfirst }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pyear }}</td>	
						<td @if ($k % 2 == 0) class='bgcolor' @endif>
							<b>Name:</b>&nbsp;&nbsp;{{ $results->filename }}<br />
							<b>Path:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{ $results->filepath }}
						</td>	
						<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/query-list')}}/{{ $results->job_id }}" >View</a></td>																		
					</tr>
				  @endforeach
				@endif
           
        </tbody>
    </table>
	<script>
		setTimeout(function() {
			$(document).ready(function() {
				document.getElementById("popuploader").style.display = "none";
				$('.example').DataTable( {
					"scrollY": 200,
					"scrollX": true,
					"paging":  true,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100],
					fixedColumns:   {
							leftColumns: 2
					}
					
				} );
			} )
        			
		}, 200);
		
	</script>