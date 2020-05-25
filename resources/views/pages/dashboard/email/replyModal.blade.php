<style>
.note-editable {height:auto !important;}
</style>
<!-- Modal -->
<div aria-hidden="true" role="dialog" tabindex="-1" id="replymailModal" class="email-reply-modal modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close email-reply-modal-close" type="button">×</button>
            <h4 class="modal-title">Reply</h4>
            </div>
            <div class="modal-body">
				<form role="form" class="form-horizontal email-reply-form"  action="{{ $emailSendUrl ?? '#'}}">
					<input type="hidden" id="email-status" name="status" value="0" class="form-control email-status">
					<input type="hidden" placeholder="" id="reply_email_type" name="email_type" value="reply" class="form-control reply_email_type">
					<input type="hidden" placeholder="" id="email-type" name="type" value="non_pmbot" class="form-control email-type">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{__("job.email_to_label")}}</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" required id="email-reply-to" name="to" value = "" class="form-control email-reply-to">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{__("job.email_cc_label") }}</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="email-reply-cc" name="cc" class="form-control email-reply-cc">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{__("job.email_subject_label") }}</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="email-reply-subject" name="subject" class="form-control email-reply-subject">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{__("job.email_message_label") }}</label>
                        <div class="col-lg-10">
                            <textarea class="textarea_editor form-control email-reply-body_html" name="body_html" rows="15"
                                placeholder="Enter text ..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <div class="fileupload btn btn-info btn-anim mr-10"><i class="fa fa-paperclip"></i><span
                                    class="btn-text">{{__("job.email_attachment_label") }}</span>
                                <input type="file" class="upload">
                            </div>
							<button class="btn btn-success email-reply-save-btn" type="submit">Save</button>
                            	&nbsp;
                            <button class="btn btn-success email-reply-send-btn" type="submit">{{__("job.email_send_button_label") }}</button>
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
