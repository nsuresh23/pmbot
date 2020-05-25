@extends('layouts.app')
@section('content')
<!-- <div class="box"> -->
  
  <!-- /.lockscreen-item -->
  <div class="help-block text-center alert alert-warning">
    <h3><strong>401</strong> <i class="fa fa-warning text-yellow"></i> Oops! Unauthorized.</h3>
    <div class="text-center">
      <a href="#">Invalid access.</a>
    </div>
  </div>
  
<!-- </div> -->
<!-- Footer -->
      @include('layouts.footer')
@endsection
