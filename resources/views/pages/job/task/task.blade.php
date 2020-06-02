@extends('layouts.default')

@push('css')
<!-- Bootstrap Dropzone CSS -->
<link href="{{ asset('public/js/custom/vendors/bower_components/dropzone/dist/dropzone.css') }}" rel="stylesheet" type="text/css" />
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')

<!-- Main Content -->
<div class="container-fluid pt-25">

    <?php

    $taskCategoryFollowupTime = [];

    $required = $taskId = $type = $selectedType = "";

    $jobId = $checkField = $checkFormButton = $disabled = $disabledClass = $selectedJobId = $selectedParent = $selectedStage = $selectedStatus = $selectedCreatedUser = $selectedAssignedUser = "";

    $statusDisplayBlock = $statusDisplayBlockOffset = $subTaskUsers = $previousAssignedUser = $partialComplete = $previousPartialcomplete = "";

    $selectedCategory = "medium";

    $selectedFollowupDate = date('Y-m-d H:i:s');

    if(isset($returnData["category_followup_time"]) && is_array($returnData["category_followup_time"]) && count($returnData["category_followup_time"]) > 0){

        $taskCategoryFollowupTime = $returnData["category_followup_time"];

        if(isset($taskCategoryFollowupTime[$selectedCategory]) && $taskCategoryFollowupTime[$selectedCategory] != "") {

            $selectedFollowupDate = date("Y-m-d H:i:s", strtotime("+" . $taskCategoryFollowupTime[$selectedCategory] . " hour", strtotime(date("Y-m-d H:i:s"))));

        }
    }

    $redirectTo = route(__("dashboard.dashboard_url"));

    $taskDeleteUrl = "#";

    $genericJobAddUrl = "#";

    $genericJobAddUrl = route(__("job.annotator_job_add_url"));

    $postUrl = route(__("job.task_store_url"));

    $mediaPostUrl = route(__("job.task_media_store_url"));

    $title = __('job.task_add_label');

    if (Route::currentRouteName() == __("job.task_edit_url")) {

        $title = __('job.task_edit_label');

        $postUrl = route(__("job.task_update_url"));

        $disabled = "disabled";

        $disabledClass = "disabled-block";

        $statusDisplayBlock = "true";

        $statusDisplayBlockOffset = "col-md-offset-1";

        $checkField = "checkField";

        $checkFormButton = "checkFormButton";
    }

    if (isset($returnData["job_id"]) && $returnData["job_id"]) {

        $jobId = $returnData["job_id"];

        $selectedJobId = $returnData["job_id"];
    }

    if (isset($returnData["type"]) && $returnData["type"]) {

        $type = $returnData["type"];

    }

    if ($type == __("job.task_querylist_text")) {

        $title = __('job.query_add_label');

    }

    if(isset($returnData["type_list"]) && isset($returnData["type_list"][__("job.task_inhouse_query_text")])) {

        $selectedType = __("job.task_inhouse_query_text");

    }

    if (isset($returnData["stage"]) && $returnData["stage"]) {

        $selectedStage = $returnData["stage"];
    }

    if ($type == "detail") {

        $required = "required";
    }

    if (isset($returnData["data"]) && $returnData["data"]) {

        if (isset($returnData["data"]["task_id"]) && $returnData["data"]["task_id"]) {

            $taskId = $returnData["data"]["task_id"];

            $taskDeleteUrl = route(__("job.task_delete_url")) . "?task_id=" . $taskId;
        }

        if (isset($returnData["data"]["category"]) && $returnData["data"]["category"]) {

            $selectedCategory = $returnData["data"]["category"];
        }

        if (isset($returnData["data"]["job_id"]) && $returnData["data"]["job_id"]) {

            $selectedJobId = $returnData["data"]["job_id"];

            $jobId = $selectedJobId;
        }

        if (isset($returnData["data"]["parent_task_id"]) && $returnData["data"]["parent_task_id"]) {

            $selectedParent = $returnData["data"]["parent_task_id"];
        }

        if (isset($returnData["data"]["stage"]) && $returnData["data"]["stage"]) {

            $selectedStage = $returnData["data"]["stage"];

            if (isset($returnData["stage_list"]) && $returnData["stage_list"] != "") {

                $stagePosition = array_search($selectedStage, array_keys($returnData["stage_list"]));

                $returnData["stage_list"] = array_slice($returnData["stage_list"], $stagePosition);
            }
        }

        if (isset($returnData["data"]["createdby_status"]) && $returnData["data"]["createdby_status"]) {

            $selectedStatus = $returnData["data"]["createdby_status"];
        }

        if (isset($returnData["data"]["createdby_empcode"]) && $returnData["data"]["createdby_empcode"]) {

            $selectedCreatedUser = $returnData["data"]["createdby_empcode"];
        }

        if (isset($returnData["data"]["assignedto_empcode"]) && $returnData["data"]["assignedto_empcode"]) {

            $selectedAssignedUser = $returnData["data"]["assignedto_empcode"];

            $previousAssignedUser = $returnData["data"]["assignedto_empcode"];
        }

        if (isset($returnData["data"]["assingees"]) && $returnData["data"]["assingees"]) {

            $subTaskUsers = json_encode($returnData["data"]["assingees"]);
        }

        if (isset($returnData["data"]["partialcomplete"]) && $returnData["data"]["partialcomplete"] != "") {

            $partialComplete = $returnData["data"]["partialcomplete"];

            $previousPartialcomplete = $returnData["data"]["partialcomplete"];

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
                        <h6 class="panel-title txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10"></i>{{ $title }}</h6>
                    </div>
                    <div class="pull-right">

                        <?php if ($taskId != "") { ?>

                            <div class="pull-left inline-block mr-15 footable-filtering">
                                <a class="btn btn-danger btn-outline btn-icon right-icon" type="button" href="{{$taskDeleteUrl ?? '#'}}">
                                    {{__('job.task_delete_button_label')}}
                                    <i class="fa fa-trash font-15"></i>
                                </a>
                            </div>

                        <?php } ?>

                        <a href="#" class="pull-left inline-block full-screen mr-15">
                            <i class="zmdi zmdi-fullscreen job-status-i"></i>
                        </a>
                        <a class="pull-left inline-block" href="{{$redirectTo ?? '#'}}" data-effect="fadeOut">
                            <i class="zmdi zmdi-close job-status-i"></i>
                        </a>
                        {{-- <a id="job-status-close" class="pull-left inline-block" href="{{ route(__("job.check_list_url")) }}"
                        data-effect="fadeOut">
                        <i class="zmdi zmdi-close job-status-i"></i>
                        </a> --}}
                        {{-- <a class="pull-left inline-block" href="javascript:history.back()" data-effect="fadeOut">
                            <i class="zmdi zmdi-close job-status-i"></i>
                        </a> --}}
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-wrap">
                                    <form class="taskForm" id="taskForm" data-toggle="validator" role="form" action="{{ $postUrl }}" method="POST">
                                        <div class="form-body">

                                            <div class="row">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" name="attachment_path" id="attachment_path" />
                                                <input type="hidden" name="followup_type" id="followup_type" value="followup" />
                                                <input type='hidden' id="partialcomplete" name='partialcomplete' value='0'>
                                                <input type='hidden' id="previousPartialcomplete" name='previousPartialcomplete' value='{{$previousPartialcomplete}}'>
                                                <input type="hidden" id="redirectTo" name="redirectTo" value="{{$returnData['redirectTo'] ?? ''}}">
                                                <input type="hidden" id="task_id" name="task_id" value="{{$returnData['data']['task_id'] ?? ''}}" />
                                                <input type="hidden" id="current_job_id" name="current_job_id" value="{{$jobId}}" />
                                                <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />

                                                <?php if ($previousAssignedUser != "") { ?>

                                                    <input type='hidden' id="previous_assigned_user" name='previous_assigned_user' value='{{$previousAssignedUser}}'>

                                                <?php } ?>

                                                <?php if ($subTaskUsers != "") { ?>

                                                    <input type='hidden' id="subTaskUsers" name='subTaskUsers' value='{{$subTaskUsers}}'>

                                                <?php } ?>

                                                <?php if ($type != __("job.task_querylist_text")) { ?>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                <div class="form-group">
                                                                    <label for="stage" class="control-label mb-10">{{ __('job.task_stage_label') }}</label>
                                                                    {!! Form::select('stage', [ null =>
                                                                    __('job.task_stage_placeholder_text') ] +
                                                                    $returnData["stage_list"], $selectedStage,
                                                                    ['class' =>
                                                                    'form-control select2 '.$checkField,
                                                                    ]) !!}
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-md-offset-1">
                                                                <div class="form-group">

                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                                            <label for="job_id" class="control-label mb-10">{{ __('job.task_job_title_label') }}</label>
                                                                        </div>

                                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-md-offset-2">
                                                                            <div class="checkbox checkbox-success pull-right ma-0 pa-0">
                                                                            <input class="genericJob" type="checkbox" data-generic-job-add-url="{{$genericJobAddUrl ?? ''}}">
                                                                                <label for="checkbox" class="text-capitalize">
                                                                                    {{ __('job.task_generic_job_label') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    {!! Form::select('job_id', [ null =>
                                                                    __('job.task_job_title_placeholder_text') ] +
                                                                    $returnData["job_list"],
                                                                    $selectedJobId, [
                                                                    'class' => 'form-control select2 task-job-select'. $checkField,
                                                                    'required'
                                                                    ]) !!}
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="row">

                                                            <?php if($statusDisplayBlock == "true") { ?>

                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                    <div class="form-group">
                                                                        <label for="status" class="control-label mb-10">{{ __('job.task_status_label') }}</label>
                                                                        {!! Form::select('createdby_status', [ null =>
                                                                        __('job.task_status_placeholder_text') ] +
                                                                        $returnData["status_list"], $selectedStatus,
                                                                        ['class' =>
                                                                        'form-control select2 ' . $checkField,
                                                                        'required'])
                                                                        !!}
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>

                                                            <?php } ?>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 {{$statusDisplayBlockOffset}}">
                                                                <div class="row">
                                                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="category" class="control-label mb-10">{{ __('job.task_category_label') }}</label>
                                                                            {!! Form::select('category', [ null =>
                                                                            __('job.task_category_placeholder_text') ] +
                                                                            $returnData["category_list"], $selectedCategory,
                                                                            ['class' => 'form-control task_category select2 ' . $checkField,
                                                                            'data-task-category_followup_time' => json_encode($taskCategoryFollowupTime),
                                                                            'required'])
                                                                            !!}
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label mb-10 text-left">{{__('job.task_followup_time_label')}}:
                                                                            </label>
                                                                            <div class="input-group date datetimepicker">
                                                                            <input type="text" id="followup_date" name="followup_date" class="followup_date form-control pa-5" value="{{$selectedFollowupDate}}" data-error="{{ __('job.task_followup_date_error_msg') }}" required>
                                                                                <span class="input-group-addon">
                                                                                    <span class="fa fa-calendar"></span>
                                                                                </span>
                                                                            </div>
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-md-offset-1">
                                                                <div class="form-group">

                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                                            <label for="assignedto_empcode" class="control-label mb-10">{{ __('job.task_assigned_to_label') }}</label>
                                                                        </div>

                                                                        <?php if (($taskId != "" && $subTaskUsers != "") || ($taskId == "")) { ?>

                                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-md-offset-2">
                                                                                <div class="checkbox checkbox-success pull-right ma-0 pa-0">
                                                                                    <input id="multipleTaskAssignee" type="checkbox">
                                                                                    <label for="checkbox" class="text-capitalize">
                                                                                        {{ __('job.task_assigned_to_multiple_label') }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                        <?php } ?>

                                                                    </div>
                                                                    {!! Form::select('assignedto_empcode', [ "" =>
                                                                    __('job.task_assigned_to_placeholder_text') ] +
                                                                    $returnData["user_list"], $selectedAssignedUser,
                                                                    ['class' => 'form-control select2 multiple-task-assignee ' . $checkField,
                                                                    'data-value' => $subTaskUsers,
                                                                    'required'])
                                                                    !!}
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                                <?php if ($type == __("job.task_querylist_text")) { ?>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                <div class="form-group">
                                                                    <label for="job_id" class="control-label mb-10">{{ __('job.task_job_title_label') }}</label>
                                                                    {!! Form::select('job_id', [ null =>
                                                                    __('job.task_job_title_placeholder_text') ] +
                                                                    $returnData["job_list"],
                                                                    $selectedJobId, [
                                                                    'class' => 'form-control select2 '. $checkField,
                                                                    ]) !!}
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-md-offset-1">
                                                                <div class="row">
                                                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="category" class="control-label mb-10">{{ __('job.task_category_label') }}</label>
                                                                            {!! Form::select('category', [ null =>
                                                                            __('job.task_category_placeholder_text') ] +
                                                                            $returnData["category_list"], $selectedCategory,
                                                                            ['class' => 'form-control task_category select2 ' . $checkField,
                                                                            'data-task-category_followup_time' => json_encode($taskCategoryFollowupTime),
                                                                            'required'])
                                                                            !!}
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label mb-10 text-left">{{__('job.task_followup_time_label')}}:
                                                                            </label>
                                                                            <div class="input-group date datetimepicker">
                                                                                <input type="text" id="followup_date" name="followup_date" class="followup_date form-control pa-5"
                                                                                    value="{{$selectedFollowupDate}}" data-error="{{ __('job.task_followup_date_error_msg') }}"
                                                                                    required>
                                                                                <span class="input-group-addon">
                                                                                    <span class="fa fa-calendar"></span>
                                                                                </span>
                                                                            </div>
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-md-offset-1 disabled-block">
                                                                <div class="form-group">
                                                                    <label for="type" class="control-label mb-10">{{ __('job.task_type_label') }}</label>
                                                                    {!! Form::select('task_type', [ null =>
                                                                    __('job.task_type_placeholder_text') ] +
                                                                    $returnData["type_list"], $selectedType,
                                                                    ['class' => 'form-control select2',
                                                                    'required'])
                                                                    !!}
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="title" class="control-label mb-10">{{ __('job.task_title_label') }}</label>
                                                        <input type="text" class="form-control {{ $checkField }}" id="title" name="title" value="{{$returnData['data']['title'] ?? ''}}" placeholder="{{ __('job.task_title_placeholder_text') }}" data-error="{{ __('job.task_title_error_msg') }}" required>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                    <div class="form-group">

                                                        <label for="task-description" class="control-label mb-10">{{ __('job.task_description_label') }}</label>

                                                        <div class="pills-struct">
                                                            <ul role="tablist" class="nav nav-pills nav-pills-outline task_desc_tab_list" id="">
                                                                <li class="active subTaskDescHead" role="presentation">
                                                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="commonTab" href="#common_desc">
                                                                        {{ __('job.task_common_description_label') }}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="pills-struct">
                                                            <div class="tab-content task_desc_tab_content" id="">
                                                                <div id="common_desc" class="tab-pane fade active in" role="tabpanel">
                                                                    <textarea class="textarea_editor form-control {{ $checkField }}" rows="15" id="task-description" name="description" value="{{$returnData['data']['description'] ?? ''}}" data-value="{{$returnData['data']['description'] ?? ''}}" placeholder="{{ __('job.task_description_placeholder_text') }}"></textarea>
                                                                    <div class="help-block with-errors"></div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <?php  if((!$taskId) or ($taskId && $partialComplete == "1")) { ?>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="attachment" class="control-label mb-10">{{ __('job.task_attachment_label') }}</label>
                                                            <input type="text" class="form-control" id="task_attachment_path" name="attachment_path" value="{{$returnData['data']['attachment_path'] ?? ''}}" placeholder="{{ __('job.task_attachment_placeholder_text') }}" data-error="{{ __('job.task_attachment_error_msg') }}">
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-30">

                                                    <span class="pull-right mt-5">

                                                        <?php if ((!$taskId) or ($taskId && $partialComplete == "1")) { ?>

                                                            <button type="button" id="taskFormSaveButton" class="btn btn-success btn-anim mr-10 taskNoteFormSaveButton">
                                                                <i class="fa fa-save font-20"></i><span class="btn-text font-20">{{ __('job.task_save_button_label') }}</span></button>

                                                        <?php } ?>

                                                        <button type="button" id="taskFormSubmitButton" class="btn btn-success btn-anim mr-10"> <i class="fa fa-check font-20"></i><span class="btn-text font-20">{{ __('job.task_submit_button_label') }}</span></button>

                                                        <a href="{{ $redirectTo ?? '#' }}" class="btn btn-danger btn-anim"><i class="fa fa-times font-20"></i><span class="btn-text font-20">{{ __('job.task_cancel_button_label') }}</span></a>

                                                    </span>

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
