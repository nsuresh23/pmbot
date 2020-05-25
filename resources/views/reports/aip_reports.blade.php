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
		.dataTables_scrollBody {min-height:65px !important;}
		.dataTables_empty{text-align:left !important;}
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
												
					<div  class="col-md-2">                            
						 <label>From:</label>
						 <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fdate; ?>'> 
                    </div>
					<div  class="col-md-2" >                            
						<label>To:</label> <input class='form-control'  type='text' id='todate' name='todate' value='<?php echo $tdate; ?>'>
                    </div>

					<div class="col-md-2 form-group jobsrchbtn searchbtn" style="float:left;margin-top:25px !important;">
						<label>&nbsp;</label>	
						<input type='hidden' name='htAction' value='userssearch' />
						<input class="btn btn-primary" type="submit" value="Search">
						<a class="" href="javascript:void(0);" onclick="export_excel(event,{{$resultcount}});"><img src="{{url('img/excelexport.png')}}" width="35" height="35"></a>
					</div>
				
			</div>
		</div>	
		</form>		
			<div id='pageloader' style='width:101%;height:-webkit-fill-available;' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>
			<table id="usersreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>							
							
							<th>Rec Date</th>
							<th>Order Id</th>
							<th>Order Type</th>
							<th>Supplier Unit Id</th>
							<th>Source-Id</th>	
							<th>Source-Title</th>								
							<th>DOI</th>
						</tr>
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)
								<tr>   
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->received_date}}</td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->orderid}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->ordertype}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->suplunitid}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->srcid}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->srctitle}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->doi}}</td>
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
				document.getElementById("pageloader").style.display = "none";
				var table = $('#usersreport').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
					pageLength:     [100]
				} );
				
				

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
					window.location.href ="{{url('reports/aipjobs_exportxls')}}"+passparam;
				} else{
					alert('No Record Found.');					
				}
				
			}
		</script>
       
@endsection

