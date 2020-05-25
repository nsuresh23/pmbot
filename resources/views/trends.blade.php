<!--  @extends('layouts.app') -->
@section('content')
<script src="{{url('js/jquery-1.12.4.js')}}" type="text/javascript"></script>
<script src="{{url('js/chosen.jquery.js')}}" type="text/javascript"></script>
<style>
	.main-footer{float:left;width:100%;}
	.content-wrapper{float:left;width:100%;}
</style>
<script type="text/javascript">
$(function () {
    $('#precisionchart').highcharts({
        credits: { enabled: false },
		title: { text: 'Logistics' },
		options3d: {
			enabled: true,
			alpha: 10,
			beta: 30,
			depth: 250,
			viewDistance: 5,
			frame: {
				bottom: {
					size: 1,
					color: 'rgba(0,0,0,0.02)'
				},
				back: {
					size: 1,
					color: 'rgba(0,0,0,0.04)'
				},
				side: {
					size: 1,
					color: 'rgba(0,0,0,0.06)'
				}
			}
		},
		plotOptions: {
			spline: {
				width: 10,
				height: 10,
				depth: 10
			},
			column: {
			},
			pie: {
				innerSize: '100',
				depth: 45
			}
		},
        xAxis: {            
			categories: [<?php echo $daterange; ?>],
			labels: {
				items: [{
						html: 'Publisher',
						style: {
							left: '50px',
							top: '18px',
							color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
						}
					}]
			},
        },
		yAxis:  {
             title: {text: ''}, 
			 tickInterval: 200,
        },
		
		series: [
		 <?php echo $pub; ?>
		,{
		type: 'spline',
		name: 'Average',
		color:'#336CA3',
		data: [<?php echo $spline; ?>],
		marker: {
			lineWidth: 2,
			lineColor: Highcharts.getOptions().colors[3],
			fillColor: 'white'
		}
		}, {
		type: 'pie',
		name: 'Total',
		data: [
		
		<?php 
		$piecolor = array('#336CA3','#CC7831','#5FBC4C');
		$coloumncolor = array('#90ed7d','#f7a35c','#8085e9','#f7a35c');
		$cnt=0;
		foreach($totalpublisherval as $publisernam =>$pieval){
			echo '{';
			echo 'name:"'.$publisernam.'",';
			echo 'color:"'.$coloumncolor[$cnt].'",';
			echo 'y:'.$pieval.'';
			
			if(count($totalpublisherval) == $cnt){
			 	echo '}';
			} else {
				echo '},';
			}
			
			$cnt++;
		}?>
		
		
		
			],
		center: [400, 40],
		size: 150,
		showInLegend: false,
		dataLabels: {
			enabled: true
		}
		}]
    });
});
</script>
 <br>
  <div class="box">
  
	<form class="form-horizontal" name="searchform" id="searchform" method="POST" action="">
		{{ csrf_field() }}
		<div class='searchbox'>
			<div class='row form-group'>	
				<div class="col-md-2" >                            
					<label>Date:</label>
					 <select class="form-control" id="fieldname" name="fieldname">
						<option <?php if($fieldname == 'received_date' or $fieldname == '') { ?> selected <?php } ?> value="received_date">Received Date</option>
						<option <?php if($fieldname == 'duedate') { ?> selected <?php } ?> value="duedate">Due Date</option>
						<option <?php if($fieldname == 'dispatchdate') { ?> selected <?php } ?> value="dispatchdate">Dispatch Date</option>
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
				<div class="col-md-2 " style="text-align: center;margin-top:25px;">
					<label>&nbsp;</label>
					<input class="btn btn-primary" type="submit" value="Search">
					<input type='hidden' name='htAction' value='jobssearch' />
					<input type='hidden' name='trends' value='{{$showtrends}}' />
				</div>
			</div>
		</div>
	</form>
	<div style='width:100%;float:left; height:400px' class='trends'>
		<figure id="precisionchart" style="height:400px;"></figure>
	</div>
        <!-- Footer -->
      @include('layouts.footer')
      @include('layouts.scriptfooter')         
    <script>
$('#ajxspinload').css('visibility','visible');
</script>
<script src="{{url('js/highstock.js')}}" type="text/javascript"></script>
@endsection

