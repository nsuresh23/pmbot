<!-- Row -->
<div class="row">
    <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>
    
        <div class="panel-group accordion-struct pl-5" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading bg-light-green activestate" role="tab">
                    <a role="tab" data-toggle="collapse" href="#myTaskList" aria-expanded="true">
                        <i class="zmdi zmdi-collection-text mr-10"></i>
                        {{ __("dashboard.tasks_label") }}
                        <span class="result-count"></span>
                        {{-- <div class="noti">
                            <i class="fas fa-heart"></i>2
                            <div class="shadow"></div>
                            <div class="point"></div>
                        </div>
                        <div class="shadow-oval"></div> --}}
                    </a>
                </div>
                <div id="myTaskList" class="panel-collapse collapse in" role="tabpanel">
        
                    @include('pages.dashboard.task.dashboardMyTasks')
        
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading bg-light-yellow activestate" role="tab">
                    <a class="collapsed" role="tab" data-toggle="collapse" href="#myEmails" aria-expanded="true">
                        <i class="zmdi zmdi-collection-text mr-10"></i>
                        {{ __("dashboard.emails_label") }}
                        {{-- <span class="result-count"></span> --}}
                        <span class="email-result-count"></span>
                        <div class="pull-right inline-block mr-15">
                            <span class="mr-5">{{ __("dashboard.emails_last_updated_label") }}:</span>
                            <span class="email-last-updated"></span>
                        </div>
                    </a>
                </div>
                <div id="myEmails" class="panel-collapse collapse in" role="tabpanel">
        
                    @include('pages.dashboard.email.dashboardMyEmails')
        
                </div>
            </div>
        </div>
    
    <?php } else { ?>
    
        @include('pages.dashboard.task.dashboardMyTasks')
    
    <?php } ?>
</div>
<!-- /Row -->