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
		.dataTables_scrollBody {height:auto !important;border-left:1px solid}
		.emptyheader{border-bottom:0px !important;border-top:1px solid black;border-left:1px solid black;}
		.refemptyheader{text-align: center !important;padding: 0; border: 1px solid black;background-color:#FFE5CC;}
		.jobemptyheader{text-align: center !important;padding: 0; border: 1px solid black;border-left:0px;}
		.DTFC_LeftBodyLiner{border-left:1px solid black;min-height:90px !important;}
		.subjobheader{border:1px solid black;border-right:0px;border-top:0px;}
		.suborheader{border:1px solid black;border-top:0px;border-right:0px;}
		.dataTables_scroll{border-right:1px solid black;}
		.ref_bg{background-color: #FFE5CC;}
		.left-border{border-left:1px solid black;}
		#usersreport th:nth-child(1),td:nth-child(n+1):nth-child(-n+3) {
			  text-align: center;
        }
		#usersreport th:nth-child(5),td:nth-child(n+5):nth-child(-n+10) {		  
		  text-align: center;
		}
		 #usersreport th:nth-child(8),td:nth-child(n+8):nth-child(-n+16) {		  
		  text-align: center;
		}
		.dataTable th, td {
   			 text-align: center !important;
		}
	</style>

@section('content')
<?php //echo route('editgroup'); ?>
<div class="box">
  <div class="box-header"> @if (session('status'))
    <div class="alert alert-success"> <strong>Success!</strong> {{ session('status') }} </div>
    @endif
    <div class="box-tools"> </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body table-responsive">
    <!--  no-padding -->
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
		  <div class="col-md-2">
            <label>Production:</label	>
            <select class="form-control" id="production" name="production">
              <option value="all" <?php if($production == 'all'){ ?> selected <?php } ?>>All</option>
              <option value="shift" <?php if($production == 'shift'){ ?> selected <?php } ?>>Shift</option>
              <option value="OT" <?php if($production == 'OT'){ ?> selected <?php } ?>>Over Time</option>
            </select>
          </div>
		  <div class="col-md-2" style="display:none" id="divshifttype">
            <label>Production:</label	>
            <select class="form-control" id="shifttype" name="shifttype">
              <option value="firstshift" <?php if($shifttype == 'firstshift'){ ?> selected <?php } ?>>Shift - I</option>
              <option value="secondshift" <?php if($shifttype == 'secondshift'){ ?> selected <?php } ?>>Shift - II</option>
              <option value="thirdshift" <?php if($shifttype == 'thirdshift'){ ?> selected <?php } ?>>Shift - III</option>
            </select>
          </div>
          <div  class="col-md-2">
            <label>From:<span class='db_fieldright'>(Ticket End Time)</label>
            <input type='text' id='fromdate' class='form-control' name='fromdate' value='<?php echo $fdate; ?>'>
          </div>
          <div  class="col-md-2" >
            <label>Date:<span class='db_fieldright'>(Ticket End Time)</label>
            <input class='form-control'  type='text' id='todate' name='todate' value='<?php echo $tdate; ?>'>
          </div>
          <div class="col-md-2" >
            <label>Emp Code:</label>
            <input type='text' id='empcode' class='form-control' name='empcode' value='<?php echo $empcode; ?>'>
          </div>
          <div class="col-md-12 form-group jobsrchbtn" style="text-align: right;float:right;margin-right:0px;padding-top:10px;">
            <label>&nbsp;</label>
            <input type='hidden' name='htAction' value='userssearch' />
			<input type='hidden' name='productiontype' id='productiontype' value='<?php echo $production; ?>' />
			
            <input class="btn btn-primary" type="submit" value="Search">
          </div>
        </div>
      </div>
    </form>
	<?php
		$total_springer_nature 	= '';
		$total_taylor			= '';
		$total_wiley			= '';
		$total_emerald			= '';
		$total_sage				= '';
		$total_sae				= '';
		$total_plos				= '';
		$total_itemtype			= '';
		$total_reference		= '';
		$total_grant			= '';
		$total_affiliation		= '';
		$total_math				= '';
		//$total_validation		= '';
	?>
    <table id="usersreport" class="stripe row-border" cellspacing="0" width="100%">
      <thead>
        <tr>
		  <th></th>
          <th>PG Code</th>
          <th align="center">Springer + Nature QC</th>
          <th align="center">Taylor QC</th>
          <th align="center">Wiley QC</th>
          <th align="center">Emerald QC</th>
          <th align="center">Sage QC</th>
          <th align="center">SAE QC</th>
          <th align="center">PLOS QC</th>
          <th align='center'>Item Type</th>
          <th align='center'>Reference</th>
          <th align='center'>Grant</th>
          <th align='center'>Affiliation</th>
          <th align='center'>Math Expression</th>
          <?php /*?><th align='center'>Validation</th><?php */?>
          <th align='center'>Achieved %</th>
        </tr>
      </thead>
      <tbody>
      <?php $inrcnt = 0; ?>
      @if (count($result))
      @foreach ($result as $k => $results)
		<?php
			$total_springer_nature += $results->Springer_Ticket_Completed_Count + $results->Nature_Ticket_Completed_Count;
			$total_taylor += $results->Taylor_Ticket_Completed_Count;
			$total_wiley += $results->Wiley_Ticket_Completed_Count;
			$total_emerald += $results->Emerald_Ticket_Completed_Count;
			$total_sage += $results->Sage_Ticket_Completed_Count;
			$total_sae += $results->SAE_Ticket_Completed_Count;
			$total_plos += $results->PLOS_Ticket_Completed_Count;
			$total_itemtype += $results->ItemType_Ticket_Completed_Count;
			$total_reference += $results->Reference_Ticket_Completed_Count;
			$total_grant += $results->Grant_Ticket_Completed_Count;
			$total_affiliation += $results->Affiliation_Ticket_Completed_Count;
			$total_math += $results->MathExpression_Ticket_Completed_Count;
			//$total_validation += $results->Validation_Ticket_Completed_Count;
		?>
      <tr>
	  	<td><?php echo $inrcnt+1; ?></td>
	  	<td class='left-border' align="center">{{ $results->user_id }}</td>
        <td class='left-border' align="center">{{ $results->user_id }}</td>
        <td class='left-border' align="center">{{ $results->Springer_Ticket_Completed_Count + $results->Nature_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->Taylor_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->Wiley_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->Emerald_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->Sage_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->SAE_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->PLOS_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->ItemType_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->Reference_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->Grant_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->Affiliation_Ticket_Completed_Count }}</td>
        <td class='left-border' align="center">{{ $results->MathExpression_Ticket_Completed_Count }}</td>
        <?php /*?><td class='left-border' align="center">{{ $results->Validation_Ticket_Completed_Count }}</td><?php */?>
		
        @if (round((($results->Springer_Ticket_Completed_Count + $results->Nature_Ticket_Completed_Count) * $_ENV['SPRINGER_Ticket_Type_Weight']) + (($results->Taylor_Ticket_Completed_Count) * $_ENV['TAYLOR_Ticket_Type_Weight']) + (($results->Wiley_Ticket_Completed_Count) * $_ENV['WILEY_Ticket_Type_Weight']) + (($results->Emerald_Ticket_Completed_Count) * $_ENV['EMERALD_Ticket_Type_Weight']) + (($results->Sage_Ticket_Completed_Count) * $_ENV['SAGE_Ticket_Type_Weight']) + (($results->SAE_Ticket_Completed_Count) * $_ENV['SAE_Ticket_Type_Weight']) + (($results->PLOS_Ticket_Completed_Count) * $_ENV['PLOS_Ticket_Type_Weight']) + (($results->ItemType_Ticket_Completed_Count) * $_ENV['ITEMTYPE_Ticket_Type_Weight']) + (($results->Reference_Ticket_Completed_Count) * $_ENV['REFERENCE_Ticket_Type_Weight']) + (($results->Grant_Ticket_Completed_Count) * $_ENV['GRANT_Ticket_Type_Weight']) + (($results->Affiliation_Ticket_Completed_Count) * $_ENV['AFFI_Ticket_Type_Weight'])) > 100)
      

		<td class='left-border' style="background:#C6EFCE; color:#006600;" align="center">
			
			<?php
				$bsc = (($results->Springer_Ticket_Completed_Count + $results->Nature_Ticket_Completed_Count) * $_ENV['SPRINGER_Ticket_Type_Weight']) + (($results->Taylor_Ticket_Completed_Count) * $_ENV['TAYLOR_Ticket_Type_Weight']) + (($results->Wiley_Ticket_Completed_Count) * $_ENV['WILEY_Ticket_Type_Weight']) + (($results->Emerald_Ticket_Completed_Count) * $_ENV['EMERALD_Ticket_Type_Weight']) + (($results->Sage_Ticket_Completed_Count) * $_ENV['SAGE_Ticket_Type_Weight']) + (($results->SAE_Ticket_Completed_Count) * $_ENV['SAE_Ticket_Type_Weight']) + (($results->PLOS_Ticket_Completed_Count) * $_ENV['PLOS_Ticket_Type_Weight']) + (($results->ItemType_Ticket_Completed_Count) * $_ENV['ITEMTYPE_Ticket_Type_Weight']) + (($results->Reference_Ticket_Completed_Count) * $_ENV['REFERENCE_Ticket_Type_Weight']) + (($results->Grant_Ticket_Completed_Count) * $_ENV['GRANT_Ticket_Type_Weight']) + (($results->Affiliation_Ticket_Completed_Count) * $_ENV['AFFI_Ticket_Type_Weight']);
				if($numberDays > 0){
					 echo round($bsc/$numberDays);
				} else {
					 echo round($bsc);
				}	
			?>
			
		</td>
        
		@elseif (round((($results->Springer_Ticket_Completed_Count + $results->Nature_Ticket_Completed_Count) * $_ENV['SPRINGER_Ticket_Type_Weight']) + (($results->Taylor_Ticket_Completed_Count) * $_ENV['TAYLOR_Ticket_Type_Weight']) + (($results->Wiley_Ticket_Completed_Count) * $_ENV['WILEY_Ticket_Type_Weight']) + (($results->Emerald_Ticket_Completed_Count) * $_ENV['EMERALD_Ticket_Type_Weight']) + (($results->Sage_Ticket_Completed_Count) * $_ENV['SAGE_Ticket_Type_Weight']) + (($results->SAE_Ticket_Completed_Count) * $_ENV['SAE_Ticket_Type_Weight']) + (($results->PLOS_Ticket_Completed_Count) * $_ENV['PLOS_Ticket_Type_Weight']) + (($results->ItemType_Ticket_Completed_Count) * $_ENV['ITEMTYPE_Ticket_Type_Weight']) + (($results->Reference_Ticket_Completed_Count) * $_ENV['REFERENCE_Ticket_Type_Weight']) + (($results->Grant_Ticket_Completed_Count) * $_ENV['GRANT_Ticket_Type_Weight']) + (($results->Affiliation_Ticket_Completed_Count) * $_ENV['AFFI_Ticket_Type_Weight'])) == 100)
        
		
		<td class='left-border' style="background:#FFEB9C; color:#FF9003;" align="center">
		
		
			<?php
				$bsc = (($results->Springer_Ticket_Completed_Count + $results->Nature_Ticket_Completed_Count) * $_ENV['SPRINGER_Ticket_Type_Weight']) + (($results->Taylor_Ticket_Completed_Count) * $_ENV['TAYLOR_Ticket_Type_Weight']) + (($results->Wiley_Ticket_Completed_Count) * $_ENV['WILEY_Ticket_Type_Weight']) + (($results->Emerald_Ticket_Completed_Count) * $_ENV['EMERALD_Ticket_Type_Weight']) + (($results->Sage_Ticket_Completed_Count) * $_ENV['SAGE_Ticket_Type_Weight']) + (($results->SAE_Ticket_Completed_Count) * $_ENV['SAE_Ticket_Type_Weight']) + (($results->PLOS_Ticket_Completed_Count) * $_ENV['PLOS_Ticket_Type_Weight']) + (($results->ItemType_Ticket_Completed_Count) * $_ENV['ITEMTYPE_Ticket_Type_Weight']) + (($results->Reference_Ticket_Completed_Count) * $_ENV['REFERENCE_Ticket_Type_Weight']) + (($results->Grant_Ticket_Completed_Count) * $_ENV['GRANT_Ticket_Type_Weight']) + (($results->Affiliation_Ticket_Completed_Count) * $_ENV['AFFI_Ticket_Type_Weight']);
				if($numberDays > 0){
					 echo round($bsc/$numberDays);
				} else {
					 echo round($bsc);
				}
			?>
			
			
		</td>
        @else
        <td class='left-border' style="background:#FFC7CE; color:#FF0000;" align="center">
				<?php
						$bsc = (($results->Springer_Ticket_Completed_Count + $results->Nature_Ticket_Completed_Count) * $_ENV['SPRINGER_Ticket_Type_Weight']) + (($results->Taylor_Ticket_Completed_Count) * $_ENV['TAYLOR_Ticket_Type_Weight']) + (($results->Wiley_Ticket_Completed_Count) * $_ENV['WILEY_Ticket_Type_Weight']) + (($results->Emerald_Ticket_Completed_Count) * $_ENV['EMERALD_Ticket_Type_Weight']) + (($results->Sage_Ticket_Completed_Count) * $_ENV['SAGE_Ticket_Type_Weight']) + (($results->SAE_Ticket_Completed_Count) * $_ENV['SAE_Ticket_Type_Weight']) + (($results->PLOS_Ticket_Completed_Count) * $_ENV['PLOS_Ticket_Type_Weight']) + (($results->ItemType_Ticket_Completed_Count) * $_ENV['ITEMTYPE_Ticket_Type_Weight']) + (($results->Reference_Ticket_Completed_Count) * $_ENV['REFERENCE_Ticket_Type_Weight']) + (($results->Grant_Ticket_Completed_Count) * $_ENV['GRANT_Ticket_Type_Weight']) + (($results->Affiliation_Ticket_Completed_Count) * $_ENV['AFFI_Ticket_Type_Weight']);
						
						if($numberDays > 0){
							 echo round($bsc/$numberDays);
						} else {
							 echo round($bsc);
						}	  
				?>
			</td>
        @endif 
		
		<?php $inrcnt++; ?>
		</tr>
      @endforeach
      @endif
	  
	  <?php if(count($result)>0) { ?>
      <tr>
        <td class='left-border' style="background:#006699 color:#FFFFFF;" align="center"><strong>Total</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_springer_nature }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_taylor }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_wiley }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_emerald }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_sage }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_sae }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_plos }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_itemtype }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_reference }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_grant }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_affiliation }}</strong></td>
        <td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_math }}</strong></td>
        <?php /*?><td class='left-border' style="background:#006699; color:#FFFFFF;" align="center"><strong>{{ $total_validation }}</strong></td><?php */?>
        <td class='left-border' style="background:#FFFFFF; color:#FFFFFF;"></td>
      </tr>
	  <?php } else { ?>
	  <tr><td colspan="15" style="background:#006699 color:#FFFFFF;"> No Record Found!!</td></tr>
	  <?php } ?>
	  
      </tbody>
      
    </table>
  </div>
  <!-- /.box-body -->
</div>
<!-- Footer -->
@include('layouts.footer')
@include('layouts.scriptfooter')
	  
<script type="text/javascript">
$(document).ready(function(){
	$("#production").change(function(){
		var selectedcolor = $('#production option:selected').text();	
		if(selectedcolor == 'Shift'){
			$('#divshifttype').show();
		} else {
			$('#divshifttype').hide();
		}
	});
});
var productiontype = document.getElementById("productiontype").value;		

if(productiontype == 'shift'){
	$('#divshifttype').show();
} else {
	$('#divshifttype').hide();
}
</script>
  
	  
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script type="text/javascript" class="init">





		$(document).ready(function() {
			var table = $('#usersreport').DataTable( {
				scrollY:        "1500px",
				scrollX:        true,
				scrollCollapse: true,
				paging:         true,
				lengthMenu:     [ [-1,10, 25, 50,100], ["All",10, 25, 50, 100, ] ],
				pageLength:     [100],
				dom: 'Bfrtip',
				buttons: ['csv', 'excel']
			} );
			
			
			//callshiftfunction
			
			
			
			
			
		} );
		</script>
@endsection