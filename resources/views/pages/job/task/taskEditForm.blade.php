<!-- Main Content -->
<div class="form-wrap mt-10">
    <form class="taskForm taskEditForm" id="taskForm" data-toggle="validator" role="form" action="{{ $postUrl }}" method="POST">
        <div class="form-body">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="attachment_path" id="task_attachment_path_field" />
                <input type='hidden' id="partialcomplete" name='partialcomplete' value='1'>
                <input type='hidden' id="previousPartialcomplete" name='previousPartialcomplete' value='{{$previousPartialcomplete}}'>
                <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />

                <?php if($previousPartialcomplete == "1") { ?>

                    <input type="hidden" name="followup_type" id="followup_type" value="followup" />

                <?php } ?>

                <input type="hidden" id="redirectTo" name="redirectTo" value="{{$returnData['redirectTo'] ?? ''}}">
                <input type="hidden" id="task_id" name="task_id" value="{{$returnData['data']['task_id'] ?? ''}}" />
                <input type="hidden" id="current_job_id" name="current_job_id" value="{{$jobId}}" />

                <input type="hidden" id="checklist" class="checklist" name="checklist" value="" />

                <?php if ($previousAssignedUser != "") { ?>

                    <input type='hidden' id="previous_assigned_user" name='previous_assigned_user' value='{{$previousAssignedUser}}'>

                <?php } ?>

                <?php if ($subTaskUsers != "") { ?>

                    <input type='hidden' id="subTaskUsers" name='subTaskUsers' value='{{$subTaskUsers}}'>

                <?php } ?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 {{$stageDisabledClass}}">
                            <div class="form-group">
                                <label for="stage" class="control-label mb-10">{{ __('job.task_stage_label') }}</label>
                                {!! Form::select('stage', [ null =>
                                __('job.task_stage_placeholder_text') ] +
                                $returnData["stage_list"], $selectedStage,
                                ['class' =>
                                'form-control select2 checkField',
                                'previous_value' => $selectedStage]) !!}
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <?php if($partialComplete != "1") { ?>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 {{$statusDisabledClass}}">
                                <div class="form-group">
                                    <label for="status" class="control-label mb-10">{{ __('job.task_status_label') }}</label>
                                    {!! Form::select('status', [ null =>
                                    __('job.task_status_placeholder_text') ] +
                                    $returnData["status_list"], $selectedStatus,
                                    ['class' =>
                                    'form-control select2 checkField',
                                    'previous_value' => $selectedStatus, 'required'])
                                    !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        <?php } ?>

                        <?php if($previousPartialcomplete != "1") { ?>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 {{$categoryDisabledClass}}">
                                <div class="form-group">
                                    <label for="category" class="control-label mb-10">{{ __('job.task_category_label') }}</label>
                                    {!! Form::select('category', [ null =>
                                    __('job.task_category_placeholder_text') ] +
                                    $returnData["category_list"], $selectedCategory,
                                    ['class' => 'form-control select2 checkField',
                                    'previous_value' => $selectedCategory, 'required'])
                                    !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        <?php } ?>

                        <?php if($previousPartialcomplete == "1") { ?>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 {{$categoryDisabledClass}}">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="category" class="control-label mb-10">{{ __('job.task_category_label') }}</label>
                                            {!! Form::select('category', [ null =>
                                            __('job.task_category_placeholder_text') ] +
                                            $returnData["category_list"], $selectedCategory,
                                            ['class' => 'form-control task_category select2 checkField',
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

                        <?php } ?>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 {{$assigneeDisabledClass}}">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <label for="assignedto_empcode" class="control-label mb-10">{{ __('job.task_assigned_to_label') }}</label>
                                    </div>

                                    <?php // if (($taskId != "" && $subTaskUsers != "") || ($taskId == "")) { ?>

                                    <?php if ($taskId != "") { ?>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-md-offset-2 {{$multipleTaskAssigneeDisabledClass}}">
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
                                ['class' => 'form-control select2 multiple-task-assignee checkField',
                                'previous_value' => $selectedAssignedUser,
                                'data-value' => $subTaskUsers,
                                'required'])
                                !!}
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 {{$titleDisabledClass}}">
                    <div class="form-group">
                        <label for="title" class="control-label mb-10">{{ __('job.task_title_label') }}</label>
                        <input type="text" class="form-control checkField" id="title" name="title" value="{{$returnData['data']['title'] ?? ''}}" placeholder="{{ __('job.task_title_placeholder_text') }}" data-error="{{ __('job.task_title_error_msg') }}" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 {{$descriptionDisabledClass}}">

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
                                    <textarea class="textarea_editor form-control checkField" rows="15" id="task-description" name="description"
                                        value="{{$returnData['data']['description'] ?? ''}}"
                                        data-value="{{$returnData['data']['description'] ?? ''}}"
                                        placeholder="{{ __('job.task_description_placeholder_text') }}"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

                <?php if($partialComplete != "1") { ?>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 {{$additionalNoteDisabledClass}}">
                        <div class="form-group">
                            <label for="additional_note" class="control-label mb-10">{{ __('job.task_additional_note_label') }}</label>
                            <input type="text" class="form-control" id="additional-note" name="additional_note"
                                value=""
                                placeholder="{{ __('job.task_additional_note_placeholder_text') }}">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                <?php } ?>

                <?php // if($partialComplete == "1") { ?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 {{$attachmentPathDisabledClass}}">
                    <div class="form-group">
                        <label for="attachment" class="control-label mb-10">{{ __('job.task_attachment_label') }}</label>
                        <input type="text" class="form-control" id="task_attachment_path" name="attachment_path"
                            value="{{$returnData['data']['attachment_path'] ?? ''}}"
                            placeholder="{{ __('job.task_attachment_placeholder_text') }}"
                            data-error="{{ __('job.task_attachment_error_msg') }}">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <?php // } ?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-30">
                    <span class="pull-right mt-5">

                        <?php if($partialComplete == "1") { ?>

                            <button type="button" id="taskFormSaveButton" class="btn btn-success btn-anim mr-10 taskNoteFormSaveButton">
                                <i class="fa fa-save font-20"></i><span
                                    class="btn-text font-20">{{ __('job.task_save_button_label') }}</span></button>

                        <?php } ?>

                        <button type="button" id="taskFormSubmitButton" class="btn btn-success btn-anim mr-10"> <i
                                class="fa fa-check font-20 "></i><span
                                class="btn-text font-20">{{ __('job.task_submit_button_label') }}</span></button>
                        <a href="{{$redirectTo ?? '#'}}" class="btn btn-danger btn-anim task-edit-cancel"><i class="fa fa-times font-20"></i><span
                                class="btn-text font-20">{{ __('job.task_cancel_button_label') }}</span></a>
                    </span>
                </div>

            </div>

        </div>
    </form>
</div>
<!-- /Main Content -->
