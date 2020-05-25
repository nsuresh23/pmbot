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
					<div class="col-md-2" >                            
						<label>Order ID:</label>
						 <input type='text' id='orderid' class='form-control' name='orderid' value='<?php echo $orderid; ?>'> 
                    </div>	
					<div  class="col-md-2">                            
						 <label>Month:<span class='db_fieldright'>(Dispatch Date)</span></label>
						<select class="form-control" id="month" name="month">
							<option <?php if($fmonth == '01') { ?> selected <?php } ?> value="01">January</option>
							<option <?php if($fmonth == '02') { ?> selected <?php } ?> value="02">February</option>
							<option <?php if($fmonth == '03') { ?> selected <?php } ?> value="03">March</option>
							<option <?php if($fmonth == '04') { ?> selected <?php } ?> value="04">April</option>
							<option <?php if($fmonth == '05') { ?> selected <?php } ?> value="05">May</option>
							<option <?php if($fmonth == '06') { ?> selected <?php } ?> value="06">June</option>
							<option <?php if($fmonth == '07') { ?> selected <?php } ?> value="07">July</option>
							<option <?php if($fmonth == '08') { ?> selected <?php } ?> value="08">August</option>
							<option <?php if($fmonth == '09') { ?> selected <?php } ?> value="09">September</option>
							<option <?php if($fmonth == '10') { ?> selected <?php } ?> value="10">October</option>
							<option <?php if($fmonth == '11') { ?> selected <?php } ?> value="11">November</option>
							<option <?php if($fmonth == '12') { ?> selected <?php } ?> value="12">December</option>
						</select>
						 
                    </div>
					<div  class="col-md-2" >                            
						<label>Year:<span class='db_fieldright'>(Dispatch Date)</span></label>
						<select class="form-control" id="year" name="year">
							<?php
								$earliest_year = 2000;
								foreach (range(date('Y'), $earliest_year) as $x) {
									print '<option value="'.$x.'"'.($x == $tyear ? ' selected="selected"' : '').'>'.$x.'</option>';
								}
								
							?>
						</select>
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

			<table id="usersreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Order No</th> 
							<th>STID</th>
							<th>Source Title</th> 
							<th>Pub Year</th>
							<th>Volume First</th>
							<th>Issue First</th>								
							<th>Article no</th>	
							<th>No of C&A</th>	
							<th>No of References</th>
							<th>Zip File name</th>
							<th>Dispatch Date</th>
							<th>Order Instructions</th>
							<th>Source</th>
							<th>Workflow / Publisher</th>
												
						</tr>
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)
								<tr>             															
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srcid }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srctitle }}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->pyear }}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->volfirst }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->issfirst }}</td>		
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->Article_Count }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ca }}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ref }}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srcid }}.zip</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->dispatchdate != '' ? date('d-M-y', strtotime($results->dispatchdate)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->instruction }}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ordertype }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>																											
								</tr>								
							@endforeach
						@else
							
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
					if($('#month').val()!='')
						passparam += 'month='+$('#month').val();
					if($('#year').val()!='')
						passparam += '&year='+$('#year').val();
					if($('#orderid').val()!='')
						passparam += '&orderid='+$('#orderid').val();
					if($('#publisher').val()!='')
						passparam += '&publisher='+$('#publisher').val();
					if($('#project').val()!='')
						passparam += '&project='+$('#project').val();
					if(passparam!='') 
						passparam = '?'+passparam;				
					window.location.href ="{{url('reports/monthlydispatch_exportxls')}}"+passparam;
				} else{
					alert('No Record Found.');
					
				}
				
			}
		</script>
       
@endsection

