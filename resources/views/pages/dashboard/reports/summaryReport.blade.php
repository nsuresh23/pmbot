<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pa-0 pb-5 border-block">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-5 pr-5">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border-block pa-10 mt-5 mb-5">

            <form class="">

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl-0">

                    <div class="form-group mb-0">

                        <input class="form-control report-daterange-datepicker report-datepicker h-42-px" placeholder="{{ __('dashboard.report_range_placeholder_text') }}" />

                    </div>

                </div>

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

                        <button type="button" class="btn btn-success btn-anim report-filter-sumbit-btn pl-25 pr-25 pt-10 pb-10">

                            <i class="fa fa-check"></i>
                            <span class="btn-text">{{ __('dashboard.filter_submit_label')}}</span>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-5 pr-5">

        <table id="summary-report-grid" class="summary-report-grid table table-striped table-bordered nowrap ma-0 wd-100" data-type="dashboard" data-category="summary" data-list-url="{{ $summaryReportListUrl }}" data-current-route="{{ $currentRoute }}">

            <thead>

                <tr>

                    <th rowspan="2" class="nosort capitalize-font text-center">S.No</th>
                    <th rowspan="2" class="nosort capitalize-font text-center">PM Name</th>
                    <th rowspan="2" class="wd-10 capitalize-font text-center">Date</th>
                    <th rowspan="2" class="capitalize-font text-center wd-15">First Login Time</th>
                    <th rowspan="2" class="capitalize-font text-center wd-15">Last Logout Time</th>
                    <th rowspan="2" class="capitalize-font text-center">Overall Time</th>
                    <th colspan="3" class="capitalize-font text-center report-email-info-bg nosort datatable_border_right" style="border-bottom: 1px solid #111 !important;">Emails Received</th>
                    <th colspan="3" class="capitalize-font text-center report-email-info-bg nosort" style="border-bottom: 1px solid #111 !important;">Emails Sent</th>

                </tr>

                <tr>

                    <th class="capitalize-font text-center nosort">Count</th>
                    <th class="capitalize-font text-center nosort ">Time</th>
                    <th class="capitalize-font text-center nosort ">Average</th>
                    <th class="capitalize-font text-center nosort">Count</th>
                    <th class="capitalize-font text-center nosort ">Time</th>
                    <th class="capitalize-font text-center nosort ">Average</th>

                </tr>

            </thead>

        </table>

    </div>

</div>


