<!--  @extends('layouts.app') -->
	<style type="text/css" class="init">
		.dataTables_wrapper {			
			overflow: inherit !important;
		}
		th, td { white-space: nowrap; }
		/*div.dataTables_wrapper {
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
		.dataTables_wrapper.no-footer .dataTables_scrollBody{border-bottom:0px !important;}*/
		
		.DTFC_LeftBodyLiner[style]{
			overflow: inherit !important;
		}
		
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
					<label>From:</label>
					  <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fromdate; ?>'> 
				</div>
				<div class="col-md-2" >
					<label>To:</label>
					<input type='text' id='todate' class='form-control' name='todate' value='<?php echo $todate; ?>'> 
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
		<table id="nonticketssummary" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>						
						<tr>                
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">Jobs Recd Date</th>
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">No of Jobs Recd</th>	
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">No of Jobs with Ticket</th>
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">No of Jobs without Ticket</th>	
							<th colspan="4" style="border-left:1px solid #d2cdcd; border-bottom:1px solid #d2cdcd; text-align:center;" align="center">No of Tickets</th>
						</tr>
						<tr>
						  <th style="border-left:1px solid #d2cdcd; border-bottom:1px solid #d2cdcd; text-align:center;">Item Type</th>
					      <th style="border-left:1px solid #d2cdcd; border-bottom:1px solid #d2cdcd;text-align:center;">Reference</th>
					      <th style="border-left:1px solid #d2cdcd; border-bottom:1px solid #d2cdcd;text-align:center;">Grant</th>
					      <th style="border-left:1px solid #d2cdcd; border-bottom:1px solid #d2cdcd;text-align:center;">Affiliation</th>
					  </tr>															
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)							
								<tr>             															
									<td class='bgcolor'>{{ $results->Rec_date }}</td>
									<td class='bgcolor'>{{ $results->Total_Tickets }}</td>									
									<td class='bgcolor'>{{ $results->WithTicket }}</td>
									<td class='bgcolor'>{{ $results->WithOutTicket }}</td>
									<td class='bgcolor'>{{ @$results->item_type }}</td>
									<td class='bgcolor'>{{ @$results->Reference }}</td>
									<td class='bgcolor'>{{ @$results->Grant }}</td>
									<td class='bgcolor'>{{ @$results->Affiliation }}</td>
									
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
		  /* function export_excel(event,listcount)
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
           }*/
		   
			$(document).ready(function() {
				var table = $('#nonticketssummary').DataTable( {
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

