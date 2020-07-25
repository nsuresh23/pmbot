
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
$redirectTo = "";

if (isset($returnData["redirectTo"]) && $returnData["redirectTo"] ) {

    $redirectTo = $returnData["redirectTo"];

}

?>

@section('content')
<!-- Main Content -->
<div class="container-fluid">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default card-view mb-0">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark capitalize-font">
                        {{__("job.email_compose_label") ?? "" }}
                    </h6>

                    {{-- <button class="btn btn-warning countdown" data-toggle="popover-x" data-target="#followupdate"
                                    data-placement="right">2020-04-30 15:04:35</button> --}}

                    {{-- <a href="#" class="btn btn-large btn-primary" rel="popover" data-content='
                                <div class="input-group date datetimepicker">
                                <input type="text" name="followup_date" value="{{$followupDate  ?? ''}}" class="form-control">
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
                <a class="pull-left inline-block" href="{{$redirectTo ?? '#'}}" data-effect="fadeOut">
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
                            <form role="form" class="form-horizontal email-send-form" action="{{ $emailSendUrl ?? '#'}}">
                                <input type="hidden" id="status" name="status" value="0" class="form-control email-status">
                                <input type="hidden" placeholder="" id="type" name="type" value="" class="form-control type">
                                <input type="hidden" placeholder="" id="job_id" name="job_id" value="{{$jobId ?? ''}}" class="form-control">
                                <input type="hidden" id="redirectTo" name="redirectTo" value="{{$redirectTo ?? '#'}}">
                                <input type="hidden" id="getemailidURL" name="getemailidURL" value="{{$getEmailid ?? '#'}}">
                                <input type="hidden" placeholder="" id="email_type" name="email_type" value="new" class="form-control email_type">
                                <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />


                                <div class="col-sm-12 nopadding">
                                    <div class="email-lt">
                                        <div class="email-send-btn pl-5">
                                            <img src="{{ asset('public/img/send_mail.png') }}" alt="" />
                                            Send
                                        </div>
                                        <div class="email-save-btn">
                                            Save
                                        </div>
                                    </div>
                                    <div class="email-rt">

                                        <div class="box">
                                            <div class="email-label">To...</div>
                                            <div class="compose_to">
                                                <input type="text" placeholder="" id="to" name="to" class="form-control composeto"
                                                    autocomplete="off" data-error="required field" required="" />
                                                <input type="hidden" placeholder="" id="composeto_value" class="form-control composeto" value="">
                                                <ul class="composetolist"></ul>
                                            </div>
                                        </div>

                                        <div class="box">
                                            <div class="email-label">Cc...</div>
                                            <div class="compose_cc">
                                                <input type="text" placeholder="" id="cc" name="cc" class="form-control composecc"
                                                    autocomplete="off">
                                                <input type="hidden" placeholder="" id="composecc_value" class="form-control composecc" value="">
                                                <ul class="composecclist"></ul>
                                            </div>

                                        </div>

                                        <div class="box">
                                            <div class="email-label">Bcc...</div>
                                            <div class="compose_bcc">
                                                <input type="text" placeholder="" id="bcc" name="bcc" class="form-control composebcc"
                                                    autocomplete="off">
                                                <input type="hidden" placeholder="" id="composebcc_value" class="form-control composebcc" value="">
                                                <ul class="composebcclist"></ul>
                                            </div>

                                        </div>

                                        <div class="box">
                                            <div class="email-label border-none">Subject</div>
                                            <input type="text" placeholder="" id="subject" name="subject" class="form-control subject">
                                        </div>
                                        <div class="box">
                                            <div class="email-label border-none">Attached</div>
                                            <input type="file" class="form-control attachements fileupload" name="attachement" multiple="multiple">
                                        </div>
                                        <div class="box">
                                            <div class="email-label border-none sig_change" data-signature-geturl="{{ $getSignatureUrl ?? '#'}}">
                                            </div>
                                            <select style="width:20% !important;" class="form-control signature_change" name="signature"
                                                data-signature-type="new">
                                                <option value="">Signature</option>
                                                <option value="new_signature">New</option>
                                                <option value="replyforward_signature">Replies/Forwards</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <div class="col-lg-12">
                                        <textarea class="textarea_editor_email form-control compose_message" name="body_html" id="body_html"
                                            rows="15" placeholder="Enter text ..."></textarea>
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
