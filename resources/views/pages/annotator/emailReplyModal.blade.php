@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@push('js')
<script>
$(document).ready(function(e) {
    $('.attachements').val('');
    var type = 'reply';
    var selector = $('.email-title');
    $('.reply_email_type').val('reply');
    $('.signature_change').val('');
    $(".reply_to ul").empty();

    setTimeout(() => {

        showform(type, selector);

    }, 500);

    setTimeout(function() {

        tinymceEditorFocus('textarea_editor_email_reply');

    }, '2000');

    // showform(type, selector);

    //CKEDITOR.replace('ck_textarea_editor_email');
    // CKEDITOR.replace('ck_textarea_editor_email', {
    //     customConfig: '<?php echo asset("public/js/custom/js/ck_textarea_editor_email_config.js"); ?>'
    // });

    // CKEDITOR.editorConfig = function( config ) {
    //     config.font_defaultLabel = 'Arial';
    //     config.uiColor = '#AADC6E';
    // };

    // tinymce.init({
    // selector: '#ck_textarea_editor_email'
    // });

    // tinymce.create('tinymce.plugins.CustomSetFontPlugin', {

    //     /**
    //      * Initializes the plugin, this will be executed after the plugin has been created.
    //      * This call is done before the editor instance has finished it's initialization so use the onInit event
    //      * of the editor instance to intercept that event.
    //      *
    //      * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
    //      * @param {string} url Absolute URL to where the plugin is located.
    //      */
    //     init : function(ed, url) {
    //         ed.onLoadContent.add(function(ed, o) {

    //             //CSS changes you can make - This is for user display purposes and does not actually get sent with the email.
    //             // ed.getBody().style.fontSize = '12pt';
    //             //ed.getBody().fontFamily = 'arial';

    //             //This will embed the font tags into the HTML body so that it is sent with the email
    //             ed.setContent('<p><span style="font-family: arial,helvetica,sans-serif; font-size: small;">&nbsp;</span></p>');
    //         });
    //     },

    //     /**
    //      * Creates control instances based in the incomming name. This method is normally not
    //      * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
    //      * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
    //      * method can be used to create those.
    //      *
    //      * @param {String} n Name of the control to create.
    //      * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
    //      * @return {tinymce.ui.Control} New control instance or null if no control was created.
    //      */
    //     createControl : function(n, cm) {
    //         return null;
    //     },

    //     /**
    //      * Returns information about the plugin as a name/value array.
    //      * The current keys are longname, author, authorurl, infourl and version.
    //      *
    //      * @return {Object} Name/value array containing information about the plugin.
    //      */
    //     getInfo : function() {
    //         return {
    //             longname : 'CustomSetFont plugin',
    //             author : 'PMBot',
    //             authorurl : '',
    //             infourl : '',
    //             version : "1.0"
    //         };
    //     }
    // });

    // // Register plugin
    // tinymce.PluginManager.add('customsetfont', tinymce.plugins.CustomSetFontPlugin);

    tinymce.init({
        selector: '.textarea_editor_email',
        height: 500,
        menubar: false,
        // keep_styles: true,
        paste_data_images: true,
        plugins: 'advlist anchor autolink bootstrap bbcode charmap code codesample colorpicker directionality fullpage fullscreen hr image imagetools insertdatetime lineheight link lists media nonbreaking paste pagebreak print preview searchreplace table template textcolor textpattern visualblocks visualchars wordcount',
        fontsize_formats: '8pt 11pt 10pt 12pt 14pt 18pt 24pt 36pt',
        font_formats: ' Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Calibri=calibri; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
        toolbar: 'formatselect | fontselect | fontsizeselect | forecolor | backcolor | lineheightselect | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link | removeformat | code | help',
        // content_style: "body { font-size: 14pt; font-family: Arial; }",
        setup : function(ed) {
            ed.on('init', function (ed) {
                ed.target.editorCommands.execCommand("fontName", false, "calibri");
                ed.target.editorCommands.execCommand("fontSize", false, "10pt");
                ed.target.editorCommands.execCommand("lineheight", false, "8pt");
                ed.target.editorCommands.execCommand("foreColor", false, "#1F497D");
            });
        },
        images_upload_handler: function (blobInfo, success, failure, progress) {

            var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

            if (postUrl != undefined && postUrl != '') {

                setTimeout(function() {

                    data = new FormData();

                    data.append("file", blobInfo.blob());

                    var d = $.Deferred();

                    $.ajax({
                        data: data,
                        type: "POST",
                        url: postUrl,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {

                            if (response.success != undefined && response.success == 'true') {

                                if (response.data != undefined && 'url' in response.data) {

                                    success(response.data.url);

                                    // var image = $('<img>').attr('src', response.data.url).addClass("img-fluid");

                                    //$('.textarea_editor_email').attr('data-image-url', response.data.url);

                                    // $('.textarea_editor_email').summernote("insertNode", image[0]);
                                    // $('.textarea_editor_email').summernote("insertImage", response.data.url);
                                    // editor.insertImage(welEditable, response.data.url);
                                    // $('.textarea_editor').summernote('insertImage', response.data.url);
                                    //$('.textarea_editor').summernote('insertImage', response.data.url, response.data.filename);


                                } else {

                                    message = response.message;

                                    flashMessage('error', message);

                                    failure(message);

                                    d.resolve();

                                    return;

                                }

                            } else {

                                message = response.message;

                                flashMessage('error', message);

                                failure(message);

                                d.resolve();

                                return;

                            }
                        }
                    });

                    // var xhr, formData;

                    // xhr = new XMLHttpRequest();
                    // xhr.withCredentials = false;
                    // xhr.open('POST', postUrl);

                    // xhr.upload.onprogress = function (e) {
                    //     progress(e.loaded / e.total * 100);
                    // };

                    // xhr.onload = function() {
                    //     var json;

                    //     if (xhr.status < 200 || xhr.status >= 300) {
                    //         failure('HTTP Error: ' + xhr.status);
                    //         return;
                    //     }

                    //     json = JSON.parse(xhr.responseText);

                    //     if (!json || typeof json.data != 'object' || typeof json.url != 'string') {
                    //         failure('Invalid JSON: ' + xhr.responseText);
                    //         return;
                    //     }

                    //     success(json.url);

                    // };

                    // xhr.onerror = function () {
                    //     failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                    // };

                    // formData = new FormData();
                    // formData.append('file', blobInfo.blob(), blobInfo.filename());

                    // xhr.send(formData);

                }, 2000);

                return;

            }

        },
        // images_upload_handler: function (blobInfo, success, failure) {

        //     console.log(blobInfo);

        //     var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

        //     if (postUrl != undefined && postUrl != '') {

        //         data = new FormData();
        //         data.append("file2", blobInfo.blob());

        //         var d = $.Deferred();

        //         $.ajax({
        //             data: data,
        //             type: "POST",
        //             url: postUrl,
        //             cache: false,
        //             contentType: false,
        //             processData: false,
        //             success: function(response) {

        //                 if (response.success != undefined && response.success == 'true') {

        //                     if (response.data != undefined && 'url' in response.data) {

        //                         success(response.data.url);

        //                         // var image = $('<img>').attr('src', response.data.url).addClass("img-fluid");

        //                         //$('.textarea_editor_email').attr('data-image-url', response.data.url);

        //                         // $('.textarea_editor_email').summernote("insertNode", image[0]);
        //                         // $('.textarea_editor_email').summernote("insertImage", response.data.url);
        //                         // editor.insertImage(welEditable, response.data.url);
        //                         // $('.textarea_editor').summernote('insertImage', response.data.url);
        //                         //$('.textarea_editor').summernote('insertImage', response.data.url, response.data.filename);


        //                     } else {

        //                         message = response.message;

        //                         flashMessage('error', message);

        //                         failure(message);

        //                         d.resolve();

        //                         return;

        //                     }

        //                 } else {

        //                     message = response.message;

        //                     flashMessage('error', message);

        //                     failure(message);

        //                     d.resolve();

        //                     return;

        //                 }
        //             }
        //         });

        //     }

        //     // sendFile(blobInfo.blob());

        //                         // var xhr, formData;

        //             // xhr = new XMLHttpRequest();
        //             // xhr.withCredentials = false;
        //             // xhr.open('POST', postUrl);

        //             // // xhr.upload.onprogress = function (e) {
        //             // //     progress(e.loaded / e.total * 100);
        //             // // };

        //             // xhr.onload = function() {

        //             //     var json;

        //             //     if (xhr.status < 200 || xhr.status >= 300) {

        //             //         failure('HTTP Error: ' + xhr.status);
        //             //         return;

        //             //     }

        //             //     json = JSON.parse(xhr.responseText);

        //             //     if (!json || typeof json.data != 'object' || typeof json.data.url != 'string') {

        //             //         failure('Invalid JSON: ' + xhr.responseText);
        //             //         return;

        //             //     }

        //             //     success(json.data.url);

        //             // };

        //             // xhr.onerror = function () {

        //             //     failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);

        //             // };

        //             // formData = new FormData();

        //             // formData.append('file', blobInfo.blob(), blobInfo.filename());

        //             // xhr.send(formData);

        // },
        // plugins : 'customsetfont',
    });

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
$redirectTo = $emailId = "";

$emailTemplateList = [];

if (isset($returnData["redirectTo"]) && $returnData["redirectTo"] ) {

    $redirectTo = $returnData["redirectTo"];

}

if(isset($returnData['email_template_list']) && is_array($returnData['email_template_list']) && count($returnData['email_template_list']) > 0 ) {

    $emailTemplateList = $returnData['email_template_list'];

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
                    <h6 class="panel-title txt-dark capitalize-font email-title" data-email-id="{{$emailId ?? ''}}" data-email-geturl="{{$emailGetUrl ?? ''}}">
                        {{__("job.email_reply_label") ?? "reply" }}
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
                                                <!-- <input type="text" placeholder="" required id="email-reply-to" name="to" value="<?php //echo $returnData['data']['email_from'] ?>"
                                                    class="form-control email-reply-to" autocomplete="off"> -->
												<input type="text" placeholder="" required id="email-reply-to" name="to" value=""
                                                    class="form-control email-reply-to" autocomplete="off">
                                            <input type="hidden" placeholder="" id="replyto_value" class="form-control email-reply-to" value="">
                                                <ul class="replytolist"></ul>
                                            </div>
                                        </div>

                                        <div class="box">
                                            <div class="email-label">Cc...</div>
                                            <div class="reply_cc">
                                                <input type="text" placeholder="" id="email-reply-cc" name="cc" class="form-control email-reply-cc"
                                                    autocomplete="off">
                                                <input type="hidden" placeholder="" id="replycc_value" class="form-control email-reply-cc" value="">
                                                <ul class="replycclist"></ul>
                                            </div>
                                        </div>
                                        <div class="box">
                                            <div class="email-label">Bcc...</div>
                                            <div class="reply_bcc">
                                                <input type="text" placeholder="" id="email-reply-bcc" name="bcc"
                                                    class="form-control email-reply-bcc" autocomplete="off">
                                                <input type="hidden" placeholder="" id="replybcc_value" class="form-control email-reply-bcc"
                                                    value="">
                                                <ul class="replybcclist"></ul>
                                            </div>
                                        </div>
                                        <div class="box">
                                            <div class="email-label border-none">Subject</div>
                                            <!-- <input type="text" placeholder="" id="email-reply-subject" name="subject"
                                                class="form-control email-reply-subject" value="{{'RE: ' . $returnData['data']['subject'] ?? ''}}"> -->
											<input type="text" placeholder="" id="email-reply-subject" name="subject"
                                                class="form-control email-reply-subject" value="">
                                        </div>
                                        <div class="box">
                                            <div class="email-label border-none">Attached</div>
                                            <input type="file" style="width:8.6% !important;" class="form-control attached replyattachements fileupload" name="attachement"
                                                multiple="multiple">

                                            <div class="email-template-list" id="email-template-list">
                                                {!! Form::select('email_template', [ "" =>
                                                __('job.email_template_placeholder_text') ] +
                                                $emailTemplateList, null,
                                                ['class' => 'form-control email-template select2',
                                                'data-modal' => 'reply',
                                                'data-email-template-list-url' => $emailTemplateListUrl])
                                                !!}
                                                <div class="help-block with-errors"></div>
                                            </div>

											<!--<select style="width:20% !important;float:left;" class="form-control signature_change" id="select_signature" name="signature" data-signature-type = "new">
												<option value="new_signature" >New Signature</option>
												<option value="replyforward_signature">Replies/Forwards</option>
											</select>-->
											<div class="high_importance">
												High Importance <input type="checkbox" class="" name="priority" id="priority" style="margin-left: 0px;">
											</div>

                                        </div>
                                        <div class="box" class="attached_file_box" id="attached_file_box">
                                            <div class="attached_file" id="attached_file"></div>
                                        </div>
                                        <!-- <div class="box">
                                            <div class="email-label border-none sig_change" data-signature-geturl="{{ $getSignatureUrl ?? '#'}}">
                                            </div>
                                            <select style="width:20% !important;" class="form-control signature_change" name="signature"
                                                data-signature-type="reply">
                                                <option value="">Select Signature</option>
                                                <option value="new_signature">New</option>
                                                <option value="replyforward_signature">Replies/Forwards</option>
                                            </select>
                                        </div> -->
                                    </div>

                                </div>

                                <div class="form-group">

                                    <div class="col-lg-12" style="float:left;">
                                        <?php

                                        $sig_class = 'emailsig_block_' . rand();

                                        session()->put("signature_classname", $sig_class);

										$message = '<p class="MsoNormal" style="font-family:Calibri;font-size:11pt;color:#337ab7;margin:0px;"><br></p>';

                                        $message .= '<br><br><div class="';

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
                                        <!-- <textarea class="textarea_editor_email form-control email-reply-body_html" name="body_html" rows="15"
                                            placeholder="Enter text ..." ><?php //echo $message; ?></textarea> -->
										{{-- <textarea id="ck_textarea_editor_email" class="ck_textarea_editor_email form-control" name="body_html" rows="15"
                                            placeholder="Enter text ..." ></textarea> --}}

                                        <textarea id="textarea_editor_email_reply" class="textarea_editor_email form-control email-reply-body_html"
                                            name="body_html" rows="15" placeholder="Enter text ..."></textarea>
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
