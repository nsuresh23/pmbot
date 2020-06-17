@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')

<?php

    $required = $taskId = "";

    $taskCategoryFollowupTime = [];

    $jobId = $checkField = $checkFormButton = $disabled = $disabledClass = $selectedJobId = $selectedParent = $selectedStage = $selectedStatus = $selectedCreatedUser = $selectedAssignedUser = "";

    $statusDisplayBlock = $statusDisplayBlockOffset = $subTaskUsers = $previousAssignedUser = $partialComplete = $previousPartialcomplete = $selectedFollowupDate = "";

    $stageDisabledClass = $statusDisabledClass = $categoryDisabledClass = $assigneeDisabledClass = $multipleTaskAssigneeDisabledClass = $titleDisabledClass = $descriptionDisabledClass = $attachmentPathDisabledClass = $additionalNoteDisabledClass = "";

    $selectedCategory = "medium";

    $redirectTo = route(__("dashboard.dashboard_url"));

    $taskDeleteUrl = "#";

    $mediaPostUrl = route(__("job.task_media_store_url"));

    $title = __('job.task_edit_label');

    $postUrl = route(__("job.task_update_url"));

    $disabled = "disabled";

    $disabledClass = "disabled-block";

    $statusDisplayBlock = "true";

    $statusDisplayBlockOffset = "col-md-offset-1";

    $checkField = "checkField";

    $checkFormButton = "checkFormButton";

    if(isset($returnData["job_id"]) && $returnData["job_id"]) {

        $jobId = $returnData["job_id"];

        $selectedJobId = $returnData["job_id"];

    }

    if(isset($returnData["stage"]) && $returnData["stage"]) {

        $selectedStage = $returnData["stage"];

    }

    if(isset($returnData['type']) && $returnData['type'] == "detail") {

    $required = "required";

    }

    if(isset($returnData["data"]) && $returnData["data"]) {

        if(isset($returnData["data"]["task_id"]) && $returnData["data"]["task_id"]) {

            $taskId = $returnData["data"]["task_id"];

            $taskDeleteUrl = route(__("job.task_delete_url")). "?task_id=" . $taskId;

        }

        if(isset($returnData["data"]["category"]) && $returnData["data"]["category"]) {

            $selectedCategory = $returnData["data"]["category"];

            $selectedFollowupDate = date('Y-m-d H:i:s');

            if(isset($returnData["category_followup_time"]) && is_array($returnData["category_followup_time"]) && count($returnData["category_followup_time"]) > 0){

                $taskCategoryFollowupTime = $returnData["category_followup_time"];

                if(isset($taskCategoryFollowupTime[$selectedCategory]) && $taskCategoryFollowupTime[$selectedCategory] != "") {

                    $selectedFollowupDate = date("Y-m-d H:i:s", strtotime("+" . $taskCategoryFollowupTime[$selectedCategory] . " hour", strtotime(date("Y-m-d H:i:s"))));

                }
            }

        }

        if(isset($returnData["data"]["job_id"]) && $returnData["data"]["job_id"]) {

            $selectedJobId = $returnData["data"]["job_id"];

            $jobId = $selectedJobId;

        }

        if(isset($returnData["data"]["parent_task_id"]) && $returnData["data"]["parent_task_id"]) {

            $selectedParent = $returnData["data"]["parent_task_id"];

        }

        if(isset($returnData["data"]["stage"]) && $returnData["data"]["stage"]) {

            $selectedStage = $returnData["data"]["stage"];

            if(isset($returnData["stage_list"]) && $returnData["stage_list"] != "") {

                $stagePosition = array_search($selectedStage, array_keys($returnData["stage_list"]));

                $returnData["stage_list"] = array_slice($returnData["stage_list"], $stagePosition);

            }

        }

        if(isset($returnData["data"]["status"]) && $returnData["data"]["status"]) {

            $selectedStatus = $returnData["data"]["status"];

        }

        if(isset($returnData["data"]["createdby_empcode"]) && $returnData["data"]["createdby_empcode"]) {

            $selectedCreatedUser = $returnData["data"]["createdby_empcode"];

        }

        if(isset($returnData["data"]["createdby_type"]) && $returnData["data"]["createdby_type"] == __("job.task_createdby_bot_text")) {

            $stageDisabledClass = "disabled-block";

        }

        if(isset($returnData["data"]["assignedto_empcode"]) && $returnData["data"]["assignedto_empcode"]) {

            $selectedAssignedUser = $returnData["data"]["assignedto_empcode"];

            $previousAssignedUser = $returnData["data"]["assignedto_empcode"];

        }

        if(isset($returnData["data"]["assingees"]) && $returnData["data"]["assingees"]) {

            $subTaskUsers = json_encode($returnData["data"]["assingees"]);

        }

        if(isset($returnData["data"]["partialcomplete"]) && $returnData["data"]["partialcomplete"] != "") {

            $partialComplete = $returnData["data"]["partialcomplete"];

            $previousPartialcomplete = $returnData["data"]["partialcomplete"];

        }

    }

    if(isset($returnData["redirectTo"]) && $returnData["redirectTo"] == "job-detail" && $jobId) {

        $redirectTo = route($returnData["redirectTo"], $jobId);

    }

?>

<!-- Main Content -->
<div class="container-fluid pt-25">

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

                        <?php if($taskId != "") { ?>

                        <div class="pull-left inline-block mr-15 footable-filtering">
                            <a class="btn btn-danger btn-outline btn-icon right-icon task-delete" type="button"
                                href="{{$taskDeleteUrl ?? '#'}}">
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

                        @include('pages.job.task.taskEditForm')

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- /Main Content -->
@endsection
