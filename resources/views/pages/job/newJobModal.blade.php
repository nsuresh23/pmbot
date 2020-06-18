<!-- Modal -->
<div aria-hidden="true" role="dialog" tabindex="-1" id="newJobModal" class="new-job-modal modal fade" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close new-job-modal-close" type="button">×</button>
            <h4 class="modal-title">{{ __("dashboard.new_job_title") }}</h4>
            </div>
            <div class="modal-body">
				<div class="form-wrap">
                    <form role="form" class="job-add-form" action="{{$newJobAddUrl ?? '#'}}">
                        <div class="form-body">
                            <div class="">
                                <input type="hidden" id="redirectTo" name="redirectTo" value="{{$redirectTo ?? '#'}}">
                                <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label uppercase-font">{{__("job.job_isbn_label")}}</label>
                                            <div class="col-lg-8 pl-20">
                                                <input type="text" id="womat_job_id" name="womat_job_id" class="form-control job-isbn"
                                                    value="{{ $returnResponse["data"]["isbn"] ?? '' }}"
                                                    placeholder="{{ __('job.job_isbn_placeholder_text') }}" pattern="[\w-]+" title="{{ __('job.job_isbn_match_error_msg') }}" data-error="{{ __('job.job_isbn_error_msg') }}" data-match-error="{{ __('job.job_isbn_error_msg') }}"
                                                    required />
                                                <div class="help-block with-errors job-isbn-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">{{ __('job.job_workflow_label') }}</label>
                                            <div class="col-lg-8">
                                                {!! Form::select('workflow_version', [ null =>
                                                __('job.job_workflow_placeholder_text') ] +
                                                $returnResponse["workflow_list"],
                                                null,
                                                ['class' =>
                                                'form-control select2',
                                                'data-error' => __('job.job_workflow_error_msg'),
                                                'required']) !!}
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">{{__("job.job_project_manager_label")}}</label>
                                            <div class="col-lg-8 pl-20">
                                                {!! Form::select('pm_empcode', [ "" =>
                                                __('job.job_project_manager_placeholder_text') ] +
                                                $returnResponse["user_list"], $selectedAssignedUser,
                                                ['class' => 'form-control select2 job-pm-empcode',
                                                // 'data-error' => __('job.job_project_manager_error_msg'),
                                                'required'])
                                                !!}
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">{{__("job.job_due_date_label")}}</label>
                                            <div class="col-lg-8">
                                                <div class="input-group date datetimepicker">
                                                <input type="text" id="date_due" name="date_due" class="job-due-date form-control pa-5" value="{{$defaultDueDate ?? ''}}"
                                                        data-error="{{ __('job.job_due_date_error_msg') }}" required>
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                                <div class="help-block with-errors"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">{{__("job.job_title_label")}}</label>
                                            <div class="col-lg-10">
                                                <input type="text" id="jobTitle" name="title" class="form-control"
                                                    value="{{ $returnResponse["data"]["title"] ?? '' }}"
                                                    placeholder="{{ __('job.job_title_placeholder_text') }}" />
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <span class="pull-right mt-5">

                                            <button type="submit" id="jobAddSubmit" class="btn btn-success btn-anim bg-success job-add-submit-btn" data-redirect-url="{{ $redirectTo ?? '' }}">
                                                <i class="fa fa-check font-18 txt-light"></i>
                                                <span class="btn-text font-18">{{ __('job.job_submit_button_label') }}</span>
                                            </button>

                                        </span>

                                    </div>
                                </div>

                            </div>

                            {{-- <div class="seprator-block"></div> --}}

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
