<div class="panel card-view mb-0">
    <div class="panel-heading bg-pannel-info">
        <div class="pull-left">
            <div class="pills-struct">
                <ul role="tablist" class="nav nav-pills nav-pills-outline dashboard-job-tabs" id="">
                    <li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab"
                            id="overviewTab" href="#overview">{{ __('dashboard.overview_tab_label') }}</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" id="stageTab" role="tab" href="#stage"
                            aria-expanded="false">{{ __('dashboard.stage_tab_label') }}</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" id="financialTab" role="tab" href="#financial"
                            aria-expanded="false">{{ __('dashboard.financial_invoice_tab_label') }}</a></li>

                    <?php if(isset($hasMembers) && $hasMembers == "1" && !session()->has("current_empcode")) { ?>

                        <li role="presentation" class="">
                            <a data-toggle="tab" id="membersTab" role="tab" href="#overview" aria-expanded="false">
                                {{ __('dashboard.members_tab_label') }}
                                <span class="members-count"></span>
                            </a>
                        </li>

                    <?php } elseif(in_array(auth()->user()->role, Config::get('constants.amUserRoles')) && !session()->has("current_empcode")) { ?>

                        <li role="presentation" class="">
                            <a data-toggle="tab" id="membersTab" role="tab" href="#overview" aria-expanded="false">
                                {{ __('dashboard.members_tab_label') }}
                                <span class="members-count"></span>
                            </a>
                        </li>

                    <?php } ?>

                    <?php if(in_array(auth()->user()->role, Config::get('constants.amUserRoles'))) { ?>

                        {{-- <li role="presentation" class="">
                            <a data-toggle="tab" id="reportsTab" role="tab" href="#reports" aria-expanded="false">
                                {{ __('dashboard.reports_tab_label') }}
                            </a>
                        </li> --}}

                    <?php } ?>

                </ul>

			</div>

        </div>

        <div class="pull-right">

            <?php if(in_array(auth()->user()->role, Config::get('constants.pmUserRoles'))) { ?>

                <a class="pull-left inline-block btn btn-primary dashboard-email-sent-count-btn mr-5" href="{{ $emailOutboxCount == '0' ? 'javascript:void(0)' : '#sentEmailModal'}}" data-toggle="modal" title="{{ __("dashboard.email_outbox_count_tooltip") }}" data-grid-selector="emailSentCountGrid" data-grid-title="outbox email" data-count="{{ $emailOutboxCount ?? '0' }}" data-email-filter="outbox">
                    <span class="txt-light dashboard-email-outbox-count">{{ $emailOutboxCount ?? '0' }}</span>
                </a>
                <a class="pull-left inline-block btn btn-warning dashboard-email-sent-count-btn mr-5" href="{{ $emailOutboxWIPCount == '0' ? 'javascript:void(0)' : '#sentEmailModal'}}" data-toggle="modal" title="{{ __("dashboard.email_outbox_wip_count_tooltip") }}" data-grid-selector="emailSentCountGrid" data-grid-title="outbox wip email" data-count="{{ $emailOutboxWIPCount ?? '0' }}" data-email-filter="outboxwip">
                    <span class="txt-light dashboard-email-outboxwip-count">{{ $emailOutboxWIPCount ?? '0' }}</span>
                </a>
                <a class="pull-left inline-block btn btn-success dashboard-email-sent-count-btn mr-5" href="{{ $emailSentCount == '0' ? 'javascript:void(0)' : '#sentEmailModal'}}" data-toggle="modal" title="{{ __("dashboard.email_sent_count_tooltip") }}" data-grid-selector="emailSentCountGrid" data-grid-title="sent email" data-count="{{ $emailSentCount ?? '0' }}" data-email-filter="sent">
                <span class="txt-light dashboard-email-sent-count" data-email-sent-count-url="{{route('email-sent-count') ?? ''}}">{{ $emailSentCount ?? '0' }}</span>
                </a>
                <a class="pull-left inline-block btn btn-danger dashboard-email-sent-count-btn mr-5" href="{{ $emailHoldCount == '0' ? 'javascript:void(0)' : '#sentEmailModal'}}" data-toggle="modal" title="{{ __("dashboard.email_hold_count_tooltip") }}" data-grid-selector="emailSentCountGrid" data-grid-title="hold email" data-count="{{ $emailHoldCount ?? '0' }}" data-email-filter="hold">
                    <span class="txt-light dashboard-email-hold-count">{{ $emailHoldCount ?? '0' }}</span>
                </a>

            <?php } ?>

            @include('pages.dashboard.email.dashboardSentEmailModal')
            @include('pages.dashboard.email.dashboardQCEmailModal')

            <?php // if(in_array(auth()->user()->role, Config::get('constants.amUserRoles'))) { ?>

                {{-- <a class="pull-left inline-block btn bg-orange dashboard-email-sent-count-btn mr-5" href="{{ $emailNegativeCount == '0' ? 'javascript:void(0)' : '#sentEmailModal'}}" data-toggle="modal" title="{{ __("dashboard.email_negative_count_tooltip") }}" data-grid-selector="emailSentCountGrid" data-grid-title="negative email" data-count="{{ $emailNegativeCount ?? '0' }}" data-email-filter="negative">
                    <span class="txt-light dashboard-email-negative-count">{{ $emailNegativeCount ?? '0' }}</span>
                    <i class="fa fa-thumbs-down txt-light"></i>
                </a>
                <a class="pull-left inline-block btn bg-gold dashboard-email-sent-count-btn mr-5" href="{{ $emailPositiveCount == '0' ? 'javascript:void(0)' : '#sentEmailModal'}}" data-toggle="modal" title="{{ __("dashboard.email_positive_count_tooltip") }}" data-grid-selector="emailSentCountGrid" data-grid-title="positive email" data-count="{{ $emailPositiveCount ?? '0' }}" data-email-filter="positive">
                    <span class="txt-light dashboard-email-positive-count">{{ $emailPositiveCount ?? '0' }}</span>
                    <i class="fa fa-thumbs-up txt-light"></i>
                </a> --}}

                {{-- @include('pages.dashboard.email.dashboardSentEmailModal') --}}

            <?php // } ?>


            <?php if(isset($jobAddUrl) && $jobAddUrl != "") { ?>

                <a class="pull-left inline-block btn btn-success new-job-btn mr-15" href="#newJobModal" data-toggle="modal"
                    title="{{ __("dashboard.new_job_title") }}" >
                    {{ __("dashboard.new_job_btn_label") }}
                </a>
                @include('pages.job.newJobModal')

            <?php } ?>

            <a class="pull-left inline-block mr-15 collapsed" data-toggle="collapse" href="#dashboard_job_pannel"
                aria-expanded="false">
                <i class="zmdi zmdi-chevron-down job-status-i"></i>
                <i class="zmdi zmdi-chevron-up job-status-i"></i>
            </a>
            <a href="#" class="pull-left inline-block full-screen mr-15">
                <i class="zmdi zmdi-fullscreen job-status-i"></i>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
<div id="dashboard_job_pannel" class="panel-wrapper collapse {{ $overViewExpand }} dashboard-job-panel">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="pills-struct">
                    <div class="tab-content" id="">
                        <div id="overview" class="tab-pane fade active in pt-10 jobOverviewTab" role="tabpanel" data-member-job-count-url="{{ $memberJobCountUrl }}">

                            @include('pages.dashboard.dashboardOverview')

                            <?php if(in_array(auth()->user()->role, config('constants.amUserRoles'))) { ?>

                                @include('pages.dashboard.am.dashboardTaskOverview')

                            <?php } ?>

                        </div>

                        <div id="stage" class="tab-pane fade" role="tabpanel">

                            @include('pages.dashboard.dashboardStage')

                        </div>

                        <div id="financial" class="tab-pane fade" role="tabpanel" style="height: 200px;">

                            {{-- @include('pages.dashboard.dashboardFinancialInVoice') --}}

                        </div>

                        <?php if(in_array(auth()->user()->role, config('constants.amUserRoles'))) { ?>

                            {{-- <div id="reports" class="tab-pane fade pt-0" role="tabpanel">

                                @include('pages.dashboard.reports.dashboardReportsOverview')

                            </div> --}}

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
