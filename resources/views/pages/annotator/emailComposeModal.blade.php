@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@push('js')
<script>
    $(document).ready(function(e) {

    /* setTimeout(() => {

        var selector = $('.email-title');

        showComposeModal(selector);

    }, 500); */

    /* setTimeout(function() {

        tinymceEditorFocus('textarea_editor_email_compose');

    }, '2000'); */

});

</script>
@endpush


<?php

$emailSendUrl      = route(__("job.email_send_url"));
$draftemailSendUrl = route(__("job.draftemail_send_url"));
$emailGetUrl = route(__("job.email_get_url"));
$emailStatusUpdateUrl = route(__("job.email_status_update_url"));
$getEmailid   = route(__("job.get_email_id"));
$signatureUpdateUrl = route(__("job.signature_update"));
$getSignatureUrl = route(__("job.get_signature"));
$emailTemplateListUrl = route(__("job.email_templates_list_url"));
$redirectTo = $emailId = $jobId = $to = "";

$type = 'non_pmbot';

$emailTemplateList = [];

if (isset($returnData["redirectTo"]) && $returnData["redirectTo"] ) {

    $redirectTo = $returnData["redirectTo"];

}

if (isset($returnData["to"]) && $returnData["to"] ) {

    $to = $returnData["to"] . ";";

}

if (isset($returnData["job_id"]) && $returnData["job_id"] ) {

    $type = 'pmbot';

    $jobId = $returnData["job_id"] ;

}

if(isset($returnData['email_template_list']) && is_array($returnData['email_template_list']) && count($returnData['email_template_list']) > 0 ) {

    $emailTemplateList = $returnData['email_template_list'];

}

if (isset($returnData["data"]) && is_array($returnData["data"]) && count($returnData["data"]) > 0 ) {

    if (isset($returnData["data"]["id"]) && $returnData["data"]["id"] !="" ) {

        $emailId = $returnData["data"]["id"];

    }

    if (isset($returnData["data"]["job_id"]) && $returnData["data"]["job_id"] !="" ) {

        $jobId = $returnData["data"]["job_id"];

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
                    <h6 class="panel-title txt-dark capitalize-font email-title">
                        {{__("job.email_compose_label") ?? "New Email" }}
                    </h6>

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
                                    <input type="hidden" id="page-type" name="page_type" value="page" class="form-control">
                                    <input type="hidden" id="status" name="status" value="0" class="form-control email-status">
                                    <input type="hidden" placeholder="" id="type" name="type" value="{{$type ?? ''}}" class="form-control type pmbottype" data-pmbottype="{{$type ?? ''}}">
                                    <input type="hidden" placeholder="" name="email_id" value="" class="form-control email_id">
                                    <input type="hidden" placeholder="" id="job_id" name="job_id" value="{{$jobId ?? ''}}" class="form-control">
                                    <input type="hidden" id="redirectTo" name="redirectTo" value="{{$redirectTo ?? '#'}}">
                                    <input type="hidden" id="getemailidURL" name="getemailidURL" value="{{$getEmailid ?? '#'}}">
                                    <input type="hidden" placeholder="" id="email_type" name="email_type" value="new" class="form-control email_type">
                                    <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />


                                    <div class="col-sm-12 nopadding">
                                        <div class="email-lt">
                                            <div class="email-send-btn email-enter-btn" data-email-enter="email-send-btn">
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
                                                    <input type="text" placeholder="" id="to" name="to"
                                                        class="form-control composeto" autocomplete="off"
                                                        data-error="required field" required="" value="{{$to ?? ''}}" />
                                                    <input type="hidden" placeholder="" id="composeto_value"
                                                        class="form-control composeto" value="">
                                                    <ul class="composetolist"></ul>
                                                </div>
                                            </div>

                                            <div class="box">
                                                <div class="email-label">Cc...</div>
                                                <div class="compose_cc">
                                                    <input type="text" placeholder="" id="cc" name="cc"
                                                        class="form-control composecc" autocomplete="off">
                                                    <input type="hidden" placeholder="" id="composecc_value"
                                                        class="form-control composecc" value="">
                                                    <ul class="composecclist"></ul>
                                                </div>

                                            </div>

                                            <div class="box">
                                                <div class="email-label">Bcc...</div>
                                                <div class="compose_bcc">
                                                    <input type="text" placeholder="" id="bcc" name="bcc"
                                                        class="form-control composebcc" autocomplete="off">
                                                    <input type="hidden" placeholder="" id="composebcc_value"
                                                        class="form-control composebcc" value="">
                                                    <ul class="composebcclist"></ul>
                                                </div>

                                            </div>

                                            <div class="box">
                                                <div class="email-label border-none">Subject</div>
                                                <input type="text" placeholder="" id="subject" name="subject"
                                                    class="form-control subject">
                                            </div>
                                            <div class="box">
                                                <div class="email-label border-none">Attached</div>

                                                <input type="file" class="form-control attached attachements fileupload"
                                                    name="attachement" multiple="multiple" value="Attached">

                                                {{-- <div class="email-template-list" id="email-template-list">
                                                    {!! Form::select('email_template', [ "" =>
                                                    __('job.email_template_placeholder_text') ] +
                                                    $emailTemplateList, null,
                                                    ['class' => 'form-control email-template select2',
                                                    'data-modal' => 'compose',
                                                    'data-email-template-list-url' => $emailTemplateListUrl])
                                                    !!}
                                                    <div class="help-block with-errors"></div>
                                                </div> --}}

                                                {{-- <select style="width:20% !important;float:left;" class="form-control signature_change"
                                                id="select_signature" name="signature" data-signature-type="new">
                                                <option value="new_signature">New Signature</option>
                                                <option value="replyforward_signature">Replies/Forwards</option>
                                            </select> --}}

                                                <div class="high_importance">
                                                    High Importance <input type="checkbox" class="" name="priority"
                                                        id="priority" style="margin-left: 0px;">
                                                </div>

                                            </div>
                                            <div class="box" class="attached_file_box" id="attached_file_box">
                                                <div class="attached_file" id="attached_file"></div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <div class="col-lg-12" style="float:left;">
                                            <textarea class="textarea_editor_email compose_message" name="body_html"
                                                id="textarea_editor_email_compose" rows="15"
                                                placeholder="Enter text ..."></textarea>
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
</div>
<!-- /Main Content -->
@endsection
