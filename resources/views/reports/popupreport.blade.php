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
	#example{color:black;opacity:0;}
</style>
<div id='popuploader' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
<?php if($type == 'Checklist_HOLD') {?>
	
	<script src="{{url('js/datatables.min.js')}}"></script>
	<link type="text/css" href="{{url('css/dataTables.checkboxes.css')}}" rel="stylesheet" />
	<script src="{{url('js/dataTables.checkboxes.min.js')}}"></script>
	<script src="{{url('js/dataTables.buttons.min.js')}}"></script>
	<?php } ?>
<table id="example" class="display nowrap example" cellspacing="0" width="100%">
        <thead>		
            <tr>
				<?php if($type == 'Checklist_HOLD') {?>
				<th></th>
				<?php } ?>
				
				<th style='background-color:#fff;'>Job Id</th>
				<th>Order Id</th> 
				<th>Project Type</th> 				
				<th>Publisher</th>  
				@if ($ticketcount == 'yes')
					<th>Total Ticket</th>
					<th>Pending Ticket</th>
					<th>Progress Ticket</th>
					<th>Completed Ticket</th>	
					<th>Query Ticket</th>	
				@endif
				
				<th>Due Date</th>								
				<th>Received  Date</th>
				@if ($type != 'Signal' && $type != 'Signal_WIP' && $type != 'CheckList' && $type != 'CheckList_WIP')
				<th>Instance Details</th>  
				@endif	
				<th>Journal Id</th>
				<th>Source</th>  
				<th>Issue</th>				
				<th>Vol</th> 
				<th>YOP</th>
				<th>Remarks</th>	
				<th>Error Info</th>					
				<th style='background-color:#fff;'>Source File Name & Location</th> 
				@if ($type == 'Signal_HOLD' || $type == 'CheckList' || $type == 'Checklist_HOLD' || $type == 'Package')
					<th style='background-color:#fff;'>Signal File Path</th> 
				@endif	
            </tr>
        </thead>
        <tbody>
            @if (count($result))
						@foreach ($result as $k => $results)
							
								<tr>
								<?php if($type == 'Checklist_HOLD') {?>
								<td>{{ $results->orderid }}</td>         
								<?php } ?>
								      						
								<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>								
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->project_type }}</td>		
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>									
								@if ($ticketcount == 'yes')
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->totalticket }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pendingticket }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->progressticket }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->completedticket }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->queryticket }}</td>
								@endif
						
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->duedate != '' ? date('d-M-y', strtotime($results->duedate)) : "" }}</td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->created_date != '' ? date('d-M-y', strtotime($results->created_date)) : "" }}</td>
								@if ($type != 'Signal' && $type != 'Signal_WIP' && $type != 'CheckList' && $type != 'CheckList_WIP')
								<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
								@endif	
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srcid }}</td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srctitle }}</td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->issfirst }}</td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->volfirst }}</td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pyear }}</td>	
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->remarks }}</td>	
								<td @if ($k % 2 == 0) class='bgcolor' @endif>
								<?php
									echo wordwrap($results->error_info,100,"<br>\n");
								?>
								</td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif>
									<b>Name:</b>&nbsp;&nbsp;{{ $results->filename }}<br />
									<b>Path:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{ $results->filepath }}
								</td>	
								<!--@if ($type == 'Signal_HOLD' || $type == 'CheckList' || $type == 'Checklist_HOLD')
									<td @if ($k % 2 == 0) class='bgcolor' @endif>
									\\ppdys-fs03\Conversion_VI\{{ $results->project_type == 'eflow' ? "E-flow" : "AIP" }}\RAZOR\03-Signal\{{date('Y', strtotime($results->modified_date))}}\{{date('m', strtotime($results->modified_date))}}_{{date('M', strtotime($results->modified_date))}}\{{date('d', strtotime($results->modified_date))}}\CAR\{{ $results->publisher }}\{{ $results->orderid }}
									</td>
								@endif	-->	
								@if ($type == 'Signal_HOLD' || $type == 'CheckList' || $type == 'Checklist_HOLD' || $type == 'Package')
								<td @if ($k % 2 == 0) class='bgcolor' @endif>
								{{ $results->signal_path }}
								</td>
								@endif								
							</tr>
						  @endforeach
						@endif
		   
        </tbody>
    </table>
	<input id="jobid-console-rows" value="" type="hidden" />
	<script>
		setTimeout(function() {
			$(document).ready(function() {
				document.getElementById("imgloader").style.display = "none";
				document.getElementById("popuploader").style.display = "none";
				document.getElementById("example").style.opacity = "1";
				<?php if($type != 'Checklist_HOLD') {?>
				  	$('.example').DataTable( {
					"scrollY": 200,
					"scrollX": true,
					"paging":  false,
					"pageLength":  100,
					fixedColumns:   {
							leftColumns: 2
					}					
				} );
				<?php } ?>

			} )
        			
		}, 300);
		
		<?php if($type == 'Checklist_HOLD') {?>
		$(document).ready(function() {
		var table = $('.example').DataTable({
			scrollX:  true,
			scrollY:  200,
			scrollCollapse: true,
			scroller:       true,
			paging:  false,
							
		  	columnDefs: [{
				targets: 0,
				checkboxes: true
			 }],
		    order: [[1, 'DESC']],
			dom: 'lBfrtip',
			lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
			pageLength:  100,
			
			buttons: [
				{
					text: 'Update',
					className: 'btn btn-success ',
					action: function ( e, dt, node, config ) {
						var oTable = $('.example').DataTable();
						var rows_selected = oTable.column(0).checkboxes.selected();
						checkvalue = $('#jobid-console-rows').val(rows_selected.join(","));
						if($('#jobid-console-rows').val() == ''){
							alert('Select order!!');
							return false;
						} else {
							$.ajax({
								type: 'GET',
								url: "{{url('reports/updatepackage')}}",
								data: 'ajaxload=1&&orderid='+rows_selected.join(","),
								success: function(data){
									//bootbox.alert(data);
									bootbox.alert({ message: data, callback: function() {location.reload();} })
								},
							  });
						}
						e.preventDefault();
					}
				}
			]
		});
		});
		
		<?php } ?>
		
	</script>