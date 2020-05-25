<?php

$tableCaption =  __("job.notification_title_label");
$listUrl = route(__("job.notification_list_url"));
$readUrl = route(__("job.notification_read_url"), "");
$readAllUrl = route(__("job.notification_read_all_url"));
$deleteUrl = route(__("job.notification_delete_url"));
$deleteAllUrl = route(__("job.notification_delete_all_url"));

?>
<!-- Row -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">{{ $tableCaption }}</h6>
                </div>
                <div class="pull-right">
                    <a href="#" class="pull-left inline-block full-screen mr-15">
                        <i class="zmdi zmdi-fullscreen job-status-i"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div class="notificationGrid" data-list-url="{{ $listUrl }}"
                            data-read-url="{{ $readUrl }}" data-read-all-url="{{ $readAllUrl }}"
                            data-delete-url="{{ $deleteUrl }}" data-delete-all-url="{{ $deleteAllUrl }}" data-current-route="{{ Route::currentRouteName() }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Row -->