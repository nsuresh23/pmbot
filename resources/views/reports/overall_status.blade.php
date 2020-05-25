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
		.dataTables_empty{text-align:left !important;}
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
						<label>Date:</label>
						 <select class="form-control" id="fieldname" name="fieldname">
							<option <?php if($fieldname == 'received_date' or $fieldname == '') { ?> selected <?php } ?> value="received_date">Received Date</option>
							<option <?php if($fieldname == 'duedate') { ?> selected <?php } ?> value="duedate">Due Date</option>
							<option <?php if($fieldname == 'dispatchdate') { ?> selected <?php } ?> value="dispatchdate">Dispatch Date</option>
						</select>
                    </div>									
					<div  class="col-md-2">                            
						 <label>From:</label>
						 <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fdate; ?>'> 
                    </div>
					<div  class="col-md-2" >                            
						<label>To:</label> <input class='form-control'  type='text' id='todate' name='todate' value='<?php echo $tdate; ?>'>
                    </div>

					<div class="col-md-2" >                            
						<label>Order ID:</label>
						 <input type='text' id='orderid' class='form-control' name='orderid' value='<?php echo $orderid; ?>'> 
                    </div>	
					<div class="col-md-2 form-group jobsrchbtn searchbtn" style="text-align: right;float:right;margin-top:15px !important;">
						<label>&nbsp;</label>	
						<input type='hidden' name='htAction' value='userssearch' />
						<input class="btn btn-primary" type="submit" value="Search">
						<a class="" href="javascript:void(0);" onclick="export_excel(event,{{$resultcount}});"><img src="{{url('img/excelexport.png')}}" width="35" height="35"></a>
					</div>
				
			</div>
		</div>	
		</form>		
			<div id='pageloader' style='width:101%;height:-webkit-fill-available;' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
			<table id="usersreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>							
							<th>Order ID</th>
							<th>Rec Date</th>
							<th>Due-Date</th>
							<th>Unit ID</th>
							<th>Source-ID</th>							
							<th>Title</th>
							<th>Year</th>							
							<th>Month</th>
							<th>Date</th>							
							<th>Pub Date Text</th>
							<th>Vol</th>							
							<th>Iss</th>
							<th>Art. ID</th>							
							<th>C&A</th>
							<th>Ref</th>							
							<th>Grant List</th>
							<th>Dispatch Date</th>														
							<th>Publisher</th>							
							<th>No of Article Recd In Order</th>
							<th>Input Type [XML/PDF/HTML]</th>							
							<th>Priority Type</th>
							<th>Order Type</th>							
							<th>Article  Based / Issue  Based As Per File Name Recd</th>
							<th>Article  Based / Issue  Based As Per Source Repository</th>							
							<th>Source Type</th>
							<th>Supplier Unit Id</th>							
							<th>Content Provider Id</th>
							<th>Delivered Signal Type</th>							
							<th>Instruction-1 [CAR]</th>
							<th>Instruction-2 [Embase]</th>							
							<th>Embase Zip Name</th>
							<th>Embase Dispatched Date</th>							
							<th>Production Query Remark</th>							
							<th>Complexity Type [Notes/1000+ Authors]</th>							
							<th>Out-Off TAT Remark</th>
							<th>TAT Days</th>
						</tr>
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)
								<tr>             																								
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->received_date != '' ? date('d-M-y', strtotime($results->received_date)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->duedate != '' ? date('d-M-y', strtotime($results->duedate)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->unitid}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->srcid}}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->srctitle}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->pyear}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->pmonth}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->pday}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->pdatetext}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->volfirst}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->issfirst}}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->ca}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->ref}}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->grantlist}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->dispatchdate != '' ? date('d-M-y', strtotime($results->dispatchdate)) : "" }}</td>																	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->publisher}}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->Article_Count}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->workflow}}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->ordertype	}}</td>																	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->srctype}}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->suplunitid}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->cpid}}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->instruction}}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->instruction}}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->order_remark}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->tatdays}}</td>

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
				document.getElementById("pageloader").style.display = "none";
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
					if($('#fieldname').val()!='')
						passparam += '&fieldname='+$('#fieldname').val();
					if($('#orderid').val()!='')
						passparam += '&orderid='+$('#orderid').val();
					if($('#publisher').val()!='')
						passparam += '&publisher='+$('#publisher').val();
					if($('#project').val()!='')
						passparam += '&project='+$('#project').val();
					if(passparam!='') 
						passparam = '?'+passparam;				
					window.location.href ="{{url('reports/overallstatus_exportxls')}}"+passparam;
				} else{
					alert('No Record Found.');					
				}
				
			}
		</script>
       
@endsection

