<!-- Row -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="panel panel-default card-view panel-refresh">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">{{ __('dashboard.job_list_label') }}</h6>
                </div>
                <div class="pull-right">
                    <a href="#" class="pull-left inline-block full-screen mr-15">
                        <i class="zmdi zmdi-fullscreen job-status-i"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body row pa-0">
                    <div id="delayedJobList" data-status="delay"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Row -->