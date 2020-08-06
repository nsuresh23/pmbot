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
.note-editor{font-family: Arial !important;font-size: 11pt !important;}


</style>
<!-- Modal -->
<div aria-hidden="true" role="dialog" tabindex="-1" id="signatureModal" class="signature-modal modal fade" style="display: none;"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close signature-close" type="button">×</button>
            <h4 class="modal-title modeltitle">Signature</h4>
            </div>
            <div class="modal-body">
				<form role="form" class="form-horizontal signature-form"  action="{{ $signatureUpdateUrl ?? '#'}}">
					
					<input type="hidden" id="redirectTo" name="redirectTo" value="{{$redirectTo ?? '#'}}">
                    <input type="hidden" id="getemailidURL" name="getemailidURL" value="{{$getEmailid ?? '#'}}">
         
						<div class="form-group">

							<div class="col-lg-6">
								<label>New Message</label>
								<textarea class="textarea_editor_signature form-control new_signature" name="new_signature" rows="15"
                                placeholder="Enter text ..."></textarea>
							</div>
							<div class="col-lg-6">
								<label>Replies/Forwards</label>
								<textarea class="textarea_editor_signature form-control replyforward_signature" name="replyforward_signature" rows="15"
                                placeholder="Enter text ..."></textarea>
							</div>

							<div class="col-sm-12 nopadding">
									
									<div style="float:right;margin-right:15px;" class="btn btn-success btn-anim bg-success signature-cancel">
										Cancel
									</div>
									<div style="float:right;margin-right:5px;" class="btn btn-success btn-anim bg-success signature-save">
										Save
									</div>
									
							</div>
						</div>
					</div>
                   




                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

<!-- /.modal -->
