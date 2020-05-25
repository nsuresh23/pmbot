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
					<div class="col-md-2 ">
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
					<div class="col-md-3 noleftpadding norightpadding">
						<div class="row">

							<div class="col-md-6 norightpadding"> 
								<label>Report Type:</label>
	                              <select class="form-control" id="report_type" name="report_type">									
								  	<option value="all" <?php if($reporttype == 'all'){ ?> selected <?php } ?>>All</option>
									<option value="Item Type" <?php if($reporttype == 'Item Type'){ ?> selected <?php } ?>>Item Type</option>									
									<option value="Reference" <?php if($reporttype == 'Reference'){ ?> selected <?php } ?>>Reference</option>
									<option value="Grant" <?php if($reporttype == 'Grant'){ ?> selected <?php } ?>>Grant</option>
									<option value="Affiliation" <?php if($reporttype == 'Affiliation'){ ?> selected <?php } ?>>Affiliation</option>																		
									<option value="Math Expression" <?php if($reporttype == 'Math Expression'){ ?> selected <?php } ?>>Math Expression</option>
									<option value="Validation" <?php if($reporttype == 'Validation'){ ?> selected <?php } ?>>Final QC</option>
								 </select>
							</div>
							<div class="col-md-5 norightpadding">                           
								<label>Status:</label>
	                             <select class="form-control" id="report_status" name="report_status">													
									<option value="all" <?php if($pagestatus == 'all'){ ?> selected <?php } ?>>All</option>
									<option value="pending" <?php if($pagestatus == 'pending'){ ?> selected <?php } ?>>Pending</option>
									<option value="progress" <?php if($pagestatus == 'progress'){ ?> selected <?php } ?>>Progress</option>
									<option value="completed" <?php if($pagestatus == 'completed'){ ?> selected <?php } ?>>Completed</option>
									<option value="ticket_query" <?php if($pagestatus == 'ticket_query'){ ?> selected <?php } ?>>Query</option>
								 </select>
                    		</div>
						</div>
                    </div>										
					<?php if($_ENV['SHOW_GROUP'] == '1') {?>
					<div class="col-md-2 noleftpadding">                            
						<label>User Group:</label	>						
						 <select class="form-control" onchange='getUsergroup();' id="usergroup" name="usergroup">
							<option value="all" <?php if($usergroup == 'all'){ ?> selected <?php } ?>>All</option>
							<option value="1" <?php if($usergroup == '1'){ ?> selected <?php } ?>>In House</option>
							<option value="2" <?php if($usergroup == '2'){ ?> selected <?php } ?>>WFH</option>
						 </select>
                    </div>
					<?php } ?>
					<div style='display:none;' class="col-md-1 noleftpadding" id='vendor_list' >
						<label>WFH:</label>
						  <input class="form-control" type='text' id="vendor" name="vendor" value='<?php echo $vendor; ?>'>
                    </div>
					<div class="col-md-1 noleftpadding" >
						<label>Emp Code:</label>						
						 <input class="form-control" type='text' id="empcode" name="empcode" value='<?php echo $empcode; ?>'>
                    </div>
					<div class="col-md-1 noleftpadding" >
						<label>Order Id:</label>						
						 <input class="form-control" type='text' id="orderid" name="orderid" value='<?php echo $orderid; ?>'>
                    </div>
					<div class="col-md-1 noleftpadding" >
						<label>Job Id:</label>						
						 <input class="form-control" type='text' id="job_id" name="job_id" value='<?php echo $job_id; ?>'>
                    </div>
					<div class="col-md-2 " style='margin-top:10px;'>                            
						 <label>Date:<span class='db_fieldright'>(Created / Modified Date)</span></label>
						 <input type='text' id='ticketdate' class='form-control' name='ticketdate' value='<?php echo $ticketdate; ?>'> 
                    </div>				
					<div class="col-md-1  form-group jobsrchbtn" style="text-align: right;float:right;margin-right:0px;">					
						<label>&nbsp;</label>	
						<input type='hidden' name='htAction' value='jobssearch' />
						<input class="btn btn-primary" type="submit" value="Search">
				</div>
			</div>
		 </div>
		</form>
			@if ($requestdate !='')
				
          <table id="ticketreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Job Id</th> 
							<th>Order Id</th> 
							<th>Ticket Type</th> 
							<th>Publisher</th>  	
							<th>Received Date</th>	
							<th>Due Date</th>	
							<th>Unit Type</th>	
							<th>DOi</th>									
							<th>Ticket#</th> 
							<th>Start Time</th>   
							<th>End Time</th> 	
							<th>Conversion Time</th>	
							<th>Waiting Time</th>							
							<th>Time Extend</th>    				
							<th>Elapsed Time</th>  			
							<th>User</th> 
							<?php if($_ENV['SHOW_VENDOR'] == '1') {?>
							<th>Domain Name</th> 
							<?php } ?>
							<?php if($_ENV['SHOW_GROUP'] == '1') {?>
							<th>User Group </th> 
							<?php } ?>
							<th>User Ip </th>
							<th>TAT</th>
							<th>Priority</th>
							<th>File Name</th>
						</tr>
					</thead>
					<tbody>
						
						@if (count($result) )
							@foreach ($result as $k => $results)
								<tr>
									<td><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
									<td><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>
									<td>{{ $results->ticket_type }}</td>									
									<td>{{ $results->publisher }}</td>	
									<td>{{ $results->received_date }}</td>
									<td>{{ $results->duedate }}</td>	
									<td>{{ $results->unit_type }}</td>	
									<td>{{ $results->doi }}</td>										
									<td>{{ $results->ticket_id }}</td>
									<td>{{ $results->ticket_start_time }}</td>									
									<td>{{ $results->ticket_end_time }}</td>	
									<td>
											<?php
												echo gmdate("H:i:s",  $results->conversion_time);
											?>											
									</td>
									<td>
											<?php
												echo gmdate("H:i:s",  $results->waiting_time);
											?>											
									</td>									
									<td>{{ $results->ticket_time_extend }}</td>
									<td>{{ $results->ticket_elapsed_time }}</td>
									<td>{{ $results->user_id }}</td>
									<?php if($_ENV['SHOW_VENDOR'] == '1') {?>
									<td>{{ $results->group_name }}</td>
									<?php } ?>
									<?php if($_ENV['SHOW_GROUP'] == '1') {?>
									<td>{{ $results->user_type }}</td>	
									<?php } ?>
									<td>{{ $results->user_working_ip }}</td>
									<td>{{ $results->TAT }}</td>
									<td>{{ $results->priority }}</td>		
									<td>{{ $results->file_name }}</td>							
								</tr>								
							@endforeach
						@endif
					</tbody>
				</table>         
        @endif
        <!-- /.box-body -->
      </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
 		<script type="text/javascript" class="init">
			$(document).ready(function() {
				var table = $('#ticketreport').DataTable( {
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
