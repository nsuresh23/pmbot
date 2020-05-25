 <div class="box-body table-responsive reportbox"><!--  no-padding -->
		<table class="table popupreport" border='0'	>
              <tr>                
				<td>				
				<div class='jobsdetailbox' style='width:750px;'>
					<table class="table popupreport" width='100%' cellpadding="5" cellspacing="5"  border='0'>
						@foreach ($result as $k => $results)
						<tr>						
							<td class='fieldtitle'>{{$k}} :</td>	
							<td >{{$results}}</td>							
						</tr>
						@endforeach					   
					</table>				
				</div>
				</td>				
				<td>				
				<form class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
					{{ csrf_field() }}
					<div @if ($result->status != 'completed') style='display:block;' @else style='display:none;' @endif class='updatebox'>
						<div class='row'>				
						<div class="col-md-12 ">
							<label>Remarks :</label>														
						</div>
						<div class="col-md-12 nopadding">
							<div  class="col-md-12">                            								
								<!--<select class="form-control" id="status" name="status">																				
									<option value="hold" <?php if($result->status == 'hold'){ ?> selected <?php } ?>>Hold</option>
									<option value="pending" <?php if($result->status == 'pending'){ ?> selected <?php } ?>>Pending</option>
									<option value="progress" <?php if($result->status == 'progress'){ ?> selected <?php } ?>>Progress</option>
									<option value="completed" <?php if($result->status == 'completed'){ ?> selected <?php } ?>>Completed</option>
								</select>-->
								<textarea name='remarks' id='remarks' style='width:100%;height:120px;resize: none;'></textarea>
							</div>				
						</div>							
							<div class="col-md-12" style="text-align: right;margin-top: 15px;">								
								<input type='hidden' name='htAction' value='jobsupdate' />
								<input type='hidden' name='job_id' id='job_id' value='{{$result->job_id}}' />
								<input class="btn btn-primary" onclick="updateholdjob({{$result->job_id}})" type="button" value="Update">
								<input class="btn btn-primary" onclick="cancelaction()" type="button" value="Cancel">
						    </div>
					</div>
				</div>	
				</form>	
				</td>								               
              </tr>         
        </table>		
        </div>
<script type="text/javascript">
	$( function() {  
		$('#updateduedate').datepicker({format: 'yyyy-mm-dd'});
	} );
	function cancelaction(){
		bootbox.hideAll();	
	}
	function updateholdjob(){
		var jobid   = document.getElementById('job_id').value;
		var remarks = document.getElementById('remarks').value;
		if(remarks == ''){
			document.getElementById("remarks").style.borderColor = "red";
			document.getElementById('remarks').focus();
			return false;
		} 
		
		$.ajax({
				type: 'GET',
				url: "{{url('reports/updateholdjobdetails')}}",
				data: 'ajaxload=1&jobid='+jobid+'&remarks='+remarks,
				success: function(data){
					bootbox.hideAll();
					parent.location.reload();
				},
			  });		
	}
</script>