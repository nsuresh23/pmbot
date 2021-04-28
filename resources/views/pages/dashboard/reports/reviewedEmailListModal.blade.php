<!-- Modal -->

<div id="reviewedEmailListModal" class="modal fade large reviewed-email-list-modal" style="display: none;" role="dialog" aria-labelledby="reviewedEmailListModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title reviewed-email-list-modal-title">Reviewed Email</h4>
            </div>
            <div class="modal-body table-container pa-0">
                <aside class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pa-0 bg-light">
                    <div class="inbox-body email-list-body bg-light pa-0">
                        <div class="reviewed-email-grid emailGrid tab-pane fade pt-0 active in"
                            data-category="email-review" data-type="dashboard" data-email-filter="email_reviewed"
                            data-list-url="{{ $myEmailListUrl }}" data-current-route="{{ $currentRoute }}"
                            data-current-user-id="{{ Auth::user()->empcode }}"></div>
                    </div>
                    @include('pages.email.emailReviewedDetail')
                </aside>
            </div>
        </div>
    </div>
</div>
