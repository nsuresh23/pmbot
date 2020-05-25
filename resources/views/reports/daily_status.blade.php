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
		.dataTables_scrollBody {min-height:60px !important;}
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
					<div  class="col-md-2">                            
						 <label>From:<span class='db_fieldright'>(Received / Dispatch Date)</span></label>
						 <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fdate; ?>'> 
                    </div>
					<div  class="col-md-2" >                            
						<label>To:<span class='db_fieldright'>(Received / Dispatch Date)</span></label> <input class='form-control' type='text' id='todate' name='todate' value='<?php echo $tdate; ?>'>
                    </div>				
									

					<div class="col-md-1 form-group jobsrchbtn" style="text-align: center;">
						<label>&nbsp;</label>	
						<input type='hidden' name='htAction' value='userssearch' />
						<input class="btn btn-primary" type="submit" value="Search">
				</div>
				<div class="col-md-1 box-tools" style="text-align: center;margin-top:15px;padding-left: 0px;">
					<a class="" href="javascript:void(0);" onclick="export_excel(event,{{$resultcount}});"><img src="{{url('img/excelexport.png')}}" width="50" height="50"></a>
				</div>
			</div>
		</div>	
		</form>		

			<table id="daily_status" class="stripe row-border order-column" cellspacing="0" width="100%">

					</thead>
					<thead>		
			
						<tr> 
						<th style='text-align:center;border-top:1px solid black;border-left:1px solid black;'></th>
							<th style='text-align:center;border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;' colspan="3">E-FLOW CAR ORDER STATUS</th>
							<th style='text-align:center;border-top:1px solid black;border-right:1px solid black;' colspan="2" >E-FLOW DISPATCH</th>															
						 </tr>	
						 
						<tr>                
							<th style='border-left:1px solid black;' >Date</th>
							<th style='border-left:1px solid black;border-right:1px solid black;' >No.of CAR order recvd</th>
							<th style='border-right:1px solid black;'>No.of CAR order closed</th>
							<th style='border-right:1px solid black;'>No.of CAR order recvd Article Count</th>														
						
						
							<th style='border-right:1px solid black;'>C&A</th>
							<th style='border-right:1px solid black;'>Refs</th>
												
						</tr>															
					</thead>
					
					<tbody>
							@if (count($result))
							@foreach ($result as $k => $results)
								<tr>             																								
									<td @if ($k % 2 == 0) class='bgcolor' @endif><?php echo $results['datelist']; ?></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif><?php echo $results['orders_received']; ?></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif><?php echo $results['orders_closed']; ?></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif><?php echo $results['article_count']; ?></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif><?php echo $results['ca_count']; ?></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif><?php echo $results['ref_count']; ?></td>
								</tr>								
							@endforeach
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
				var table = $('#daily_status').DataTable( {
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
					if($('#project').val()!='')
						passparam += '&project='+$('#project').val();
					if(passparam!='') 
						passparam = '?'+passparam;				
					window.location.href ="{{url('reports/dailystatus_exportxls')}}"+passparam;
				} else {
					alert('No Record Found.');
					
				}				
			}
		</script>
       
@endsection