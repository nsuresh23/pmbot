<!-- Main Content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <!-- Row -->
    <div class="row" id="taskView" data-url="{{ $viewUrl }}">
        <div class="panel panel-default card-view mb-0">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark capitalize-font">
                        <i
                            class="zmdi zmdi-collection-text mr-10"></i>{{ $taskDetailLabel . ": #" }}{{$returnData['data']['task_no']  ?? ''}}
                    </h6>

                    {{-- <button class="btn btn-warning countdown" data-toggle="popover-x" data-target="#followupdate"
                        data-placement="right">2020-04-30 15:04:35</button> --}}

                    {{-- <a href="#" class="btn btn-large btn-primary" rel="popover" data-content='
                    <div class="input-group date datetimepicker">
                    <input type="text" name="followup_date" value="{{$followupDate  ?? ''}}" class="form-control">
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-anim">
                            <i class="icon-rocket"></i>
                            <span class="btn-text">submit</span></button>
                    </span>
                </div>
                ' data-placement="top" data-original-title="Follow up date and time"><span class="countdown">2020-04-30
                    15:04:35</span></a> --}}

                <?php if($followupDate) { ?>
                <a class="" href="#" data-toggle="popover-x" data-target="#followupdate" data-placement="right">
                    <span class="countdown txt-warning">{{$followupDate  ?? ''}}</span>
                    <span class="fa fa-pencil pl-5"></span></a>
                <?php } ?>
            </div>
            <div class="pull-right">

                <?php if($jobUrl) { ?>
                
                    <div class="pull-left inline-block mr-15 footable-filtering">
                        <a class="btn btn-warning btn-outline btn-icon right-icon" type="button" target="_blank" href="{{$jobUrl ?? '#'}}">
                            {{__('job.task_job_info_button_label')}}
                            <i class="ti-new-window font-15"></i>
                        </a>
                    </div>
                
                <?php } ?>

                <div class="pull-left inline-block mr-15 footable-filtering">
                    <a class="btn btn-primary btn-outline task-details-tab" type="button" data-toggle="collapse"
                        href="#task-details" aria-expanded="false"
                        aria-controls="collapseExample">{{__('job.task_info_label')}}</a>
                </div>

                <?php

                    // if ((in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles')) && $taskType == __("job.task_text")) || (!in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles')) && $taskType == __("job.task_inhouse_query_text"))) {
                    if ((in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) || (!in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles')) && $taskType == __("job.task_inhouse_query_text"))) {

                    ?>

                <div class="pull-left inline-block mr-15 footable-filtering">
                    <a class="btn btn-warning btn-outline btn-icon right-icon" type="button"
                        href="{{$taskAddUrl ?? '#'}}">
                        {{__('job.task_add_button_label')}}
                        <i class="fa fa-plus font-15"></i>
                    </a>
                </div>

                <div class="pull-left inline-block mr-15 footable-filtering">
                    <a class="btn btn-warning btn-outline btn-icon right-icon task-edit" type="button">
                        {{__('job.task_edit_button_label')}}
                        <i class="fa fa-pencil font-15"></i>
                    </a>
                </div>

                <?php if($taskStatus != __("job.task_closed_status_text")) { ?>

                <div class="pull-left inline-block mr-15 footable-filtering">
                    <a class="btn btn-danger btn-outline btn-icon right-icon task-delete" type="button"
                        href="{{$taskDeleteUrl ?? '#'}}">
                        {{__('job.task_delete_button_label')}}
                        <i class="fa fa-trash font-15"></i>
                    </a>
                </div>

                <?php } ?>

                <?php

                                    }

                                    ?>
                <div class="pull-left inline-block mr-15 footable-filtering">
                    <form id="taskViewSearchForm" class="form-inline">
                        <div class="form-group">
                            <label class="sr-only">{{ __('job.task_search_label') }}</label>
                            <div class="input-group">
                                <input type="text" id="taskViewSearchInput" class="form-control" placeholder="Search">
                                <div id="taskViewSearch"
                                    data-task-view-base-url="{{ route(__('job.task_search_url'), '') }}"
                                    class="input-group-btn">
                                    <span type="button" class="btn btn-primary">
                                        <span class="fooicon fooicon-search"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <a class="pull-left inline-block mr-15" data-toggle="collapse" href="#task_detail_collapse"
                    aria-expanded="true">
                    <i class="zmdi zmdi-chevron-down job-status-i"></i>
                    <i class="zmdi zmdi-chevron-up job-status-i"></i>
                </a>
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
        <div class="clearfix"></div>
    </div>
    <div class="row panel-wrapper collapse in">
        <div id="task_detail_collapse" class="readonly-block">
            <div class="panel-body pa-0 pl-5">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <?php if($taskChecklist == "true") { ?>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 pt-0 pl-5 pr-5 task-detail-block">
                            <?php } else { ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-0 pl-5 pr-5 task-detail-block">
                                <?php } ?>

                                <div class="pills-struct pt-2">
                                    <ul role="tablist" class="nav nav-pills nav-pills-outline" id="">
                                        <li class="active ml-0" role="presentation">
                                            <a id="taskDetailTab" class="pa-5" href="#taskDetailTabContent"
                                                data-toggle="tab" role="tab"
                                                aria-expanded="true">{{ __("job.task_details_tab_label") }}</a>
                                        </li>
                                        <li role="presentation" class="ml-0">
                                            <a id="taskDiaryTab" class="pa-5" href="#taskDiaryTabContent"
                                                data-task-history-url="{{ route(__('job.task_history_url'), $taskId) }}"
                                                data-toggle="tab" role="tab"
                                                aria-expanded="false">{{ __("job.task_diary_tab_label") }}</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="">
                                        <div id="taskDetailTabContent" class="tab-pane fade active in pt-10"
                                            role="tabpanel">

                                            <div class="">
                                                <div class="row">
                                                    <div class="collapse" id="task-details">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="row">
                                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="control-label text-left">{{ __('job.task_stage_label') }}:</label>
                                                                        <span class="ml-20">
                                                                            {{$returnData['data']['stage']   ?? '-'}}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="control-label text-left">{{ __('job.task_job_id_label') }}:</label>
                                                                        <span class="ml-20">
                                                                            {{$returnData['data']['order_id']   ?? '-'}}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="control-label text-left">{{ __('job.task_job_title_label') }}:</label>
                                                                        <span class="ml-20">
                                                                            {{$jobTitle   ?? '-'}}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="row">
                                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                    <label
                                                                        class="control-label text-left">{{ __('job.task_status_label') }}:</label>
                                                                    <span class="ml-20">
                                                                        {{$taskStatus   ?? '-'}}
                                                                    </span>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                    <label
                                                                        class="control-label text-left">{{ __('job.task_category_label') }}:</label>
                                                                    <span class="ml-20">
                                                                        {{$returnData['data']['category']   ?? '-'}}
                                                                    </span>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                    <label
                                                                        class="control-label text-left">{{ __('job.task_assigned_to_label') }}:</label>
                                                                    <span class="ml-20">
                                                                        {{$returnData['data']['assignedto_empname']   ?? '-'}}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="row">
                                                                <hr class="light-grey-hr mt-0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if($taskTitle) {

                                                            $taskTitleClass = "col-lg-12 col-md-12 col-sm-12 col-xs-12";

                                                            if($taskEmailTitleLink) {

                                                                $taskTitleClass = "col-lg-6 col-md-6 col-sm-12 col-xs-12";

                                                            }

                                                        ?>

                                                    <div class="{{$taskTitleClass}}">
                                                        <label for="title" class="control-label text-left">
                                                            {{$taskTitle   ?? '-'}}
                                                        </label>
                                                    </div>

                                                    <?php if($taskEmailTitleLink) { ?>

                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <label
                                                            class="control-label text-left">{{ __('job.task_associated_email_label') }}:</label>
                                                        <?php echo $taskEmailTitleLink ?>
                                                        {{-- <span class="ml-20">
                                                                    {{$taskEmailTitleLink   ?? '-'}}
                                                        </span> --}}
                                                    </div>

                                                    <?php } ?>

                                                    <?php if($createdDate) { ?>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <p class="mb-10 font-italic">
                                                            Added by
                                                            <span class="weight-500 capitalize-font txt-primary">
                                                                <span
                                                                    class="pl-5">{{$returnData['data']['createdby_empname']   ?? '-'}}</span>
                                                            </span>
                                                            at
                                                            <span>
                                                                {{date('g:ia \o\n l jS F Y',strtotime($createdDate))}}
                                                            </span>
                                                        </p>
                                                    </div>

                                                    <?php } ?>

                                                    <?php } ?>
                                                    <?php if($taskCustomUrl) { ?>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <label
                                                            class="control-label">{{ __('job.task_custom_url_label') }}:</label>
                                                        <p>
                                                            <a class="" type="button"
                                                                href="{{$taskCustomUrl}}">{{$taskCustomUrl}}</a>
                                                        </p>
                                                    </div>

                                                    <?php } ?>
                                                    <div class="table-wrap">

                                                        <?php if ($assignees == "") { ?>

                                                        <?php if ($commomDesc != "") { ?>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <label
                                                                class="control-label">{{ __('job.task_common_description_field_label') }}:</label>
                                                            <p id="task-common-description-view" class=""
                                                                data-value="{{$commomDesc  ?? ''}}">
                                                            </p>
                                                        </div>

                                                        <?php } ?>

                                                        <?php if($taskDescription) { ?>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <label
                                                                class="control-label">{{ __('job.task_description_label') }}:</label>
                                                            <p id="task-description-view" class=""
                                                                data-value="{{$returnData['data']['description']  ?? ''}}">
                                                            </p>
                                                        </div>

                                                        <?php } ?>

                                                        <?php } else { ?>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <label
                                                                class="control-label">{{ __('job.task_description_label') }}:</label>
                                                            <p id="task-description-view" class=""
                                                                data-value="{{$assignessDescriptionView  ?? ''}}">
                                                            </p>
                                                        </div>

                                                        <?php } ?>

                                                        <div
                                                            class="col-lg-12 col-md-12 col-sm-12 col-xs-12 taskActivitiesDiv">
                                                            <div class="taskActivitiesScrollBlock">
                                                                <div class="taskActivities task-note-activies-bg"
                                                                    data-multi-task="{{$multiTask}}"
                                                                    data-task-id="{{$taskId}}"
                                                                    data-task-status="{{$taskStatus}}"
                                                                    data-task-closed-text="{{__('job.task_closed_status_text')}}"
                                                                    data-created-empcode="{{ $createdByEmpcode }}"
                                                                    data-current-empcode="{{ auth()->user()->empcode }}"
                                                                    data-list-url="{{ $activitiesListUrl }}"
                                                                    data-common-list-url="{{ $activitiesListUrl }}"
                                                                    data-add-url="{{ $activitiesAddUrl }}"
                                                                    data-edit-url="{{ $activitiesEditUrl }}"
                                                                    data-delete-url="{{ $activitiesDeleteUrl }}"
                                                                    data-task-close-url="{{ $taskCloseUrl }}"
                                                                    data-current-route="{{ Route::currentRouteName() }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <hr class="light-grey-hr">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hiddenBlock pt-5 form-block collapse"
                                                    id="noteReply">
                                                    <div class="form-wrap">
                                                        <form id="taskNoteViewForm" class="taskNoteForm"
                                                            data-toggle="validator" role="form"
                                                            action="{{ $notePostUrl ?? '#'}}" method="POST">
                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <input type="hidden" name="_token"
                                                                        value="{{ csrf_token() }}">
                                                                    <input type="hidden" id="noteReplyTaskId"
                                                                        name="task_id" value="{{ $taskId  ?? ''}}">
                                                                    <input type="hidden" id="jobId" name="job_id"
                                                                        value="{{ $jobId  ?? ''}}">
                                                                    <input type="hidden" id="title" name="title"
                                                                        value="{{ $taskTitle  ?? ''}}">
                                                                    <input type="hidden" name="redirectTo"
                                                                        value="dashboard">
                                                                    <input type="hidden" name="status_previous"
                                                                        value="{{ $taskStatus  ?? ''}}">
                                                                    <input type="hidden" name="createdby_empcode"
                                                                        value="{{ $createdByEmpcode  ?? ''}}">
                                                                    <input type="hidden" name="assignedto_empcode"
                                                                        value="{{ $assignedToEmpcode  ?? ''}}">
                                                                    <input type="hidden" name="createdby_status"
                                                                        value="{{ $createdByStatus  ?? ''}}">
                                                                    <input type="hidden" name="assignedto_status"
                                                                        value="{{ $assignedToStatus  ?? ''}}">
                                                                    <input type="hidden" id="view_id" name="id">
                                                                    <div
                                                                        class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="task-note"
                                                                                class="control-label mb-10">{{ __('job.task_note_label') }}</label>
                                                                            <textarea
                                                                                class="textarea_editor task_note task_additional_note form-control"
                                                                                id="task_additional_note"
                                                                                name="additional_note"
                                                                                value="{{$returnData['data']['note']['additional_note']  ?? ''}}"
                                                                                data-value="{{$returnData['data']['note']['additional_note']  ?? ''}}"
                                                                                placeholder="{{ __('job.task_note_placeholder_text') }}"></textarea>
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label for="attachment"
                                                                                class="control-label mb-10">{{ __('job.task_attachment_label') }}</label>
                                                                            <input type="text" class="form-control"
                                                                                id="attachment_path"
                                                                                name="attachment_path"
                                                                                {{-- value="{{$returnData['data']['attachment_path']  ?? ''}}"
                                                                                --}}
                                                                                placeholder="{{ __('job.task_attachment_placeholder_text') }}"
                                                                                data-error="{{ __('job.task_attachment_error_msg') }}">
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-20 mt-20">
                                                                        <div class="form-group">
                                                                            <div class="pull-right">
                                                                                <button type="submit"
                                                                                    class="btn btn-success btn-anim mr-10 taskNoteFormSubmitButton">
                                                                                    <i
                                                                                        class="fa fa-check font-20"></i><span
                                                                                        class="btn-text font-20">{{ __('job.task_note_submit_button_label') }}</span></button>
                                                                                <a href="javascript:void(0);"
                                                                                    class="btn btn-danger btn-anim note-reply-cancel">
                                                                                    <i class="fa fa-times font-20"></i>
                                                                                    <span class="btn-text font-20">
                                                                                        {{ __('job.task_note_cancel_button_label') }}
                                                                                    </span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <?php
                                                                                                // if ((in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles')) && $taskType == __("job.task_text")) || (!in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles')) && $taskType == __("job.task_inhouse_query_text"))) {
                                                                                                if ((in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) || (!in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles')) && $taskType == __("job.task_inhouse_query_text"))) {
                                                                                            ?>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hiddenBlock form-block collapse"
                                                    id="taskEdit">

                                                    @include('pages.job.task.taskEditForm')

                                                </div>

                                                <?php } ?>
                                            </div>

                                        </div>

                                        <div id="taskDiaryTabContent" class="tab-pane fade pt-5 taskDiaryTabContent"
                                            role="tabpanel">

                                            @include('pages.job.task.taskDiary')

                                        </div>

                                    </div>
                                </div>


                            </div>
                            <?php if($taskChecklist == "true") { ?>
                            <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
                                <div class="panel panel-default card-view">
                                    <div class="panel-heading">
                                        <div class="pull-left">
                                            <h6 class="panel-title txt-dark">check list</h6>
                                        </div>
                                        <div class="pull-right">
                                            {{-- <div class="pull-left inline-block dropdown mr-15">
                                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i
                                                                class="zmdi zmdi-more-vert"></i></a>
                                                        <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply"
                                                                        aria-hidden="true"></i>Edit</a></li>
                                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share"
                                                                        aria-hidden="true"></i>Clear All</a></li>
                                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash"
                                                                        aria-hidden="true"></i>Select All</a></li>
                                                        </ul>
                                                    </div>
                                                    <a class="pull-left inline-block close-panel" href="#" data-effect="fadeOut">
                                                        <i class="zmdi zmdi-close"></i>
                                                    </a> --}}
                                            <?php if (in_array(auth()->user()->role, Config::get('constants.nonStakeHolderUserRoles'))) { ?>

                                            <a class="pull-left inline-block mr-15" href="{{$checkListAddUrl ?? '#'}}">
                                                <i class="zmdi zmdi-plus txt-success job-status-i"></i>
                                            </a>

                                            <?php } ?>

                                            <a href="#" class="pull-left inline-block full-screen">
                                                <i class="zmdi zmdi-fullscreen job-status-i"></i>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row panel-wrapper collapse in">
                                        <div class="task-checklists panel-body pa-0">
                                            <?php
                                                    echo $taskCheckListView;
                                                ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('includes.modals.followup')
<!-- /Row -->
<!-- /Main Content -->
