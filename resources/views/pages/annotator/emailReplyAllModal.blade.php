@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

<?php

$emailSendUrl      = route(__("job.email_send_url"));
$draftemailSendUrl = route(__("job.draftemail_send_url"));
$emailGetUrl = route(__("job.email_get_url"));
$emailStatusUpdateUrl = route(__("job.email_status_update_url"));
$getEmailid   = route(__("job.get_email_id"));
$signatureUpdateUrl = route(__("job.signature_update"));
$getSignatureUrl = route(__("job.get_signature"));
$redirectTo = $emailId = "";

if (isset($returnData["redirectTo"]) && $returnData["redirectTo"] ) {

    $redirectTo = $returnData["redirectTo"];

}

if (isset($returnData["data"]) && is_array($returnData["data"]) && count($returnData["data"]) > 0 ) {

    if (isset($returnData["data"]["id"]) && $returnData["data"]["id"] !="" ) {

        $emailId = $returnData["data"]["id"];

    }

}

?>

@section('content')
<!-- Main Content -->
<div class="container-fluid pa-0">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default card-view mb-0">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark capitalize-font">
                        {{__("job.email_reply_all_label") ?? "reply all" }}
                    </h6>

                    {{-- <button class="btn btn-warning countdown" data-toggle="popover-x" data-target="#followupdate"
                                    data-placement="right">2020-04-30 15:04:35</button> --}}

                    {{-- <a href="#" class="btn btn-large btn-primary" rel="popover" data-content='
                                <div class="input-group date datetimepicker">
                                <input type="text" name="followup_date" value="{{$followupDate  ?? ''}}"
                    class="form-control">
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-anim">
                            <i class="icon-rocket"></i>
                            <span class="btn-text">submit</span></button>
                    </span>
                </div>
                ' data-placement="top" data-original-title="Follow up date and time"><span class="countdown">2020-04-30
                    15:04:35</span></a> --}}

            </div>
            <div class="pull-right">
                <a href="#" class="pull-left inline-block full-screen mr-15">
                    <i class="zmdi zmdi-fullscreen job-status-i"></i>
                </a>
                <a class="pull-left inline-block" href="{{$redirectTo ?? '#'}}"
                    data-effect="fadeOut">
                    <i class="zmdi zmdi-close job-status-i"></i>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="panel-wrapper">
            <div id="email-compose-collapse" class="">
                <div class="panel-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <form role="form" class="form-horizontal email-reply-form" action="{{ $emailSendUrl ?? '#'}}">
                                <input type="hidden" id="page-type" name="page_type" value="page" class="form-control">
                                <input type="hidden" id="email-status" name="status" value="0" class="form-control email-status">
                                <input type="hidden" id="type" name="type" value="non_pmbot" class="form-control type pmbottype" data-pmbottype="non_pmbot">
                                <input type="hidden" id="email_id" name="email_id" class="form-control email_id" value="{{ $emailId ?? ''}}">
                                <input type="hidden" id="reply_email_type" name="email_type" value="reply" class="form-control reply_email_type">
                                <input type="hidden" id="email-type" name="email-type" value="" class="form-control email-type">
                                <input type="hidden" id="redirectTo" name="redirectTo" value="{{$redirectTo ?? '#'}}">
                                <input type="hidden" id="getemailidURL" name="getemailidURL" value="{{$getEmailid ?? '#'}}">
                                <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />

                                <div class="col-sm-12 nopadding">
                                    <div class="email-lt">
                                        <div class="email-reply-send-btn pl-5">
                                            <img src="{{ asset('public/img/send_mail.png') }}" alt="" />
                                            Send
                                        </div>
                                        <div class="email-reply-save-btn">
                                            Save
                                        </div>
                                    </div>
                                    <div class="email-rt">

                                        <div class="box">
                                            <div class="email-label">To...</div>
                                            <div class="reply_to">
                                                <input type="text" placeholder="" required id="email-reply-to" name="to" value="<?php echo $returnData['data']['email_from'] ?>"
                                                    class="form-control email-reply-to" autocomplete="off">
                                            <input type="hidden" placeholder="" id="replyto_value" class="form-control email-reply-to" value="">
                                                <ul class="replytolist"></ul>
                                            </div>
                                        </div>

                                        <div class="box">
                                            <div class="email-label">Cc...</div>
                                            <div class="reply_cc">
                                                <input type="text" placeholder="" id="email-reply-cc" name="cc" class="form-control email-reply-cc"
                                                    autocomplete="off" value="<?php echo $returnData['data']['email_cc'] ?>">
                                                <input type="hidden" placeholder="" id="replycc_value" class="form-control email-reply-cc" >
                                                <ul class="replycclist"></ul>
                                            </div>
                                        </div>
                                        <div class="box">
                                            <div class="email-label">Bcc...</div>
                                            <div class="reply_bcc">
                                                <input type="text" placeholder="" id="email-reply-bcc" name="bcc"
                                                    class="form-control email-reply-bcc" autocomplete="off" value="<?php echo $returnData['data']['email_bcc'] ?>">
                                                <input type="hidden" placeholder="" id="replybcc_value" class="form-control email-reply-bcc"
                                                    value="">
                                                <ul class="replybcclist"></ul>
                                            </div>
                                        </div>
                                        <div class="box">
                                            <div class="email-label border-none">Subject</div>
                                            <input type="text" placeholder="" id="email-reply-subject" name="subject"
                                                class="form-control email-reply-subject" value="{{'RE: ' . $returnData['data']['subject'] ?? ''}}">
                                        </div>
                                        <div class="box">
                                            <div class="email-label border-none">Attached</div>
                                            <input type="file" class="form-control replyattachements fileupload" name="attachement"
                                                multiple="multiple">
                                        </div>
                                        {{-- <div class="box">
                                            <div class="email-label border-none sig_change" data-signature-geturl="{{ $getSignatureUrl ?? '#'}}">
                                            </div>
                                            <select style="width:20% !important;" class="form-control signature_change" name="signature"
                                                data-signature-type="reply">
                                                <option value="">Select Signature</option>
                                                <option value="new_signature">New</option>
                                                <option value="replyforward_signature">Replies/Forwards</option>
                                            </select>
                                        </div> --}}
                                    </div>

                                </div>

                                <div class="form-group">

                                    <div class="col-lg-12">
                                        <?php 

                                        $sig_class = 'emailsig_block_' . rand();

                                        session()->put("signature_classname", $sig_class);

                                        $message = '<br><br><div class="';

                                        $message .= $sig_class;

                                        $message .= '">';

                                        $message .= $returnData['data']['replyforward_signature'];

                                        $message .='</div>';

                                        $message .='<hr><b>From:</b>';

                                        $message .= $returnData['data']['email_from'];

                                        $message .= '<br><b>Sent:</b>';

                                        $message .= $returnData['data']['email_received_date'];

                                        $message .= '<br><b>To:</b>';

                                        $message .= $returnData['data']['email_to'];

                                        $message .='<br><b>Subject:</b>';

                                        $message .= $returnData['data']['subject'];

                                        $message .= '<br><br>';

                                        $message .= $returnData['data']['body_html'];

                                        ?>
                                        <textarea class="textarea_editor_email form-control email-reply-body_html" name="body_html" rows="15"
                                            placeholder="Enter text ..." ><?php echo $message; ?></textarea>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Main Content -->
@endsection
