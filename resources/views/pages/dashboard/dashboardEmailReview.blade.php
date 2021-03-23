<div class="mail-box">
    <div class="row">

        {{-- @include('pages.dashboard.email.emailboxnavmenu') --}}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border-block pa-10 mt-10 mb-10">

                <form class="">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl-0">
                        <div class="form-group mb-0">
                            {!! Form::select('user_empcode', [ "" =>
                            __('dashboard.review_user_select_placeholder_text') ] +
                            $returnResponse["member_select_list"], null,
                            ['class' => 'select2 user-empcode',
                            ])
                            !!}
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl-0">
                        <div class="form-group mb-0">
                            <input class="form-control review-daterange-datepicker date-range-picker h-42-px" placeholder="{{ __('dashboard.report_range_placeholder_text') }}" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pl-0">
                        <div class="form-group mb-0">
                            <div class="input-group">
                                <div class="input-group-button">
                                    {!! Form::select('sort_type', [ "" =>
                                    __('dashboard.sort_type_select_placeholder_text') ] +
                                    $returnResponse["sort_type_list"], $returnResponse["sort_type_list"]["newer"],
                                    ['class' => 'select2 sort-type',
                                    ])
                                    !!}
                                </div>
                                <input type="number" class="form-control sort-limit h-42-px" placeholder="{{ __('dashboard.sort_limit_placeholder_text') }}" name="sort_limit" value="5" />
                            </div>
                            {{-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pl-0">
                                <input type="number" class="form-control sort-limit h-42-px" placeholder="{{ __('dashboard.sort_limit_placeholder_text') }}" name="sort_limit" value="10" />
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pl-0">
                        <div class="form-group mb-0">
                            <button type="button" class="btn btn-success btn-anim reviewed-email-sumbit-btn pl-25 pr-25 pt-10 pb-10"><i class="fa fa-check"></i><span class="btn-text">{{ __('dashboard.filter_submit_label')}}</span></button>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pl-0">
                        <div class="form-group mb-0 text-bold">
                            <p class="text-center mb-0">{{ __('dashboard.reviewed_count_label')}}</p>
                            <p class="text-center mb-0 reviewed-email-count">0</p>
                        </div>
                    </div>

                </form>

            </div>

        </div>

        <aside class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="inbox-body email-list-body pa-0">
                <div id="email-review" class="reviewEmailGrid emailGrid tab-pane fade pt-0 active in" data-category="email-review"
                    data-type="dashboard" data-email-filter="email_review" data-list-url="{{ $myEmailListUrl }}"
                    data-current-route="{{ $currentRoute }}" data-current-user-id="{{ Auth::user()->empcode }}"></div>
            </div>
            {{-- <div class="inbox-body email-list-body pa-0">
                <div id="myEmail" class="myEmailGrid emailGrid tab-pane fade pt-0 active in" data-category="myEmail"
                    data-type="dashboard" data-email-filter="" data-list-url="{{ $myEmailListUrl }}"
                    data-current-route="{{ $currentRoute }}" data-current-user-id="{{ Auth::user()->empcode }}"></div>
            </div> --}}
            @include('pages.email.emailReviewDetail')
        </aside>

    </div>
</div>
