<div class="mail-box">
    <div class="row">

        @include('pages.dashboard.email.businessEmailBoxNavMenu')

        <aside class="col-lg-10 col-md-10 col-sm-10 col-xs-10 pl-0">
            <div class="inbox-body email-list-body pa-0">
                <div id="businessEmailGrid" class="businessEmailGrid emailGrid tab-pane fade pt-0 active in" data-category="businessEmail"
                    data-type="dashboard" data-email-filter="inbox" data-list-url="{{ $myEmailListUrl }}"
                    data-current-route="{{ $currentRoute }}" data-current-user-id="{{ Auth::user()->empcode }}"></div>
            </div>
            @include('pages.email.emaildetail')
        </aside>

    </div>
</div>
