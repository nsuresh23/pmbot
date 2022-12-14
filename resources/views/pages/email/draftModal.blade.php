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
</style>
<!-- Modal -->
<div aria-hidden="true" role="dialog" tabindex="-1" id="draftymailModal" class="email-draft-modal modal fade" style="display: none;"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	<div id="loader" class="draft_loader" style="display: none;width: 100%;height: 100%;position: absolute;padding: 2px;z-index: 1;text-align: center;">
	<img src="{{ asset('public/img/loader2.gif') }}" width="64" height="64" /></div>
        <div class="modal-content">
            <div class="modal-header">
                {{-- <button aria-hidden="true" data-dismiss="modal" class="close email-draft-modal-close" type="button">×</button> --}}

                <button type="button" class="close email-draft-modal-close" id="email-draft-modal-close" data-dismiss="modal" data-modal-type='email-draft-modal'> <i class='fa fa-times'></i> </button>
                <button class="close modal-minimize" data-modal-type='email-draft-modal'> <i class='fa fa-minus'></i> </button>

            <h4 class="modal-title modeltitle">Reply</h4>
            </div>
            <div class="modal-body">
				<form role="form" class="form-horizontal email-draft-form"  action="{{ $draftemailSendUrl ?? '#'}}">
					<input type="hidden" id="email-status" name="status" value="0" class="form-control email-status">
					<input type="hidden" id="type" name="type" value="" class="form-control type">
					<input type="hidden" id="email_id" name="email_id" value="" class="form-control email_id">
					<input type="hidden" id="draft_email_type" name="email_type" value="reply" class="form-control draft_email_type">
					<input type="hidden" id="email-type" name="type" value="" class="form-control email-type">
					<input type="hidden" id="redirectTo" name="redirectTo" value="{{$redirectTo ?? '#'}}">
                    <input type="hidden" id="getemailidURL" name="getemailidURL" value="{{$getEmailid ?? '#'}}">
                    <input type="hidden" id="start_time" name="start_time" value="{{date('Y-m-d H:i:s')}}" />
                    <input type="hidden" class="parent-email-received-date" value="" name="parent_email_received_date" />
						<div class="col-sm-12 nopadding">
							<div class="email-lt">
								<div class="email-draft-send-btn email-enter-btn" data-email-enter="email-draft-send-btn">
									<img src="{{ asset('public/img/send_mail.png') }}" alt="" />
									Send
								</div>
								<div class="email-draft-save-btn">
									Save
								</div>
							</div>
							<div class="email-rt">

								<div class="box">
									<div class="email-label">To...</div>
									<div class="draft_to">
										 <input type="text" placeholder="" required id="email-draft-to" name="to" value = "" class="form-control email-draft-to" autocomplete="off">
										 <input type="hidden" placeholder="" id="draftto_value" class="form-control email-draft-to" value="">
										 <ul class="drafttolist"></ul>
									</div>
								</div>

								<div class="box">
									<div class="email-label">Cc...</div>
									<div class="draft_cc">
										 <input type="text" placeholder="" id="email-draft-cc" name="cc" class="form-control email-draft-cc" autocomplete="off">
										 <input type="hidden" placeholder="" id="draftcc_value" class="form-control email-draft-cc" value="">
										 <ul class="draftcclist"></ul>
									</div>
								</div>
								<div class="box">
									<div class="email-label">Bcc...</div>
									<div class="draft_bcc">
										 <input type="text" placeholder="" id="email-draft-bcc" name="bcc" class="form-control email-draft-bcc" autocomplete="off">
										 <input type="hidden" placeholder="" id="draftbcc_value" class="form-control email-draft-bcc" value="">
										 <ul class="draftbcclist"></ul>
									</div>
								</div>
								<div class="box">
									<div class="email-label border-none" >Subject</div>
									<input type="text" placeholder="" id="email-draft-subject" name="subject" class="form-control email-draft-subject">
								</div>
								<div class="box">
									<div class="email-label border-none">Attached</div>
                                    <input type="file" class="form-control attached draftattachements fileupload" name="attachement"  multiple="multiple">

                                    <div class="email-template-list" id="email-template-list">
                                        {!! Form::select('email_template', [ "" =>
                                        __('job.email_template_placeholder_text') ] +
                                        $emailTemplateList, null,
                                        ['class' => 'form-control email-template select2',
                                        'data-modal' => 'draft',
                                        'data-email-template-list-url' => $emailTemplateListUrl])
                                        !!}
                                        <div class="help-block with-errors"></div>
                                    </div>

									<select style="width:20% !important;float:left;" class="form-control signature_draft_change" name="signature" data-signature-type = "reply">
										<option value="new_signature">New Signature</option>
										<option value="replyforward_signature" selected>Replies/Forwards</option>
									</select>

									<div class="high_importance">
										High Importance <input type="checkbox" class="" name="priority" id="priority" style="margin-left: 0px;">
									</div>
								</div>
								<div class="box" class="attached_file_box" id="attached_file_box">
									<div class="attached_file" id="attached_file"></div>
								</div>
								<!--<div class="box">
									<div class="email-label border-none sig_change" data-signature-geturl = "{{ $getSignatureUrl ?? '#'}}">Signature</div>
									<select style="width:20% !important;float:left;" class="form-control signature_draft_change" name="signature" data-signature-type = "reply">
										<option value="new_signature">New Signature</option>
										<option value="replyforward_signature" selected>Replies/Forwards</option>
									</select>

									<div class="high_importance">
										High Importance <input type="checkbox" class="" name="priority" id="priority" style="margin-left: 0px;">
									</div>
								</div>-->
							</div>

						</div>

						<div class="form-group">

							<div class="col-lg-12" style="float:left;">
								<textarea id="textarea_editor_email_draft" class="textarea_editor_email form-control email-draft-body_html" name="body_html" rows="15"
                                placeholder="Enter text ..."></textarea>
							</div>
						</div>
               </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
