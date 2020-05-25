<style type="text/css" class="init">
	
	/* Ensure that the demo table scrolls */
	th, td { white-space: nowrap; }
	div.dataTables_wrapper {
		width: 100%;
		margin:0 auto;
		min-height: 450px;		
	}
	.dataTables_wrapper{		
		overflow: hidden !important;
	}
	.modal-footer {
		display:none !important;
	}
	
	
	.modal-body{height:495px;}
	.ticketreportbox {
		overflow-x: inherit !important;
		max-height: 480px;
	}
	.loadingimg{height: 470px !important; }
	#ticketreport{color:black;opacity:0;}
	</style>
	
	

	

        <div class="box-body table-responsive ticketreportbox"><!--  no-padding -->
		
		<div id='ticketloader' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
		<table id="ticketreport" style='width:auto !important;' class="stripe row-border order-column" cellspacing="0" width="100%">
				
					<thead>
					
					 @if ($status == 'pending')
						<tr>							
								<th>Job Id</th>								
								<th>Order Id</th>	
								<th>Project Type</th> 
								<th>Ticket #</th> 				
								<th>Ticket Type</th> 	
								<th>Total Ticket</th>
								<th>Pending Ticket</th>
								<th>Progress Ticket</th>
								<th>Completed Ticket</th>	
								<th >Query Ticket</th>									
								<th>Publisher</th> 
								<th>Duedate</th>													
								<th>Priority</th> 								
								<th>Status</th> 
								<th>File Name</th>
								
						</tr>
					
					@else
						<tr>							
								<th style='background-color:#fff;'>Job Id</th>
								<th>Order Id</th>	
								<th>Project Type</th> 
								<th>Ticket #</th>
								<th>Ticket Type</th> 
								
								<th >Total Ticket</th>
								<th >Pending Ticket</th>
								<th >Progress Ticket</th>
								<th >Completed Ticket</th>	
								<th >Query Ticket</th>	
								
								<th>Publisher</th> 
								
								<th>Time Extend</th>   
								<th>Start Time</th>   
								<th>End Time</th>
								<th>Elapsed Time</th>
								<th>User</th> 							
								<?php if($_ENV['SHOW_VENDOR'] == '1') {?>
								<th>Vendor Name</th> 
								<?php } ?>
								<?php if($_ENV['SHOW_GROUP'] == '1') {?>
								<th>User Group </th> 
								<?php } ?>
								<th>User Ip </th>
								
								<th>File Name</th>
								<th>TAT</th>							
								<th style='background-color:#fff;'>Priority</th> 
						</tr>
					  @endif
					</thead>
					<tbody>
						 @if (count($result))
							@foreach ($result as $k => $results)
						
								@if ($status == 'pending')
									<tr>             															
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->order_id}}">{{ $results->order_id }}</a></td>									
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->project_type }}</td>	
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_id }}</td>	
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_type }}</td>
										
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->totalticket }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pendingticket }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->progressticket }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->completedticket }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->queryticket }}</td>
										
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->tat }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->priority }}</td>														
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->status }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->file_name }}</td>									
									</tr>								
								@else
									<tr>             						
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->order_id}}">{{ $results->order_id }}</a></td>		
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->project_type }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_id }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_type }}</td>
										
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->totalticket }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pendingticket }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->progressticket }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->completedticket }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->queryticket }}</td>
										
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_time_extend }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_start_time }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_end_time }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_elapsed_time }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->user_id }}</td>
										<?php if($_ENV['SHOW_VENDOR'] == '1') {?>									
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->group_name }}</td>
										<?php } ?>
										<?php if($_ENV['SHOW_GROUP'] == '1') {?>									
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->user_type }}</td>
										<?php } ?>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->user_working_ip }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->file_name }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->tat }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->priority }}</td>					
									</tr>
								@endif
								
							  @endforeach
							@else
								
							@endif
					</tbody>
				</table>
		</div>
		

	
		<script>		
		setTimeout(function() {
			$(document).ready(function() {
				
				document.getElementById("imgloader").style.display = "none";
				document.getElementById("ticketloader").style.display = "none";
				document.getElementById("ticketreport").style.opacity = "1";
				$('#ticketreport').DataTable( {
					"scrollY": 350,
					"scrollX": true,
					"paging":  false,
					"pageLength":  100,
					fixedColumns:   {
						leftColumns: 2
					}
					
				} );
			} )
        			
		}, 200);
		
	</script>