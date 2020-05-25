@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')

<!-- Main Content -->
<div class="container-fluid pt-25">

    <?php
    
        $selectedStatus = "";

        $taskList = $checklistTasks = $checkListUserRoles = [];

        $globalChecklistStatus = __("job.check_list_enabled_text");
        
        $jobId = $checkListStatus = $createdDate = $jobTitle = $sideBlockTitle = "";
        
        $redirectTo = $checkListId = $title = $taskTitleLink = $attachmentPath = "";

        $stage = $task = $location = $tasksRequired = $checkListTaskView = "";

        $checklistTask = "false";

        $checklistCategory = "task";
        
        $title = __('job.check_list_detail_label');
        
        $viewUrl = $postUrl = $mediaPostUrl = $checkListAddUrl = $checkListDeleteUrl = $checkListTaskUrl = $checkListJobUrl = '#';

        $redirectTo = route(__("dashboard.dashboard_url"));
        
        $postUrl = route(__("job.check_list_update_url"));

        $checkListAddUrl = route(__("job.check_list_add_url"));

        if(isset($returnData['task_list']) && is_array($returnData['task_list']) && count($returnData['task_list']) > 0) {

            $taskList = $returnData['task_list'];

            $tasksRequired = "required";

        }
        
        if(isset($returnData["data"]) && $returnData["data"]) {

            $checkListUserRoles = config('constants.jobCheckListAddUserRoles');
        
            if(isset($returnData["data"]["c_id"]) && $returnData["data"]["c_id"]) {
            
                $checkListId = $returnData["data"]["c_id"];
                
                $viewUrl = route(__("job.check_list_view_url"), $checkListId);

                $checkListDeleteUrl = route(__("job.check_list_delete_url")) . "?c_id=" . $checkListId;
            
            }
            
            if(isset($returnData["data"]["stage"]) && $returnData["data"]["stage"]) {
            
                $stage = $returnData["data"]["stage"];

                if(isset($returnData["stage_list"]) && $returnData["stage_list"] != "") {
                
                    $stagePosition = array_search($stage, array_keys($returnData["stage_list"]));
                    
                    $returnData["stage_list"] = array_slice($returnData["stage_list"], $stagePosition);
                
                }

            }

            if(isset($returnData["data"]["task_list"]) && $returnData["data"]["task_list"]) {
            
                $checklistTasks = $returnData["data"]["task_list"];
                
                $checklistTask = "true";

            }

            if(isset($returnData["data"]["checkListTaskView"]) && $returnData["data"]["checkListTaskView"]) {
            
                $checkListTaskView = $returnData["data"]["checkListTaskView"];
            
            }

            if(isset($returnData["data"]["t_id"]) && $returnData["data"]["t_id"]) {
            
                $task = $returnData["data"]["t_id"];

                $checkListTaskUrl = route(__('job.job_detail_url'), $task);
            
            }

            if(isset($returnData["data"]["location"]) && $returnData["data"]["location"]) {
            
                $location = $returnData["data"]["location"];

                $checkListUserRoles = config('constants.globalCheckListAddUserRoles');
            
            }

            if(isset($returnData["data"]["type"])) {
                
                if($returnData["data"]["type"] == "task") {

                    $checklistCategory = "task";
            
                    $sideBlockTitle = __("job.checklist_task_block_title");
                }

                if($returnData["data"]["type"] == "email") {

                    $checklistCategory = "email";
            
                    $sideBlockTitle = __("job.checklist_email_block_title");
                }
            
            }
        
            if(isset($returnData["data"]["status"])) {
            
                $selectedStatus = $returnData["data"]["status"];

                if($selectedStatus == "0") {
                    
                    $globalChecklistStatus = __("job.check_list_disabled_text");;
                
                }
            
            }

            if(isset($returnData["data"]["created_date"]) && $returnData["data"]["created_date"]) {
            
                $createdDate = $returnData["data"]["created_date"];
            
            }

            if(isset($returnData["data"]["task_title_link"]) && $returnData["data"]["task_title_link"]) {
            
                $taskTitleLink = $returnData["data"]["task_title_link"];
            
            }

            if(isset($returnData["data"]["attachment_path"]) && $returnData["data"]["attachment_path"]) {
            
                $attachmentPath = $returnData["data"]["attachment_path"];
            
            }

            if(isset($returnData["data"]["job_id"]) && $returnData["data"]["job_id"]) {

                $jobId = $returnData["data"]["job_id"];

                $checkListAddUrl = $checkListAddUrl . "?type=job&job_id=" . $jobId . "&redirectTo=" . __('job.job_detail_url');

                $checkListDeleteUrl = $checkListDeleteUrl . "&job_id=" . $jobId;

                if(isset($returnData["job_list"]) && $returnData["job_list"]) {

                    if(isset($returnData["job_list"][$jobId]) && $returnData["job_list"][$jobId]) {

                        $checkListJobUrl = route(__('job.job_detail_url'), $jobId);

                        $jobTitle = $returnData["job_list"][$jobId];

                    }

                }

                if(isset($returnData["data"]["status"]) && $returnData["data"]["status"]) {
            
                    $checkListStatus = $returnData["data"]["status"];

                    $selectedStatus = $checkListStatus;
                
                }
                

            } else {

                $checkListAddUrl = $checkListAddUrl . "?type=global&redirectTo=" . __('dashboard.dashboard_url');

            }

            if (isset($returnData["redirectTo"]) && $returnData["redirectTo"] == __("job.job_detail_url") && $jobId) {

                $redirectTo = route($returnData["redirectTo"], $jobId);

                $checkListAddUrl = $checkListAddUrl . "&redirectTo=" . $returnData["redirectTo"];

            }

            if($checklistCategory) {

                $checkListAddUrl = $checkListAddUrl . "&category=" . $checklistCategory;
                
            }
        
        }
    
    ?>
    
    @include('pages.job.checkList.detail')

</div>
<!-- /Main Content -->
@endsection