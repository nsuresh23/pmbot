@extends('layouts.app')
@section('content')

	<link rel="stylesheet" type="text/css" href="css/main.css">

	<div class="row detailpage">

		<div class="col-sm-12 container dashcontainer table-responsive">	
			
				<div class="col-md-12 jobinfo_tablebox nopadding">

					<div class="col-md-3 col-sm-6 col-xs-12 noleftpadding">
						<div class="count_container detailpage-greenbg">
							 <span class="detailpage_count_head ">Due</span>     						 
							 <div class='detailpage_count_val'><?php echo $detailpagecount['duedate']; ?></div>
						 </div>
					</div>					
					<div class="col-md-3 col-sm-6 col-xs-12 noleftpadding" >
						<div class="count_container detailpage-yellowbg">
							<span class="detailpage_count_head">Received</span>     
							<div class='detailpage_count_val'><?php echo $detailpagecount['received']; ?></div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 noleftpadding">
						<div class="count_container detailpage-bluebg">
							 <span class="detailpage_count_head">Dispatched</span>     
							<div class='detailpage_count_val'><?php echo $detailpagecount['dispatched']; ?></div>
						</div>						
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 noleftpadding norightpadding">
						<div class="count_container detailpage-darkbluebg">
							 <span class="detailpage_count_head">Balance</span>     
							<div class='detailpage_count_val'><?php echo $detailpagecount['balance']; ?></div>
						</div>						
					</div>
				</div> 
		</div>
		
		<div class="col-sm-12 nopadding marginbtm-25">	
			<div class="col-md-6 noleftpadding">			
				<?php echo $detailpagecount['jobs_bots_status']; ?>			
			</div>
			<div class="col-md-6 noleftpadding norightpadding" >						
				<?php echo $detailpagecount['hap_ticket_status']; ?>
			</div>
		</div>
		
		
		<div class="col-sm-12 nopadding marginbtm-25">	
			<div class="col-md-6 noleftpadding" >										
				<?php echo $detailpagecount['signal_package']; ?>
			</div>
			
			<div class="col-md-6 noleftpadding norightpadding">					
				<?php echo $detailpagecount['hap_user_status']; ?>
			</div>
		</div>
	</div>

  <!-- Footer -->
  @include('layouts.footer')
  @include('layouts.scriptfooter')
  <script src="js/main.js"></script>
<script type="text/javascript">
	function showticketstatus(type){
		
		if(type == 'withticket') {			
			document.getElementById("withticket").style.display = "block";
			document.getElementById("withoutticket").style.display = "none";
			$("#withticket_cnt").removeClass("hap-statusbg").addClass("signal-packagebg");
			$("#withoutticket_cnt").removeClass("signal-packagebg").addClass("hap-statusbg");
		} else {
			document.getElementById("withticket").style.display = "none";	
			document.getElementById("withoutticket").style.display = "block";
			$("#withoutticket_cnt").removeClass("hap-statusbg").addClass("signal-packagebg");
			$("#withticket_cnt").removeClass("signal-packagebg").addClass("hap-statusbg");			
		}
		
	}	
	
	
	var j_ds = document.getElementById('detailpage_bots').getElementsByTagName('td');
	var t_ds = document.getElementById('detailpage_haptickets').getElementsByTagName('td');
	var sp_ds = document.getElementById('detailpage_sp').getElementsByTagName('td');
	columntotalcount(j_ds,'column100 column2 total1','result1');
	columntotalcount(j_ds,'column100 column3 total2','result2');
	columntotalcount(j_ds,'column100 column4 total3','result3');
	columntotalcount(j_ds,'column100 column5 totalcount','result4');
	
	columntotalcount(t_ds,'column100 column2 ptotal','tresult1');
	columntotalcount(t_ds,'column100 column3 prtotal','tresult2');
	columntotalcount(t_ds,'column100 column4 ctotal','tresult3');
	columntotalcount(t_ds,'column100 column5 totalcount','tresult4');
	
	columntotalcount(sp_ds,'column100 column2 sptotal1','spresult1');
	columntotalcount(sp_ds,'column100 column3 sptotal2','spresult2');
	columntotalcount(sp_ds,'column100 column4 sptotal3','spresult3');
	columntotalcount(sp_ds,'column100 column5 totalcount','spresult4');
	
	function columntotalcount(id,classname,result){
		var sum = 0;
		for(var i = 0; i < id.length; i ++) {		
			if(id[i].className == classname) {					
				sum += isNaN(id[i].innerHTML) ? 0 : parseInt(id[i].innerHTML);
			}
		}	
		document.getElementById(result).innerHTML =  sum ;				
	}
	
	
        
</script>
@endsection