@extends('layout.admin')
@section('content')
<body class="hold-transition login-page">

  <div class="lockscreen-wrapper">
  <!-- START LOCK SCREEN ITEM -->
  <div>
    <!-- lockscreen image -->
    <div class="error-page">
      <h2 class="headline text-yellow"> 404</h2>
    </div>
    <!-- /.lockscreen-image -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
  </div>
  <div class="text-center">
    <a href="#">We could not find the page you were looking for.</a>
  </div>
  <div class="lockscreen-footer text-center">
    Copyright © 2016-2017 <b><a href="#" class="text-black">iCaballeria</a></b><br>
    All rights reserved
  </div>
</div>

  @include('includes.script')
</body>
@stop
