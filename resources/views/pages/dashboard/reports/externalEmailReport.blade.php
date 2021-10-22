<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pa-0 pb-5 border-block">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-5 pr-5">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border-block pa-10 mt-5 mb-5">

            <form class="">

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl-0">

                    <div class="form-group mb-0">

                        <input class="form-control report-daterange-datepicker report-datepicker h-42-px" placeholder="{{ __('dashboard.report_range_placeholder_text') }}" />

                    </div>

                </div>

                {{-- <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl-0">

                    <div class="form-group mb-0">

                        {!! Form::select('report_type', [ "" =>
                        __('dashboard.report_type_select_placeholder_text') ] +
                        $returnResponse["report_type_list"], null,
                        ['class' => 'select2 report-type',
                        ])
                        !!}

                    </div>

                </div> --}}

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl-0">

                    <div class="form-group mb-0">

                        {!! Form::select('user_empcode', [ "" =>
                        __('dashboard.report_user_select_placeholder_text') ] +
                        $returnResponse["user_list"], null,
                        ['class' => 'select2 user-empcode',
                        ])
                        !!}

                    </div>

                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pl-0">

                    <div class="form-group mb-0">

                        <button type="button"
                            class="btn btn-success btn-anim report-filter-sumbit-btn pl-25 pr-25 pt-10 pb-10">

                            <i class="fa fa-check"></i>
                            <span class="btn-text">{{ __('dashboard.filter_submit_label')}}</span>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-5 pr-5">

        <table id="external-email-report-grid" class="external-email-report-grid table table-striped table-bordered nowrap ma-0 wd-100" data-type="dashboard" data-category="external_email" data-list-url="{{ $externalEmailReportListUrl }}" data-current-route="{{ $currentRoute }}">

            <thead>

                <tr>

                    <th rowspan="2" class="capitalize-font text-center nosort">S.No</th>
                    <th rowspan="2" class="capitalize-font text-center nosort">PM Name</th>
                    <th rowspan="2" class="capitalize-font text-center nosort datatable_border_right"># Of Emails Un-Responded</th>
                    <th colspan="4" class="capitalize-font text-center report-user-login-info-bg nosort datatable_border_right" style="border-bottom: 1px solid #111 !important;">Email Sentiment</th>
                    <th colspan="2" class="capitalize-font text-center report-email-info-bg nosort" style="border-bottom: 1px solid #111 !important;">Response Time</th>

                </tr>

                <tr>

                    <th class="capitalize-font text-center nosort">Not Set</th>
                    <th class="capitalize-font text-center nosort">Positive</th>
                    <th class="capitalize-font text-center nosort">Neutral</th>
                    <th class="capitalize-font text-center nosort">Negative</th>
                    <th class="capitalize-font text-center nosort"># Of Emails Responded</th>
                    <th class="capitalize-font text-center nosort ">Avg.Response Time Per Email<br><span class="column-note capitalize-font text-center">(In Hours)</span></th>

                </tr>

            </thead>

            <tfoot>

                <tr>

                    <th style="text-align:center">Total</th>
                    <th class="pm_total" style="text-align:center"></th>
                    <th class="emails_unresponded_total" style="text-align:center"></th>
                    <th class="noset_total" style="text-align:center"></th>
                    <th class="positive_total" style="text-align:center"></th>
                    <th class="neutral_total" style="text-align:center"></th>
                    <th class="negative_total" style="text-align:center"></th>
                    <th class="emails_responded_total" style="text-align:center"></th>
                    <th class="average_response_time_total" style="text-align:center"></th>

                </tr>

            </tfoot>

        </table>

    </div>

</div>
