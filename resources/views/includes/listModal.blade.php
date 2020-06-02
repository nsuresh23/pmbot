<!-- sample modal content -->
<div class="modal fade list-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg list-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title job-list-modal-title capitalize-font" id="myLargeModalLabel">{{ __('job.job_list_label') }}</h5>
            </div>
        <div class="modal-body pa-0 pl-5 pr-5 list-modal-body">

            <div id="jobListGrid"> </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
