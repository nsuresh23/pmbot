<!--  @extends('layouts.app') -->
	<style type="text/css" class="init">
		.dataTables_wrapper {			
			overflow: inherit !important;
		}
		th, td { white-space: nowrap; }
		div.dataTables_wrapper {
			width: 100%;
			margin: 0 auto;
		}
		
		.example_wrapper{		
			overflow: inherit !important;
		}
		.dataTables_scrollBody {min-height:60px !important;}
		.emptyheader{border-bottom:0px !important;border-top:1px solid black;border-left:1px solid black;}
		.refemptyheader{text-align: center !important;padding: 0; border: 1px solid black;}
		.jobemptyheader{text-align: center !important;padding: 0; border: 1px solid black;border-left:0px;}
		
		.subjobheader{border:1px solid black;border-right:0px;border-top:0px;}
		.suborheader{border:1px solid black;border-top:0px;border-right:0px;}
		.dataTables_empty{border-bottom:1px solid black;}
		.dataTables_wrapper.no-footer .dataTables_scrollBody{border-bottom:0px !important;}
		
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
						<label>Date Type:</label>
						 <select class="form-control" id="fieldname" name="fieldname">
							<option <?php if($fieldname == 'modified_date') { ?> selected <?php } ?> value="modified_date">Process Date</option>
							<option <?php if($fieldname == 'received_date') { ?> selected <?php } ?> value="received_date">Received Date</option>
							<option <?php if($fieldname == 'duedate') { ?> selected <?php } ?> value="duedate">Due Date</option>							
							<option <?php if($fieldname == 'dispatchdate') { ?> selected <?php } ?> value="dispatchdate">Dispatch Date</option>
						</select>
                    </div>	
					<div class="col-md-2" >
						<label>From:</label>
		                  <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fromdate; ?>'> 
	                </div>
					<div class="col-md-2" >
						<label>To:</label>
		                <input type='text' id='todate' class='form-control' name='todate' value='<?php echo $todate; ?>'> 
	                </div>
					<div class="col-md-2" >                            
						<label>Ticket:</label>
						 <select class="form-control" id="articleticket" name="articleticket">
							<option <?php if($articleticket == 'all') { ?> selected <?php } ?> value="all">All</option>
							<option <?php if($articleticket == 'withticket') { ?> selected <?php } ?> value="withticket">Articles with Ticket</option>
							<option <?php if($articleticket == 'withoutticket') { ?> selected <?php } ?> value="withoutticket">Articles without Ticket</option>
						</select>
                    </div>	
					
					<div class="col-md-2" style="text-align: right;margin-top:25px;float:right;">
						<label>&nbsp;</label>
						<input class="btn btn-primary" type="submit" value="Search">
						<input type='hidden' name='htAction' value='jobssearch' />
						<a class="" href="javascript:void(0);" onclick="export_excel(event,{{$resultcount}});"><img src="{{url('img/excelexport.png')}}" width="35" height="35"></a>
	                </div>
	                
				</div>
			</div>
		</form>
	
		<table id="nontickets" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>						
						<tr>                
							<th>Job Id</th>
							<th>Order Id</th>	
							<th>Publisher</th>
							<th>Received Date</th>	
							<th>Process Date</th>
							<th>Due Date</th>	
							<th>Dispatch Date</th>							
							<th>Current Process</th>
							<th>Remarks</th>	
							<th>Error Info</th>
							<?php if($articleticket != 'withoutticket') { ?>
								<th>Ticket Count</th>	
							<?php } ?>
							<th>Source File & Location</th>							
						</tr>															
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)							
								<tr>             															
									<td class='bgcolor'><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
									<td class='bgcolor'><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>									
									<td class='bgcolor'>{{ $results->publisher }}</td>
									<td class='bgcolor'>{{ $results->received_date }}</td>
									<td class='bgcolor'>{{ $results->modified_date }}</td>
									<td class='bgcolor'>{{ $results->duedate }}</td>	
									<td class='bgcolor'>{{ $results->dispatchdate }}</td>									
									<td class='bgcolor'>{{ $results->current_process }}</td>
									<td class='bgcolor'>{{ $results->remarks }}</td>	
									<td class='bgcolor'>
										<?php
											echo wordwrap($results->error_info,100,"<br>\n");
										?>
									</td>
									<?php if($articleticket != 'withoutticket') { ?>
										<td class='bgcolor'>{{ $results->Ticket_Total_Count }}</td>
									<?php } ?>
									<td class='bgcolor'>
										Name:&nbsp;&nbsp;{{ $results->filename }}<br />
										Path:&nbsp;&nbsp;&nbsp;&nbsp;{{ $results->filepath }}
									</td>									
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
		   function export_excel(event,listcount)
           {
               if(listcount > 0){
					event.preventDefault();
                	var passparam = '';
                	if($('#fromdate').val()!='')
                		passparam += 'fromdate='+$('#fromdate').val();
						passparam += '&todate='+$('#todate').val();
						passparam += '&fieldname='+$('#fieldname').val();
						passparam += '&articleticket='+$('#articleticket').val();
						passparam += '&publisher='+$('#publisher').val();
						passparam += '&project='+$('#project').val();
                	if(passparam!='') 
                		passparam = '?'+passparam;
					
                	window.location.href ="{{url('reports/nonTickets_ExportXls')}}"+passparam;
				} else{
					alert('No Record Found.');					
				}		
           }
		   
			$(document).ready(function() {
				var table = $('#nontickets').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100],
					fixedColumns:   {
						leftColumns: 2
					}
				} );
			} );
		</script>
       
@endsection

