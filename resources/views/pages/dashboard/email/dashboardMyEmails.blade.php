<div class="mail-box">
    <div class="row">

        {{-- @include('pages.dashboard.email.emailboxnavmenu') --}}

        <aside class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="inbox-body email-list-body pa-0">
                <div id="myEmail" class="myEmailGrid emailGrid tab-pane fade pt-0 active in" data-category="myEmail"
                    data-type="dashboard" data-email-filter="" data-list-url="{{ $myEmailListUrl }}"
                    data-current-route="{{ $currentRoute }}" data-current-user-id="{{ Auth::user()->empcode }}"></div>
            </div>
            @include('pages.email.emaildetail')
        </aside>

    </div>
</div>