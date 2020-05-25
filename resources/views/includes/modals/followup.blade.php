{{-- <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="mySmallModalLabel">Follow up date and time</h5>
            </div>
            <div class="modal-body">

                <div class="input-group date datetimepicker">
                    <input type="text" name="followup_date" value="{{$followupDate ?? ''}}" class="form-control">
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-anim">
                            <i class="icon-rocket"></i>
                            <span class="btn-text">submit</span></button>
                    </span>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> --}}

<div id="followupdate" class="followupdate popover popover-x is-bs4 popover-default">
    <div class="arrow"></div>
    <h3 class="popover-header popover-title"><span class="close" data-dismiss="popover-x">&times;</span>{{__("job.task_followup_time_label")}}</h3>
    <div class="popover-body popover-content">
    <form id="task-followup-datetime" class="task-follow-up-datetime" action="{{$taskFollowupDateUpdateUrl}}">
            <input type="hidden" name="task_id" value="{{$taskId ?? ''}}" />
            <div class="input-group date datetimepicker">
                <input type="text" name="followup_date" value="{{$followupDate ?? ''}}" class="form-control">
                <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span>
                <span class="input-group-btn">
                    <button type="submit" class="btn-task-followup-date-submit btn btn-success btn-anim">
                        <i class="fa fa-check"></i>
                    <span class="btn-text">{{__("job.task_submit_button_label")}}</span></button>
                </span>
            </div>
        </form>
    </div>
</div>
