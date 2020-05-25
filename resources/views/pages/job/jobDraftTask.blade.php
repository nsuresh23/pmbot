<!-- Row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div id="jobDetailTask" class="tab-pane fade active in" role="tabpanel">
                        <div class="jobDraftTaskGrid fullwidth" data-category="jobdrafttask" data-type="jobDetail" data-list-url="{{ $draftTaskListUrl }}" data-add-url="{{ $taskAddUrl }}"
                            data-edit-url="{{ $taskEditUrl }}" data-delete-url="{{ $taskDeleteUrl }}"
                            data-current-route="{{ Route::currentRouteName() }}" data-current-user-id="{{ Auth::user()->id }}" data-current-job-id="{{ $jobId }}"></div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Row -->