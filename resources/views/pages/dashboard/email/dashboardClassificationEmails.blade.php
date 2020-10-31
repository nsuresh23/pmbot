<div class="mail-box">
    <div class="row">

        <aside class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
            <div class="inbox-body email-list-body pa-0">
                <div id="classificationEmailGrid" class="classificationEmailGrid emailGrid tab-pane fade pt-0 active in" data-category="classificationEmail"
                    data-type="dashboard" data-email-filter="negative" data-list-url="{{ $myEmailListUrl }}"
                    data-current-route="{{ $currentRoute }}" data-current-user-id="{{ Auth::user()->empcode }}" data-empcode="{{ Auth::user()->empcode }}"></div>
            </div>
            @include('pages.email.emaildetail')
        </aside>

    </div>
</div>
