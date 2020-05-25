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
		
		#publisherticket .dataTables_scrollBody{height:500px !important; overflow:hidden;}
		.dataTables_scrollBody{overflow:hidden !important; overflow-y:scroll !important; }
		
		
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
		 <form class="form-horizontal" name="searchform" id="searchform" method="POST" action="" onsubmit="return validateForm()">
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
					<label>From: <span class="db_fieldright">(Received Date)</span></label>
					  <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fromdate; ?>'> 
					  <div><span class="db_fieldright" style="color:#64151C">(Date range should be 31 days only)</span></div>
				</div>
				<div class="col-md-2" >
					<label>To: <span class="db_fieldright">(Received Date)</span></label>
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
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">Total Jobs</th>	
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">Jobs with Ticket</th>
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">Jobs without Ticket</th>	
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
					<?php $totalticketsum = 0;$totalwithticketsum = 0;$totalwithoutticketsum = 0;$totalitemtypesum = 0;$totalreferencesum = 0;$totalgrantsum = 0;$totalaffiliationsum = 0; ?>
						@if (count($result))
							@foreach ($result as $k => $results)
								<?php 									
										$totalticketsum 			+= $results->Total_Tickets;
										$totalwithticketsum 		+= $results->WithTicket;
										$totalwithoutticketsum		+= $results->WithOutTicket;
										$totalitemtypesum			+= @$results->item_type;
										$totalreferencesum			+= @$results->Reference;
										$totalgrantsum				+= @$results->Grant;
										$totalaffiliationsum		+= @$results->Affiliation;
								?>
								<tr>             															
									<td  @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->Rec_date }}</td>
									<td  @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->Total_Tickets }}</td>									
									<td  @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->WithTicket }}</td>
									<td  @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->WithOutTicket }}</td>
									<td  @if ($k % 2 == 0) class='bgcolor' @endif>{{ @$results->item_type }}</td>
									<td  @if ($k % 2 == 0) class='bgcolor' @endif>{{ @$results->Reference }}</td>
									<td  @if ($k % 2 == 0) class='bgcolor' @endif>{{ @$results->Grant }}</td>
									<td  @if ($k % 2 == 0) class='bgcolor' @endif>{{ @$results->Affiliation }}</td>
								</tr>
							@endforeach
						@endif
					</tbody>
					@if (count($result))
						@if ($totalticketsum > 0)
							<tr>             						
								<td style='border-top:1px solid black !important;font-weight:bold;' > Total</td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalticketsum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalwithticketsum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalwithoutticketsum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalitemtypesum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalreferencesum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalgrantsum ?> </td>
								<td style='border-top:1px solid black !important;'> <?php echo $totalaffiliationsum ?> </td>							
							</tr>	
						@endif	
					@endif		
				</table>
				</table>
				<table id="publisherticket" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>						
						<tr>                
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">Publisher</th>
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">Total Jobs</th>	
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">Jobs with Ticket</th>
							<th rowspan="2" style="border-bottom:1px solid #d2cdcd;">Jobs without Ticket</th>	
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
					<?php $totalticketpublihersum = 0;$totalwithticketpublihersum = 0;$totalwithoutticketpublihersum = 0;$totalpubliheritemtypesum = 0;$totalpubliherreferencesum = 0;$totalpublihergrantsum = 0;$totalpubliheraffiliationsum = 0; ?>
						@if (count($publisherresult))
							@foreach ($publisherresult as $k => $ticketpublisherlists)
							<?php /*?>@if ($ticketpublisherlists->Total_Tickets > 0)<?php */?>
								<?php 									
										$totalticketpublihersum 			+= $ticketpublisherlists->Total_Tickets;
										$totalwithticketpublihersum 		+= $ticketpublisherlists->WithTicket;
										$totalwithoutticketpublihersum		+= $ticketpublisherlists->WithOutTicket;
										$totalpubliheritemtypesum			+= @$ticketpublisherlists->item_type;
										$totalpubliherreferencesum			+= @$ticketpublisherlists->Reference;
										$totalpublihergrantsum				+= @$ticketpublisherlists->Grant;
										$totalpubliheraffiliationsum		+= @$ticketpublisherlists->Affiliation;
								?>
									<tr>             						
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $ticketpublisherlists->publisher != '' ? $ticketpublisherlists->publisher : "-" }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $ticketpublisherlists->Total_Tickets }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $ticketpublisherlists->WithTicket }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $ticketpublisherlists->WithOutTicket }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ @$ticketpublisherlists->item_type }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ @$ticketpublisherlists->Reference }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ @$ticketpublisherlists->Grant }}</td>	
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ @$ticketpublisherlists->Affiliation }}</td>										
									</tr>	
								<?php /*?>@endif	<?php */?>
							@endforeach
						@endif		
					</tbody>
					@if (count($publisherresult))
						@if ($totalticketpublihersum > 0)
							<tr>             						
								<td style='border-top:1px solid black !important;font-weight:bold;' > Total</td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalticketpublihersum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalwithticketpublihersum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalwithoutticketpublihersum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalpubliheritemtypesum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalpubliherreferencesum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $totalpublihergrantsum ?> </td>
								<td style='border-top:1px solid black !important;'> <?php echo $totalpubliheraffiliationsum ?> </td>							
							</tr>	
						@endif	
					@endif		
				</table>	
        </div>
        <!-- /.box-body -->
      </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
           <script type="text/javascript" class="init">		
		   
			function treatAsUTC(date) {
				var result = new Date(date);
				result.setMinutes(result.getMinutes() - result.getTimezoneOffset());
				return result;
			}
			
			function daysBetween(startDate, endDate) {
				var millisecondsPerDay = 24 * 60 * 60 * 1000;
				return (treatAsUTC(endDate) - treatAsUTC(startDate)) / millisecondsPerDay;
			}

		   
		   
		   function validateForm() {
			var fromdate = $('#fromdate').val();
			var todate = $('#todate').val();
			
			var totaldays = daysBetween(fromdate, todate);
			if(totaldays < 32) {
			} else {
				alert('Date range should be less than 32 days!!');
				return false;
			}
		} 
		   
		   
		      
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
					
                	window.location.href ="{{url('reports/withorwithoutTickets_ExportXls')}}"+passparam;
				} else{
					alert('No Record Found.');					
				}		
           }
		   
		   var table = $('#publisherticket').DataTable( {
					scrollY:        "600px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         false,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100]
				} );
		   
			$(document).ready(function() {
				var table = $('#nonticketssummary').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         false,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100],
					fixedColumns:   {
						leftColumns: 2
					}
				} );
			} );
		</script>
       
@endsection

