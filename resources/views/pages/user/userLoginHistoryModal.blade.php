<!-- Modal -->

<div id="userLoginHistoryModal" class="modal fade large user-login-history-modal" style="display: none;" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title user-login-history-modal-title"></h4>
            </div>
            <div class="modal-body table-container pa-0">
                <div id="loader" class="userLoginHistory_loader" style="display: none;width: 100%;height: 100%;position: absolute;padding: 2px;z-index: 1;text-align: center;">
                    <img src="{{ asset('public/img/loader2.gif') }}" width="64" height="64" />
                </div>
                <div id="user-login-history-grid" class="user-login-history-grid tab-pane fade pt-0 active in" data-type="dashboard" data-category="user_login_history" data-list-url="{{ $userLoginHistoryListUrl }}" data-current-route="{{ $currentRoute }}"></div>
            </div>
        </div>
    </div>
</div>
