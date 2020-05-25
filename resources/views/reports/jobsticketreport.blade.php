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
				<th>Publisher</th>
				<th>Received Date</th>	
				<th>Due Date</th>	
				<th>Dispatch Date</th>
				<th>Current Process</th>							
				<?php if($articletype != 'withoutticket') { ?>
					<th>Ticket Count</th>	
				<?php } ?>							
				<th>Source File & Location</th>			
				
            </tr>
        </thead>
        <tbody>
            @if (count($result))
						@foreach ($result as $k => $results)
							<tr>             						
									<td class='bgcolor'><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
									<td class='bgcolor'><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>
									<td class='bgcolor'>{{ $results->publisher }}</td>
									<td class='bgcolor'>{{ $results->received_date }}</td>
									<td class='bgcolor'>{{ $results->duedate }}</td>	
									<td class='bgcolor'>{{ $results->dispatchdate }}</td>
									<td class='bgcolor'>{{ $results->current_process }}</td>
									<?php if($articletype != 'withoutticket') { ?>
										<td class='bgcolor'>{{ $results->Ticket_Total_Count }}</td>
									<?php } ?>
									<td class='bgcolor'>
										Name:&nbsp;&nbsp;{{ $results->filename }}<br />
										Path:&nbsp;&nbsp;&nbsp;&nbsp;{{ $results->filepath }}
									</td>									
								</tr>
						  @endforeach
						@else
							
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
					"paging":  false,
					fixedColumns:   {
							leftColumns: 2
					}
					
				} );
			} )
        			
		}, 200);
		
	</script>