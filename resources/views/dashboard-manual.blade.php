@extends('layouts.app')
<meta http-equiv="refresh" content="80">
@section('content')
<div class="row">

 <div class="col-sm-12 container dashcontainer table-responsive">	
 
<form class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
	{{ csrf_field() }}
	<!--<div style='width:35%;float:right;border:0;padding-top:0;text-align:right;' class='searchbox'>		
		@if ($showreporttype == 'all')
			<input class="btn btn-primary" type="submit" name="report_type" value="Show Today Report">
			<input type='hidden' name='showreporttype' value='today' />
		@else
			<input class="btn btn-primary" type="submit" name="report_type" value="Show All Report">
			<input type='hidden' name='showreporttype' value='all' />
		@endif 
	</div>-->
	<input type='hidden' name='listtype' id='listtype' value='{{$showreporttype}}' />
</form>
 <div class='jobtable_container' >
 <table border='0' width='100%' cellspacing='0' cellpadding='0' class='jobinfo_tablebox'>
  <tr>
    <th class='bordernone' colspan='6'>JOBS</th>
  </tr>
   <tr>    
	<th align='center'>
		Input Check 		
		<div class='healthcheck_signal'>
			<div class='innerbox'>
				<span class="green"><i class="fa fa-check" ></i></span>
				<span class="yellow"></span>
				<span class="red"></span>
			</div>
		<div>
	</th>
	<th>BPA
		<div class='healthcheck_signal'>
			<div class='innerbox'>
				<span class="green"><i class="fa fa-check" ></i></span>
				<span class="yellow"></span>
				<span class="red"></span>
			</div>
		<div>
	</th>
	<th>HAP</th>
	<th  class='bordernone'>Final Validation
		<div class='healthcheck_signal'>
			<div class='innerbox'>
				<span class="green"><i class="fa fa-check" ></i></span>
				<span class="yellow"></span>
				<span class="red"></span>
			</div>
		<div>
	</th>	
  </tr>
	<!--<tr>
		<td width='25%' align='center' style='padding-right:0px;padding-left:0px;';>
			<?php echo $dashboardcount['jobs_inputcheck']; ?>			
		</td>	
		
		<td width='25%' align='center' style='padding-right:0px;padding-left:0px;';>
			<?php echo $dashboardcount['jobs_xmlconversion']; ?>		
		</td>
		
		<td width='25%' align='center' style='padding-right:0px;padding-left:0px;';>		
			<?php echo $dashboardcount['jobs_hap']; ?>	
		</td>		
		<td width='25%' align='center' class='bordernone' style='padding-right:0px;padding-left:0px;';>
			<?php echo $dashboardcount['jobs_finalval']; ?>					
		</td>
	</tr>-->
	<tr>
		<td width='25%' align='center' style='padding-right:0px;padding-left:0px;';>
			
					<div class="job_container">
						<div class="lt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td style="border:0px;"></td></tr></table>
						</div>
						<div class="mid_clm">
							<div class="commonwidth">
								<div class="onhold-icon"><i class="fa fa-pause" style="padding-bottom:10px; !important;"></i></div>
								<div title='Input Check Hold' class="onhold-box" onclick="showreport('input_check','hold','all')">0</div>
					</div>						
						<div class="tile-stats">
							<div class="commonwidth">
								<div title='Input Check Pending' class="jobcontainerbox bg-blue num" data-start="0" onclick="showreport('input_check','pending','all')" data-end="397" data-duration="500" data-delay="0">397</div>
							</div>
						</div>				
						<div class="robot_container">
							<div class="jobrbt-img"><img src="img/robot.png" /></div>
							<div title='Input Check Instance' class="jobsubinfobox bg-blue" onclick="showreport('input_check','instance','all')">10</div>
						</div>			
						</div>
						<div class="rt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="completed_count">
										<div class="jobscompleted-box">
											<span class="txt">Completed</span>
											<span title='Input Check Completed' class="bg-green count" onclick="showreport('input_check','completed','all')">169</span>
										</div>
									</td>
								</tr>
								<tr>
									<td style="border:0px;"></td>
								</tr>
																													
							</table>
						</div>
					</div>			
		</td>			
		<td width='25%' align='center' style='padding-right:0px;padding-left:0px;';>			
					<div class="job_container">
						<div class="lt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td style="border:0px;"></td></tr></table>
						</div>
						<div class="mid_clm">
							<div class="commonwidth">
								<div class="onhold-icon"><i class="fa fa-pause" style="padding-bottom:10px; !important;"></i></div>
								<div title='BPA Hold' class="onhold-box" onclick="showreport('xmlconversion','hold','all')">0</div>
					</div>						
						<div class="tile-stats">
							<div class="commonwidth">
								<div title='BPA Pending' class="jobcontainerbox bg-blue num" data-start="0" onclick="showreport('xmlconversion','pending','all')" data-end="133" data-duration="500" data-delay="0">133</div>
							</div>
						</div>				
						<div class="robot_container">
							<div class="jobrbt-img"><img src="img/robot.png" /></div>
							<div title='BPA Instance' class="jobsubinfobox bg-blue" onclick="showreport('xmlconversion','instance','all')">10</div>
						</div>			
						</div>
						<div class="rt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="completed_count">
										<div class="jobscompleted-box">
											<span class="txt">Completed</span>
											<span title='BPA Completed' class="bg-green count" onclick="showreport('xmlconversion','completed','all')">87</span>
										</div>
									</td>
								</tr>
								<tr>
									<td style="border:0px;"></td>
								</tr>
																													
							</table>
						</div>
					</div>		
		</td>		
		<td width='25%' align='center' style='padding-right:0px;padding-left:0px;';>					
					<div class="job_container">
						<div class="lt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td style="border:0px;"></td></tr></table>
						</div>
						<div class="mid_clm">
							<div class="commonwidth">
								<div class="onhold-icon"><i class="fa fa-pause" style="padding-bottom:10px; !important;"></i></div>
								<div title='HAP Hold' class="onhold-box" onclick="showreport('hap','hold','all')">0</div>
					</div>		
						<div class="tile-stats">
							<div class="commonwidth">
								<div title='HAP Pending' class="jobcontainerbox bg-blue_hap num" onclick="showreport('hap','pending','all')" data-start="0" data-end="91" data-duration="500" data-delay="0">90</div>
							</div>
						</div>	
						<div class="info-container">
							<div class="boxcontaner" style="padding-top:10px;">
								<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
								<div title='Assigned Users' class="ticketinfobox bg-green">8</div>
								<div title='Waiting Users' class="ticketinfobox bg-orange">0</div>
								<div title='Users in Break' class="ticketinfobox bg-red">1</div>
							</div>
						</div>
									
						</div>
						<div class="rt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="completed_count">
										<div class="jobscompleted-box">
											<span class="txt">Completed</span>
											<span title='HAP Completed' class="bg-green count" onclick="showreport('hap','completed','all')">66</span>
										</div>
									</td>
								</tr>
								<tr>
									<td style="border:0px;"></td>
								</tr>
									
								<tr>
									<td style="border:0px;">
										<div style="margin-left: -25%;margin-top: -5%;" class="robot_container">
											<div class="jobrbt-img"><img src="img/Preloader_3.gif" /></div>
											<div title='HAP Instance' class="jobsubinfobox bg-blue" onclick="showreport('hap','instance','all')">2</div>
										</div>
									</td>
								</tr>
																													
							</table>
						</div>
					</div>	
		</td>		
		<td width='25%' align='center' class='bordernone' style='padding-right:0px;padding-left:0px;';>
			
					<div class="job_container">
						<div class="lt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td style="border:0px;"></td></tr></table>
						</div>
						<div class="mid_clm">
							<div class="commonwidth">
								<div class="onhold-icon"><i class="fa fa-pause" style="padding-bottom:10px; !important;"></i></div>
								<div title='Final Validation Hold' class="onhold-box" onclick="showreport('finalvalidation','hold','all')">0</div>
					</div>						
						<div class="tile-stats">
							<div class="commonwidth">
								<div title='Final Validation Pending' class="jobcontainerbox bg-blue num" data-start="0" onclick="showreport('finalvalidation','pending','all')" data-end="21" data-duration="500" data-delay="0">21</div>
							</div>
						</div>				
						<div class="robot_container">
							<div class="jobrbt-img"><img src="img/robot.png" /></div>
							<div title='Final Validation Instance' class="jobsubinfobox bg-blue" onclick="showreport('finalvalidation','instance','all')">7</div>
						</div>			
						</div>
						<div class="rt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="completed_count">
										<div class="jobscompleted-box">
											<span class="txt">Completed</span>
											<span title='Final Validation Completed' class="bg-green count" onclick="showreport('finalvalidation','completed','all')">13</span>
										</div>
									</td>
								</tr>
								<tr>
									<td style="border:0px;"></td>
								</tr>
																													
							</table>
						</div>
					</div>					
		</td>
	</tr>
</table>
</div>
 </div>
 <div class="col-sm-12 container dashcontainer table-responsive">	
 <table border='0' width='100%' cellspacing='0' cellpadding='0' >
  <tr>					
		<td valign='bottom' align='center' class='bordernone'>				
				<div class='tickettable_container' >
				 <table border='0' width='100%' cellspacing='0' cellpadding='0' class='ticketinfo_tablebox tickettable' style="border-collapse:collapse;">
				  <tr>
					<th class='bordernone' colspan='8'>TICKETS</th>
				  </tr>
					<tr>
				   
					<th>Reference</th>
					<th>Affiliation</th>
					<th>Item Type</th>
					<th>Grant</th>
					<th class='bordernone'>Math Expression</th>	
				  </tr>
				  <!--<tr>							
						<td align='center' valign='top'>
							<?php echo $dashboardcount['ticket_reference']; ?>
						</td>
						<td valign='top' align='center'>
							<?php echo $dashboardcount['ticket_affiliation']; ?>
						</td>	
						<td valign='top' align='center'>
							<?php echo $dashboardcount['ticket_item_type']; ?>
						</td>
						<td valign='top' align='center'>
							<?php echo $dashboardcount['ticket_grant']; ?>			
						</td>

						<td valign='top' align='center' class='bordernone'>
							<?php echo $dashboardcount['ticket_math_expression']; ?>
						</td>
					</tr>-->
	<tr>							
						<td align='center' valign='top'>
							<div>
						<div title='Reference Tickets Completed' class="ticketcompleted-box">
							<span class="txt">Completed</span><span class="bg-green count" onclick="showticketreport('Reference','completed','all')">118</span>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">							
								<div class="jobs_count">
									<span class="process_cnt" title='Jobs Reference In-Progress' onclick="showjobsreport('Reference','progress','all')">90</span>
									<span class="sep"></span>
									<span class="waiting_cnt" title='Jobs Reference Pending' onclick="showjobsreport('Reference','pending','all')">3</span>
								</div>								
								<span class="main_cnt" title='Reference Tickets Pending' onclick="showticketreport('Reference','pending','all')">227</span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
							<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
							<div title='Assigned Reference Users' class="ticketinfobox bg-green" onclick="show_workrequestreport('Reference','assigned')">6</div>
							<div title='Waiting Reference Users' class="ticketinfobox bg-orange" onclick="show_workrequestreport('Reference','waiting')">0</div>
							<div title='Reference Users In Break' class="ticketinfobox bg-red" onclick="show_workrequestreport('Reference','break')">1</div>
							</div>
						</div>
					</div>						</td>
						<td valign='top' align='center'>
							<div>
						<div title='Affiliation Tickets Completed' class="ticketcompleted-box">
							<span class="txt">Completed</span><span class="bg-green count" onclick="showticketreport('Affiliation','completed','all')">0</span>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">							
								<div class="jobs_count">
									<span title='Jobs Affiliation In-Progress' class="process_cnt" onclick="showjobsreport('Affiliation','progress','all')">0</span>
									<span class="sep"></span>
									<span title='Jobs Affiliation Pending' class="waiting_cnt" onclick="showjobsreport('Affiliation','pending','all')">0</span>
								</div>								
								<span title='Affiliation Tickets Pending' class="main_cnt" onclick="showticketreport('Affiliation','pending','all')">0</span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
							<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
							<div title='Assigned Affiliation Users' class="ticketinfobox bg-green" onclick="show_workrequestreport('Affiliation','assigned')">0</div>
							<div title='Waiting Affiliation Users' class="ticketinfobox bg-orange" onclick="show_workrequestreport('Affiliation','waiting')">0</div>
							<div title='Affiliation Users In Break' class="ticketinfobox bg-red" onclick="show_workrequestreport('Affiliation','break')">0</div>
							</div>
						</div>
					</div>						</td>	
						<td valign='top' align='center'>
							<div>
						<div title='Item Type Tickets Completed' class="ticketcompleted-box">
							<span class="txt">Completed</span><span class="bg-green count" onclick="showticketreport('Item Type','completed','all')">11</span>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">							
								<div class="jobs_count">
									<span title='Jobs Item Type In-Progress' class="process_cnt" onclick="showjobsreport('Item Type','progress','all')">26</span>
									<span class="sep"></span>
									<span  title='Jobs Item Type In-Progress' class="waiting_cnt" onclick="showjobsreport('Item Type','pending','all')">1</span>
								</div>								
								<span title='Item-Type Tickets Pending' class="main_cnt" onclick="showticketreport('Item Type','pending','all')">26</span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
							<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
							<div title='Assigned Item Type Users' class="ticketinfobox bg-green" onclick="show_workrequestreport('Item Type','assigned')">1</div>
							<div title='Waiting Item Type Users' class="ticketinfobox bg-orange" onclick="show_workrequestreport('Item Type','waiting')">0</div>
							<div title='Item Type Users In Break' class="ticketinfobox bg-red" onclick="show_workrequestreport('Item Type','break')">0</div>
							</div>
						</div>
					</div>						</td>
						<td valign='top' align='center'>
							<div>
						<div title='Grant Tickets Completed' class="ticketcompleted-box">
							<span class="txt">Completed</span><span class="bg-green count" onclick="showticketreport('Grant','completed','all')">0</span>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">							
								<div class="jobs_count">
									<span title='Jobs Grant In-Progress' class="process_cnt" onclick="showjobsreport('Grant','progress','all')">0</span>
									<span class="sep"></span>
									<span title='Jobs Grant Pending' class="waiting_cnt" onclick="showjobsreport('Grant','pending','all')">0</span>
								</div>								
								<span title='Grant Tickets Pending' class="main_cnt" onclick="showticketreport('Grant','pending','all')">0</span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
							<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
							<div title='Assigned Grant Users' class="ticketinfobox bg-green" onclick="show_workrequestreport('Grant','assigned')">0</div>
							<div title='Waiting Grant Users' class="ticketinfobox bg-orange" onclick="show_workrequestreport('Grant','waiting')">0</div>
							<div title='Grant Users In Break' class="ticketinfobox bg-red" onclick="show_workrequestreport('Grant','break')">0</div>
							</div>
						</div>
					</div>
						</td>

						<td valign='top' align='center' class='bordernone'>
							<div>
						<div title='Math Expression Tickets Completed' class="ticketcompleted-box">
							<span class="txt">Completed</span><span class="bg-green count" onclick="showticketreport('Math Expression','completed','all')">0</span>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">							
								<div class="jobs_count">
									<span title='Jobs Math Expression In-Progress' class="process_cnt" onclick="showjobsreport('Math Expression','progress','all')">0</span>
									<span class="sep"></span>
									<span title='Jobs Math Expression Pending' class="waiting_cnt" onclick="showjobsreport('Math Expression','pending','all')">0</span>
								</div>								
								<span title='Math Expression Tickets Pending' class="main_cnt" onclick="showticketreport('Math Expression','pending','all')">0</span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
								<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
								<div title='Assigned Math Expression Users' class="ticketinfobox bg-green" onclick="show_workrequestreport('Math Expression','assigned')">0</div>
								<div title='Waiting Math Expression Users'  class="ticketinfobox bg-orange" onclick="show_workrequestreport('Math Expression','waiting')">0</div>
								<div title='Math Expression Users In Break' class="ticketinfobox bg-red" onclick="show_workrequestreport('Math Expression','break')">0</div>
							</div>
						</div>
					</div>	
					</td>
					</tr>				
				</table>
				</div>							
		</td>			
		<td valign='bottom' align='center' class='bordernone'>				
				<div class='tickettable_validation' >
				 <table border='0' width='100%' cellspacing='0' cellpadding='0' class='ticketinfo_tablebox tickettable' style="border-collapse:collapse;">				 
				<tr height='61px;' >
					<th  class='bordernone' >Validation</th>
				</tr>
				  <!--<tr>													
						<td  valign='bottom' align='center' class='bordernone'>
							<?php echo $dashboardcount['ticket_Validation']; ?>			
						</td>
					</tr>-->
					<tr>													
						<td  valign='bottom' align='center' class='bordernone'>
							<div>
								<div class="ticketcompleted-box">
									<span title='Validation Tickets Completed' class="txt">Completed</span><span class="bg-green count" onclick="showticketreport('Validation','completed','all')">0</span>
								</div>
								<div class="cntcontainer">
									<div class="ticketcontainerbox ticket-bg">							
										<div class="jobs_count">
											<span title='Jobs Validation In-Progress' class="process_cnt" onclick="showjobsreport('Validation','progress','all')">0</span>
											<span class="sep"></span>
											<span title='Jobs Validation Pending' class="waiting_cnt" onclick="showjobsreport('Validation','pending','all')">0</span>
										</div>								
										<span title='Validation Tickets Pending'  class="main_cnt" onclick="showticketreport('Validation','pending','all')">0</span>
									</div>
								</div>						
								<div class="info-container">
									<div class="boxcontaner">
									<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
									<div title='Assigned Validation Users' class="ticketinfobox bg-green" onclick="show_workrequestreport('Validation','assigned')">0</div>
									<div title='Waiting Validation Users' class="ticketinfobox bg-orange" onclick="show_workrequestreport('Validation','waiting')">0</div>
									<div title='Validation Users In Break' class="ticketinfobox bg-red" onclick="show_workrequestreport('Validation','break')">0</div>
									</div>
								</div>
							</div>			
						</td>
					</tr>
				</table>
				</div>
		</td>
	</tr>
</table>
 </div>
 </div>
<script src="{{url('js/num/jquery-1.11.0.min.js')}}"></script>
<script src="{{url('js/num/main-gsap.js')}}"></script>
<script src="{{url('js/num/joinable.js')}}"></script>
<script src="{{url('js/num/resizeable.js')}}"></script>
<script src="{{url('js/num/neon-custom.js')}}"></script>
  <!-- Footer -->
  @include('layouts.footer')
  @include('layouts.scriptfooter')
<script type="text/javascript">
	/*setInterval(function() {
		//window.location.reload(1);
	 var reporttype =  $('#listtype').val();
   	 $.ajax({
            type: 'GET',
            url: "{{route('home')}}",
            data: 'ajaxload=1&showreporttype='+reporttype,			
            success: function(data){
                jQuery(".content").html(data);
            },
          });
	}, 800000000);*/
	function showreport(type,status,showreporttype)
	{
		$.ajax({
		type: 'GET',
		url: "{{url('reports/jobs_popupreport')}}",            
		data: 'ajaxload=1&type='+type+'&status='+status+'&showreporttype='+showreporttype,			
		success: function(data){                
			//bootbox.alert(data);
		},
	  });			
	}
	function showticketreport(type,status,showreporttype)
	{
		$.ajax({
		type: 'GET',
		url: "{{url('reports/ticket_popupreport')}}",            
		data: 'ajaxload=1&type='+type+'&status='+status+'&showreporttype='+showreporttype,			
		success: function(data){                
			//bootbox.alert(data);
		},
	  });			
	}
	function show_workrequestreport(type,status)
	{
		$.ajax({
		type: 'GET',
		url: "{{url('reports/workrequest_popupreport')}}",            
		data: 'ajaxload=1&type='+type+'&status='+status,			
		success: function(data){                
			//bootbox.alert(data);
		},
	  });			
	}
	function showjobsreport(type,status,showreporttype)
	{
		$.ajax({
		type: 'GET',
		url: "{{url('reports/jobstatus_popupreport')}}",
		data: 'ajaxload=1&type='+type+'&status='+status+'&showreporttype='+showreporttype,
		success: function(data){
			//bootbox.alert(data);
		},
	  });			
	}
	
</script>
@endsection
