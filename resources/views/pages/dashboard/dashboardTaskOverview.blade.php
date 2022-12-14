<!-- Row -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default card-view mb-0">
            <div class="panel-heading">
                <div class="pull-left">
                    <div class="pills-struct">
                        <ul role="tablist" class="nav nav-pills nav-pills-outline dashboard-task-tabs" id="">
                            <li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab"
                                    id="myTaskTab" class="capitalize-font"
                                    href="#myTaskOverview">{{ __('dashboard.my_task_tab_label') }}</a></li>

                            <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                <li class="" role="presentation">
                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="openTaskTab" class="capitalize-font" href="#openTask">
                                        {{ __('dashboard.open_task_tab_label') }}
                                    </a>
                                </li>

                            <?php } ?>

                            <?php if(!in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                <li class="" role="presentation">
                                    <a role="tab" data-toggle="tab" id="queryListTab" class="capitalize-font" href="#queryList" aria-expanded="false">
                                        {{ __('dashboard.query_list_tab_label') }}
                                    </a>
                                </li>

                            <?php } ?>

                            <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                <li role="presentation" class=""><a data-toggle="tab" id="checkListTab"
                                        class="capitalize-font" role="tab" href="#checkList"
                                        aria-expanded="false">{{ __('dashboard.check_list_tab_label') }}</a></li>

                            <?php } ?>

                            <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                <li class="" role="presentation">
                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="taskCalendarTab"
                                        class="capitalize-font" href="#taskCalendar">
                                        {{ __('dashboard.task_calendar_tab_label') }}
                                    </a>
                                </li>

                            <?php } ?>

                            <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                <li class="" role="presentation">
                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="eventCalendarTab" class="capitalize-font" href="#eventCalendar" data-event-calendar-get-url="{{$eventCalendarUrl ?? ''}}">
                                        {{ __('dashboard.event_calendar_tab_label') }}
                                    </a>
                                </li>

                            <?php } ?>

                            <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                <li class="" role="presentation">
                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="nonBusinessEmailsTab" class="capitalize-font" href="#nonBusinessEmails">
                                        {{ __('dashboard.non_business_emails_tab_label') }}
                                    </a>
                                </li>

                            <?php } ?>

                            <?php // if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                {{-- <li class="" role="presentation">
                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="classificationEmailsTab" class="capitalize-font"
                                        href="#classificationEmails">
                                        {{ __('dashboard.classification_emails_tab_label') }}
                                    </a>
                                </li> --}}

                            <?php // } ?>

                            <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                <li class="" role="presentation">
                                    <a aria-expanded="false" title="Add this item" data-toggle="modal" role="tab" id="genericJobsTab" class="capitalize-font job-list" data-type="{{ __('dashboard.generic_job_text') }}" data-count="1">
                                        {{ __('dashboard.generic_jobs_tab_label') }}
                                    </a>
                                </li>

                            <?php } ?>

                            <?php //if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                            {{-- <li class="" role="presentation">
                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="businessEmailsTab" class="capitalize-font"
                                        href="#businessEmails">
                                        {{ __('dashboard.business_emails_tab_label') }}
                            </a>
                            </li> --}}

                            <?php //} ?>

                            <?php if(auth()->user()->lead_pm) { ?>

                                <li class="" role="presentation">
                                    <a data-toggle="tab" id="emailRulesTab" class="capitalize" role="tab" href="#emailRules"
                                        post-url="{{ route(__('job.email_rules_url')) }}">
                                        {{ __('job.email_rules_tab_label') }}
                                        <span class="email-rules-count"></span>
                                    </a>
                                </li>

                            <?php } ?>

                            <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                <li class="" role="presentation">
                                    <a data-toggle="tab" id="myDiaryTab" class="capitalize" role="tab" href="#myDiary"
                                        data-my-history-url="{{ route(__('job.my_history_url')) }}">
                                        {{ __('job.my_diary_tab_label') }}
                                    </a>
                                </li>

                            <?php } ?>

                        </ul>
                    </div>
                </div>
                <div class="pull-right">
                    {{-- <div class="pull-left">
                        <div class="pills-struct mr-20">
                            <ul role="tablist" class="nav nav-pills nav-pills-outline" id="">
                                <li class="" role="presentation">
                                    <a aria-expanded="true" data-toggle="tab" role="tab" id="openTaskTab" class="capitalize-font" href="#openTask">
                                        {{ __('dashboard.open_task_tab_label') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div> --}}
                    <?php

                        if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) {

                    ?>
                        {{-- <div class="pull-left inline-block mr-15 footable-filtering">
                            <ul role="tablist" class="nav nav-pills nav-pills-outline" id="">
                                <li role="presentation" class="">
                                    <a data-toggle="tab" id="myDiaryTab" class="capitalize-font" role="tab" href="#mydiary"
                                        aria-expanded="false">{{ __('dashboard.my_diary_tab_label') }}
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
                    <?php
                        }
                    ?>
        <a class="pull-left inline-block mt-5 mr-15" data-toggle="collapse" href="#dashboard_task_pannel" aria-expanded="false">
            <i class="zmdi zmdi-chevron-down job-status-i"></i>
            <i class="zmdi zmdi-chevron-up job-status-i"></i>
        </a>
        <div class="pull-left inline-block mt-5 footable-filtering">
            <a href="#" class="pull-left inline-block full-screen mr-15">
                <i class="zmdi zmdi-fullscreen job-status-i"></i>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div id="dashboard_task_pannel" class="panel-wrapper collapse in dashboard-task-panel">
    <div class="panel-body pt-0 pb-0">
        <div class="pills-struct">
            <div class="tab-content" id="">

                <div id="myTaskOverview" class="tab-pane fade pt-0 active in" role="tabpanel">

                    @include('pages.dashboard.task.dashboardMyTasksOverview')

                </div>

                <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                    <div id="openTask" class="tab-pane fade pt-0" role="tabpanel">

                        @include('pages.dashboard.task.dashboardOpenTasks')

                    </div>

                <?php } ?>

                <?php if(!in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                    <div id="queryList" class="tab-pane fade pt-0" role="tabpanel">

                        @include('pages.dashboard.queries.dashboardQueries')

                    </div>

                <?php } ?>

                <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                    <div id="checkList" class="tab-pane fade pt-0" role="tabpanel">

                        @include('pages.dashboard.checkList.dashboardCheckListOverview')

                    </div>

                <?php } ?>

                <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                    <div id="taskCalendar" class="taskCalendar tab-pane fade pt-5" role="tabpanel">

                        @include('pages.dashboard.task.dashboardTaskCalendar')

                    </div>

                <?php } ?>

                <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                    <div id="eventCalendar" class="eventCalendar tab-pane fade pt-0" role="tabpanel">

                        @include('pages.dashboard.events.dashboardEventCalendar')

                    </div>

                <?php } ?>

                <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                    <div id="nonBusinessEmails" class="nonBusinessEmails tab-pane fade pt-0" role="tabpanel">

                        @include('pages.dashboard.email.dashboardEmails')

                    </div>

                <?php } ?>

                <?php // if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                    {{-- <div id="classificationEmails" class="classificationEmails tab-pane fade pt-0" role="tabpanel">

                        @include('pages.dashboard.email.dashboardClassificationEmails')

                    </div> --}}

                <?php // } ?>

                <?php //if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                {{-- <div id="businessEmails" class="businessEmails tab-pane fade" role="tabpanel">

                                    @include('pages.dashboard.email.dashboardBusinessEmails')

                                </div> --}}

                <?php //} ?>

                <?php if(auth()->user()->lead_pm) { ?>

                    <div id="emailRules" class="tab-pane fade" role="tabpanel">

                        @include('pages.dashboard.email.emailRules')

                    </div>

                <?php } ?>

                <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                    <div id="myDiary" class="tab-pane fade" role="tabpanel">

                        @include('pages.dashboard.diary.myDiary')

                    </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Row -->
@include('pages.email.composeModal')
@include('pages.email.replyModal')
@include('pages.email.draftModal')
