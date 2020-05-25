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

            $redirectTo = __("user.user_list_url");

            $title = __('user.user_password_update_label');

            if(isset($userData["data"]) && $userData["data"]) {

                if(isset($userData["data"]["id"]) && $userData["data"]["id"]) {

                    $postUrl = route(__("user.user_password_update_url"), $userData["data"]["id"]);

                }
            }

        @endphp

        <!-- Row -->
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 col-md-offset-2">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10"></i>{{ $title }}</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                <i class="zmdi zmdi-fullscreen job-status-i"></i>
                            </a>
                            <a id="job-status-close" class="pull-left inline-block" href="{{ route(__("user.user_list_url")) }}"
                                data-effect="fadeOut">
                                <i class="zmdi zmdi-close job-status-i"></i>
                            </a>
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
                                                                        <label for="password" class="control-label mb-10">{{ __('user.user_password_label') }}</label>
                                                                        <input type="password" data-minlength="6" class="form-control" id="password" name="password"
                                                                            placeholder="{{ __('user.user_password_placeholder_text') }}"
                                                                            data-error="{{ __('user.user_password_error_msg') }}" required>
                                                                        <h6 class="nonecase-font txt-grey">{{ __('user.user_password_help_text') }}</h6>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label for="passwordConfirm" class="control-label mb-10">{{ __('user.user_confirm_password_label') }}</label>
                                                                        <input type="password" class="form-control" id="passwordConfirm" data-match="#password" data-error=""
                                                                            data-match-error="{{ __('user.user_confirm_password_error_msg') }}"
                                                                            placeholder="{{ __('user.user_password_placeholder_text') }}" required>
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
                                                    <a href="{{ route($redirectTo) }}" class="btn btn-danger btn-anim"><i class="fa fa-times font-20"></i><span
                                                            class="btn-text font-20">{{ __('user.user_cancel_button_label') }}</span></a>

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
