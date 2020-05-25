<!--  @extends('layouts.app') -->     
    <style type="text/css" class="init">
		ul.topbreadcrumb{text-align:center;color:red;}		
	</style> 
    @section('content')
	<div style='height:500px;'>
	
	</div>
      @include('layouts.footer')

      @include('layouts.scriptfooter')
           <script type="text/javascript" class="init">
			$(document).ready(function() {
				var table = $('#usersreport').DataTable( {
					scrollY:        "300px",
					scrollX:        true,
					scrollCollapse: true,
					paging:         true
				} );
			} );
			
			function export_excel(event,listcount)
			{
				if(listcount > 0){
					event.preventDefault();
					var passparam = '';				
					if($('#duedate').val()!='')
						passparam += 'duedate='+$('#duedate').val();
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
		</script>
       
@endsection

