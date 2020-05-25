
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
		.dataTables_scrollBody {minheight:500px !important;}
		.emptyheader{border-bottom:0px !important;border-top:1px solid black;border-left:1px solid black;}
		.refemptyheader{text-align: center !important;padding: 0; border: 1px solid black;}
		.jobemptyheader{text-align: center !important;padding: 0; border: 1px solid black;border-left:0px;}
		
		.subjobheader{border:1px solid black;border-right:0px;border-top:0px;}
		.suborheader{border:1px solid black;border-top:0px;border-right:0px;}
		.dataTables_empty{border-bottom:1px solid black;}
		.dataTables_wrapper.no-footer .dataTables_scrollBody{border-bottom:0px !important;}
		.bottom_border{border-bottom:1px solid black;background-color: #d0cfcf !important;}
		.bgcolor{background-color: #d0cfcf !important;}
		
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
		<div id='pageloader' style='width:102%;height:-webkit-fill-available;' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
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
	               <div class="col-md-2" >
						<label>From:</label>
		                  <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fromdate; ?>'> 
	                </div>
					<div class="col-md-2" >
						<label>To:</label>
		                <input type='text' id='todate' class='form-control' name='todate' value='<?php echo $todate; ?>'> 
	                </div>
					<div class="col-md-2 " style="text-align: center;margin-top:25px;"><!-- margin-top:25px;style="text-align: center;"form-group -->
						<label>&nbsp;</label>
						<input class="btn btn-primary" type="submit" value="Search">
						<input type='hidden' name='htAction' value='jobssearch' />
	                </div>
				</div>
			</div>
		</form>
		<div style='overflow: hidden;overflow-x: scroll;'>
			<table class="manualtable" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style='border-bottom:1px solid black;'>Job Id</th> 
							<th style='border-bottom:1px solid black;'>Order Id</th> 
							<th style='border-bottom:1px solid black;'>Publisher</th> 
							<th style='border-bottom:1px solid black;'>File Path</th> 
							<th style='border-bottom:1px solid black;'>File Name</th> 
							<th style='border-bottom:1px solid black;'>Current Process</th> 
						</tr>
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)

								<tr style='background: #d1d1d2;'>
									<td><a href="{{url('reports/individualjobsdetail')}}/{{$results->job_id}}">{{ $results->job_id }}</a></td>
									<td ><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>
									<td >{{ $results->publisher }}</td>
									<td>{{ $results->filename }}</td>
									<td>{{ $results->filepath }}</td>
									<td>{{ $results->current_process }}</td>
								</tr>
							
										
											
										<tr style='border:0px !important;'>      
										
											<td colspan='6' style='padding:0px !important;'>
												<table style='background-color:#dadada;    display: inline-table;' class="manualtableinner"  cellspacing="0" width="100%">
													<thead>
														<tr>
															<th width='15%'>Ticket ID </th> 
															<th width='10%'>Ticket Type</th> 
															<th width='25%'>Query</th> 
															<th width='15%'>Query By</th> 
															<th width='15%'>Query Date</th> 															 
														</tr>
													</thead>
													@if (count($results->querylist))
														@foreach ($results->querylist as $j => $res)
															
																
															<tr>      
															
																
																<td width='15%'>{{ $res->ticket_id != '' ? $res->ticket_id : "-" }}</td>
																<td width='10%'>{{ $res->ticket_type != '' ? $res->ticket_type : "-" }}</td>
																<td width='25%'><?php echo base64_decode($res->query); ?>	</td>
																<td width='15%'>{{ $res->post_status != '' ? $res->post_status : "-" }}</td>
																<td width='15%'>{{ $res->created_date != '' ? $res->created_date : "-" }}</td>
																	
																</td>											
															</tr>
														@endforeach
													@endif	
												</table>
											</td>											
										</tr>
										

								<tr>
									<td colspan='6' style='border-bottom:2px solid black;'></td>
								</tr>
								
							@endforeach
						@else
							<tr>      
								<td  colspan='6' class='noresult'>No data available in table</td>											
							</tr>
						@endif
					</tbody>
				</table>
		</div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
           <script type="text/javascript" class="init">
		   
		   
			$(document).ready(function() {
				document.getElementById("pageloader").style.display = "none";
				/*var table = $('#querylist').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					pageLength:     100,
					
				} );*/
			} );
			
			function showquery(job_id,ticketid,ticket_type)
			{
				$.ajax({
				type: 'GET',
				url: "{{url('reports/query_popupreport')}}",            				
				data: 'ajaxload=1&job_id='+job_id+'&ticketid='+ticketid+'&ticket_type='+ticket_type,						
				success: function(data){               
					bootbox.alert(data)
				},
			  });			
			}
		</script>
       
@endsection

