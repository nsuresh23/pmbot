<style>
	div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;		
    }
	.dataTables_wrapper {
		overflow: inherit;
	}
	.modal {
		background: rgba(0, 0, 0, 0.59);
	}
	.modal-footer {
		display:none !important;
	}
	.modal-body{height:470px;}
	.dataTables_scrollBody{ height:300px !important;}
	#stockpopup{color:black;opacity:0;}
</style>
<div id='popuploader' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
<table id="stockpopup" class="display nowrap example" cellspacing="0" width="100%">
        <thead>
		 @if ($type != 'orders_in_hand' && $type != 'Orders_in_query')
            <tr>
				<th style='background-color:#fff;'>Job Id</th>
				<th>Order Id</th>  
				<th>Project Type</th>  
				<th>Publisher</th>  
				<th>Target Date</th>								
				<th>Jobs Downloaded Date</th>
				<th>Instance Details</th>  
				<th>Journal Id</th>
				<th>Source</th>  
				<th>Issue</th>				
				<th>Vol</th> 
				<th>YOP</th>					
				<th style='background-color:#fff;'>Source File & Location</th> 
            </tr>
		@else
		 <tr>
				<th style='background-color:#fff;'>Order Id</th>
				<th>Project Type</th>				
				<th>Rec Date</th>
				<th>Due-Date</th>
				<th>Title</th>
				<th>Year</th>							
				<th>Month</th>
				<th>Date</th>							
				<th>Pub Date Text</th>
				<th>Vol</th>							
				<th>Iss</th>						
										
				<th>Status</th>
				<th>Publisher</th>		
				<th>Order Type</th>													
				

				<th style='background-color:#fff;'>Source Type</th> 
            </tr>			
		@endif	
        </thead>
        <tbody>
            @if (count($result))
						@foreach ($result as $k => $results)
							@if ($type != 'orders_in_hand' && $type != 'Orders_in_query')
								<tr>             						
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>								
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->project_type }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->duedate != '' ? date('d-M-y', strtotime($results->duedate)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->created_date != '' ? date('d-M-y', strtotime($results->created_date)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srcid }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srctitle }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->issfirst }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->volfirst }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pyear }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>
									
									Name:&nbsp;&nbsp;{{ $results->filename }}<br />
									Path:&nbsp;&nbsp;&nbsp;&nbsp;{{ $results->filepath }}
									</td>					
								</tr>
							@else
								<tr> 							
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>								
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->project_type }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->received_date != '' ? date('d-M-y', strtotime($results->received_date)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->duedate != '' ? date('d-M-y', strtotime($results->duedate)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srctitle }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pyear }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pmonth }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pday }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pdatetext }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->volfirst }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->issfirst }}</td>	
										
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->status }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ordertype }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srctype }}</td>	
									
													
								</tr>	
							@endif		
						@endforeach
						@endif
           
        </tbody>
    </table>
	<script>
		setTimeout(function() {
			$(document).ready(function() {
				document.getElementById("imgloader").style.display = "none";
				document.getElementById("popuploader").style.display = "none";
				document.getElementById("stockpopup").style.opacity = "1";
				$('#stockpopup').DataTable( {
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
        			
		}, 300);
		
	</script>