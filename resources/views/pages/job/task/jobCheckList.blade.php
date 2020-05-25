<div id="jobDetailTaskJobCheckList" class="fullwidth jobDetailTaskJobCheckList tab-pane fade pt-0 pb-10 active in" data-type="jobDetail" data-job-id="{{ $jobId }}"
        $taskCheckListAddOption=$emailCheckListAddOption="false" ; data-category="job" data-checklist-type="task"
        data-add-option="{{$taskCheckListAddOption}}" data-list-url="{{ $checkListUrl }}"
        data-add-url="{{ $checkListAddUrl }}" data-edit-url="{{ $checkListEditUrl }}"
        data-delete-url="{{ $checkListDeleteUrl }}" data-current-route="{{ Route::currentRouteName() }}"></div>