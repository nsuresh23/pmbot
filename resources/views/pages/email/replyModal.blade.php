<style>
.note-editable {height:auto !important;}
.note-editable{min-height:400px !important;}
.note-editor.panel .panel-heading {
    background: transparent !important;
}
.note-popover .popover-content, .panel-heading.note-toolbar {
    padding: 0 0 5px 5px !important;
    margin: 0;
}
.note-editor .note-toolbar.panel-heading {
    border: 1px solid #dedede !important;
}
.note-editable{height:75px !important;}
.modal-dialog{width:80% !important}
.note-editor{font-family: Calibri !important;font-size: 11pt !important;}
</style>
<!-- Modal -->
<div aria-hidden="true" role="dialog" tabindex="-1" id="replymailModal" class="email-reply-modal modal fade" style="display: none;"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
		<div id="loader" class="reply_loader" style="display: none;width: 100%;height: 100%;position: absolute;padding: 2px;z-index: 1;text-align: center;">
		<img src="{{ asset('public/img/loader2.gif') }}" width="64" height="64" /></div>
	
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close email-reply-modal-close" type="button">×</button>
            <h4 class="modal-title modeltitle">Reply</h4>
            </div>
            <div class="modal-body">
				<form role="form" class="form-horizontal email-reply-form"  action="{{ $emailSendUrl ?? '#'}}">
					<input type="hidden" id="email-status" name="status" value="0" class="form-control email-status">
					<input type="hidden" id="type" name="type" value="non_pmbot" class="form-control type">
					<input type="hidden" id="email_id" name="email_id" value="" class="form-control email_id">
					<input type="hidden" id="reply_email_type" name="email_type" value="reply" class="form-control reply_email_type">
					<input type="hidden" id="email-type" name="email-type" value="" class="form-control email-type">
					<input type="hidden" id="redirectTo" name="redirectTo" value="{{$redirectTo ?? '#'}}">
                    <input type="hidden" id="getemailidURL" name="getemailidURL" value="{{$getEmailid ?? '#'}}">
                    <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />



						<div class="col-sm-12 nopadding">
							<div class="email-lt">
								<div class="email-reply-send-btn">
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
										 <input type="text" placeholder="" required id="email-reply-to" name="to" value = "" class="form-control email-reply-to" autocomplete="off">
										 <input type="hidden" placeholder="" id="replyto_value" class="form-control email-reply-to" value="">
										 <ul class="replytolist"></ul>
									</div>
								</div>

								<div class="box">
									<div class="email-label">Cc...</div>
									<div class="reply_cc">
										 <input type="text" placeholder="" id="email-reply-cc" name="cc" class="form-control email-reply-cc" autocomplete="off">
										 <input type="hidden" placeholder="" id="replycc_value" class="form-control email-reply-cc" value="">
										 <ul class="replycclist"></ul>
									</div>
								</div>
								<div class="box">
									<div class="email-label">Bcc...</div>
									<div class="reply_bcc">
										 <input type="text" placeholder="" id="email-reply-bcc" name="bcc" class="form-control email-reply-bcc" autocomplete="off">
										 <input type="hidden" placeholder="" id="replybcc_value" class="form-control email-reply-bcc" value="">
										 <ul class="replybcclist"></ul>
									</div>
								</div>
								<div class="box">
									<div class="email-label border-none" >Subject</div>
									<input type="text" placeholder="" id="email-reply-subject" name="subject" class="form-control email-reply-subject">
								</div>
								<div class="box">
									<div class="email-label border-none">Attached</div>
									<input type="file" class="form-control replyattachements fileupload" name="attachement"  multiple="multiple">
								</div>
								<div class="box" id="attached_file_box">
									<div class="email-label border-none"></div>
									<div class="attached_file" id="attached_file"></div>
								</div>
								<div class="box">
									<div class="email-label border-none sig_change" data-signature-geturl = "{{ $getSignatureUrl ?? '#'}}"></div>
									<select style="width:20% !important;float:left;" class="form-control signature_reply_change" name="signature" data-signature-type = "reply">
										<option value="">Select Signature</option>
										<option value="new_signature">New</option>
										<option value="replyforward_signature" selected>Replies/Forwards</option>
									</select>
									
									<div style="float:left;width:20%;margin-left:8px;line-height:34px;">
										High Importance <input type="checkbox" class="" name="priority" id="priority" style="margin-left: 0px;">
									</div>
								</div>
							</div>

						</div>

						<div class="form-group">

							<div class="col-lg-12">
								<textarea id="textarea_editor_email_reply" class="textarea_editor_email form-control email-reply-body_html" name="body_html" rows="15"
                                placeholder="Enter text ..."></textarea>
							</div>
						</div>


                    <!--<div class="form-group">
                        <label class="col-lg-1 control-label">{{__("job.email_to_label")}}</label>
                        <div class="col-lg-11">
                            <input type="text" placeholder="" required id="email-reply-to" name="to" value = "" class="form-control email-reply-to">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-1 control-label">{{__("job.email_cc_label") }}</label>
                        <div class="col-lg-11">
                            <input type="text" placeholder="" id="email-reply-cc" name="cc" class="form-control email-reply-cc">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-1 control-label">{{__("job.email_subject_label") }}</label>
                        <div class="col-lg-11">
                            <input type="text" placeholder="" id="email-reply-subject" name="subject" class="form-control email-reply-subject">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-1 control-label">{{__("job.email_message_label") }}</label>
                        <div class="col-lg-11">
                            <textarea class="textarea_editor form-control email-reply-body_html" name="body_html" rows="15"
                                placeholder="Enter text ..."></textarea>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-lg-1 control-label">{{__("job.email_attachment_label") }}</label>
                        <div class="col-lg-11">
                           <input type="file" class="replyattachements fileupload" name="attachement"  multiple="multiple">
                        </div>
                    </div>
                    <div class="form-group">
                       	<label class="col-lg-1 control-label">&nbsp;</label>
                        <div class="col-lg-11">
							<button class="btn btn-success email-reply-save-btn" type="submit">Save</button>
                            	&nbsp;
                            <button class="btn btn-success email-reply-send-btn" type="submit">{{__("job.email_send_button_label") }}</button>
                        </div>
                    </div>-->








                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
