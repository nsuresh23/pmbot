<!-- Row -->
<div class="row">
    <div class="col-md-12">
        <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

            <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                <div class="panel">
                    <div class="job-check-list">
                        <div class="panel-heading activestate" role="tab">
                            <a role="tab" class="txt-dark capitalize-font" data-toggle="collapse" href="#job_check_list_collapse" aria-expanded="true">
                                <i class="zmdi zmdi-collection-text mr-10"></i>
                                {{ $jobCheckListTableCaption }}
                            </a>
                        </div>
                        <div id="job_check_list_collapse" class="panel-collapse collapse in" role="tabpanel">

                            @include('pages.job.checkList.jobCheckList')

                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-heading" role="tab">
                        <a class="collapsed txt-dark capitalize-font" role="button" data-toggle="collapse" href="#global_check_list_collapse" aria-expanded="false">
                            <i class="zmdi zmdi-collection-text mr-10"></i>
                            {{ $globalCheckListTableCaption }}
                        </a>
                    </div>
                    <div id="global_check_list_collapse" class="panel-collapse collapse" role="tabpanel">

                        @include('pages.job.checkList.globalCheckList')

                    </div>
                </div>
            </div>

        <?php } ?>
    </div>
</div>
<!-- /Row -->