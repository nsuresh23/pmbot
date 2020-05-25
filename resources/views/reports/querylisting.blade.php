
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
		<div id='pageloader' style='width:101%;height:-webkit-fill-available;' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
		<form class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
            {{ csrf_field() }}
            <div class='searchbox'>
				<div class='row form-group'>
				<div class="col-md-2 norightpadding">
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
					<div class="col-md-2 " style="text-align: center;margin-top:25px;"><!-- margin-top:25px;style="text-align: center;"form-group -->
						<label>&nbsp;</label>
						<input class="btn btn-primary" type="submit" value="Search">
						<input type='hidden' name='htAction' value='jobssearch' />
	                </div>
				</div>
			</div>
		</form>
			<table id="querylist" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Job Id</th> 
							<th>Order Id</th> 
							<th>Due Date</th> 							
							<th>Publisher</th>
							<th>Ticket Type</th> 
							<th>Ticket Id</th> 
							<th>Action</th> 
						</tr>
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)
								<tr>             						
									<td><a href="{{url('reports/jobs_report/detailed_reports')}}/job_id-{{$results->job_id}}">{{ $results->job_id }}</a></td>
									<td><a href="{{url('reports/jobs_report/detailed_reports')}}/orderid-{{$results->orderid}}">{{ $results->orderid }}</a></td>									
									<td >{{ $results->duedate != '' ? date('d-M-y', strtotime($results->duedate)) : "" }}</td>
									<td >{{ $results->publisher }}</td>
									<td>{{ $results->ticket_type }}</td>
									<td>{{ $results->ticket_id }}</td>
									<td>															
										<a href='#' onclick="showquery('{{ $results->job_id }}','{{ $results->ticket_id }}','{{ $results->ticket_type }}')" >Need To Reply</a>
									</td>
																
								</tr>

							@endforeach
						
						@endif
					</tbody>
				</table>
		
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
           <script type="text/javascript" class="init">
		   
		   
			$(document).ready(function() {
				document.getElementById("pageloader").style.display = "none";
				var table = $('#querylist').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100]
					
				} );
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

