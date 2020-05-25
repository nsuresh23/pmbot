<?php
$startime = date('Y-m-d H:i:s');
$pageurl = $_SERVER['REQUEST_URI'];
?> 

@extends('layouts.app')
@section('content')

<div class="row">

<div class="col-sm-12 container dashcontainer table-responsive">	

 <div class='jobtable_container' >
 	<div class="col-md-12 jobinfo_tablebox" style="padding:0px;">

        <div class="col-md-2 col-sm-6 col-xs-12 jobsbox leftbordernone">
          <span class="tkthead">Input Check</span>     
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
				<span class="green"><i class="fa fa-check" ></i></span>
				<span class="yellow"></span>
				<span class="red"></span>
            </div>
          </div>          
          
						<div class="job_container">
							<div class="lt_clm">
								<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td style="border:0px;"></td></tr></table>
							</div>							
							<div class="mid_clm">
								<div class="commonwidth">
									<div class="onhold-icon"><i class="fa fa-pause" style="padding-bottom:10px; !important;"></i></div>

									<div class="onhold-box tool_tip"  style="padding:5px 5px 5px 8px; !important;" onclick="showreport('InputCheck_HOLD','hold','all','all')">9<span class="tooltiptext">InputCheck Hold</span>									
								</div>								
								<div class="onhold-icon" style="margin-left:8px;"><i class="fa fa-close" style="font-size:16px;"></i></div>
									<div class="nnp-box tool_tip" onclick="showreport('InputCheck_NNP','NNP','all','all')">4<span class="tooltiptext">InputCheck NNP</span>									
								</div>								
						</div>						
						<div class="tile-stats">
							<div class="commonwidth">
								<div class="jobcontainerbox bg-blue num tool_tip"  onclick="showreport('InputCheck','pending','all','all')" >943<span class="tooltiptext jobstooltip">InputCheck Pending</span></div>
							</div>
						</div>				
						<div class="robot_container">
							<div class="jobrbt-img"><img src="img/robot.png" /></div>
							<div class="jobsubinfobox bg-blue tool_tip" onclick="showreport('InputCheck_WIP','instance','all','all')">5<span class="tooltiptext">InputCheck Instance</span></div>
						</div>			
						</div>
						<div class="rt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="completed_count">
										
									</td>
								</tr>
								<tr>
									<td style="border:0px;"></td>
								</tr>
								
							</table>
						</div>
					</div>        </div>
        <!-- /.col -->
        <!-- <div class="clearfix visible-sm-block"></div> -->
		
        <div class="col-md-2 col-sm-6 col-xs-12 jobsbox" id="bpabox">
           <span class="tkthead">BPA</span> 
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
				<span class="green"><i class="fa fa-check" ></i></span>
				<span class="yellow"></span>
				<span class="red"></span>
            </div>
          </div>
          <!-- <div class="rowborder"></div> -->
          
						<div class="job_container">
							<div class="lt_clm">
								<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td style="border:0px;"></td></tr></table>
							</div>							
							<div class="mid_clm">
								<div class="commonwidth">
									<div class="onhold-icon"><i class="fa fa-pause" style="padding-bottom:10px; !important;"></i></div>

									<div class="onhold-box tool_tip"  style="padding:5px 5px 5px 8px; !important;" onclick="showreport('BPA_HOLD','hold','all','all')">2<span class="tooltiptext">BPA Hold</span>									
								</div>								
								<div class="onhold-icon" style="margin-left:8px;"><i class="fa fa-close" style="font-size:16px;"></i></div>
									<div class="nnp-box tool_tip" onclick="showreport('BPA_NNP','NNP','all','all')">5<span class="tooltiptext">BPA NNP</span>									
								</div>								
						</div>						
						<div class="tile-stats">
							<div class="commonwidth">
								<div class="jobcontainerbox bg-blue num tool_tip"  onclick="showreport('BPA','pending','all','all')" >851<span class="tooltiptext jobstooltip">BPA Pending</span></div>
							</div>
						</div>				
						<div class="robot_container">
							<div class="jobrbt-img"><img src="img/robot.png" /></div>
							<div class="jobsubinfobox bg-blue tool_tip" onclick="showreport('BPA_WIP','instance','all','all')">12<span class="tooltiptext">BPA Instance</span></div>
						</div>			
						</div>
						<div class="rt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="completed_count">
										
									</td>
								</tr>
								<tr>
									<td style="border:0px;"></td>
								</tr>
								
							</table>
						</div>
					</div>        </div>
        <!-- /.col -->
		
		<!-- <div class="clearfix visible-sm-block"></div> -->
		
        <div class="col-md-2 col-sm-6 col-xs-12 jobsbox" id="bpabox">
           <span class="tkthead">Item Type</span> 
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
				<span class="green"><i class="fa fa-check" ></i></span>
				<span class="yellow"></span>
				<span class="red"></span>
            </div>
          </div>
          <!-- <div class="rowborder"></div> -->
          
						<div class="job_container">
							<div class="lt_clm">
								<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td style="border:0px;"></td></tr></table>
							</div>							
							<div class="mid_clm">
								<div class="commonwidth">
									<div class="onhold-icon"><i class="fa fa-pause" style="padding-bottom:10px; !important;"></i></div>

									<div class="onhold-box tool_tip"  style="padding:5px 5px 5px 8px; !important;" onclick="showreport('Itemtype_HOLD','hold','all','all')">0<span class="tooltiptext">Itemtype Hold</span>									
								</div>								
								<div class="onhold-icon" style="margin-left:8px;"><i class="fa fa-close" style="font-size:16px;"></i></div>
									<div class="nnp-box tool_tip" onclick="showreport('Itemtype_NNP','NNP','all','all')">2<span class="tooltiptext">Itemtype NNP</span>									
								</div>								
						</div>						
						<div class="tile-stats">
							<div class="commonwidth">
								<div class="jobcontainerbox bg-blue num tool_tip"  onclick="showreport('Itemtype','pending','all','all')" >137<span class="tooltiptext jobstooltip">Itemtype Pending</span></div>
							</div>
						</div>				
						<div class="robot_container">
							<div class="jobrbt-img"><img src="img/robot.png" /></div>
							<div class="jobsubinfobox bg-blue tool_tip" onclick="showreport('Itemtype_WIP','instance','all','all')">3<span class="tooltiptext">Itemtype Instance</span></div>
						</div>			
						</div>
						<div class="rt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="completed_count">
										
									</td>
								</tr>
								<tr>
									<td style="border:0px;"></td>
								</tr>
								
							</table>
						</div>
					</div>        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
       <!--  <div class="clearfix visible-sm-block"></div> -->


		
		  <div class="col-md-2 col-sm-6 col-xs-12 jobsbox" id="bpabox">
           <span class="tkthead">HAP</span> 
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
              <span class="white">&nbsp;</span>
              <span class="white"></span>
              <span class="white"></span>
            </div>
          </div>
          <!-- <div class="rowborder"></div> -->
          
						<div class="job_container">
							<div class="lt_clm">
								<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td style="border:0px;"></td></tr></table>
							</div>							
							<div class="mid_clm">
								<div style="width:90% !important" class="commonwidth">
									<div class="onhold-icon"><i class="fa fa-pause" style="padding-bottom:10px; !important;"></i></div>
									<div class="onhold-box tool_tip" onclick="showreport('HAP_HOLD','hold','all','all')">0<span class="tooltiptext">HAP Hold</span></div>									
									<div class="wip-box tool_tip" onclick="showreport('HAP_WIP','instance','all','all')">14<span class="tooltiptext">HAP WIP</span></div>
								
						</div>		
						<div class="tile-stats">
							<div style="width:90% !important;" class="commonwidth">
								<div class="jobcontainerbox bg-blue_hap num tool_tip" onclick="showreport('HAP','pending','all','all')" >381<span class="tooltiptext jobstooltip">HAP Pending</span></div>
							</div>
						</div>	
						<div class="info-container">
							<div class="boxcontaner" style="padding-top:10px;width:100%;">
								<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
								<div style="width: 25px;" class="ticketinfobox bg-green tool_tip" >13<span class="tooltiptext">Assigned Users</span></div>
								<div style="width: 25px;" class="ticketinfobox bg-orange tool_tip">0<span class="tooltiptext">Waiting Users</span></div>
								<div style="width: 25px;" class="ticketinfobox bg-red tool_tip">2<span class="tooltiptext">Users in Break</span></div>
							</div>
						</div>
									
						</div>
						<div class="rt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="completed_count">
										
									</td>
								</tr>
								<tr>
									<td style="border:0px;"></td>
								</tr>
									
								<tr>
									<td id="jobs_progress" style="border:0px;">
										<div style="margin-left: -40%;margin-top: -50%;" class="robot_container">
											<div style="float:initial;" class="jobrbt-img"><img src="img/Preloader_3.gif" /></div>
											<div class="jobsubinfobox bg-blue tool_tip" onclick="showreport('jobsprogress','instance','all','all')">1015<span class="tooltiptext">Jobs Progress :: Ticket In-Queue</span></div>
										</div>
									</td>
								</tr>
								
							</table>
						</div>
					</div>        </div>
		
		
        <!-- /.col -->
        <div class="col-md-2 col-sm-6 col-xs-12 jobsbox tktbox">
          <span class="tkthead">Validation</span> 
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
				<span class="green"><i class="fa fa-check" ></i></span>
				<span class="yellow"></span>
				<span class="red"></span>
            </div>
          </div>
          <!-- <div class="rowborder"></div> -->
          
						<div class="job_container">
							<div class="lt_clm">
								<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td style="border:0px;"></td></tr></table>
							</div>							
							<div class="mid_clm">
								<div class="commonwidth">
									<div class="onhold-icon"><i class="fa fa-pause" style="padding-bottom:10px; !important;"></i></div>
									<div class="onhold-box tool_tip" onclick="showreport('FinalValidation_HOLD','hold','all','all')">0<span class="tooltiptext">FinalValidation Hold</span></div>
						</div>						
						<div class="tile-stats">
							<div class="commonwidth">
								<div class="jobcontainerbox bg-blue num tool_tip"  onclick="showreport('FinalValidation','pending','all','all')" >244<span class="tooltiptext jobstooltip">FinalValidation Pending</span></div>
							</div>
						</div>				
						<div class="robot_container">
							<div class="jobrbt-img"><img src="img/robot.png" /></div>
							<div class="jobsubinfobox bg-blue tool_tip" onclick="showreport('FinalValidation_WIP','instance','all','all')">10<span class="tooltiptext">FinalValidation Instance</span></div>
						</div>			
						</div>
						<div class="rt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="completed_count">
										<!--<div class="jobscompleted-box">
											<span class="txt">Completed</span>
											<span class="bg-green count tool_tip" onclick="showreport('Completed','completed','all','all')">0<span class="tooltiptext">FinalValidation Completed</span></span>
										</div>-->
									</td>
								</tr>
								<tr>
									<td style="border:0px;"></td>
								</tr>
								
							</table>
						</div>
					</div>        </div>
        <!-- /.col -->
		      <div class="col-md-2 col-sm-6 col-xs-12 jobsbox tktbox">
          <span class="tkthead">Signal & Package</span> 
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
				&nbsp              
            </div>
          </div>
          <!-- <div class="rowborder"></div> -->
          <div class="job_container"><div class="sp-box">	
							<div class="commonwidth">
								<div class="onhold-icon"><i class="fa fa-pause" style="padding-bottom:10px; !important;"></i></div>
									<div class="onhold-box tool_tip" onclick="showreport('Signal_HOLD','hold','all','all')">31<span class="tooltiptext">Signal Hold</span></div>	
						</div>							
							<div class="count_box signal-color" style="padding: 2px; font-size: 10px;" onclick="showreport('Signal','pending','all','all')">
								Signal
								<span style="font-size: 20px; font-weight: bold;">1120</span>
							</div>
							<div class="count_box norightmargin checklist-color" style="padding: 2px; font-size: 10px;" onclick="showreport('CheckList','pending','all','all')">
								Check List
								<span style="font-size: 20px; font-weight: bold;">710</span>
							</div>																									
							<div class="count_box package-color" style="padding: 2px; font-size: 10px;" onclick="showreport('Packaging','pending','all','all')">
								Package
								<span style="font-size: 20px; font-weight: bold;">239</span>
							</div>
							<div class="count_box norightmargin dispatch-color" style="padding: 2px; font-size: 10px;" onclick="showreport('Dispatched','pending','all','all')">
								Dispatch
								<span style="font-size: 20px; font-weight: bold;">36794</span>
							</div>
									
						</div>
						<div class="rt_clm">
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="completed_count">
										
									</td>
								</tr>
								<tr>
									<td style="border:0px;"></td>
								</tr>
								
							</table>
						</div>
					</div>        </div>
        <!-- /.col -->
 </div>
 <!-- col-md-12 div -->
</div>
</div>
<div class="col-sm-12 nopadding">

	<div  style='margin-top:7px;' class="col-md-2 col-sm-6 col-xs-12 nopadding">
		<div style='margin-left:0px;width:100%;' class='tickettable_validation' >
			 <table border='0' width='100%' cellspacing='0' cellpadding='0' class='ticketinfo_tablebox tickettable' style="border-collapse:collapse;">
			<tr>
				<th class='bordernone' style='height:60px;'>Item Type</th>
			</tr>
			  <tr>													
				<td  valign='bottom' align='center' class='bordernone'>
					<div>
						<div style="float:left;width:100%;">
							<div class="ticketquery-box">
								<span class="txt">Query</span><span class="bg-darkgray count tool_tip" onclick="showticketqueryreport('Item Type','ticket_query','all','all')">2<span class="tooltiptext">Item Type Query</span></span>
							</div>
							<div style="float:right;width:50%;"  class="ticketcompleted-box">
								<span class="txt">Completed</span><span class="bg-green count tool_tip" onclick="showticketreport('Item Type','completed','all','all')">492<span class="tooltiptext">Item Type Completed</span></span>
							</div>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">
								<div class="jobs_count">								
									<span class="waiting_cnt tool_tip" onclick="showjobsreport('Item Type','pending','all','all')">267<span class="tooltiptext ticketstooltip">Jobs Pending</span></span>								
									<span class="sep"></span>									
									<span class="process_cnt tool_tip" onclick="showjobsreport('Item Type','progress','all','all')">2<span class="tooltiptext ticketstooltip">Jobs Progress</span></span>									
								</div>								
								<span class="main_cnt tool_tip " onclick="showticketreport('Item Type','pending','all','all')">267<span class="tooltiptext ticketstooltip">Item Type Pending</span></span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
							<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
							<div class="ticketinfobox bg-green tool_tip" onclick="show_workrequestreport('Item Type','assigned','all','all')">2<span class="tooltiptext">Assigned Item Type Users</span></div>
							<div class="ticketinfobox bg-orange tool_tip" onclick="show_workrequestreport('Item Type','waiting','all','all')">0<span class="tooltiptext">Waiting Item Type Users</span></div>
							<div class="ticketinfobox bg-red tool_tip" onclick="show_workrequestreport('Item Type','break','all','all')">0<span class="tooltiptext">Item Type Users In Break</span></div>
							</div>
						</div>
					</div>				</td>
			  </tr>
			</table>
		</div>
	</div>

	<div style='padding-right:0px;margin-top:7px;' class="col-md-8 col-sm-6 col-xs-12 ticketcontainer">
		<div class='tickettable_container' >
				<table border='0' width='100%' cellspacing='0' cellpadding='0' class='ticketinfo_tablebox tickettable' style="border-collapse:collapse;">
					<tr>
						<th class='bordernone' colspan='8'>TICKETS</th>
					</tr>
					<tr>
						<th>Reference</th>
						<th>Grant</th>											
						<th>Affiliation</th>
						<th class='bordernone'>Math Expression</th>	
					</tr>
					<tr>
						<td align='center' valign='top'><div>
						<div style="float:left;width:100%;">
							<div class="ticketquery-box">
								<span class="txt">Query</span><span class="bg-darkgray count tool_tip" onclick="showticketqueryreport('Reference','ticket_query','all','all')">7<span class="tooltiptext">Reference Query</span></span>
							</div>
							<div style="float:right;width:50%;"  class="ticketcompleted-box">
								<span class="txt">Completed</span><span class="bg-green count tool_tip" onclick="showticketreport('Reference','completed','all','all')">11741<span class="tooltiptext">Reference Completed</span></span>
							</div>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">
								<div class="jobs_count">								
									<span class="waiting_cnt tool_tip" onclick="showjobsreport('Reference','pending','all','all')">738 <span class="tooltiptext ticketstooltip">Jobs Pending</span></span>								
									<span class="sep"></span>									
									<span class="process_cnt tool_tip" onclick="showjobsreport('Reference','progress','all','all')">2<span class="tooltiptext ticketstooltip">Jobs Progress</span></span>									
								</div>								
								<span class="main_cnt tool_tip " onclick="showticketreport('Reference','pending','all','all')">4041<span class="tooltiptext ticketstooltip">Reference Pending</span></span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
							<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
							<div class="ticketinfobox bg-green tool_tip" onclick="show_workrequestreport('Reference','assigned','all','all')">5 <span class="tooltiptext">Assigned Reference Users</span></div>
							<div class="ticketinfobox bg-orange tool_tip" onclick="show_workrequestreport('Reference','waiting','all','all')">0 <span class="tooltiptext">Waiting Reference Users</span></div>
							<div class="ticketinfobox bg-red tool_tip" onclick="show_workrequestreport('Reference','break','all','all')">1<span class="tooltiptext">Reference Users In Break</span></div>
							</div>
						</div>
					</div></td>
						<td valign='top' align='center'><div>
						<div style="float:left;width:100%;">
							<div class="ticketquery-box">
								<span class="txt">Query</span><span class="bg-darkgray count tool_tip" onclick="showticketqueryreport('Grant','ticket_query','all','all')">1<span class="tooltiptext">Grant Query</span></span>
							</div>
							<div style="float:right;width:50%;"  class="ticketcompleted-box">
								<span class="txt">Completed</span><span class="bg-green count tool_tip" onclick="showticketreport('Grant','completed','all','all')">822<span class="tooltiptext">Grant Completed</span></span>
							</div>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">
								<div class="jobs_count">								
									<span class="waiting_cnt tool_tip" onclick="showjobsreport('Grant','pending','all','all')">117 <span class="tooltiptext ticketstooltip">Jobs Pending</span></span>								
									<span class="sep"></span>									
									<span class="process_cnt tool_tip" onclick="showjobsreport('Grant','progress','all','all')">1<span class="tooltiptext ticketstooltip">Jobs Progress</span></span>									
								</div>								
								<span class="main_cnt tool_tip " onclick="showticketreport('Grant','pending','all','all')">180<span class="tooltiptext ticketstooltip">Grant Pending</span></span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
							<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
							<div class="ticketinfobox bg-green tool_tip" onclick="show_workrequestreport('Grant','assigned','all','all')">1 <span class="tooltiptext">Assigned Grant Users</span></div>
							<div class="ticketinfobox bg-orange tool_tip" onclick="show_workrequestreport('Grant','waiting','all','all')">0 <span class="tooltiptext">Waiting Grant Users</span></div>
							<div class="ticketinfobox bg-red tool_tip" onclick="show_workrequestreport('Grant','break','all','all')">1<span class="tooltiptext">Grant Users In Break</span></div>
							</div>
						</div>
					</div></td>							
						<td valign='top' align='center'><div>
						<div style="float:left;width:100%;">
							<div class="ticketquery-box">
								<span class="txt">Query</span><span class="bg-darkgray count tool_tip" onclick="showticketqueryreport('Affiliation','ticket_query','all','all')">1<span class="tooltiptext">Affiliation Query</span></span>
							</div>
							<div style="float:right;width:50%;"  class="ticketcompleted-box">
								<span class="txt">Completed</span><span class="bg-green count tool_tip" onclick="showticketreport('Affiliation','completed','all','all')">267<span class="tooltiptext">Affiliation Completed</span></span>
							</div>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">
								<div class="jobs_count">								
									<span class="waiting_cnt tool_tip" onclick="showjobsreport('Affiliation','pending','all','all')">233 <span class="tooltiptext ticketstooltip">Jobs Pending</span></span>								
									<span class="sep"></span>									
									<span class="process_cnt tool_tip" onclick="showjobsreport('Affiliation','progress','all','all')">2<span class="tooltiptext ticketstooltip">Jobs Progress</span></span>									
								</div>								
								<span class="main_cnt tool_tip " onclick="showticketreport('Affiliation','pending','all','all')">233<span class="tooltiptext ticketstooltip">Affiliation Pending</span></span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
							<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
							<div class="ticketinfobox bg-green tool_tip" onclick="show_workrequestreport('Affiliation','assigned','all','all')">2 <span class="tooltiptext">Assigned Affiliation Users</span></div>
							<div class="ticketinfobox bg-orange tool_tip" onclick="show_workrequestreport('Affiliation','waiting','all','all')">0 <span class="tooltiptext">Waiting Affiliation Users</span></div>
							<div class="ticketinfobox bg-red tool_tip" onclick="show_workrequestreport('Affiliation','break','all','all')">0<span class="tooltiptext">Affiliation Users In Break</span></div>
							</div>
						</div>
					</div></td>
						<td valign='top' align='center' class='bordernone'><div>
						<div style="float:left;width:100%;">
							<div class="ticketquery-box">
								<span class="txt">Query</span><span class="bg-darkgray count tool_tip" onclick="showticketqueryreport('Math Expression','ticket_query','all','all')">0<span class="tooltiptext">Math Expression Query</span></span>
							</div>
							<div style="float:right;width:50%;"  class="ticketcompleted-box">
								<span class="txt">Completed</span><span class="bg-green count tool_tip" onclick="showticketreport('Math Expression','completed','all','all')">0<span class="tooltiptext">Math Expression Completed</span></span>
							</div>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">
								<div class="jobs_count">								
									<span class="waiting_cnt tool_tip" onclick="showjobsreport('Math Expression','pending','all','all')">0 <span class="tooltiptext ticketstooltip">Jobs Pending</span></span>								
									<span class="sep"></span>									
									<span class="process_cnt tool_tip" onclick="showjobsreport('Math Expression','progress','all','all')">0<span class="tooltiptext ticketstooltip">Jobs Progress</span></span>									
								</div>								
								<span class="main_cnt tool_tip " onclick="showticketreport('Math Expression','pending','all','all')">0<span class="tooltiptext ticketstooltip">Math Expression Pending</span></span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
							<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
							<div class="ticketinfobox bg-green tool_tip" onclick="show_workrequestreport('Math Expression','assigned','all','all')">0 <span class="tooltiptext">Assigned Math Expression Users</span></div>
							<div class="ticketinfobox bg-orange tool_tip" onclick="show_workrequestreport('Math Expression','waiting','all','all')">0 <span class="tooltiptext">Waiting Math Expression Users</span></div>
							<div class="ticketinfobox bg-red tool_tip" onclick="show_workrequestreport('Math Expression','break','all','all')">0<span class="tooltiptext">Math Expression Users In Break</span></div>
							</div>
						</div>
					</div></td>
					</tr>
				</table>
			</div>
	</div>
	<div style='padding-left:0px;margin-top:7px;' class="col-md-2 col-sm-6 col-xs-12 ticketvalcontainer">
		<div class='tickettable_validation' style='width:100%;margin-left:18px;' >
			 <table border='0' width='100%' cellspacing='0' cellpadding='0' class='ticketinfo_tablebox tickettable' style="border-collapse:collapse;">
			<tr>
				<th  class='bordernone'  style='height:60px;'>Final QC</th>
			</tr>
			  <tr>													
					<td valign='bottom' align='center' class='bordernone'>
						<div>
						<div style="float:left;width:100%;">
							<div class="ticketquery-box">
								<span class="txt">Query</span><span class="bg-darkgray count tool_tip" onclick="showticketqueryreport('Validation','ticket_query','all','all')">17<span class="tooltiptext">Validation Query</span></span>
							</div>
							<div style="float:right;width:50%;"  class="ticketcompleted-box">
								<span class="txt">Completed</span><span class="bg-green count tool_tip" onclick="showticketreport('Validation','completed','all','all')">920<span class="tooltiptext">Validation Completed</span></span>
							</div>
						</div>
						<div class="cntcontainer">
							<div class="ticketcontainerbox ticket-bg">
								<div class="jobs_count">								
									<span class="waiting_cnt tool_tip" onclick="showjobsreport('Validation','pending','all','all')">838 <span class="tooltiptext ticketstooltip">Jobs Pending</span></span>								
									<span class="sep"></span>									
									<span class="process_cnt tool_tip" onclick="showjobsreport('Validation','progress','all','all')">3<span class="tooltiptext ticketstooltip">Jobs Progress</span></span>									
								</div>								
								<span class="main_cnt tool_tip " onclick="showticketreport('Validation','pending','all','all')">838<span class="tooltiptext ticketstooltip">Validation Pending</span></span>
							</div>
						</div>						
						<div class="info-container">
							<div class="boxcontaner">
							<div class="ticketinfobox"><img src="img/Users-icon.png"/></div>
							<div class="ticketinfobox bg-green tool_tip" onclick="show_workrequestreport('Validation','assigned','all','all')">3 <span class="tooltiptext">Assigned Validation Users</span></div>
							<div class="ticketinfobox bg-orange tool_tip" onclick="show_workrequestreport('Validation','waiting','all','all')">0 <span class="tooltiptext">Waiting Validation Users</span></div>
							<div class="ticketinfobox bg-red tool_tip" onclick="show_workrequestreport('Validation','break','all','all')">0<span class="tooltiptext">Validation Users In Break</span></div>
							</div>
						</div>
					</div>			
					</td>
				</tr>
			</table>
			</div>
	</div>

</div>
 
 </div>

  <!-- Footer -->
  @include('layouts.footer')
  @include('layouts.scriptfooter')
<script type="text/javascript">
	setInterval(function() {
		//window.location.reload(1);
		 var reporttype =  $('#listtype').val();
		 var publisher =  $('#publisher').val();
		 
		 $.ajax({
				type: 'GET',
				url: "{{route('home')}}",
				data: 'ajaxload=1&showreporttype='+reporttype+'&publisher='+publisher,			
				success: function(data){
					jQuery(".content").html(data);
				},
			  });
	}, 5000000);
	function showreport(type,status,showreporttype,publishername)
	{
		document.getElementById("imgloader").style.display = "block";		
		$.ajax({
		type: 'GET',
		url: "{{url('reports/jobs_popupreport')}}",            
		data: 'ajaxload=1&type='+type+'&status='+status+'&showreporttype='+showreporttype+'&publishername='+publishername,			
		success: function(data){               
			bootbox.alert(data)
		},
	  });
	}
	function shownonticketreport(type,showreporttype)
	{
		$.ajax({
		type: 'GET',
		url: "{{url('reports/jobs_ticketreport')}}",            
		data: 'ajaxload=1&type='+type+'&showreporttype='+showreporttype,			
		success: function(data){               
			bootbox.alert(data)
		},
	  });			
	}
	function showticketreport(type,status,showreporttype,publishername)
	{
		document.getElementById("imgloader").style.display = "block";
		$.ajax({
		type: 'GET',
		url: "{{url('reports/ticket_popupreport')}}",            
		data: 'ajaxload=1&type='+type+'&status='+status+'&showreporttype='+showreporttype+'&publishername='+publishername,			
		success: function(data){                
			bootbox.alert(data)
		},
	  });			
	}
	function showticketqueryreport(type,status,showreporttype,publishername)
	{
		$.ajax({
		type: 'GET',
		url: "{{url('reports/ticketquery_popupreport')}}",            
		data: 'ajaxload=1&type='+type+'&status='+status+'&showreporttype='+showreporttype+'&publishername='+publishername,			
		success: function(data){                
			bootbox.alert(data)
		},
	  });			
	}
	function show_workrequestreport(type,status,showtype,publishername)
	{
		$.ajax({
		type: 'GET',
		url: "{{url('reports/workrequest_popupreport')}}",            
		data: 'ajaxload=1&type='+type+'&status='+status+'&showtype='+showtype+'&publishername='+publishername,			
		success: function(data){                
			bootbox.alert(data)
		},
	  });			
	}
	function showjobsreport(type,status,showreporttype,publishername)
	{
		$.ajax({
		type: 'GET',
		url: "{{url('reports/jobstatus_popupreport')}}",
		data: 'ajaxload=1&type='+type+'&status='+status+'&showreporttype='+showreporttype+'&publishername='+publishername,
		success: function(data){
			bootbox.alert(data);				
		},
	  });			
	}	
	function page_analysis(starttime,pageurl){	 
		$.ajax({
			type: 'GET',
			url: "{{url('updatepageanalysis')}}",
			data: 'ajaxload=1&starttime='+starttime+'&pageurl='+pageurl,
			success: function(data){
				//bootbox.alert(data);				
			},
		  });
	}
	page_analysis('<?php echo $startime; ?>','<?php echo $pageurl; ?>');
</script>
@endsection