<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pa-0 pb-5 border-block">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-5 pr-5">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border-block pa-10 mt-5 mb-5">

            <form class="">

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl-0">

                    <div class="form-group mb-0">

                        <input class="form-control report-daterange-datepicker report-datepicker h-42-px"
                            placeholder="{{ __('dashboard.report_range_placeholder_text') }}" />

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

        <table id="classified-email-report-grid"
            class="classified-email-report-grid table table-striped table-bordered nowrap ma-0 wd-100" data-type="dashboard"
            data-category="classified_email" data-list-url="{{ $classifiedEmailReportListUrl }}"
            data-current-route="{{ $currentRoute }}">

            <thead>

                <tr>

                    <th class="capitalize-font text-center nosort">S.No</th>
                    <th class="capitalize-font text-center nosort">PM Name</th>
                    <th class="capitalize-font text-center wd-10">Date</th>
                    <th class="capitalize-font text-center wd-15">First Login Time</th>
                    <th class="capitalize-font text-center wd-15">Last Logout Time</th>
                    <th class="capitalize-font text-center">Overall Time</th>
                    <th class="capitalize-font text-center nosort">Positive</th>
                    <th class="capitalize-font text-center nosort">Neutral</th>
                    <th class="capitalize-font text-center nosort">Negative</th>

                </tr>

            </thead>

        </table>

    </div>

</div>
