
		
        <div class="box-body table-responsive reportbox"><!--  no-padding -->
		
		
		<table class="table popupreport" border='0'	>
            
              <tr>                
				<td width='50%'>
				
				
				
				<div style='width:750px;' class='jobsdetailbox'>
					<table class="table popupreport" width='100%' cellpadding="5" cellspacing="5"  border='0'>
						@foreach ($result as $k => $results)
						<tr>						
							<td class='fieldtitle'>{{$k}} :</td>	
							<td >{{nl2br(e($results))}}</td>							
						</tr>
						@endforeach
					   
					</table>
				
				</div>

				
				
				</td>
				
				<td width='50%'>
				
				
				
				
				
				
				<form class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
					{{ csrf_field() }}
					<div @if ($result->status != 'completed') style='display:block;' @else style='display:none;' @endif class='updatebox'>
						<div class='row'>				
						<div class="col-md-12 ">
							<label>Edit</label>	
							

							
						</div>
						<div class="col-md-12 ">
							<div  class="col-md-6">                            
							 <label>Priority :</label>
							 <input type='number' id='updatedpriority' class='form-control' name='updatedpriority' value='{{$result->priority}}'> 
							</div>
							<div  class="col-md-6">                            
							 <label>Due Date :</label>
							 <input type='text' id='updateduedate' class='form-control' name='updateduedate' value='{{$result->duedate}}'> 
							</div>							
						</div>							
							<div class="col-md-12" style="text-align: right;margin-top: 15px;">								
								<input type='hidden' name='htAction' value='jobsupdate' />
								<input type='hidden' name='job_id' id='job_id' value='{{$result->job_id}}' />
								<input type='hidden' name='original_priority' id='original_priority' value='{{$result->priority}}' />
								<input type='hidden' name='original_duedate' id='original_duedate' value='{{$result->duedate}}' />
								<input class="btn btn-primary" onclick="updatejob({{$result->job_id}})" type="button" value="Update">
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
	function updatejob(){
		var jobid = document.getElementById('job_id').value;
		var updatepriorityvalue   = document.getElementById('updatedpriority').value;
		var updatedduedatevalue   = document.getElementById('updateduedate').value;
		var originalpriorityvalue = document.getElementById('original_priority').value;
		var originalduedatevalue  = document.getElementById('original_duedate').value;
		
		$.ajax({
				type: 'GET',
				url: "{{url('reports/updatejobdetails')}}",
				data: 'ajaxload=1&jobid='+jobid+'&updatepriorityvalue='+updatepriorityvalue+'&updatedduedatevalue='+updatedduedatevalue+'&originalpriorityvalue='+originalpriorityvalue+'&originalduedatevalue='+originalduedatevalue,
				success: function(data){
					bootbox.hideAll();
					parent.location.reload();
				},
			  });		
	}
</script>