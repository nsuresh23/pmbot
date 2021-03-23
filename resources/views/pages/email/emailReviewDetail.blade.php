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

@include('pages.dashboard.email.dashboardEmailReviewModal')

<div class="row email-detail-body" style="display:none;">

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

        <div class="pa-0 border-block">
            <div class="heading-inbox">
                <div class="container-fluid mt-5 pr-0 pl-0">
                    <div class="pull-left">
                        <div class="">
                            <a class="email-detail-back-btn btn btn-sm mr-10" href="#" title="Back">
                                <i class="zmdi zmdi-chevron-left"></i></a>
                        </div>
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn btn-warning bg-warning email-latest-received-btn mr-10 pl-15 pr-15 pt-5 pb-5" data-email-get-url="{{route(__('dashboard.email_review_update_url' ?? ''))}}">
                            Latest received
                        </button>
                        <button type="button" class="btn btn-warning bg-warning email-latest-sent-btn mr-10 pl-15 pr-15 pt-5 pb-5" data-email-get-url="{{route(__('dashboard.email_review_update_url' ?? ''))}}">
                            Latest sent
                        </button>
                        <button type="button" class="btn btn-danger bg-danger email-unreview-btn mr-10 pl-15 pr-15 pt-5 pb-5" data-email-review-update-url="{{route(__('dashboard.email_review_update_url' ?? ''))}}">
                            unreview
                        </button>
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
                <textarea id="email-review-body" class="form-control email-body border-none" name="email-body"
                    rows="15"></textarea>
            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl-0 pr-25">
        <div class="panel panel-default card-view border-block email-rating-block">
            {{-- <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Key Metrics</h6>
                </div>
                <div class="clearfix"></div>
            </div> --}}
            <div class="panel-wrapper collapse in">
                <div class="panel-body pt-0">
                    <form class="email-rating-form" action="{{ $emailRatingUrl ?? '#' }}">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                            <label class="txt-dark">Quality of Communication:</label>
                            <hr class="light-grey-hr mt-5 mb-5">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                            <div class="form-group mb-0">
                                <span class="txt-dark rating-label">Issue resolved in fewer rounds:</span>
                                <input name="issue" value="2" data-size="sm" title="" class="star-block rating-loading issue">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                            <div class="form-group mb-0">
                                <span class="txt-dark rating-label">Responded with factual clarity:</span>
                                <input name="responded" value="2" data-size="sm" title="" class="star-block rating-loading responded">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                            <div class="form-group mb-0">
                                <span class="txt-dark rating-label">Language used in communication:</span>
                                <input name="language" value="2" data-size="sm" title="" class="star-block rating-loading language">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                            <div class="form-group mb-0">
                                <span class="txt-dark rating-label">Satisfaction of the affected stakeholder:</span>
                                <input name="satisfaction" value="2" data-size="sm" title="" class="star-block rating-loading satisfaction">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                            <hr class="light-grey-hr mt-5 mb-5">
                            <label class="txt-dark">Speed of Communication:</label>
                            <hr class="light-grey-hr mt-5 mb-5">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                            <div class="form-group mb-0">
                                {{-- <span class="txt-dark">Assertiveness:</span> --}}
                                <input name="speed" value="2" data-size="sm" title="" class="star-block rating-loading speed">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 pt-15">
                            <div class="form-group mb-0">
                                <button type="button" class="btn btn-success btn-anim email-rating-sumbit-btn pull-right" data-email-get-url=""><i class="fa fa-check"></i><span class="btn-text">{{ __('dashboard.filter_submit_label')}}</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
