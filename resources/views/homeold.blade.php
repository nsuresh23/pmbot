@extends('layouts.app')

@section('content')
    <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>Articles</p>
            </div>
            <div class="icon">
              <i class="fa fa-newspaper-o"></i><!-- fa fa-file-text-o -->
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Tickets</p>
            </div>
            <div class="icon">
              <i class="fa fa-support"></i> <!-- fa fa-ticket -->
            </div>
            <a href="#" class="small-box-footer">More info asdasd <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      @if(count($user_details)>0)
          <?php $total_usercnt = array_sum(array_column($user_details, 'usercnt')); ?>
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="icon">
              <i class="fa fa-users"></i><!-- ion ion-person-add -->
            </div>
            <div class="inner">
              <h3><?php echo $total_usercnt; ?></h3>

              <p>Users</p>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      @endif
        <!-- ./col -->
        <!-- <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> -->
        <!-- ./col -->
      </div>
      <!-- /.row -->


  <!-- Footer -->
  @include('layouts.footer')
  @include('layouts.scriptfooter')
@endsection
