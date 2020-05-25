<style>

	.modal-footer {
		display:none !important;
	}

</style>
        <div class="box-body table-responsive reportbox"><!--  no-padding -->	
				
			<form style='width:100%;' class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
					{{ csrf_field() }}
					<div class='updatebox'>
						<div class='row'>	
						<div class="col-md-12 ">
							<label>Remarks</label>	
						</div>
						<div class="col-md-12 ">						
							<select class="form-control" id="remarks" name="remarks">
								<option value="">Select Remarks</option>
								<option value="Notes">Notes</option>
								<option value="Merged Reference">Merged Reference</option>
								<option value="Input Issue">Input Issue</option>
								<option value="High Inflow">High Inflow</option>
								<option value="Reference Missing">Reference Missing</option>
								<option value="Complex Article">Complex Article</option>
								<option value="Internal Query">Internal Query</option>
								<option value="Technical Issue">Technical Issue</option>
								<option value="Rework">Rework</option>
								<option value="Query">Query</option>

							</select>
						</div>	
						
						<div class="col-md-12 ">
							<label>Additional Remarks</label>	
						</div>
						<div class="col-md-12 ">						
							 <textarea id='comments' style='height:75px; resize: none;' class='form-control' name='comments'></textarea>
						</div>	
							<div class="col-md-12" style="text-align: right;margin-top: 15px;">								
								<input type='hidden' name='htAction' value='queryreply' />	
												
								<input class="btn btn-primary" onclick="cancelaction()" type="button" value="Cancel">
								<input class="btn btn-primary" onclick="updateremarks()" type="button" value="Submit">
								
						</div>
					</div>
				</div>	
				</form>	
			</div>
<script type="text/javascript">

	function cancelaction(){
		bootbox.hideAll();	
	}
	function getSelectValues(select) {
	  var result = [];
	  var options = select && select.options;
	  var opt;

	  for (var i=0, iLen=options.length; i<iLen; i++) {
		opt = options[i];

		if (opt.selected) {
		  result.push(opt.value || opt.text);
		}
	  }
	  return result;
	}
	function updateremarks(){
		var checkboxName = 'orderidname';
		var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
		Array.prototype.forEach.call(checkboxes, function(el) {
			values.push(el.value);
		});
		var comments   = document.getElementById('comments').value;		
		var remarks   = document.getElementById('remarks').value;		
		if(values == '') {
			alert('Please select orders.');
			bootbox.hideAll();	
			return false;
		}		
		if(comments == '') {
			alert('Please enter the comments.');
			document.getElementById("comments").focus();
			return false;
		}
		$.ajax({
				type: 'GET',
				url: "{{url('reports/update_orderremarks')}}",
				data: 'ajaxload=1&orderid='+values+'&remarks='+remarks+'&comments='+comments,
				success: function(data){
					bootbox.hideAll();
					parent.location.reload();
				},
			  });	
			
	}
</script>