<div class="row">

<div class="col-sm-12 container dashcontainer table-responsive">	

 <div class='jobtable_container' >
 	<div class="col-md-12 jobinfo_tablebox" style="padding:0px;">

        <div class="col-md-2 col-sm-6 col-xs-12 jobsbox leftbordernone">
          <span class="tkthead">Input Check</span>     
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
              <span class="green">@if ($healthcheck->inputcheck == 'wip')<i class="fa fa-check" ></i>@endif</span>
              <span class="yellow">@if ($healthcheck->inputcheck == 'waiting')<i class="fa fa-check" ></i>@endif</span>
              <span class="red">@if ($healthcheck->inputcheck == 'hold')<i class="fa fa-check" ></i>@endif</span>
            </div>
          </div>          
          <?php echo $dashboardcount['jobs_inputcheck']; ?>
        </div>
        <!-- /.col -->
        <!-- <div class="clearfix visible-sm-block"></div> -->
		
        <div class="col-md-2 col-sm-6 col-xs-12 jobsbox" id="bpabox">
           <span class="tkthead">BPA</span> 
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
              <span class="green">@if ($healthcheck->bpa == 'wip')<i class="fa fa-check" ></i>@endif</span>
              <span class="yellow">@if ($healthcheck->bpa == 'waiting')<i class="fa fa-check" ></i>@endif</span>
              <span class="red">@if ($healthcheck->bpa == 'hold')<i class="fa fa-check" ></i>@endif</span>
            </div>
          </div>
          <!-- <div class="rowborder"></div> -->
          <?php echo $dashboardcount['jobs_xmlconversion']; ?>
        </div>
        <!-- /.col -->
		
		<!-- <div class="clearfix visible-sm-block"></div> -->
		
        <div class="col-md-2 col-sm-6 col-xs-12 jobsbox" id="bpabox">
           <span class="tkthead">Item Type</span> 
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
              <span class="green">@if ($healthcheck->item_type == 'wip')<i class="fa fa-check" ></i>@endif</span>
              <span class="yellow">@if ($healthcheck->item_type == 'waiting')<i class="fa fa-check" ></i>@endif</span>
              <span class="red">@if ($healthcheck->item_type == 'hold')<i class="fa fa-check" ></i>@endif</span>
            </div>
          </div>
          <!-- <div class="rowborder"></div> -->
          <?php echo $dashboardcount['jobs_itemtype']; ?>
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
       <!--  <div class="clearfix visible-sm-block"></div> -->

	<div class="col-md-2 col-sm-6 col-xs-12 jobsbox" id="bpabox">
           <span class="tkthead">HAP</span> 
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
              <span class="white">&nbsp;</span>
              <span class="white">@if ($healthcheck->item_type == 'waiting')<i class="fa fa-check" ></i>@endif</span>
              <span class="white">@if ($healthcheck->item_type == 'hold')<i class="fa fa-check" ></i>@endif</span>
            </div>
          </div>
          <!-- <div class="rowborder"></div> -->
          <?php echo $dashboardcount['jobs_hap']; ?>
        </div>
		
        <!-- /.col -->
        <div class="col-md-2 col-sm-6 col-xs-12 jobsbox tktbox">
          <span class="tkthead">Validation</span> 
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
              <span class="green">@if ($healthcheck->hap == 'wip')<i class="fa fa-check" ></i>@endif</span>
              <span class="yellow">@if ($healthcheck->hap == 'waiting')<i class="fa fa-check" ></i>@endif</span>
              <span class="red">@if ($healthcheck->hap == 'hold')<i class="fa fa-check" ></i>@endif</span>
            </div>
          </div>
          <!-- <div class="rowborder"></div> -->
          <?php echo $dashboardcount['jobs_finalval']; ?>
        </div>
        <!-- /.col -->
		      <div class="col-md-2 col-sm-6 col-xs-12 jobsbox tktbox">
          <span class="tkthead">Signal & Package</span> 
          <div class='healthcheck_signal rowborder'>
            <div class='innerbox'>
				&nbsp              
            </div>
          </div>
          <!-- <div class="rowborder"></div> -->
          <?php echo $dashboardcount['jobs_packaging']; ?>
        </div>
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
					<?php echo $dashboardcount['ticket_item_type']; ?>
				</td>
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
						<td align='center' valign='top'><?php echo $dashboardcount['ticket_reference']; ?></td>
						<td valign='top' align='center'><?php echo $dashboardcount['ticket_grant']; ?></td>							
						<td valign='top' align='center'><?php echo $dashboardcount['ticket_affiliation']; ?></td>
						<td valign='top' align='center' class='bordernone'><?php echo $dashboardcount['ticket_math_expression']; ?></td>
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
					<td  valign='bottom' align='center' class='bordernone'>
						<?php echo $dashboardcount['ticket_validation']; ?>			
					</td>
				</tr>
			</table>
			</div>
	</div>

</div>
 
 </div>