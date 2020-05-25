<!--  @extends('layouts.app') -->     
    <style type="text/css" class="init">
		th, td { white-space: nowrap; }
		div.dataTables_wrapper {
			width: 100%;
			margin: 0 auto;
		}
		.dataTables_wrapper{		
			overflow: inherit !important;
		}
		.example_wrapper{		
			overflow: inherit !important;
		}
		.dataTables_scrollBody {min-height:100px !important;}
	</style> 
    @section('content')
<?php //echo route('editgroup'); ?>
      <div class="box">
        <div class="box-header">         
          @if (session('status'))
            <div class="alert alert-success">
               <strong>Success!</strong> {{ session('status') }}
            </div>
          @endif 
          <div class="box-tools">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive"><!--  no-padding -->
		
		
		<form class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
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
					<div class="col-md-2">
						<label>Publisher:</label	>						
		                 <select class="form-control" id="publisher" name="publisher">
							<option value="all" <?php if($publisher == 'all'){ ?> selected <?php } ?>>All</option>
							@foreach($publisherlist as $publishers)
								@if ($publishers->publisher != '')									
									<option value='{{$publishers->publisher}}' <?php if($publisher == $publishers->publisher){ ?> selected <?php } ?>> {{$publishers->publisher}}</option>								
								@endif																
							 @endforeach
						 </select>
	                </div>				
					<div  class="col-md-2">                            
						 <label>From:<span class='db_fieldright'>(Dispatch Date)</span></label>
						 <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fdate; ?>'> 
                    </div>
					<div  class="col-md-2" >                            
						<label>To:<span class='db_fieldright'>(Dispatch Date)</span></label> <input class='form-control' type='text' id='todate' name='todate' value='<?php echo $tdate; ?>'>
                    </div>
					<div class="col-md-2 form-group jobsrchbtn" style="text-align: center;margin-top:25px !important;">
						<label>&nbsp;</label>	
						<input type='hidden' name='htAction' value='userssearch' />
						<input class="btn btn-primary" type="submit" value="Search">
						<a class="" href="javascript:void(0);" onclick="export_excel(event,{{$resultcount}});"><img src="{{url('img/excelexport.png')}}" width="35" height="35"></a>
				</div>

			</div>
		</div>	
		</form>		

			<table id="usersreport"  cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Instruction</th> 
							<th>Service</th>
							<th>Product Code</th> 
							<th>Product Code Description</th>
							<th>Unit of Billing</th>
							<th>Quantity</th>													
						</tr>
					</thead>
					<tbody>
						@if ($REF > 0 || $CA > 0)

								<tr>             						
									<td>Create CAR</td>
									<td>C&A Processing</td>
									<td>-</td>	
									<td>C&A creation from XML</td>
									<td>-</td>																		
									<td style='text-align:center;'>{{$CA}}</td>										
								</tr>								
								<tr>             						
									<td>Create CAR</td>
									<td>Reference Processing</td>
									<td>-</td>	
									<td>Reference creation from XML</td>
									<td>-</td>									
									<td style='text-align:center;'>{{$REF}}</td>										
								</tr>
								<tr>             						
									<td style='border-top:1px solid black;'>No. of CARs with grants delivered during the period</td>
									<td style='border-top:1px solid black;'></td>
									<td style='border-top:1px solid black;'></td>	
									<td style='border-top:1px solid black;'></td>
									<td style='border-top:1px solid black;border-right:1px solid black;'></td>									
									<td colspan='5' style='border-top:1px solid black;text-align:center;'>{{$REF+$CA}}</td>										
								</tr>
	
						@endif
					</tbody>
				</table>
         

        </div>
        <!-- /.box-body -->
      </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
           <script type="text/javascript" class="init">
			$(document).ready(function() {
				var table = $('#usersreport').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100]
				} );
			} );
			
			function export_excel(event,listcount)
			{
				if(listcount > 0){
					event.preventDefault();
					var passparam = '';				
					if($('#fromdate').val()!='')
						passparam += 'fromdate='+$('#fromdate').val();
					if($('#todate').val()!='')
						passparam += '&todate='+$('#todate').val();	
					if($('#publisher').val()!='')
						passparam += '&publisher='+$('#publisher').val();	
					if($('#project').val()!='')
						passparam += '&project='+$('#project').val();						
					if(passparam!='') 
						passparam = '?'+passparam;				
					window.location.href ="{{url('reports/monthlyoverview_exportxls')}}"+passparam;
				} else{
					alert('No Record Found.');
					
				}
				
			}
		</script>
       
@endsection

