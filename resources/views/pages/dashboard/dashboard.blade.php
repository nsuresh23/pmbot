@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Main Content -->
<div class="container-fluid pa-5 pt-0">
    <?php

        // auth()->user()->is_members = '1';

        $am_email_approved = "0";

        if (in_array(auth()->user()->role, config('constants.amUserRoles'))) {

            $am_email_approved = "1";

        }

        $hasMembers = auth()->user()->is_members;

        $previoustUrl = Session::get('previousUrl');
        $r = explode('/', $previoustUrl);
        if(count($r) > 2) {

            $previousUrlIsJobDetail = $r[count($r)-2];
        }

        $addQueryOption = $taskCheckListAddOption = $emailCheckListAddOption = "false";

        $overViewExpand = "";

        if(in_array(auth()->user()->role, config('constants.amUserRoles'))) {

            $overViewExpand = "in";

        }

        if(!in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) {

            $addQueryOption = "true";

        }

        if(in_array(auth()->user()->role, config('constants.globalCheckListAddUserRoles'))) {

            $taskCheckListAddOption = "true";

            $emailCheckListAddOption = "true";

        }

        $myEmailsMoveToList = $emailTemplateList = [];

        $redirectToDashboard = $returnResponse['redirectToDashboard'];

        $nonBusinessEmailLabels = $returnResponse['label_list'];

        $emailOutboxCount = $emailOutboxWIPCount = $emailSentCount = $emailHoldCount = "0";

        if(isset($returnResponse['email_sent_count']) && is_array($returnResponse['email_sent_count']) && count($returnResponse['email_sent_count']) > 0 ) {

            if(isset($returnResponse['email_sent_count']["outbox_count"]) && $returnResponse['email_sent_count']["outbox_count"] != "") {

                $emailOutboxCount = $returnResponse['email_sent_count']["outbox_count"];

            }

            if(isset($returnResponse['email_sent_count']["outbox_wip_count"]) && $returnResponse['email_sent_count']["outbox_wip_count"] != "") {

                $emailOutboxWIPCount = $returnResponse['email_sent_count']["outbox_wip_count"];

            }

            if(isset($returnResponse['email_sent_count']["sent_count"]) && $returnResponse['email_sent_count']["sent_count"] != "") {

                $emailSentCount = $returnResponse['email_sent_count']["sent_count"];

            }

            if(isset($returnResponse['email_sent_count']["hold_count"]) && $returnResponse['email_sent_count']["hold_count"] != "")
            {

                $emailHoldCount = $returnResponse['email_sent_count']["hold_count"];

            }

        }

        if(isset($returnResponse['email_move_to_list']) && is_array($returnResponse['email_move_to_list']) && count($returnResponse['email_move_to_list']) > 0 ) {

            $myEmailsMoveToList = $returnResponse['email_move_to_list'];

        }

        if(isset($returnResponse['email_template_list']) && is_array($returnResponse['email_template_list']) && count($returnResponse['email_template_list']) > 0 ) {

            $emailTemplateList = $returnResponse['email_template_list'];

        }

		$redirectTo = __("dashboard.dashboard_url");

        // $redirectToDashboard = isset($returnResponse['redirectToDashboard'])?'true':'false';

        $currentRoute = __("job.dashboard_label");

        $eventCalendarUrl = route(__("dashboard.user_event_calendar_url"));

        $userEventCalendarUpdateUrl = route(__("dashboard.user_event_calendar_update_url"));

        $memberJobCountUrl = route(__("dashboard.user_job_count_url"));

        $membersListUrl = route(__("dashboard.member_list_url"));

        $emailRatingUrl = route(__("dashboard.email_rating_url"));

        $checkListUrl = route(__("job.check_list_url"));
        $checkListAddUrl = route(__("job.check_list_add_url"));
        $checkListEditUrl = route(__("job.check_list_edit_url"), "");
        $checkListDeleteUrl = route(__("job.check_list_delete_url"));

        $myTaskListUrl = route(__("job.my_task_list_url"));
        $draftTaskListUrl = route(__("job.draft_task_list_url"));
        $openTaskListUrl = route(__("job.open_task_list_url"));
        $taskAddUrl = route(__("job.task_add_url"));
        $taskEditUrl = route(__("job.task_edit_url"), "");
        $taskDeleteUrl = route(__("job.task_delete_url"));
        $taskCalendarUrl = route(__("job.task_calendar_url"));

        $myEmailListUrl = route(__("job.email_list_url"));
        $emailCategoryMoveToUrl = route(__("job.email_move_to_url"));

        $emailRuleListUrl = route(__("dashboard.email_rules_list_url"));

        $emailTemplateListUrl = route(__("job.email_templates_list_url"));

        $emailSendUrl      = route(__("job.email_send_url"));
		$draftemailSendUrl = route(__("job.draftemail_send_url"));
        $emailGetUrl = route(__("job.email_get_url"));
        $emailStatusUpdateUrl = route(__("job.email_status_update_url"));
		$getEmailid   = route(__("job.get_email_id"));

        $nonBusinessEmailListUrl = route(__("job.email_list_url"));

		$signatureUpdateUrl      = route(__("job.signature_update"));
		$getSignatureUrl         = route(__("job.get_signature"));

        $queryListUrl = route(__("job.query_list_url"));
        // $myQueriesListUrl = route(__("job.my_queries_list_url"));
        // $draftQueriesListUrl = route(__("job.draft_queries_list_url"));
        // $openQueriesListUrl = route(__("job.open_queries_list_url"));
        // $queryAddUrl = route(__("job.query_add_url"));
        // $queryEditUrl = route(__("job.query_edit_url"), "");
        // $queryDeleteUrl = route(__("job.query_delete_url"));

        // $checkListAddUrl = "";
        // $checkListEditUrl = "";
        // $checkListDeleteUrl = "";

        // $taskListUrl = "";
        // $taskAddUrl = "";
        // $taskEditUrl = "";
        // $taskDeleteUrl = "";

    ?>
    <!-- Row -->
    {{-- <div class="row" id="job-list-data" data-dashboard-job-stage="{{ $_session['data_dashboard_job_stage'] }}"
    data-dashboard-job-status="{{ $_session['data_dashboard_job_status'] }}" > --}}

    {{-- <div class="row" id="job-list-data" data-dashboard-job-stage="{{ Session::get('data_dashboard_job_stage') }}"
    data-dashboard-job-status="{{ Session::get('data_dashboard_job_status') }}"
    data-job-list-url="{{ route('job-list') }}" data-job-detail-base-url="{{ route('job') }}"
    data-redirect-to-dashboard="{{ $redirectToDashboard }}"> --}}

    <div id="job-list-data"
        data-type="dashboard"
        data-dashboard-job-stage="{{ Session::get('data_dashboard_job_stage') }}"
        data-dashboard-job-status="{{ Session::get('data_dashboard_job_status') }}"
        data-job-list-url="{{ route('job-list') }}" data-delayed-job-list-url="{{ route('delayed-job-list') }}" data-job-detail-base-url="{{ route('job') }}"
        data-redirect-to-dashboard="{{ $redirectToDashboard }}"
        data-email-category-move-to-url="{{ $emailCategoryMoveToUrl }}">

        <!-- Row -->
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="panel card-view pt-5">
                    <div id="" class="panel-wrapper collapse in">
                        <div class="panel-body pt-0 pmbottype" data-pmbottype="non_pmbot">

                            <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                @include('pages.dashboard.dashboardJobOverview')

                            <?php } ?>

                            @include('pages.dashboard.dashboardTaskOverview')

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
