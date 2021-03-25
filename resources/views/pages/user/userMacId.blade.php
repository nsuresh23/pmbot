@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Main Content -->
<div class="container-fluid pt-25">

    <div id="userForm">

        @php

            $postUrl = "#";

            $redirectTo = "home";

            $title = __('user.user_mac_id_update_label');

            if(isset($userData["data"]) && $userData["data"]) {

                if(isset($userData["data"]["id"]) && $userData["data"]["id"]) {

                    $postUrl = route(__("user.user_mac_id_update_url"), $userData["data"]["id"]);

                }
            }

        @endphp

        <!-- Row -->
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 col-md-offset-2">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark capitalize-font"><i class="fa fa-envelope mr-10"></i>{{ $title }}</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                <i class="zmdi zmdi-fullscreen job-status-i"></i>
                            </a>
                            {{-- <a id="job-status-close" class="pull-left inline-block" href="{{ route(__("user.users_url")) }}"
                                data-effect="fadeOut">
                                <i class="zmdi zmdi-close job-status-i"></i>
                            </a> --}}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-wrap">
                                    <form data-toggle="validator" role="form" action="{{ $postUrl }}" method="POST">
                                            <div class="form-body">
                                                <div class="row">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" id="empcode" name="empcode" value="{{$userData['data']['id'] ?? ''}}">
                                                    <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label for="mac-id" class="control-label mb-10">{{ __('user.user_mac_id_label') }}</label>
                                                                        <input type="text" data-minlength="6" class="form-control" id="mac-id" name="mac_address"
                                                                            placeholder="{{ __('user.user_mac_id_placeholder_text') }}"
                                                                            data-error="{{ __('user.user_mac_id_error_msg') }}" required>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-md-offset-5 pull-right mr-25 mt-10">

                                                    <button type="submit" class="btn btn-success btn-anim mr-10"> <i class="fa fa-check font-20"></i><span
                                                            class="btn-text font-20">{{ __('user.user_submit_button_label') }}</span></button>

                                                    <?php

                                                        $referer = "";

                                                        $redirectToUrl = "#";

                                                        if(isset($_SERVER) && isset($_SERVER['HTTP_REFERER'])) {

                                                            $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

                                                        }

                                                    	if (!empty($referer)) {

                                                    		$redirectToUrl = $referer;

                                                    	} else {

                                                    		$redirectToUrl = "javascript:history.go(-1)";

                                                    	}
                                                    ?>

                                                    <a href="{{ $redirectToUrl }}" class="btn btn-danger btn-anim">
                                                        <i class="fa fa-times font-20"></i>
                                                        <span class="btn-text font-20">{{ __('user.user_cancel_button_label') }}</span>
                                                    </a>

                                                </div>

                                            </div>

                                        </form>
                                    </div>
                                </div>
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
