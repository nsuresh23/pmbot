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
		.dataTables_scrollBody {min-height:90px !important;}
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
       <div id='pageloader' style='width:101%;height:-webkit-fill-available;' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
		<table id="querylist" class="stripe row-border" cellspacing="0" width="100%">
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
									<td class='bgcolor' >{{ $results->job_id }}</td>
									<td class='bgcolor' >{{ $results->orderid }}</td>
									<td class='bgcolor' >{{ $results->duedate != '' ? date('d-M-y', strtotime($results->duedate)) : "" }}</td>
									<td class='bgcolor' >{{ $results->publisher }}</td>
									<td class='bgcolor' >{{ $results->ticket_type }}</td>
									<td class='bgcolor' >{{ $results->ticket_id }}</td>
									<td class='bgcolor' >															
										<a href='#' onclick="showquery('{{ $results->job_id }}','{{ $results->ticket_id }}','{{ $results->ticket_type }}')" >Need To Reply</a>
									</td>
																
								</tr>
								
							@endforeach
						@endif

					</tbody>
				</table>
         

       
        <!-- /.box-body -->
      </div>
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
					paging:         true
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
