<style>
    .btn-success {
        background-color: #5cb85c !important;
        border-color: #4cae4c !important;
    }

    .btn-block {
        color: #fff !important;
        text-decoration: none !important;
    }
	.email-title {text-transform:none !important;}
</style>

<div id="loader" class="email_detail_loader" style="display: none;width: 100%;height: 100%;position: absolute;padding: 2px;z-index: 1;text-align: center;">
    <img src="{{ asset('public/img/loader2.gif') }}" width="64" height="64" />
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 review-email-modal-detail-body inbox-body" style="display:none;">
    <div class="heading-inbox">
        <div class="container-fluid mt-5 pr-0 pl-0">
            <div class="pull-left">
                <div class="">
                    <a class="review-email-modal-detail-back-btn btn btn-sm mr-10" href="#" title="Back">
                        <i class="zmdi zmdi-chevron-left"></i></a>
                </div>
            </div>
        </div>

        <hr class="light-grey-hr mt-5 mb-5" />
        <div class="container-fluid email-title-block" style="display:none;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <h4 class="weight-500 email-title" data-email-id=""></h4>
                </div>
            </div>
        </div>

    </div>
    <div class="sender-info">
        <div class="container-fluid">
            <div class="sender-details pull-left">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 email-from-block" style="display: none;">
                    <div class="row">
                        <label>From:</label>
                        <span class="email-from"></span>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 email-to-block" style="display: none;">
                    <div class="row">
                        <label>To:</label>
                        <span class="email-to"></span>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 email-cc-block" style="display: none;">
                    <div class="row">
                        <label>CC:</label>
                        <span class="email-cc"></span>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 email-bcc-block" style="display: none;">
                    <div class="row">
                        <label>BCC:</label>
                        <span class="email-bcc"></span>
                    </div>
                </div>
            </div>
            <div class="pull-right">
                <div class="inline-block mr-5">
                    <span class="inbox-detail-time-1 font-12 email-date-block email-date"
                        style="display: none;"></span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <hr class="light-grey-hr mt-5 mb-5" />
    <div class="container-fluid attachment-block attachment-mail" style="display: none;">
        <div class="download-blocks mb-10">
            <span class="pr-15"><i class="zmdi zmdi-attachment-alt pr-10"></i><span class="attachment-count"></span>
                attachments</span>
        </div>
        <ul class="attachment-items mb-0">
        </ul>
    </div>
    <hr class="light-grey-hr mt-5 mb-5" />

    <div class="view-mail email-body-block hiddenBlock">
        <textarea id="review-email-modal-body" class="form-control review-email-body border-none" name="email-body"
            rows="15"></textarea>
    </div>

</div>
