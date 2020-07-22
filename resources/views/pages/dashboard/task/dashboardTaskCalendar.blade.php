<div class="row">
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ml-0 pl-0 pr-5 calendar-wrap big-calendar">
    <div id="task-calendar" class="task-calendar" data-post-url="{{$taskCalendarUrl ?? ''}}"></div>
    </div>
    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 ml-0 pl-0">
        <div class="taskCalendarGrid" data-category="mytask" data-type="dashboard" data-list-url="{{ $myTaskListUrl }}"
            data-add-url="{{ $taskAddUrl }}" data-edit-url="{{ $taskEditUrl }}" data-delete-url="{{ $taskDeleteUrl }}"
            data-current-route="{{ $currentRoute }}" data-current-user-id="{{ Auth::user()->empcode }}" data-task-date=""></div>
    </div>
</div>
