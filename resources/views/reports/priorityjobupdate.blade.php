<div class="box-body table-responsive reportbox">
  <table class="table popupreport" border='0'>
    <tr>
      <td width='50%'><form class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
	  
          <div class='updatebox'>
            <div class='row'>
              <div class="col-md-12 ">
                <label>Edit</label>
              </div>
              <div class="col-md-12 ">
                <div  class="col-md-6">
                  <label>Priority :</label>
                  <input type='number' id='updatedpriority' class='form-control' name='updatedpriority' value='500'>
                </div>
              </div>
              <div class="col-md-12" style="text-align: right;margin-top: 15px;">
                <input type='hidden' name='htAction' value='jobsupdate' />
                <input type='hidden' name='job_id' id='job_id' value='<?php echo $result; ?>' />
                <input class="btn btn-primary" onclick="updatejob()" type="button" value="Update">
                <input class="btn btn-primary" onclick="cancelaction()" type="button" value="Cancel">
              </div>
            </div>
          </div>
        </form></td>
    </tr>
  </table>
</div>
<script type="text/javascript">

	function cancelaction(){
		bootbox.hideAll();	
	}
	function updatejob(){
		var jobid 			= '<?php echo $result; ?>';
		var updatedpriority = document.getElementById('updatedpriority').value;
		$.ajax({
				type: 'GET',
				url: "{{url('reports/update_priority_jobdetails')}}",
				data: 'ajaxload=1&jobid='+jobid+'&updatedpriority='+updatedpriority,
				success: function(data){
					bootbox.hideAll();
					parent.location.reload();
				},
			  });		
	}
</script>
