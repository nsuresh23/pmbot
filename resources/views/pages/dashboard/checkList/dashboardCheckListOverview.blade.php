<!-- Row -->
<div class="row">
    <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>
    
        <div class="panel-group accordion-struct pl-5" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading bg-light-green activestate" role="tab">
                    <a role="tab" data-toggle="collapse" href="#taskCheckList" aria-expanded="true">
                        <i class="zmdi zmdi-collection-text mr-10"></i>
                        {{ __("dashboard.tasks_label") }}
                        <span class="result-count"></span>
                    </a>
                </div>
                <div id="taskCheckList" class="panel-collapse collapse in" role="tabpanel">
        
                    @include('pages.dashboard.task.dashboardTaskCheckList')
        
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading bg-light-yellow activestate" role="tab">
                    <a class="collapsed" role="tab" data-toggle="collapse" href="#emailCheckList" aria-expanded="true">
                        <i class="zmdi zmdi-collection-text mr-10"></i>
                        {{ __("dashboard.emails_label") }}
                        <span class="result-count"></span>
                    </a>
                </div>
                <div id="emailCheckList" class="panel-collapse collapse in" role="tabpanel">
        
                    @include('pages.dashboard.email.dashboardEmailCheckList')
        
                </div>
            </div>
        </div>
    
    <?php } ?>
</div>
<!-- /Row -->