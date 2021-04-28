<!-- Row -->
<div class="row pl-10 pr-10" >
    <!-- Pannel -->
    <div class="panel panel-default card-view mb-0 pa-0 report-block">

        <div class="panel-heading ma-0 pa-0 border-bottom-none">

            <div class="pull-left">

                <ul role="tablist" class="nav nav-pills nav-pills-outline dashboard-job-tabs" id="">

                    <li class="active" role="presentation">
                        <a aria-expanded="true" data-toggle="tab" role="tab" id="summaryReportTab"
                            href="#summary-report">{{ __('dashboard.summary_report_tab_label') }}</a>
                    </li>

                    <li role="presentation" class="">
                        <a data-toggle="tab" id="receivedEmailReportTab" role="tab" href="#received-email-report"
                            aria-expanded="false">{{ __('dashboard.received_email_report_tab_label') }}</a>
                    </li>

                    <li role="presentation" class="">
                        <a data-toggle="tab" id="sentEmailReportTab" role="tab" href="#sent-email-report"
                            aria-expanded="false">{{ __('dashboard.sent_email_report_tab_label') }}</a>
                    </li>

                    <li role="presentation" class="">
                        <a data-toggle="tab" id="classificationEmailReportTab" role="tab" href="#classification-email-report"
                            aria-expanded="false">{{ __('dashboard.classification_email_report_tab_label') }}</a>
                    </li>

                    <li role="presentation" class="">
                        <a data-toggle="tab" id="externalEmailReportTab" role="tab" href="#external-email-report"
                            aria-expanded="false">{{ __('dashboard.external_email_report_tab_label') }}</a>
                    </li>

                    <li role="presentation" class="">
                        <a data-toggle="tab" id="reviewedEmailReportTab" role="tab" href="#reviewed-email-report"
                            aria-expanded="false">{{ __('dashboard.reviewed_email_report_tab_label') }}</a>
                    </li>

                </ul>

            </div>

            <div class="pull-right">

                {{-- <a href="#" class="pull-left inline-block full-screen mr-15">
                    <i class="zmdi zmdi-fullscreen job-status-i"></i>
                </a> --}}

            </div>

            <div class="clearfix"></div>

        </div>

        <div class="panel-wrapper">

            <div class="panel-body pa-0">

                <div class="tab-content" id="">

                    <div id="summary-report" class="tab-pane fade active in pa-0" role="tabpanel">

                        @include('pages.dashboard.reports.summaryReport')

                    </div>

                    <div id="received-email-report" class="tab-pane fade pa-0" role="tabpanel">

                        @include('pages.dashboard.reports.emailReceivedReport')

                    </div>

                    <div id="sent-email-report" class="tab-pane fade pa-0" role="tabpanel">

                        @include('pages.dashboard.reports.emailSentReport')

                    </div>

                    <div id="classification-email-report" class="tab-pane fade pa-0" role="tabpanel">

                        @include('pages.dashboard.reports.emailClassificationReport')

                    </div>

                    <div id="external-email-report" class="tab-pane fade pa-0" role="tabpanel">

                        @include('pages.dashboard.reports.externalEmailReport')

                    </div>

                    <div id="reviewed-email-report" class="tab-pane fade pa-0" role="tabpanel">

                        @include('pages.dashboard.reports.reviewedEmailReport')

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /Pannel -->

</div>
<!-- /Row -->


