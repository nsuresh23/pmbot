<!-- Row -->
<div class="row">
    <?php if(in_array(auth()->user()->role, config('constants.qcUserRoles'))) { ?>

        <div class="panel-group accordion-struct pl-5 mb-0" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading bg-light-yellow activestate" role="tab">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <a class="collapsed" role="tab" data-toggle="collapse" href="javascript:void(0);" aria-expanded="true">
                                <i class="zmdi zmdi-collection-text mr-10"></i>
                                {{ __("dashboard.emails_label") }}
                                <span class="email-result-count"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="myEmails" class="panel-collapse collapse in" role="tabpanel">

                    @include('pages.dashboard.qc.dashboardQCEmails')

                </div>
            </div>
        </div>

    <?php } ?>
</div>
<!-- /Row -->
