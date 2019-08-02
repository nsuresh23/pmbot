<!-- sample modal content -->
<div class="modal fade list-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg list-modal-dialog">
        <div class="modal-content">
            {{-- <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title" id="myLargeModalLabel">{{ __('job.jobList') }}</h5>
        </div> --}}
        <div class="modal-body list-modal-body">

            <div class="panel panel-default card-view panel-refresh">
                <div class="refresh-container">
                    <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">{{ __('job.jobList') }}</h6>
                    </div>
                    <div class="pull-right">
                        <a class="pull-left inline-block mr-15" data-toggle="collapse" href="#collapse_1" aria-expanded="true">
                            <i class="zmdi zmdi-chevron-down"></i>
                            <i class="zmdi zmdi-chevron-up"></i>
                        </a>
                        {{-- <a href="#" class="pull-left inline-block refresh mr-15">
                            <i class="zmdi zmdi-replay"></i>
                        </a> --}}
                        {{-- <a href="{{ route('jobs') }}" class="pull-left inline-block mr-15">
                            <i class="zmdi zmdi-fullscreen"></i>
                        </a> --}}
                        {{-- <a class="pull-left inline-block close-panel" href="#" data-effect="fadeOut">
                            <i class="zmdi zmdi-close"></i>
                        </a> --}}

                        <a class="pull-left inline-block close" href="#" data-dismiss="modal" aria-hidden="true">
                            <i class="zmdi zmdi-close"></i>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="collapse_1" class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div id="jobList"> </div>
                    </div>
                </div>
            </div>
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
