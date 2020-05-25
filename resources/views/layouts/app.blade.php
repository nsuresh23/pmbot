<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!--<meta http-equiv="refresh" content="10">-->
    <title>RAZOR - {{ $page_title or "Dashboard" }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{url('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="{{url('css/ionicons.min.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap-datepicker.min.css')}}"/>
    
    <link href="{{url('plugins/select2.min.css')}}" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{url('css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
	
	<link rel="shortcut icon" href="{{url('img/favicon.ico')}}img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="{{url('img/favicon.ico')}}" type="image/x-icon">
     

    
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{url('css/skins/skin-blue.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('css/skins/_all-skins.min.css')}}">
    <link href="{{url('plugins/jquery.dataTables.min.css')}}" rel="stylesheet">
	<link href="{{url('css/fixedColumns.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{url('css/custom.css')}}" rel="stylesheet">
	<link href="{{url('css/colorcode.css')}}" rel="stylesheet">
	
	<link type="text/css" href="{{url('css/datatables.min.css')}}" rel="stylesheet" />
	<script src="{{url('js/datatables.min.js')}}"></script>
	<link type="text/css" href="{{url('css/dataTables.checkboxes.css')}}" rel="stylesheet" />
	<script src="{{url('js/dataTables.checkboxes.min.js')}}"></script>
	<script src="{{url('js/dataTables.buttons.min.js')}}"></script>

	

    <style type="text/css">
     .has-feedback label ~ .form-control-feedback {
        top:0px;
     }
        <?php $routename = Route::currentRouteName(); 		
              if($routename=='jobslisting' || $routename == 'usersreports')
              { ?>
                #jobsreport td:first-child(1) {
                  border-left:1px solid black;
                }
                #jobsreport td:nth-child(2) {
                  border-left:1px solid black;                  
                }
                #jobsreport tr:last-child td:nth-child(n+1):nth-child(-n+2){
                   border-bottom:1px solid black;
                }
                #jobsreport td:nth-child(1) {
                  border-left:1px solid black;
                }
                #jobsreport td:nth-child(3) {
                  border-left:1px solid black;
                }
                #jobsreport td:nth-child(7) {
                 
                }
                #jobsreport tr:last-child td:nth-child(n+3):nth-child(-n+8){
                   border-bottom:1px solid black;
                }
                #jobsreport th:nth-child(8) {
                  border-right:1px solid black;
                   background-color: #FFE5CC;
                }
                #jobsreport th:nth-child(8),td:nth-child(n+8):nth-child(-n+13) {                  
                  text-align: center;
                }
                .jobrefcolor{
                  background-color: #FFE5CC;
                }

                /*for grant*/
                #jobsreport td:nth-child(9) {
                  /*border-left:1px solid black;*/
                }
                #jobsreport td:nth-child(13) {
                 
                }
                #jobsreport tr:last-child td:nth-child(n+9):nth-child(-n+14){
                   border-bottom:1px solid black;
                }
                #jobsreport th:nth-child(14) {
                  border-right:1px solid black;
                   background-color: #CCFFE5;
                }
                #jobsreport th:nth-child(14),td:nth-child(n+14):nth-child(-n+19) {                  
                  text-align: center;
                }
                .jobgrtcolor{
                  background-color: #CCFFE5;
                }
                /*for item type*/
                #jobsreport td:nth-child(15) {
                 /* border-left:1px solid black;*/
                }
                #jobsreport td:nth-child(19) {
                 
                }
                #jobsreport tr:last-child td:nth-child(n+15):nth-child(-n+20){
                   border-bottom:1px solid black;
                }
                #jobsreport th:nth-child(19) {
                  border-right:1px solid black;
                  
                }
                #jobsreport th:nth-child(20),td:nth-child(n+20):nth-child(-n+25) {
                
				  
                  text-align: center;
                }
				#jobsreport th:nth-child(24) {
                  border-right:1px solid black;
                 
                }
                #jobsreport th:nth-child(25),td:nth-child(n+26):nth-child(-n+31) {
                 
				
                  text-align: center;
                }
				
				#jobsreport th:nth-child(29) {
                  border-right:1px solid black;
                  
                }
                #jobsreport th:nth-child(32),td:nth-child(n+32):nth-child(-n+37) {                 
                  text-align: center;				 
                }							
				#jobsreport th:nth-child(37) {
                  border-right:1px solid black;                 
                }
                #jobsreport th:nth-child(38),td:nth-child(n+38):nth-child(-n+43) {                  
                  text-align: center;				 
                }				
                .jobitmcolor{
                  background-color: #FFCCE5;
                }
				.jobaffcolor{
                  background-color: #b6cfef;
                }
				.jobmxcolor{
                  background-color: #b0e2b7;
                }
				.jobvalcolor{
                  background-color: #e4bfc2;
                }
        <?php
              } ?>
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
          
  </head>
  <body class="skin-blue">
  <div id='imgloader' class='loaderimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
    <div class="wrapper">
      <!-- Header -->
      @include('layouts.header')
   
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="margin-left:0px;">
        <!-- Content Header (Page header) -->
        <section class="content-header" ><?php $breadcrumbs = Breadcrumbs::generate(); //echo '<pre>'; print_r($breadcrumbs[0]->title); echo'</pre>'; //exit; ?>
		   <?php $routename = Route::currentRouteName(); ?>
         <!-- {!! Breadcrumbs::render() !!} -->
		
		
			 @if (count($breadcrumbs))
				<ul class="topbreadcrumb rightdisp">
					@foreach ($breadcrumbs as $breadcrumb)
						@if ($breadcrumb->url && !$loop->last)
								@if ($breadcrumb->title != 'Production Report' && $breadcrumb->title != 'Jobs' && $breadcrumb->title != 'Ticket' && $breadcrumb->title != 'Monthly' && $breadcrumb->title != 'Daily')
									<li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
								@else
									<li class="breadcrumb-item">{{ $breadcrumb->title }}</li>
								@endif

						@else
							<li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
						@endif
					@endforeach 
				</ul>
			  @endif
		  
		   
		   <div class='dashboardsearchbox'>
		   
		   
		   @if ($routename =='home' || $routename =='dashboard')	
					<form class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
					{{ csrf_field() }}
					
						<div class='pub_lable'>						
							 Project : &nbsp;
						</div>
						
						<div class='pro_list'>									
							 <select class="form-control" id="project" name="project" onchange='changeproject(this.value);'>
								<option value="all" <?php if($project == 'all'){ ?> selected <?php } ?>>All</option>
								<option value="aip" <?php if($project == 'aip'){ ?> selected <?php } ?>>AIP</option>
								<option value="eflow" <?php if($project == 'eflow'){ ?> selected <?php } ?>>EFLOW</option>
							 </select>							 
						</div>
					
					
						<div class='pub_lable'>						
							 Publisher : &nbsp;
						</div>
						
						<div class='pub_list'>									
							 <select class="form-control" id="publisher" name="publisher" onchange='changepublisher(this.value);'>
								<option value="all" <?php if($publisher == 'all'){ ?> selected <?php } ?>>All</option>
								@foreach($publisherlist as $publishers)
									@if ($publishers->publisher != '')									
										<option value='{{$publishers->publisher}}' <?php if($publisher == $publishers->publisher){ ?> selected <?php } ?>> 
										{{$publishers->publisher != 'Taylor' ? $publishers->publisher : "Taylor & Francis" }}
										</option>								
									@endif
																	
								 @endforeach							
							 </select>							 
						</div>
						 

						 
							<div class='searchbox btn_box'>		
								@if ($showreporttype == 'all')
								<input class="btn btn-primary data_btn" type="button" name="report_type" onclick='reporttype("today");' value="Show Today's Data">								
								@else
									<input class="btn btn-primary data_btn" type="button" name="report_type" onclick='reporttype("all");'  value="Show All Data">
									
								@endif 
							</div>
							
							<!--
							<div class='searchbox btn_box'>										
								
								@if ($showpagetype == 'summary')
									<input class="btn btn-primary page_btn" type="button" name="pagetype" onclick='page_type("detail");'  value="Detail">								
								@else
									<input class="btn btn-primary page_btn" type="button" name="pagetype" onclick='page_type("summary");'  value="Summary">
									
								@endif 
							</div>
							
							<div class='searchbox btn_box'>																		
								@if ($showtrends == 'home')
									<input class="btn btn-primary page_btn" type="button" name="trendspagetype" onclick='show_trends("trends");'  value="Trends">
								@else
									<input class="btn btn-primary page_btn" type="button" name="trendspagetype" onclick='show_trends("home");'  value="Home">									
								@endif 
							</div>
							-->
							<input type='hidden' name='showreporttype' id='showreporttype' value='' />
							<input type='hidden' name='showprojecttype' id='showprojecttype' value='' />
							<input type='hidden' name='showpagetype' id='showpagetype' value='{{$showpagetype}}' />
							<input type='hidden' name='trends' id='trends' value='{{$showtrends}}' />
							<input type='hidden' name='listtype' id='listtype' value='{{$showreporttype}}' />							
						</form>
					@endif
		   
		   </div>
		   
		   
          <!-- You can dynamically generate breadcrumbs here -->
         <!--  <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
          </ol> -->
        </section>

        <!-- Main content -->
        <section class="content">          
          <!-- Your Page Content Here -->
            @yield('content')
        <!-- section closing tags are in footer-->

     
    <!-- Optionally, you can add Slimscroll and FastClick plugins. 
          Both of these plugins are recommended to enhance the 
          user experience -->
   <script type="text/javascript">
    function allConfirmDelete()
    {
      if(confirm("Are you sure want to delete?"))
        return true;
      else
        return false;
    }


	$(document).ready(function(){		
	  $('.dropdown-submenu a.test').on("click", function(e){		  
		$(this).next('ul').toggle();
		e.stopPropagation();
		e.preventDefault();
	  });
	});
	
	/*$( ".dropdown-submenu" ).click(function(event) {		
		event.stopPropagation();		
		$( this ).find(".dropdown-submenu").removeClass('open');		
		$( this ).parents(".dropdown-submenu").addClass('open');		
		$( this ).toggleClass('open');
	});*/
	
	function showhide(val) {
		
		var wfhmenu     = document.getElementById('wfh-submenu').style.display;		
		var jobsmenu    = document.getElementById('job-submenu').style.display;
		var ticketsmenu = document.getElementById('ticket-submenu').style.display;
		
		if(val == 'wfh') {			
		}else if(val == 'inhouse') {
			document.getElementById('wfh-submenu').style.display = 'none';
		}else if(val == 'jobs') {
			document.getElementById('ticket-submenu').style.display = 'none';
		} else if(val == 'tickets') {
			document.getElementById('job-submenu').style.display = 'none';
		}else if(val == 'employee') {
			document.getElementById('daily-submenu').style.display = 'none';
			document.getElementById('weekly-submenu').style.display = 'none';
			document.getElementById('monthly-submenu').style.display = 'none';
		}else if(val == 'daily') {
			document.getElementById('employee-submenu').style.display = 'none';
			document.getElementById('weekly-submenu').style.display = 'none';
			document.getElementById('monthly-submenu').style.display = 'none';
		}else if(val == 'weekly') {
			document.getElementById('daily-submenu').style.display = 'none';
			document.getElementById('employee-submenu').style.display = 'none';
			document.getElementById('monthly-submenu').style.display = 'none';
		}else if(val == 'monthly') {
			document.getElementById('daily-submenu').style.display = 'none';
			document.getElementById('weekly-submenu').style.display = 'none';
			document.getElementById('employee-submenu').style.display = 'none';
		} else if(val == 'reports') {	
			document.getElementById('wfh-submenu').style.display = 'none';
		
			document.getElementById('job-submenu').style.display = 'none';
			document.getElementById('ticket-submenu').style.display = 'none';

			document.getElementById('employee-submenu').style.display = 'none';
			document.getElementById('daily-submenu').style.display = 'none';
			document.getElementById('weekly-submenu').style.display = 'none';
			document.getElementById('monthly-submenu').style.display = 'none';
		}		
	}
	function showhidesubmenu(val) {
		if(val == 'ic') {			
			document.getElementById('bpa-submenu').style.display = 'none';
			document.getElementById('hap-submenu').style.display = 'none';
			document.getElementById('fv-submenu').style.display = 'none';			
		} else if(val == 'bpa') {
			document.getElementById('ic-submenu').style.display = 'none';
			document.getElementById('hap-submenu').style.display = 'none';
			document.getElementById('fv-submenu').style.display = 'none';	
		} else if(val == 'hap') {
			document.getElementById('bpa-submenu').style.display = 'none';
			document.getElementById('ic-submenu').style.display = 'none';
			document.getElementById('fv-submenu').style.display = 'none';	
		} else if(val == 'fv') {
			document.getElementById('bpa-submenu').style.display = 'none';
			document.getElementById('hap-submenu').style.display = 'none';
			document.getElementById('ic-submenu').style.display = 'none';	
		} else if(val == 'ref') {				
			document.getElementById('aff-submenu').style.display = 'none';
			document.getElementById('it-submenu').style.display = 'none';
			document.getElementById('grant-submenu').style.display = 'none';
			document.getElementById('me-submenu').style.display = 'none';
			document.getElementById('val-submenu').style.display = 'none';
		} else if(val == 'aff') {				
			document.getElementById('ref-submenu').style.display = 'none';
			document.getElementById('it-submenu').style.display = 'none';
			document.getElementById('grant-submenu').style.display = 'none';
			document.getElementById('me-submenu').style.display = 'none';
			document.getElementById('val-submenu').style.display = 'none';
		} else if(val == 'it') {				
			document.getElementById('ref-submenu').style.display = 'none';
			document.getElementById('aff-submenu').style.display = 'none';
			document.getElementById('grant-submenu').style.display = 'none';
			document.getElementById('me-submenu').style.display = 'none';
			document.getElementById('val-submenu').style.display = 'none';
		} else if(val == 'grant') {				
			document.getElementById('ref-submenu').style.display = 'none';
			document.getElementById('aff-submenu').style.display = 'none';
			document.getElementById('it-submenu').style.display = 'none';
			document.getElementById('me-submenu').style.display = 'none';
			document.getElementById('val-submenu').style.display = 'none';
		} else if(val == 'me') {				
			document.getElementById('ref-submenu').style.display = 'none';
			document.getElementById('aff-submenu').style.display = 'none';
			document.getElementById('it-submenu').style.display = 'none';
			document.getElementById('grant-submenu').style.display = 'none';
			document.getElementById('val-submenu').style.display = 'none';
		} else if(val == 'va') {				
			document.getElementById('ref-submenu').style.display = 'none';
			document.getElementById('aff-submenu').style.display = 'none';
			document.getElementById('it-submenu').style.display = 'none';
			document.getElementById('grant-submenu').style.display = 'none';
			document.getElementById('me-submenu').style.display = 'none';
		}

	}
	$( function() {    
		$('#jobdate').datepicker({format: 'yyyy-mm-dd',autoclose:true});
		$('#ticketdate').datepicker({format: 'yyyy-mm-dd',autoclose:true});
		$('#fromdate').datepicker({format: 'yyyy-mm-dd',autoclose:true});
		$('#todate').datepicker({format: 'yyyy-mm-dd',autoclose:true});
		$('#doj').datepicker({format: 'yyyy-mm-dd',autoclose:true});
	
  } );
  function changeproject(val){	 
	document.getElementById('showprojecttype').value = val; 
	document.getElementById('showreporttype').value = document.getElementById('listtype').value; 
	document.getElementById("searchform").submit();	 
  }
  function changepublisher(val){	 
	document.getElementById('showreporttype').value = document.getElementById('listtype').value; 
	document.getElementById("searchform").submit();	 
  }
  function reporttype(val){	 
	document.getElementById('showreporttype').value = val;  
	document.getElementById("searchform").submit();
  }
  function page_type(val){	 
	document.getElementById('showpagetype').value = val; 
	document.getElementById('trends').value = '';  	
	document.getElementById("searchform").submit();
  }
  function show_trends(val){	 
	document.getElementById('trends').value = val;  
	document.getElementById('showpagetype').value = ''; 
	document.getElementById("searchform").submit();
  }
</script>
  </body>
</html>