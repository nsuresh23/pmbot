@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@php

$taskListUrl = route(__("job.job_task_list_url"));
$draftTaskListUrl = route(__("job.draft_task_list_url"));
$taskAddUrl = route(__("job.task_add_url"));
$taskEditUrl = route(__("job.task_edit_url"), "");
$taskDeleteUrl = route(__("job.task_delete_url"));


$globalCheckListTableCaption = __("job.job_detail_global_check_list_table_caption_label");
$jobCheckListTableCaption = __("job.job_detail_job_check_list_table_caption_label");

$checkListUrl = route(__("job.check_list_url"));
$checkListAddUrl = route(__("job.check_list_add_url"));
$checkListEditUrl = route(__("job.check_list_edit_url"), "");
$checkListDeleteUrl = route(__("job.check_list_delete_url"));

$jobEmailListUrl = route(__("job.email_list_url"));

$emailSendUrl = route(__("job.email_send_url"));
$draftemailSendUrl = route(__("job.draftemail_send_url"));
$emailGetUrl = route(__("job.email_get_url"));
$emailStatusUpdateUrl = route(__("job.email_status_update_url"));
$getEmailid = route(__("job.get_email_id"));
$emailTemplateListUrl = route(__("job.email_templates_list_url"));

$signatureUpdateUrl      = route(__("job.signature_update"));
$getSignatureUrl         = route(__("job.get_signature"));

$redirectTo = __("job.job_detail_url");
$redirectToJobUrl = __("job.job_detail_url");

$emailTemplateList = [];

$jobId = $jobStatus = $selectedDueDate = $peEmail = $authorEmail = "";

$selectedJobCategory = $selectedWorkflowVersion = null;

if(isset($responseData["data"]) && $responseData["data"]) {

    if(isset($responseData["data"]["job_id"]) && $responseData["data"]["job_id"]) {

        $jobId = $responseData["data"]["job_id"];

        $redirectToJobUrl = route(__("job.job_detail_url"), $jobId);

    }

    if(isset($responseData["data"]["status"]) && $responseData["data"]["status"]) {

        $jobStatus = $responseData["data"]["status"];

    }

    if(isset($responseData["data"]["date_due"]) && $responseData["data"]["date_due"]) {

        $selectedDueDate = $responseData["data"]["date_due"];

    }

    if(isset($responseData["data"]["workflow_version"]) && $responseData["data"]["workflow_version"]) {

        $selectedWorkflowVersion = $responseData["data"]["workflow_version"];

    }

    if(isset($responseData["data"]["category"]) && $responseData["data"]["category"]) {

        $selectedJobCategory = $responseData["data"]["category"];

    }

    if(isset($responseData["data"]["pe_email"]) && $responseData["data"]["pe_email"]) {

        $peEmail = $responseData["data"]["pe_email"];

    }

    if(isset($responseData["data"]["author_email"]) && $responseData["data"]["author_email"]) {

        $authorEmail = $responseData["data"]["author_email"];

    }

}

if(isset($responseData['email_template_list']) && is_array($responseData['email_template_list']) && count($responseData['email_template_list']) > 0 ) {

    $emailTemplateList = $responseData['email_template_list'];

}

$taskCheckListAddOption = $emailCheckListAddOption = "false";

if(in_array(auth()->user()->role, config('constants.jobCheckListAddUserRoles'))) {

    $taskCheckListAddOption = "true";

    $emailCheckListAddOption = "true";

}

$jobEditReadonly = "readonly";

if(in_array(auth()->user()->role, config('constants.jobEditUserRoles'))) {

    $jobEditReadonly = "";

}

@endphp

@section('content')
<!-- Main Content -->
<div class="container-fluid pt-25">
    @include('pages.email.composeModal')
    @include('pages.email.replyModal')
    @include('pages.email.draftModal')
    <?php // print_r($responseData["jsonData"]); exit; ?>
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title capitalize txt-dark">{{__('job.job_detail_job_label')}} :
                            {{ $responseData["data"]["title"] ?? '-' }}</h6>
                    </div>
                    <div class="pull-right">

                        <div class="pull-left inline-block mr-15 footable-filtering">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label class="sr-only capitalize">{{__('job.job_detail_search_label')}}</label>
                                    <div class="input-group">
                                        <input type="text" id="jobStatusSearchInput" class="form-control"
                                            placeholder="{{__('job.job_detail_search_placeholder_text')}}">
                                        <div id="jobStatusSearch"
                                            data-job-detail-base-url="{{ route(__('job.job_detail_base_url')) }}"
                                            class="input-group-btn">
                                            <span type="button" class="btn btn-primary">
                                                <span class="fooicon fooicon-search"></span>
                                                {{-- <i class="zmdi zmdi-search zmdi-hc-2x"></i> --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <a href="#" class="pull-left inline-block full-screen mr-15">
                            <i class="zmdi zmdi-fullscreen job-status-i"></i>
                        </a>
                        {{-- <a id="job-status-close" class="pull-left inline-block" href="{{ route(__('job.job_detail_home_url'), 'redirectToDashboard') }}"
                        data-effect="fadeOut">
                        <i class="zmdi zmdi-close job-status-i"></i>
                        </a> --}}
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pb-0">
                        <div class="pills-struct">
                            <ul role="tablist" class="nav nav-pills nav-pills-outline" id="myTabs_7">
                                <li class="" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab"
                                        id="jobBookInfoTab" class="capitalize"
                                        href="#bookInfo">{{ __('job.book_detail_label') }}</a></li>
                                <li class="jobTaskList" role="presentation"><a aria-expanded="true" data-toggle="tab"
                                        role="tab" id="jobTimelineTab" class="capitalize" href="#jobTimeline"
                                        data-job-timeline-url="{{ route(__('job.job_timeline_url'), $jobId) }}">{{ __('job.job_detail_timeline_tab_label') }}</a>
                                </li>
                                <li class="jobTaskList" role="presentation"><a data-toggle="tab" id="jobDiaryTab"
                                        class="capitalize" role="tab" href="#jobDiary"
                                        data-job-history-url="{{ route(__('job.job_history_url'), $jobId) }}"
                                        aria-expanded="false">{{ __('job.job_detail_diary_tab_label') }}</a></li>
                                <li class="jobTaskList active" role="presentation"><a data-toggle="tab" id="jobTaskTab"
                                        class="capitalize" role="tab" href="#jobTask"
                                        aria-expanded="false">{{__('job.job_task_tab_label')}}</a></li>
                                <li class="jobClosedTaskTab" role="presentation"><a data-toggle="tab"
                                        id="jobClosedTaskTab" class="capitalize" role="tab" href="#jobClosedTask"
                                        aria-expanded="false">{{__('dashboard.closed_tasks_label')}}</a></li>
                                {{-- <li class="jobTaskList" role="presentation"><a data-toggle="tab" id="jobDraftTaskTab" class="capitalize" role="tab"
                                        href="#jobDraftTask" aria-expanded="false">{{__('job.job_draft_task_tab_label')}}</a>
                                </li> --}}
                                {{-- <li class="" role="presentation"><a data-toggle="tab" id="jobCheckListTab" class="capitalize" role="tab" href="#jobCheckList"
                                        aria-expanded="false">{{__('job.job_check_list_tab_label')}}</a></li> --}}
                                <li class="" role="presentation"><a data-toggle="tab" id="jobEmailListTab"
                                        class="capitalize" role="tab" href="#jobEmailList"
                                        aria-expanded="false">{{__('job.job_email_tab_label')}}</a></li>
                                <li role="presentation" class=""><a data-toggle="tab" id="financialTab" role="tab"
                                        href="#financial"
                                        aria-expanded="false">{{ __('job.job_invoice_tab_label') }}</a></li>
                                {{-- <li class="dropdown" role="presentation">
                                    <a data-toggle="dropdown" class="dropdown-toggle" id="myTabDrop_7" href="#"
                                        aria-expanded="false">Dropdown <span class="caret"></span></a>
                                    <ul id="myTabDrop_7_contents" class="dropdown-menu">
                                        <li class=""><a data-toggle="tab" id="dropdown_13_tab" role="tab"
                                                href="#dropdown_13" aria-expanded="true">@fat</a></li>
                                        <li class=""><a data-toggle="tab" id="dropdown_14_tab" role="tab"
                                                href="#dropdown_14" aria-expanded="false">@mdo</a></li>
                                    </ul>
                                </li> --}}
                                {{-- <div class="pull-right">

                                    <?php //if(isset($jobStatus) && $jobStatus == "hold") { ?>

                                        <a class="pull-left inline-block btn btn-primary job-resume-btn" href="#">
                                            {{ __("job.job_resume_btn_label") }}
                                        </a>

                                    <?php //} ?>

                                    <?php //if(isset($jobStatus) && $jobStatus != "hold" && $jobStatus != "completed") { ?>

                                        <a class="pull-left inline-block btn btn-warning job-hold-btn mr-15" href="#">
                                            {{ __("job.job_hold_btn_label") }}
                                        </a>

                                        <a class="pull-left inline-block btn btn-success job-complete-btn mr-15" href="#">
                                            {{ __("job.job_completed_btn_label") }}
                                        </a>

                                    <?php //} ?>

                                    <form id="job-status-update-form" class="job-status-update-form" style="display:none;"
                                        action="{{route(__('job.job_update_url'))}}">

                                        <div class=" form-body">

                                            <div class="">
                                                <input type="hidden" id="job_status_update_redirectTo" name="redirectTo" value="{{$redirectTo ?? '#'}}">
                                                <input type="hidden" id="job_status_update_job_id" name="job_id" value="{{$jobId ?? ''}}">
                                                <input type="hidden" id="job_status_update_current_job_id" name="current_job_id" value="{{$jobId ?? ''}}">
                                                <input type="hidden" id="job_status_update_start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />
                                                <input type="hidden" id="job_status_update_status" name="status" value="hold" />
                                                <input type="hidden" id="job_status_update_remarks" name="remarks" value="" />
                                            </div>

                                        </div>
                                    </form>

                                </div> --}}

                                <form id="job-status-update-form" class="job-status-update-form" style="display:none;" action="{{route(__('job.job_update_url'))}}">
                                    <div class="form-body">
                                        <div class="">
                                            <input type="hidden" id="job_status_update_redirectTo" name="redirectTo" value="{{$redirectTo ?? '#'}}">
                                            <input type="hidden" id="job_status_update_job_id" name="job_id" value="{{$jobId ?? ''}}">
                                            <input type="hidden" id="job_status_update_current_job_id" name="current_job_id" value="{{$jobId ?? ''}}">
                                            <input type="hidden" id="job_status_update_start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />
                                            <input type="hidden" id="job_status_update_status" name="status" value="hold" />
                                            <input type="hidden" id="job_status_update_remarks" name="remarks" value="" />
                                        </div>
                                    </div>
                                </form>

                            </ul>
                            {{-- <hr class="light-grey-hr" /> --}}
                            <div class="tab-content" id="myTabContent_7">
                                <div id="bookInfo" class="tab-pane fade" role="tabpanel">
                                    @include('pages.job.bookInfo')
                                </div>
                                <div id="jobTimeline" class="tab-pane fade" role="tabpanel">
                                    @include('pages.job.jobTimeline')
                                </div>
                                <div id="jobGrid" class="tab-pane fade" role="tabpanel">
                                    @include('pages.job.jobGrid')
                                </div>
                                <div id="jobDiary" class="tab-pane fade" role="tabpanel">
                                    @include('pages.job.jobDiary')
                                </div>
                                <div id="jobTask" class="tab-pane fade active in" role="tabpanel">
                                    @include('pages.job.taskListOverview')
                                </div>
                                <div id="jobClosedTask" class="tab-pane fade" role="tabpanel">
                                    @include('pages.job.task.taskList')
                                </div>
                                {{-- <div id="jobDraftTask" class="tab-pane fade" role="tabpanel">
                                    @include('pages.job.jobDraftTask')
                                </div> --}}
                                {{-- <div id="jobCheckList" class="tab-pane fade" role="tabpanel">
                                    @include('pages.job.checkListOverview')
                                </div> --}}
                                <div id="jobEmailList" class="tab-pane fade" role="tabpanel">
                                    @include('pages.job.emailListOverview')
                                </div>
                                <div id="financial" class="tab-pane fade" role="tabpanel">

                                    {{--@include('pages.job.jobFinancialInVoice')--}}

                                </div>
                                {{-- <div id="dropdown_13" class="tab-pane fade " role="tabpanel">
                                    <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's
                                        organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
                                </div>
                                <div id="dropdown_14" class="tab-pane fade" role="tabpanel">
                                    <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they
                                        sold out master cleanse gluten-free squid scenester freegan cosby sweater.</p>
                                </div> --}}
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
