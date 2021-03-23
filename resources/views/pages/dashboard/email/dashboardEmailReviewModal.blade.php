<!-- Modal -->
<div aria-hidden="true" role="dialog" id="emailReviewModal" class="review-email-modal modal fade" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close"
                    type="button">×</button>
                <h4 class="modal-title dashboard-email-review-modal-title"></h4>
            </div>
            <div class="modal-body pt-0">
                <div class="mail-box">
                    <div class="row">
                        <aside class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 pr-0 border-block">
                            <div class="inbox-body review-email-modal-list-body pa-0">
                                <div id="review-email-modal-grid" class="review-email-modal-grid emailGrid tab-pane fade pt-0 active in" data-category="email-review-latest" data-type="dashboard" data-email-filter=""
                                    data-list-url="{{ $myEmailListUrl }}" data-email-category-move-to-url="{{ $emailCategoryMoveToUrl }}" data-current-route="{{ $currentRoute }}"
                                    data-current-user-id="{{ Auth::user()->empcode }}"></div>
                            </div>
                            @include('pages.email.emailReviewModalDetail')
                        </aside>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

