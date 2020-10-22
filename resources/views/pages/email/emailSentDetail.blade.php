<style>
    .btn-success {
        background-color: #5cb85c !important;
        border-color: #4cae4c !important;
    }

    .btn-block {
        color: #fff !important;
        text-decoration: none !important;
    }

    .email-title {
        text-transform: none !important;
    }
</style>
<div class="email-detail-body inbox-body pa-0" style="display:none;">
    <div class="heading-inbox">
        <div class="container-fluid mt-5 pr-0">
            <div class="pull-left">
                <div class="">
                    <a class="email-detail-back-btn btn btn-sm mr-10" href="#" title="Back">
                        <i class="zmdi zmdi-chevron-left"></i></a>
                </div>
            </div>
            <div class="email-button-group">

                <div class="email-move-to-block" style="float:right;margin-right:5px;display:none;">

                    <div class="pull-left inline-block">
                        <form class="form-inline email-move-to-form" action="{{ route(__('job.email_move_to_url')) }}">
                            <input type="hidden" class="email-move-to-email-id" name="id" value="" />
                            <div class="form-group">
                                <div class="input-group email-move-to-input-group">
                                    <div class="input-group-btn">
                                        <span type="button" class="btn bg-warning txt-light pt-10 pb-10 pr-10">
                                            {{-- <span class="fa fa-arrow-circle-right"></span> --}}
                                            {{ __('job.email_move_to_label') }}
                                        </span>
                                    </div>
                                    <select class="form-control select2 email-move-to-input" name="label_name"
                                        style="width: max-content;" placeholder="{{__('job.email_move_to_placeholder_text') }}"
                                        required></select>
                                    <div class="input-group-btn email-move-to-btn">
                                        <span type="button" class="btn bg-success txt-light pa-10">
                                            <span class="fa fa-arrow-circle-right"></span>
                                            {{-- {{ __('job.email_move_to_label') }} --}}
                                        </span>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div style="float:right;margin-right:5px;">
                    <a href="#replymailModal" role="menuitem" data-toggle="modal" title="reply"
                        class="btn btn-success btn-block email-forward-btn" data-email-geturl="{{ $emailGetUrl }}"
                        data-type="forward">
                        Forward
                    </a>
                </div>

                <div style="float:right;margin-right:5px;">
                    <a href="#replymailModal" role="menuitem" data-toggle="modal" title="reply"
                        class="btn btn-success btn-block email-reply-all-btn" data-email-geturl="{{ $emailGetUrl }}"
                        data-type="replyall">
                        Reply All
                    </a>
                </div>
                <div style="float:right;margin-right:5px;">
                    <a href="#" role="menuitem" data-toggle="modal" title="Reply" class="btn btn-success btn-block email-reply-btn"
                        data-email-geturl="{{ $emailGetUrl }}" data-type="reply">
                        Reply
                    </a>
                </div>
                <div class="non-business-unmark-btn-block" style="float:right;margin-right:5px;display:none;">
                    <a href="#" title="unmark" class="btn btn-success btn-block non-business-unmark-btn"
                        data-email-status-update-url="{{ $emailStatusUpdateUrl }}">
                        Unmark
                    </a>
                </div>

                <div class="job-unmark-btn-block" style="float:right;margin-right:5px;display:none;">
                    <a href="#" title="unmark" class="btn btn-success btn-block job-unmark-btn" data-job-id=""
                        data-email-status-update-url="{{ $emailStatusUpdateUrl }}">
                        Unmark
                    </a>
                </div>

                <div class="email-annotator-link-block" style="float:right;margin-right:5px;display:none;">
                    <a href="javascript:void(0);" target="_blank" class="btn btn-success btn-block email-annotator-link">
                        Annotated Email
                    </a>
                </div>
            </div>
            <div class="email-draftbutton-group" style="float:right;margin-right:5px;display:none;">
                <div style="float:right;">
                    <a href="#draftmailModal" role="menuitem" data-toggle="modal" title="Edit/Send"
                        class="btn btn-success btn-block email-draft-btn" data-email-geturl="{{ $emailGetUrl }}" data-type="draft">
                        Edit/Send
                    </a>
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
            {{-- <div class="sender-img-wrap pull-left mr-20">
                <img class="sender-img" alt="user" src="{{ asset('public/img/user1.png') }}">
        </div> --}}
            <div class="sender-details pull-left">
                {{-- <span class="capitalize-font pr-5 txt-dark block font-15 weight-500 head-font">John Doe</span>
                    <span class="block">
                        to
                        <span>me</span>
                    </span> --}}
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
                    <span class="inbox-detail-time-1 font-12 email-date-block email-date" style="display: none;"></span>
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
                {{-- <a href="#"><i class="zmdi zmdi-download pr-10"></i>Download</a> --}}
            </div>
            <ul class="attachment-items mb-0">
            </ul>
</div>
<hr class="light-grey-hr mt-5 mb-5" />

<div class="view-mail email-body-block hiddenBlock">
    <textarea id="sent-email-body" class="form-control email-body border-none" name="email-body" rows="15"></textarea>
</div>
{{-- <div class="container-fluid view-mail mt-20 email-body-block email-body" style="display: none;">
</div> --}}
</div>
