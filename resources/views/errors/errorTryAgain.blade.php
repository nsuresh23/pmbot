@extends('layouts.error')
@section('content')
<!-- Main Content -->
<div class="page-wrapper pa-0 ma-0 error-bg-img">
  <div class="container-fluid">
    <!-- Row -->
    <div class="table-struct full-width full-height">
      <div class="table-cell vertical-align-middle auth-form-wrap">
        <div class="auth-form  ml-auto mr-auto no-float">
          <div class="row">
            <div class="col-sm-12 col-xs-12">
              <div class="mb-30">
                <span class="block error-head text-center txt-primary mb-10">Oops!</span>
                <span class="text-center nonecase-font mb-20 block error-comment"><i
                    class="fa fa-warning text-yellow"></i>Please try again!</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Row -->
  </div>

</div>
<!-- /Main Content -->
@endsection
