<?php
            $useremail   = '';
            $user_name   = '';
            $user_attr   = array();
            $but_lbl     = 'Add';
            $sub_url     = 'user/overridedate/'.$grp_id;
            if(!empty($vol_id))
              $sub_url     = 'user/editdateranges/'.$vol_id;
            
       ?>
    <!--  @extends('layouts.app') -->
    @section('content')
      <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{$but_lbl}} Date Ranges</h3>
        </div>
          @if (session('status'))
              <div class="alert alert-success">
                 <strong>Success!</strong> {{ session('status') }}
              </div>
          @endif 
           @if (count($submit_disable)>0)
              <div class="alert alert-danger" style="text-align:center; ">
                 <strong>Sorry!</strong> Not allowed to override tickets volumes between 11.30 P.M to 12.00 A.M
              </div>
          @endif 
        <div class="box-body">
          <div class="row"> 
            {{ Form::open(array('url' => $sub_url, 'method' => 'post','class'=>'')) }}
                <input type="Hidden" name="group_name" value="{{$grp_id}}">
                <div class="col-md-6 form-group">
                   {{Form::label('tickettype', 'Ticket Type:', array('for' => 'tickettype','class'=>'frmlabel'))}}
                   {!! $errors->first('ticket_reference', '<p class="text-danger" style="text-align: center;">:message</p>') !!}
                  <div class="ticket_type">
                      <?php 
                            foreach($tickettypelist as $tkey=>$tvalue)
                            { ?>
                              <div class="col-md-6 mb-3">
                                <?php 
                                  $lbl_name = formatstring($tvalue);
                                  $place_holder ='Enter Alloted Volume';
                                   $tkt_val = '';
                                  $default_value = (!empty($ticket_volumes[$lbl_name])) ? $ticket_volumes[$lbl_name]:'';
                                  if(isset($ticket_volumes['group_name'])&& $default_value>0)
                                  {
                                     $place_holder = $default_value.' (Default Alloted Volume)';
                                  }
                                  else
                                     $tkt_val  = $default_value;
                                   
                                 echo Form::label('lbl'.$lbl_name, $tvalue);
                                 echo Form::number('ticket_'.$lbl_name, $value = $tkt_val, $attributes = array('placeholder'=>$place_holder,'class'=>'form-control'));
                                ?>
                              </div>
                        <?php
                            }
                          ?>
                      </div>
              </div>
                <div class="addranges col-md-6 form-group">
                <?php 
                	 
                      $retainfrom_arr = array();
                      $retainto_arr = array();
                      if(!empty($_POST['from_date'])&& count($_POST['from_date'])>0)
                      {
                          $retainfrom_arr['from_date'] = $_POST['from_date'];
                          $retainfrom_arr['to_date'] = $_POST['to_date'];
                      }
                      elseif(!empty($ticket_volumes['volume_dates'])&& count($ticket_volumes['volume_dates'])>0)
                      {
                         foreach($ticket_volumes['volume_dates'] as $volkey=>$volvalue)
                         {
                         	//if($volvalue['to_date']>=date('Y-m-d'))
                         	//{
                            	$retainfrom_arr['from_date'][$volkey] = covertDate($volvalue['from_date'],'Y-m-d');
                            	$retainfrom_arr['to_date'][$volkey]   = covertDate($volvalue['to_date'],'Y-m-d');
                            //}
                         }
                      }
                     // echo '<pre>rrrrr'; print_r($retainfrom_arr); echo'</pre>'; exit;


                  if(isset($retainfrom_arr['from_date'])&& count($retainfrom_arr['from_date'])>0)
                  {
                  	$cur_datgreatedt = '';
                      foreach($retainfrom_arr['from_date'] as $pkey=>$pvalue)
                      { 
                      	  $from_disabled = array();
	                      $to_disabled   = array();
                      	  if(!empty($pvalue) && !empty($retainfrom_arr['to_date'][$pkey]))
                      	  {
	                      		$from_disabled = array('disabled'=>'disabled');
	                      		$to_disabled	= array('disabled'=>'disabled');
	                      		$from_date =covertDate($pvalue,'d/m/Y','Y-m-d');
	                      		$to_date = covertDate($retainfrom_arr['to_date'][$pkey],'d/m/Y','Y-m-d');
	                      		//$from_date_frmt = $from_date->format("Y-m-d");
	                      		//echo "==>".$from_date_frmt;
	                      		if($from_date>date('Y-m-d') && $to_date>date('Y-m-d'))
	                      		{
	                      			$from_disabled = array();
	                      			$to_disabled   = array();
	                      		}
	                      		else if($to_date>date('Y-m-d'))
	                      		{
	                      			$todaydate = new DateTime('NOW');
	                      			$from_disabled = array();
	                      			$to_disabled   = array();
	                      			$newpvalue = $todaydate->modify('+1 day');
	                      			$pvalue    = $todaydate->format('d/m/Y');
	                      		}
                      	  }
                        ?>
                         <div class="row">
                            <div class="col-md-5 mb-3 mactext">
                               <?php 
                                      echo Form::label('fromdate', 'From Date', array('for' => 'fromdate'));
                                      echo Form::text('from_date['.$pkey.']', $value =$pvalue, $attributes = array('placeholder'=>'Enter From Date','class'=>'form-control datepick','id'=>'from_date')+$from_disabled);
                                 ?>
                                  {!! $errors->first('from_date.'.$pkey, '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="col-md-5 mb-3  mactext">
                                      <?php echo Form::label('todate', 'To Date', array('for' => 'email'));
                                            echo Form::text('to_date['.$pkey.']', $value = $retainfrom_arr['to_date'][$pkey], $attributes = array('placeholder'=>'Enter To Date','class'=>'form-control datepick')+$to_disabled);
                                       ?>
                                       {!! $errors->first('to_date.'.$pkey, '<p class="text-danger">:message</p>') !!}
                            </div>
                            @if($pkey==0)
                                 <a id="append" class=""><img src="{{url('img/plus.png')}}" /></a>
                            @elseif(count($from_disabled)==0)
                                <a id="append" class="datedelete"><img src="../../img/cross.png" /></a>
                            @endif
                          </div> 
               <?php  }

                  }
                  else
                  {
                ?>

                    <div class="row">
                      <div class="col-md-5 mactext">
                         <?php 
                                echo Form::label('fromdate', 'From Date', array('for' => 'fromdate'));
                                echo Form::text('from_date[0]', $value ='', $attributes = array('placeholder'=>'Enter From Date','class'=>'form-control datepick','id'=>'from_date'));
                           ?>
                            {!! $errors->first('from_date.0', '<p class="text-danger">:message</p>') !!}
                      </div>
                      <div class="col-md-5 mactext">
                                <?php echo Form::label('todate', 'To Date', array('for' => 'email'));
                                      echo Form::text('to_date[0]', $value = '', $attributes = array('placeholder'=>'Enter To Date','class'=>'form-control datepick'));
                                 ?>
                                 {!! $errors->first('to_date.0', '<p class="text-danger">:message</p>') !!}
                      </div>
                        <a id="append" class=""><img src="{{url('img/plus.png')}}" /></a>
                    </div>
            <?php } 
            ?>
            </div>
             <div class="row col-md-12" style="text-align: center;">
                       {!! Form::submit('Submit',  array('class'=>'btn btn-primary')+$submit_disable) !!}
                      <a class="btn btn-primary" href="{{url('user/wfhgroupdetails/'.$grp_id)}}"> Back to Date List</a>
              </div> 
         {{ Form::close() }}
         </div> 
      </div>
<!-- Footer -->
  @include('layouts.footer')

  @include('layouts.scriptfooter')
  <script type="text/javascript">
    @if ($errors->first('password')|| empty($user_details->id))
      showpass();
    @endif 
    function showpass(){
      $("#changepassword").show();
      $(".chglink").hide();
    }
    datepickshow();
    function datepickshow()
    {
      $('.datepick').datepicker({
        format: 'dd/mm/yyyy',
        startDate: '+1d'
      });
    }
     $("#append").click( function(e) {
      var ind = parseInt($(".addranges").children().length);

            e.preventDefault();
          $(".addranges").append('<div class="row"><div class="col-md-5"><label for="fromdate">From Date</label><input type="text" value="" name="from_date['+ind+']" class="form-control datepick" placeholder="Enter From Date"></div><div class="col-md-5"><label for="todate">To Date</label><input type="text" value="" name="to_date['+ind+']" class="form-control datepick" placeholder="Enter To Date"></div><a id="append" class="datedelete"><img src="../../img/cross.png" /></a></div>');
          datepickshow();
        /*  $('.netEmp').each(function () {
                    $(this).rules("add", {
                        required: true
                    });
                });*/
          return false;
          });
  jQuery(document).on('click', '.datedelete', function() {
      jQuery(this).parent().remove();
      return false;
      });

   </script>
 @endsection
