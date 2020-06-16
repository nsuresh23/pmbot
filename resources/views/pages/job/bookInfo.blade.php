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
                        <!-- Row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_id_label') }}</label>
                                    <input type="text" id="bookId" class="form-control"
                                        value="{{ $responseData["data"]["order_id"] ?? '-' }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_title_id_label') }}</label>
                                    <input type="text" id="bookTitleId" class="form-control"
                                        value="{{ $responseData["data"]["title_id"] ?? '-' }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_workflow_version_label') }}</label>
                                    <input type="text" id="workflow_version" class="form-control" value="{{ $responseData["data"]["workflow_version_text"] ?? '-' }}"
                                        readonly />
                                </div>
                            </div>
                        </div>
                        <!-- /Row -->
                        <!-- Row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_DOI_label') }}</label>
                                    <input type="text" id="bookDOI" class="form-control" value="{{ $responseData["data"]["doi"] ?? '-' }}"
                                        readonly />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_category_label') }}</label>
                                    {!! Form::select('category', [ null =>
                                    __('job.book_info_category_placeholder_text') ] +
                                    $responseData["job_category_list"],
                                    $selectedJobCategory,
                                    ['class' =>
                                    'form-control select2',
                                    'data-error' => __('job.book_info_category_error_msg'),
                                    'required']) !!}
                                    <div class="help-block with-errors"></div>
                                    {{-- <input type="text" id="category" class="form-control" value="{{ $responseData["data"]["category"] ?? '-' }}" /> --}}
                                </div>
                            </div>
                        </div>
                        <!-- /Row -->
                        <!-- Row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_title_label') }}</label>
                                    <input type="text" id="bookTitle" class="form-control"
                                        value="{{ $responseData["data"]["title"] ?? '-' }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_sub_title_label') }}</label>
                                    <input type="text" id="bookSubTitle" class="form-control"
                                        value="{{ $responseData["data"]["sub_title"] ?? '-' }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_series_title_label') }}</label>
                                    <input type="text" id="bookSeriesTitle" class="form-control"
                                        value="{{ $responseData["data"]["series_title"] ?? '-' }}" readonly />
                                </div>
                            </div>
                        </div>
                        <!-- /Row -->
                        <!-- Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_ISBN_label') }}</label>
                                    <input type="text" id="bookISBN" class="form-control" value="{{ $responseData["data"]["isbn"] ?? '-' }}"
                                        readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">{{ __('job.book_info_E_ISBN_label') }}</label>
                                    <input type="text" id="bookEISBN" class="form-control"
                                        value="{{ $responseData["data"]["e_isbn"] ?? '-' }}" readonly />
                                </div>
                            </div>
                        </div>
                        <!-- /Row -->
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
                    </div>

                    {{-- <div class="seprator-block"></div> --}}

                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Row -->
