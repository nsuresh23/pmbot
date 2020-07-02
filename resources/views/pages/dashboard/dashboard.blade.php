@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Main Content -->
<div class="container-fluid pa-5 pt-0">
    <?php

        auth()->user()->members = '1';

        $hasMembers = auth()->user()->members;

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

        $redirectToDashboard = $returnResponse['redirectToDashboard'];

		$redirectTo = __("dashboard.dashboard_url");

        // $redirectToDashboard = isset($returnResponse['redirectToDashboard'])?'true':'false';

        $currentRoute = __("job.dashboard_label");

        $memberJobCountUrl = route(__("dashboard.user_job_count_url"));

        $membersListUrl = route(__("dashboard.member_list_url"));

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

        $myEmailListUrl = route(__("job.email_list_url"));

        $emailSendUrl      = route(__("job.email_send_url"));
		$draftemailSendUrl = route(__("job.draftemail_send_url"));
        $emailGetUrl = route(__("job.email_get_url"));
        $emailStatusUpdateUrl = route(__("job.email_status_update_url"));
		$getEmailid   = route(__("job.get_email_id"));

        $nonBusinessEmailListUrl = route(__("job.email_list_url"));

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
        data-redirect-to-dashboard="{{ $redirectToDashboard }}">

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
