<!--  @extends('layouts.app') -->
	<style type="text/css" class="init">
		.dataTables_wrapper {			
			overflow: inherit !important;
		}
		th, td { white-space: nowrap; }
		div.dataTables_wrapper {
			width: 100%;
			margin: 0 auto;
		}
		
		.example_wrapper{		
			overflow: inherit !important;
		}
		.dataTables_scrollBody {min-height:60px !important;}
		.emptyheader{border-bottom:0px !important;border-top:1px solid black;border-left:1px solid black;}
		.refemptyheader{text-align: center !important;padding: 0; border: 1px solid black;}
		.jobemptyheader{text-align: center !important;padding: 0; border: 1px solid black;border-left:0px;}
		
		.subjobheader{border:1px solid black;border-right:0px;border-top:0px;}
		.suborheader{border:1px solid black;border-top:0px;border-right:0px;}
		.dataTables_empty{border-bottom:1px solid black;}
		.dataTables_wrapper.no-footer .dataTables_scrollBody{border-bottom:0px !important;}
		.dataTables_wrapper .dataTables_length { width:200px; }
		
	</style>
    @section('content')

      <div class="box">
        <div class="box-header">         
          @if (session('status'))
            <div class="alert alert-success">
               <strong>Success!</strong> {{ session('status') }}
            </div>
          @endif 
          <div class="box-tools">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive"><!--  no-padding -->
		
		
		<form class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
            {{ csrf_field() }}
			<div class='searchbox'>
				<div class='row form-group'>
				<div class="col-md-2">
					<label>Project:</label	>						
					 <select class="form-control" id="project" name="project">
						<option value="all" <?php if($project == 'all'){ ?> selected <?php } ?>>All</option>
						<option value="aip" <?php if($project == 'aip'){ ?> selected <?php } ?>>AIP</option>
						<option value="eflow" <?php if($project == 'eflow'){ ?> selected <?php } ?>>EFLOW</option>
					 </select>
				</div>
				<div class="col-md-2">
						<label>Publisher:</label	>						
		                 <select class="form-control" id="publisher" name="publisher">
							<option value="all" <?php if($publisher == 'all'){ ?> selected <?php } ?>>All</option>
							@foreach($publisherlist as $publishers)
								@if ($publishers->publisher != '')									
									<option value='{{$publishers->publisher}}' <?php if($publisher == $publishers->publisher){ ?> selected <?php } ?>> {{$publishers->publisher}}</option>								
								@endif																
							 @endforeach
						 </select>
	                </div>
					<div class="col-md-1" >                            
						<label>Date Type:</label>
						 <select class="form-control" id="fieldname" name="fieldname">
						    <option <?php if($fieldname == 'received_date') { ?> selected <?php } ?> value="received_date">Received Date</option>
							<option <?php if($fieldname == 'duedate') { ?> selected <?php } ?> value="duedate">Due Date</option>
						</select>
                    </div>	
					<div  class="col-md-1">                            
						 <label>Date:</label>
						 <input type='text' id='jobdate' class='form-control' name='jobdate' value='<?php echo $jobdate; ?>'> 
                    </div>
					<div  class="col-md-2" >                            
						<label>Current Process: </label>
						 <select class="form-control" id="currentprocess" name="currentprocess">
						 <option value=""></option>									
							   <?php foreach($currentprocess as $key => $value){ ?>
								 <option value="<?php echo $value->current_process; ?>" <?php if($fieldcurrentprocess == $value->current_process) { ?> selected <?php } ?> ><?php echo $value->current_process; ?></option> 
   							   <?php } ?>
						 </select>
                    </div>
					
					<div  class="col-md-1" >                            
						<label>Status:</label>
						 <select class="form-control" id="status" name="status">									
							<option value="all" <?php if($status == 'all'){ ?> selected <?php } ?>>All</option>
							<option value="pending" <?php if($status == 'pending'){ ?> selected <?php } ?>>Pending</option>
							<option value="progress" <?php if($status == 'progress'){ ?> selected <?php } ?>>Progress</option>
						 </select>
                    </div>
					
					<div class="col-md-1" style='padding-left:0px;'>
						<label>Order Id:</label>
						<input type='text' id='orderid' class='form-control' name='orderid' value='<?php echo $orderid; ?>'>
	                </div>
					<div class="col-md-1" style='padding-left:0px;'>
						<label>Job Id:</label>
						<input type='text' id='job_id' class='form-control' name='job_id' value='<?php echo $job_id; ?>'>
	                </div>
					
					
					<div class="col-md-1 form-group jobsrchbtn searchbtn" >
						<label>&nbsp;</label>	
						<input type='hidden' name='htAction' value='jobsupdate_search' />
						<input class="btn btn-primary" type="submit" value="Search">
				</div>
			</div>
		</div>	
		</form>			
		<div style='float: right;font-weight: bold;margin-bottom:5px;'>Next Job Id: <?php echo $nextjobid; ?></div>
		
		
          <table id="jobsupdate" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th></th>
							<th>Job Id</th>
							<th>Order Id</th>		 
							<th>Current Status</th>	
							<th>Priority </th>						  
							<th>Publisher</th>  
							<th>Due Date</th>								
							<th>Received Date</th>							
							<th>Source ID</th> 
							<th>Source Title</th>	
							<th>Remarks</th>	
							<th>Error Info</th>								
							<th>Source File & Location</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)
								<tr> 
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->job_id }}</td>            						
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>
									
									
									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->current_process }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->priority }}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->duedate }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->received_date }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srcid }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srctitle }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->remarks }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>
									<?php
										echo wordwrap($results->error_info,100,"<br>\n");
									?>
									</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>
										Name&nbsp;&nbsp;: {{ $results->filename }}<br />
										Path&nbsp;&nbsp;&nbsp;&nbsp; : {{ str_replace('RAZOR',' RAZOR ',$results->filepath) }}
									</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>
										<a onclick="showjobview('{{ $results->job_id }}')" href="javascript:void(0);" class="glyphicon glyphicon-edit "></a>
									</td>												
								</tr>								
							@endforeach
						@else
							
						@endif
					</tbody>
				</table>
				<input id="jobid-console-rows" value="" type="hidden" />
         

        </div>
        <!-- /.box-body -->
      </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
		<link type="text/css" href="https://cdn.datatables.net/s/dt/dt-1.10.10,se-1.1.0/datatables.min.css" rel="stylesheet" />
		<script type="text/javascript" src="https://cdn.datatables.net/s/dt/dt-1.10.10,se-1.1.0/datatables.min.js"></script>
		<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
		<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" class="init">
		$(document).ready(function() {
		var table = $('#jobsupdate').DataTable({
			scrollX:  true,
			scrollY:  500,
			scrollCollapse: true,
			scroller:       true,
		  	columnDefs: [{
				targets: 0,
				checkboxes: true
			 }],
		    order: [[1, 'asc']],
			dom: 'lBfrtip',
			lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
			buttons: [
				{
					text: 'Update Job Priority',
					action: function ( e, dt, node, config ) {
						var oTable = $('#jobsupdate').DataTable();
						var rows_selected = oTable.column(0).checkboxes.selected();
						checkvalue = $('#jobid-console-rows').val(rows_selected.join(","));
						if($('#jobid-console-rows').val() == ''){
							alert('Select Job!!');
							return false;
						} else {
							$.ajax({
								type: 'GET',
								url: "{{url('reports/priority_job_update')}}",
								data: 'ajaxload=1&jobid='+rows_selected.join(","),
								success: function(data){
									bootbox.alert(data);
								},
							  });
						}
						e.preventDefault();
					}
				}
			]
		});
		});
		
		$( function() {    
			$('#duedate').datepicker({format: 'yyyy-mm-dd'});
			$('#downloadeddate').datepicker({format: 'yyyy-mm-dd'});
		
		} );	
		
		
		function showjobview(jobid){
		$.ajax({
				type: 'GET',
				url: "{{url('reports/update_jobdetails')}}",
				data: 'ajaxload=1&jobid='+jobid,
				success: function(data){
					bootbox.alert(data);
				},
			  });					
		//bootbox.hideAll();
		}
		
		
		$('#jobid-frm').on('click', function(e){
		var oTable = $('#jobsupdate').DataTable();
		var rows_selected = oTable.column(0).checkboxes.selected();
		$('#jobid-console-rows').val(rows_selected.join(","));
		// Prevent actual form submission
		
			$.ajax({
				type: 'GET',
				url: "{{url('reports/priority_job_update')}}",
				data: 'ajaxload=1&jobid='+rows_selected.join(","),
				success: function(data){
					bootbox.alert(data);
				},
			  });
		
		
		
		
		
		e.preventDefault();
		});   
		
		</script>
       
@endsection

