@extends('layouts.app')

@section('content')


  <!-- Info boxes -->
      <div class="row">
	  
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-newspaper-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Jobs</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-support"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tickets</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><i class="fa fa-user fa-fw bg-black-active"></i>Total Users</span>
                <span class="info-box-text info-box-number"></span> 
                  <span class="info-box-text"><i class="fa fa-user fa-fw bg-green-active"></i> Online Users</span>
                <span class="info-box-text"><i class="fa fa-user fa-fw bg-red-active"></i> Waiting Users</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
      </div>
      <!-- /.row -->






    


  <!-- Footer -->
  @include('layouts.footer')
  @include('layouts.scriptfooter')
@endsection
