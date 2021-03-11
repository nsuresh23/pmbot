<!-- Row -->
<div class="row">
    <div class="col-md-12">
        <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

            <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                <div class="panel panel-primary">
                    <div class="panel-heading bg-pannel-info activestate" role="tab">
                        <a class="collapsed" role="tab" data-toggle="collapse" href="#myEmails" aria-expanded="true">
                            <i class="zmdi zmdi-collection-text mr-10"></i>
                            {{ __("dashboard.emails_label") }}
                            <span class="result-count"></span>
                        </a>
                    </div>
                    <div id="myEmails" class="panel-collapse collapse in" role="tabpanel">

                        <div class="tab-struct job-email-tab-struct mt-5">

                            <ul role="tablist" class="nav nav-tabs inner-tabs" id="job-email-tab-list">

                                <li class="active" role="presentation">

                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="job-all-email-tab" class="inner-tab-bg job-all-email" data-grid-selector="jobEmailGrid" href="#all-email-tab-content">All</a>

                                </li>

                                <li role="presentation">

                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="job-pe-email-tab" class="inner-tab-bg job-pe-email" data-grid-selector="jobEmailGrid" href="#pe-email-tab-content">PE</a>

                                </li>

                                <li role="presentation">

                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="job-author-email-tab" class="inner-tab-bg job-author-email" data-grid-selector="jobEmailGrid" href="#author-email-tab-content">Author</a>

                                </li>

                            </ul>

                            <div class="tab-content" id="job-email-tab-content">

                                <div id="all-email-tab-content" class="tab-pane fade active in" role="tabpanel">

                                    @include('pages.job.email.emailList')

                                </div>

                                {{-- <div id="pe-email-tab-content" class="tab-pane fade" role="tabpanel">

                                    @include('pages.job.email.peEmailListWithoutNav')

                                </div>

                                <div id="author-email-tab-content" class="tab-pane fade " role="tabpanel">

                                    @include('pages.job.email.authorEmailListWithoutNav')

                                </div> --}}

                            </div>

                        </div>

                    </div>
                </div>

                <div class="panel">
                    <div class="job-check-list">
                        <div class="panel-heading bg-light-green activestate" role="tab">
                            <a role="tab" class="txt-dark capitalize-font" data-toggle="collapse" href="#email_job_check_list_collapse"
                                aria-expanded="false">
                                <i class="zmdi zmdi-collection-text mr-10"></i>
                                {{ $jobCheckListTableCaption }}
                                <span class="result-count"></span>
                            </a>
                            {{-- <a class="pull-left inline-block mt-5 mr-15" data-toggle="collapse" href="#email_job_check_list_collapse"
                                aria-expanded="false">
                                <i class="zmdi zmdi-chevron-down job-status-i"></i>
                                <i class="zmdi zmdi-chevron-up job-status-i"></i>
                            </a> --}}
                        </div>
                        <div id="email_job_check_list_collapse" class="panel-collapse collapse" role="tabpanel">

                            @include('pages.job.email.jobCheckList')

                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-heading bg-light-yellow" role="tab">
                        <a class="collapsed txt-dark capitalize-font" role="button" data-toggle="collapse"
                            href="#email_global_check_list_collapse" aria-expanded="false">
                            <i class="zmdi zmdi-collection-text mr-10"></i>
                            {{ $globalCheckListTableCaption }}
                            <span class="result-count"></span>
                        </a>
                    </div>
                    <div id="email_global_check_list_collapse" class="panel-collapse collapse" role="tabpanel">

                        @include('pages.job.email.globalCheckList')

                    </div>
                </div>

            </div>

        <?php } ?>
    </div>
</div>
<!-- /Row -->
