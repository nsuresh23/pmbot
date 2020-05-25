<div class="row">
    <div id="queryList" class="pt-0 pl-5 wd-100" role="tabpanel">
        <div class="queryListGrid" data-category="querylist" data-add-task-option="true" data-type="dashboard"  data-list-url="{{ $queryListUrl }}"
            data-add-url="{{ $taskAddUrl }}" data-edit-url="{{ $taskEditUrl }}" data-delete-url="{{ $taskDeleteUrl }}"
            data-current-route="{{ $currentRoute }}" data-current-user-id="{{ Auth::user()->empcode }}"></div>
    </div>
</div>