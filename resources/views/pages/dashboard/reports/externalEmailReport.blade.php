{{-- <div id="received-email-report-grid" class="received-email-report-grid" data-type="dashboard" data-category="received-email" data-list-url="{{ $checkListUrl }}"
data-current-route="{{ $currentRoute }}">
</div> --}}

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 pr-0 pt-10">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl-0">
        <div class="form-group mb-0">
            <input class="form-control report-daterange-timepicker report-datepicker h-42-px"
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

<table id="external-email-report-grid" class="external-email-report-grid table table-striped table-bordered nowrap ma-0 wd-100" data-type="dashboard"
    data-category="external_email" data-list-url="{{ $externalEmailReportListUrl }}" data-current-route="{{ $currentRoute }}">
    <thead>
        <tr>
            <th rowspan="2" class="capitalize-font text-center nosort">S.No</th>
            <th rowspan="2" class="capitalize-font text-center nosort">PM Name</th>
            <th rowspan="2" class="capitalize-font text-center nosort">Total</th>
            <th rowspan="2" class="capitalize-font text-center nosort">Internal</th>
            <th rowspan="2" class="capitalize-font text-center nosort">External</th>
            <th rowspan="2" class="capitalize-font text-center nosort">Positive</th>
            <th rowspan="2" class="capitalize-font text-center nosort">Neutral</th>
            <th rowspan="2" class="capitalize-font text-center nosort">Negative</th>
            <th colspan="3" class="capitalize-font text-center report-email-info-bg nosort datatable_border_right" style="border-bottom: 1px solid #111 !important;">Last 24<br><span class="column-note capitalize-font text-center">(Hours)</span></th>
            <th colspan="3" class="capitalize-font text-center report-email-info-bg nosort datatable_border_right" style="border-bottom: 1px solid #111 !important;">Last 24 To 48<br><span class="column-note capitalize-font text-center">(Hours)</span></th>
            <th rowspan="2" class="capitalize-font text-center report-email-info-bg nosort datatable_border_right">Above 48<br><span class="column-note capitalize-font text-center">(Hours)</span></th>
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
