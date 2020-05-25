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
		.emptyheader{border-bottom:0px !important;border-top:1px solid black;}
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

		<table id="jobsreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>						
						<tr>
							<th>Job Id</th>
							<th>Order Id</th>		 																			 
							<th>Publisher</th>  
							<th>Due Date</th>	
							<th>Rec Date</th>								
							<th>Source ID</th> 
							<th>Source Title</th>		
							<th>Order Remark</th>	
							<th>Remarks</th>	
							<th>Error Info</th>
							<th>Source File & Location</th>
						</tr>	
																					
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)
								<tr>             						
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->duedate }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->received_date }}</td>										
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srcid }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srctitle }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->order_remark }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->remarks }}</td>	
									<td @if ($k % 2 == 0) class='bgcolor' @endif>
									<?php
										echo wordwrap($results->error_info,100,"<br>\n");
									?>
									</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>
										Name&nbsp;&nbsp;: {{ $results->filename }}<br />
										Path&nbsp;&nbsp;&nbsp;&nbsp; : {{ $results->filepath }}
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

			$(document).ready(function() {
				var table = $('#jobsreport').DataTable( {
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
			function showjobview(jobid)
			{				
				$.ajax({
						type: 'GET',
						url: "{{url('reports/update_holdjobdetails')}}",
						data: 'ajaxload=1&jobid='+jobid,
						success: function(data){
							bootbox.alert(data);
						},
					  });									
			}
		</script>
       
@endsection

