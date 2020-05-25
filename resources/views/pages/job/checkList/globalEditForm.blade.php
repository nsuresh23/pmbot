@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')

<!-- Main Content -->
<div class="container-fluid pt-25">

    <?php

        $job_id = $checkField = $checkFormButton = $c_id = "";

        $selectedStatus = "checked";

        $selectedTask = $redirectTo = null;

        $selectedStage = __("job.check_list_default_stage_text");

        $selectedLocation = __("job.check_list_default_location_text");

        $redirectTo = route(__("dashboard.dashboard_url"));

        $postUrl = route(__("job.check_list_store_url"));

        $mediaPostUrl = route(__("job.check_list_media_store_url"));

        $title = __('job.check_list_add_label');

        if(Route::currentRouteName() == __("job.check_list_edit_url")) {

            $title = __('job.check_list_edit_label');

            $checkField = "checkField";

            $checkFormButton = "checkFormButton";

            $postUrl = route(__("job.check_list_update_url"));

        }

        if(isset($returnData["job_id"]) && $returnData["job_id"]) {

            $job_id = $returnData["job_id"];

            $selectedStatus = __("job.check_list_default_status_text");

        }

        if(isset($returnData["data"]) && $returnData["data"]) {


            if(isset($returnData["data"]["stage"]) && $returnData["data"]["stage"]) {

                $selectedStage = $returnData["data"]["stage"];

            }

            if(isset($returnData["data"]["t_id"]) && $returnData["data"]["t_id"]) {

            $selectedTask = $returnData["data"]["t_id"];

            }

            if(isset($returnData["data"]["location"]) && $returnData["data"]["location"]) {

                $selectedLocation = $returnData["data"]["location"];

            }

            if(isset($returnData["data"]["status"]) && $returnData["data"]["status"] == "0") {

                $selectedStatus = "";

            }

            if(isset($returnData["data"]["c_id"]) && $returnData["data"]["c_id"]) {

                $c_id = $returnData["data"]["c_id"];

            }

            if(isset($returnData["data"]["job_id"]) && $returnData["data"]["job_id"]) {

                $job_id = $returnData["data"]["job_id"];

                if(isset($returnData["data"]["status"]) && $returnData["data"]["status"]) {

                    $selectedStatus = $returnData["data"]["status"];

                }

            }

        }

        if(isset($returnData["job_stage"])) {

            $selectedStage = $returnData["job_stage"];

            if(isset($returnData["stage_list"]) && $returnData["stage_list"] != "") {

                $stagePosition = array_search($selectedStage, array_keys($returnData["stage_list"]));

                $returnData["stage_list"] = array_slice($returnData["stage_list"], $stagePosition);

            }

        }

        if (isset($returnData["redirectTo"]) && $returnData["redirectTo"] == __("job.job_detail_url") && $jobId) {

            $redirectTo = route($returnData["redirectTo"], $jobId);

        }

    ?>

    <!-- Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark capitalize-font"><i
                                class="zmdi zmdi-account-box mr-10"></i>{{ $title }}</h6>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="pull-left inline-block full-screen mr-15">
                            <i class="zmdi zmdi-fullscreen job-status-i"></i>
                        </a>
                        <a class="pull-left inline-block" href="{{$redirectTo ?? '#'}}" data-effect="fadeOut">
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
                                    <form id="checkListForm" class="checkListForm" data-toggle="validator" role="form"
                                        action="{{ $postUrl }}" method="POST">
                                        <div class="form-body">
                                            <div class="row">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" id="redirectTo" name="redirectTo" value="{{$returnData['redirectTo'] ?? ''}}">
                                                <input type="hidden" id="c_id" name="c_id" value="{{$c_id ?? ''}}">
                                                <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />
                                                <?php if(isset($returnData['type']) && $returnData['type'] == "job") { ?>

                                                <input type="hidden" id="job_id" name="job_id" value="{{ $job_id }}">

                                                <?php } ?>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                            <div class="form-group">
                                                                <label for="stage"
                                                                    class="control-label mb-10">{{ __('job.check_list_stage_label') }}</label>
                                                                {!! Form::select('stage', [ null =>
                                                                __('job.check_list_stage_placeholder_text') ] +
                                                                $returnData["stage_list"],
                                                                $selectedStage, ['class' =>
                                                                'form-control select2 ' . $checkField,
                                                                'previous_value' => $selectedStage,
                                                                'required']) !!}
                                                            </div>
                                                        </div>

                                                        <?php if(isset($returnData['type']) && $returnData['type'] == "job") { ?>

                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-md-offset-1">

                                                            <div class="form-group">
                                                                <label for="status"
                                                                    class="control-label mb-10">{{ __('job.check_list_status_label') }}</label>
                                                                {!! Form::select('status', [ null =>
                                                                __('job.check_list_status_placeholder_text') ] +
                                                                $returnData["status_list"],
                                                                $selectedStatus, ['class' =>
                                                                'form-control select2 ' . $checkField,
                                                                'previous_value' => $selectedStatus,
                                                                'required']) !!}
                                                            </div>

                                                        </div>

                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-md-offset-1">

                                                            <div class="form-group">
                                                                <label for="task_id"
                                                                    class="control-label mb-10">{{ __('job.check_list_task_select_label') }}</label>
                                                                {!! Form::select('t_id', [ null =>
                                                                __('job.check_list_task_select_placeholder_text') ] +
                                                                $returnData["task_list"],
                                                                $selectedTask, ['class' =>
                                                                'form-control select2 ' . $checkField,
                                                                'previous_value' => $selectedTask]) !!}
                                                            </div>

                                                        </div>

                                                        <?php } else { ?>

                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-md-offset-2">

                                                            <div class="form-group">
                                                                <label for="location"
                                                                    class="control-label mb-10">{{ __('job.check_list_location_label') }}</label>
                                                                {!! Form::select('location', [ null =>
                                                                __('job.check_list_location_placeholder_text') ] +
                                                                $returnData["location_list"],
                                                                $selectedLocation,
                                                                ['class' =>
                                                                'form-control select2 ' . $checkField,
                                                                'previous_value' . $selectedLocation,
                                                                'required']) !!}
                                                            </div>

                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-md-offset-2">
                                                            <label for="status"
                                                                class="control-label mb-10">{{ __('job.check_list_status_label') }}</label>
                                                            <div class="form-group js-switch-mt-0">
                                                                <input type="checkbox" id="status" name="status"
                                                                    class="js-switch js-switch-1 {{$checkField}}"
                                                                    previous_value="{{ $selectedStatus }}"
                                                                    data-color="#8BC34A" data-secondary-color="#F8B32D"
                                                                    {{ $selectedStatus }}>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>

                                                        <?php } ?>

                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="title"
                                                            class="control-label mb-10">{{ __('job.check_list_title_label') }}</label>
                                                        <input type="text" class="form-control {{$checkField}}"
                                                            id="title" name="title"
                                                            value="{{$returnData['data']['title'] ?? ''}}"
                                                            placeholder="{{ __('job.check_list_title_placeholder_text') }}"
                                                            data-error="{{ __('job.check_list_title_error_msg') }}"
                                                            required>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="check-list-description"
                                                            class="control-label mb-10">{{ __('job.check_list_description_label') }}</label>
                                                        <textarea class="textarea_editor form-control {{$checkField}}"
                                                            rows="15" id="check-list-description" name="description"
                                                            value="{{$returnData['data']['description'] ?? ''}}"
                                                            data-value="{{$returnData['data']['description'] ?? ''}}"
                                                            placeholder="{{ __('job.check_list_description_placeholder_text') }}"></textarea>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="attachment"
                                                            class="control-label mb-10">{{ __('job.check_list_attachment_label') }}</label>
                                                        <input type="text" class="form-control {{$checkField}}"
                                                            id="attachment" name="attachment_path"
                                                            value="{{$returnData['data']['attachment_path'] ?? ''}}"
                                                            placeholder="{{ __('job.check_list_attachment_placeholder_text') }}"
                                                            data-error="{{ __('job.check_list_attachment_error_msg') }}">
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-md-offset-10 mt-30">
                                                    <button type="submit"
                                                        class="btn btn-success btn-anim mr-10 {{$checkFormButton}}">
                                                        <i class="fa fa-check font-20"></i>
                                                        <span class="btn-text font-20">
                                                            {{ __('job.check_list_submit_button_label') }}
                                                        </span>
                                                    </button>
                                                    <a href="{{ $redirectTo }}" class="btn btn-danger btn-anim">
                                                        <i class="fa fa-times font-20"></i>
                                                        <span class="btn-text font-20">
                                                            {{ __('job.check_list_cancel_button_label') }}
                                                        </span>
                                                    </a>
                                                </div>
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
<!-- /Main Content -->
@endsection
