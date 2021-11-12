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

            $disabledField = "";

            $selectedStatus = $lead_pm_status = $spi_status = $daily_status_report = "checked";

            $selectedRole = $selectedGroup = $selectedLocation = $selectedMembers = null;

            $postUrl = route(__("user.user_store_url"));

            $title = __('user.user_add_label');

            $redirectTo = __("user.users_url");

            if(Route::currentRouteName() == __("user.user_edit_url")) {

                $disabledField = "disabled";

                $title = __('user.user_edit_label');

                $postUrl = route(__("user.user_update_url"));

            }

            if(isset($userData["data"]) && $userData["data"]) {

                if(isset($userData["data"]["role"]) && $userData["data"]["role"]) {

                    $selectedRole = $userData["data"]["role"];

                }

                if(isset($userData["data"]["members"]) && $userData["data"]["members"]) {

                    $selectedMembers = $userData["data"]["members"];

                }

                if(isset($userData["data"]["location"]) && $userData["data"]["location"]) {

                    $selectedLocation = $userData["data"]["location"];

                }

                // if(isset($userData["data"]["role_id"]) && $userData["data"]["role_id"]) {

                // $selectedRole = $userData["data"]["role_id"];

                // }

                // if(isset($userData["data"]["role_id"]) && $userData["data"]["role_id"]) {

                //     $selectedRole = $userData["data"]["role_id"];

                // }

                // if(isset($userData["data"]["group_id"]) && $userData["data"]["group_id"]) {

                //     $selectedGroup = $userData["data"]["group_id"];

                // }

                // if(isset($userData["data"]["location_id"]) && $userData["data"]["location_id"]) {

                //     $selectedLocation = $userData["data"]["location_id"];

                // }

                if(isset($userData["data"]["status"]) && $userData["data"]["status"] == "0") {

                    $selectedStatus = "";

                }

                if(isset($userData["data"]["lead_pm"]) && $userData["data"]["lead_pm"] == "0") {

                    $lead_pm_status = "";

                }

                if(isset($userData["data"]["spi_status"]) && $userData["data"]["spi_status"] == "0") {

                    $spi_status = "";

                }

                if(isset($userData["data"]["daily_status_report"]) && $userData["data"]["daily_status_report"] == "0") {

                    $daily_status_report = "";

                }

            }

        @endphp

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10"></i>{{ $title }}</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                <i class="zmdi zmdi-fullscreen job-status-i"></i>
                            </a>
                            <a id="job-status-close" class="pull-left inline-block" href="{{ route(__("user.users_url")) }}"
                                data-effect="fadeOut">
                                <i class="zmdi zmdi-close job-status-i"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-wrap">
                                    <form data-toggle="validator" role="form" action="{{ $postUrl }}" method="POST">
                                            <div class="form-body">
                                                <div class="row">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" id="empcode" name="empcode" value="{{$userData['data']['empcode'] ?? ''}}">
                                                    <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <label for="empname" class="control-label mb-10">{{ __('user.user_name_label') }}</label>
                                                                    <input type="text" class="form-control" id="empname" name="empname" value="{{$userData['data']['empname'] ?? ''}}"
                                                                        placeholder="{{ __('user.user_name_placeholder_text') }}" data-error="{{ __('user.user_name_error_msg') }}"
                                                                        required>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                                {{-- <div class="form-group">
                                                                    <label for="empcode" class="control-label mb-10">{{ __('user.user_empcode_label') }}</label>
                                                                    <input type="text" class="form-control" id="empcode" name="empcode"
                                                                        value="{{$userData['data']['empcode'] ?? ''}}"
                                                                        placeholder="{{ __('user.user_empcode_placeholder_text') }}"
                                                                        data-error="{{ __('user.user_empcode_error_msg') }}" {{ $disabledField }} required>
                                                                    <div class="help-block with-errors"></div>
                                                                </div> --}}
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <label for="empcode" class="control-label mb-10">{{ __('user.user_empcode_label') }}</label>
                                                                    <input type="text" class="form-control" id="empcode" name="empcode"
                                                                        value="{{$userData['data']['empcode'] ?? ''}}" placeholder="{{ __('user.user_empcode_placeholder_text') }}"
                                                                        data-error="{{ __('user.user_empcode_error_msg') }}" {{ $disabledField }} required>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pl-0">
                                                                    <div class="form-group">
                                                                        <label for="email" class="control-label mb-10">{{ __('user.user_email_label') }}</label>
                                                                        <input type="email" class="form-control" id="email" name="email" value="{{$userData['data']['email'] ?? ''}}"
                                                                            placeholder="{{ __('user.user_email_placeholder_text') }}"
                                                                            data-error="{{ __('user.user_email_error_msg') }}" {{ $disabledField }} required>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pa-0">
                                                                    <div class="form-group">
                                                                        <label for="role" class="control-label mb-10">{{ __('user.user_role_label') }}</label>
                                                                        {!! Form::select('role', $userData["role_list"], $selectedRole, ['class' => 'form-control select2 user_role_select',
                                                                        'data-error' => "{{ __('user.user_role_error_msg') }}", 'required']) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <label for="members" class="control-label mb-10">{{ __('user.user_members_label') }}</label>
                                                                    {!! Form::select('members[]',
                                                                    $userData["user_list"],
                                                                    $selectedMembers,
                                                                    ['class' =>
                                                                    'form-control select2 select2-multiple checklist-task-list',
                                                                    'multiple' => 'multiple',
                                                                    'data-placeholder' =>
                                                                    __('user.user_members_placeholder_text'),
                                                                    'data-error' => __('user.user_members_error_msg'),]) !!}
                                                                    <div class="help-block with-errors"></div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    @php

                                                        // if(!isset($userData["data"])) {

                                                    @endphp

                                                            {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="password" class="control-label mb-10">{{ __('user.user_password_label') }}</label>
                                                                            <input type="password" data-minlength="6" class="form-control" id="password" name="password"
                                                                                placeholder="{{ __('user.user_password_placeholder_text') }}"
                                                                                data-error="{{ __('user.user_password_error_msg') }}" required>
                                                                            <h6 class="nonecase-font txt-grey">{{ __('user.user_password_help_text') }}</h6>
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="passwordConfirm" class="control-label mb-10">{{ __('user.user_confirm_password_label') }}</label>
                                                                            <input type="password" class="form-control" id="passwordConfirm" data-match="#password" data-error=""
                                                                                data-match-error="{{ __('user.user_confirm_password_error_msg') }}"
                                                                                placeholder="{{ __('user.user_password_placeholder_text') }}" required>
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                    @php

                                                        // }

                                                    @endphp

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <label for="cisco" class="control-label mb-10">{{ __('user.user_cisco_label') }}</label>
                                                                    <input type="text" class="form-control" id="cisco" name="cisco"
                                                                        value="{{$userData['data']['cisco'] ?? ''}}" placeholder="{{ __('user.user_cisco_placeholder_text') }}"
                                                                        data-error="{{ __('user.user_cisco_error_msg') }}" required>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <label for="mobile" class="control-label mb-10">{{ __('user.user_mobile_label') }}</label>
                                                                    <input type="text" class="form-control" id="empmobile" name="mobile"
                                                                        value="{{$userData['data']['mobile'] ?? ''}}" placeholder="{{ __('user.user_mobile_placeholder_text') }}"
                                                                        data-error="{{ __('user.user_mobile_error_msg') }}" required>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <label for="location" class="control-label mb-10">{{ __('user.user_location_label') }}</label>
                                                                    {!! Form::select('location', $userData["location_list"], $selectedLocation, ['class' => 'form-control select2', 'data-error' => "{{ __('user.user_location_error_msg') }}", 'required']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <label for="status" class="control-label mb-10">{{ __('user.user_status_label') }}</label>
                                                                    <div class="form-group js-switch-mt-0">
                                                                        {{-- <input type="checkbox" id="terms" class="" data-error="Before you check yourself" required> --}}
                                                                        {{-- <div class="clearfix"></div> --}}

                                                                        <input type="checkbox" id="status" name="status" class="js-switch js-switch-1"  data-color="#8BC34A" data-secondary-color="#F8B32D" {{ $selectedStatus }}>

                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 lead-pm-block">
                                                                    <label for="lead-pm" class="control-label mb-10">{{ __('user.user_lead_pm_label') }}</label>
                                                                    <div class="form-group js-switch-mt-0">
                                                                        {{-- <input type="checkbox" id="terms" class="" data-error="Before you check yourself" required> --}}
                                                                        {{-- <div class="clearfix"></div> --}}

                                                                        <input type="checkbox" id="lead-pm" name="lead_pm" class="js-switch js-switch-1"  data-color="#8BC34A" data-secondary-color="#F8B32D" {{ $lead_pm_status }}>

                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <label for="spi_status" class="control-label mb-10">{{ __('user.user_spi_status_label') }}</label>
                                                                    <div class="form-group js-switch-mt-0">
                                                                        <input type="checkbox" id="spi_status" name="spi_status" class="js-switch js-switch-1" data-color="#8BC34A"
                                                                            data-secondary-color="#F8B32D" {{ $spi_status }}>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <label for="daily_status_report" class="control-label mb-10">{{ __('user.user_daily_status_report_label') }}</label>
                                                                    <div class="form-group js-switch-mt-0">
                                                                        <input type="checkbox" id="daily_status_report" name="daily_status_report" class="js-switch js-switch-1" data-color="#8BC34A"
                                                                            data-secondary-color="#F8B32D" {{ $daily_status_report }}>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-md-offset-10 mt-10">

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
