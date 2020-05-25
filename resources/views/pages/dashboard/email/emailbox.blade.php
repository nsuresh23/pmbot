<div class="mail-box">
    <div class="row">
        
        @include('pages.dashboard.email.emailboxnavmenu')
        
        <aside class="col-lg-10 col-md-10 col-sm-10 col-xs-10 pl-0">
            <div class="inbox-body pa-0">
                <div id="myEmail" class="myEmailGrid tab-pane fade pt-0 active in" data-category="myemail" data-type="dashboard" data-email-filter="inbox" 
                    data-list-url="{{ $myEmailListUrl }}" data-current-route="{{ $currentRoute }}"
                    data-current-user-id="{{ Auth::user()->empcode }}"></div>
            </div>
        </aside>
    </div>
</div>