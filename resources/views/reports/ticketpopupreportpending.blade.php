

	 <style type="text/css" class="init">
	
	/* Ensure that the demo table scrolls */
	th, td { white-space: nowrap; }
	div.dataTables_wrapper {
		width: 100%;
		margin:0 auto;
		min-height: 400px;		
	}
	.dataTables_wrapper .dataTables_info {
		display:none !important;
	}
	.dataTables_wrapper{		
		overflow: hidden !important;
	}
	.modal-footer {
		display:none !important;
	}	
	.modal-body{height:495px;}
	</style>
		
		<div class="box-body table-responsive ticketreportbox"><!--  no-padding -->		
		<div id='pendingticketloader' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
		<table id="pendingticket" style='width:auto !important;' class="stripe row-border order-column" cellspacing="0" width="100%">
				
					<thead>
						<tr>
							
								<th width='10%'>Job Id</th>								
								<th width='10%'>Order Id</th>				
								<th width='10%'>Ticket #</th> 				
								<th width='10%'>Ticket Type</th> 								
								<th width='10%'>Publisher</th> 
								<th width='10%'>Duedate</th>													
								<th width='10%'>Priority</th> 								
								<th width='10%'>Status</th> 
								<th width='10%'>File Name</th>
								
						</tr>
					</thead>
					<tbody>
						 @if (count($result))
							@foreach ($result as $k => $results)
								<tr>             															
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->job_id }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->order_id }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_id }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_type }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->tat }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->priority }}</td>														
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->status }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->file_name }}</td>									
								</tr>
							  @endforeach
							
							@endif
					</tbody>
				</table>
        </div>

	<script type="text/javascript" class="init">
		setTimeout(function() {
			$(document).ready(function() {
				document.getElementById("pendingticketloader").style.display = "none";
				$('#pendingticket').DataTable( {
					"scrollY": 300,
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
