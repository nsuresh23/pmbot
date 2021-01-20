{{-- <div id="classified-email-report-grid" class="classified-email-report-grid" data-type="dashboard" data-category="classified-email" data-list-url="{{ $checkListUrl }}"
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

<table id="classified-email-report-grid" class="classified-email-report-grid table table-striped table-bordered nowrap ma-0 wd-100" data-type="dashboard"
    data-category="classified_email" data-list-url="{{ $classifiedEmailReportListUrl }}" data-current-route="{{ $currentRoute }}">
    <thead>
        <tr>
            <th class="nosort">SNO</th>
            <th class="nosort">PM Name</th>
            <th class="wd-10">Date</th>
            <th class="wd-15">First Login Time</th>
            <th class="wd-15">Last Logout Time</th>
            <th class="">Overall Time</th>
            <th class="nosort">Positive</th>
            <th class="nosort">Neutral</th>
            <th class="nosort">Negative</th>
        </tr>
    </thead>
</table>
