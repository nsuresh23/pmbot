<div class="mail-box">
    <div class="row">

        @include('pages.dashboard.email.nonBusinessEmailBoxNavMenu')

        <aside class="col-lg-10 col-md-10 col-sm-10 col-xs-10 pl-0">

            <div id="loader" class="email_nonbusiness_grid_loader" style="display: none;width: 100%;height: 100%;position: absolute;padding: 2px;z-index: 1;text-align: center;">
                <img src="{{ asset('public/img/loader2.gif') }}" width="64" height="64" />
            </div>

            <div class="inbox-body email-list-body pa-0">
                <div id="nonBusinessEmailGrid" class="nonBusinessEmailGrid emailGrid tab-pane fade pt-0 active in" data-category="nonBusinessEmail"
                    data-type="dashboard" data-email-filter="inbox" data-list-url="{{ $myEmailListUrl }}"
                    data-current-route="{{ $currentRoute }}" data-current-user-id="{{ Auth::user()->empcode }}"></div>
            </div>
            @include('pages.email.emaildetail')
        </aside>

    </div>
</div>
