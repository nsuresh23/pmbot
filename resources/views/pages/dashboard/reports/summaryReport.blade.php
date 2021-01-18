{{-- <div id="summary-report-grid" class="summary-report-grid" data-type="dashboard" data-category="summary" data-list-url="{{ $checkListUrl }}"
data-current-route="{{ $currentRoute }}">
</div> --}}

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 pr-0 pt-10">
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pl-0">
        <div class="form-group mb-0">
        <input class="form-control report-daterange-datepicker h-42-px" placeholder="{{ __('dashboard.report_range_placeholder_text') }}" />
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pl-0">
        <div class="form-group mb-0">
            {!! Form::select('report_type', [ "" =>
            __('dashboard.report_type_select_placeholder_text') ] +
            $returnResponse["report_type_list"], null,
            ['class' => 'select2 report-type',
            ])
            !!}
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
</div>

<table id="summary-report-grid" class="summary-report-grid table display ma-0" data-type="dashboard" data-category="summary"
    data-list-url="{{ $summaryReportListUrl }}" data-current-route="{{ $currentRoute }}">
    <thead>
        <tr>
            <th rowspan="2">SNO</th>
            <th rowspan="2">PM Name</th>
            <th rowspan="2">Date (History) list of login and logout and session time</th>
            <th rowspan="2">First Login Time</th>
            <th rowspan="2">Last Logout Time</th>
            <th rowspan="2">Overall Time</th>
            <th colspan="3">Emails Received (Business)</th>
            <th colspan="3">Emails Sent (Business)</th>
        </tr>
        <tr>
            <th>Count</th>
            <th>Time</th>
            <th>Average</th>
            <th>Count</th>
            <th>Time</th>
            <th>Average</th>
        </tr>
    </thead>
</table>
