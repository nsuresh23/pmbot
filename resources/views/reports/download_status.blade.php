<!--  @extends('layouts.app') -->     
    <style type="text/css" class="init">
		th, td { white-space: nowrap; }
		div.dataTables_wrapper {
			width: 50%;
			margin: 0 auto;
		}
		.dataTables_wrapper{		
			overflow: inherit !important;
		}
		.example_wrapper{		
			overflow: inherit !important;
		}
		
		#downloadstatus_wrapper .dataTables_scrollBody {height:auto !important;    overflow: hidden !important;}
		#downloadstatus_wrapper .dataTables_scroll{border:1px solid black;border-bottom:0px;}
		.dataTables_empty{text-align:center !important;line-height:80px;}
		.totalcnt{border-top:1px solid black !important;font-weight:bold;}
		#downloadstatus_wrapper{float:left;width:625px;}
		#downloadstatus_filter{display:none;}
		
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
						 <label>From:<span class='db_fieldright'>(Received Date)</span> </label>
						 <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fdate; ?>'> 
                    </div>
					<div  class="col-md-2" >                            
						<label>To:<span class='db_fieldright'>(Received Date)</span> </label> <input class='form-control'  type='text' id='todate' name='todate' value='<?php echo $tdate; ?>'>
                    </div>
					
					<div class="col-md-2 form-group jobsrchbtn" style="text-align: center;margin-top:25px !important;">
						<label>&nbsp;</label>	
						<input type='hidden' name='htAction' value='userssearch' />
						<input class="btn btn-primary" type="submit" value="Search">
						<a class="" href="javascript:void(0);" onclick="export_excel(event,{{$resultcount}});"><img src="{{url('img/excelexport.png')}}" width="35" height="35"></a>
					</div>
				
			</div>
		</div>	
		<input type='hidden' id='rescount' value='{{$resultcount}}' />
		</form>		
			<div id='pageloader' style='width:101%;height:-webkit-fill-available;' class='loadingimg'><img src="{{url('img/loader.gif')}}" id="headlogo" class='logoimg' /></div>

			<table id="downloadstatus" class="stripe row-border order-column " cellspacing="0" width="100%">
					<thead>
						<tr>							
							<th>Publisher</th>
							<th>No of Orders</th>
							<th>No of Articles</th>							
						</tr>
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)
								<tr>             																								
									<td class='bgcolor'>{{$results->publisher}}</td>
									<td class='bgcolor ordercnt' onclick="downloadstatusreport('{{$results->publisher}}','orderid')">{{$results->Order_Count}}</td>
									<td class='bgcolor articlecnt' onclick="downloadstatusreport('{{$results->publisher}}','job_id')">{{$results->Article_Count}}</td>
								</tr>
							@endforeach
						
						@endif
					</tbody>
					@if (count($result))
					<tbody>
						<tr>             																								
							<td class='bgcolor totalcnt'>Total</td>
							<td id='totalorder' class='bgcolor totalcnt' onclick="downloadstatusreport('all','orderid')"></td>
							<td id='totalarticle' class='bgcolor totalcnt' onclick="downloadstatusreport('all','job_id')"></td>
						</tr>
					</tbody>
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
				document.getElementById("pageloader").style.display = "none";
				var table = $('#downloadstatus').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         false,
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
					if($('#project').val()!='')
						passparam += '&project='+$('#project').val();
					if(passparam!='') 
						passparam = '?'+passparam;				
					window.location.href ="{{url('reports/downloadstatus_exportxls')}}"+passparam;
				} else{
					alert('No Record Found.');					
				}
				
			}
			var rescnt = document.getElementById('rescount').value;			
			if(rescnt > 0){
				var j_ds = document.getElementById('downloadstatus').getElementsByTagName('td');
				columntotalcount(j_ds,'bgcolor ordercnt','totalorder');
				columntotalcount(j_ds,'bgcolor articlecnt','totalarticle');
			}
			function columntotalcount(id,classname,result){
				var sum = 0;
				for(var i = 0; i < id.length; i ++) {		
					if(id[i].className == classname) {					
						sum += isNaN(id[i].innerHTML) ? 0 : parseInt(id[i].innerHTML);
					}
				}	
				document.getElementById(result).innerHTML =  sum ;				
			}
			function downloadstatusreport(publisher,type)
			{
				var frmdate = document.getElementById("fromdate").value;		
				var to_date = document.getElementById("todate").value;

				$.ajax({
				type: 'GET',
				url: "{{url('reports/downloadstatus_popupreport')}}",            
				data: 'ajaxload=1&fromdate='+frmdate+'&todate='+to_date+'&publisher='+publisher+'&type='+type,			
				success: function(data){               
					bootbox.alert(data)
				},
			  });
			}
			
		</script>
       
@endsection

