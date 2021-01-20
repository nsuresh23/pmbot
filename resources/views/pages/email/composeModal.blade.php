<style>
.modal-dialog{width:80% !important;}
.note-editor.note-frame{min-height:400px !important;}
.note-editable{min-height:400px !important;}
.note-editor.note-frame {
    border: 1px solid #a9a9a9 !important;
}
.textarea_editor_email {font-family: Calibri !important;font-size: 11pt !important; }
.note-editor{font-family: Calibri !important;font-size: 11pt !important;}
.dropdown-fontsize{font-size: 11pt !important;}

</style>
<!-- Modal -->

<div aria-hidden="true" role="dialog" tabindex="-1" id="emailSendModal" class="email-compose-modal modal fade" style="display: none;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	<div id="loader" class="compose_loader" style="display: none;width: 100%;height: 100%;position: absolute;padding: 2px;z-index: 1;text-align: center;">
	<img src="{{ asset('public/img/loader2.gif') }}" width="64" height="64" /></div>
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close email-compose-modal-close" id="email-compose-modal-close" type="button">×</button>
            <h4 class="modal-title">{{__("job.email_compose_label") }}</h4>
            </div>
            <div class="modal-body">
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
									<div class="email-send-btn">
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
											<input type="text" placeholder="" id="to" name="to" class="form-control composeto" autocomplete="off" data-error="required field" required="" />
											<input type="hidden" placeholder="" id="composeto_value" class="form-control composeto" value="">
											<ul class="composetolist"></ul>
										</div>
									</div>

									<div class="box">
										<div class="email-label">Cc...</div>
										<div class="compose_cc">
											 <input type="text" placeholder="" id="cc" name="cc" class="form-control composecc" autocomplete="off">
											<input type="hidden" placeholder="" id="composecc_value" class="form-control composecc" value="">
											<ul class="composecclist"></ul>
										</div>

									</div>
									
									<div class="box">
										<div class="email-label">Bcc...</div>
										<div class="compose_bcc">
											 <input type="text" placeholder="" id="bcc" name="bcc" class="form-control composebcc" autocomplete="off">
											<input type="hidden" placeholder="" id="composebcc_value" class="form-control composebcc" value="">
											<ul class="composebcclist"></ul>
										</div>

									</div>
									
									<div class="box">
										<div class="email-label border-none" >Subject</div>
										 <input type="text" placeholder="" id="subject" name="subject" class="form-control subject" >
									</div>
									<div class="box">
										<div class="email-label border-none">Attached</div>
										
										<input type="file" class="form-control attached attachements fileupload" name="attachement" multiple="multiple" value="Attached">
										<select style="width:20% !important;float:left;" class="form-control signature_change" id="select_signature" name="signature" data-signature-type = "new">
											<option value="new_signature" >New Signature</option>
											<option value="replyforward_signature">Replies/Forwards</option>
										</select>
										<div class="high_importance">
											High Importance <input type="checkbox" class="" name="priority" id="priority" style="margin-left: 0px;">
										</div>
										
									</div>
									<div class="box" class="attached_file_box" id="attached_file_box">
										<div class="attached_file" id="attached_file"></div>
									</div>
									<!--<div class="box">
										<div class="email-label border-none sig_change" data-signature-geturl = "{{ $getSignatureUrl ?? '#'}}"></div>
										<select style="width:20% !important;float:left;" class="form-control signature_change" id="select_signature" name="signature" data-signature-type = "new">
											<option value=''>Signature</option>
											<option value="new_signature" >New</option>
											<option value="replyforward_signature">Replies/Forwards</option>
										</select>
										<div style="float:left;width:20%;margin-left:8px;line-height:34px;">
											High Importance <input type="checkbox" class="" name="priority" id="priority" style="margin-left: 0px;">
										</div>
									</div>-->
							</div>

					</div>

				 <div class="form-group">

                        <div class="col-lg-12" style="float:left;">
                            <textarea class="textarea_editor_email compose_message" name="body_html" id="textarea_editor_email_compose" rows="15"
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
