{{-- <div id="sent-email-report-grid" class="sent-email-report-grid" data-type="dashboard" data-category="sent-email" data-list-url="{{ $checkListUrl }}"
data-current-route="{{ $currentRoute }}">
</div> --}}

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 pr-0 pt-10">
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pl-0">
        <div class="form-group mb-0">
            <input class="form-control report-daterange-datepicker h-42-px"
                placeholder="{{ __('dashboard.report_range_placeholder_text') }}" />
        </div>
    </div>
    {{-- <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pl-0">
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
</div>

<table id="sent-email-report-grid" class="sent-email-report-grid table table-striped table-bordered nowrap ma-0 wd-100" data-type="dashboard"
    data-category="sent_email" data-list-url="{{ $sentEmailReportListUrl }}" data-current-route="{{ $currentRoute }}">
    <thead>
        <tr>
            <th rowspan="2" class="nosort">SNO</th>
            <th rowspan="2" class="nosort">PM Name</th>
            <th rowspan="2" class="wd-10">Date</th>
            <th rowspan="2" class="wd-15">First Login Time</th>
            <th rowspan="2" class="wd-15">Last Logout Time</th>
            <th rowspan="2" class="">Overall Time</th>
            <th colspan="3" class="report-email-info-bg nosort">Title</th>
            <th colspan="3" class="report-email-info-bg nosort">Non Business</th>
            <th colspan="3" class="report-email-info-bg nosort">Generic</th>
        </tr>
        <tr>
            <th class="nosort">Count</th>
            <th class="nosort ">Time</th>
            <th class="nosort ">Average</th>
            <th class="nosort">Count</th>
            <th class="nosort ">Time</th>
            <th class="nosort ">Average</th>
            <th class="nosort">Count</th>
            <th class="nosort ">Time</th>
            <th class="nosort ">Average</th>
        </tr>
    </thead>
</table>
