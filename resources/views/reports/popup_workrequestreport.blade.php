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
	.modal-body{height:440px;}
	.dataTables_scrollBody{ height:300px !important;}
</style>
		<div id='workrequestloader' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
       
		 
          <table id="workrequest" class="display nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>                
				<th>User Name</th>
				<th>Project Type</th> 
				<?php if($_ENV['SHOW_VENDOR'] == '1') {?>
				<th>Domain</th> 
				<?php } ?>
				<?php if($_ENV['SHOW_GROUP'] == '1') {?>
				<th>User Group </th> 
				<?php } ?>
				
                <th>Login Time</th>  
				<th>Total Ticket</th>								
				<th>Avg Ticket Time</th>
				<!--<th>Break Count</th>--> 
				<th>Total Break Time</th> 			               
              </tr>
          </thead>
          <tbody>	

		  @if (count($result))
			@foreach ($result as $k => $results)
				<tr>             						
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->user_id }}</td>
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->project_type }}</td>
					<?php if($_ENV['SHOW_VENDOR'] == '1') {?>									
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->user_type }}</td>
					<?php } ?>
					<?php if($_ENV['SHOW_GROUP'] == '1') {?>									
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->group_name }}</td>
					<?php } ?>
					
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->login_datetime != '' ? date('d-M-y h:m A', strtotime($results->login_datetime)) : "" }}</td>
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->total_ticket }}</td>
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->avg_ticket }}</td>
					<!--<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->total_break }}</td>-->
					<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->breaktime }}</td>
					
				</tr>
			  @endforeach
			
			@endif
          </tbody>
        </table>

     
     
	<script>
		setTimeout(function() {
			$(document).ready(function() {
				document.getElementById("workrequestloader").style.display = "none";
				$('#workrequest').DataTable( {
					"scrollY": 200,
					"scrollX": true,
					"paging":  false,
					"pageLength":  100
				} );
			} )
        			
		}, 200);
		
	</script>
