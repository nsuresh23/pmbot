<!-- Row -->
<div class="row">
    <div class="col-md-12">
        <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

            <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading bg-pannel-info activestate" role="tab">
                        <a role="tab" data-toggle="collapse" href="#taskList" aria-expanded="true">
                            <i class="zmdi zmdi-collection-text mr-10"></i>
                            {{ __("dashboard.tasks_label") }}
                            <span class="result-count"></span>
						</a>
		            </div>
                    <div id="taskList" class="panel-collapse collapse in" role="tabpanel">

                        @include('pages.job.task.taskList')

                    </div>
                </div>
                {{-- <div class="panel panel-default">
                    <div class="panel-heading activestate" role="tab">
                        <a class="collapsed" role="tab" data-toggle="collapse" href="#myEmails" aria-expanded="true">
                            <i class="zmdi zmdi-collection-text mr-10"></i>
                            {{ __("dashboard.emails_label") }}
                        </a>
                    </div>
                    <div id="myEmails" class="panel-collapse collapse in" role="tabpanel">

                        @include('pages.job.email.emailList')

                    </div>
                </div> --}}

                <div class="panel">
                    <div class="job-check-list">
                        <div class="panel-heading bg-light-green activestate" role="tab">
                            <a role="tab" class="txt-dark capitalize-font" data-toggle="collapse" href="#task_job_check_list_collapse"
                                aria-expanded="false">
                                <i class="zmdi zmdi-collection-text mr-10"></i>
                                {{ $jobCheckListTableCaption }}
                                <span class="result-count"></span>
                            </a>
                        </div>
                        <div id="task_job_check_list_collapse" class="panel-collapse collapse" role="tabpanel">
                
                            @include('pages.job.task.jobCheckList')
                
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-heading bg-light-yellow" role="tab">
                        <a class="collapsed txt-dark capitalize-font" role="button" data-toggle="collapse"
                            href="#task_global_check_list_collapse" aria-expanded="false">
                            <i class="zmdi zmdi-collection-text mr-10"></i>
                            {{ $globalCheckListTableCaption }}
                            <span class="result-count"></span>
                        </a>
                    </div>
                    <div id="task_global_check_list_collapse" class="panel-collapse collapse" role="tabpanel">
                
                        @include('pages.job.task.globalCheckList')
                
                    </div>
                </div>

            </div>

        <?php } ?>
    </div>
</div>
<!-- /Row -->