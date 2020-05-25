<style>
	div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;		
    }
	.dataTables_wrapper {
		overflow: inherit;
	}
	.modal {
		background: rgba(0, 0, 0, 0.59);
	}
	.modal-footer {
		display:none !important;
	}
	.modal-body{height:470px;}
	.dataTables_scrollBody{ height:300px !important;}
	#example{color:black;opacity:0;}
</style>
<div id='popuploader' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
<table id="example" class="display nowrap example" cellspacing="0" width="100%">
        <thead>
            <tr>				
				<th style='background-color:#fff;'>Order Id</th>  
				@if ($type == 'job_id')
				<th>Job Id</th> 
				@endif
				<th >Source Id</th>  
				<th>Title</th>  
				<th>Publisher</th>
				<th>Volume</th>  
				<th>Issue</th>		
				@if ($type == 'orderid')
				<th>Articles</th> 
				@endif				
				<th>Downloadtype</th>
			</tr>
        </thead>
        <tbody>
            @if (count($result))
						@foreach ($result as $k => $results)
							<tr>             						
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->orderid }}</td>
								@if ($type == 'job_id')
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->job_id }}</td>	
								@endif
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srcid }}</td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->srctitle }}</td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->publisher }}</td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->Vol }}</td>
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->ISS }}</td>	
								@if ($type == 'orderid')
								<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->Articles }}</td>	
								@endif
								
								
								<td @if ($k % 2 == 0) class='bgcolor' @endif>Downloaded</td>	
							</tr>
						  @endforeach
						@endif
           
        </tbody>
    </table>
	<script>
		setTimeout(function() {
			$(document).ready(function() {
				document.getElementById("imgloader").style.display = "none";
				document.getElementById("popuploader").style.display = "none";
				document.getElementById("example").style.opacity = "1";
				$('.example').DataTable( {
					"scrollY": 200,
					"scrollX": true,
					"paging":  false,
					fixedColumns:   {
							leftColumns: 2
					}					
				} );
			} )
        			
		}, 200);
		
	</script>