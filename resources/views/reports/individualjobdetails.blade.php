<?php
	//use App\Http\Controllers\ReportController;
	//ReportController::average_time(); 
	function calculate_average_timeformat(
											$Total_Count, 
											$Completed_Count,
											$Pending_Count,
											$Progress_Count,				
											$Total_Time,
											$Operators_Worked_Count){											
		$str_returnval = array();		
		if($Total_Count > 0) {
			$str_returnval[0]	= $Total_Count; 
		}else{
			$str_returnval[0]	= '';
		}	
			
		if($Completed_Count > 0){
			$str_returnval[1]   = $Completed_Count; 
			$str_returnval[4]   = gmdate("H:i:s",  $Total_Time);
			$str_returnval[5]   = $Operators_Worked_Count;
			$str_returnval[6]   = gmdate("H:i:s", ($Total_Time/$Completed_Count));
		}else{
			$str_returnval[1]   = ''; 
			$str_returnval[4]   = '';
			$str_returnval[5]   = '';
			$str_returnval[6]   = '';						
		}
		
		if($Pending_Count > 0){
			$str_returnval[2]   = $Pending_Count;
		}else{
			$str_returnval[2]   = '';
		}
		
		if($Progress_Count > 0){
			$str_returnval[3]   = $Progress_Count;
		}else{
			$str_returnval[3]   = '';
		}
		
		return $str_returnval;	
	}	
?>
<!--  @extends('layouts.app') -->
	<style type="text/css" class="init">
		th, td { white-space: nowrap; }
		div.dataTables_wrapper {
			width: 100%;
			margin: 0 auto;
		}
		.dataTables_wrapper{		
			overflow: inherit !important;
		}
		.example_wrapper{		
			overflow: inherit !important;
		}
		.dataTables_scrollBody {min-height:60px !important;}
		#individualjobsreport_filter,#individualjobshistory_filter,#individualticketreport_filter,#individualquerylist_filter,#ticketstatusreport_filter,#ticketstatusreport_length{display:none;}
		#individualjobsreport_info,#individualticketreport_info,#individualquerylist_info,#ticketstatusreport_info,#individualjobshistory_info{font-size:11px;}
		.dataTables_wrapper.no-footer .dataTables_scrollBody{border-bottom:none !important;}
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
		 
		<div class='individual_heading'>
			Job Details:
		
		<table id="individualjobsreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Job Id</th>
							<th>Order Id</th>
							<th>Current Status</th>							  
							<th>Publisher</th>  
							<th>Due Date</th>								
							<th>Received Date</th>	
							<th>Dispatch Date</th>								
							<th>Unit Type</th>	
							<th>Source ID</th> 
							<th>Source Title</th>  
							<th>Issue</th>				
							<th>Vol</th> 
							<th>YOP</th>	
							<th>DOI</th>	
							<th>Source File & Location</th> 
						</tr>
					</thead>
					<tbody>
						@if (count($jobresult))
							@foreach ($jobresult as $k => $jobticketstatusresults)
								<tr>             						
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->job_id }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->orderid }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->current_process }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->publisher }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->duedate != '' ? date('d-M-y', strtotime($jobticketstatusresults->duedate)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->created_date != '' ? date('d-M-y', strtotime($jobticketstatusresults->created_date)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->dispatchdate != '' ? date('d-M-y', strtotime($jobticketstatusresults->dispatchdate)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->unittype }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->srcid }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->srctitle }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->issfirst }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->volfirst }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->pyear }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobticketstatusresults->doi }}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>
										Name&nbsp;&nbsp;: {{ $jobticketstatusresults->filename }}<br />
										Path&nbsp;&nbsp;&nbsp;&nbsp; : {{ $jobticketstatusresults->filepath }}
									</td>
								</tr>
								
							@endforeach

						@endif
					</tbody>
				</table>
				
			</div>	
			
			
			
			
			
		<div class='individual_heading'>
			Job Process:
		
		<table id="individualjobshistory" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Job Id</th>							
							<th>Process</th>
							<th>Username</th>
							<th>App Name</th>
							<th>App Version</th>
							<th>Machine</th>
							<th>Machine Ip</th>
							<th>Instance Name</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Remarks</th>							
						</tr>
					</thead>
					<tbody>
						@if (count($jobprocess))
							@foreach ($jobprocess as $k => $jobprocesslist)
								<tr>             						
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->job_id }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->process }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->username }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->app_name }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->app_version }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->machine }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->machine_ip }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->instance_name }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->Start_Time }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->End_Time }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobprocesslist->remarks }}</td>																	
								</tr>								
							@endforeach

						@endif
					</tbody>
				</table>
				
			</div>		
			
			
			
			
			
			
			
		<div class='individual_heading'>
			Job Update History:
		
		<table id="jobshistory" class="stripe row-border order-column" cellspacing="0" width="100%">		
					<thead>
						<tr>
							<th>Job Id</th>							
							<th>User</th>
							<th>Field</th>
							<th>Original Value</th>
							<th>Updated Value</th>
							<th>Remarks</th>
							<th>Ip Address</th>	
							<th>Created Date</th>	
						</tr>
					</thead>
					<tbody>
						@if (count($jobhistory))
							@foreach ($jobhistory as $k => $jobhistorys)
								<tr>             						
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobhistorys->job_id }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobhistorys->user }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobhistorys->field }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobhistorys->original_value }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobhistorys->updated_value }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobhistorys->remarks }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobhistorys->ip_address }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $jobhistorys->create_time }}</td>										
								</tr>								
							@endforeach

						@endif
					</tbody>
				</table>
				
			</div>		
			
			
			
			
			
			
			
			
			
			
			<div class='individual_heading'>
			Ticket Summary:
			
			<table id="ticketstatusreport" class="stripe row-border order-column" style=';' cellspacing="0" width="100%">
					<thead>						
						<tr>                
							<th class='emptyheader top-border left-border'></th>
	
							<th class='jobemptyheader top-border totaltype-bg left-border' style='border-right:0px;text-align:center;' colspan="7">Total Ticket Details</th>														
							<th class='jobemptyheader itemtype-bg left-border right-border top-border' style='text-align:center;' colspan="7">Item Type</th>
							<th colspan="7" align='center' style='text-align:center;'  class="jobemptyheader reference-bg top-border right-border">Reference</th>
							<th colspan="7" align='center' style='text-align:center;'  class="jobemptyheader grant-bg top-border right-border">Grant</th>
							<th colspan="7" align='center' style='text-align:center;'  class="jobemptyheader affiliation-bg top-border right-border">Affiliation</th>
							<th colspan="7" align='center' style='text-align:center;'  class="jobemptyheader mathexpression-bg top-border right-border">Math Expression</th>
							<th colspan="7" style='text-align:center;' align='center' class="jobemptyheader validation-bg top-border right-border">Final QC</th>
						</tr>		
						<tr>                
							<th class='subjobheader left-border'>Job Id</th>

							
							<th class='totaltype-bg left-border'>Total</th>
							<th class='totaltype-bg'>Completed</th>
							<th class='totaltype-bg'>Pending</th>
							<th class='totaltype-bg'>Progress</th>
							<th class='totaltype-bg'>Total Time</th>
							<th class='totaltype-bg'>Operators</th>
							<th class='totaltype-bg'>Average Time</th>								
							<th class='itemtype-bg left-border' >Total</th>
							<th class='itemtype-bg'>Completed</th>
							<th class='itemtype-bg'>Pending</th>
							<th class='itemtype-bg'>Progress</th>
							<th class='itemtype-bg'>Total Time</th>
							<th class='itemtype-bg '>Operators</th>
							<th class='itemtype-bg right-border'>Average Time</th>
							<th class='reference-bg'>Total</th>
							<th class='reference-bg'>Completed</th>
							<th class='reference-bg'>Pending</th>
							<th class='reference-bg'>Progress</th>
							<th class='reference-bg'>Total Time</th>
							<th class='reference-bg '>Operators</th>
							<th class='reference-bg right-border'>Average Time</th>							
							<th class='grant-bg'>Total</th>
							<th class='grant-bg'>Completed</th>
							<th class='grant-bg'>Pending</th>
							<th class='grant-bg'>Progress</th>
							<th class='grant-bg'>Total Time</th>
							<th class='grant-bg '>Operators</th>
							<th class='grant-bg right-border'>Average Time</th>							
							<th class='affiliation-bg '>Total</th>
							<th class='affiliation-bg'>Completed</th>
							<th class='affiliation-bg'>Pending</th>
							<th class='affiliation-bg'>Progress</th>
							<th class='affiliation-bg'>Total Time</th>
							<th class='affiliation-bg '>Operators</th>
							<th class='affiliation-bg right-border'>Average Time</th>
							<th class="mathexpression-bg">Total</th>
							<th class="mathexpression-bg">Completed</th>
							<th class="mathexpression-bg">Pending</th>
							<th class="mathexpression-bg">Progress</th>
							<th class="mathexpression-bg">Total Time</th>
							<th class='mathexpression-bg '>Operators</th>
							<th class='mathexpression-bg right-border'>Average Time</th>
							<th class="validation-bg">Total</th>
							<th class="validation-bg">Completed</th>
							<th class="validation-bg">Pending</th>
							<th class="validation-bg">Progress</th>
							<th class="validation-bg">Total Time</th>
							<th class='validation-bg '>Operators</th>
							<th class='validation-bg right-border'>Average Time</th>													
						</tr>															
					</thead>
					<tbody>
						@if (count($ticketstatusresult))
							@foreach ($ticketstatusresult as $k => $ticketstatusresults)
								<?PHP
									$ItemType_Avg			= '';
									$Reference_Avg			= '';
									$Grant_Avg				= '';
									$Affiliation_Avg		= '';
									$MathExpression_Avg		= '';																		
									$Validation_Avg			= '';									
									$Total_Avg				= '';

									$ItemType_Avg 			= calculate_average_timeformat($ticketstatusresults->ItemType_Ticket_Total_Count, $ticketstatusresults->ItemType_Ticket_Completed_Count, $ticketstatusresults->ItemType_Ticket_Pending_Count, $ticketstatusresults->ItemType_Ticket_Progress_Count, $ticketstatusresults->ItemType_Total_Time, $ticketstatusresults->ItemType_Operators_Worked_Count);
									$Reference_Avg 			= calculate_average_timeformat($ticketstatusresults->Reference_Ticket_Total_Count, $ticketstatusresults->Reference_Ticket_Completed_Count, $ticketstatusresults->Reference_Ticket_Pending_Count, $ticketstatusresults->Reference_Ticket_Progress_Count, $ticketstatusresults->Reference_Total_Time, $ticketstatusresults->Reference_Operators_Worked_Count);
									$Grant_Avg 				= calculate_average_timeformat($ticketstatusresults->Grant_Ticket_Total_Count, $ticketstatusresults->Grant_Ticket_Completed_Count, $ticketstatusresults->Grant_Ticket_Pending_Count, $ticketstatusresults->Grant_Ticket_Progress_Count, $ticketstatusresults->Grant_Total_Time, $ticketstatusresults->Grant_Operators_Worked_Count);
									$Affiliation_Avg 		= calculate_average_timeformat($ticketstatusresults->Affiliation_Ticket_Total_Count, $ticketstatusresults->Affiliation_Ticket_Completed_Count, $ticketstatusresults->Affiliation_Ticket_Pending_Count, $ticketstatusresults->Affiliation_Ticket_Progress_Count, $ticketstatusresults->Affiliation_Total_Time, $ticketstatusresults->Affiliation_Operators_Worked_Count);
									$MathExpression_Avg 	= calculate_average_timeformat($ticketstatusresults->MathExpression_Ticket_Total_Count, $ticketstatusresults->MathExpression_Ticket_Completed_Count, $ticketstatusresults->MathExpression_Ticket_Pending_Count, $ticketstatusresults->MathExpression_Ticket_Progress_Count, $ticketstatusresults->MathExpression_Total_Time, $ticketstatusresults->MathExpression_Operators_Worked_Count);
									$Validation_Avg 		= calculate_average_timeformat($ticketstatusresults->Validation_Ticket_Total_Count, $ticketstatusresults->Validation_Ticket_Completed_Count, $ticketstatusresults->Validation_Ticket_Pending_Count, $ticketstatusresults->Validation_Ticket_Progress_Count, $ticketstatusresults->Validation_Total_Time, $ticketstatusresults->Validation_Operators_Worked_Count);
									$Total_Avg 				= calculate_average_timeformat($ticketstatusresults->Jobs_Ticket_Total_Count, $ticketstatusresults->Jobs_Ticket_Completed_Count, $ticketstatusresults->Jobs_Ticket_Pending_Count, $ticketstatusresults->Jobs_Ticket_Progress_Count, $ticketstatusresults->Jobs_Total_Time, $ticketstatusresults->Jobs_Operators_Worked_Count);
								?>
							
								<tr>             						
									<td class='bgcolor left-border bottom-border'>{{ $ticketstatusresults->job_id }}</td>
									
																		
									<td class='totaltype-bg left-border bottom-border'>{{ $Total_Avg[0] }}</td>
									<td class='totaltype-bg bottom-border'>{{ $Total_Avg[1] }}</td>
									<td class='totaltype-bg bottom-border'>{{ $Total_Avg[2] }}</td>
									<td class='totaltype-bg bottom-border'>{{ $Total_Avg[3] }}</td>
									<td class='totaltype-bg bottom-border'>{{ $Total_Avg[4] }}</td>
									<td class='totaltype-bg bottom-border'>{{ $Total_Avg[5] }}</td>
									<td class='totaltype-bg bottom-border'>{{ $Total_Avg[6] }}</td>
									
									<td class='itemtype-bg left-border bottom-border'>{{ $ItemType_Avg[0] }}</td>
									<td class='itemtype-bg bottom-border'>{{ $ItemType_Avg[1] }}</td>
									<td class='itemtype-bg bottom-border'>{{ $ItemType_Avg[2] }}</td>
									<td class='itemtype-bg bottom-border'>{{ $ItemType_Avg[3] }}</td>
									<td class='itemtype-bg bottom-border'>{{ $ItemType_Avg[4] }}</td>
									<td class='itemtype-bg bottom-border'>{{ $ItemType_Avg[5] }}</td>
									<td class='itemtype-bg right-border bottom-border'>{{ $ItemType_Avg[6] }}</td>
									
									<td class='reference-bg bottom-border'>{{ $Reference_Avg[0] }}</td>
									<td class='reference-bg bottom-border'>{{ $Reference_Avg[1] }}</td>
									<td class='reference-bg bottom-border'>{{ $Reference_Avg[2] }}</td>									
									<td class='reference-bg bottom-border'>{{ $Reference_Avg[3] }}</td>
									<td class='reference-bg bottom-border'>{{ $Reference_Avg[4] }}</td>
									<td class='reference-bg bottom-border'>{{ $Reference_Avg[5] }}</td>
									<td class='reference-bg right-border bottom-border'>{{ $Reference_Avg[6] }}</td>
									
									<td class='grant-bg bottom-border'>{{ $Grant_Avg[0] }}</td>
									<td class='grant-bg bottom-border'>{{ $Grant_Avg[1] }}</td>	
									<td class='grant-bg bottom-border'>{{ $Grant_Avg[2] }}</td>
									<td class='grant-bg bottom-border'>{{ $Grant_Avg[3] }}</td>													
									<td class='grant-bg bottom-border'>{{ $Grant_Avg[4] }}</td>
									<td class='grant-bg bottom-border'>{{ $Grant_Avg[5] }}</td>
									<td class='grant-bg right-border bottom-border'>{{ $Grant_Avg[5] }}</td>
									
									<td class='affiliation-bg bottom-border'>{{ $Affiliation_Avg[0] }}</td>
									<td class='affiliation-bg bottom-border'>{{ $Affiliation_Avg[1] }}</td>	
									<td class='affiliation-bg bottom-border'>{{ $Affiliation_Avg[2] }}</td>
									<td class='affiliation-bg bottom-border'>{{ $Affiliation_Avg[3] }}</td>												
									<td class='affiliation-bg bottom-border'>{{ $Affiliation_Avg[4] }}</td>
									<td class='affiliation-bg bottom-border'>{{ $Affiliation_Avg[5] }}</td>
									<td class='affiliation-bg right-border bottom-border'>{{ $Affiliation_Avg[6] }}</td>
									
									<td class='mathexpression-bg bottom-border'>{{ $MathExpression_Avg[0] }}</td>
									<td class='mathexpression-bg bottom-border'>{{ $MathExpression_Avg[1] }}</td>	
									<td class='mathexpression-bg bottom-border'>{{ $MathExpression_Avg[2] }}</td>
									<td class='mathexpression-bg bottom-border'>{{ $MathExpression_Avg[3] }}</td>											
									<td class='mathexpression-bg bottom-border'>{{ $MathExpression_Avg[4] }}</td>
									<td class='mathexpression-bg bottom-border'>{{ $MathExpression_Avg[5] }}</td>
									<td class='mathexpression-bg right-border bottom-border'>{{ $MathExpression_Avg[6] }}</td>
									
									<td class='validation-bg bottom-border'>{{ $Validation_Avg[0] }}</td>
									<td class='validation-bg bottom-border'>{{ $Validation_Avg[1] }}</td>	
									<td class='validation-bg bottom-border'>{{ $Validation_Avg[2] }}</td>
									<td class='validation-bg bottom-border'>{{ $Validation_Avg[3] }}</td>												
									<td class='validation-bg bottom-border'>{{ $Validation_Avg[4] }}</td>
									<td class='validation-bg bottom-border'>{{ $Validation_Avg[5] }}</td>
									<td class='validation-bg right-border bottom-border'>{{ $Validation_Avg[6] }}</td>

								</tr>
								
							@endforeach
							
						@endif
					</tbody>
				</table>

			
			
				
		</div>
			
			
			
			
			
			
			
				
		<div class='individual_heading'>			
			Individual Ticket:
		<table id="individualticketreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Job Id</th> 							
							<th>Ticket Type</th> 																				
							<th>Ticket#</th> 
							<th>Start Time</th>   
							<th>End Time</th> 							
							<th>Time Extend</th>    				
							<th>Elapsed Time</th>  			
							<th>User</th> 
							<?php if($_ENV['SHOW_VENDOR'] == '1') {?>
							<th>Vendor Name</th> 
							<?php } ?>
							<?php if($_ENV['SHOW_GROUP'] == '1') {?>
							<th>User Group </th> 
							<?php } ?>
							<th>User Ip </th>
						</tr>
					</thead>
					<tbody>
						@if (count($ticketresult))
							@foreach ($ticketresult as $k => $ticketticketstatusresults)
								<tr>             						
									<td>{{ $ticketticketstatusresults->job_id }}</td>									
									<td>{{ $ticketticketstatusresults->ticket_type }}</td>
									<td>{{ $ticketticketstatusresults->ticket_id }}</td>
									<td>{{ $ticketticketstatusresults->ticket_start_time }}</td>									
									<td>{{ $ticketticketstatusresults->ticket_end_time }}</td>									
									<td>{{ $ticketticketstatusresults->ticket_time_extend }}</td>
									<td>{{ $ticketticketstatusresults->ticket_elapsed_time }}</td>
									<td>{{ $ticketticketstatusresults->user_id }}</td>
									<?php if($_ENV['SHOW_VENDOR'] == '1') {?>
									<td>{{ $ticketticketstatusresults->group_name }}</td>
									<?php } ?>
									<?php if($_ENV['SHOW_GROUP'] == '1') {?>
									<td>{{ $ticketticketstatusresults->user_type }}</td>	
									<?php } ?>
									<td>{{ $ticketticketstatusresults->user_working_ip }}</td>						
								</tr>								
							@endforeach
						@endif
					</tbody>
				</table> 		
			</div>	
			

					
         
		 
		 <div class='individual_heading'>
			Ticket Query:
		
				
		<table id="individualquerylist" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Job Id</th> 
							<th>User Id</th> 
							<th>Query Date</th> 
							<th>Ticket Type</th> 
							<th>Ticket Id</th> 
							<th>Elapsed Time</th>
							<th>Query</th> 
						</tr>
					</thead>
					<tbody>
						@if (count($queryresult))
							@foreach ($queryresult as $k => $queryticketstatusresults)
								
								<tr>             						
									<td @if($queryticketstatusresults->post_status == 'user') style='background-color: #f1f1f1;' @else style='background-color: #e0dcdc !important;border-bottom:1px solid #bdb4b4;' @endif>{{ $queryticketstatusresults->job_id }}</td>
									<td @if($queryticketstatusresults->post_status == 'user') style='background-color: #f1f1f1;' @else style='background-color: #e0dcdc !important;border-bottom:1px solid #bdb4b4;' @endif>{{ $queryticketstatusresults->user_id }}</td>									
									<td @if($queryticketstatusresults->post_status == 'user') style='background-color: #f1f1f1;' @else style='background-color: #e0dcdc !important;border-bottom:1px solid #bdb4b4;' @endif>{{ $queryticketstatusresults->query_date }}</td>
									<td @if($queryticketstatusresults->post_status == 'user') style='background-color: #f1f1f1;' @else style='background-color: #e0dcdc !important;border-bottom:1px solid #bdb4b4;' @endif>{{ $queryticketstatusresults->ticket_type }}</td>
									<td @if($queryticketstatusresults->post_status == 'user') style='background-color: #f1f1f1;' @else style='background-color: #e0dcdc !important;border-bottom:1px solid #bdb4b4;' @endif>{{ $queryticketstatusresults->ticket_id }}</td>
									<td @if($queryticketstatusresults->post_status == 'user') style='background-color: #f1f1f1;' @else style='background-color: #e0dcdc !important;border-bottom:1px solid #bdb4b4;' @endif>{{ $queryticketstatusresults->ticket_elapsed_time }}</td>
									<td @if($queryticketstatusresults->post_status == 'user') style='background-color: #f1f1f1;' @else style='background-color: #e0dcdc !important;border-bottom:1px solid #bdb4b4;' @endif>
									<b>@if($queryticketstatusresults->post_status == 'user') Q: @else R: @endif</b>
									{{ $queryticketstatusresults->query }}
									
									</td>
																
								</tr>

							@endforeach
						
						@endif
					</tbody>
				</table>		
			</div>
		 
		 
		 

        </div>
        <!-- /.box-body -->
      </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
           <script type="text/javascript" class="init">
			$(document).ready(function() {
				var table = $('#individualjobsreport').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         false,
					fixedColumns:   {
						leftColumns: 2
					}
				} );
				
				var table = $('#individualjobshistory').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         false,
					fixedColumns:   {
						leftColumns: 2
					}
				} );
				var table = $('#jobshistory').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         false,
					fixedColumns:   {
						leftColumns: 2
					}
				} );
				
				var table = $('#individualticketreport').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         false,
					fixedColumns:   {
						leftColumns: 2
					}
				} );
				
				var table = $('#individualquerylist').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         false,
					
				} );
				
			
				var table = $('#ticketstatusreport').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         false,
					fixedColumns:   {
						leftColumns: 1
					}
				} );
			
				
			} );
		</script>
       
@endsection

