<!-- Main Content -->
<div class="form-wrap mt-10">
    <form id="checkListForm" class="checkListForm" data-toggle="validator" role="form" action="{{ $postUrl }}" method="POST">
        <div class="form-body">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="redirectTo" name="redirectTo" value="{{$returnData['redirectTo'] ?? ''}}">
                <input type="hidden" id="c_id" name="c_id" value="{{$checkListId ?? ''}}">
                <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />
                <?php if($jobId) { ?>

                    <input type="hidden" id="jobId" name="job_id" value="{{ $jobId }}">

                <?php } ?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">

                        <?php if($taskList) { ?>

                            <?php if($location) { ?>

                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

                            <?php } else { ?>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <?php } ?>

                            <div class="form-group">
                                <label for="tasks" class="mb-10">{{ __('job.check_list_task(s)_label') }}</label>
                                <span class="checkbox checkbox-success pull-right ma-0 pa-0">
                                    <input class="select-all" type="checkbox">
                                    <label for="checkbox" class="text-capitalize pl-0">
                                        {{ __('job.select_all_label') }}
                                    </label>
                                </span>
                                {!! Form::select('tasklist[]',
                                $taskList,
                                // $task_id,
                                $checklistTasks,
                                ['class' =>
                                'form-control select2 select2-multiple',
                                'multiple' => 'multiple',
                                'data-placeholder' =>
                                __('job.check_list_task(s)_placeholder_text'),
                                'data-error' => __('job.check_list_tasklist_error_msg'),
                                // 'previous_value' => json_encode($checklistTasks),
                                $tasksRequired]) !!}
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>

                        <?php } ?>

                        <?php if($location) { ?>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                            <div class="form-group">
                                <label for="location"
                                    class="control-label mb-10">{{ __('job.check_list_location_label') }}</label>
                                {!! Form::select('location', [ null =>
                                __('job.check_list_location_placeholder_text') ] +
                                $returnData["location_list"],
                                $location,
                                ['class' =>
                                'form-control select2 checkField',
                                'previous_value' . $location,
                                'data-error' =>  __('job.check_list_location_error_msg'),
                                'required']) !!}
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>

                        <?php } ?>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="title" class="control-label mb-10">{{ __('job.check_list_title_label') }}</label>
                        <input type="text" class="form-control checkField" id="title" name="title"
                            value="{{$returnData['data']['title'] ?? ''}}"
                            placeholder="{{ __('job.check_list_title_placeholder_text') }}"
                            data-error="{{ __('job.check_list_title_error_msg') }}" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="check-list-description"
                            class="control-label mb-10">{{ __('job.check_list_description_label') }}</label>
                        <textarea class="textarea_editor form-control checkField" rows="15" id="check-list-description"
                            name="description" value="{{$returnData['data']['description'] ?? ''}}"
                            data-value="{{$returnData['data']['description'] ?? ''}}"
                            placeholder="{{ __('job.check_list_description_placeholder_text') }}"></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="attachment"
                            class="control-label mb-10">{{ __('job.check_list_attachment_label') }}</label>
                        <input type="text" class="form-control checkField" id="attachment" name="attachment_path"
                            value="{{$returnData['data']['attachment_path'] ?? ''}}"
                            placeholder="{{ __('job.check_list_attachment_placeholder_text') }}"
                            data-error="{{ __('job.check_list_attachment_error_msg') }}">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="pull-right mb-20 pr-15">
                    <button type="submit" class="btn btn-success btn-anim mr-10 checkFormButton">
                        <i class="fa fa-check font-20"></i>
                        <span class="btn-text font-20">
                            {{ __('job.check_list_submit_button_label') }}
                        </span>
                    </button>
                    <a href="{{ $redirectTo }}" class="btn btn-danger btn-anim check-list-edit-cancel">
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
