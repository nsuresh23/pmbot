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
		
	</style>
 @section('content')
<?php //echo route('editgroup'); ?>
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
	                <div class="col-md-2" >
						<label>Report Type:</label>
		                 <select class="form-control" id="report_type" name="report_type">						
							<option value="all" <?php if($reporttype == 'all'){ ?> selected <?php } ?>>All</option>						 
							<option value="InputCheck" <?php if($reporttype == 'InputCheck'){ ?> selected <?php } ?>>Input Check</option>
							<option value="xmlconversion" <?php if($reporttype == 'xmlconversion'){ ?> selected <?php } ?>>BPA</option>
							<option value="itemtype" <?php if($reporttype == 'itemtype'){ ?> selected <?php } ?>>Item Type</option>
							<option value="hap" <?php if($reporttype == 'hap'){ ?> selected <?php } ?>>HAP</option>
							<option value="final_validation" <?php if($reporttype == 'final_validation'){ ?> selected <?php } ?>>Validation</option>
							<option value="packaging" <?php if($reporttype == 'packaging'){ ?> selected <?php } ?>>Signal & Package</option>
							<option value="dispatched" <?php if($reporttype == 'dispatched'){ ?> selected <?php } ?>>Dispatched </option>
						 </select>
	                </div>
	                <div class="col-md-2" >
						<label>Status:</label>
		                 <select class="form-control" id="report_status" name="report_status">		
							<option value="all" <?php if($pagestatus == 'all'){ ?> selected <?php } ?>>All</option>										 
							<option value="hold" <?php if($pagestatus == 'hold'){ ?> selected <?php } ?>>Hold</option>
							<option value="pending" <?php if($pagestatus == 'pending'){ ?> selected <?php } ?>>Pending</option>
							<option value="progress" <?php if($pagestatus == 'progress'){ ?> selected <?php } ?>>Progress</option>
							<option value="completed" <?php if($pagestatus == 'completed'){ ?> selected <?php } ?>>Completed</option>
						 </select>
	                </div>
	                <div class="col-md-2">
						<label>Order Id:</label>
						<input type='text' id='orderid' class='form-control' name='orderid' value='<?php echo $orderid; ?>'>
	                </div>		
					<div class="col-md-2">
		                 <label>Date:<span class='db_fieldright'>(Created Date)</span></label>
						 <input type='text' id='jobdate' class='form-control' name='jobdate' value='<?php echo $jobdate; ?>'> 
	                </div>						
					<div class="col-md-1 form-group searchbtn">
						<label>&nbsp;</label>	
						<input class="btn btn-primary" type="submit" value="Search">
						<input type='hidden' name='htAction' value='jobssearch' />
	                </div>
				</div>
			</div>
		</form>
		
	
		<table id="jobsreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Job Id</th>
							<th>Order Id</th>
							<th>Current Status</th>							  
							<th>Publisher</th>  
							<th>Due Date</th>								
							<th>Received Date</th>							
							<th>Source ID</th> 
							<th>Source Title</th>  
							<th>Issue</th>				
							<th>Vol</th> 
							<th>YOP</th>	
							<th>Remarks</th>	
							<th>Error Info</th>
							<th>Source File & Location</th> 
						</tr>
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)
								<tr>             						
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->current_process }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->duedate != '' ? date('d-M-y', strtotime($results->duedate)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->created_date != '' ? date('d-M-y', strtotime($results->created_date)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srcid }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srctitle }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->issfirst }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->volfirst }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pyear }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->remarks }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>
									<?php
										echo wordwrap($results->error_info,150,"<br>\n");
									?>
									</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>
										Name&nbsp;&nbsp;: {{ $results->filename }}<br />
										Path&nbsp;&nbsp;&nbsp;&nbsp; : {{ $results->filepath }}
									</td>
								</tr>
								
							@endforeach

						@endif
					</tbody>
				</table>
         

        </div>
        <!-- /.box-body -->
      </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
           <script type="text/javascript" class="init">
			$(document).ready(function() {
				var table = $('#jobsreport').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100],
					fixedColumns:   {
						leftColumns: 2
					}
				} );
			} );
		</script>
       
@endsection

