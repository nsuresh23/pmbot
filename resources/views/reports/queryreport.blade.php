<style>

	.modal-footer {
		display:none !important;
	}

</style>
        <div class="box-body table-responsive reportbox"><!--  no-padding -->			
				<div style='width: 100%;float: left;margin-bottom: 15px;'>
						@if (count($result))
							<div class='queryjobdetails'>
								<span style='text-transform: capitalize;width:100%;float:left;'><b>Job Id &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> {{ $result[0]->job_id }}</span>
								<span style='text-transform: capitalize;width:100%;float:left;'><b>Ticket Type  :</b> {{ $result[0]->ticket_type }}</span>
								<span style='text-transform: capitalize;width:100%;float:left;'><b>Ticket Id &nbsp;&nbsp;&nbsp;&nbsp;:</b> {{ $result[0]->ticket_id }}</span>
								<span style='text-transform: capitalize;width:100%;float:left;'>
									<b>File Name &nbsp;&nbsp;:</b> {{ $result[0]->filename }}<br>
									<b>File Path &nbsp;&nbsp;&nbsp;&nbsp;:</b> {{ $result[0]->filepath }}
								</span>	
								
							</div>
							@foreach ($result as $k => $results)
								
									@if($results->query_type == 'Query')
										<div class='querylisting'>										
											<label>User Query:</label>
											<span style='text-transform: capitalize;width:100%;float:left;'><?php echo base64_decode($results->query); ?></span>									
											<label>Query by:</label>
											<span style='text-transform: capitalize;width:15%;float:left;'>User : {{ $results->user_id }}</span>	
											<span style='text-transform: capitalize;width:45%;float:left;'>Query date : {{ $results->query_date }}</span>	
											<span style='text-transform: capitalize;width:35%;float:left;'><b>Elapsed Time :</b> {{ $results->ticket_elapsed_time }}</span>
											<label style=' border-top: 1px dotted #ccc7c7;margin-top:5px;'></label>
											</span>	
										</div>
									@else			
										<div class='querylisting replybg'>
											<div class='reply_box'>
											<label>Reply:</label>
											<span style='text-transform: capitalize;width:100%;float:left;'><?php echo base64_decode($results->query); ?></span>
											<span style='text-transform: capitalize;width:15%;float:left;'>Reply by : {{ $results->replied_by }}</span>	
											<span style='text-transform: capitalize;width:35%;float:left;'>Reply date : {{ $results->query_date }}</span>
											</div>
										</div>
									@endif
							@endforeach
						@endif
				</div>

			<form style='width:100%;float:left;' class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
					{{ csrf_field() }}
					<div class='updatebox'>
						<div class='row'>				
						<div class="col-md-12 ">
							<label>Comment</label>	
						</div>
						<div class="col-md-12 ">
							 <textarea id='comments' style='height:75px; resize: none;' class='form-control' name='comments'></textarea>
						</div>	
						<div class="col-md-12" style='margin-top:10px;'>
							<label style='width:100%;'>Reply by:</label>
							<input type='radio' name='replyedby' id='replyedby' checked value='user' > User
							<input id='replyedby' type='radio' name='replyedby' value='client' > Client
						</div>							
						<div class="col-md-12" style="text-align: right;margin-top: 15px;">								
								<input type='hidden' name='htAction' value='queryreply' />	
								<input type='hidden' name='ticket_id' id='ticket_id' value='{{$ticket_id}}' />
								<input type='hidden' name='ticket_type' id='ticket_type' value='{{$ticket_type}}' />
								<input type='hidden' name='job_id' id='job_id' value='{{$job_id}}' />								
								<input class="btn btn-primary" onclick="cancelaction()" type="button" value="Cancel">
								<input class="btn btn-primary" onclick="replyquery()" type="button" value="Submit">
						</div>
					</div>
				</div>	
				</form>	
				
				
        </div>
<script type="text/javascript">

	function cancelaction(){
		bootbox.hideAll();
	}
	function replyquery(){
		var ticket_id   = document.getElementById('ticket_id').value;		
		var ticket_type = document.getElementById('ticket_type').value;		
		var job_id      = document.getElementById('job_id').value;
		var comments    = document.getElementById('comments').value;		
		var replyedby   = $("input[type='radio'][name='replyedby']:checked").val();
		
		if(comments == '') {
			alert('Please enter the comments.');
			document.getElementById("comments").focus();
			return false;
		}
		$.ajax({
				type: 'GET',
				url: "{{url('reports/replyquery')}}",
				data: 'ajaxload=1&jobid='+job_id+'&ticket_id='+ticket_id+'&ticket_type='+ticket_type+'&comments='+comments+'&replyedby='+replyedby,
				success: function(data){
					bootbox.hideAll();
					parent.location.reload();
				},
			  });	
			
	}
</script>