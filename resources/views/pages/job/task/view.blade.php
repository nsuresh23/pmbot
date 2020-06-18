@extends('layouts.default')

@push('css')
<!-- Bootstrap Dropzone CSS -->
<link href="{{ asset('public/js/custom/vendors/bower_components/dropzone/dist/dropzone.css') }}" rel="stylesheet"
    type="text/css" />
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')

<!-- Main Content -->
<div class="container-fluid pt-25">

    <?php

    $descriptionDisabledClass = $attachmentPathDisabledClass = $selectedFollowupDate = $taskEmailTitleLink = "";
    $selectedParent = $selectedStage = $selectedStatus = $selectedCreatedUser = $checkListAddUrl = "";
    $createdDate = $checkField = $disabled = $disabledClass = $selectedCategory = $taskCustomUrl = "";
    $selectedJobId = $statusDisplayBlock = $statusDisplayBlockOffset = $multiTask = $taskDetailLabel = "";
    $jobId = $createdByStatus = $assignedToStatus = $assignedToEmpcode = $subTaskUsers = $taskCheckListView = "";
    $selectedAssignedUser = $subTaskUsers = $required = $checkFormButton = $previousAssignedUser = $taskTitle = "";
    $createdByEmpcode = $taskId = $followupDate = $reminderDate = $followupCount = $taskType = $taskDescription = "";
    $commomDesc = $assignees = $assignessDescriptionView = $partialComplete = $taskStatus = $previousPartialcomplete = "";

    $stageDisabledClass = $statusDisabledClass = $categoryDisabledClass = $assigneeDisabledClass = $multipleTaskAssigneeDisabledClass = $titleDisabledClass = $additionalNoteDisabledClass = "";

    $jobUrl = "";

    $jobTitle = "-";

    $taskCategoryFollowupTime = [];

    $disabled = "disabled";

    $taskChecklist = "false";

    $disabledClass = "disabled-block";

    $viewUrl = $taskEditUrl = $taskDeleteUrl = $taskAddUrl = $taskFollowupDateUpdateUrl = '#';

    $redirectTo = route(__("dashboard.dashboard_url"));

    $notePostUrl = route(__("job.task_note_store_url"));

    $mediaPostUrl = route(__("job.task_media_store_url"));

    $postUrl = route(__("job.task_update_url"));

    $taskAddUrl = route(__("job.task_add_url"));

    $checkListAddUrl = route(__("job.check_list_add_url"));

    $noteTitle = __('job.task_note_add_label');

    if(isset($returnData["category_followup_time"]) && is_array($returnData["category_followup_time"]) && count($returnData["category_followup_time"]) > 0){

        $taskCategoryFollowupTime = $returnData["category_followup_time"];

    }

    if (isset($returnData["data"]) && $returnData["data"]) {

        if (isset($returnData["data"]["task_id"]) && $returnData["data"]["task_id"]) {

            $taskId = $returnData["data"]["task_id"];

            $viewUrl = route(__("job.task_view_url"), $taskId);

            $taskEditUrl = route(__("job.task_edit_url"), $taskId);
            // $taskDeleteUrl = route(__("job.task_delete_url")) . "?task_id=" . $taskId . "&redirectTo=" ;
            $taskDeleteUrl = route(__("job.task_delete_url")) . "?task_id=" . $taskId;

            $checkListAddUrl = $checkListAddUrl . "?task_id=" . $taskId . "&category=task";

            $updateUrl = route(__("job.task_field_update_url"));
        }

        if (isset($returnData["data"]["job_id"]) && $returnData["data"]["job_id"]) {

            $jobId = $returnData["data"]["job_id"];

            $jobUrl = route(__('job.job_detail_url'), $jobId);

            $taskAddUrl = $taskAddUrl . "?job_id=" . $jobId . "&type=job" . "&redirectTo=" . __('job.job_detail_url');

            $checkListAddUrl = $checkListAddUrl . "&type=job" . "&job_id=" . $jobId . "&redirectTo=" . __('job.job_detail_url');

            if (isset($returnData["redirectTo"]) && $returnData["redirectTo"] && $jobId) {

                $redirectTo = route($returnData["redirectTo"], $jobId);
            }
        }

        if (isset($returnData["data"]["job_title"]) && $returnData["data"]["job_title"]) {

            $jobTitle = $returnData["data"]["job_title"];
        }

        if (isset($returnData["data"]["title"]) && $returnData["data"]["title"]) {

            $taskTitle = $returnData["data"]["title"];
        }

        if (isset($returnData["data"]["type"])) {

            $taskType = $returnData["data"]["type"];

            if($returnData["data"]["type"] == __("job.task_text")) {

                $taskDetailLabel = __('job.task_label');

            }

            if($returnData["data"]["type"] == __("job.task_inhouse_query_text")) {

                $taskDetailLabel = __('job.query_label');

            }

        }

        if (isset($returnData["data"]["description"]) && $returnData["data"]["description"]) {

            $taskDescription = $returnData["data"]["description"];

        }

        if (isset($returnData["data"]["parent_description"]) && $returnData["data"]["parent_description"]) {

            $commomDesc = $returnData["data"]["parent_description"];
        }

        if (isset($returnData["data"]["custom_url"]) && $returnData["data"]["custom_url"]) {

            $taskCustomUrl = $returnData["data"]["custom_url"];

        }


        if (isset($returnData["data"]["taskCheckListView"]) && $returnData["data"]["taskCheckListView"]) {

            if(in_array(auth()->user()->role, Config::get("constants.nonStakeHolderUserRoles"))) {

                $taskCheckListView = $returnData["data"]["taskCheckListView"];

                $taskChecklist = "true";

            }

        }


        if (isset($returnData["data"]["assingees"]) && $returnData["data"]["assingees"]) {

            $assignees = $returnData["data"]["assingees"];

            $subTaskUsers = json_encode($assignees);

            $multiTask = "true";
        }

        if (isset($returnData["data"]["assignessDescriptionView"]) && $returnData["data"]["assignessDescriptionView"]) {

            $assignessDescriptionView = $returnData["data"]["assignessDescriptionView"];
        }

        if (isset($returnData["data"]["followup_date"]) && $returnData["data"]["followup_date"]) {

            $followupDate = $returnData["data"]["followup_date"];

            $selectedFollowupDate = $returnData["data"]["followup_date"];

        }

        if (isset($returnData["data"]["reminder_date"]) && $returnData["data"]["reminder_date"]) {

            $reminderDate = $returnData["data"]["reminder_date"];
        }

        if (isset($returnData["data"]["followup_count"]) && $returnData["data"]["followup_count"]) {

            $followupCount = $returnData["data"]["followup_count"];
        }

        if (isset($returnData["data"]["category"]) && $returnData["data"]["category"]) {

            $selectedCategory = $returnData["data"]["category"];
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

        if (isset($returnData["data"]["created_date"]) && $returnData["data"]["created_date"]) {

            $createdDate = $returnData["data"]["created_date"];
        }

        if (isset($returnData["data"]["status"]) && $returnData["data"]["status"]) {

            $selectedStatus = $returnData["data"]["status"];

            $taskStatus = $selectedStatus;
        }

        if (isset($returnData["data"]["createdby_status"]) && $returnData["data"]["createdby_status"]) {

            $createdByStatus = $returnData["data"]["createdby_status"];

            // $selectedStatus = $createdByStatus;

        }

        if (isset($returnData["data"]["assignedto_status"]) && $returnData["data"]["assignedto_status"]) {

            $assignedToStatus = $returnData["data"]["assignedto_status"];
        }

        if (isset($returnData["data"]["createdby_empcode"]) && $returnData["data"]["createdby_empcode"]) {

            $createdByEmpcode = $returnData["data"]["createdby_empcode"];

            $selectedCreatedUser = $createdByEmpcode;
        }

        if (isset($returnData["data"]["createdby_empname"]) && $returnData["data"]["createdby_empname"]) {

            $createdByEmpname = $returnData["data"]["createdby_empname"];
        }

        if(isset($returnData["data"]["createdby_type"]) && $returnData["data"]["createdby_type"] == __("job.task_createdby_bot_text")) {

            $stageDisabledClass = "disabled-block";

        }

        if (isset($returnData["data"]["assignedto_empname"]) && $returnData["data"]["assignedto_empname"]) {

            $assignedToEmpname = $returnData["data"]["assignedto_empname"];
        }

        if (isset($returnData["data"]["partialcomplete"]) && $returnData["data"]["partialcomplete"]) {

            $partialComplete = $returnData["data"]["partialcomplete"];

            $previousPartialcomplete = $returnData["data"]["partialcomplete"];
        }

        if (isset($returnData["data"]["assignedto_empcode"]) && $returnData["data"]["assignedto_empcode"]) {

            $assignedToEmpcode = $returnData["data"]["assignedto_empcode"];

            $selectedAssignedUser = $assignedToEmpcode;

            $previousAssignedUser = $assignedToEmpcode;


            // if($selectedAssignedUser == auth()->user()->empcode) {

                //     $selectedStatus = $assignedToStatus;

                // }

            }

            if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles')) && $taskType == __("job.task_inhouse_query_text")) {

                // $stageDisabledClass = "disabled-block";
                // $statusDisabledClass = "disabled-block";
                // $categoryDisabledClass = "disabled-block";
                // $assigneeDisabledClass = "disabled-block";
                $multipleTaskAssigneeDisabledClass = "disabled-block";
                // $titleDisabledClass = "disabled-block";
                // $descriptionDisabledClass = "disabled-block";
                // $attachmentPathDisabledClass = "disabled-block";

                if(isset($returnData["status_list"]) && is_array($returnData["status_list"]) && count($returnData["status_list"]) > 0 ) {

                    unset($returnData["status_list"][__('job.task_closed_status_text')]);

                }
            }

        }

        if (isset($returnData["data"]["task_email_title_link"]) && $returnData["data"]["task_email_title_link"]) {

            $taskEmailTitleLink = $returnData["data"]["task_email_title_link"];

        }


        $type = __("job.task_detail_label");
        $tableCaption = __("job.sub_task_label");
        $listUrl;
        $addUrl = route(__("job.task_add_url"));
        $editUrl = route(__("job.task_edit_url"), "");
        $taskFollowupDateUpdateUrl = route(__("job.task_followup_date_update_url"));
        $deleteUrl = route(__("job.task_delete_url"));
        $taskCloseUrl = route(__("job.task_close_url"));

        $activitiesTableCaption = __("job.task_activities_label");
        $activitiesListUrl = route(__("job.task_note_list_url"), $taskId);
        // $activitiesAddUrl = route(__("job.task_activities_add_url"));
        $activitiesEditUrl = route(__("job.task_note_edit_url"), "");
        $activitiesDeleteUrl = route(__("job.task_note_delete_url"));

        $activitiesAddUrl = "";
        // $activitiesEditUrl = "";
        // $activitiesDeleteUrl = "";

        ?>

    @include('pages.job.task.detail')
    {{-- @include('pages.job.task.activities') --}}
    {{-- @include('pages.job.task.taskGrid') --}}
    {{-- @include('pages.job.task.note') --}}

</div>
<!-- /Main Content -->
@endsection
