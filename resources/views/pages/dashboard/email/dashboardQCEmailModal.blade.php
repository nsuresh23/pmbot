<!-- Modal -->
<div aria-hidden="true" role="dialog" id="QCEmailModal" class="sent-email-modal modal fade"
    style="display: none;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close"
                    type="button">×</button>
                <h4 class="modal-title dashboard-email-qc-count-modal-title"></h4>
            </div>
            <div class="modal-body pt-0">
                <div class="mail-box">
                    <div class="row">
                        <aside class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                            <div class="inbox-body email-list-body pa-0">
                                <div id="emailQCCountGrid" class="emailQCCountGrid emailGrid tab-pane fade pt-0 active in"
                                    data-category="qcEmail" data-type="dashboard" data-email-filter=""
                                    data-list-url="{{ $myEmailListUrl }}" data-email-category-move-to-url="{{ $emailCategoryMoveToUrl }}" data-current-route="{{ $currentRoute }}"
                                    data-current-user-id="{{ Auth::user()->empcode }}"></div>
                            </div>
                            {{-- @include('pages.email.emailSentDetail') --}}
                            @include('pages.email.qcEmailDetail')
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

