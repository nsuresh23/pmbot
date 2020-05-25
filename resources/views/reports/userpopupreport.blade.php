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
	.modal-body{height:520px;}
	.dataTables_scrollBody{ height:130px !important;}
</style> 
<?php
	function date_getFullTimeDifference( $start, $end )
	{
	$uts['start']      =    strtotime( $start );
			$uts['end']        =    strtotime( $end );
			if( $uts['start']!==-1 && $uts['end']!==-1 )
			{
				if( $uts['end'] >= $uts['start'] )
				{
					$diff    =    $uts['end'] - $uts['start'];
					if( $years=intval((floor($diff/31104000))) )
						$diff = $diff % 31104000;
					if( $months=intval((floor($diff/2592000))) )
						$diff = $diff % 2592000;
					if( $days=intval((floor($diff/86400))) )
						$diff = $diff % 86400;
					if( $hours=intval((floor($diff/3600))) )
						$diff = $diff % 3600;
					if( $minutes=intval((floor($diff/60))) )
						$diff = $diff % 60;
					$diff    =    intval( $diff );
					return( array('years'=>$years,'months'=>$months,'days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
				}
				else
				{
					echo "Ending date/time is earlier than the start date/time";
				}
			}
			else
			{
				echo "Invalid date/time data detected";
			}
	}
?>
		<div id='workrequestloader' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
       
		 <div style='font-weight:bold;text-align:center;' >Break Report</div>
          <table id="userbreak" class="display nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>    
				<th>Date</th>					  
				<th>User Name</th>				
                <th>Break Start Time</th>  	
				<th>Break End Time</th>  
				<th>Total Time</th>  
				<!--<th>Break Count</th>-->  	
				<th>Ticket Type</th>  					
              </tr>
          </thead>
          <!--<tbody>	

		  @if (count($result))
			@foreach ($result as $k => $results)
				<?php 

				if ($results->total_break != '' && $results->total_break != NULL) {  ?>
					<tr>          
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->work_request_time != '' ? date('d-M-y h:m A', strtotime($results->work_request_time)) : "" }}</td>					
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->user_id }}</td>									
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->break_starttime }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->break_endtime }}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>
							<?php 
								if($results->break_endtime != ''){								
									$breaktime = date_getFullTimeDifference($results->break_starttime,$results->break_endtime);									
									echo (($breaktime['hours'] < 10 ) ? '0' : '') .$breaktime['hours'] . ':' . (($breaktime['minutes'] < 10 ) ? '0' : '') . $breaktime['minutes'] . ':'  . (($breaktime['seconds'] < 10 ) ? '0' : '') . $breaktime['seconds'];
								} else {
									echo '-';
								}
							?>
							
						</td>
						
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_type}}</td>
											
					</tr>
				<?php } ?>
			  @endforeach
			
			@endif
          </tbody>-->
		  <tbody>	

		   @if (count($breakresult))
			@foreach ($breakresult as $k => $breakresults)
				
					<tr>          
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $breakresults->break_starttime}}</td>					
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $breakresults->user_id }}</td>									
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $breakresults->break_starttime}}</td>
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $breakresults->break_endtime}}</td>
						
						<td @if ($k % 2 == 0) class='bgcolor' @endif>
							
							<?php 
							/*if($breakresults->break_endtime != ''){								
								$breaktime = date_getFullTimeDifference($breakresults->break_starttime,$breakresults->break_endtime);
								echo $breaktime['hours'].':'.$breaktime['minutes'].':'.$breaktime['seconds'];
							} else {
								echo '-';
							}*/
						?>
						{{$breakresults->totaltime}}
						</td>
						<!--<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$k+1}}</td>-->
						<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $breakresults->tickettype}}</td>
											
					</tr>				
			  @endforeach
			
			@endif
          </tbody>
		  
        </table>

		 <div style='font-weight:bold;text-align:center;' >Login & Logout Report</div> 
          <table id="userlist" class="display nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>   
				<th>Date</th>				  
				<th>User Name</th>				
                <th>Login Time</th>  	
				<th>Log Out Time</th>  	
				<th>Total Time</th>  					
				<th>Ticket Type</th>  					
              </tr>
          </thead>
          <tbody>	

		  @if (count($result))
			@foreach ($result as $k => $results)
			
				<tr>             					
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->work_request_time != '' ? date('d-M-y h:m A', strtotime($results->work_request_time)) : "" }}</td>					
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->user_id }}</td>									
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->login_datetime }}</td>
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->logout_datetime}}</td>
					<td @if ($k % 2 == 0) class='bgcolor' @endif>
						<?php 
							if($results->logout_datetime != ''){
								$logintime = date_getFullTimeDifference($results->login_datetime,$results->logout_datetime); 
								echo (($logintime['hours'] < 10 ) ? '0' : '') .$logintime['hours'] . ':' . (($logintime['minutes'] < 10 ) ? '0' : '') . $logintime['minutes'] . ':'  . (($logintime['seconds'] < 10 ) ? '0' : '') . $logintime['seconds'];
							} else {
								echo '-';
							}
						?>
					</td>
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ticket_type}}</td>					
				</tr>
			  @endforeach
			
			@endif
          </tbody>
        </table>
     
     
	<script>
		setTimeout(function() {
			$(document).ready(function() {
				document.getElementById("workrequestloader").style.display = "none";
				$('#userbreak').DataTable( {
					"scrollY": 200,
					"scrollX": true,
					"paging":  false
				} );
				$('#userlist').DataTable( {
					"scrollY": 200,
					"scrollX": true,
					"paging":  false
				} );
			} )
        			
		}, 200);
		
	</script>
