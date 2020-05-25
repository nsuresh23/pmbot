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
		#publisherstock_wrapper .dataTables_scrollBody{height:auto !important;}
		#stockreport_wrapper .dataTables_scrollBody{height:auto !important;}
	
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
						 <label>From:<span class='db_fieldright'>(Received Date)</span></label>
						 <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fdate; ?>'> 
                    </div>
					<div  class="col-md-2" >                            
						<label>To:<span class='db_fieldright'>(Received Date)</span></label> <input class='form-control' type='text' id='todate' name='todate' value='<?php echo $tdate; ?>'>
                    </div>				
					<div class="col-md-1 form-group jobsrchbtn" style="text-align: center;">
						<label>&nbsp;</label>	
						<input type='hidden' name='htAction' value='userssearch' />
						<input class="btn btn-primary" type="submit" value="Search">
				</div>
				<!--<div class="col-md-1 box-tools" style="text-align: center;margin-top:15px;padding-left: 0px;">
					<a class="" href="javascript:void(0);" onclick="export_excel(event,{{$resultcount}});"><img src="{{url('img/excelexport.png')}}" width="50" height="50"></a>
				</div>-->
			</div>
		</div>	
		</form>		

			<table id="stockreport" class="stripe row-border order-column" cellspacing="0" width="100%">

					</thead>
					<thead>	
						<tr>                						
							<th style='text-align:center;font-weight:bold;color:#3c8dbc;font-size:15px !important;' colspan='8'>Stock Per Date</th>																		
						</tr>						
						<tr>                						
							<th>Recd Date</th>
							<th>Orders In Hand</th>
							<th>Articles In Hand</th>
							<th>Articles In Last Day TAT</th>
							<th>Articles Out Off TAT</th>
							<th>Pending Within Due Date</th>
							<th>Orders In Query</th>
							<th>Articles In Query</th>							
						</tr>															
					</thead>
					
					<tbody>
						<?php $ordersum = 0;$articlesum = 0;$tatsum = 0;$outoftatsum = 0;$pendingtatsum = 0;$orderquerysum = 0;$articlequerysum = 0; ?>
						@if (count($stockperdatelist))
							@foreach ($stockperdatelist as $k => $stockperdatelists)
								@if ($stockperdatelists->orders_in_hand > 0)
									<?php 									
										$ordersum += $stockperdatelists->orders_in_hand;
										$articlesum += $stockperdatelists->Article_in_hand;
										$tatsum += $stockperdatelists->Article_in_LastDate;
										$outoftatsum += $stockperdatelists->Article_in_OutDate;
										$pendingtatsum += $stockperdatelists->Pending_in_OutDate;
										$orderquerysum += $stockperdatelists->Orders_in_query;		
										$articlequerysum += $stockperdatelists->Articles_in_query;											
									?>
									<tr>             						
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $stockperdatelists->Rece_Date }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockperdatelists->Rece_Date}}','orders_in_hand','per_date')">{{ $stockperdatelists->orders_in_hand }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockperdatelists->Rece_Date}}','Article_in_hand','per_date')">{{ $stockperdatelists->Article_in_hand }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockperdatelists->Rece_Date}}','Article_in_LastDate','per_date')">{{ $stockperdatelists->Article_in_LastDate }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockperdatelists->Rece_Date}}','Article_in_OutDate','per_date')">{{ $stockperdatelists->Article_in_OutDate }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockperdatelists->Rece_Date}}','Pending_in_OutDate','per_date')">{{ $stockperdatelists->Pending_in_OutDate }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockperdatelists->Rece_Date}}','Orders_in_query','per_date')">{{ $stockperdatelists->Orders_in_query }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockperdatelists->Rece_Date}}','Articles_in_query','per_date')">{{$stockperdatelists->Articles_in_query }}</a></td>									
									</tr>	
								@endif
							@endforeach

						@endif						
		
					</tbody>
					@if (count($stockperdatelist))
						@if ($ordersum > 0)
							<tr>             						
								<td style='border-top:1px solid black !important;font-weight:bold;' > Total</td>	
								<td style='border-top:1px solid black !important;'> <?php echo $ordersum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $articlesum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $tatsum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $outoftatsum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $pendingtatsum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $orderquerysum ?> </td>
								<td style='border-top:1px solid black !important;'> <?php echo $articlequerysum ?> </td>							
							</tr>	
						@endif	
					@endif		
				</table>
				
				
		<table id="publisherstock" class="stripe row-border order-column" cellspacing="0" width="100%">

					</thead>
					<thead>	
						<tr>                						
							<th style='text-align:center;font-weight:bold;color:#3c8dbc;font-size:15px !important;' colspan='8'>Stock Per Publisher</th>																		
						</tr>						
						<tr>                						
							<th>Publisher</th>
							<th>Orders In Hand</th>
							<th>Articles In Hand</th>
							<th>Articles In Last Day TAT</th>
							<th>Articles Out Off TAT</th>
							<th>Pending Within Due Date</th>
							<th>Orders In Query</th>
							<th>Articles In Query</th>																	
						</tr>															
					</thead>
					
					<tbody>
					<?php $pordersum = 0;$particlesum = 0;$ptatsum = 0;$poutoftatsum = 0;$ppendingtatsum = 0;$porderquerysum = 0;$particlequerysum = 0; ?>
						@if (count($stockpublisherlist))
							@foreach ($stockpublisherlist as $k => $stockpublisherlists)
							@if ($stockpublisherlists->orders_in_hand > 0)
								<?php 									
										$pordersum += $stockpublisherlists->orders_in_hand;
										$particlesum += $stockpublisherlists->Article_in_hand;
										$ptatsum += $stockpublisherlists->Article_in_LastDate;
										$poutoftatsum += $stockpublisherlists->Article_in_OutDate;
										$ppendingtatsum += $stockpublisherlists->Pending_in_OutDate;
										$porderquerysum += $stockpublisherlists->Orders_in_query;
										$particlequerysum += $stockpublisherlists->Articles_in_query;
										
									?>
									<tr>             						
										<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $stockpublisherlists->publisher != '' ? $stockpublisherlists->publisher : "-" }}</td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockpublisherlists->publisher}}','orders_in_hand','per_publisher')">{{ $stockpublisherlists->orders_in_hand }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockpublisherlists->publisher}}','Article_in_hand','per_publisher')">{{ $stockpublisherlists->Article_in_hand }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockpublisherlists->publisher}}','Article_in_LastDate','per_publisher')">{{ $stockpublisherlists->Article_in_LastDate }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockpublisherlists->publisher}}','Article_in_OutDate','per_publisher')">{{ $stockpublisherlists->Article_in_OutDate }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockpublisherlists->publisher}}','Pending_in_OutDate','per_publisher')">{{ $stockpublisherlists->Pending_in_OutDate }}</a></td>
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockpublisherlists->publisher}}','Orders_in_query','per_publisher')">{{ $stockpublisherlists->Orders_in_query }}</a></td>	
										<td @if ($k % 2 == 0) class='bgcolor' @endif><a href='#' onclick="showstockreport('{{$stockpublisherlists->publisher}}','Articles_in_query','per_publisher')">{{ $stockpublisherlists->Articles_in_query }}</a></td>										
									</tr>	
								@endif	
							@endforeach

						@endif		
					</tbody>
					@if (count($stockpublisherlist))
						@if ($pordersum > 0)
							<tr>             						
								<td style='border-top:1px solid black !important;font-weight:bold;' > Total</td>	
								<td style='border-top:1px solid black !important;'> <?php echo $pordersum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $particlesum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $ptatsum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $poutoftatsum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $ppendingtatsum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $porderquerysum ?> </td>	
								<td style='border-top:1px solid black !important;'> <?php echo $particlequerysum ?> </td>									
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
			$(document).ready(function() {
				var table = $('#stockreport').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100]
				} );
			} );
			var table = $('#publisherstock').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100]
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
					if(passparam!='') 
						passparam = '?'+passparam;				
					window.location.href ="{{url('reports/stockreport_exportxls')}}"+passparam;
				} else {
					alert('No Record Found.');
					
				}				
			}
			function showstockreport(arg,type,searchtype){
				document.getElementById("imgloader").style.display = "block";
				var fromdate = $('#fromdate').val();
				var todate = $('#todate').val();				
				$.ajax({
					type: 'GET',
					url: "{{url('reports/stock_popupreport')}}",
					data: 'ajaxload=1&type='+type+'&searchtype='+searchtype+'&arg='+arg+'&fromdate='+fromdate+'&todate='+todate,
					success: function(data){
						bootbox.alert(data);				
					},
				  });
			}
		</script>
       
@endsection