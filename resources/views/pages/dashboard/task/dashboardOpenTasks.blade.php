<div class="row">
    <div class="openTaskGrid pl-5 wd-100" data-category="opentask" data-add-task-option="true" data-type="dashboard"
        data-list-url="{{ $openTaskListUrl }}" data-add-url="{{ $taskAddUrl }}" data-edit-url="{{ $taskEditUrl }}"
        data-delete-url="{{ $taskDeleteUrl }}" data-current-route="{{ $currentRoute }}"
        data-current-user-id="{{ Auth::user()->empcode }}">
    </div>
</div>