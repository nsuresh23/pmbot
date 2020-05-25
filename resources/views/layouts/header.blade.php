<?php use App\Models\User; ?>
<!-- Main Header -->
<style>
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
}
</style>
<header class="main-header">
<!-- Header Navbar -->
<nav class="navbar navbar-static-top">
<!-- Sidebar toggle button-->
<div class="container" id="headermenu">
  <div class="navbar-header" id="logohead">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
    <!-- logo -->
    <!-- <b>Admin</b>LTE -->
    <img src="{{url('img/RAZOR_slogo.png')}}" id="headlogo" class='logoimg' /> </a>
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"> <i class="fa fa-bars"></i> </button>
  </div>
  <!-- Navbar Right Menu -->
  <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
    <!-- navbar-custom-menu -->
    <ul class="nav navbar-nav" id="topmenulink">
      @if (Auth::guest())
      <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
      @else
      <!-- start after login -->
      <!-- Messages: style can be found in dropdown.less-->
      <?php 
              $items = $MyNavBar->topMenu()->roots();
            if(Auth::user()->roles['name']=='Admin')
            {
            ?>
      <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick='showhide("reports");'>Manage<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="dropdown-submenu"> <a class="test" tabindex="-1" href="#" onclick='showhide("wfh");' >WFH User<span class="caret"></span></a>
            <ul class="dropdown-menu"  id='wfh-submenu'>
              <li class="dropdown-submenu"> <a href="{{url('user/grouplist')}}">Group List</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('user/addgroup')}}">Add Group</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('user/alldatelist')}}">Overridden Ticket Volume</a> </li>
            </ul>
          </li>
          <li class="separator"></li>
          <li class="dropdown-submenu"> <a href="{{url('user/user_list')}}">User List</a> </li>
          <li class="separator"></li>
          <li class="dropdown-submenu"> <a href="{{url('user/add_user')}}">Add User</a> </li>
        </ul>
      </li>
      <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick='showhide("reports");'>Tracking<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="dropdown-submenu"> <a class="test" tabindex="-1" href="#" onclick='showhide("jobs");'>Jobs <span class="caret"></span></a>
            <ul class="dropdown-menu" id='job-submenu'>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/jobs-process')}}">Process</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/hold-jobs')}}">Hold</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/jobs-priority-update')}}">Priority Update</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/jobs-based-ticket-status-details')}}">Ticket Status Details</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/jobs-query-list')}}">Query List</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/consolidated-query-list')}}">Consolidated Queries</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/jobs-non-tickets')}}">With / Without Tickets</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/with-without-tickets')}}">Ticket Summary</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/stock_report')}}">Stock</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/detailed_report')}}">Detailed Report</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/resupply_report')}}">Re-supply Report</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/dispatch_update')}}">Dispatch Update</a> </li>
            </ul>
          </li>
          <li class="separator"></li>
          <li class="dropdown-submenu"> <a class="test" tabindex="-1" href="#" onclick='showhide("tickets");'>Tickets <span class="caret"></span></a>
            <ul class="dropdown-menu" id='ticket-submenu'>
              <li class="dropdown-submenu"> <a href="{{url('reports/ticket_report/ticket-process')}}">Process</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/ticket_report/ticket-user-based')}}">User Based</a> </li>
            </ul>
          </li>
          <li class="separator"></li>
          <li class="dropdown-submenu"> <a href="{{url('reports/jobs_report/aip_jobs')}}">AIP Jobs</a> </li>
        </ul>
      </li>
      <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick='showhide("reports");'>Reports<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="dropdown-submenu"> <a href="{{url('reports/overall_status')}}">Overall Status</a> </li>
          <li class="separator"></li>
          <li class="dropdown-submenu"> <a href="{{url('reports/download_status')}}">Download Status</a> </li>
          <li class="separator"></li>
          <li class="dropdown-submenu"> <a class="test" tabindex="-1" href="#" onclick='showhide("employee");'>Employee<span class="caret"></span></a>
            <ul class="dropdown-menu" id='employee-submenu'>
              <li class="dropdown-submenu"> <a href="{{url('reports/productivity_report')}}">Productivity Report </a> </li>
            </ul>
          </li>
          <li class="separator"></li>
          <li class="dropdown-submenu"> <a href="{{url('reports/delay_report')}}">Delay Report</a> </li>
          <li class="separator"></li>
          <li class="dropdown-submenu"> <a class="test" tabindex="-1" href="#" onclick='showhide("daily");'>Daily<span class="caret"></span></a>
            <ul class="dropdown-menu" id='daily-submenu'>
              <li class="dropdown-submenu"> <a href="{{url('reports/daily_invoice')}}">Invoice</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/daily_status')}}">Common Status</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/daily_car_orders')}}">Transmission CAR Orders</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/daily_dispatch')}}">Dispatch Report</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/daily_empty_signal')}}">Empty Signal Report</a> </li>
            </ul>
          </li>
          <li class="separator"></li>
          <li class="dropdown-submenu"> <a class="test" tabindex="-1" href="#" onclick='showhide("weekly");'>Weekly<span class="caret"></span></a>
            <ul class="dropdown-menu" id='weekly-submenu'>
              <li class="dropdown-submenu"> <a href="{{url('reports/pending_report')}}">Embase Conference Report</a> </li>
            </ul>
          </li>
          <li class="separator"></li>
          <li class="dropdown-submenu"> <a class="test" tabindex="-1" href="#" onclick='showhide("monthly");'>Monthly <span class="caret"></span></a>
            <ul class="dropdown-menu" id='monthly-submenu'>
              <li class="dropdown-submenu"> <a href="{{url('reports/monthly_unstructured_reference')}}">Unstructured Reference</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/pending_report')}}">Grant Candidate</a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/monthly_dispatch')}}">Dispatch Report </a> </li>
              <li class="separator"></li>
              <li class="dropdown-submenu"> <a href="{{url('reports/monthly_overview')}}">Overview </a> </li>
            </ul>
          </li>
        </ul>
      </li>
      <?php   } ?>
    </ul>
    @endif
    <!-- end after login -->
  </div>
  @if(Auth::check())
  <div class="navbar-custom-menu" >
    <!-- style='padding:0px;float:right;' -->
    <ul  class="nav navbar-nav" id="loginprofile">
      <li class="dropdown user user-menu">
        <!-- Menu Toggle Button -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!-- The user image in the navbar-->
        <!-- <img src="{{ url('/img/user2-160x160.jpg') }}" class="user-image" alt="User Image"/> -->
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs "><i class="fa fa-user fa-fw"></i></span><span class="caret"></span> </a>
        <ul style='left:-180% !important;min-width: 170px;' class="dropdown-menu">
          <li> <a href="{{ route('changepassword') }}"><i class="fa fa-key" aria-hidden="true"></i>Change password</a> </li>
          <li> <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class=""><i class="fa fa-sign-out fa-fw"></i>Sign out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
  @endif </div>
</nav>
</header>
