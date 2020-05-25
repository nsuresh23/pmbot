<!--  @extends('layouts.app') -->
	

    @section('content')
<?php //echo route('editgroup'); ?>
      <div class="box">
        <div class="box-header">         
          @if (session('status'))
            <div class="alert alert-success">
               <strong>Success!</strong> {{ session('status') }}
            </div>
          @endif 
          
        </div>
		
        <!-- /.box-header -->
		<div class="box-body table-responsive"><!--  no-padding -->
		
		 <form class="form-horizontal" name="searchform" id="searchform" method="POST" enctype="multipart/form-data" action="">
            {{ csrf_field() }}
            <div class='searchbox'>
				<div class='row form-group'>	
				<div class="col-md-2">
					<label>Project:</label	>						
					 <select class="form-control" id="project" name="project">
						<option value="all" <?php if($project == 'all'){ ?> selected <?php } ?>>All</option>
						<option value="aip" <?php if($project == 'aip'){ ?> selected <?php } ?>>AIP</option>
						<option value="eflow" <?php if($project == 'eflow'){ ?> selected <?php } ?>>EFLOW</option>
					 </select>
				</div>				
	               <div class="col-md-3" style='margin-top:30px;' >
						<input type='file' id='dipatch_list' name='dipatch_list'>
						<br>
						<div style='position: absolute;bottom:-10px;'><a href='../../sample.xlsx'>Sample Format</a></div>
	                </div>
					<div class="col-md-2 " >
						<label>&nbsp;</label>
						<input class="btn btn-primary" type="submit" onclick='return ValidateExtension();' value="Update">
						<input type='hidden' name='htAction' value='jobssearch' />
	                </div>
					
					
				</div>
			</div>
			<?php if(!empty($response)) { ?>
			<div class='searchbox'>
				<div class='row form-group'>					
	               <div class="col-md-12 " >
					<div style='font-weight:bold;color:green;font-size:15px;float:left;'><?php echo $response; ?></div>
					</div>
				</div>
			</div>
			<?php } ?>
		</form>

        </div>
        <!-- /.box-body -->
      </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')          
       <script type="text/javascript">
			
			function ValidateExtension() {
				var allowedFiles = [".xlsx", ".xls"];
				var fileUpload = document.getElementById("dipatch_list");
				
				
				var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
				if (!regex.test(fileUpload.value.toLowerCase())) {
					alert('Invalid format. Please upload only ".xlsx, .xls" format ');
					return false;
				}				
				return true;
			}
			
	   </script>
@endsection


