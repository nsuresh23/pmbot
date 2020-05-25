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
		.dataTables_empty{border-bottom:1px solid black;border-left:1px solid black;}
		
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
					 <div class="col-md-2" >
						<label>Due Date</label>
		                  <input type='text' id='jobdate' class='form-control' name='jobdate' value='<?php echo $jobdate; ?>'> 
	                </div>
					<div class="col-md-2" >                            
						<label>Date :</label>
						 <select class="form-control" id="fieldname" name="fieldname">
							<option <?php if($fieldname == 'dispatchdate') { ?> selected <?php } ?> value="dispatchdate">Dispatch Date</option>
							<option <?php if($fieldname == 'duedate') { ?> selected <?php } ?> value="duedate">Due Date</option>
							<option <?php if($fieldname == 'received_date') { ?> selected <?php } ?> value="received_date">Received Date</option>

						</select>
                    </div>	
					<div class="col-md-2 " style="text-align: center;margin-top:25px;"><!-- margin-top:25px;style="text-align: center;"form-group -->
						<label>&nbsp;</label>
						<input class="btn btn-primary" type="submit" value="Search">
						<input type='hidden' name='htAction' value='jobssearch' />

	                </div>
	                <div class="col-md-1 box-tools" style="text-align: center;margin-top:15px;padding-left: 0px;"><!-- verticle-align:center; fa fa-file-excel-o -->
			            <a class="" href="javascript:void(0);" onclick="passexport(event);"><img src="{{url('img/excelexport.png')}}" width="50" height="50"></a>
          			</div>
				</div>
			</div>
		</form>
	
		<table id="jobsreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>						
						<tr>                
							<th class='subjobheader'>Job Id</th>
							<th class='suborheader'>Order Id</th>	
							<th class='suborheader'>Publisher</th>
							<th class='suborheader'>Received Date</th>	
							<th class='suborheader'>Due Date</th>	
							<th class='suborheader'>Current Process</th>							
							<th class='suborheader'>Item Type</th>	
							<th class='suborheader'>Articles with Ticket</th>	
							<th class='suborheader'>Articles without Ticket</th>								
							<th class="subjobheader">Source File & Location</th>							
						</tr>															
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)							
								<tr>             						
									<td class='bgcolor left-border'>{{ $results->job_id }}</td>
									<td class='bgcolor left-border'>{{ $results->orderid }}</td>
									<td class='bgcolor left-border'>{{ $results->publisher }}</td>
									<td class='bgcolor left-border'>{{ $results->received_date }}</td>
									<td class='bgcolor left-border'>{{ $results->duedate }}</td>							
									<td class='bgcolor left-border'>{{ $results->current_process }}</td>																		
									<?PHP							
										$ItemType_1_Other_Ticket_Count = '';
										$ItemType_0_Other_Ticket_Count = '';			
										if($JobsInfo_Row[$i]->ItemType_Ticket_Total_Count > 0){				
											
											$ItemType_1_Other_Ticket_Count = 
																		$JobsInfo_Row[$i]->Reference_Ticket_Total_Count + 
																		$JobsInfo_Row[$i]->Grant_Ticket_Total_Count + 
																		$JobsInfo_Row[$i]->Affiliation_Ticket_Total_Count + 
																		$JobsInfo_Row[$i]->MathExpression_Ticket_Total_Count;
											if ($ItemType_1_Other_Ticket_Count == 0	){
												$ItemType_1_Other_Ticket_Count = '';
											}	
										}else{				
											$ItemType_0_Other_Ticket_Count = 
																		$JobsInfo_Row[$i]->Reference_Ticket_Total_Count + 
																		$JobsInfo_Row[$i]->Grant_Ticket_Total_Count + 
																		$JobsInfo_Row[$i]->Affiliation_Ticket_Total_Count + 
																		$JobsInfo_Row[$i]->MathExpression_Ticket_Total_Count;
											if ($ItemType_0_Other_Ticket_Count == 0	){
												$ItemType_0_Other_Ticket_Count = '';
											}											
										}							
									?>										
									<td class='bgcolor left-border'>{{ $results->ItemType_Ticket_Total_Count }}</td>
									<td class='bgcolor left-border'>{{ $ItemType_1_Other_Ticket_Count }}</td>
									<td class='bgcolor left-border'>{{ $ItemType_0_Other_Ticket_Count }}</td>																											
									<td class='bgcolor right-border'>
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
		   
		   function passexport(event)
                {
                	event.preventDefault();
                	var passparam = '';
                	if($('#orderid').val()!='')
                		passparam += 'orderid='+$('#orderid').val();
                	if($('#fromdate').val()!='')
                		passparam += 'duedate='+$('#fromdate').val();
                	if($('#filename').val()!='')
                		passparam += 'filename='+$('#filename').val();
                	if(passparam!='') 
                		passparam = '?'+passparam;
					
                	window.location.href ="{{url('reports/exportxls')}}"+passparam;
                }
		   
			$(document).ready(function() {
				var table = $('#jobsreport').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					fixedColumns:   {
						leftColumns: 2
					}
				} );
			} );
		</script>
       
@endsection

