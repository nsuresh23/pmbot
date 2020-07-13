<!-- Row -->
<div class="row">
    <div class="col-sm-12 col-xs-12">
        <div class="form-wrap">
            <form id="job-update-form" class="job-update-form" action="{{route(__('job.job_update_url'))}}"">
                <div class="form-body">

                    <h6 class="txt-dark capitalize-font font-16">
                        <i class="glyphicon glyphicon-book mr-10"></i>
                        {{ __('job.book_info_label') }}
                    </h6>
                    <hr class="light-grey-hr" />
                    <div class="">
                        <input type="hidden" id="redirectTo" name="redirectTo" value="{{$redirectTo ?? '#'}}">
                        <input type="hidden" id="job_id" name="job_id" value="{{$jobId ?? ''}}">
                        <input type="hidden" id="current_job_id" name="current_job_id" value="{{$jobId ?? ''}}">
                        <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />
                        <!-- Row -->
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_id_label') }}</label>
                                    <input type="text" id="order_id" class="form-control" name="order_id" value="{{ $responseData["data"]["order_id"] ?? '' }}" placeholder="{{ __('job.book_info_id_placeholder_text') }}" data-error="{{ __('job.book_info_id_error_msg') }}" pattern="[\w-]+" title="{{ __('job.job_isbn_match_error_msg') }}" data-match-error="{{ __('job.job_isbn_error_msg') }}" {{ $jobEditReadonly ?? '' }} />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_title_id_label') }}</label>
                                    <input type="text" id="bookTitleId" class="form-control" name="title_id" value="{{ $responseData["data"]["title_id"] ?? '' }}" placeholder="{{ __('job.book_info_title_id_placeholder_text') }}" data-error="{{ __('job.book_info_title_id_error_msg') }}" {{ $jobEditReadonly ?? '' }} />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_workflow_version_label') }}</label>
                                    {!! Form::select('workflow_version', [ null =>
                                    __('job.book_info_workflow_version_placeholder_text') ] +
                                    $responseData["workflow_list"],
                                    $selectedWorkflowVersion,
                                    ['class' => 'form-control select2',
                                    'data-error' => __('job.book_info_workflow_version_error_msg'),
                                    $jobEditReadonly,
									]) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>


                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_due_date_label') }}</label>
                                    <div class="input-group date datetimepicker">
                                        <input type="text" id="due_date" name="date_due" class="due_date form-control" value="{{$selectedDueDate}}" placeholder="{{ __('job.book_info_due_date_placeholder_text') }}" data-error="{{ __('job.book_info_due_date_error_msg') }}">
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>
                        <!-- /Row -->
                        <!-- Row -->
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_category_label') }}</label>
                                    {!! Form::select('category', [ null =>
                                    __('job.book_info_category_placeholder_text') ] +
                                    $responseData["job_category_list"],
                                    $selectedJobCategory,
                                    ['class' =>
                                    'form-control select2',
                                    'data-error' => __('job.book_info_category_error_msg'),
                                    $jobEditReadonly,
                                    'required']) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_author_info_label') }}</label>
                                    <input type="text" id="author" name="author" class="form-control" value="{{ $responseData["data"]["author"] ?? '' }}"
                                        placeholder="{{ __('job.book_info_author_info_placeholder_text') }}"
                                        data-error="{{ __('job.book_info_author_info_error_msg') }}" {{ $jobEditReadonly ?? '' }} />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_editor_info_label') }}</label>
                                    <input type="text" name="publisher" name="publisher" class="form-control" value="{{ $responseData["data"]["publisher"] ?? '' }}"
                                        placeholder="{{ __('job.book_info_editor_info_placeholder_text') }}"
                                        data-error="{{ __('job.book_info_editor_info_error_msg') }}" {{ $jobEditReadonly ?? '' }} />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_DOI_label') }}</label>
                                    <input type="text" id="bookDOI" class="form-control" name="doi" value="{{ $responseData["data"]["doi"] ?? '' }}" placeholder="{{ __('job.book_info_DOI_placeholder_text') }}" data-error="{{ __('job.book_info_DOI_error_msg') }}" {{ $jobEditReadonly ?? '' }} />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Row -->
                        <!-- Row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_title_label') }}</label>
                                    <input type="text" id="bookTitle" class="form-control" name="title"
                                        value="{{ $responseData["data"]["title"] ?? '' }}" placeholder="{{ __('job.book_info_title_placeholder_text') }}" data-error="{{ __('job.book_info_title_error_msg') }}" {{ $jobEditReadonly ?? '' }} />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_sub_title_label') }}</label>
                                    <input type="text" id="bookSubTitle" class="form-control" name="sub_title"
                                        value="{{ $responseData["data"]["sub_title"] ?? '' }}" placeholder="{{ __('job.book_info_sub_title_placeholder_text') }}" data-error="{{ __('job.book_info_sub_title_error_msg') }}" {{ $jobEditReadonly ?? '' }} />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_series_title_label') }}</label>
                                    <input type="text" id="bookSeriesTitle" class="form-control" name="series_title"
                                        value="{{ $responseData["data"]["series_title"] ?? '' }}" placeholder="{{ __('job.book_info_series_title_placeholder_text') }}" data-error="{{ __('job.book_info_series_title_error_msg') }}" {{ $jobEditReadonly ?? '' }} />
                                </div>
                            </div>
                        </div>
                        <!-- /Row -->
                        <!-- Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_ISBN_label') }}</label>
                                    <input type="text" id="bookISBN" class="form-control" name="isbn" value="{{ $responseData["data"]["isbn"] ?? '' }}" placeholder="{{ __('job.book_info_ISBN_placeholder_text') }}" data-error="{{ __('job.book_info_ISBN_error_msg') }}" pattern="[\w-]+" title="{{ __('job.job_isbn_match_error_msg') }}" data-match-error="{{ __('job.job_isbn_error_msg') }}" {{ $jobEditReadonly ?? '' }} />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_E_ISBN_label') }}</label>
                                    <input type="text" id="bookEISBN" class="form-control" name="e_isbn" value="{{ $responseData["data"]["e_isbn"] ?? '' }}" placeholder="{{ __('job.book_info_E_ISBN_placeholder_text') }}" data-error="{{ __('job.book_info_E_ISBN_error_msg') }}" pattern="[\w-]+" title="{{ __('job.job_isbn_match_error_msg') }}" data-match-error="{{ __('job.job_isbn_error_msg') }}" {{ $jobEditReadonly ?? '' }} />
                                </div>
                            </div>
                        </div>
                        <!-- /Row -->

                        <?php if(in_array(auth()->user()->role, config('constants.jobEditUserRoles'))) { ?>

                            <!-- Row -->
                            <div class="row">
                                <div class="col-md-12 mb-10">
                                    <div class="form-group">
                                        {{-- <a href="{{ $redirectToJobUrl ?? '#' }}" class="btn btn-danger btn-anim pull-right">
                                            <i class="fa fa-times"></i>
                                            <span class="btn-text ">{{ __('job.job_cancel_button_label') }}</span>
                                        </a> --}}
                                        <button type="submit" id="job-update-form-submit-button" class="btn btn-success btn-anim pull-right mr-10 job-update-form-submit-button"> <i class="fa fa-check"></i><span class="btn-text">{{ __('job.job_update_button_label') }}</span></button>
                                    </div>
                                </div>
                            </div>
                            <!-- /Row -->

                        <?php } ?>

                    </div>

                    {{-- <div class="seprator-block"></div> --}}

                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Row -->
