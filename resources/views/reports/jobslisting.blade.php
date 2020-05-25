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
		.dataTables_scrollBody {min-height:60px !important;border-left:1px solid black;border-right:1px solid black;}
		.emptyheader{border-bottom:0px !important;border-top:1px solid black;border-left:1px solid black;}
		.refemptyheader{text-align: center !important;padding: 0; border: 1px solid black;}
		.jobemptyheader{text-align: center !important;padding: 0; border: 1px solid black;border-left:0px;}
		
		.subjobheader{border:1px solid black;border-right:0px;border-top:0px;}
		.suborheader{border:1px solid black;border-top:0px;border-right:0px;}
		.dataTables_empty{text-align:left !important;}
		.dataTables_scrollHead{border-right:1px solid black !important;}
		.odd.DTFC_NoData {display:none;}
		#jobsreport td:nth-child(1){border-left:0px !important;border-bottom:0px !important}
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
						<label>Date Type:</label>
						 <select class="form-control" id="fieldname" name="fieldname">					
							<option <?php if($fieldname == 'received_date') { ?> selected <?php } ?> value="received_date">Received Date</option>
							<option <?php if($fieldname == 'duedate') { ?> selected <?php } ?> value="duedate">Due Date</option>
							<option <?php if($fieldname == 'dispatchdate') { ?> selected <?php } ?> value="dispatchdate">Dispatch Date</option>
							<option <?php if($fieldname == 'start_time') { ?> selected <?php } ?> value="start_time">BOTS Start Date</option>
						</select>
                    </div>	
					 <div class="col-md-2" >
						<label>Date:</label>
		                  <input type='text' id='jobdate' class='form-control' name='jobdate' value='<?php echo $jobdate; ?>'> 
	                </div>
	                <div class="col-md-2" >
						<label>Order Id:</label>
		                 <input type='text' id='orderid' class='form-control' name='orderid' value='<?php echo $order_id; ?>'>
	                </div>

	                <div class="col-md-2">
		                 <label>File Name:</label>
						<input type='text' id='filename' class='form-control' name='filename' value='<?php echo $filename; ?>'> 
	                </div>
	                
	               
					<div class="col-md-2 " style="text-align: center;margin-top:25px;float:right;">
						<label>&nbsp;</label>
						<input class="btn btn-primary" type="submit" value="Search">
						<input type='hidden' name='htAction' value='jobssearch' />
						 <a class="" title='Export Excel' href="javascript:void(0);" onclick="passexport(event,{{$resultcount}});"><img src="{{url('img/excelexport.png')}}" width="35" height="35"></a>
	                </div>
	                
				</div>
			</div>
		</form>
	
		<table id="jobsreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>						
						<tr>                
							<th class='emptyheader'></th>
							<th class='emptyheader'></th>
							<th class='emptyheader'></th>	
							<th class='emptyheader'></th>
							<th class='emptyheader'></th>	
							<th class='emptyheader'></th>
							<th class='emptyheader'></th>
							<th class='emptyheader'></th>
							<th class='emptyheader'></th>	
							<th class='jobemptyheader totaltype-bg left-border' style='border-right:0px;' colspan="7">Total Ticket Details</th>														
							<th class='jobemptyheader itemtype-bg left-border' colspan="7">Item Type</th>
							<th colspan="7" align='center' class="jobemptyheader reference-bg">Reference</th>
							<th colspan="7" align='center' class="jobemptyheader grant-bg">Grant</th>
							<th colspan="7" align='center' class="jobemptyheader affiliation-bg">Affiliation</th>
							<th colspan="7" align='center' class="jobemptyheader mathexpression-bg">Math Expression</th>
							<th colspan="7" style='border-right:0px;' align='center' class="jobemptyheader validation-bg">Final QC</th>		
							<th class='emptyheader '></th>																	
						 </tr>		
						<tr>                
							<th class='subjobheader'>Job Id</th>
							<th class='suborheader'>Order Id</th>	
							<th class='suborheader'>Publisher</th>
							<th class='suborheader'>Received Date</th>	
							<th class='suborheader'>Due Date</th>	
							<th class='suborheader'>Dispatch Date</th>	
							<th class='suborheader'>Current Status</th>	
							<th class='suborheader'>BOTS Start Time</th>	
							<th class='suborheader'>BOTS End Time</th>																					
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
							<th class='validation-bg '>Average Time</th>
							<th class="subjobheader">Source File & Location</th>							
						</tr>															
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)
								<?PHP
									$ItemType_Avg			= '';
									$Reference_Avg			= '';
									$Grant_Avg				= '';
									$Affiliation_Avg		= '';
									$MathExpression_Avg		= '';																		
									$Validation_Avg			= '';									
									$Total_Avg				= '';

									$ItemType_Avg 			= calculate_average_timeformat($results->ItemType_Ticket_Total_Count, $results->ItemType_Ticket_Completed_Count, $results->ItemType_Ticket_Pending_Count, $results->ItemType_Ticket_Progress_Count, $results->ItemType_Total_Time, $results->ItemType_Operators_Worked_Count);
									$Reference_Avg 			= calculate_average_timeformat($results->Reference_Ticket_Total_Count, $results->Reference_Ticket_Completed_Count, $results->Reference_Ticket_Pending_Count, $results->Reference_Ticket_Progress_Count, $results->Reference_Total_Time, $results->Reference_Operators_Worked_Count);
									$Grant_Avg 				= calculate_average_timeformat($results->Grant_Ticket_Total_Count, $results->Grant_Ticket_Completed_Count, $results->Grant_Ticket_Pending_Count, $results->Grant_Ticket_Progress_Count, $results->Grant_Total_Time, $results->Grant_Operators_Worked_Count);
									$Affiliation_Avg 		= calculate_average_timeformat($results->Affiliation_Ticket_Total_Count, $results->Affiliation_Ticket_Completed_Count, $results->Affiliation_Ticket_Pending_Count, $results->Affiliation_Ticket_Progress_Count, $results->Affiliation_Total_Time, $results->Affiliation_Operators_Worked_Count);
									$MathExpression_Avg 	= calculate_average_timeformat($results->MathExpression_Ticket_Total_Count, $results->MathExpression_Ticket_Completed_Count, $results->MathExpression_Ticket_Pending_Count, $results->MathExpression_Ticket_Progress_Count, $results->MathExpression_Total_Time, $results->MathExpression_Operators_Worked_Count);
									$Validation_Avg 		= calculate_average_timeformat($results->Validation_Ticket_Total_Count, $results->Validation_Ticket_Completed_Count, $results->Validation_Ticket_Pending_Count, $results->Validation_Ticket_Progress_Count, $results->Validation_Total_Time, $results->Validation_Operators_Worked_Count);
									$Total_Avg 				= calculate_average_timeformat($results->Jobs_Ticket_Total_Count, $results->Jobs_Ticket_Completed_Count, $results->Jobs_Ticket_Pending_Count, $results->Jobs_Ticket_Progress_Count, $results->Jobs_Total_Time, $results->Jobs_Operators_Worked_Count);
								?>
							
								<tr>             						

									<td class='bgcolor left-border'><a href="{{url('reports/individualjobsdetail')}}/{{$results->job_id}}">{{ $results->job_id }}</a></td>
									<td class='bgcolor left-border'><a href="{{url('reports/individualorderdetail')}}/{{$results->orderid}}">{{ $results->orderid }}</a></td>
									
									<td class='bgcolor left-border'>{{ $results->publisher }}</td>
									<td class='bgcolor left-border'>{{ $results->received_date }}</td>
									<td class='bgcolor left-border'>{{ $results->duedate }}</td>	
									<td class='bgcolor left-border'>{{ $results->dispatchdate }}</td>							
									<td class='bgcolor left-border'>{{ $results->current_process }}</td>									
									<td class='bgcolor left-border'>{{ $results->XML_Conversion_Start_Time }}</td>
									<td class='bgcolor left-border'>{{ $results->XML_Conversion_End_Time }}</td>
																		
									<td class='totaltype-bg left-border'>{{ $Total_Avg[0] }}</td>
									<td class='totaltype-bg'>{{ $Total_Avg[1] }}</td>
									<td class='totaltype-bg'>{{ $Total_Avg[2] }}</td>
									<td class='totaltype-bg'>{{ $Total_Avg[3] }}</td>
									<td class='totaltype-bg'>{{ $Total_Avg[4] }}</td>
									<td class='totaltype-bg'>{{ $Total_Avg[5] }}</td>
									<td class='totaltype-bg'>{{ $Total_Avg[6] }}</td>
									
									<td class='itemtype-bg left-border'>{{ $ItemType_Avg[0] }}</td>
									<td class='itemtype-bg'>{{ $ItemType_Avg[1] }}</td>
									<td class='itemtype-bg'>{{ $ItemType_Avg[2] }}</td>
									<td class='itemtype-bg'>{{ $ItemType_Avg[3] }}</td>
									<td class='itemtype-bg'>{{ $ItemType_Avg[4] }}</td>
									<td class='itemtype-bg'>{{ $ItemType_Avg[5] }}</td>
									<td class='itemtype-bg right-border'>{{ $ItemType_Avg[6] }}</td>
									
									<td class='reference-bg'>{{ $Reference_Avg[0] }}</td>
									<td class='reference-bg'>{{ $Reference_Avg[1] }}</td>
									<td class='reference-bg'>{{ $Reference_Avg[2] }}</td>									
									<td class='reference-bg'>{{ $Reference_Avg[3] }}</td>
									<td class='reference-bg'>{{ $Reference_Avg[4] }}</td>
									<td class='reference-bg'>{{ $Reference_Avg[5] }}</td>
									<td class='reference-bg right-border'>{{ $Reference_Avg[6] }}</td>
									
									<td class='grant-bg'>{{ $Grant_Avg[0] }}</td>
									<td class='grant-bg'>{{ $Grant_Avg[1] }}</td>	
									<td class='grant-bg'>{{ $Grant_Avg[2] }}</td>
									<td class='grant-bg'>{{ $Grant_Avg[3] }}</td>													
									<td class='grant-bg'>{{ $Grant_Avg[4] }}</td>
									<td class='grant-bg'>{{ $Grant_Avg[5] }}</td>
									<td class='grant-bg right-border'>{{ $Grant_Avg[5] }}</td>
									
									<td class='affiliation-bg'>{{ $Affiliation_Avg[0] }}</td>
									<td class='affiliation-bg'>{{ $Affiliation_Avg[1] }}</td>	
									<td class='affiliation-bg'>{{ $Affiliation_Avg[2] }}</td>
									<td class='affiliation-bg'>{{ $Affiliation_Avg[3] }}</td>												
									<td class='affiliation-bg'>{{ $Affiliation_Avg[4] }}</td>
									<td class='affiliation-bg'>{{ $Affiliation_Avg[5] }}</td>
									<td class='affiliation-bg right-border'>{{ $Affiliation_Avg[6] }}</td>
									
									<td class='mathexpression-bg'>{{ $MathExpression_Avg[0] }}</td>
									<td class='mathexpression-bg'>{{ $MathExpression_Avg[1] }}</td>	
									<td class='mathexpression-bg'>{{ $MathExpression_Avg[2] }}</td>
									<td class='mathexpression-bg'>{{ $MathExpression_Avg[3] }}</td>											
									<td class='mathexpression-bg'>{{ $MathExpression_Avg[4] }}</td>
									<td class='mathexpression-bg'>{{ $MathExpression_Avg[5] }}</td>
									<td class='mathexpression-bg right-border'>{{ $MathExpression_Avg[6] }}</td>
									
									<td class='validation-bg'>{{ $Validation_Avg[0] }}</td>
									<td class='validation-bg'>{{ $Validation_Avg[1] }}</td>	
									<td class='validation-bg'>{{ $Validation_Avg[2] }}</td>
									<td class='validation-bg'>{{ $Validation_Avg[3] }}</td>												
									<td class='validation-bg'>{{ $Validation_Avg[4] }}</td>
									<td class='validation-bg'>{{ $Validation_Avg[5] }}</td>
									<td class='validation-bg right-border'>{{ $Validation_Avg[6] }}</td>
									
									<td class='bgcolor right-border'>
										Name:&nbsp;&nbsp;{{ $results->filename }}<br />
										Path:&nbsp;&nbsp;&nbsp;&nbsp;{{ $results->filepath }}
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
		   
		   function passexport(event,listcount)
			{
				if(listcount > 0){
					event.preventDefault();
					var passparam = '';
					if($('#jobdate').val()!='')
						passparam += 'jobdate='+$('#jobdate').val();
					if($('#fieldname').val()!='')
						passparam += '&fieldname='+$('#fieldname').val();
					if($('#filename').val()!='')
						passparam += '&filename='+$('#filename').val();
					if($('#orderid').val()!='')
						passparam += '&orderid='+$('#orderid').val();
					if($('#publisher').val()!='')
						passparam += '&publisher='+$('#publisher').val();
					if($('#project').val()!='')
						passparam += '&project='+$('#project').val();
					if(passparam!='') 
						passparam = '?'+passparam;
					
					window.location.href ="{{url('reports/exportxls')}}"+passparam;
				} else{
					alert('No Record Found.');
					
				}
			}
		   
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

