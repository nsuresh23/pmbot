<div id="jobDetailTask" class="jobTaskGrid fullwidth tab-pane fade pt-0 pb-10 active in" data-category="jobtask" data-type="jobDetail" data-add-task-option="true"
    data-list-url="{{ $taskListUrl }}" data-add-url="{{ $taskAddUrl }}" data-edit-url="{{ $taskEditUrl }}"
    data-delete-url="{{ $taskDeleteUrl }}" data-current-route="{{ Route::currentRouteName() }}"
    data-current-user-id="{{ Auth::user()->id }}" data-current-job-id="{{ $jobId }}"></div>