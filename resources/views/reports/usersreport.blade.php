<?php
	function calculate_average_timeformat($ticket_count, $total_time){		
		$str_returnval = array();		
		if($ticket_count == 0) {
			$str_returnval[0]	= ''; 
			$str_returnval[1]   = ''; 
			$str_returnval[2]   = ''; 
		}else{
			$str_returnval[0]   = $ticket_count; 	
			//$str_returnval[1]   = gmdate("H:i:s",  $total_time);				
			$time = $total_time;
			$mins = $time % 3600;
			$secs = $mins % 60;
			$hours = ($time - $mins) / 3600;
			$mins = ($mins - $secs) / 60;
			$str_returnval[1] = (($hours < 10 ) ? '0' : '') .$hours . ':' . (($mins < 10 ) ? '0' : '') . $mins . ':'  . (($secs < 10 ) ? '0' : '') . $secs;
			$str_returnval[2]   = gmdate("H:i:s", ($total_time/$ticket_count));				
		}
		return $str_returnval;	
	}
	function formatMilliseconds($ticket_count,$milliseconds) {
		$returnval = array();		
		if($ticket_count == 0) {
			$returnval[0]	= ''; 
			$returnval[1]   = ''; 			
		}else{
			//$avg = round(($milliseconds / $ticket_count)/1000);
			$avgtempsec = $milliseconds / $ticket_count;
			$avg = $milliseconds / $ticket_count;
			
			$returnval[0]   = $ticket_count; 	
			$seconds = floor($milliseconds / 1000);
			$minutes = floor($seconds / 60);
			$hours = floor($minutes / 60);
			$milliseconds = $milliseconds % 1000;
			$seconds = $seconds % 60;
			$minutes = $minutes % 60;
			$format = '%02u:%02u:%02u.%02u';
			$totaltime = sprintf($format, $hours, $minutes, $seconds, $milliseconds);	
			
			$avgseconds = floor($avg / 1000);
			$avgminutes = floor($avgseconds / 60);
			$avghours = floor($avgminutes / 60);
			$avgmilliseconds = $avg % 1000;
			$avgseconds = $avgseconds % 60;
			$avgminutes = $avgminutes % 60;
			$avgformat = '%02u:%02u:%02u.%02u';
			
			$avg = substr(($avgtempsec),0,2);
			$avgtotaltime = sprintf($avgformat, $avghours, $avgminutes, $avgseconds, $avg);	
			
			
			
			$returnval[1]	= $totaltime; 
			$returnval[2]   = $avgtotaltime; 
		}		
		return $returnval;
	}
	function Milliseconds($milliseconds) {
		$seconds = floor($milliseconds / 1000);
		$minutes = floor($seconds / 60);
		$hours = floor($minutes / 60);
		$milliseconds = $milliseconds % 100;
		$seconds = $seconds % 60;
		$minutes = $minutes % 60;

		$format = '%u:%02u:%02u.%02u';
		$time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
		return $time;
	}
	
function timeToMilliseconds($time){
    $time_start = substr($time, -11, -3);
    $time_end = substr($time, -3);

    $time_arr = explode(':', $time_start);
    $seconds = 0;
    foreach($time_arr as $key => $val){
        if($key == 0){
            $seconds += $val * 60 * 60;
        }elseif($key == 1){
            $seconds += $val * 60;
        }elseif($key == 2){
            $seconds += $val;
        }
    }

    $seconds = $seconds.$time_end;
    $milliseconds = $seconds * 1000;

    return $milliseconds;
}

function format_Milliseconds($milliseconds) {
    $seconds = floor($milliseconds / 1000);
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $milliseconds = $milliseconds % 1000;
    $seconds = $seconds % 60;
    $minutes = $minutes % 60;

    $format = '%u:%02u:%02u.%03u';
    $time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
    return rtrim($time, '0');
}
function sum_time($time1, $time2) {
    $times = array($time1, $time2);
    $seconds = 0;
    $Imiliseconds = 0.0;

    foreach ($times as $time){
        @list($rest, $miliseconds) = explode('.', $time);
        $Imiliseconds += '0.'.$miliseconds;
        @list($hour, $minute, $second) = explode(':', $rest);
        $seconds += $hour*3600;
        $seconds += $minute*60;
        $seconds += $second;
    }

    $seconds += floor($Imiliseconds);
    $hours = floor($seconds/3600);
    $seconds -= $hours*3600;
    $minutes  = floor($seconds/60);
    $seconds -= $minutes*60;
    $miliseconds  = round(($Imiliseconds-floor($Imiliseconds))*100);
    //return sprintf('%02d:%02d:%02d:%0.2f', $hours, $minutes, $seconds, $miliseconds); 
	return sprintf('%02d:%02d:%02d.%s', $hours, $minutes, $seconds, $miliseconds); 
}

class times_counter {

    private $hou = 0;
    private $min = 0;
    private $sec = 0;
    private $totaltime = '00:00:00';

    public function __construct($times){
        
        if(is_array($times)){

            $length = sizeof($times);

            for($x=0; $x <= $length; $x++){
                    $split = explode(":", @$times[$x]); 
                    $this->hou += @$split[0];
                    $this->min += @$split[1];
                    $this->sec += @$split[2];
            }

            $seconds = $this->sec % 60;
            $minutes = $this->sec / 60;
            $minutes = (integer)$minutes;
            $minutes += $this->min;
            $hours = $minutes / 60;
            $minutes = $minutes % 60;
            $hours = (integer)$hours;
            $hours += $this->hou % 24;
            $this->totaltime = $hours.":".$minutes.":".$seconds;
			
        }
    }

    public function get_total_time(){
        return date('H:i:s',strtotime($this->totaltime));
    }

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
		.dataTables_scrollBody {height:auto !important;border-left:1px solid}
		.emptyheader{border-bottom:0px !important;border-top:1px solid black;border-left:1px solid black;}
		.refemptyheader{text-align: center !important;padding: 0; border: 1px solid black;background-color:#FFE5CC;}
		.jobemptyheader{text-align: center !important;padding: 0; border: 1px solid black;border-left:0px;}
		.DTFC_LeftBodyLiner{border-left:1px solid black;min-height:90px !important;}
		.subjobheader{border:1px solid black;border-right:0px;border-top:0px;}
		.suborheader{border:1px solid black;border-top:0px;border-right:0px;}
		.dataTables_scroll{border-right:1px solid black;}
		.ref_bg{background-color: #FFE5CC;}
		.left-border{border-left:1px solid black;}
		#usersreport th:nth-child(1),td:nth-child(n+1):nth-child(-n+3) {
			  text-align: center;
        }
		#usersreport th:nth-child(5),td:nth-child(n+5):nth-child(-n+10) {		  
		  text-align: center;
		}
		 #usersreport th:nth-child(8),td:nth-child(n+8):nth-child(-n+16) {		  
		  text-align: center;
		}
		.
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
					<div  class="col-md-2">                            
						 <label>From:<span class='db_fieldright'>(Ticket End Time)</label>
						 <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fdate; ?>'> 
                    </div>
					<div  class="col-md-2" >                            
						<label>Date:<span class='db_fieldright'>(Ticket End Time)</label> <input class='form-control'  type='text' id='todate' name='todate' value='<?php echo $tdate; ?>'>
                    </div>					
					<div class="col-md-2" >                            
						<label>Emp Code:</label>
						 <input type='text' id='empcode' class='form-control' name='empcode' value='<?php echo $empcode; ?>'> 
                    </div>
					<div class="col-md-1 form-group jobsrchbtn" style="text-align: center;">
						<label>&nbsp;</label>	
						<input type='hidden' name='htAction' value='userssearch' />
						<input class="btn btn-primary" type="submit" value="Search">
				</div>
			</div>
		</div>	
		</form>		

			<table id="usersreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>                
							<th class='emptyheader'></th>
							<th class='emptyheader'></th>
							<th colspan="7" align='center' class="jobemptyheader totaltype-bg left-border" style="border-right:0px;">Total Completed Ticket & Time</th>
							<th colspan="3" align='center' class='refemptyheader ticketquery-bg' style="border-right:0px;">Ticket Query</th>
							<th colspan="3" align='center' class='refemptyheader rejectedticket-bg' style="border-right:0px;">Rejected Ticket</th>
							<th colspan="2" align='center' class='refemptyheader waitingticket-bg' style="border-right:0px;">Waiting Time</th>
							<th colspan="3" align='center' class='refemptyheader itemtype-bg'>Item Type</th>
							<th colspan="3" align='center' class="jobemptyheader reference-bg">Reference</th>
							<th colspan="3" align='center' class="jobemptyheader grant-bg">Grant</th>
							<th colspan="3" align='center' class="jobemptyheader affiliation-bg">Affiliation</th>
							<th colspan="3" align='center' class="jobemptyheader mathexpression-bg">Math Expression</th>
							<!--<th colspan="3" align='center' class="jobemptyheader validation-bg">Final QC</th>-->
							@foreach($publisherlist as $publishers)
								@if ($publishers->publisher != '')									
									<th colspan="3" align='center' class="jobemptyheader validation-{{$publishers->publisher}}-bg">{{$publishers->publisher}} QC</th>				
								@endif																
							 @endforeach							
						 </tr>		
						<tr>                
							<th class='subjobheader'>Date</th>	
							<th class='subjobheader'>User Name</th>	
							<th class='totaltype-bg left-border'>Ticket</th>
							<th class='totaltype-bg'>Razor Time</th>
							<th class='totaltype-bg'>Total Ticket Time</th>
							<th class='totaltype-bg'>Break Time</th>
							<th class='totaltype-bg'>Average Time</th>
							<th class='totaltype-bg'>Start Time</th>
							<th class='totaltype-bg'>End Time</th>			

							<th class='ticketquery-bg left-border'>Total Ticket</th>							
							<th class='ticketquery-bg'>Total Time</th>  
							<th class='ticketquery-bg '>Average Time</th> 							
							
							<th class='rejectedticket-bg left-border'>Total Ticket</th>							
							<th class='rejectedticket-bg'>Total Time</th>  
							<th class='rejectedticket-bg '>Average Time</th> 
							
													
							<th class='waitingticket-bg left-border'>Total Time</th>  
							<th class='waitingticket-bg '>Average Time</th> 
							
							<th class='itemtype-bg left-border'>Completed</th>							
							<th class='itemtype-bg'>Total Time</th>  
							<th class='itemtype-bg right-border'>Average Time</th> 
							
							<th class="reference-bg">Completed</th>
							<th class="reference-bg">Total Time</th>
							<th class="reference-bg right-border">Average Time</th>
							
							<th class="grant-bg">Completed</th>
							<th class="grant-bg">Total Time</th>
							<th class="grant-bg right-border">Average Time</th> 	
							
							<th class='affiliation-bg' >Completed</th>							
							<th class='affiliation-bg'>Total Time</th>  
							<th class='affiliation-bg right-border'>Average Time</th> 

							<th class="mathexpression-bg">Completed</th>
							<th class="mathexpression-bg">Total Time</th>
							<th class="mathexpression-bg right-border">Average Time</th>
							
							<!--<th class="validation-bg">Completed</th>
							<th class="validation-bg">Total Time</th>
							<th class="validation-bg right-border">Average Time</th>-->
							@foreach($publisherlist as $publishers)
								@if ($publishers->publisher != '')									
									<th class="validation-{{$publishers->publisher}}-bg">Completed</th>
									<th class="validation-{{$publishers->publisher}}-bg">Total Time</th>
									<th class="validation-{{$publishers->publisher}}-bg right-border">Average Time</th>			
								@endif																
							 @endforeach
						</tr>
					</thead>
					<tbody>
					<?php 
						$totalticketsum = 0;$totaltimetsum = 0;$totalitemtypeticketsum = 0;$totalitemtypetimetsum = 0;$totalreferenceticketsum = 0;$totalreferencetimetsum = 0;
						$totalgrantticketsum = 0;$totalgranttimetsum = 0;
						$totalaffticketsum = 0;$totalafftimetsum = 0;
						$totalmathexpressionticketsum = 0;$totalmathexpressiontimetsum = 0;
						$totalvalidationticketsum = 0;$totalvalidationtimetsum = 0;
						$totalusersum = 0;$totalticketquerysum = 0;$totalticketquertimeysum = 0;
						$totalrejectedticketsum = 0;$totalrejectedtickettimeysum = 0;
						
						$totalwaitingticketsum = 0;$totalwaitingtickettimeysum = 0;
						
						$publisharylist = array();
						foreach($publisherlist as $key => $publishers){
							if ($publishers->publisher != ''){
								$ptc = 'Ticket_Completed_Count';
								$ptt = 'Total_Time';
								$Tcnt = 0;
								$TTcnt = 0;
								foreach($result as $key => $resultval){
									$ptcc = $publishers->publisher.'_Ticket_Completed_Count';
									$ptt = $publishers->publisher.'_Total_Time';
									$publisharylist[][$ptcc] =	$resultval->$ptcc+$Tcnt;
									$publisharylist[][$ptt] =	$resultval->$ptt+$TTcnt;
								}
							}
						}
						
						$sum = array();
						foreach ($publisharylist as $key => $sub_array) {
							foreach ($sub_array as $sub_key => $value) {
								if( ! array_key_exists($sub_key, $sum)) $sum[$sub_key] = 0;
								$sum[$sub_key]+=$value;
							}
						}
						$totalbreaktime = array();						
					?>
						@if (count($result))
							@foreach ($result as $k => $results)
								<?PHP
									$brektimeary = array();									
									if(count($results->employeetimediff>0)){
										foreach($results->employeetimediff as $timediffcal){
											$brektimeary[] =  $timediffcal->totaltime;
										}
									} else {
										$brektimeary[] = '';
									}
									
									$razortimeary = array();									
									if(count($results->razortime>0)){
										foreach($results->razortime as $timediffcal){
											$razortimeary[] =  $timediffcal->totaltime;
										}
									} else {
										$razortimeary[] = '';
									}
								
								//print '<prE>';
								
								 	$breaktimecounter = new times_counter($brektimeary);
									$razortimecounter = new times_counter($razortimeary);
									$TicketQuery_Avg     	= '';
									$ItemType_Avg			= '';
									$Reference_Avg			= '';
									$Grant_Avg				= '';
									$Affiliation_Avg		= '';
									$MathExpression_Avg		= '';																		
									$Validation_Avg			= '';									
									$Total_Avg				= '';
									
									
									$TicketQuery_Avg 		= calculate_average_timeformat($results->Total_Ticket_Query, $results->Total_Ticket_time);
									$ItemType_Avg 			= calculate_average_timeformat($results->ItemType_Ticket_Completed_Count, $results->ItemType_Total_Time);
									$Reference_Avg 			= calculate_average_timeformat($results->Reference_Ticket_Completed_Count, $results->Reference_Total_Time);									
									$Grant_Avg 				= calculate_average_timeformat($results->Grant_Ticket_Completed_Count, $results->Grant_Total_Time);
									$Affiliation_Avg 		= calculate_average_timeformat($results->Affiliation_Ticket_Completed_Count, $results->Affiliation_Total_Time);
									$MathExpression_Avg 	= calculate_average_timeformat($results->MathExpression_Ticket_Completed_Count, $results->MathExpression_Total_Time);
									$Validation_Avg 		= calculate_average_timeformat($results->Validation_Ticket_Completed_Count, $results->Validation_Total_Time);
									$RejectedTicket_Avg 	= calculate_average_timeformat($results->Total_Rejected_Ticket, $results->Total_RejectedTicket_time);									
									$WaitingTicket_Avg_old    	= calculate_average_timeformat($results->Total_Ticket_Completed_Count+$results->Total_Ticket_Query+$results->Total_Rejected_Ticket, $results->Total_Waiting_Time+$results->Total_Ticket_Query_Waiting_time+$results->Total_RejectedTicket_Waiting_time);
									
									$WaitingTicket_Avg    	= formatMilliseconds($results->Total_Ticket_Completed_Count+$results->Total_Ticket_Query+$results->Total_Rejected_Ticket, $results->Total_Waiting_Time+$results->Total_Ticket_Query_Waiting_time+$results->Total_RejectedTicket_Waiting_time);
									
									if(empty($WaitingTicket_Avg[2])) {
										$WaitingTicket_Avg[2] = '';
									}
									
									$Total_Avg	= calculate_average_timeformat($results->Total_Ticket_Completed_Count+$results->Total_Ticket_Query+$results->Total_Rejected_Ticket, $results->Total_Work_Time+$results->Total_Ticket_time+$results->Total_RejectedTicket_time);
									
									$time1 = $Total_Avg[1];
									$time2 = $WaitingTicket_Avg[1];
									$totalt = sum_time($time1, $time2); 
									
									
									$totalticketquerysum += $TicketQuery_Avg[0];
									$totalticketquertimeysum += $results->Total_Ticket_time;
									
									$totalticketsum += $Total_Avg[0];
									$totaltimetsum += $results->Total_Work_Time+$results->Total_Ticket_time+$results->Total_RejectedTicket_time;									
									$totalitemtypeticketsum += $ItemType_Avg[0];
									$totalitemtypetimetsum += $results->ItemType_Total_Time;									
									$totalreferenceticketsum += $Reference_Avg[0];
									$totalreferencetimetsum += $results->Reference_Total_Time;
									$totalgrantticketsum += $Grant_Avg[0];
									$totalgranttimetsum += $results->Grant_Total_Time;
									$totalaffticketsum += $Affiliation_Avg[0];
									$totalafftimetsum += $results->Affiliation_Total_Time;
									$totalmathexpressionticketsum += $MathExpression_Avg[0];
									$totalmathexpressiontimetsum += $results->MathExpression_Total_Time;
									$totalvalidationticketsum += $Validation_Avg[0];
									$totalvalidationtimetsum += $results->Validation_Total_Time;
									
									$totalrejectedticketsum += $RejectedTicket_Avg[0];
									$totalrejectedtickettimeysum += $results->Total_RejectedTicket_time;
									
									$totalwaitingticketsum += $results->Total_Waiting_Time+$results->Total_Ticket_Query_Waiting_time+$results->Total_RejectedTicket_Waiting_time;
									//$totalwaitingtickettimeysum += $results->Total_Waiting_Time;
									$totalwaitingtickettimeysum += $results->Total_Waiting_Time;									
									$totalusersum ++;
									
									
									$totalbreaktime[] = $breaktimecounter->get_total_time();
									$totalrazortime[] = $razortimecounter->get_total_time();
									
									
								?>	
								<tr>             						
									<td >{{ $results->ticket_end_time }}</td>
									<td class='left-border' ><a href='#' onclick="showuserreport('{{$results->user_id}}','{{$results->wr_time}}')">{{ $results->user_id }}</a></td>
									<td class='totaltype-bg left-border'>{{ $Total_Avg[0] }}</td>
									<td class='totaltype-bg'>{{ $razortimecounter->get_total_time()}}</td>
									<td class='totaltype-bg'>{{ $totalt }}</td>
									<td class='totaltype-bg'>{{ $breaktimecounter->get_total_time()}}</td>
									<td class='totaltype-bg'>{{ $Total_Avg[2] }}</td>
									<td class='totaltype-bg'>{{ $results->User_Start_Time }}</td>
									<td class='totaltype-bg'>{{ $results->User_End_Time }}</td>
																		
									<td class='ticketquery-bg left-border'>{{ $TicketQuery_Avg[0] }}</td>
									<td class='ticketquery-bg'>{{ $TicketQuery_Avg[1] }}</td>
									<td class='ticketquery-bg '>{{ $TicketQuery_Avg[2] }}</td>
									
									<td class='rejectedticket-bg left-border'>{{ $RejectedTicket_Avg[0] }}</td>
									<td class='rejectedticket-bg'>{{ $RejectedTicket_Avg[1] }}</td>
									<td class='rejectedticket-bg '>{{ $RejectedTicket_Avg[2] }}</td>
									
									
									<td class='waitingticket-bg left-border'>{{ $WaitingTicket_Avg[1]  != '' ? $WaitingTicket_Avg[1]  : "-" }}</td>
									<td class='waitingticket-bg '>{{ $WaitingTicket_Avg[2]  != '' ? $WaitingTicket_Avg[2]  : "-" }}</td>
									
									<td class='itemtype-bg left-border'>{{ $ItemType_Avg[0]  != '' ? $ItemType_Avg[0]  : "" }}</td>
									<td class='itemtype-bg'>{{ $ItemType_Avg[1]  != '' ? $ItemType_Avg[1]  : "" }}</td>
									<td class='itemtype-bg right-border'>{{ $ItemType_Avg[2]  != '' ? $ItemType_Avg[2]  : ""}}</td>
									
									<td class='reference-bg '>{{ $Reference_Avg[0] }}</td>
									<td class='reference-bg'>{{ $Reference_Avg[1] }}</td>
									<td class='reference-bg right-border'>{{ $Reference_Avg[2] }}</td>
									
									<td class='grant-bg'>{{ $Grant_Avg[0] }}</td>
									<td class='grant-bg'>{{ $Grant_Avg[1] }}</td>
									<td class='grant-bg right-border'>{{ $Grant_Avg[2] }}</td>																		
									
									<td class='affiliation-bg'>{{ $Affiliation_Avg[0] }}</td>
									<td class='affiliation-bg'>{{ $Affiliation_Avg[1] }}</td>
									<td class='affiliation-bg right-border'>{{ $Affiliation_Avg[2] }}</td>
									
									<td class='mathexpression-bg'>{{ $MathExpression_Avg[0] }}</td>
									<td class='mathexpression-bg'>{{ $MathExpression_Avg[1] }}</td>
									<td class='mathexpression-bg right-border'>{{ $MathExpression_Avg[2] }}</td>
									
									<!--<td class='validation-bg'>{{ $Validation_Avg[0] }}</td>
									<td class='validation-bg'>{{ $Validation_Avg[1] }}</td>
									<td class='validation-bg right-border'>{{ $Validation_Avg[2] }}</td>-->	
								
									<?php  
										$publishercntlist = array(); 									
										$totalcompleted = 0;
										$total_Time = 0;
										$keycount = 0;										
									?>
									@foreach($publisherlist as $key => $publishers)
										@if ($publishers->publisher != '')	
												<?php
													$tot = $publishers->publisher.'_Ticket_Completed_Count';
													$tottime = $publishers->publisher.'_Total_Time';
													$publishercntlist = calculate_average_timeformat($results->$tot, $results->$tottime);
													$publishertotal_calc[$key][$publishers->publisher][]['Completed'] = $results->$tot;
													$publishertotal_calc[$key][$publishers->publisher][]['Total_Time'] = $results->$tottime;
												?>											
											<td class='validation-{{$publishers->publisher}}-bg'><?php echo $publishercntlist[0]; ?></td>
											<td class='validation-{{$publishers->publisher}}-bg'><?php echo $publishercntlist[1]; ?></td>
											<td class='validation-{{$publishers->publisher}}-bg right-border'><?php echo $publishercntlist[2]; ?></td>			
										@endif																
									@endforeach

								</tr>
								
								<?php 		
									
									$totaltime = calculate_average_timeformat($totalticketsum, $totaltimetsum);
									//print "<pre>";print_r($totaltime);print "</pre>";
									
									$totalticketquerytime = calculate_average_timeformat($totalticketquerysum, $totalticketquertimeysum);
									
									$totalitemtype = calculate_average_timeformat($totalitemtypeticketsum, $totalitemtypetimetsum);
									$totalreference = calculate_average_timeformat($totalreferenceticketsum, $totalreferencetimetsum);
									$totalgrant = calculate_average_timeformat($totalgrantticketsum, $totalgranttimetsum);
									$totalaffiliation = calculate_average_timeformat($totalaffticketsum, $totalafftimetsum);
									$totalmathexpression = calculate_average_timeformat($totalmathexpressionticketsum, $totalmathexpressiontimetsum);
									$totalvalidation = calculate_average_timeformat($totalvalidationticketsum, $totalvalidationtimetsum);
									
									$totalrejectedticket = calculate_average_timeformat($totalrejectedticketsum, $totalrejectedtickettimeysum);
									
									$totalwaitingticket = calculate_average_timeformat($totalwaitingticketsum, $totalwaitingtickettimeysum);
									
									
									
									if ($k+1 == count($result)) { 
								?>
									<tr>             						
										<td class='top-border weight-font' >Total</td>	
										<td class='top-border weight-font'><?php echo $totalusersum; ?></td>	
										<td class='top-border weight-font'><?php 
										
											echo $totaltime[0]; 
											
										?></td>	
										<td class='top-border weight-font'>
											<?php $totalrazortimecounter = new times_counter($totalrazortime);
											echo $totalrazortimecounter->get_total_time();
											?>
										</td>	
										<td class='top-border weight-font'>
											<?php 
												$totalwaiting = Milliseconds($totalwaitingticketsum);
											
												
												$time1 = $totaltime[1];
												$time2 = $totalwaiting;
												$to = sum_time($time1, $time2); 
												echo $to;
											?>
										</td>	
										<td class='top-border weight-font'>
										<?php
											$totalbreaktimecounter = new times_counter($totalbreaktime);
											echo $totalbreaktimecounter->get_total_time();
										?>
										</td>	
										<td class='top-border weight-font'><?php echo $totaltime[2]; ?></td>	
										<td class='top-border'></td>	
										<td class='top-border'></td>	
										
										<td class='top-border weight-font'><?php echo $totalticketquerysum; ?></td>	
										<td class='top-border weight-font'><?php echo $totalticketquerytime[1];  ?></td>	
										<td class='top-border weight-font'><?php echo $totalticketquerytime[2];  ?></td>
										
										<td class='top-border weight-font'><?php echo $totalrejectedticket[0]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalrejectedticket[1];  ?></td>	
										<td class='top-border weight-font'><?php echo $totalrejectedticket[2];  ?></td>
										
										
										<td class='top-border weight-font'>
											<?php 													
													
													echo $totalwaiting;												
											?>											
										</td>	
										<td class='top-border weight-font'>
											<?php 
												
												$avg = $totalwaitingticketsum/$totalticketsum;
												$avgtime = Milliseconds($avg);
												echo $avgtime;
												
											?>
										</td>
										
										<td class='top-border weight-font'><?php echo $totalitemtype[0]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalitemtype[1]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalitemtype[2]; ?></td>
										
										<td class='top-border weight-font'><?php echo $totalreference[0]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalreference[1]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalreference[2]; ?></td>
										
										<td class='top-border weight-font'><?php echo $totalgrant[0]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalgrant[1]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalgrant[2]; ?></td>
										
										<td class='top-border weight-font'><?php echo $totalaffiliation[0]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalaffiliation[1]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalaffiliation[2]; ?></td>	
										
										<td class='top-border weight-font'><?php echo $totalmathexpression[0]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalmathexpression[1]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalmathexpression[2]; ?></td>	
										
										<!--<td class='top-border weight-font'><?php echo $totalvalidation[0]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalvalidation[1]; ?></td>	
										<td class='top-border weight-font'><?php echo $totalvalidation[2]; ?></td>-->	
										
										@foreach($publisherlist as $keyindex=>$publishers)
											@if ($publishers->publisher != '')	
											
													<?php 
														$ticket_complete = $publishers->publisher.'_Ticket_Completed_Count';
														$ticket_total_time = $publishers->publisher.'_Total_Time';
													 
														$totalsum = calculate_average_timeformat($sum[$ticket_complete], $sum[$ticket_total_time]);
													?>
											
																			
												<td class='top-border weight-font'><?php echo $totalsum[0]; ?></td>	
												<td class='top-border weight-font'><?php echo $totalsum[1]; ?></td>	
												<td class='top-border weight-font'><?php echo $totalsum[2]; ?></td>		
											@endif																
										@endforeach		
																	
									</tr>
								<?php } ?>
							
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
				var table = $('#usersreport').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100],
					fixedColumns:   {
						leftColumns: 7/*,
						rightColumns: 3*/
					}
				} );
			} );
			function showuserreport(userid,wrdate){
				//document.getElementById("imgloader").style.display = "block";			
				$.ajax({
					type: 'GET',
					url: "{{url('reports/user_popupreport')}}",
					data: 'ajaxload=1&userid='+userid+'&wrdate='+wrdate,
					success: function(data){
						bootbox.alert(data);				
					},
				  });
			}
		</script>
@endsection