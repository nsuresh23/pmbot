<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pa-0 pl-5">
        <div class="tab-pane fade pt-0 active in">
            <div id="loader" class="pmsemailcount_loader" style="display: none;width: 100%;height: 100%;position: absolute;padding: 2px;z-index: 1;text-align: center;">
                <img src="{{ asset('public/img/loader2.gif') }}" width="64" height="64" />
            </div>
            <div id="pmsEmailCountGrid" class="pmsEmailCountGrid" data-type="dashboard" data-list-url="{{ $pmsEmailCountUrl }}" data-current-route="{{ $currentRoute }}"></div>
        </div>
    </div>
</div>
