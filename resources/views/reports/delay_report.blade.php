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
		.dataTables_scrollBody {min-height:100px !important;}		
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
			<div style="text-align: right;margin-bottom:5px;">						
					<input class="btn btn-primary" type="button"  onclick="showupdatecomment('{{$resultcount}}')" value="Update Order Comments">						
				</div>
			<div class='searchbox' style='float:left;width:100%;'>
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
						<label>Publisher:</label>						
		                 <select  class="form-control" id="publisher" name="publisher">
							<option value="all" <?php if($publisher == 'all'){ ?> selected <?php } ?>>All</option>
							@foreach($publisherlist as $publishers)
								@if ($publishers->publisher != '')									
									<option value='{{$publishers->publisher}}' <?php if($publisher == $publishers->publisher){ ?> selected <?php } ?>> {{$publishers->publisher}}</option>								
								@endif																
							 @endforeach
						 </select>
	                </div>
					<div class="col-md-2" >                            
						<label>Date Type:</label>
						 <select class="form-control" id="fieldname" name="fieldname">
							<option <?php if($fieldname == 'received_date' or $fieldname == '') { ?> selected <?php } ?> value="received_date">Received Date</option>
							<option <?php if($fieldname == 'duedate') { ?> selected <?php } ?> value="duedate">Due Date</option>
							<option <?php if($fieldname == 'dispatchdate') { ?> selected <?php } ?> value="dispatchdate">Dispatch Date</option>
						</select>
                    </div>	
					
					<div  class="col-md-2">                            
						 <label>From:</label>
						 <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fdate; ?>'> 
                    </div>
					<div  class="col-md-2" >                            
						<label>To:</label> <input class='form-control'  type='text' id='todate' name='todate' value='<?php echo $tdate; ?>'>
                    </div>					
					<div class="col-md-2 form-group jobsrchbtn" style="text-align: center;margin-top:25px !important;">
						<label>&nbsp;</label>	
						<input type='hidden' name='htAction' value='userssearch' />
						<input class="btn btn-primary" type="submit" value="Search">
						<a class="" href="javascript:void(0);" onclick="export_excel(event,{{$resultcount}});"><img src="{{url('img/excelexport.png')}}" width="35" height="35"></a>
						
				</div>
				
				
			</div>
		</div>	
		</form>		
			<form class="form-horizontal" name="delayform" id="delayform" method="POST" action="">
            {{ csrf_field() }}
			<input type="checkbox" id="selectAll" value="selectAll"> <label for='selectAll'>Select / Deselect All</label><br/>

			<table id="usersreport" class="stripe row-border order-column" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th></th>							
							<th>Order Id</th>
							<th>Order Type</th>
							<th>Flow</th>
							<th>Due Date</th>
							<th>Dispatch Date</th>							
							<th>Time</th>
							<th>Article</th>							
							<th>Signal Type</th>
							<th>Status</th>						
							<th>Remarks</th>							
							<th>Additional remarks</th>							
						</tr>
					</thead>
					<tbody>
						@if (count($result))
							@foreach ($result as $k => $results)
								<tr>             						
									<td @if ($k % 2 == 0) class='bgcolor' @endif><input style='margin:0px;' onclick="checkstatus('{{$results->delaydetail_remarks}}','orderidname_{{$k}}','{{$results->orderid}}');" type='checkbox' name='orderidname' id='orderidname_{{$k}}' value='{{$results->orderid}}'  /> </td>									
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->orderid}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->ordertype}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>XML</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->duedate != '' ? date('d-M-y', strtotime($results->duedate)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{ $results->dispatchdate != '' ? date('d-M-y', strtotime($results->dispatchdate)) : "" }}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>-</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->signaltype}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->status}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->delay_remarks}}</td>
									<td @if ($k % 2 == 0) class='bgcolor' @endif>{{$results->delaydetail_remarks}}</td>
								</tr>
							@endforeach						
						@endif
					</tbody>
				</table>
         </form>

        </div>
        <!-- /.box-body -->
      </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
           <script type="text/javascript" class="init">
			$(document).ready(function() {
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
					if($('#publisher').val()!='')
						passparam += '&publisher='+$('#publisher').val();
					if($('#fieldname').val()!='')
						passparam += '&fieldname='+$('#fieldname').val();
					if($('#project').val()!='')
						passparam += '&project='+$('#project').val();
					if(passparam!='') 
						passparam = '?'+passparam;				
					window.location.href ="{{url('reports/delayreport_exportxls')}}"+passparam;
				} else{
					alert('No Record Found.');
					
				}
				
			}
			$(document).ready(function () {
				var today = new Date();
				$('#duedate').datepicker({
					format: 'yyyy-mm-dd',
					autoclose:true,
					endDate: "yesterday",
					maxDate: today
				}).on('changeDate', function (ev) {
						$(this).datepicker('hide');
					});
				$('#duedate').keyup(function () {
					if (this.value.match(/[^0-9]/g)) {
						this.value = this.value.replace(/[^0-9^-]/g, '');
					}
				});
			});
			function checkstatus(cnt,id,orderid){
				var lfckv = document.getElementById(id).checked;
				if(cnt != '') {
					if(lfckv == true){
						if(confirm("Do you want to updatet the remarks for this order: "+orderid)){
							return false;
						}
						else{
							document.getElementById(id).checked = false;						
						}
					}
					
				} 
			}
			
			function showupdatecomment(listcount)
			{
				if(listcount > 0){
					var duedate = $('#duedate').val();
					var publisher =  $('#publisher').val();

					$.ajax({
					type: 'GET',
					url: "{{url('reports/delayreport_popup')}}",            				
					data: 'ajaxload=1',						
					success: function(data){               
						bootbox.alert(data);
					},
				  });
				} else{
					alert('No Record Found.');
					
				}
			}
			$('#selectAll').click(function() {
			   if (this.checked) {
				   $(':checkbox').each(function() {
					   this.checked = true;                        
				   });
			   } else {
				  $(':checkbox').each(function() {
					   this.checked = false;                        
				   });
			   } 
			});
		</script>
       
@endsection

