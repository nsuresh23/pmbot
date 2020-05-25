
<!-- Main Content -->
<!-- Row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark capitalize-font"><i
                            class="zmdi zmdi-collection-text mr-10"></i>{{ $noteTitle ?? '' }}</h6>
                </div>
                {{-- <div class="pull-right">
                    <a class="pull-left inline-block mr-15" data-toggle="collapse" href="#task_note_collapse"
                        aria-expanded="true">
                        <i class="zmdi zmdi-chevron-down job-status-i"></i>
                        <i class="zmdi zmdi-chevron-up job-status-i"></i>
                    </a>
                    <a href="#" class="pull-left inline-block full-screen mr-15">
                        <i class="zmdi zmdi-fullscreen job-status-i"></i>
                    </a>
                </div> --}}
                <div class="clearfix"></div>
            </div>
            <div id="task_note_collapse" class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap">
                        <form id="taskNoteForm" class="taskNoteForm taskNoteModalForm" data-toggle="validator" role="form" action="{{ $notePostUrl ?? '#'}}" method="POST">
                            <div class="form-body">
                                <div class="row">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    {{-- <input type="hidden" name="task_id" value="{{ $taskId ?? ''}}"> --}}
                                    <input type="hidden" id="jobId" name="job_id" value="{{ $jobId ?? ''}}">
                                    <input type="hidden" id="title" name="title" value="{{ $taskTitle ?? ''}}">
                                    <input type="hidden" name="status_previous" value="{{ $selectedStatus ?? ''}}">
                                    <input type="hidden" name="createdby_empcode" value="{{ $createdByEmpcode ?? ''}}">
                                    {{-- <input type="hidden" name="createdby_empname" value="{{ $createdByEmpname ?? ''}}"> --}}
                                    <input type="hidden" name="assignedto_empcode" value="{{ $assignedToEmpcode ?? ''}}">
                                    {{-- <input type="hidden" name="assignedto_empname" value="{{ $assignedToEmpname ?? ''}}"> --}}
                                    <input type="hidden" name="createdby_status" value="{{ $createdByStatus ?? ''}}">
                                    <input type="hidden" name="assignedto_status" value="{{ $assignedToStatus ?? ''}}">
                                    <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />
                                    <input type="hidden" id="id" name="id">
                                    {{-- <input type="hidden" id="attachment" name="attachment"> --}}
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="task-note" class="control-label mb-10">{{ __('job.task_note_label') }}</label>
                                        <textarea class="textarea_editor form-control" id="task-note" name="additional_note"
                                                value="{{$returnResponse['data']['note']['additional_note'] ?? ''}}"
                                                data-value="{{$returnResponse['data']['note']['additional_note'] ?? ''}}"
                                                placeholder="{{ __('job.task_note_placeholder_text') }}"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-30">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-30 pl-0">
                                            <div class="form-group">
                                                <label for="attachment" class="control-label mb-10">{{ __('job.task_attachment_label') }}</label>
                                                <input type="text" class="form-control" id="attachment" name="attachment_path"
                                                    value="{{$returnResponse['data']['attachment_path'] ?? ''}}"
                                                    placeholder="{{ __('job.task_attachment_placeholder_text') }}"
                                                    data-error="{{ __('job.task_attachment_error_msg') }}">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div class="pull-right">
                                                <button type="submit" class="btn btn-success btn-anim mr-10 taskNoteFormSubmitButton"> <i class="fa fa-check font-20"></i><span
                                                            class="btn-text font-20">{{ __('job.task_note_submit_button_label') }}</span></button>
                                                    <a href="{{ $redirectTo ?? '#' }}" data-dismiss="modal" class="btn btn-danger btn-anim"><i class="fa fa-times font-20"></i><span
                                                            class="btn-text font-20">{{ __('job.task_note_cancel_button_label') }}</span></a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Row -->
<!-- /Main Content -->
