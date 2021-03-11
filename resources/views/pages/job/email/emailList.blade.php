<div class="mail-box">
    <div class="row">

        @include('pages.job.email.emailboxnavmenu')

        <aside class="col-lg-10 col-md-10 col-sm-10 col-xs-10 pl-0 job-email-grid-block">
            <div class="inbox-body email-list-body pa-0">
                <div id="jobEmail" class="jobEmailGrid emailGrid tab-pane fade pt-0 active in" data-category="jobEmail" data-type="jobDetail"
                    data-email-filter="inbox" data-list-url="{{ $jobEmailListUrl }}" data-current-route="{{ Route::currentRouteName() }}"
                    data-current-user-id="{{ Auth::user()->empcode }}" data-current-job-id="{{ $jobId }}" data-pe-email="{{ $peEmail ?? '' }}" data-author-email="{{ $authorEmail ?? '' }}"></div>
            </div>
            @include('pages.email.emaildetail')
        </aside>
    </div>
</div>
